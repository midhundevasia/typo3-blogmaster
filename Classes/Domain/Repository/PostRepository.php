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
 * Post repository
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class PostRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	protected $defaultOrderings = ['created' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];

	/**
	 * Initialize the repository
	 * @return void
	 */
	public function initializeObject() {
		$this->querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
		$this->querySettings->setRespectStoragePage(FALSE);
		$this->querySettings->setIgnoreEnableFields(FALSE);
		$this->querySettings->setIncludeDeleted(FALSE);
		$this->setDefaultQuerySettings($this->querySettings);
	}

	/**
	 * Find all post by blog
	 * @param  int $blog   Blog ID
	 * @param  int $limit  Query limit
	 * @param  int $offset Query offset
	 * @return array
	 */
	public function findAllByBlog($blog = 0, $limit = 999999, $offset = 0) {
		$query = $this->createQuery();
		$query->setLimit($limit);
		$query->setOffset($offset);
		if (TYPO3_MODE === 'FE') {
			return $query->matching($query->logicalAnd($query->equals('blog', $blog), $query->equals('status', 'publish')))->execute();
		} else {
			return $query->matching($query->equals('blog', $blog))->execute();
		}
	}

	/**
	 * Get all deleted items
	 * @return array
	 */
	public function findByDeleted() {
		$query = $this->createQuery();
		return $query->matching($query->equals('deleted', 1))->execute();
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
			['title', 'slug', 'content', 'excerpt'],
			'tx_blogmaster_domain_model_post',
			'OR'
		);

		if (TYPO3_MODE === 'FE') {
			$published = ' AND status = "publish" ';
		}

		$results = $this->getDatabaseConnection()->exec_SELECTgetRows(
			'uid',
			'tx_blogmaster_domain_model_post',
			'((' . $where . ') AND deleted = 0 ' . $published . ' )'
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
	 * Find by year and month
	 * @param  string $year Year
	 * @param  string $month Month
	 * @return array
	 */
	public function findAllByYearAndMonth($year, $month) {
		$parseKey = explode(',', str_replace(' ', '', $keyword));
		$where = 'YEAR(created) = ' . $year . ' AND MONTH(created) = ' . $month;
		$results = $this->getDatabaseConnection()->exec_SELECTgetRows(
			'uid',
			'tx_blogmaster_domain_model_post',
			'(' . $where . ') AND deleted = 0 '
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
	 * Get post count by month and year
	 * @param  string $year Year
	 * @return string
	 */
	public function findAllPostCountByYearAndMonth($year = NULL) {
		$res = $this->getDatabaseConnection()->sql_query('
			SELECT YEAR(created) AS year, MONTH(created) AS month, COUNT(*) AS TOTAL 
				FROM tx_blogmaster_domain_model_post 
				GROUP BY year, month;
			');
		$archiveList = [];
		while (($row = $this->getDatabaseConnection()->sql_fetch_assoc($res))) {
			$monthName = strftime('%B', mktime(0, 0, 0, $row['month'], 10, $row['year']));
			$row['monthName'] = $monthName;
			$archiveList[$row['year'] . '.' . $row['month']] = $row;
		}

		return $archiveList;
	}

	/**
	 * Find all by category
	 * @param  int $categoryUid Category Uid
	 * @return array
	 */
	public function findAllByCategory($categoryUid) {
		$query = $this->createQuery();
		if (TYPO3_MODE === 'FE') {
			return $query->matching($query->logicalAnd($query->contains('categories', $categoryUid), $query->equals('status', 'publish')))->execute();
		} else {
			return $query->matching($query->contains('categories', $categoryUid))->execute();
		}
	}

	/**
	 * Find all by Tag
	 * @param  int $tagUid Tag Uid
	 * @return array
	 */
	public function findAllByTag($tagUid) {
		$query = $this->createQuery();
		if (TYPO3_MODE === 'FE') {
			return $query->matching($query->logicalAnd($query->contains('tags', $tagUid)))->execute();
		} else {
			return $query->matching($query->contains('tags', $tagUid))->execute();
		}
	}

	/**
	 * Archive list
	 * @param  string $year  Year
	 * @param  string $month Month
	 * @param  string $day   Day
	 * @return array
	 */
	public function findAllByYearMonthDay($year, $month = NULL, $day = NULL) {
		$parseKey = explode(',', str_replace(' ', '', $keyword));
		$where = 1;
		if ($year) {
			$where = ' YEAR(created) = ' . $year;
		}
		if ($month) {
			$where .= ' AND MONTH(created) = ' . $month;
		}
		if ($day) {
			$where .= ' AND DAY(created) = ' . $day;
		}

		if (TYPO3_MODE === 'FE') {
			$published = ' AND status = "publish" ';
		}

		$results = $this->getDatabaseConnection()->exec_SELECTgetRows(
			'uid',
			'tx_blogmaster_domain_model_post',
			'(' . $where . ') AND deleted = 0 ' . $published
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
	 * Find next post
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Post $post Current post
	 * @return array
	 */
	public function findNext(\Tutorboy\Blogmaster\Domain\Model\Post $post) {
		$query = $this->createQuery();
		return $query
				->matching(
					$query->logicalAnd(
						$query->greaterThan('crdate', $post->getCrdate()),
						$query->equals('status', 'publish')
					)
				)
				->execute()
				->getFirst();
	}

	/**
	 * Get previous post object
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Post $post Current Post
	 * @return array
	 */
	public function findPrevious(\Tutorboy\Blogmaster\Domain\Model\Post $post) {
		$query = $this->createQuery();
		return $query
				->matching(
					$query->logicalAnd(
						$query->lessThan('crdate', $post->getCrdate()),
						$query->equals('status', 'publish')
					)
				)
				->execute()
				->getFirst();
	}

	/**
	 * Find all future posts
	 * @return array
	 */
	public function findAllFuturePosts() {
		$query = $this->createQuery();
		$today = new \DateTime();
		return $query
				->matching(
					$query->logicalAnd(
						$query->lessThanOrEqual('crdate', $today->getTimestamp()),
						$query->equals('status', 'future')
					)
				)
				->execute();
	}

	/**
	 * Database connection
	 * @return DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}