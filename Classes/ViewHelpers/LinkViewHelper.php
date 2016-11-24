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
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A viewhelper for create links
 *
 * @package 	Blogmaster
 * @subpackage 	ViewHelper
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class LinkViewHelper extends AbstractTagBasedViewHelper {

	/**
	 * Tag name
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * ContentObjectRenderer
	 * @var $cObj ContentObjectRenderer
	 */
	protected $cObj;

	/**
	 * Object type
	 * @var string
	 */
	protected $objectType = 'post';

	/**
	 * Page Id of object detail view
	 * @var integer
	 */
	protected $objectPageId = 1;

	protected $settingsService;

	/**
	 * Initialize arguments
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerArgument('object', 'object', 'Object', FALSE);
		$this->registerArgument('content', 'string', 'content', FALSE, '');
		$this->registerArgument('section', 'string', 'section', FALSE);
		$this->registerArgument('type', 'string', 'Type', FALSE);
		$this->registerArgument('params', 'array', 'Additional Params', FALSE);
		$this->registerArgument('urlOnly', 'string', 'Additional Params', FALSE);
		$this->registerTagAttribute('rel', 'string', 'rel', FALSE);
		$this->registerTagAttribute('itemprop', 'string', 'rel', FALSE);
	}

	/**
	 * Render link
	 * @return string
	 */
	public function render() {
		$this->settingsService = GeneralUtility::makeInstance(\Tutorboy\Blogmaster\Service\SettingsService::class);
		$this->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
		$object = $this->arguments['object'];
		$type = $this->arguments['type'];

		if (is_object($object)) {
			$this->getObjectType();
			$this->getObjectsPageUid();
			$value = $object->getUid();
		}

		if (isset($type)) {
			$conf['additionalParams'] = $this->getAdditionalParams($type);
		} else {
			$conf['additionalParams'] = '&tx_blogmaster_blog[' . $this->objectType . ']=' . $value;
		}
		$conf['parameter'] = $this->objectPageId;
		$conf['useCacheHash'] = 1;
		$conf['forceAbsoluteUrl'] = 1;
		$conf['returnLast'] = 1;

		if (isset($this->arguments['section']) && !empty($this->arguments['section'])) {
			$section = '#' . $this->arguments['section'];
		}
		$url = $this->cObj->typoLink_URL($conf) . $section;

		if ($this->arguments['urlOnly'] == TRUE) {
			return $url;
		}

		$this->tag->addAttribute('href', $url);
		if (empty($content)) {
			$content = $this->renderChildren();
		}
		$this->tag->setContent($content);

		return $this->tag->render();
	}

	/**
	 * Get the object type from the given Object
	 * @return void
	 */
	private function getObjectType() {
		$reflectionClassObject = new \ReflectionClass($this->arguments['object']);
		$this->objectType = strtolower($reflectionClassObject->getShortName());
	}

	/**
	 * Get page ids based on link types
	 * @return void
	 */
	private function getObjectsPageUid() {
		switch ($this->objectType) {
			case 'post':
				$this->objectPageId = $this->settingsService->getSettings('singlePageId');
				break;
			case 'category':
				$this->objectPageId = $this->settingsService->getSettings('categoryPageId');
				break;
			case 'tag':
				$this->objectPageId = $this->settingsService->getSettings('tagPageId');
				break;
			default:
				$this->objectPageId = $this->settingsService->getSettings('singlePageId');
		}

	}

	/**
	 * Additional parameters for link types
	 * @param  string $type Link type
	 * @return string
	 */
	private function getAdditionalParams($type) {
		$params = $this->arguments['params'];
		switch ($type) {
			case 'archive':
				$this->objectPageId = $this->settingsService->getSettings('archivePageId');
				return '&tx_blogmaster_blog[year]=' . $params['year'] . '&tx_blogmaster_blog[month]=' . $params['month'];
			case 'tag':
				$this->objectPageId = $this->settingsService->getSettings('tagPageId');
				return '&tx_blogmaster_blog[tag]=' . $params['id'];
			case 'category':
				$this->objectPageId = $this->settingsService->getSettings('categoryPageId');
				return '&tx_blogmaster_blog[category]=' . $params['id'];
			case 'author':
				$this->objectPageId = $this->settingsService->getSettings('authorPageId');
				return '&tx_blogmaster_blog[author]=' . $params['user'];
			default:
				return NULL;
		}
	}
}
