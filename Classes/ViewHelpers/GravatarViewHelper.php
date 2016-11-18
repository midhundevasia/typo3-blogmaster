<?php
namespace Tutorboy\Blogmaster\ViewHelpers;

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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Gravatar View helper
 *
 * @package 	Blogmaster
 * @subpackage 	ViewHelper
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class GravatarViewHelper extends AbstractTagBasedViewHelper {

	/**
	 * Tag name
	 * @var string
	 */
	protected $tagName = 'img';

	/**
	 * Initialize arguments
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('alt', 'string', 'Alternative Text for the image');
		$this->registerTagAttribute('itemprop', 'string', 'itemprop schema tag for image');
		$this->registerArgument('email', 'string', 'The email address to resolve the gravatar for', TRUE);
		$this->registerArgument('size', 'int', 'The size of the gravatar, ranging from 1 to 512', FALSE, 65);
	}

	/**
	 * Render
	 * @return string
	 */
	public function render() {
		$size = $this->arguments['size'];
		$url = 'http://www.gravatar.com/avatar/' . md5($this->arguments['email']) . '?s=' . $size;
		$this->tag->addAttribute('src', $url);
		$this->tag->addAttribute('width', $size);
		$this->tag->addAttribute('height', $size);
		$this->tag->addAttribute('class', 'avatar avatar-' . $size . ' photo avatar-default ' . $this->arguments['class']);

		return $this->tag->render();
	}
}
