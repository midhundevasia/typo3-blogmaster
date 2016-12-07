<?php
namespace Tutorboy\Blogmaster\ViewHelpers\Widget\Controller;

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

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * Class BoxController
 *
 * @package     Blogmaster
 * @subpackage  ViewHelpers
 * @copyright   (c) 2016 Midhun Devasia, Tutorboy.org
 * @author      Midhun Devasia <hello@midhundevasia.com>
 */
class BoxController extends AbstractWidgetController {

	public $content = '';

	/**
	 * Index action
	 * @return void
	 */
	public function indexAction() {
		$id = 'box-' . md5($this->widgetConfiguration['title']);
		$userSettings = $GLOBALS['BE_USER']->uc['blogmaster'];
		$this->view->assign('title', $this->widgetConfiguration['title']);
		$this->view->assign('content', $this->content);
		$this->view->assign('id', $id);
		$this->view->assign('state', isset($userSettings[$id]) ? $userSettings[$id] : 'expand');
		$this->view->assign('stateIcon', ($userSettings[$id] == 'collapse') ? 'expand' : 'collapse');
		$this->view->assign('stateStyle', ($userSettings[$id] == 'collapse') ? 'display:none;' : 'display:block;');
	}
}