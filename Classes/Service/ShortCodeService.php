<?php
namespace Tutorboy\Blogmaster\Service;

/*
 * This file is part of the Blogmaster project.
 * Copyright (C) 2016  Midhun Devasia <hello@midhundevasia.com>
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * Blogmaster - A blog system for TYPO3!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ShortCode Service
 *
 * @package 	Blogmaster
 * @subpackage 	Hooks
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class ShortCodeService  implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Register new short code
	 * @param string $hookName Hook Name
	 * @param string $function Class name
	 * @return void
	 */
	public static function addShortCode($hookName, $function) {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Blogmaster/ShortCode'][$hookName] = $function;
	}

	/**
	 * Check if any short code exist
	 * @param  string  $hookName Shortcode hookname
	 * @return bool
	 */
	public static function hasShortCode($hookName) {
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Blogmaster/ShortCode'][$hookName])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get all registered shortcodes
	 * @return array
	 */
	public static function getAll() {
		return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Blogmaster/ShortCode'];
	}

	/**
	 * Apply shortcode
	 * @param  string $content Content which need to apply shortcode
	 * @param  object $ref    Parent object or called instance object
	 * @return string
	 */
	public static function applyShortCode($content, $ref) {
		if (FALSE === strpos($content, '[')) {
			return $content;
		}

		$hooks = self::getAll(
			);
		if (empty($hooks)) {
			return $content;
		}

		preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
		$tagNames = array_intersect(array_keys($hooks), $matches[1]);

		if (empty($tagNames)) {
			return $content;
		}

		$pattern = self::getShortCodePatterns($tagNames);
		if (is_array($hooks)) {
			foreach ($hooks as $key => $funcRef) {
				if (in_array($key, $tagNames)) {
					preg_match_all('/' . $pattern . '/', $content, $matches);
					$attr = self::getAttributeAndValues($matches);
					$shortcodeContent = \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($funcRef, $attr, $ref);
					$content = preg_replace('/' . $pattern . '/', $shortcodeContent, $content);
					return $content;
				}
			}
		}
	}

	/**
	 * Get shortcode attributes and its values
	 * @param  array $match Matched shortcodes
	 * @return array
	 */
	private static function getAttributeAndValues(array $match) {
		// Allow [[foo]] syntax for escaping a tag
		if ($match[1] == '[' && $match[6] == ']') {
			return substr($match[0], 1, -1);
		}
		$tagName = $match[2];
		return self::getShortCodeAttributes($match[3]);
	}

	/**
	 * Get all short code attributes
	 * @param  string $attrStr Attribute string part of a short code
	 * @return array
	 */
	private static function getShortCodeAttributes($attrStr) {
		$atts = array();
		$pattern = '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
		$attrStr = preg_replace("/[\x{00a0}\x{200b}]+/u", ' ', $attrStr);
		if (preg_match_all($pattern, $attrStr[0], $match, PREG_SET_ORDER)) {
			foreach ($match as $m) {
				if (!empty($m[1])) {
					$atts[strtolower($m[1])] = stripcslashes($m[2]);
				} elseif (!empty($m[3])) {
					$atts[strtolower($m[3])] = stripcslashes($m[4]);
				} elseif (!empty($m[5])) {
					$atts[strtolower($m[5])] = stripcslashes($m[6]);
				} elseif (isset($m[7]) && strlen($m[7])) {
					$atts[] = stripcslashes($m[7]);
				} elseif (isset($m[8])) {
					$atts[] = stripcslashes($m[8]);
				}
			}

			// Reject any unclosed HTML elements
			foreach ($atts as &$value) {
				if (FALSE !== strpos($value, '<')) {
					if (1 !== preg_match( '/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value)) {
						$value = '';
					}
				}
			}
		} else {
			$atts = ltrim($attrStr);
		}
		return $atts;
	}

	/**
	 * Parse shortcode content
	 * @param  string $tagNames Name of the shortcode
	 * @return string
	 */
	private static function getShortCodePatterns($tagNames = NULL) {
		$tagregexp = join( '|', array_map('preg_quote', $tagNames) );
		return
			'\\[' .									/* Opening bracket */
			'(\\[?)' .								/* 1: Optional second opening bracket for escaping shortcodes: [[tag]] */
			'(' . $tagregexp . ')' .						/* 2: Shortcode name */
			'(?![\\w-])' .							/* Not followed by word character or hyphen */
			'(' .									/* 3: Unroll the loop: Inside the opening shortcode tag */
			'[^\\]\\/]*' .							/* Not a closing bracket or forward slash */
				'(?:' .
					'\\/(?!\\])' .					/* A forward slash not followed by a closing bracket */
					'[^\\]\\/]*' .					/* Not a closing bracket or forward slash */
				')*?' .
			')' .
			'(?:' .
				'(\\/)' .							/* 4: Self closing tag ... */
				'\\]' .								/* ... and closing bracket */
			'|' .
				'\\]' .								/* Closing bracket */
				'(?:' .
					'(' .							/* 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags */
						'[^\\[]*+' .				/* Not an opening bracket */
						'(?:' .
							'\\[(?!\\/\\2\\])' .	/* An opening bracket not followed by the closing shortcode tag */
							'[^\\[]*+' .			/* Not an opening bracket */
						')*+' .
					')' .
					'\\[\\/\\2\\]'	.				/* Closing shortcode tag */
				')?' .
			')' .
			'(\\]?)';								/* 6: Optional second closing brocket for escaping shortcodes: [[tag]] */
	}
}