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
 * Tag cloud view
 *
 * @package 	Blogmaster
 * @subpackage 	Widgets
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class TagCloudView extends \Tutorboy\Blogmaster\Views\AbstractView {

	/**
	 * Process
	 * @return void
	 */
	public function process() {
		$tags = $this->getDatabaseConnection()->exec_SELECTgetRows(
			't.title, mm.uid_foreign as uid, count(distinct mm.uid_local) as frequency ',
			'tx_blogmaster_post_tag_mm mm
			join tx_blogmaster_domain_model_tag t on (t.uid = mm.uid_foreign)',
			'1=1',
			'mm.uid_foreign',
			'frequency DESC');
		$maxFont = 32;
		$tagMax = $tags[0]['frequency'];
		$tagMin = $tags[count($tags) - 1]['frequency'];
		array_walk($tags, function(&$value, $key, $params) {
			$value['size'] = ((($params[0]) * ($value['frequency'] - $params[1])) / ($params[2] - $params[1]));
			if ($value['size'] <= 0) {
				$value['size'] = 8;
			}
		}, [$maxFont, $tagMin, $tagMax]);
		shuffle($tags);
		$this->view->assign('tags', $tags);
	}
}