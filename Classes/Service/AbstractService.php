<?php
namespace Tutorboy\Blogmaster\Service;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Abstract Service
 *
 * @package 	Blogmaster
 * @subpackage 	Hooks
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class AbstractService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * View Instances
	 * @var \TYPO3\CMS\Fluid\View\StandaloneView
	 */
	protected $view;

	/**
	 * Setup abstract service
	 * @param  object $pObject Parent Object
	 * @return void
	 */
	public function setup($pObject) {
		$this->view = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
		$this->view->setControllerContext($pObject->controllerContext);
		$this->view->getRequest()->setControllerExtensionName('Blogmaster');
	}
}