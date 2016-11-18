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

# ======================================================================
# Module constants
# ======================================================================
module.tx_blogmaster {
	settings {
		templates {
			# cat=BlogMaster/general/1000; type=string; label=Home page template : Path to template file
			homePage = EXT:blogmaster/Resources/Private/Themes/Default/

			# cat=BlogMaster/general/1010; type=string; label=Single page template : Path to template file
			singlePage = EXT:blogmaster/Resources/Private/Themes/Default/

			# cat=BlogMaster/general/1020; type=string; label=Archive page template : Path to template file
			archivePage = EXT:blogmaster/Resources/Private/Themes/Default/
		}
	}
}