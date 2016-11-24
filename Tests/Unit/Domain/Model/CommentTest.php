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
class CommentTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Tutorboy\Blogmaster\Domain\Model\Comment
	 */
	protected $fixture = null;

	protected function setUp() {
		$this->fixture = new \Tutorboy\Blogmaster\Domain\Model\Comment();
	}

	/**
	 * @test
	 */
	public function getContentInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getContent());
	}

	/**
	 * @test
	 */
	public function setContentSetsContent() {
		$this->fixture->setContent('foo bar');
		$this->assertSame('foo bar', $this->fixture->getContent());
	}

	/**
	 * @test
	 */
	public function getAuthorNameInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getAuthorName());
	}

	/**
	 * @test
	 */
	public function setAuthorNameSetsAuthorName() {
		$this->fixture->setAuthorName('foo bar');
		$this->assertSame('foo bar', $this->fixture->getAuthorName());
	}

	/**
	 * @test
	 */
	public function getAuthorEmailInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getAuthorEmail());
	}

	/**
	 * @test
	 */
	public function setAuthorEmailSetsAuthorEmail() {
		$this->fixture->setAuthorEmail('test@test.com');
		$this->assertSame('test@test.com', $this->fixture->getAuthorEmail());
	}

	/**
	 * @test
	 */
	public function getAuthorUrlInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getAuthorUrl());
	}

	/**
	 * @test
	 */
	public function setAuthorUrlSetsAuthorUrl() {
		$this->fixture->setAuthorUrl('www.example.ltd');
		$this->assertSame('www.example.ltd', $this->fixture->getAuthorUrl());
	}

	/**
	 * @test
	 */
	public function getAuthorIpInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getAuthorIp());
	}

	/**
	 * @test
	 */
	public function setAuthorIpSetsAuthorIp() {
		$this->fixture->setAuthorIp('12.2.3.34');
		$this->assertSame('12.2.3.34', $this->fixture->getAuthorIp());
	}

	/**
	 * @test
	 */
	public function getAgentInitiallyReturnsEmptyString() {
		$this->assertSame('', $this->fixture->getAgent());
	}

	/**
	 * @test
	 */
	public function setAgentSetsAgent() {
		$this->fixture->setAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.98 Safari/537.36');
		$this->assertSame('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.98 Safari/537.36', $this->fixture->getAgent());
	}
}