<?php
namespace Tutorboy\Blogmaster\Utility;

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
use TYPO3\CMS\Core\Messaging\FlashMessage;

/**
 * General utility
 *
 * @package 	Blogmaster
 * @subpackage 	Utility
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class BlogUtility extends AbstractUtility {

	/**
	 * Slugify a string
	 * @param  string $string String to slugify
	 * @return string
	 */
	public static function slugify($string) {
		if (!empty($string)) {
			//@todo include better funcion to make slug
			// replace non letter or digits by -
			$string = preg_replace('~[^\pL\d]+~u', '-', $string);
			// transliterate
			$string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
			// remove unwanted characters
			$string = preg_replace('~[^-\w]+~', '', $string);
			$string = trim($string, '-');
			// remove duplicate -
			$string = preg_replace('~-+~', '-', $string);
			// lowercase
			$string = strtolower($string);
			if (empty($string)) {
				return '';
			}
		}

		return $string;
	}
}