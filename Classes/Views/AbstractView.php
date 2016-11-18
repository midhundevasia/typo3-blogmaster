<?php
namespace Tutorboy\Blogmaster\Views;

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
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Abstract view
 *
 * All the view and widgets should inherit this class
 *
 * @package 	Blogmaster
 * @subpackage 	Views
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
abstract class AbstractView {


	/**
	 * View Object
	 * @var \TYPO3\CMS\Fluid\View\StandaloneView
	 */
	protected $view = NULL;

	/**
	 * Values from the GET and POST variables
	 * @var array
	 */
	public $request = [];

	/**
	 * Configuration array
	 * @var array
	 */
	public $configuration = [];

	/**
	 * All typoscript settings values
	 * @var array
	 */
	public $settings = [];

	/**
	 * Controller Context Object
	 * @var \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext
	 */
	public $controllerContext;

	/**
	 * Main function of a view class
	 * @return void
	 */
	abstract public function process();

	/**
	 * Initialize view class variables
	 * @return void
	 */
	public function initialize() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
		$this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::class);
		$this->view = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
		$this->view->setControllerContext($this->controllerContext);
		$this->view->getRequest()->setControllerExtensionName('Blogmaster');
		$this->settings = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class)->getSettings();
		$this->view->assign('settings', $this->settings);
		$this->view->assign('cObject', $this->configuration['contentObject']);
	}

	/**
	 * Render view
	 * @param  string $templateName Template file name
	 * @return string
	 */
	public function render($templateName = NULL) {
		if (!isset($templateName)) {
			$templateName = $this->configuration['pi_flexform']['whaToDisplay'];
		}

		/*
			# You can load new templates from other extensions
			customTheme {
			   ExtensionName = blogmaster
			   ThemeName = Default
			}
		 */
		if (!isset($this->settings['customTheme']['ExtensionName'])) {
			$themeExtensionName = 'blogmaster';
		} else {
			$themeExtensionName = strtolower($this->settings['customTheme']['ExtensionName']);
		}
		if (!isset($this->settings['customTheme']['ThemeName'])) {
			$themeName = 'Default';
		} else {
			$themeName = $this->settings['customTheme']['ThemeName'];
		}

		$this->view->setTemplatePathAndFileName(GeneralUtility::getFileAbsFileName('EXT:' . $themeExtensionName . '/Theme/' . $themeName . '/' . $templateName . '.html'));
		return $this->view->render();
	}

	/**
	 * Get database connection object
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	public function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

	/**
	 * Redriect to a given page
	 * @param  int $pageId Page Uid
	 * @return void
	 */
	public function redirectToPage($pageId = NULL) {
		if (!isset($pageId)) {
			$pageId = $this->settings['blogRootPageId'];
		}
		$this->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
		$conf['parameter'] = $pageId;
		$conf['useCacheHash'] = 1;
		$conf['forceAbsoluteUrl'] = 1;
		$conf['returnLast'] = 1;
		$url = $this->cObj->typoLink_URL($conf);
		header('Location: ' . $url);
	}
}