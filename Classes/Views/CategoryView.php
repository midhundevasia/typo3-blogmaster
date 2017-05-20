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
 * Category View
 *
 * @package 	Blogmaster
 * @subpackage 	Views
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class CategoryView extends AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$categoryRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\CategoryRepository::class);
		$catId = $this->request['category'];
		if (isset($catId)) {
			$data = $postRepository->findAllByCategory($catId);
			$categoryObject = $categoryRepository->findOneByUid($catId);
			$this->pageService->setViewType('list');
			$this->pageService->setTitle($categoryObject->getTitle());
			$this->pageService->setDescription($categoryObject->getDescription());
			$this->view->assign('data', $data);
			$this->view->assign('categoryObject', $categoryObject);
		}
	}
}