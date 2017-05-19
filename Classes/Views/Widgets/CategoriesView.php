<?php
namespace Tutorboy\Blogmaster\Views\Widgets;
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
 * Category view
 *
 * @package 	Blogmaster
 * @subpackage 	Widgets
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class CategoriesView extends \Tutorboy\Blogmaster\Views\AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$categories = $this->getDatabaseConnection()->exec_SELECTgetRows(
			't.title, mm.uid_foreign as uid, count(distinct mm.uid_local) as count ',
			'tx_blogmaster_post_category_mm mm
			join tx_blogmaster_domain_model_category t on (t.uid = mm.uid_foreign)',
			't.deleted = 0',
			'mm.uid_foreign',
			'count DESC');
		$this->view->assign('categories', $categories);
	}
}