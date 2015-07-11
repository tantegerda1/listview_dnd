/**
 * JS code to enable drag&drop on list view table records in TYPO3 backend.
 * Author: Fabrice Morin
 * Licences: GPL, The MIT License (MIT)
 * Copyright: (c) 2015 Fabrice Morin - SwordGroup
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * Revision:
 *  2015-07-11, Fabrice Morin:
 *      - Initial release
 */
(function($) {
	$(document).ready(function() {
		// Restore jQuery global name to load jQuery UI.
		window.jQuery = $;

		// Load jQueryUI here because it needs jQuery without noConflicts().
		$.getScript('/typo3conf/ext/listview_dnd/Resources/Public/JavaScript/jquery-ui-1.10.4.custom.min.js', function() {
			var $tables = $('table.typo3-dblist');
			$tables.each(function() {

				// Enable sorting for draggable items
				$(this).find('tbody').sortable({
					cursor: 'move',
					items: 'tr.db_list_normal:has(span.draggable)',
					revert: true,
					create: onCreate,
					stop: onDragStop
				}).disableSelection();
			});
		});

		/*
		 * Hide move icons when sorting is enable.
		 */
		function onCreate(e, ui) {
			$(this).find('tr.db_list_normal:has(span.t3-icon-actions-move)').css('cursor', 'move');
			$(this).find('tr.db_list_normal a:has(span.t3-icon-actions-move)').css('opacity', 0).css('pointer-events', 'none');
		}

		/*
		 * Trigger move action after drop event.
		 */
		function onDragStop(e, ui) {
			var $tr = $(ui.item[0]);
			var $prev = $tr.prev();

			var sourceID = $tr.find('span.draggable').data('uid');
			var targetID = $prev.hasClass('c-headLine') ? $tr.find('span.draggable').data('pid') : -$prev.find('span.draggable').data('uid');
			var tokenParam = $tr.find('span.draggable').data('token');

			var table = $tr.find('span.draggable').data('table');

			$.get('tce_db.php?' + 'cmd[' + table + '][' + sourceID + '][move]=' + targetID + tokenParam);
		}
	});
}(TYPO3.jQuery));
