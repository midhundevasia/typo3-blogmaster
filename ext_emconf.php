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
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Blog system for TYPO3 CMS',
	'description' => 'A blog system for TYPO3 CMS. Features: Posts, Publishing Tools, Categories, Tags, Comments, User Management, Themes, Search, Tag cloud, Archive, Widgets, RSS Feed, Comment Feed',
	'category' => 'plugin',
	'author' => 'Midhun Devasia',
	'author_email' => 'hello@midhundevasia.com',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.4',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.6.0-8.9.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);