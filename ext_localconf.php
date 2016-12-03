<?php
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

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Tutorboy.' . $_EXTKEY,
	'Blog',
	[
		'BlogFrontend' => 'render',
	]
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Tutorboy.' . $_EXTKEY,
	'Comment',
	[
		'Comment' => 'commentForm,addComment',
	]
);

// Blog services like feed, xmlrpc etc
\Tutorboy\Blogmaster\Service\BlogService::addService('feed', \Tutorboy\Blogmaster\Service\FeedService::class . '->generateBlogFeed');
\Tutorboy\Blogmaster\Service\BlogService::addService('commentsFeed', \Tutorboy\Blogmaster\Service\FeedService::class . '->generateCommentsFeed');
\Tutorboy\Blogmaster\Service\BlogService::addService('init', \Tutorboy\Blogmaster\Service\Core\GeneralService::class . '->activateFuturePosts');

// Hooks
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['encodeSpURL_postProc'][] = 'Tutorboy\\Blogmaster\\Hooks\\RealUrlHooks->encodeSpUrl_postProc';
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['decodeSpURL_preProc'][] = 'Tutorboy\\Blogmaster\\Hooks\\RealUrlHooks->decodeSpUrl_preProc';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][$_EXTKEY] = 'Tutorboy\\Blogmaster\\Hooks\\PageRendererHooks->renderPostProcess';

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration'][$_EXTKEY]
		= \Tutorboy\Blogmaster\Hooks\RealUrlAutoConfiguration::class . '->addBlogConfiguration';
}