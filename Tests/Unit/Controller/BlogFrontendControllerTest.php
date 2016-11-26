<?php
namespace Tutorboy\Blogmaster\Tests\Unit\Controller;
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
 * Test case
 */
class BlogFrontendControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Tutorboy\Blogmaster\Controller\BlogFrontendController
	 */
	protected $subject;

	/**
	 * setup
	 */
	public function setup() {
		// caches, those need to be mocked.
		$cacheManagerMock = $this->getMock(\TYPO3\CMS\Core\Cache\CacheManager::class, [], [], '', false);
		$cacheMock = $this->getMock(\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface::class, [], [], '', false);
		$cacheManagerMock->expects($this->any())->method('getCache')->will($this->returnValue($cacheMock));
		GeneralUtility::setSingletonInstance(\TYPO3\CMS\Core\Cache\CacheManager::class, $cacheManagerMock);
		$flexFormService = $this->getMock(\TYPO3\CMS\Extbase\Service\FlexFormService::class, ['dummy'], [], '', false);

		$this->subject = $this->getAccessibleMock(\Tutorboy\Blogmaster\Controller\BlogFrontendController::class, ['dummy']);
		$this->settings = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Tests\Unit\Fixtures\PluginSettingsArrayFixture::class)->getSettings();
		$this->flexFormData = $flexFormService->convertFlexFormContentToArray(GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Tests\Unit\Fixtures\FlexFormArrayFixture::class)->getData());
	}

	/**
	 * @test
	 * @todo not possible to call controller method
	 */
	public function renderContentRenderViewBasedOnFlexArray() {
		$data = [];
		$data['contentObject'] = [];
		$data['pi_flexform'] = $this->flexFormData;
		$data['request'] = [];
		$this->subject->_set('settings', $this->settings);
		//$viewContent = $this->subject->_call('renderContent', $data);
		$this->assertSame(NULL, $viewContent);
	}
}