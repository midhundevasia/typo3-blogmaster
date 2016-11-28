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
 * Page services class for set all the page content tags values like title, meta, etc.
 *
 * @package 	Blogmaster
 * @subpackage 	Service
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class PageService  implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Is blog extension
	 * @var bool
	 */
	public $isBlog = FALSE;

	/**
	 * Page title
	 * @var string
	 */
	private $title = '';

	/**
	 * Page description
	 * @var string
	 */
	private $description = '';

	/**
	 * Page author
	 * @var string
	 */
	private $author = '';

	/**
	 * Keywords
	 * @var string
	 */
	private $keywords = '';

	/**
	 * View type eg: single, list, home, archive, etc.
	 * @var string
	 */
	private $viewType = 'home';

	/**
	 * Url
	 * @var string
	 */
	private $url = '';

	/**
	 * Image
	 * @var string
	 */
	private $image = '';

	/**
	 * Setter for page title
	 * @param string $title Page title
	 * @return void
	 */
	public function setTitle($title = '') {
		$this->title = $title;
	}

	/**
	 * Getter for page title
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Getter for view type
	 * @return string
	 */
	public function getViewType() {
		return $this->viewType;
	}

	/**
	 * Setter for page view type
	 * @param string $viewType View type
	 * @return void
	 */
	public function setViewType($viewType = 'list') {
		$this->viewType = $viewType;
	}

	/**
	 * Setter for description
	 * @param string $description Description
	 * @return void
	 */
	public function setDescription($description = '') {
		$this->description = substr(\Tutorboy\Blogmaster\Utility\StringUtility::convertToPlainString($description), 0, 154);
	}

	/**
	 * Getter for Description
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Setter for keyword
	 * @param array $keywords Array of Keyword
	 * @return void
	 */
	public function setKeywords(array $keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Getter for keyword
	 * @return string
	 */
	public function getKeywords() {
		if (is_array($this->keywords)) {
			return implode(',', $this->keywords);
		}
	}

	/**
	 * Setter for author
	 * @param string $authorName Author name
	 * @return void
	 */
	public function setAuthor($authorName) {
		$this->author = $authorName;
	}

	/**
	 * Get author information
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Get url
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Set url
	 * @param string $url Url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Get image
	 * @return string
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Set image
	 * @param string $image Image path
	 * @return void
	 */
	public function setImage($image) {
		if ($image > 0) {
			$resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
			$file = $resourceFactory->getFileObject($image);
			$this->image = $file->getIdentifier();
		}
	}
}