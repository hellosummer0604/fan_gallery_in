var headNav = headNav || {}

//execute after resize
headNav._resizeEvt;

headNav.activate = function () {


	//only index page has poster
	this._enableAdjustOpacity = jQuery(".poster").length > 0 ? true : false;


	if (this._enableAdjustOpacity) {
		jQuery(".headerNavBackground").css({
			"opacity": "0"
		});
	}

	headNav.height = jQuery(".imgNavContainer").height();

	headNav.scrollColor = new Color_scroller();

	headNav.track = headNav._getTrack();

	headNav.liArray = headNav._getLiElementArray();

	headNav._setLinkList();

	headNav._setBodyPosition();

	headNav._bindResizeEvt();

	headNav._bindScrollEvt();

	headNav._bindClickEvt();
}

headNav._adjustOpacity = function () {
	if (this._enableAdjustOpacity) {
		var scrollTop = jQuery(document).scrollTop();

		var opacity = scrollTop / headNav.track;
		opacity = opacity.toPrecision(3);

		if (opacity > 0.9) {
			opacity = 0.9;
		}

		jQuery(".headerNavBackground").css({
			"opacity": opacity
		});
	}
}

headNav._getTrack = function () {
	var prev = jQuery(".imgNavContainerBackground").prev();
	var prevTop = prev.offset().top;
	var prevHeight = prev.outerHeight(true);

	var top = prevTop + prevHeight;


	jQuery(".imgNavContainer").css({
		"top": top
	});


	return top;
}

headNav._setImgNavContainerPosition = function () {
	var flag = headNav.track - headNav.height - jQuery(document).scrollTop();


	if (flag <= 0) {//fix img nav
		jQuery(".imgNavContainer").css({
			"position": "fixed",
			"top": headNav.height,
		});
	} else {//release img nav
		jQuery(".imgNavContainer").css({
			"position": "absolute",
			"top": headNav.track,
		});
	}
}

headNav._setNavColor = function (clear) {
	if (typeof clear == "undefined") {
		var color = headNav.scrollColor.action();
		jQuery(".linkContainer .active").animate({color: color, borderBottom: color}, 0);
	} else {
		jQuery(".linkContainer .active").animate({color: "#666666", borderBottom: "#666666"}, 0);
	}
}

//headNav._setFooterColor = function () {
//	var color = headNav.scrollColor.action();
//	jQuery(".footer").animate({color: color, borderTop: color}, 0);
//}

headNav._bindScrollEvt = function () {

	jQuery(window).scroll(function () {

		headNav._adjustOpacity();

		headNav._setImgNavContainerPosition();

		headNav._setNavColor();
		
//		headNav._setFooterColor();
	});

	///***for ios**/
	//document.addEventListener("touchmove", function() {
	//    headNav._adjustOpacity();
	//
	//    headNav._setImgNavContainerPosition();
	//
	//    headNav._setNavColor();
	//}, false);
}

headNav._setBodyPosition = function () {
	var navHeight = jQuery(".imgNavContainer").height();

	var prev = jQuery(".bodySection").prev().prev().prev();

	var prevTop = prev.offset().top;
	var prevHeight = prev.outerHeight(true);


	jQuery(".bodySection").css({
		"top": prevTop + prevHeight + navHeight
	});
}

headNav._getLiElementArray = function () {
	var elements = jQuery.makeArray(jQuery(".linkContainer li"));

	jQuery(".linkContainer li").each(function () {
		jQuery(this).css({
			"display": "none"
		});
	});

	return elements;
}


headNav._setLinkList = function () {
	var MoreButton = jQuery(".linkContainer li").last();

	var marginLR = 30;

	var windowWidth = jQuery(window).width();

	var containerMaxWidth = windowWidth - marginLR - MoreButton.outerWidth(true);

	var width = 0;

	var num = 0;

	jQuery.each(headNav.liArray, function (key, obj) {
		var ele = jQuery(obj);

		width = width + ele.outerWidth(true);

		if (width < containerMaxWidth) {
			num++;
		} else {
			width = width - ele.outerWidth(true);
			return false;
		}
	});


	jQuery(".linkContainer li").each(function () {
		if (num-- > 1) {
			jQuery(this).css({
				"display": "inline-block"
			});
		} else {
			jQuery(this).css({
				"display": "none"
			});
		}
	});

	//append last button -- More
	MoreButton.css({
		"display": "inline-block"
	});

	jQuery(".linkContainer").css({
		"width": width,
		"left": (windowWidth - width) / 2
	});

}

headNav._bindResizeEvt = function () {
	var obj = this;

	jQuery(window).resize(function () {
		clearTimeout(obj._resizeEvt);
		obj._resizeEvt = setTimeout(function () {
			obj.track = obj._getTrack();

			obj._setLinkList();

			obj._setBodyPosition();

			obj._setImgNavContainerPosition();

		}, 10);
	});

}

headNav._liOnClick = function (obj) {
	headNav._setNavColor("clear");

	jQuery(".linkContainer li").each(function () {
		jQuery(this).removeClass("active");
	});

	obj.addClass("active");

	headNav._setNavColor();
}

headNav._bindClickEvt = function () {
	jQuery(".linkContainer li").each(function () {
		jQuery(this).click(function (e) {
			headNav._liOnClick(jQuery(this));
		});
	});

	//remove last one button  -- More
	jQuery(".linkContainer li").last().off('click');
}