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
 * Category repository
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

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
	 * Final all categories by blog id
	 * @param  int $blog BlogId
	 * @return array
	 */
	public function findAllByBlog($blog = 0) {
		$query = $this->createQuery();
		return $query->matching($query->equals('blog', $blog))->execute();
	}

	/**
	 * Search
	 * @param  string $keyword Keywords
	 * @return array
	 */
	public function search($keyword = '') {
		$parseKey = explode(',', str_replace(' ', '', $keyword));
		$where = $this->getDatabaseConnection()->searchQuery(
			$parseKey,
			['title', 'slug', 'description'],
			'tx_blogmaster_domain_model_category',
			'OR'
		);

		$results = $this->getDatabaseConnection()->exec_SELECTgetRows(
			'uid',
			'tx_blogmaster_domain_model_category',
			'((' . $where . ') AND deleted = 0 )'
		);

		if (count($results)) {
			$uids = array_column($results, 'uid');
			$query = $this->createQuery();
			$results = $query->matching($query->in('uid', $uids))->execute();
		} else {
			// Generate empty query result array
			$results = $this->createQuery()->matching($this->createQuery()->equals('blog', -1))->execute();
		}

		return $results;
	}

	/**
	 * Database connection
	 * @return DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}