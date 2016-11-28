<?php
namespace Tutorboy\Blogmaster\Frontend;

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

use Tutorboy\Blogmaster\Service\HookService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Content renderer controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class ContentRenderer {

	/**
	 * Configurations
	 * @var array
	 */
	public $configuration = [];

	/**
	 * ControllerContext
	 * @var \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext
	 */
	public $controllerContext;

	/**
	 * All the request variables from controller
	 * @var array
	 */
	public $request = [];

	/**
	 * Render view
	 * @param  array $configuration Configuration
	 * @return string
	 */
	public function render(array $configuration) {
		$this->configuration = $configuration;
		$this->request = $this->configuration['request'];
		$this->init();
		if (is_array($configuration['pi_flexform']) && $configuration['pi_flexform']['whaToDisplay']) {
			$pageService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\PageService::class);
			$pageService->isBlog = TRUE;
			$viewClassName = 'ViewType/' . ucfirst($configuration['pi_flexform']['whaToDisplay']);
			if (HookService::hasHook($viewClassName) && ($className = HookService::getAll($viewClassName))) {
				return $this->renderView($className[0]);
			} else {
				return $this->renderViewType();
			}
		}
	}

	/**
	 * Initialize render context
	 * @return void
	 */
	private function init() {
		$this->initServices();
	}

	/**
	 * Services
	 * @return void
	 */
	private function initServices() {
		if (is_array($this->request['service'])) {
			foreach ($this->request['service'] as $serviceName => $serviceValue) {
				$blogService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\BlogService::class);
				$blogService->doService($serviceName, [$serviceName, $serviceValue, 'request' => $this->request], $this);
			}
		}
	}

	/**
	 * Render view type
	 * @return string
	 */
	private function renderViewType() {
		$whaToDisplay = str_replace('/', '\\', ucfirst($this->configuration['pi_flexform']['whaToDisplay']));
		$viewClassName = 'Tutorboy\\Blogmaster\\Views\\' . $whaToDisplay . 'View';
		return $this->renderView($viewClassName);
	}

	/**
	 * Render view
	 * @param  string $viewClassName View class name
	 * @return string
	 */
	private function renderView($viewClassName) {
		if (class_exists($viewClassName)) {
			$view = GeneralUtility::makeInstance($viewClassName);
			$view->configuration = $this->configuration;
			$view->request = $this->configuration['request'];
			$view->controllerContext = $this->controllerContext;
			$view->initialize();
			$view->process();
			return $view->render();
		}
	}
}