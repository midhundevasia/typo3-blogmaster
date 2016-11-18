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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * RealUrl Hooks
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class PageRendererHooks {

	/**
	 * Render
	 * @param  array $params Params
	 * @param  object $ref   Reference
	 * @return void
	 */
	public static function renderPostProcess(array &$params, &$ref) {
		$blogRenderer = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Frontend\BlogRenderer::class);

		// @todo lang="en-US"
		$params['htmlTag'] = $blogRenderer->getHtmlTag();
		$params['titleTag'] = $blogRenderer->getTitleTag();
	}
}