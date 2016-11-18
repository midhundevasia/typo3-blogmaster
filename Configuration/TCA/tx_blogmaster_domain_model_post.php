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
		'title' => [],
		'content' => [],
		'slug' => [],
		'excerpt' => [],
		'cruser_id' => [],
		'crdate' => [],
		'created' => [],
		'modified' => [],
		'deleted' => [],
		'hidden' => [],
		'created_gmt' => [],
		'modified_gmt' => [],
		'status' => [],
		'comment_count' => [],
		'comment_status' => [],
		'blog' => [],
		'image' => [
			'exclude' => 1,
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'sys_file_reference',
				'foreign_field' => 'uid_foreign',
				'foreign_sortby' => 'sorting_foreign',
				'foreign_table_field' => 'tablenames',
				'foreign_match_fields' => [
					'fieldname' => 'image',
					'tablenames' => 'tx_blogmaster_domain_model_post',
					'table_local' => 'sys_file',
				],
				'foreign_label' => 'uid_local',
				'foreign_selector' => 'uid_local',
			]
		],

		'categories' => [
			'exclude' => 1,
			'config' => [
				'foreign_table' => 'tx_blogmaster_domain_model_category',
				'MM' => 'tx_blogmaster_post_category_mm'
			]
		],

		'tags' => [
			'exclude' => 1,
			'config' => [
				'foreign_table' => 'tx_blogmaster_domain_model_tag',
				'MM' => 'tx_blogmaster_post_tag_mm'
			]
		],
	],

	'languageField' => 'sys_language_uid',
	'transOrigPointerField' => 'l18n_parent',
	'transOrigDiffSourceField' => 'l18n_diffsource',
];