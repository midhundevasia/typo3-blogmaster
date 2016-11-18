<?php
namespace Tutorboy\Blogmaster\Frontend;

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

use Tutorboy\Blogmaster\Service\HookService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Blog renderer controller
 *
 * @package 	Blogmaster
 * @subpackage 	Blog
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class BlogRenderer {

	protected $title = NULL;

	protected $titleTag = '<title itemprop="name">|</title>';

	protected $htmlTag = '';

	public $viewType = 'list';

	/**
	 * Get Title tag
	 * @return [type] [description]
	 */
	public function getTitleTag() {
		return $this->titleTag;
	}

	/**
	 * Get HTML tags
	 * @return string
	 */
	public function getHtmlTag() {
		// @todo lang="en-US"
		switch ($this->viewType) {
			case 'list':
				$this->htmlTag = '<html itemscope="itemscope" itemtype="http://schema.org/WebPage" lang="en-US" prefix="og: http://ogp.me/ns#">';
				break;
			case 'single':
				$this->htmlTag = '<html itemscope="itemscope" itemtype="http://schema.org/Article" lang="en-US" prefix="og: http://ogp.me/ns#">';
				break;
			default:
		}
		return $this->htmlTag;
	}
}