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
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Comment action controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class CommentController extends AbstractController {

	/**
	 * CommentRepository object
	 * @var \Tutorboy\Blogmaster\Domain\Repository\CommentRepository
	 */
	protected $commentRepository;

	/**
	 * Inject repository
	 * @param \Tutorboy\Blogmaster\Domain\Repository\CommentRepository $commentRepository Comment Repository
	 * @return void
	 */
	public function injectCommentRepository(\Tutorboy\Blogmaster\Domain\Repository\CommentRepository $commentRepository) {
		$this->commentRepository = $commentRepository;
	}

	/**
	 * List action
	 * @return void
	 */
	public function listAction() {
		if ($this->request->hasArgument('bulk-action') && NULL !== $this->request->getArgument('search')) {
			$action = $this->request->getArgument('bulk-action');
			if ($this->request->hasArgument('items')) {
				$items = $this->request->getArgument('items');
				switch ($action) {
					// Delete all selected comments.
					case 'trash':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->commentRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Comment) {
									$this->commentRepository->remove($object);
								}
							}
						}
						$this->getPersistenceManager()->persistAll();
						$this->addFlashMessage('Comment(s) has been moved to trash', 'Done!', FlashMessage::OK);
						break;
					// Publish all selected comments.
					case 'publish':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->commentRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Comment) {
									$object->setStatus('publish');
									$this->commentRepository->update($object);
								}
							}
						}
						$this->getPersistenceManager()->persistAll();
						$this->addFlashMessage('Comment(s) has been published', 'Done!', FlashMessage::OK);
						break;
					// Pending all selected comments.
					case 'pending':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->commentRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Comment) {
									$object->setStatus('pending');
									$this->commentRepository->update($object);
								}
							}
						}
						$this->getPersistenceManager()->persistAll();
						$this->addFlashMessage('Comment(s) has been marked as pending', 'Done!', FlashMessage::OK);
						break;
					// Spam all selected comments.
					case 'spam':
						if (is_array($items) && count($items)) {
							foreach ($items as $id) {
								if (($object = $this->commentRepository->findOneByUid($id)) instanceof \Tutorboy\Blogmaster\Domain\Model\Comment) {
									$object->setStatus('spam');
									$this->commentRepository->update($object);
								}
							}
						}
						$this->getPersistenceManager()->persistAll();
						$this->addFlashMessage('Comment(s) has been mark as spam', 'Done!', FlashMessage::OK);
						break;
					default:
				}
			}
		}

		// Filters
		if ($this->request->hasArgument('filter-by-type') && $this->request->getArgument('filter-by-type') != -1) {
			$type = $this->request->getArgument('filter-by-type');
			$comments = $this->commentRepository->findByType($type);
			$this->view->assign('filter-by-type', $type);
		} elseif ($this->request->hasArgument('filter-by-status') && $this->request->getArgument('filter-by-status') != -1) {
			// Search filter
			$status = $this->request->getArgument('filter-by-status');
			$comments = $this->commentRepository->findByStatus($status);
			$this->view->assign('filter-by-status', $status);
		} elseif ($this->request->hasArgument('search')) {
			// Search filter
			$search = $this->request->getArgument('search');
			$comments = $this->commentRepository->search($search);
			$this->view->assign('search', $search);
		} else {
			// Get all comments
			$comments = $this->commentRepository->findAllByBlog(0);
		}
		$this->view->assign('comments', $comments);
	}


	/**
	 * New comment
	 * @return void
	 */
	public function newAction() {
		if ($this->request->hasArgument('post')) {
			$this->view->assign('post', $this->request->getArgument('post'));
		}
	}

	/**
	 * Create new comment
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Comment $comment Comment object
	 * @return void
	 */
	public function createAction(\Tutorboy\Blogmaster\Domain\Model\Comment $comment) {
		if (!isset($this->settings['defaultCommentStatus'])) {
			$comment->setStatus('publish');
		} else {
			$comment->setStatus($this->settings['defaultCommentStatus']);
		}
		$comment->setAgent($_SERVER['HTTP_USER_AGENT']);
		$comment->setAuthorIp($_SERVER['REMOTE_ADDR']);
		$this->commentRepository->add($comment);
		$this->getPersistenceManager()->persistAll();
		if ($comment->getUid()) {
			$this->addFlashMessage('New comment has been created', 'Done!', FlashMessage::OK);
		} else {
			$this->addFlashMessage('Comment could not be saved.', 'Error!', FlashMessage::ERROR);
		}
		$this->redirect('edit', NULL, NULL, ['id' => $comment->getUid()]);
	}

	/**
	 * Edit
	 * @return void
	 */
	public function editAction() {
		$commentObject = $this->commentRepository->findOneByUid($this->request->getArgument('id'));
		$this->view->assign('comment', $commentObject);
	}

	/**
	 * Update
	 * @param  \Tutorboy\Blogmaster\Domain\Model\Comment $comment Comment object
	 * @return void
	 */
	public function updateAction(\Tutorboy\Blogmaster\Domain\Model\Comment $comment) {
		if (!isset($this->settings['defaultCommentStatus'])) {
			$comment->setStatus('publish');
		} else {
			$comment->setStatus($this->settings['defaultCommentStatus']);
		}
		$this->commentRepository->add($comment);
		$this->getPersistenceManager()->persistAll();
		if ($comment->getUid()) {
			$this->addFlashMessage('Comment has been updated', 'Done!', FlashMessage::OK);
		} else {
			$this->addFlashMessage('Comment could not be update.', 'Error!', FlashMessage::ERROR);
		}
		$this->redirect('edit', NULL, NULL, ['id' => $comment->getUid()]);
	}

	/**
	 * Add comment form
	 * @return NULL
	 */
	public function commentFormAction() {
		return '';
	}

	/**
	 * Add new comment for a post. Access from frontend plugin
	 * @return void
	 */
	public function addCommentAction() {
		if ($this->request->hasArgument('comment')) {
			$commentData = $this->request->getArgument('comment');
			$comment = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Domain\Model\Comment::class);
			$comment->setContent($commentData['content']);
			$comment->setAuthorName($commentData['authorName']);
			$comment->setAuthorUrl($commentData['authorUrl']);
			$comment->setAuthorEmail($commentData['authorEmail']);
			$comment->setAgent($_SERVER['HTTP_USER_AGENT']);
			$comment->setAuthorIp($_SERVER['REMOTE_ADDR']);
			$comment->setType('comment');
			if (!isset($this->settings['defaultCommentStatus'])) {
				$comment->setStatus('publish');
			} else {
				$comment->setStatus($this->settings['defaultCommentStatus']);
			}
			$comment->setPost($commentData['post']);
			$validator = $this->validatorResolver->getBaseValidatorConjunction(\Tutorboy\Blogmaster\Domain\Model\Comment::class);
			$result = $validator->validate($comment);
			if ($result->hasErrors()) {
				$validationErrors = $result->getFlattenedErrors();
				$errors = [];
				foreach ($validationErrors as $propertyName => $validationError) {
					$errors[$propertyName] = $validationError[0]->getMessage();
				}
				$this->view->assign('validationErrors', $errors);
			} else {
				$this->commentRepository->add($comment);
				$this->getPersistenceManager()->persistAll();
			}
		}
		if (!$comment->getPost()) {
			$redirect = \Tutorboy\Blogmaster\Utility\BlogUtility::getBlogUrl();
		}
		if ($comment->getUid()) {
			$redirect = \Tutorboy\Blogmaster\Utility\BlogUtility::getPostUrl($comment->getPost()) . '#comment-' . $comment->getUid();
		} else {
			$redirect = \Tutorboy\Blogmaster\Utility\BlogUtility::getPostUrl($comment->getPost());
		}
		header('Location:' . $redirect);
	}
}