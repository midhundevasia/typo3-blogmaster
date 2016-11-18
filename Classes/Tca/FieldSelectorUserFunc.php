<?php
namespace Tutorboy\Blogmaster\Tca;

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
 * Flex field hook functions
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class FieldSelectorUserFunc {

	/**
	 * Load View Types from the hooks
	 * @param  array $params Current values from the Flex array
	 * @return void
	 */
	public function getFieldSelection(array &$params) {
		if (is_array($params) && count($params)) {
			// Insert list options from other extensions (Experimental)
			$cleanup = 1;
		}
	}

	/**
	 * Load all categories to the flex form
	 * @param array $params Params
	 * @return void
	 */
	public function getCategories(array &$params) {
		if (is_array($params) && count($params)) {
			$objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager();
			$persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
			$catRepository = $objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\CategoryRepository::class);
			$cats = $catRepository->findAll();
			foreach ($cats as $cat) {
				$params['items'][$cat->getUid()] = [$cat->getTitle(), $cat->getUid()];
			}
		}
	}
}
