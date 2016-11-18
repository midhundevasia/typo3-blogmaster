<?php
namespace Tutorboy\Blogmaster\Domain\Model;

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
 * Category model
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Posts
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tutorboy\Blogmaster\Domain\Model\Post>
	 * @lazy
	 */
	protected $posts;

	/**
	 * Category title
	 * @var string
	 * @validate StringLength(minimum = 3)
	 */
	protected $title = '';

	/**
	 * Category slug
	 * @var string
	 */
	protected $slug = '';

	/**
	 * Category description
	 * @var string
	 */
	protected $description = '';

	/**
	 * Pid
	 * @var int
	 */
	protected $pid = 0;

	/**
	 * Created user id
	 * @var int
	 */
	protected $cruserId = 0;

	/**
	 * Created date
	 * @var int
	 */
	protected $crdate;

	/**
	 * Count
	 * @var int
	 */
	protected $count;

	/**
	 * Count
	 * @var int
	 */
	protected $parent;

	/**
	 * Constructs this post
	 * @return void
	 */
	public function __construct() {
		$this->cruserId = isset($GLOBALS['BE_USER']->user['uid']) ? (int)$GLOBALS['BE_USER']->user['uid'] : 0;
	}

	/**
	 * Setter for title
	 * @param string $title cat title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Setter for description
	 * @param string $content cat description
	 * @return void
	 */
	public function setDescription($content) {
		$this->description = $content;
	}

	/**
	 * Getter for description
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Setter for cruser_id
	 * @param string $userId post content
	 * @return void
	 */
	public function setCruserId($userId) {
		$this->cruserId = $userId;
	}

	/**
	 * Getter for cruser_id
	 * @return int
	 */
	public function getCruserId() {
		return $this->cruserId;
	}

	/**
	 * Getter for the crdate
	 * @return int
	 */
	public function getCrdate() {
		return $this->crdate;
	}

	/**
	 * Getter for count
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * Setter for count
	 * @param int $count Count
	 * @return void
	 */
	public function setCount($count) {
		$this->count = $count;
	}

	/**
	 * Getter for slug
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Setter for slug
	 * @param string $slug Category slug
	 * @return void
	 */
	public function setSlug($slug) {
		if (empty($slug)) {
			$slug = $this->title;
		}
		$this->slug = \Tutorboy\Blogmaster\Utility\BlogUtility::slugify($slug);
	}

	/**
	 * Getter for parent
	 * @return string
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Setter for parent
	 * @param string $parent Category parent
	 * @return void
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}
}