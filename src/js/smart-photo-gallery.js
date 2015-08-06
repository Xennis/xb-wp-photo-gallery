jQuery(function() {
	jQuery('.spg-photozone.sortable').sortable({
		cursor: 'move',
		containment: 'parent',
		items: '> .photo',
		stop: function(event, table) {
			jQuery('.spg-photozone .order').each(function(index) {
				jQuery(this).val(index);
			});
		}
	});
});