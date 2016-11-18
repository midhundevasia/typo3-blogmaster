<?php
namespace Tutorboy\Blogmaster\RTE;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;

/**
 * RTE configuration
 *
 * Load all external extensions and configurations for the RTE
 *
 * @package 	Blogmaster
 * @subpackage 	Editor
 * @copyright 	(c) 2016 Midhun Devasia, Tutorboy.org
 * @author 		Midhun Devasia <hello@midhundevasia.com>
 */
class RteConfiguration {

	/**
	 * Editor default configuration
	 * @return string
	 */
	public function getConfiguration() {
		$path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('blogmaster');
		$this->loadRegisteredPlugins();
		$confString = '
		TYPO3.jQuery(document).ready(function() {
			tinyMCE.baseURL = "' . $path . 'Resources/Public/Library/tinymce";
			tinymce.init({
				selector:".rte-editor",
				height: 100,
				menubar: false,
				image_advtab: true,
				autoresize_bottom_margin: 5,
				autoresize_overflow_padding: 5,
				content_css: "' . $path . 'Resources/Public/Css/tinymce.css",
				external_plugins : {
					' . $this->plugins . '
				},
				plugins: [
				"autoresize advlist autolink autosave link  lists charmap print preview hr pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"table directionality textcolor paste textcolor colorpicker textpattern"
				],
				toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontsizeselect | code | preview",
				toolbar2: "table | hr removeformat | pagebreak restoredraft | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor  media | forecolor backcolor",
				toolbar3: "",
				toolbar_items_size: "small",
			});
		});
		';

		return $confString;
	}

	/**
	 * Load registered plugins for the editor
	 * @return void
	 */
	private function loadRegisteredPlugins() {
		$params = array();
		$params = \Tutorboy\Blogmaster\Service\HookService::applyHook('Blogmaster/RTE/Plugin', $params, $this);
		if (is_array($params) && count($params)) {
			foreach ($params as $key => $param) {
				$this->plugins[] = '"' . $key . '" : "../../../../../../' . $param['file'] . '"';
			}
			$this->plugins = implode(',' . PHP_EOL, $this->plugins);
		}
	}
}