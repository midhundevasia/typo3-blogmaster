<?php
namespace Tutorboy\Blogmaster\Tests\Unit\Fixtures;
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
 * Plugin Settings Array Fixture
 * plugin.tx_blogmaster.settings {}
 */
class PluginSettingsArrayFixture {

	/**
	 * @return array
	 */
	public function getSettings() {
		return [
			'blogRootPageId' => 1,
			'singlePageId' => 2, 
			'categoryPageId' => '', 
			'tagPageId' => '', 
			'archivePageId' => '', 
			'searchResultPageId' => '', 
			'authorPageId' => '', 
			'dateFormat' => 'F j, Y, g:i a',

			'comments' => ['active' => 1],

			'customTheme' => [
				'ExtensionName' => 'blogmaster',
				'ThemeName' => 'Default',
			],

			'pagination' => [
				'insertBelow' => 1,
				'insertAbove' => 0,
				'itemsPerPage' => 10,
			],

			'meta' => [
				'description' => '', 
				'keywords' => '', 
			],

			'blogTitle' => '', 
			'blogTagline' => '', 
			'titleSeparator' => '|', 
			'enableFeeds' => 1, 
			'locale' => 'en_US',
			'backend' => [
				'dateFormat' => 'F j, Y, g:i a'
			]
		];
	}
}