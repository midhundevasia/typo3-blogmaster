<?php
namespace Tutorboy\Blogmaster\Tests\Unit\Views;
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
 * Test case
 */
class HomeViewTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Tutorboy\Blogmaster\Views\HomeView
	 */
	protected $subject;

	/**
	 * setup
	 */
	public function setup() {
		$this->subject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Views\HomeView::class);
	}

	/**
	 * @test
	 */
	public function checkInitializeSetsAllValues() {
		$this->assertEquals(1, 1);
	}
}