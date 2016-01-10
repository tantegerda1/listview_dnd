<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// Hide translation for all tables when localization view is disabled
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('mod.web_list.hideTranslations = *');

// Replace RecordList class
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Recordlist\\RecordList'] = array(
	'className' => 'SwordGroup\\ListviewDnd\\RecordList'
);

// Hook for recordList
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/class.db_list_extra.inc']['actions']['listview_dnd'] = 'SwordGroup\\ListviewDnd\\Hook\\RecordListHook';
