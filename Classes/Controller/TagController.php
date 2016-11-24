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
 * Tag controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class TagController extends AbstractController {

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
								if (($object = $this->tagRepository->findOneByUid($catId)) instanceof \Tutorboy\Blogmaster\Domain\Model\Tag) {
									$this->tagRepository->remove($object);
								}
							}
						}
						$this->getPersistenceManager()->persistAll();
						$this->addFlashMessage('Tag has been moved to trash', 'Done!', FlashMessage::WARNING);
						break;
					default:
				}
			}
		}

		// Search filter
		if ($this->request->hasArgument('search')) {
			$search = $this->request->getArgument('search');
			$cats = $this->tagRepository->search($search);
			$this->view->assign('search', $search);
		} else {
			// Get all categories
			$cats = $this->tagRepository->findAllByBlog(0);
		}

		$this->view->assign('cats', $cats);
	}

	/**
	 * New tag form
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Tag|null $tag Tag
	 * @return void
	 * @dontvalidate $tag
	 */
	public function newAction(\Tutorboy\Blogmaster\Domain\Model\Tag $tag = NULL) {
		// Edit view
		if ($this->request->hasArgument('id')) {
			$id = $this->request->getArgument('id');
			$tag = $this->tagRepository->findOneByUid($id);
			$this->view->assign('tagObject', $tag);
		} else {
			$this->view->assign('tagObject', $tag);
		}
	}

	/**
	 * Create new tag
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Tag $tag Tag object
	 * @return void
	 */
	public function createAction(\Tutorboy\Blogmaster\Domain\Model\Tag $tag) {
		$this->tagRepository->add($tag);
		$this->getPersistenceManager()->persistAll();
		if ($tag->getUid()) {
			$this->addFlashMessage('New tag has been created', 'Done!', FlashMessage::OK);
		} else {
			$this->addFlashMessage('Tag could not be saved.', 'Error!', FlashMessage::ERROR);
		}
		$this->redirect('new', NULL, NULL, ['id' => $tag->getUid()]);
	}

	/**
	 * Delete tag
	 * @return void
	 * @todo More ID validation codes
	 */
	public function deleteAction() {
		$id = $this->request->getArgument('delete');
		$this->tagRepository->remove($this->tagRepository->findOneByUid($id));
		$this->addFlashMessage('One tag has been moved to trash', 'Done!', FlashMessage::WARNING);
		$this->redirect('new', NULL, NULL);
	}

	/**
	 * Ajax actions
	 * @return mixed
	 */
	public function ajaxAction() {
		switch (GeneralUtility::_GP('action')) {
			case 'add':
				$this->addNewTags();
				break;
			case 'suggest':
				$this->suggest();
				break;
			case 'mostUsed':
				$this->suggest();
				break;
			default:
		}
		die();
	}

	/**
	 * Add new tags
	 * @return void
	 */
	private function addNewTags() {
		if ($this->request->hasArgument('postId')) {
			$postId = $this->request->getArgument('postId');
		}
		$tags = GeneralUtility::_GP('tags');
		$tags = GeneralUtility::trimExplode(',', $tags, TRUE);
		if (is_array($tags) && count($tags)) {
			$newTags = [];
			foreach ($tags as $tagName) {
				$tag = new \Tutorboy\Blogmaster\Domain\Model\Tag;
				$tag->setTitle($tagName);
				$tag->setSlug();
				$this->tagRepository->add($tag);
				$this->getPersistenceManager()->persistAll();
				if ($tag->getUid()) {
					$newTags[] = $tag;
				}
			}

			if ($postId) {
				$post = $this->postRepository->findOneByUid($postId);
				$postCurrentTags = $post->getTags();
				if ($postCurrentTags) {
					foreach ($postCurrentTags as $postTag) {
						$newTags[] = $postTag;
					}
				}

				$tagStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
				if (count($newTags) && is_array($newTags)) {
					foreach ($newTags as $tag) {
						$tagStorage->attach($tag);
					}
				}
				$post->setTags($tagStorage);
				$this->postRepository->update($post);
				$this->getPersistenceManager()->persistAll();

				$post = $this->postRepository->findOneByUid($postId);
				$postCurrentTags = $post->getTags();
				if (count($postCurrentTags)) {
					$this->renderTagsAsJson($postCurrentTags);
				}
			} else {
				$this->renderTagsAsJson($newTags);
			}
		}
	}

	/**
	 * Search and list if the tag exists
	 * @return void
	 */
	private function suggest() {
		if ($this->request->hasArgument('postId')) {
			$postId = $this->request->getArgument('postId');
		}
		$tags = GeneralUtility::_GP('tags');
		$tags = end(GeneralUtility::trimExplode(',', $tags, TRUE));
		$result = $this->tagRepository->suggest($tags);
		if (count($result)) {
			$tags = [];
			foreach ($result as $tag) {
				$tags[] = $tag;
			}
			$this->renderTagsAsJson($tags);
		}
	}

	/**
	 * Get most used tags
	 * @return void
	 */
	private function getMostUsedTags() {
		$tags = $this->getDatabaseConnection()->exec_SELECTgetRows(
			't.title, mm.uid_foreign as uid, count(distinct mm.uid_local) as frequency ',
			'tx_blogmaster_post_tag_mm mm
			join tx_blogmaster_domain_model_tag t on (t.uid = mm.uid_foreign)',
			'1=1',
			'mm.uid_foreign',
			'frequency DESC');
		$maxFont = 72;
		$tagMax = $tags[0]['frequency'];
		$tagMin = $tags[count($tags) - 1]['frequency'];
		array_walk($tags, function(&$value, $key, $params) {
			$value['size'] = ((($params[0]) * ($value['frequency'] - $params[1])) / ($params[2] - $params[1]));
			if ($value['size'] <= 0) {
				$value['size'] = 8;
			}
		}, [$maxFont, $tagMin, $tagMax]);

		if (count($tags)) {
			$tagObjects = [];
			foreach ($tags as $tag) {
				$tagObjects[] = $this->tagRepository->findOneByUid($tag['uid']);
			}
			$this->renderTagsAsJson($tagObjects);
		}
	}

	/**
	 * Render tags as JSON
	 * @param  array|mixed $tags Tags
	 * @return void
	 */
	private function renderTagsAsJson($tags) {
		foreach ($tags as $postTag) {
			$newTags[] = ['name' => $postTag->getTitle(), 'uid' => $postTag->getUid()];
		}
		header('Content-Type: application/json');
		echo json_encode($newTags);
	}
}