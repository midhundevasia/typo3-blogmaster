<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Widget;

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

/**
 * Widget Link Viewhelper
 *
 * @package     Blogmaster
 * @subpackage  ViewHelpers
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class LinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * Tagname
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * Initialize arguments
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
		$this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
		$this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
		$this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
		$this->registerArgument('addQueryStringMethod', 'string', 'Method to be used for query string');
	}

	/**
	 * Render the link.
	 *
	 * @param string $action Target action
	 * @param array $arguments Arguments
	 * @param string $section The anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html
	 * @param bool $ajax TRUE if the URI should be to an AJAX widget, FALSE otherwise.
	 *
	 * @return string The rendered link
	 * @api
	 */
	public function render($action = NULL, array $arguments = [], $section = '', $format = '', $ajax = FALSE) {
		if ($ajax === TRUE) {
			$uri = $this->getAjaxUri();
		} else {
			$uri = $this->getWidgetUri();
		}
		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($this->renderChildren());
		return $this->tag->render();
	}

	/**
	 * Get the URI for an AJAX Request.
	 *
	 * @return string the AJAX URI
	 */
	protected function getAjaxUri() {
		$action = $this->arguments['action'];
		$arguments = $this->arguments['arguments'];
		if ($action === NULL) {
			$action = $this->controllerContext->getRequest()->getControllerActionName();
		}
		$arguments['id'] = $GLOBALS['TSFE']->id;
		// @todo page type should be configurable
		$arguments['type'] = 7076;
		$arguments['fluid-widget-id'] = $this->controllerContext->getRequest()->getWidgetContext()->getAjaxWidgetIdentifier();
		$arguments['action'] = $action;
		return '?' . http_build_query($arguments, NULL, '&');
	}

	/**
	 * Get the URI for a non-AJAX Request.
	 *
	 * @return string the Widget URI
	 */
	protected function getWidgetUri() {
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$argumentPrefix = $this->controllerContext->getRequest()->getArgumentPrefix();
		$arguments = $this->hasArgument('arguments') ? $this->arguments['arguments'] : [];
		if ($this->hasArgument('action')) {
			$arguments['action'] = $this->arguments['action'];
		}
		if ($this->hasArgument('format') && $this->arguments['format'] !== '') {
			$arguments['format'] = $this->arguments['format'];
		}
		return $uriBuilder->reset()
			->setArguments([$argumentPrefix => $arguments])
			->setSection($this->arguments['section'])
			->setAddQueryString(TRUE)
			->setCreateAbsoluteUri(TRUE)
			->setAddQueryStringMethod($this->arguments['addQueryStringMethod'])
			->setArgumentsToBeExcludedFromQueryString([$argumentPrefix, 'cHash'])
			->setFormat($this->arguments['format'])
			->build();
	}
}