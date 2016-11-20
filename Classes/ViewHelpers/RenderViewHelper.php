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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Render View helper
 *
 * @package 	Blogmaster
 * @subpackage 	ViewHelper
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 *
 * Usage:
 * <code>
 * 		<blog:render object="{post}" field="content"/>
 * </code>
 */
class RenderViewHelper extends AbstractViewHelper {

	/**
	 * Initialize arguments
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('object', 'object', 'Active object', TRUE);
		$this->registerArgument('field', 'string', 'The email address to resolve the gravatar for', TRUE);
		$this->registerArgument('viewType', 'string', 'Whether its a single or list view', FALSE);
		$this->registerArgument('length', 'integer', 'Length of the content to be trim', FALSE);
		$this->registerArgument('offset', 'integer', 'Offset of the trim', FALSE);
		$this->registerArgument('format', 'string', 'Format function', FALSE);
		$this->registerArgument('content', 'string', 'If a content provided to process', FALSE);
		$this->registerArgument('breakString', 'string', 'String which used to split the content', FALSE);
	}

	/**
	 * Render
	 * @return string
	 */
	public function render() {
		$this->settingsService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class);

		$object = $this->arguments['object'];
		$field = $this->arguments['field'];
		$viewType = $this->arguments['viewType'];
		$len = $this->arguments['length'];
		$offset = $this->arguments['offset'];
		$format = $this->arguments['format'];
		$content = $this->arguments['content'];
		$breakString = $this->arguments['breakString'] ? $this->arguments['breakString'] : '<!-- more -->';

		if (is_object($object) && !empty($field)) {
			$methodName = 'get' . ucfirst($field);
			if (method_exists($object, $methodName)) {
				$content = $object->$methodName();
			}
		}

		if ('single' !== $viewType) {
			$content = explode($breakString, $content);
			$content = $content[0];
		}

		return $content;
	}
}
