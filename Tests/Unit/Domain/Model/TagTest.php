<?php
namespace Tutorboy\Blogmaster\Tests\Unit\Domain\Model;
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
class TagTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Tutorboy\Blogmaster\Domain\Model\Tag
	 */
	protected $fixture = null;

	protected function setUp() {
		$this->fixture = new \Tutorboy\Blogmaster\Domain\Model\Tag();
	}

	/**
	 * @test
	 */
	public function getTitleInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getTitle());
	}

	/**
	 * @test
	 */
	public function setTitleSetsTitle() {
		$this->fixture->setTitle('foo bar');
		$this->assertSame('foo bar', $this->fixture->getTitle());
	}

	/**
	 * @test
	 */
	public function getSlugInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getSlug());
	}

	/**
	 * @test
	 */
	public function setSlugSetsSlug() {
		$this->fixture->setSlug('foo-bar');
		$this->assertSame('foo-bar', $this->fixture->getSlug());
	}

	/**
	 * @test
	 */
	public function setSlugSetsSlugOnEmptyString() {
		$this->fixture->setTitle('foo bar');
		$this->fixture->setSlug();
		$this->assertSame('foo-bar', $this->fixture->getSlug());
	}

	/**
	 * @test
	 */
	public function getDescriptionInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getDescription());
	}

	/**
	 * @test
	 */
	public function setDescriptionSetsDescription() {
		$this->fixture->setDescription('foo bar');
		$this->assertSame('foo bar', $this->fixture->getDescription());
	}
}