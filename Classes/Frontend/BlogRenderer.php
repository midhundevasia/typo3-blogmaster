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
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use Tutorboy\Blogmaster\Utility\BlogUtility;

/**
 * Renderer class for blog views
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class BlogRenderer implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Page title tag
	 * @var string
	 */
	protected $titleTag = '<title itemprop="name">|</title>';

	/**
	 * HTML tag for blog
	 * @var string
	 */
	protected $htmlTag = '<html itemscope="itemscope" itemtype="%s" lang="en-US" prefix="og: http://ogp.me/ns#">';

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
	 * Pagerenderer hook params
	 * @var array
	 */
	private $params = [];

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
			case 'home':
				$this->htmlTag = sprintf($this->htmlTag, 'http://schema.org/WebPage');
				break;
			case 'single':
				$this->htmlTag = sprintf($this->htmlTag, 'http://schema.org/Article');
				break;
			default:
		}
		return $this->htmlTag;
	}

	/**
	 * Render page header
	 * @param  array $params Page params
	 * @return void
	 */
	public function renderPageHeader(array &$params) {
		$this->params = $params;
		// @todo lang="en-US"
		$params['htmlTag'] = $this->getHtmlTag();
		$params['titleTag'] = $this->getTitleTag();
		$params['metaTags'] = $this->getMetaTags($params['metaTags']);
		$params['inlineComments'][] = $this->appendInlineComment();
		$params['title'] = $this->getPageTitle();
		$this->getHeaderData();
		$this->setlocale();
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

		$this->getOpenGraphMetas($this->metaTags);
		return $this->metaTags;
	}

	/**
	 * Add facebook open graph
	 * @return void
	 */
	private function getOpenGraphMetas() {
		if ($this->settingsService->getSettings('enableOpenGraph') == TRUE) {
			if ($this->pageService->getViewType() == 'single') {
				$this->metaTags[] = '<meta property="og:type" content="article"/>';
			} elseif ($this->pageService->getViewType() == 'list') {
				$this->metaTags[] = '<meta property="og:type" content="object"/>';
			} else {
				$this->metaTags[] = '<meta property="og:type" content="website"/>';
			}
			$this->metaTags[] = '<meta property="og:locale" content="' . $this->settingsService->getSettings('locale') . '"/>';
			$this->metaTags[] = '<meta property="og:title" content="' . $this->getPageTitle() . '"/>';
			if (NULL !== ($this->getDescription())) {
				$this->metaTags[] = '<meta property="og:description" content="' . $this->getDescription() . '"/>';
			}
			$this->metaTags[] = '<meta property="og:url" content="' . $this->pageService->getUrl() . '"/>';
			$this->metaTags[] = '<meta property="og:site_name" content="' . $this->settingsService->getSettings('blogTitle') . '"/>';
			$this->metaTags[] = '<meta property="og:image" content="' . $this->pageService->getImage() . '"/>';
			if (isset($this->settingsService->getSettings('facebook')['appId'])) {
				$this->metaTags[] = '<meta property="fb:app_id" content="' . $this->settingsService->getSettings('facebook')['appId'] . '"/>';
				$this->metaTags[] = '<meta property="fb:admins" content="' . $this->settingsService->getSettings('facebook')['admins'] . '"/>';
			}
		}
	}

	/**
	 * Prepare the page title
	 * @return string
	 */
	public function getPageTitle() {
		switch ($this->pageService->getViewType()) {
			case 'home':
				if ($this->settingsService->getSettings('blogTitle')) {
					$title = $this->settingsService->getSettings('blogTitle') . ' ' . $this->settingsService->getSettings('titleSeparator') . ' ' . $this->settingsService->getSettings('blogTagline');
					$this->pageService->setUrl(BlogUtility::getBlogUrl());
				}
				break;
			case 'single':
				if (!empty($this->pageService->getTitle())) {
					$title = $this->pageService->getTitle() . ' ' . $this->settingsService->getSettings('titleSeparator') . ' ' . $this->settingsService->getSettings('blogTitle');
				}
				break;
			case 'list':
				if ($this->pageService->getTitle()) {
					$title = $this->pageService->getTitle() . ' ' . $this->settingsService->getSettings('titleSeparator') . ' ' . $this->settingsService->getSettings('blogTitle');
				}
				$this->pageService->setUrl(BlogUtility::getCurrentUrl());
				break;
			default:
		}

		if (!isset($title)) {
			$title = ($GLOBALS['TSFE']->page['title'] ? $GLOBALS['TSFE']->page['title'] : $GLOBALS['TSFE']->altPageTitle);
		}

		return $title;
	}

	/**
	 * Set additional page headers
	 * @return void
	 */
	public function getHeaderData() {
		$this->addFeedLinks();
	}

	/**
	 * Add feed link to the blog header
	 * @return void
	 */
	private function addFeedLinks() {
		if ($this->settingsService->getSettings('enableFeeds')) {
			$feedTag = '<link rel="alternate" type="application/rss+xml" title="%s" href="%s" />';
			$this->params['headerData'][] = sprintf(
				$feedTag,
				$this->settingsService->getSettings('blogTitle') . ' &raquo; Feed',
				BlogUtility::generateUrl($this->settingsService->getSettings('blogRootPageId')) . 'feed/');
			$this->params['headerData'][] = sprintf(
				$feedTag,
				$this->settingsService->getSettings('blogTitle') . ' &raquo; Comments Feed',
				BlogUtility::generateUrl($this->settingsService->getSettings('blogRootPageId')) . 'comments/feed/');
			if ($this->pageService->getViewType() == 'single') {
				$this->params['headerData'][] = sprintf(
				$feedTag,
				$this->settingsService->getSettings('blogTitle') . ' &raquo; ' . $this->pageService->getTitle() . ' Comments Feed',
				$this->pageService->getUrl() . 'feed/');
			}
		}
	}

	/**
	 * Get page description based on view
	 * @return string
	 */
	public function getDescription() {
		if ($this->pageService->getViewType() == 'single' || $this->pageService->getViewType() == 'list') {
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

	/**
	 * Setlocale
	 * @return void
	 */
	private function setlocale() {
		$locale = $this->settingsService->getSettings('locale') ? $this->settingsService->getSettings('locale') : 'en_US';
		setlocale(LC_TIME, $locale);
	}
}