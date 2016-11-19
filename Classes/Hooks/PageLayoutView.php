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

/**
 * PageLayoutView Hooks
 *
 * @package 	Blogmaster
 * @subpackage 	Backend
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class PageLayoutView implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface {

	/**
	 * Preprocesses the preview rendering of a content element.
	 * @param  \TYPO3\CMS\Backend\View\PageLayoutView $parentObject  Calling parent object
	 * @param  bool	 		$drawItem      Whether to draw the item using the default functionalities
	 * @param  string	 	$headerContent Header content
	 * @param  string		$itemContent   Item content
	 * @param  array		$row           Record row of tt_content
	 * @return void
	 */
	public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) {
		switch ($row['list_type']) {
			case 'blogmaster_blog':
				$drawItem = FALSE;
				$flexformService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
				$flexFormData = $flexformService->convertFlexFormContentToArray($row['pi_flexform']);
				$headerContent = '<strong>Blog: ' . $flexFormData['whaToDisplay'] . '</strong><br/>';
				$itemContent = 'Blogmaster<br/>';
				break;
			default:
		}
	}
}