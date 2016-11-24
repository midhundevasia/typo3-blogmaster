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
 * Feed Service
 *
 * @package 	Blogmaster
 * @subpackage 	Service
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class FeedService extends AbstractService {

	/**
	 * Construct
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
		$this->settingsService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class);
	}

	/**
	 * Generate RSS 2.0
	 * @param  array $params Params
	 * @param  object $pObj  Parent Object
	 * @return void
	 */
	public function generateBlogFeed(array &$params, &$pObj) {
		parent::setup($pObj);
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$data = $postRepository->findAllByBlog(0);
		$this->view->assign('settings', $this->settingsService->getSettings());
		$this->view->assign('data', $data);
		$this->view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:blogmaster/Resources/Private/Templates/Service/Feed.html'));
		header('Content-type: text/xml');
		echo $this->view->render();
		exit(0);
	}

	/**
	 * Generate comments feed
	 * @param  array $params Params
	 * @param  object $pObj  Parent Object
	 * @return void
	 */
	public function generateCommentsFeed(array &$params, &$pObj) {
		parent::setup($pObj);
		$commentRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\CommentRepository::class);
		$data = $commentRepository->findAllByBlog(0);
		$this->view->assign('settings', $this->settingsService->getSettings());
		$this->view->assign('data', $data);
		$this->view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:blogmaster/Resources/Private/Templates/Service/CommentsFeed.html'));
		header('Content-type: text/xml');
		echo $this->view->render();
		exit(0);
	}

	/**
	 * Generate Post comments feed
	 * @return void
	 * @todo Will update in future release
	 */
	public function generatePostFeed() {
	}
}