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
	 * Render pagination links
	 * @param QueryResultInterface|ObjectStorage|array $objects Query object
	 * @param string $as Assign to another object
	 * @param array $configuration Pagination configuration
	 * @return string
	 */
	public function render($objects, $as, array $configuration = ['itemsPerPage' => 10, 'insertAbove' => FALSE, 'insertBelow' => TRUE, 'maximumNumberOfLinks' => 99]) {
		return $this->initiateSubRequest();
	}
}
