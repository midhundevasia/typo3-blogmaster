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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;

/**
 * Category controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class CategoryController extends AbstractController {

	/**
	 * CategoryRepository object
	 * @var \Tutorboy\Blogmaster\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * Inject repository
	 * @param \Tutorboy\Blogmaster\Domain\Repository\CategoryRepository $categoryRepository Category Repository
	 * @return void
	 */
	public function injectCategoryRepository(\Tutorboy\Blogmaster\Domain\Repository\CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * List all categories
	 * @return void
	 */
	public function listAction() {
		if ($this->request->hasArgument('bulk-action')) {
			$action = $this->request->getArgument('bulk-action');
			if ($this->request->hasArgument('items')) {
				$items = $this->request->getArgument('items');
				switch ($action) {
					// Delete all selected categories.
					case 'delete':
						if (is_array($items) && count($items)) {
							foreach ($items as $catId) {
								if (($object = $this->categoryRepository->findOneByUid($catId)) instanceof \Tutorboy\Blogmaster\Domain\Model\Category) {
									$this->categoryRepository->remove($object);
								}
							}
							$this->getPersistenceManager()->persistAll();
							$this->addFlashMessage($this->translate('msg.categoriesMovedToTrash'), $this->translate('heading.done'), FlashMessage::OK);
						}
						break;
					default:
				}
			}
		}

		// Search filter
		if ($this->request->hasArgument('search')) {
			$search = $this->request->getArgument('search');
			$cats = $this->categoryRepository->search($search);
			$this->view->assign('search', $search);
		} else {
			// Get all categories
			$cats = $this->categoryRepository->findAllByBlog(0);
		}

		$this->view->assign('cats', $cats);
	}

	/**
	 * New category form
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Category|null $category Category
	 * @return void
	 * @dontvalidate $category
	 */
	public function newAction(\Tutorboy\Blogmaster\Domain\Model\Category $category = NULL) {
		// Edit view
		if ($this->request->hasArgument('id')) {
			$id = $this->request->getArgument('id');
			$category = $this->categoryRepository->findOneByUid($id);
			$this->view->assign('categoryObject', $category);
		} else {
			$this->view->assign('categoryObject', $category);
		}

		$cats = $this->categoryRepository->findAllByBlog(0);
		$catList[0] = 'None';
		foreach ($cats as $cat) {
			$catList[$cat->getUid()] = $cat->getTitle();
		}
		$this->view->assign('catList', $catList);
	}

	/**
	 * Create new category
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Category $category Category object
	 * @return void
	 */
	public function createAction(\Tutorboy\Blogmaster\Domain\Model\Category $category) {
		$this->categoryRepository->add($category);
		$this->getPersistenceManager()->persistAll();
		if ($category->getUid()) {
			$this->addFlashMessage($this->translate('msg.newCatCreated'), $this->translate('heading.done'), FlashMessage::OK);
		} else {
			$this->addFlashMessage($this->translate('msg.catCouldNotSave'), $this->translate('heading.error'), FlashMessage::ERROR);
		}
		$this->redirect('new', NULL, NULL, ['id' => $category->getUid()]);
	}

	/**
	 * Delete category
	 * @return void
	 * @todo More ID validation codes
	 */
	public function deleteAction() {
		$id = $this->request->getArgument('delete');
		$this->categoryRepository->remove($this->categoryRepository->findOneByUid($id));
		$this->addFlashMessage($this->translate('msg.categoryMovedToTrash'), $this->translate('heading.done'), FlashMessage::WARNING);
		$this->redirect('new', NULL, NULL);
	}

	/**
	 * Ajax
	 * @return void
	 */
	public function ajaxAction() {
		switch (GeneralUtility::_GP('action')) {
			case 'add':
				if (NULL !== (GeneralUtility::_GP('name'))) {
					$category = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Model\Category::class);
					$category->setTitle(GeneralUtility::_GP('name'));
					$category->setSlug();
					$category->setParent(GeneralUtility::_GP('parent'));
					$this->categoryRepository->add($category);
					$this->getPersistenceManager()->persistAll();
					if ($category->getUid()) {
						$catObject['name'] = $category->getTitle();
						$catObject['parent'] = $category->getParent();
						$catObject['id'] = $category->getUid();
						header('Content-Type: application/json');
						echo json_encode($catObject);
					}
				}
				break;
			default:
		}
		die();
	}
}