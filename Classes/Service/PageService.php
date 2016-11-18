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
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Page services
 *
 * @package 	Blogmaster
 * @subpackage 	Hooks
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class PageService  implements \TYPO3\CMS\Core\SingletonInterface {

	private $pageRenderer;

	/**
	 * Construct
	 */
	public function __construct() {
		$this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
	}

	/**
	 * Set page title
	 * @param string $content Content
	 * @param string $ref     Ref
	 * @return string
	 */
	public static function setPageTitle($content, $ref) {
		$GLOBALS['TSFE']->altPageTitle = $content;
		$GLOBALS['TSFE']->indexedDocTitle = $content;
		return $content;
	}

	/**
	 * Add page meta
	 * @return void
	 */
	public function addMetaTag() {
		//$GLOBALS['TSFE']->altPageTitle = $content;
		//$GLOBALS['TSFE']->indexedDocTitle = $content;
		// $this->pageRenderer->addMetaTag('<title>asdd</title>');
		// $this->pageRenderer->addHeaderData('
		// 	<title>From service</title>
		// 	');
	}
}
