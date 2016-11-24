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
 * Archive View
 *
 * @package 	Blogmaster
 * @subpackage 	Views
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class ArchiveView extends AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$postRepository = $this->objectManager->get(\Tutorboy\Blogmaster\Domain\Repository\PostRepository::class);
		if (isset($this->request['year'])) {
			$config['year'] = $this->request['year'];
			$prefix = 'Year: ';
		}
		if (isset($this->request['month'])) {
			$config['month'] = $this->request['month'];
			$prefix = 'Month: ';
		}
		if (isset($this->request['day'])) {
			$config['day'] = $this->request['day'];
			$prefix = 'Day: ';
		}
		$data = $postRepository->findAllByYearMonthDay($config['year'], $config['month'], $config['day']);

		$archiveInfo[] = $config['year'];
		$archiveInfo[] = $config['month'] ? strftime('%B', strtotime('1900-' . $config['month'] . '-22')) : '';
		$archiveInfo[] = $config['day'] ? $config['day'] : '';
		$heading = $prefix . implode(' ', $archiveInfo);

		$this->pageService->setViewType('list');
		$this->pageService->setTitle($heading);
		$this->view->assign('archiveInfo', $heading);
		$this->view->assign('data', $data);
	}
}