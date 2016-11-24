<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Widget;

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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * Pagination Viewhelper
 *
 * @package     Blogmaster
 * @subpackage  ViewHelpers
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class PaginateViewHelper extends AbstractWidgetViewHelper {

	/**
	 * Controller
	 * @var \Tutorboy\Blogmaster\ViewHelpers\Widget\Controller\PaginateController
	 */
	protected $controller;

	/**
	 * Inject controller instace
	 * @param \Tutorboy\Blogmaster\ViewHelpers\Widget\Controller\PaginateController $controller Controller instance
	 * @return void
	 */
	public function injectPaginateController(\Tutorboy\Blogmaster\ViewHelpers\Widget\Controller\PaginateController $controller) {
		$this->controller = $controller;
	}

	/**
	 * Initialize arguments.
	 *
	 * @api
	 * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('objects', 'mixed', 'Object', TRUE);
		$this->registerArgument('as', 'string', 'as', TRUE);
		$this->registerArgument('configuration', 'array', 'configuration', FALSE, ['itemsPerPage' => 10, 'insertAbove' => FALSE, 'insertBelow' => TRUE, 'maximumNumberOfLinks' => 99]);
	}

	/**
	 * Render pagination links
	 * @return string
	 */
	public function render() {
		return $this->initiateSubRequest();
	}
}
