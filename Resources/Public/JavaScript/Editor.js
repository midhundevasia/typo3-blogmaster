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
 * RTE functions
 */
TYPO3.jQuery(document).ready(function() {
	// Set default editor mode from user settings
	Blogmaster.UserSettings.get('RTEMode', function(data) {
		if (data === 'undefined') {
			TYPO3.jQuery(".rte-editor-mode[data-mode='visual']").trigger('click');
		} else {
			if (data === 'text') {
				TYPO3.jQuery(".rte-editor-mode[data-mode='visual']").trigger('click');
				TYPO3.jQuery(".rte-editor-mode[data-mode='"+ data +"']").trigger('click');
			} else {
				TYPO3.jQuery(".rte-editor-mode[data-mode='visual']").trigger('click');
			}
		}
	});
	// Set editor mode
	TYPO3.jQuery(".rte-editor-mode").on('click', function() {
		mode = TYPO3.jQuery(this).data('mode');
		if (mode == 'text') {
			tinyMCE.execCommand('mceRemoveEditor', false, 'post-content');
		} else {
			tinyMCE.execCommand('mceAddEditor', false, 'post-content');
		}
		TYPO3.jQuery('.active-editor').removeClass('active-editor');
		TYPO3.jQuery(this).addClass('active-editor');
		Blogmaster.UserSettings.set('RTEMode', mode);
	});
});