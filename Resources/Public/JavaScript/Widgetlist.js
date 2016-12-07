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
 * Module: TYPO3/CMS/Blogmaster/Widgetlist
 * Widget list view function
 */
define(['jquery', 'TYPO3/CMS/Backend/Storage', 'TYPO3/CMS/Backend/Icons'], function($, Storage, Icons) {

	var Widgetlist = {
		identifier: {
			toggle: '.toggle-widgetlist'
		}
	};

	/**
	 * Widget toggle button click
	 */
	Widgetlist.toggleClick = function(e) {
		e.preventDefault();
		var $me = $(this),
			id = $me.data('id'),
			toggle = $me.data('stage');
		if (toggle === 'expand') {
			iconName = 'collapse';
		} else {
			iconName = 'expand';
		}
		$me.data('stage', toggle);
		Icons.getIcon('actions-view-list-' + toggle, Icons.sizes.small).done(function(toggleIcon) {
			$me.html(toggleIcon);
		});
		Blogmaster.UserSettings.set(id, iconName);
		$('#' + id + ' .panel-body').slideToggle();
	};

	$(function() {
		$(document).on('click', Widgetlist.identifier.toggle, Widgetlist.toggleClick);
	});

	return Widgetlist;
});