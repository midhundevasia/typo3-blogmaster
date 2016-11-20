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
 * Single view
 *
 * @package 	Blogmaster
 * @subpackage 	Views
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class SingleView extends AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$commentRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\CommentRepository::class);
		$postId = $this->request['post'];
		$data = $postRepository->findOneByUid($postId);
		if (is_object($data)) {
			if ($data->getStatus() == 'publish') {
				$comments = $commentRepository->findByPost($postId);
				if (($nextPost = $postRepository->findNext($data))) {
					$this->view->assign('nextPost', $nextPost);
				}
				if (($prevPost = $postRepository->findPrevious($data))) {
					$this->view->assign('previousPost', $prevPost);
				}
				$this->pageService->setTitle($data->getTitle());
				$this->pageService->setDescription($data->getContent());
				$postTags = $data->getTags();
				$tags = [];
				foreach ($postTags as $tag) {
					$tags[] = $tag->getTitle();
				}
				$this->pageService->setKeywords($tags);
				$this->pageService->setAuthor($data->getAuthor()->getDisplayName());
				$this->pageService->setViewType('single');
				$this->view->assign('post', $data);
				$this->view->assign('comments', $comments);
			} else {
				$this->redirectToPage();
			}
		}
	}
}