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
 * Tag View
 *
 * @package 	Blogmaster
 * @subpackage 	Views
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class TagView extends AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$tagRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\TagRepository::class);
		$this->pageService->setViewType('list');
		$tagId = $this->request['tag'];
		$data = $postRepository->findAllByTag($tagId);
		$tagObject = $tagRepository->findOneByUid($tagId);
		$this->pageService->setTitle($tagObject->getTitle());
		$this->pageService->setDescription($tagObject->getDescription());
		$this->view->assign('data', $data);
		$this->view->assign('tagObject', $tagObject);
	}
}