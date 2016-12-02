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
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Post controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class PostController extends AbstractController {

	/**
	 * PostRepository object
	 * @var \Tutorboy\Blogmaster\Domain\Repository\PostRepository
	 */
	protected $postRepository;

	/**
	 * TagRepository object
	 * @var \Tutorboy\Blogmaster\Domain\Repository\TagRepository
	 */
	protected $tagRepository;

	/**
	 * CategoryRepository object
	 * @var \Tutorboy\Blogmaster\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * UserRepository object
	 * @var \Tutorboy\Blogmaster\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * Inject repository
	 * @param \Tutorboy\Blogmaster\Domain\Repository\CategoryRepository $categoryRepository Category Repository
	 * @return void
	 */
	public function injectCategoryRepository(\Tutorboy\Blogmaster\Domain\Repository\CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * Inject repository
	 * @param \Tutorboy\Blogmaster\Domain\Repository\TagRepository $tagRepository Tag Repository
	 * @return void
	 */
	public function injectTagRepository(\Tutorboy\Blogmaster\Domain\Repository\TagRepository $tagRepository) {
		$this->tagRepository = $tagRepository;
	}

	/**
	 * Inject repository
	 * @param \Tutorboy\Blogmaster\Domain\Repository\PostRepository $postRepository Post Repository
	 * @return void
	 */
	public function injectPostRepository(\Tutorboy\Blogmaster\Domain\Repository\PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * Inject repository
	 * @param \Tutorboy\Blogmaster\Domain\Repository\UserRepository $userRepository User Repository
	 * @return void
	 */
	public function injectUserRepository(\Tutorboy\Blogmaster\Domain\Repository\UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}

	/**
	 * Initialize actions
	 * @return void
	 */
	protected function initializeAction() {
		$path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('blogmaster');
		//@todo setlocale(LC_ALL, 'de_DE'); for date chagnes and slug functions
		$this->pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
		$this->pageRenderer->addJsFile($path . 'Resources/Public/JavaScript/Backend.js');
		$this->pageRenderer->addJsFile($path . 'Resources/Public/Library/tinymce/tinymce.min.js');
		$rteConf = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Rte\RteConfiguration::class)->getConfiguration();
		$this->pageRenderer->addJsInlineCode('tinymce', $rteConf, FALSE, TRUE);
		$this->pageRenderer->addJsInlineCode('recordBrowseUrl', '
			var recordBrowseUrl = ' . GeneralUtility::quoteJSvalue(BackendUtility::getModuleUrl('wizard_element_browser')) . ';', FALSE, TRUE);
		$this->pageRenderer->addJsInlineCode('getFileInfoUrl', '
			var getFileInfoUrl = ' . GeneralUtility::quoteJSvalue(BackendUtility::getModuleUrl('getFileInfo')) . ';', FALSE, TRUE);
	}

	/**
	 * Initialize View
	 * @param  ViewInterface $view [description]
	 * @return void
	 */
	protected function initializeView(ViewInterface $view) {
		parent::initializeView($view);
		$this->view->assign('categoryList', $this->categoryRepository->findAllByBlog(0));
	}

	/**
	 * List of all post form the default blog if no blog selected
	 * @return void
	 */
	public function listAction() {
		if ($this->request->hasArgument('bulk-action')) {
			$action = $this->request->getArgument('bulk-action');
			if ($this->request->hasArgument('items')) {
				$items = $this->request->getArgument('items');
				switch ($action) {
					// Delete all selected posts.
					case 'trash':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->postRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Post) {
									$this->postRepository->remove($object);
								}
							}
							$this->getPersistenceManager()->persistAll();
							$this->addFlashMessage($this->translate('msg.postsMovedToTrash'), $this->translate('heading.done'), FlashMessage::OK);
						}
						break;
					// Publish all selected posts.
					case 'publish':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->postRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Post) {
									$object->setStatus('publish');
									// @todo Need fix
									$object->setDeleted(0);
									$this->postRepository->setDefaultQuerySettings($querySettings);
									$this->postRepository->update($object);
								}
							}
							$this->getPersistenceManager()->persistAll();
							$this->addFlashMessage($this->translate('msg.postsPublished'), $this->translate('heading.done'), FlashMessage::OK);
						}
						break;
					// Draft all selected posts.
					case 'draft':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->postRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Post) {
									$object->setStatus('draft');
									$this->postRepository->update($object);
								}
							}
							$this->getPersistenceManager()->persistAll();
							$this->addFlashMessage($this->translate('msg.postsDrafted'), $this->translate('heading.done'), FlashMessage::OK);
						}
						break;
					default:
				}
			}
		}

		// Filters
		if ($this->request->hasArgument('filter-by-date') && $this->request->getArgument('filter-by-date') != -1) {
			list($year, $month) = explode('.', $this->request->getArgument('filter-by-date'));
			$posts = $this->postRepository->findAllByYearAndMonth($year, $month);
			$this->view->assign('filter-by-date', $this->request->getArgument('filter-by-date'));
		} elseif ($this->request->hasArgument('filter-by-cat') && $this->request->getArgument('filter-by-cat') != -1) {
			// Filter by cat
			$cat = $this->request->getArgument('filter-by-cat');
			$posts = $this->postRepository->findAllByCategory($cat);
			$this->view->assign('filter-by-cat', $cat);
		} elseif ($this->request->hasArgument('filter-by-status') && $this->request->getArgument('filter-by-status') != -1) {
			// Filter by status
			$status = $this->request->getArgument('filter-by-status');
			if ($status === 'trash') {
				$querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
				$querySettings->setRespectStoragePage(FALSE);
				$querySettings->setIgnoreEnableFields(TRUE);
				$querySettings->setIncludeDeleted(TRUE);
				$this->postRepository->setDefaultQuerySettings($querySettings);
				$posts = $this->postRepository->findByDeleted($status);
			} else {
				$posts = $this->postRepository->findByStatus($status);
			}
			$this->view->assign('filter-by-status', $status);
		} elseif ($this->request->hasArgument('search')) {
			// Search filter
			$search = $this->request->getArgument('search');
			$posts = $this->postRepository->search($search);
			$this->view->assign('search', $search);
		} else {
			// Get all posts
			$posts = $this->postRepository->findAllByBlog(0);
		}
		$this->view->assign('posts', $posts);

		$archiveList = $this->postRepository->findAllPostCountByYearAndMonth();
		$date[-1] = $this->translate('label.allDates');
		foreach ($archiveList as $key => $value) {
			$date[$key] = $value['monthName'] . ' ' . $value['year'];
		}
		$this->view->assign('archiveList', $date);

		$categories = $this->categoryRepository->findAllByBlog(0);
		foreach ($categories as $cat) {
			$catList[$cat->getUid()] = $cat->getTitle();
		}
		$catList[-1] = $this->translate('label.allCategories');
		ksort($catList);
		$this->view->assign('categories', $catList);
	}

	/**
	 * New post form
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Post|null $newPost New post
	 * @return void
	 * @dontvalidate $newPost
	 */
	public function newAction(\Tutorboy\Blogmaster\Domain\Model\Post $newPost = NULL) {
		$this->view->assign('postObject', $newPost);
		$cats = $this->categoryRepository->findAllByBlog(0);
		$authors = $this->userRepository->findAll();
		$catList[0] = 'None';
		foreach ($cats as $cat) {
			$catList[$cat->getUid()] = $cat->getTitle();
		}
		$this->view->assign('catList', $catList);
		$this->view->assign('authors', $authors);
	}

	/**
	 * Delete post
	 * @return void
	 * @todo More ID validation codes
	 */
	public function deleteAction() {
		$id = $this->request->getArgument('delete');
		$this->postRepository->remove($this->postRepository->findOneByUid($id));
		$this->addFlashMessage($this->translate('msg.postMovedToTrash'), $this->translate('heading.done'), FlashMessage::OK);
		$this->redirect('list', NULL, NULL);
	}

	/**
	 * Create new post
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Post $newPost Post object
	 * @return void
	 */
	public function createAction(\Tutorboy\Blogmaster\Domain\Model\Post $newPost) {
		if (GeneralUtility::_GP('__additionalData')) {
			$additionalData = GeneralUtility::_GP('__additionalData');
			$this->processAdditionalData($newPost, $additionalData);
		}
		$this->postRepository->add($newPost);
		$this->getPersistenceManager()->persistAll();
		if ($newPost->getUid()) {
			$this->addFlashMessage($this->translate('msg.newPostCreated'), $this->translate('heading.done'), FlashMessage::OK);
		} else {
			$this->addFlashMessage($this->translate('msg.postCoulddNotSave'), $this->translate('heading.error'), FlashMessage::ERROR);
		}
		$this->redirect('edit', NULL, NULL, ['id' => $newPost->getUid()]);
	}

	/**
	 * Update post
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Post $newPost Post object
	 * @return void
	 */
	public function updateAction(\Tutorboy\Blogmaster\Domain\Model\Post $newPost) {
		if (GeneralUtility::_GP('__additionalData')) {
			$additionalData = GeneralUtility::_GP('__additionalData');
			$this->processAdditionalData($newPost, $additionalData);
		}
		$this->postRepository->add($newPost);
		$this->getPersistenceManager()->persistAll();
		if ($newPost->getUid()) {
			$this->addFlashMessage($this->translate('msg.newPostCreated'), $this->translate('heading.done'), FlashMessage::OK);
		} else {
			$this->addFlashMessage($this->translate('msg.postCoulddNotSave'), $this->translate('heading.error'), FlashMessage::ERROR);
		}
		$this->redirect('edit', NULL, NULL, ['id' => $newPost->getUid()]);
	}

	/**
	 * Edit
	 * @return void
	 */
	public function editAction() {
		$this->view->assign('categoryList', $this->categoryRepository->findAllByBlog(0));
		$postObject = $this->postRepository->findOneByUid($this->request->getArgument('id'));
		$commentRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\CommentRepository::class);
		$comments = $commentRepository->findByPost($this->request->getArgument('id'));
		$authors = $this->userRepository->findAll();
		$this->view->assign('postObject', $postObject);
		if (is_object($postObject->getTags())) {
			foreach ($postObject->getTags() as $tag) {
				$tagList[] = $tag;
			}
		}
		$this->view->assign('tagList', $tagList);
		$cats = $this->categoryRepository->findAllByBlog(0);
		$catList[0] = 'None';
		foreach ($cats as $cat) {
			$catList[$cat->getUid()] = $cat->getTitle();
		}
		$this->view->assign('catList', $catList);
		$this->view->assign('authors', $authors);
		$this->view->assign('comments', $comments);
	}

	/**
	 * Process additional data
	 * @param  object $postObject Post object
	 * @param  array $data        Request variables
	 * @return void
	 */
	private function processAdditionalData($postObject, array $data) {
		if ($data['newCategories'] && is_array($data['newCategories'])) {
			$this->addCategories($postObject, $data['newCategories']);
		}

		if ($data['newTags'] && is_array($data['newTags'])) {
			$this->addTags($postObject, $data['newTags']);
		}
	}

	/**
	 * Add New categories
	 * @param object $postObject Post object
	 * @param array $categories  Category list
	 * @return void
	 */
	private function addCategories($postObject, array $categories) {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		if (count($categories) && is_array($categories)) {
			$postCurrentCats = $postObject->getCategories();
			if ($postCurrentCats) {
				foreach ($postCurrentCats as $postCat) {
					$categories[] = $postCat->getUid();
				}
			}
			foreach ($categories as $catId) {
				$cat = $this->categoryRepository->findOneByUid($catId);
				$storage->attach($cat);
			}
			$postObject->setCategories($storage);
			$this->postRepository->add($postObject);
			$this->getPersistenceManager()->persistAll();
		}
	}

	/**
	 * Add new tags to the post
	 * @param object $postObject Post object
	 * @param array  $tags        Tag ids
	 * @return void
	 */
	private function addTags($postObject, array $tags) {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		if (count($tags) && is_array($tags)) {
			$postCurrentTags = $postObject->getTags();
			if ($postCurrentTags) {
				foreach ($postCurrentTags as $postTag) {
					$tags[] = $postTag->getUid();
				}
			}
			foreach ($tags as $tagId) {
				$tag = $this->tagRepository->findOneByUid($tagId);
				$storage->attach($tag);
			}
			$postObject->setTags($storage);
			$this->postRepository->add($postObject);
			$this->getPersistenceManager()->persistAll();
		}
	}
}