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

/**
 * Blog frontend controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class BlogFrontendController extends AbstractController {

	/**
	 * Render all view for the frontend plugin
	 * @return void
	 */
	public function renderAction() {
		$settingsService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class);
		$settingsService->setSettings($this->settings);

		$data['contentObject'] = $this->configurationManager->getContentObject()->data;
		$data['pi_flexform'] = $this->convertFlexFormToArray($this->configurationManager->getContentObject()->data['pi_flexform']);
		$data['request'] = $this->request->getArguments();

		$contentRenderer = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Frontend\ContentRenderer::class);
		$contentRenderer->controllerContext = $this->controllerContext;
		$content = $contentRenderer->render($data);
		$this->view->assign('content', $content);
	}
}