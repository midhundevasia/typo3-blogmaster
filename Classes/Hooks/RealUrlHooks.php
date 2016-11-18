<?php
namespace Tutorboy\Blogmaster\Hooks;

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

/**
 * RealUrl Hooks
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class RealUrlHooks {

	/**
	 * Realurl hooks for encode url
	 * @param  array $params Params
	 * @param  object $ref  Ref
	 * @return void
	 */
	public static function encodeSpUrlPostProc(array &$params, &$ref) {
		//$params['URL'] = str_replace('post/', '/', $params['URL']);
	}

	/**
	 * Realurl hooks for decode url
	 * @param  array $params Params
	 * @param  object $ref  Ref
	 * @return void
	 */
	public static function decodeSpUrlPreProc(array &$params, &$ref) {
		//$params['URL'] = 'post/' . $params['URL'];
	}
}