<?php
namespace Tutorboy\Blogmaster\Service\Core;

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
 * General Service
 *
 * @package 	Blogmaster
 * @subpackage 	Service
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class GeneralService extends \TYPO3\CMS\Core\Service\AbstractService {

	/**
	 * Construct
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
		$this->settingsService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class);
	}

	/**
	 * Activate future post if the date match
	 * @param  array  $params Params
	 * @param  object $pObj   Parent Class
	 * @return void
	 */
	public function activateFuturePosts(array &$params, &$pObj) {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$posts = $postRepository->findAllFuturePosts();
		if (is_object($posts) && count($posts)) {
			foreach ($posts as $post) {
				$post->setStatus('publish');
				$postRepository->update($post);
			}
		}
	}
}