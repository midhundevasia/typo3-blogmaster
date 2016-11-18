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
 * Hook Service
 *
 * @package 	Blogmaster
 * @subpackage 	Hooks
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class HookService  implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Register Hook
	 * @param string $hookName Hookname
	 * @param string $function Class name
	 * @return void
	 */
	public static function addHook($hookName, $function) {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$hookName][] = $function;
	}

	/**
	 * Check if hook exist
	 * @param  string  $hookName Hookname
	 * @return bool
	 */
	public static function hasHook($hookName) {
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$hookName])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get all hooks
	 * @param  string $hookName Hookname
	 * @return array|NULL
	 */
	public static function getAll($hookName) {
		if (self::hasHook($hookName)) {
			return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$hookName];
		} else {
			return NULL;
		}
	}

	/**
	 * Appy hook
	 * @param  string $hookName Hookname
	 * @param  array  $params   Params
	 * @param  object $ref     	Reference object
	 * @return array
	 */
	public static function applyHook($hookName, array $params, $ref) {
		$hooks = self::getAll($hookName);
		if (is_array($hooks)) {
			foreach ($hooks as $funcRef) {
				\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($funcRef, $params, $ref);
			}
			return $params;
		}
	}
}