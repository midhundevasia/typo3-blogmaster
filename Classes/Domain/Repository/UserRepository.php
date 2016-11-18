<?php
namespace Tutorboy\Blogmaster\Domain\Repository;

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
 * User repository
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class UserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	protected $defaultOrderings = ['crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];

	/**
	 * Initialize the repository
	 * @return void
	 */
	public function initializeObject() {
		$this->querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
		$this->querySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($this->querySettings);
	}

	/**
	 * Find by username
	 * @param  string $username Username
	 * @return array
	 */
	public function findOneByUsername($username) {
		$query = $this->createQuery();
		return $query->matching($query->equals('username', $username))->execute()->getFirst();
	}

	/**
	 * Database connection
	 * @return DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}