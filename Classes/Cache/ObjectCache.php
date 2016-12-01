<?php
namespace Tutorboy\Blogmaster\Cache;

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
 * Object cache is a singleton class which store the oject and share only in page or Something like share data with in views
 *
 * @todo Will replace this class as real cache in future
 * @package 	Blogmaster
 * @subpackage 	Cache
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class ObjectCache implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Which hold all the object
	 * @var array
	 */
	protected $object = [];

	/**
	 * Get object
	 * @param  string $key Cache identifier
	 * @return cached object
	 */
	public function get($key) {
		return $this->object[$key];
	}

	/**
	 * Set object
	 * @param string $key    Cache identifier
	 * @param object $object Object
	 * @return void
	 */
	public function set($key, $object) {
		$this->object[$key] = $object;
	}
}