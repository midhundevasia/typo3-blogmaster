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
 * Search Result view
 *
 * @package 	Blogmaster
 * @subpackage 	Views
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class SearchResultView extends AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		// @TODO
		$searchString = $this->getDatabaseConnection()->quoteStr($this->request['search'], 'tx_blogmaster_domain_model_post');
		$searchString = strip_tags($searchString);
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$data = $postRepository->search($searchString);
		$this->pageService->setViewType('list');
		$this->pageService->setTitle('Search Results for "' . $searchString . '"');
		$this->view->assign('data', $data);
	}
}