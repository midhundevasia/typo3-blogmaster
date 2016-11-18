<?php
namespace Tutorboy\Blogmaster\Controller;

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

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Abstract action controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Return the persistance manager object instance
	 * @return \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
	 */
	protected function getPersistenceManager() {
		return $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::class);
	}

	/**
	 * Convert flex form to array
	 * @param  string $flexForm Flex Configuration string
	 * @return array Flex value array
	 */
	public function convertFlexFormToArray($flexForm) {
		$flexformService = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
		$flexFormData = $flexformService->convertFlexFormContentToArray($flexForm);
		return $flexFormData;
	}

	/**
	 * Database connection
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	public static function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}