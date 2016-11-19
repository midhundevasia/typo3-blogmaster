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

#####################
### RESET WRAPPER ###
#####################
tt_content.stdWrap.innerWrap >
lib.stdheader >
tt_content.list.10 >

module.tx_blogmaster {
	settings < plugin.tx_blogmaster.settings
}
