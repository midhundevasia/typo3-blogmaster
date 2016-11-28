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

/**
 * String utility
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class StringUtility extends AbstractUtility {

	/**
	 * Convert a string into plain string
	 * @param  string $string String to convert
	 * @return string
	 */
	public static function convertToPlainString($string) {
		$string = strip_tags($string);
		$string = trim(str_replace(PHP_EOL, '', $string));
		$string = trim(preg_replace('~[\r\n\t]+~', '', $string));
		return $string;
	}
}