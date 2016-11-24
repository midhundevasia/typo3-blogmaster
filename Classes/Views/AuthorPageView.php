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

/**
 * Author View
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class AuthorPageView extends AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$userRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\UserRepository::class);
		$this->pageService->setViewType('list');

		if (is_int($this->request['author'])) {
			$userData = $userRepository->findOneByUid($this->request['author']);
		} else {
			$userData = $userRepository->findOneByUsername($this->request['author']);
		}
		$data = $postRepository->findByCruserId($userData->getUid());
		$this->pageService->setTitle($userData->getDisplayName());
		$this->view->assign('data', $data);
		$this->view->assign('userData', $userData);
	}
}