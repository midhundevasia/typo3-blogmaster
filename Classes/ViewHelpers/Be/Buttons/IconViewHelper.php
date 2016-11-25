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

use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;

/**
 * View helper which returns a button icon
 *
 * @package     Blogmaster
 * @subpackage  ViewHelper
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 *
 * = Examples =
 *
 * <code title="Default">
 * <f:be.buttons.icon uri="{f:uri.action()}" />
 * </code>
 * <output>
 * An icon button as known from the TYPO3 backend, skinned and linked with the default action of the current controller.
 * Note: By default the "close" icon is used as image
 * </output>
 *
 * <code title="Default">
 * <f:be.buttons.icon uri="{f:uri.action(action:'new')}" icon="actions-document-new" title="Create new Foo" />
 * </code>
 *
 * <code title="Default">
 * <f:be.buttons.icon icon="actions-document-new" title="Create new Foo" />
 * </code>
 * <output>
 * Here the "actions-document-new" icon is returned, but without link.
 * </output>
 */
class IconViewHelper extends AbstractBackendViewHelper implements CompilableInterface {

	/**
	 * View helper returns HTML, thus we need to disable output escaping
	 *
	 * @var bool
	 */
	protected $escapeOutput = FALSE;

	/**
	 * Renders a linked icon as known from the TYPO3 backend.
	 *
	 * If the URI is left empty, the icon is rendered without link.
	 *
	 * @param string $uri The target URI for the link. If you want to execute JavaScript here, prefix the URI with
	 *     "javascript:". Leave empty to render just an icon.
	 * @param string $icon Icon to be used.
	 * @param string $title Title attribute of the icon construct
	 * @param array $additionalAttributes Additional tag attributes. They will be added directly to the resulting HTML tag.
	 *
	 * @return string The rendered icon with or without link
	 * @deprecated since TYPO3 CMS 7, will be removed in TYPO3 CMS 8, use \TYPO3\CMS\Core\ViewHelpers\IconViewHelper instead
	 */
	public function render($uri = '', $icon = 'actions-document-close', $title = '', array $additionalAttributes = []) {
		return static::renderStatic(
			[
				'uri' => $uri,
				'icon' => $icon,
				'title' => $title,
				'additionalAttributes' => $additionalAttributes
			],
			$this->buildRenderChildrenClosure(),
			$this->renderingContext
		);
	}

	/**
	 * Render
	 * @param array $arguments arguments
	 * @param \Closure $renderChildrenClosure renderChildrenClosure
	 * @param RenderingContextInterface $renderingContext renderingContext
	 * @return string
	 * @deprecated since TYPO3 CMS 7, will be removed in TYPO3 CMS 8, use \TYPO3\CMS\Core\ViewHelpers\IconViewHelper instead
	 */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		GeneralUtility::logDeprecatedFunction();
		$uri = $arguments['uri'];
		$icon = $arguments['icon'];
		$title = $arguments['title'];
		$additionalAttributes = $arguments['additionalAttributes'];
		$additionalTagAttributes = '';
		$iconFactory = GeneralUtility::makeInstance(IconFactory::class);
		$icon = '<span title="' . htmlspecialchars($title) . '">' . $iconFactory->getIcon($icon, Icon::SIZE_SMALL)->render() . '</span>';
		if (empty($uri)) {
			return $icon;
		}

		if ($additionalAttributes) {
			foreach ($additionalAttributes as $argumentKey => $argumentValue) {
				$additionalTagAttributes .= ' ' . $argumentKey . '="' . htmlspecialchars($argumentValue) . '"';
			}
		}
		return '<a href="' . $uri . '"' . $additionalTagAttributes . '>' . $icon . '</a>';
	}
}
