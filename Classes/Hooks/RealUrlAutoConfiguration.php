<?php
namespace Tutorboy\Blogmaster\Hooks;

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

use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * RealURL Configuration hook
 *
 * @package     Blogmaster
 * @subpackage  Blog
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class RealUrlAutoConfiguration {

	/**
	 * Generates additional RealURL configuration and merges it with provided configuration
	 * @param  array $params Default configuration
	 * @return array Updated configuration
	 */
	public function addBlogConfiguration(array $params) {
		ArrayUtility::mergeRecursiveWithOverrule($params['config'], [
			'fixedPostVadrs' => [
				'article' => [
					[
						'GETvar' => 'tx_blogmaster_blog[Post]',
						'lookUpTable' => [
							'table' => 'tx_blogmaster_domain_model_post',
							'id_field' => 'uid',
							'alias_field' => 'slug',
							'useUniqueCache' => 1,
							'useUniqueCache_conf' => [
								'strtolower' => 1,
								'spaceCharacter' => '-',
							],
							'noMatch' => 'bypass',
						],
					]
				],
				'category' => [
					[
						'GETvar' => 'tx_blogmaster_blog[Category]',
						'lookUpTable' => [
							'table' => 'tx_blogmaster_domain_model_category',
							'id_field' => 'uid',
							'alias_field' => 'title',
							'useUniqueCache' => 1,
							'useUniqueCache_conf' => [
								'strtolower' => 1,
								'spaceCharacter' => '-',
							],
							'noMatch' => 'bypass',
						],
					]
				],
				'tag' => [
					[
						'GETvar' => 'tx_blogmaster_blog[Tag]',
						'lookUpTable' => [
							'table' => 'tx_blogmaster_domain_model_tag',
							'id_field' => 'uid',
							'alias_field' => 'title',
							'useUniqueCache' => 1,
							'useUniqueCache_conf' => [
								'strtolower' => 1,
								'spaceCharacter' => '-',
							],
							'noMatch' => 'bypass',
						],
					]
				],
				'archive' => [
					[
						'GETvar' => 'tx_blogmaster_archive[year]',
					],
					[
						'GETvar' => 'tx_blogmaster_archive[month]',
					],
				],
			]
		]);
		return $params['config'];
	}
}
