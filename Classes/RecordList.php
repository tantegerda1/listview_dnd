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

		$GLOBALS['TBE_TEMPLATE']->getPageRenderer()->addJsInlineCode('typo3_version', 'var sg_t3version="' . TYPO3_version . '";');
		$GLOBALS['TBE_TEMPLATE']->getPageRenderer()->loadJquery();
		$GLOBALS['TBE_TEMPLATE']->getPageRenderer()->loadRequireJs();
		$GLOBALS['TBE_TEMPLATE']->getPageRenderer()->addJsFile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('listview_dnd') . 'Resources/Public/JavaScript/dnd.js');
	}
}

