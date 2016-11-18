<?php
namespace Tutorboy\Blogmaster\Views\Widgets;
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

/**
 * Archive view
 *
 * @package 	Blogmaster
 * @subpackage 	Widgets
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class ArchivesView extends \Tutorboy\Blogmaster\Views\AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		$archiveList = $postRepository->findAllPostCountByYearAndMonth();
		ksort($archiveList);
		$this->view->assign('archiveList', $archiveList);
	}
}