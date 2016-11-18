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
 * User model
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class User extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * First name
	 * @var string
	 */
	protected $firstname = '';

	/**
	 * Last name
	 * @var string
	 */
	protected $lastname = '';

	/**
	 * Email
	 * @var string
	 */
	protected $email = '';

	/**
	 * Username
	 * @var string
	 */
	protected $username = NULL;


	/**
	 * Constructs a new user
	 * @param int $userId User Id
	 * @return void
	 */
	public function __construct($userId = 0) {
		$userData = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', 'fe_users', 'uid=' . $userId);
		$this->setFirstname($userData['realName']);
		$this->setLastname($userData['lastName']);
		$this->setUsername($userData['username']);
		$this->setEmail($userData['email']);
	}

	/**
	 * Sets this persons's firstname
	 * @param string $firstname The person's firstname
	 * @return void
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	/**
	 * Returns the person's firstname
	 * @return string The persons's firstname
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 * Sets this persons's lastname
	 * @param string $lastname The person's lastname
	 * @return void
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	/**
	 * Returns the person's lastname
	 * @return string The persons's lastname
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * Returns the person's full name
	 * @return string The persons's lastname
	 */
	public function getFullName() {
		return $this->firstname . ' ' . $this->lastname;
	}

	/**
	 * Sets this persons's email adress
	 * @param string $email The person's email adress
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the person's email address
	 * @return string The persons's email address
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Getter for username
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * Setter for username
	 * @param string $username Username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}
}