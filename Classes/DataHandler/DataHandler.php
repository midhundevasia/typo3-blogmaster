<?php
namespace Tutorboy\Blogmaster\DataHandler;

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
 * Data handler controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class DataHandler  implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Function to manipulate the given content with its registered hooks
	 * @param  string $type    Type/name of data like title, description, slug etc
	 * @param  string $content Content value
	 * @param  object $ref     Parent object
	 * @return string
	 */
	public static function process($type, $content, $ref) {
		if (TYPO3_MODE === 'BE') {
			return $content;
		}
		$registeredFields = ['post_title', 'post_slug', 'post_content', 'category_content', 'tag_content'];
		$content = \Tutorboy\Blogmaster\Service\FilterService::applyFilter($type, $content, $ref);
		if (in_array($type, $registeredFields)) {
			$content = \Tutorboy\Blogmaster\Service\ShortCodeService::applyShortCode($content, $ref);
		}
		return $content;
	}
}
