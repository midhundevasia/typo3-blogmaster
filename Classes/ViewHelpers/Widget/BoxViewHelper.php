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

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;

/**
 * Pagination Viewhelper
 *
 * @package     Blogmaster
 * @subpackage  ViewHelpers
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class BoxViewHelper extends AbstractWidgetViewHelper {

	/**
	 * Controller
	 * @var \Tutorboy\Blogmaster\ViewHelpers\Widget\Controller\BoxController
	 */
	protected $controller;

	/**
	 * Inject controller instace
	 * @param \Tutorboy\Blogmaster\ViewHelpers\Widget\Controller\BoxController $controller Controller instance
	 * @return void
	 */
	public function injectPaginateController(\Tutorboy\Blogmaster\ViewHelpers\Widget\Controller\BoxController $controller) {
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
		$this->registerArgument('content', 'string', 'Content', FALSE);
		$this->registerArgument('title', 'string', 'Title', FALSE);
	}

	/**
	 * Render pagination links
	 * @return string
	 */
	public function render() {
		$this->controller->content = $this->renderChildren();
		return $this->initiateSubRequest();
	}
}
