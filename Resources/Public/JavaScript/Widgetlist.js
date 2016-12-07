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
			toggle: '.toggle-widgetlist',
			icons: {
				collapse: 'actions-view-list-collapse',
				expand: 'actions-view-list-expand'
			}
		}
	};

	/**
	 * Widget toggle button click
	 */
	Widgetlist.toggleClick = function(e) {
		e.preventDefault();
		var $me = $(this),
			id = $me.data('id'),
			isExpanded = $me.attr('data-state') === 'expand',
			toggle = $me.attr('data-state'),
			toggleIcon = isExpanded ? Widgetlist.identifier.icons.expand : Widgetlist.identifier.icons.collapse;
		Icons.getIcon(toggleIcon, Icons.sizes.small).done(function(toggleIcon) {
			$me.html(toggleIcon);
		});
		$me.attr('data-state', isExpanded ? 'collapse' : 'expand');
		Blogmaster.UserSettings.set(id, $me.data('state'), function() {
			$('#' + id + ' .panel-body').slideToggle('fast');
		});
	};

	$(function() {
		$(document).on('click', Widgetlist.identifier.toggle, Widgetlist.toggleClick);
	});

	return Widgetlist;
});