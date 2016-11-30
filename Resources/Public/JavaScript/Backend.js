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
 * Backend utility functions
 * @type {Object}
 */
var Blogmaster = {};
Blogmaster.fileFn = {
	checkUniqueElement: function(objectId, table, uid, type) {
		return {passed: true};
	},

	importElement: function(objectId, table, uid, type) {
		TYPO3.jQuery('#' + objectId).val(uid);
		Blogmaster.getFilePreview(uid, '#' + objectId)
		return;
	}
};

/**
 * Get file preivew
 * @param  {int} fileUid 	  File Uid
 * @param  {string} container File Preivew Element
 * @return void
 */
Blogmaster.getFilePreview = function(fileUid, container) {
	TYPO3.jQuery.ajax({
		url: getFileInfoUrl,
		data: {uid: fileUid},
		success: function (fileObject) {
			TYPO3.jQuery(container + '-preview').attr('src', fileObject.absolutePath);
		}
	});
}

Blogmaster.openFileBrowser = function(mode, params, width, height) {
	var topwidth = 800, topheight = 800;
	if (top && top.TYPO3 && top.TYPO3.configuration) {
		topwidth = top.TYPO3.configuration.PopupWindow.width;
		topheight = top.TYPO3.configuration.PopupWindow.height;
	}
	var url = recordBrowseUrl + '&mode=' + mode + '&bparams=' + params;
	width = width ? width : topwidth;
	height = height ? height : topheight;
	window.openedPopupWindow = window.open(url, 'Typo3WinBrowser', 'height=' + height + ',width=' + width + ',status=0,menubar=0,resizable=1,scrollbars=1');
	window.openedPopupWindow.focus();
};
