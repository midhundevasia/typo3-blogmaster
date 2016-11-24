<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Format;

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

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Remove newline characters
 *
 * @package     Blogmaster
 * @subpackage  ViewHelper
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class RemoveNlViewHelper extends AbstractViewHelper implements CompilableInterface {

	/**
	 * Replaces newline characters.
	 * @param string $value string to format
	 * @return string the altered string.
	 */
	public function render($value = NULL) {
		return static::renderStatic(
			[
				'value' => $value
			],
			$this->buildRenderChildrenClosure(),
			$this->renderingContext
		);
	}

	/**
	 * Remove newline
	 * @param array $arguments Arguments
	 * @param \Closure $renderChildrenClosure renderChildrenClosure
	 * @param \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext renderingContext
	 * @return string
	 */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		$value = $arguments['value'];
		if ($value === NULL) {
			$value = $renderChildrenClosure();
		}

		return trim(str_replace(PHP_EOL, '', $value));
	}
}
