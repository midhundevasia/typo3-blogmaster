<?php
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
defined('TYPO3_MODE') or die();

return [
	'ctrl' => [
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'adminOnly' => 1,
		'delete' => 'deleted',
		'hideTable' => TRUE,
		'enablecolumns' => [
			'disabled' => 'hidden',
			]
		],
	'columns' => [
		'author_name' => [],
		'author_email' => [],
		'author_url' => [],
		'author_ip' => [],
		'content' => [],
		'agent' => [],
		'cruser_id' => [],
		'crdate' => [],
		'created' => [],
		'created_gmt' => [],
		'blog' => [],
		'post' => [],
		'parent' => [],
		'type' => [],
		'status' => []
	],

	'languageField' => 'sys_language_uid',
	'transOrigPointerField' => 'l18n_parent',
	'transOrigDiffSourceField' => 'l18n_diffsource',
];