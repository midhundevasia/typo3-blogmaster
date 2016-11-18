<?php
namespace Tutorboy\Blogmaster\Service;

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
 * Settings services
 *
 * @package 	Blogmaster
 * @subpackage 	Hooks
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class SettingsService implements \TYPO3\CMS\Core\SingletonInterface {

	protected $settings = [];

	/**
	 * Set settings value
	 * @param string $settings Settings array
	 * @return void
	 */
	public function setSettings($settings) {
		$this->settings = $settings;
	}

	/**
	 * Get settings
	 * @param  string $key Settings variable
	 * @return string|array
	 */
	public function getSettings($key = NULL) {
		if (isset($key)) {
			return $this->settings[$key];
		} else {
			return $this->settings;
		}
	}
}