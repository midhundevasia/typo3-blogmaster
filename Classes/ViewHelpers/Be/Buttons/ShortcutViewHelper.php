<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Be\Buttons;

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

use TYPO3\CMS\Backend\Template\DocumentTemplate;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;

/**
 * View helper which returns shortcut button with icon
 * Note: This view helper is experimental!
 *
 * @package     Blogmaster
 * @subpackage  ViewHelper
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com> * = Examples =
 *
 * <code title="Default">
 * <f:be.buttons.shortcut />
 * </code>
 * <output>
 * Shortcut button as known from the TYPO3 backend.
 * By default the current page id, module name and all module arguments will be stored
 * </output>
 *
 * <code title="Explicitly set parameters to be stored in the shortcut">
 * <f:be.buttons.shortcut getVars="{0: 'M', 1: 'myOwnPrefix'}" setVars="{0: 'function'}" />
 * </code>
 * <output>
 * Shortcut button as known from the TYPO3 backend.
 * This time only the specified GET parameters and SET[]-settings will be stored.
 * Note:
 * Normally you won't need to set getVars & setVars parameters in Extbase modules
 * </output>
 */
class ShortcutViewHelper extends AbstractBackendViewHelper implements CompilableInterface {

	/**
	 * View helper returns HTML, thus we need to disable output escaping
	 *
	 * @var bool
	 */
	protected $escapeOutput = FALSE;

	/**
	 * Renders a shortcut button as known from the TYPO3 backend
	 *
	 * @param array $getVars list of GET variables to store. By default the current id, module and all module arguments
	 *     will be stored
	 * @param array $setVars list of SET[] variables to store. See
	 *     \TYPO3\CMS\Backend\Template\DocumentTemplate::makeShortcutIcon(). Normally won't be used by Extbase modules
	 *
	 * @return string the rendered shortcut button
	 * @see \TYPO3\CMS\Backend\Template\DocumentTemplate::makeShortcutIcon()
	 */
	public function render(array $getVars = [], array $setVars = []) {
		return static::renderStatic(
			[
				'getVars' => $getVars,
				'setVars' => $setVars
			],
			$this->buildRenderChildrenClosure(),
			$this->renderingContext
		);
	}

	/**
	 * Render
	 * @param array $arguments Arguments
	 * @param \Closure $renderChildrenClosure renderChildrenClosure
	 * @param RenderingContextInterface $renderingContext renderingContext
	 * @return string
	 */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		$getVars = $arguments['getVars'];
		$setVars = $arguments['setVars'];

		$mayMakeShortcut = $GLOBALS['BE_USER']->mayMakeShortcut();

		if ($mayMakeShortcut) {
			$doc = GeneralUtility::makeInstance(DocumentTemplate::class);
			$currentRequest = $renderingContext->getControllerContext()->getRequest();
			$extensionName = $currentRequest->getControllerExtensionName();
			$moduleName = $currentRequest->getPluginName();
			if (count($getVars) === 0) {
				$modulePrefix = strtolower('tx_' . $extensionName . '_' . $moduleName);
				$getVars = ['id', 'M', $modulePrefix];
			}
			$getList = implode(',', $getVars);
			$setList = implode(',', $setVars);
			return $doc->makeShortcutIcon($getList, $setList, $moduleName);
		}
		return '';
	}
}
