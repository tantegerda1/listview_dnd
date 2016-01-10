/**
 * JS code to enable drag&drop on list view table records in TYPO3 backend.
 * Author: Fabrice Morin
 * Licences: GPL, The MIT License (MIT)
 * Copyright: (c) 2015-2016 Fabrice Morin - SwordGroup
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * Revision:
 *  2016-01-10, Fabrice Morin:
 *      - TYPO3 v7 compatibility
 *  2015-07-11, Fabrice Morin:
 *      - Initial release
 */
(function($) {
	$(document).ready(function() {
		var version = parseInt(sg_t3version, 10);

		if(version === 6) {
			require(['jquery','jquery-ui/jquery-ui-1.10.4.custom.min'], function() {
				enableSorting();
			});
		} else {
			require(['jquery', 'jquery-ui/sortable'], function () {
				enableSorting();
			});
		}

		function enableSorting() {
			var $tables = $('form[name="dblistForm"] table');
			$tables.each(function() {
				var $table = $(this);
				// Enable sorting for draggable items
				$(this).find('tbody').sortable({
					appendTo: document.body,
					helper: 'clone',
					cursor: 'move',
					items: 'tr:has(span.draggable)',
					revert: true,
					create: onCreate,
					start: onDragStart,
					stop: onDragStop
				}).disableSelection();
			});
		}

		/*
		 * Set move cursor.
		 */
		function onCreate(e, ui) {
			$(this).find('tr:has(span.draggable)').css('cursor', 'move');
		}

		/*
		 * Set CSS on helper.
		 */
		function onDragStart(e, ui) {
			$(ui.helper).css('display', 'table');
		}

		/*
		 * Trigger move action after drop event.
		 */
		function onDragStop(e, ui) {
			var $tr = $(ui.item[0]);
			var $prev = $tr.prev();

			var baseURL = $tr.find('span.draggable').data('url');
			var table = $tr.find('span.draggable').data('table');
			var sourceID = $tr.find('span.draggable').data('uid');
			if(version === 6) {
				var targetID = $prev.hasClass('c-headLine') ? $tr.find('span.draggable').data('pid') : -$prev.find('span.draggable').data('uid');
			} else {
				var targetID = $prev.length === 0 ? $tr.find('span.draggable').data('pid') : -$prev.find('span.draggable').data('uid');
			}
			var params = '&cmd[' + table + '][' + sourceID + '][move]=' + targetID;
			var url = baseURL + params;
			$.get(url);
		}
	});
}(TYPO3.jQuery));
