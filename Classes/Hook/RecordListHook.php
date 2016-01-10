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

namespace SwordGroup\ListviewDnd\Hook;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Hook for record list rows.
 * Add a drag span containing information for each draggable rows.
 *
 * @author Fabrice Morin
 *
 */
class RecordListHook implements \TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface, \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var array
	 */
	protected $pageTsConfig = array();

	/**
	 * Retrive page TS config.
	 */
	public function __construct() {
		$TsConfig = GeneralUtility::removeDotsFromTS(\TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($GLOBALS['_GET']['id']));

		$this->pageTsConfig = $TsConfig['tx_listview_dnd']['tables'];
	}

	/**
	 * (non-PHPdoc)
	 * @see \TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface::makeClip()
	 */
	public function makeClip($table, $row, $cells, &$parentObject) {
		return $cells;
	}

	/**
	 * (non-PHPdoc)
	 * @see \TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface::makeControl()
	 */
	public function makeControl($table, $row, $cells, &$parentObject) {
		if(is_array($this->pageTsConfig) && in_array($table, $this->pageTsConfig) && $this->canMove($cells) && ! $GLOBALS['SOBE']->MOD_SETTINGS['localization']) {
			$urlParameters = [
				'prErr' => 1,
				'uPT' => 1
			];
			unset($cells['moveUp']);
			unset($cells['moveDown']);
			if (version_compare(TYPO3_version, '6.99.99', '<=')) {
				$url = $GLOBALS['SOBE']->doc->issueCommand($urlParameters);
			} else {
				$urlParameters['vC'] = $GLOBALS['BE_USER']->veriCode();
				$url = BackendUtility::getModuleUrl('tce_db', $urlParameters);
				unset($cells['secondary']['moveUp']);
				unset($cells['secondary']['moveDown']);
			}
			$span = sprintf('<span class="draggable" style="display: none" data-uid="%s" data-pid="%s" data-table="%s" data-url="%s"></span>', $row['uid'], $row['pid'], $table, $url);
			$cells['draggable'] = $span;
		}
		return $cells;
	}

	/**
	 * (non-PHPdoc)
	 * @see \TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface::renderListHeader()
	 */
	public function renderListHeader($table, $currentIdList, $headerColumns, &$parentObject) {
		return $headerColumns;
	}

	/**
	 * (non-PHPdoc)
	 * @see \TYPO3\CMS\Recordlist\RecordList\RecordListHookInterface::renderListHeaderActions()
	 */
	public function renderListHeaderActions($table, $currentIdList, $cells, &$parentObject) {
		return $cells;
	}

	/**
	 * Check if cell can move.
	 *
	 * @param array $cells
	 * @return boolean
	 */
	protected function canMove(array $cells) {
		if (version_compare(TYPO3_version, '6.99.99', '<=')) {
			foreach($cells as $cell) {
				if(strpos($cell, 't3-icon-actions-move') > 0) {
					return TRUE;
				}
			}
		} else {
			$keys = array_keys($cells);
			return in_array('moveUp', $keys) || in_array('moveDown', $keys);
		}
		RETURN FALSE;
	}
}
