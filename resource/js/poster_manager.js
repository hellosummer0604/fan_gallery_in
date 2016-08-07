var Image_adjuster = Class.create({
	initialize: function (selector) {
        this.container = jQuery(selector);
        var tempWidth = this.container.attr('data-width');
        var tempHeight = this.container.attr('data-height');
        if (tempWidth <= 0 || tempHeight <= 0) {
            return;
        }

		this._img_width = tempWidth;
		this._img_height = tempHeight;
        this.container.css('background-image', 'url(' + this.container.attr('data-src') + ')');
		this.resizeEvt;
	},
	_resize_background: function () {
		this._container_width = this.container.width();
		this._container_height = this.container.height();

		var img_ratio = this._img_width / this._img_height;

		var container_ratio = this._container_width / this._container_height;

		if (img_ratio > container_ratio) {//image wider
			var img_height = this._container_height;
			var img_width = Math.round(img_height * img_ratio);
			var top_offset = 0;
			var left_offset = Math.round((img_width - this._container_width) / 2 * -1);
		} else {//image higher
			var img_width = this._container_width;
			var img_height = Math.round(img_width / img_ratio);
			var top_offset = Math.round((img_height - this._container_height) / 2 * -1);
			var left_offset = 0;
		}

		//this.container.html(top_offset);
		this.container.css({
			"background-repeat": "no-repeat",
			"background-size": img_width + "px " + img_height + "px",
			"background-position": left_offset + "px " + top_offset + "px"
		});

	},
	_bind_resize_event: function () {
		if (!GLOBAL_IS_MOBILE) {
			var obj = this;
			jQuery(window).resize(function () {
				clearTimeout(obj.resizeEvt);
				obj.resizeEvt = setTimeout(function () {
					obj._resize_background();
				}, 10);

			});
		}
	},
	activate: function () {
		this._resize_background();
		this._bind_resize_event();
	}

});




