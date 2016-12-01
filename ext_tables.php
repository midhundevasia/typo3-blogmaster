<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TYPO3 Blog');

/**
 * Plugin Configuration
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'Blog', 'Blog');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'Comment', 'Blog Comment');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_blog'] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['blogmaster_blog'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	'blogmaster_blog',
	'FILE:EXT:blogmaster/Configuration/FlexForms/Blog.xml'
);
/**
 * ContentElementWizard for Blog
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
	'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:blogmaster/Configuration/TSConfig/ContentElementWizard.ts">'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY]
	= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Hooks/PageLayoutView.php:Tutorboy\Blogmaster\Hooks\PageLayoutView';

/**
* Register icons
*/
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
	$iconRegistry->registerIcon(
		'extension-blogmaster-blog',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/Blog.svg']
	);
	$iconRegistry->registerIcon(
		'extension-blogmaster-donate',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/piggy-bank.svg']
	);
	$iconRegistry->registerIcon(
		'extension-blogmaster-bugs',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/bugs.svg']
	);
	$iconRegistry->registerIcon(
		'extension-blogmaster-help',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/help.svg']
	);
	$iconRegistry->registerIcon(
		'ext-blogmaster-collapse',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/actions-view-list-collapse.svg']
	);
	$iconRegistry->registerIcon(
		'ext-blogmaster-expand',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/actions-view-list-expand.svg']
	);
	$iconRegistry->registerIcon(
		'ext-blogmaster-close',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/actions-close.svg']
	);
	$iconRegistry->registerIcon(
		'ext-blogmaster-plus',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:blogmaster/Resources/Public/Icons/actions-plus.svg']
	);

if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {

	// Hijack: Typo3 default module listing order
	$GLOBALS['TBE_MODULES'] = array_merge(array('Tutorboy' => ''), $GLOBALS['TBE_MODULES']);
	$GLOBALS['TBE_MODULES']['_configuration']['Tutorboy'] = array(
		'labels' => array(
			'll_ref' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf:blog.mlang_tabs_tab',
			'tabs_images' => array(
				'tab' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Blog.svg',
			)
		),
		'name' => 'Tutorboy', /* New main module key as 'pw' */
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Tutorboy.' . $_EXTKEY,
		'Tutorboy',
		'blog',
		'top',
		array(
			'Post' => 'list,new,create,edit,update,delete',
			'Category' => 'list,new,create,delete,ajax',
			'Tag' => 'list,new,create,delete,ajax',
			'Comment' => 'list,new,create,delete,ajax,update,edit',
			'File' => 'getFileInfo'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Posts.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf:post.mlang_tabs_tab'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Tutorboy.' . $_EXTKEY,
		'Tutorboy',
		'cat',
		'',
		array(
			'Category' => 'list,new,create,delete'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Category.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf:category.mlang_tabs_tab'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Tutorboy.' . $_EXTKEY,
		'Tutorboy',
		'tag',
		'',
		array(
			'Tag' => 'list,new,create,delete,ajax'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Tags.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf:tag.mlang_tabs_tab'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Tutorboy.' . $_EXTKEY,
		'Tutorboy',
		'comment',
		'',
		array(
			'Comment' => 'list,new,edit,update,create,delete,addComment,ajax',
			'Post' => 'edit'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Comments.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf:comment.mlang_tabs_tab'
		)
	);
}

