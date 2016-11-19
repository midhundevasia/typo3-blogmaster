<?php
namespace Tutorboy\Blogmaster\Frontend;

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

use Tutorboy\Blogmaster\Service\HookService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Renderer class for blog views
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class BlogRenderer {

	/**
	 * Page title tag
	 * @var string
	 */
	protected $titleTag = '<title itemprop="name">|</title>';

	/**
	 * HTML tag for blog
	 * @var string
	 */
	protected $htmlTag = '';

	/**
	 * Page service
	 * @var \Tutorboy\Blogmaster\Service\PageService
	 */
	private $pageService;

	/**
	 * Settings service
	 * @var \Tutorboy\Blogmaster\Service\SettingsService
	 */
	private $settingsService;

	/**
	 * Construct
	 */
	public function __construct() {
		$this->pageService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\PageService::class);
		$this->settingsService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class);
	}

	/**
	 * Get Title tag
	 * @return string
	 */
	public function getTitleTag() {
		return $this->titleTag;
	}

	/**
	 * Get HTML tags
	 * @return string
	 */
	public function getHtmlTag() {
		// @todo lang="en-US"
		switch ($this->pageService->getViewType()) {
			case 'list':
				$this->htmlTag = '<html itemscope="itemscope" itemtype="http://schema.org/WebPage" lang="en-US" prefix="og: http://ogp.me/ns#">';
				break;
			case 'single':
				$this->htmlTag = '<html itemscope="itemscope" itemtype="http://schema.org/Article" lang="en-US" prefix="og: http://ogp.me/ns#">';
				break;
			default:
		}
		return $this->htmlTag;
	}

	/**
	 * Generate page meta tags
	 * @param  array $params Page params
	 * @return void
	 */
	public function generateMetaTags(array &$params) {
		// @todo lang="en-US"
		$params['htmlTag'] = $this->getHtmlTag();
		$params['titleTag'] = $this->getTitleTag();
		$params['metaTags'] = $this->getMetaTags($params['metaTags']);
		$params['inlineComments'][] = $this->appendInlineComment();
		$params['title'] = $this->pageService->getTitle();
	}

	/**
	 * Get meta tags
	 * @param  array $metaTags Current meta tags
	 * @return array
	 */
	public function getMetaTags(array $metaTags) {
		$this->metaTags = $metaTags;

		if ($this->getDescription()) {
			$this->metaTags[] = '<meta name="description" content="' . $this->getDescription() . '">';
		}

		if ($this->getKeywords()) {
			$this->metaTags[] = '<meta name="keywords" content="' . $this->getKeywords() . '">';
		}

		if ($this->pageService->getAuthor()) {
			$this->metaTags[] = '<meta name="author" content="' . $this->pageService->getAuthor() . '">';
		}

		return $this->metaTags;
	}

	/**
	 * Get page description based on view
	 * @return string
	 */
	public function getDescription() {

		if ($this->pageService->getViewType() == 'single') {
			return $this->pageService->getDescription();
		} elseif ($this->pageService->getViewType() == 'home') {
			$settings = $this->settingsService->getSettings();
			if (isset($settings['meta']['description'])) {
				return $settings['meta']['description'];
			}
		}
	}

	/**
	 * Get page keywords
	 * @return string
	 */
	public function getKeywords() {
		if ($this->pageService->getViewType() == 'single') {
			return $this->pageService->getKeywords();
		} elseif ($this->pageService->getViewType() == 'home') {
			$settings = $this->settingsService->getSettings();
			if (isset($settings['meta']['keywords'])) {
				return $settings['meta']['keywords'];
			}
		}
	}

	/**
	 * Add credit info in the inline comment
	 * @return string
	 */
	public function appendInlineComment() {
		return '	Powered By EXT:Blogmaster' . LF;
	}
}