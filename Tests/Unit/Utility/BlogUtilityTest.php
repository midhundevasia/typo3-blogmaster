<?php
namespace Tutorboy\Blogmaster\Tests\Unit\Utility;
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
class BlogUtilityTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Tutorboy\Blogmaster\Utility\BlogUtility
	 */
	protected $fixture = null;

	/**
	 * setup
	 */
	protected function setUp() {
		$this->fixture = new \Tutorboy\Blogmaster\Utility\BlogUtility();
	}

	/**
	 * @test
	 */
	public function normalStringSlugify() {
		$this->assertEquals('foo-bar-test', $this->fixture->slugify('foo bar test'));
	}

	/**
	 * @test
	 */
	public function germanSpecialCharStringSlugify() {
		$this->assertEquals('the-a-o-u-and-ss', $this->fixture->slugify('the ä, ö, ü and ß '));
	}

	/**
	 * @test
	 */
	public function htmlSymbolEntitiesCharStringSlugify() {
		$this->assertEquals('i-will-display', $this->fixture->slugify('I will display € ™'));
	}
}