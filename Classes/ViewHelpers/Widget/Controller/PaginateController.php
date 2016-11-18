<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Widget\Controller;

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

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * Class PaginateController
 *
 * @package     Blogmaster
 * @subpackage  ViewHelpers
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class PaginateController extends AbstractWidgetController {

	/**
	 * Configuration
	 * @var array
	 */
	protected $configuration = [
		'itemsPerPage' => 10,
		'insertAbove' => FALSE,
		'insertBelow' => TRUE,
		'maximumNumberOfLinks' => 99,
		'addQueryStringMethod' => '',
		'section' => ''
	];

	/**
	 * Object
	 * @var QueryResultInterface|ObjectStorage|array
	 */
	protected $objects;

	/**
	 * Current Page
	 * @var int
	 */
	protected $currentPage = 1;

	/**
	 * Max number of links
	 * @var int
	 */
	protected $maximumNumberOfLinks = 99;

	/**
	 * Number of pages
	 * @var int
	 */
	protected $numberOfPages = 1;

	/**
	 * Display range start
	 * @var int
	 */
	protected $displayRangeStart = NULL;

	/**
	 * Display range end
	 * @var int
	 */
	protected $displayRangeEnd = NULL;

	/**
	 * Init
	 * @return void
	 */
	public function initializeAction() {
		$this->objects = $this->widgetConfiguration['objects'];
		ArrayUtility::mergeRecursiveWithOverrule($this->configuration, $this->widgetConfiguration['configuration'], FALSE);
		$itemsPerPage = (int)$this->configuration['itemsPerPage'];
		$this->numberOfPages = $itemsPerPage > 0 ? ceil(count($this->objects) / $itemsPerPage) : 0;
		$this->maximumNumberOfLinks = (int)$this->configuration['maximumNumberOfLinks'];
	}

	/**
	 * Index action
	 * @param int $currentPage Current page number
	 * @return void
	 */
	public function indexAction($currentPage = 1) {
		// set current page
		$this->currentPage = (int)$currentPage;
		if ($this->currentPage < 1) {
			$this->currentPage = 1;
		}
		if ($this->currentPage > $this->numberOfPages) {
			// set $modifiedObjects to NULL if the page does not exist
			$modifiedObjects = NULL;
		} else {
			// modify query
			$itemsPerPage = (int)$this->configuration['itemsPerPage'];
			$offset = 0;
			if ($this->currentPage > 1) {
				$offset = ((int)($itemsPerPage * ($this->currentPage - 1)));
			}
			$modifiedObjects = $this->prepareObjectsSlice($itemsPerPage, $offset);
		}
		$this->view->assign('contentArguments', [
			$this->widgetConfiguration['as'] => $modifiedObjects
		]);
		$this->view->assign('configuration', $this->configuration);
		$this->view->assign('pagination', $this->buildPagination());
	}

	/**
	 * If a certain number of links should be displayed, adjust before and after
	 * amounts accordingly.
	 *
	 * @return void
	 */
	protected function calculateDisplayRange() {
		$maximumNumberOfLinks = $this->maximumNumberOfLinks;
		if ($maximumNumberOfLinks > $this->numberOfPages) {
			$maximumNumberOfLinks = $this->numberOfPages;
		}
		$delta = floor($maximumNumberOfLinks / 2);
		$this->displayRangeStart = $this->currentPage - $delta;
		$this->displayRangeEnd = $this->currentPage + $delta - ($maximumNumberOfLinks % 2 === 0 ? 1 : 0);
		if ($this->displayRangeStart < 1) {
			$this->displayRangeEnd -= $this->displayRangeStart - 1;
		}
		if ($this->displayRangeEnd > $this->numberOfPages) {
			$this->displayRangeStart -= $this->displayRangeEnd - $this->numberOfPages;
		}
		$this->displayRangeStart = (int)max($this->displayRangeStart, 1);
		$this->displayRangeEnd = (int)min($this->displayRangeEnd, $this->numberOfPages);
	}

	/**
	 * Returns an array with the keys "pages", "current", "numberOfPages",
	 * "nextPage" & "previousPage"
	 *
	 * @return array
	 */
	protected function buildPagination() {
		$this->calculateDisplayRange();
		$pages = [];
		for ($i = $this->displayRangeStart; $i <= $this->displayRangeEnd; $i++) {
			$pages[] = ['number' => $i, 'isCurrent' => $i === $this->currentPage];
		}
		$pagination = [
			'pages' => $pages,
			'current' => $this->currentPage,
			'numberOfPages' => $this->numberOfPages,
			'displayRangeStart' => $this->displayRangeStart,
			'displayRangeEnd' => $this->displayRangeEnd,
			'hasLessPages' => $this->displayRangeStart > 2,
			'hasMorePages' => $this->displayRangeEnd + 1 < $this->numberOfPages
		];
		if ($this->currentPage < $this->numberOfPages) {
			$pagination['nextPage'] = $this->currentPage + 1;
		}
		if ($this->currentPage > 1) {
			$pagination['previousPage'] = $this->currentPage - 1;
		}
		return $pagination;
	}

	/**
	 * Prepare Objects Slice
	 * @param int $itemsPerPage Item per page
	 * @param int $offset Offset
	 * @return array|QueryResultInterface
	 * @throws \InvalidArgumentException
	 */
	protected function prepareObjectsSlice($itemsPerPage, $offset) {
		if ($this->objects instanceof QueryResultInterface) {
			$query = $this->objects->getQuery();
			$query->setLimit($itemsPerPage);
			if ($offset > 0) {
				$query->setOffset($offset);
			}
			$modifiedObjects = $query->execute();
			return $modifiedObjects;
		} elseif ($this->objects instanceof ObjectStorage) {
			$modifiedObjects = [];
			$endOfRange = $offset + $itemsPerPage;
			for ($i = $offset; $i < $endOfRange; $i++) {
				$modifiedObjects[] = $this->objects->toArray()[$i];
			}
			return $modifiedObjects;
		} elseif (is_array($this->objects)) {
			$modifiedObjects = array_slice($this->objects, $offset, $itemsPerPage);
			return $modifiedObjects;
		} else {
			throw new \InvalidArgumentException('The view helper "' . get_class($this) .
				'" accepts as argument "QueryResultInterface", "\SplObjectStorage", "ObjectStorage" or an array. ' .
				'given: ' . get_class($this->objects), 1385547291
			);
		}
	}
}
