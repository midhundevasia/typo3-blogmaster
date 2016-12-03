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
 * Post model
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class Post extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Categories
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tutorboy\Blogmaster\Domain\Model\Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * Tags
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tutorboy\Blogmaster\Domain\Model\Tag>
	 * @lazy
	 */
	protected $tags;

	/**
	 * Post title
	 * @var string
	 * @validate StringLength(minimum = 3)
	 */
	protected $title = '';

	/**
	 * Post content
	 * @var string
	 */
	protected $content = '';

	/**
	 * Post excerpt
	 * @var string
	 */
	protected $excerpt = '';

	/**
	 * Post slug
	 * @var string
	 */
	protected $slug = '';

	/**
	 * Comment status
	 * @var string
	 */
	protected $commentStatus = 'open';

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
	 * Comment count
	 * @var int
	 */
	protected $commentCount;

	/**
	 * Status
	 * @var string
	 */
	protected $status;

	/**
	 * Created date
	 * @var string
	 */
	protected $created;

	/**
	 * Created date
	 * @var string
	 */
	protected $createdGmt;

	/**
	 * Modified date
	 * @var string
	 */
	protected $modified;

	/**
	 * Modified date
	 * @var string
	 */
	protected $modifiedGmt;

	/**
	 * Visibility
	 * @var int
	 */
	protected $hidden = 0;

	/**
	 * Deleted
	 * @var int
	 */
	protected $deleted = 0;

	/**
	 * Feature image
	 * @var int
	 */
	protected $image;

	/**
	 * Constructs this post
	 * @return void
	 */
	public function __construct() {
		$this->created = Date('Y-m-d H:i:s');
		$date = new \DateTime($this->create);
		$date->setTimezone(new \DateTimeZone('GMT'));
		$this->createdGmt = $date->format('Y-m-d H:i:s');
		$this->modified = $this->created;
		$this->modifiedGmt = $this->createdGmt;
	}

	/**
	 * Setter for title
	 * @param string $title post title
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
		return $this->title = \Tutorboy\Blogmaster\DataHandler\DataHandler::process('post_title', $this->title, $this);
	}

	/**
	 * Setter for content
	 * @param string $content post content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 * @return string
	 */
	public function getContent() {
		return $this->content = \Tutorboy\Blogmaster\DataHandler\DataHandler::process('post_content', $this->content, $this);
	}

	/**
	 * Get excerpt value
	 * @return string
	 */
	public function getExcerpt() {
		return $this->excerpt = \Tutorboy\Blogmaster\DataHandler\DataHandler::process('post_excerpt', $this->excerpt, $this);
	}

	/**
	 * Set excerpt
	 * @param string $value Excerpt
	 * @return void
	 */
	public function setExcerpt($value) {
		$this->excerpt = $value;
	}

	/**
	 * Get slug
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Post slug
	 * @param string $value Post slug
	 * @return void
	 */
	public function setSlug($value) {
		if (empty($value)) {
			$value = $this->title;
		}
		$this->slug = \Tutorboy\Blogmaster\Utility\BlogUtility::slugify($value);
	}

	/**
	 * Get comment status
	 * @return string
	 */
	public function getCommentStatus() {
		return $this->commentStatus;
	}

	/**
	 * Set comment status
	 * @param string $value Comment flag
	 * @return void
	 */
	public function setCommentStatus($value) {
		if (empty($value)) {
			$value = 'closed';
		}
		$this->commentStatus = $value;
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
	 * Set created date as timestamp
	 * @param string $date Date
	 * @return void
	 */
	public function setCrdate($date) {
		$this->crdate = $date;
	}

	/**
	 * Getter for comment count
	 * @return object
	 */
	public function getCommentCount() {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
		$commentRepo = $objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\CommentRepository::class);
		$count = $commentRepo->countAllByPost($this->getUid());
		return $count;
	}

	/**
	 * Setter for comment_count
	 * @param int $count Comment count
	 * @return void
	 */
	public function setCommentCount($count) {
		$this->commentCount = $count;
	}

	/**
	 * Setter for post status
	 * @param string $status Post status 'publish, draft, pending' etc.
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Getter for post status
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Get created date
	 * @return string
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * Set created date
	 * @param string $date Date
	 * @return void
	 */
	public function setCreated($date) {
		$this->created = $date;
	}

	/**
	 * Get created date GMT
	 * @return string
	 */
	public function getCreatedGmt() {
		return $this->createdGmt;
	}

	/**
	 * Set create date in GMT
	 * @param string $date Date
	 * @return void
	 */
	public function setCreatedGmt($date) {
		$this->createdGmt = $date;
	}

	/**
	 * Get modified date
	 * @return string
	 */
	public function getModified() {
		return $this->modified;
	}

	/**
	 * Set modified date
	 * @param string $date Data
	 * @return void
	 */
	public function setModified($date) {
		$this->modified = Date('Y-m-d H:i:s');
		$date = new \DateTime($this->modified);
		$date->setTimezone(new \DateTimeZone('GMT'));
		$this->modifiedGmt = $date->format('Y-m-d H:i:s');
	}

	/**
	 * Get modified date  GMT
	 * @return string
	 */
	public function getModifiedGmt() {
		return $this->modifiedGmt;
	}

	/**
	 * Set modified date in GMT
	 * @param string $date Date
	 * @return void
	 */
	public function setModifiedGmt($date) {
		$this->modifiedGmt = $date;
	}

	/**
	 * Setter for deleted
	 * @param string $deleted Deleted
	 * @return void
	 */
	public function setDeleted($deleted) {
		$this->deleted = $deleted;
	}

	/**
	 * Getter for deleted
	 * @return int
	 */
	public function getDeleted() {
		return $this->deleted;
	}

	/**
	 * Add a category
	 * @param \Tutorboy\Blogmaster\Domain\Model\Category $category Category
	 * @return void
	 */
	public function addCategory(\Tutorboy\Blogmaster\Domain\Model\Category $category) {
		$this->categories->attach($category);
	}

	/**
	 * Remove a category
	 * @param \Tutorboy\Blogmaster\Domain\Model\Category $category Category
	 * @return void
	 */
	public function removeCategory(\Tutorboy\Blogmaster\Domain\Model\Category $category) {
		$this->categories->detach($category);
	}

	/**
	 * Returns categories
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tutorboy\Blogmaster\Domain\Model\Category> $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Set the categories
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories Categories
	 * @return void
	 */
	public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Add a tag
	 * @param \Tutorboy\Blogmaster\Domain\Model\Tag $tag Tag
	 * @return void
	 */
	public function addTag(\Tutorboy\Blogmaster\Domain\Model\Tag $tag) {
		$this->tags->attach($tag);
	}

	/**
	 * Remove a tag
	 * @param \Tutorboy\Blogmaster\Domain\Model\Tag $tag Tag
	 * @return void
	 */
	public function removeTag(\Tutorboy\Blogmaster\Domain\Model\Tag $tag) {
		$this->tags->detach($tag);
	}

	/**
	 * Returns tags
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tutorboy\Blogmaster\Domain\Model\Tag> $tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Set the tags
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags Tags
	 * @return void
	 */
	public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags) {
		$this->tags = $tags;
	}

	/**
	 * Add Image to the post
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image Image
	 * @return void
	 */
	public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->image->attach($image);
	}

	/**
	 * Remove image from post
	 * @param  \TYPO3\CMS\Extbase\Domain\Model\FileReference $image Image
	 * @return void
	 */
	public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->image->detach($image);
	}

	/**
	 * Set featured image
	 * @param int $image Image object
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Get featured image
	 * @return int
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Get featured image
	 * @return array
	 */
	public function getFeatureImage() {
		if ($this->image > 0) {
			$resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
			$file = $resourceFactory->getFileObject($this->image);
			return $file;
		}
	}

	/**
	 * Check if the post is a scheduled item
	 * @return bool
	 */
	public function getIsFuture() {
		$today = new \DateTime();
		$postDate = new \DateTime($this->getCreated());
		if ($today->getTimestamp() < $postDate->getTimestamp()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get author object
	 * @return \Tutorboy\Blogmaster\Domain\Model\User
	 */
	public function getAuthor() {
		$user = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Domain\Model\User::class, $this->cruserId);
		return $user;
	}
}