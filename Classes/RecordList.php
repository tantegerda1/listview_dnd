<?php

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace SwordGroup\ListviewDnd;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extension of RecordList class to load CSS/JS resources for backend module list.
 *
 * @author Fabrice Morin
 *
 */
class RecordList extends \TYPO3\CMS\Recordlist\RecordList {

	/**
	 * Load jQuery and required CSS/JS.
	 */
	public function __construct() {
		parent::__construct();

		// TYPO3 < 8 compatibility
		if (version_compare(TYPO3_version, '8.0', 'lt')) {
			$GLOBALS['TBE_TEMPLATE']->addJsInlineCode('typo3_version', 'var sg_t3version="' . TYPO3_version . '";');
			$GLOBALS['TBE_TEMPLATE']->loadJquery();
			$GLOBALS['TBE_TEMPLATE']->loadRequireJs();
			$GLOBALS['TBE_TEMPLATE']->addJsFile(ExtensionManagementUtility::extRelPath('listview_dnd') . 'Resources/Public/JavaScript/dnd.js');
			return;
		}

		$renderer = GeneralUtility::makeInstance(PageRenderer::class);
		$renderer->addJsInlineCode('typo3_version', 'var sg_t3version="' . TYPO3_version . '";');
		$renderer->loadJquery();
		$renderer->loadRequireJs();
		$renderer->addJsFile(ExtensionManagementUtility::siteRelPath('listview_dnd') . 'Resources/Public/JavaScript/dnd.js');
	}
}

