jQuery.fn.endlessPhotoScroll = function(data, options) {
console.log(data);
	var _this = this;
	this.currentIndex = 0;	

	options = jQuery.extend({
		name_prefix: '',
		path: '',
		offset: 0,
		limit: 20
	}, options);

	
	var appendPhoto = function(item) {
		var name_prefix = options.name_prefix+'['+item['id']+']';

		_this.append('<div class="photo">' +
			'<img src="'+options.path+item['file']+'">' +
			'<textarea name="'+name_prefix+'[description]">'+item['description']+'</textarea>' +
			'<div class="options"><span class="dashicons dashicons-location"></span></div>' +
			'<input type="hidden" name="'+name_prefix+'[sequence]" class="order" value="'+item['sequence']+'">' +
		'</div>');
	};
	
	var appendPhotos = function() {
		var endIndex = _this.currentIndex+options.limit;
		if (endIndex >= data.length) {
			endIndex = data.length;
		}

		for(var i=_this.currentIndex; i<endIndex; i++) {
			var item = data[i];
			appendPhoto(item);
		}

		_this.currentIndex = endIndex;		
	};

	jQuery(window).scroll(function() {
		if(jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height()) {
			appendPhotos();
		}
	});
	
	
	appendPhotos();
};