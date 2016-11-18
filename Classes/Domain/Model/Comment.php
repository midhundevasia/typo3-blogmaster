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
 * Comment model
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class Comment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Comment content
	 * @var string
	 */
	protected $content = '';

	/**
	 * Comment author
	 * @var string
	 */
	protected $authorName = '';

	/**
	 * Author email
	 * @var string
	 */
	protected $authorEmail = '';

	/**
	 * Author url
	 * @var string
	 */
	protected $authorUrl = '';

	/**
	 * Author IP
	 * @var string
	 */
	protected $authorIp = '';

	/**
	 * Author browser user agent
	 * @var string
	 */
	protected $agent = '';

	/**
	 * Status
	 * @var string
	 */
	protected $status = '';

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
	 * Created date
	 * @var string
	 */
	protected $post;

	/**
	 * Created date
	 * @var string
	 */
	protected $type;

	/**
	 * Constructs this post
	 * @return void
	 */
	public function __construct() {
		$this->cruserId = isset($GLOBALS['BE_USER']->user['uid']) ? (int)$GLOBALS['BE_USER']->user['uid'] : 0;
		$this->created = Date('Y-m-d H:i:s');
		$date = new \DateTime($this->create);
		$date->setTimezone(new \DateTimeZone('GMT'));
		$this->createdGmt = $date->format('Y-m-d H:i:s');
	}

	/**
	 * Setter for content
	 * @param string $content Content
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
		return $this->content;
	}

	/**
	 * Setter for type
	 * @param string $type Type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Getter for type
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Setter for author name
	 * @param string $name cat Author name
	 * @return void
	 */
	public function setAuthorName($name) {
		$this->authorName = $name;
	}

	/**
	 * Getter for author name
	 * @return string
	 */
	public function getAuthorName() {
		return $this->authorName;
	}

	/**
	 * Setter for author email
	 * @param string $mail Author email
	 * @return void
	 */
	public function setAuthorEmail($mail) {
		$this->authorEmail = $mail;
	}

	/**
	 * Getter for author email
	 * @return string
	 */
	public function getAuthorEmail() {
		return $this->authorEmail;
	}

	/**
	 * Setter for author url
	 * @param string $url Author url
	 * @return void
	 */
	public function setAuthorUrl($url) {
		$this->authorUrl = $url;
	}

	/**
	 * Getter for author url
	 * @return string
	 */
	public function getAuthorUrl() {
		return $this->authorUrl;
	}

	/**
	 * Setter for author ip
	 * @param string $ip Author ip
	 * @return void
	 */
	public function setAuthorIp($ip) {
		$this->authorIp = $ip;
	}

	/**
	 * Getter for author ip
	 * @return string
	 */
	public function getAuthorIp() {
		return $this->authorIp;
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
	 * Getter for agent
	 * @return string
	 */
	public function getAgent() {
		return $this->agent;
	}

	/**
	 * Setter for agent
	 * @param string $agent Comment bowser agent
	 * @return void
	 */
	public function setAgent($agent) {
		$this->agent = $agent;
	}

	/**
	 * Getter for status
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Setter for status
	 * @param string $status Status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
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
	 * Get create date in GMT
	 * @return string
	 */
	public function getCreatedGmt() {
		return $this->createdGmt;
	}

	/**
	 * Set created date in GMT
	 * @param string $date Date
	 * @return void
	 */
	public function setCreatedGmt($date) {
		$this->createdGmt = $date;
	}

	/**
	 * Get post id
	 * @return int
	 */
	public function getPost() {
		return $this->post;
	}

	/**
	 * Set post id
	 * @param int $post Post id
	 * @return void
	 */
	public function setPost($post) {
		$this->post = $post;
	}
}