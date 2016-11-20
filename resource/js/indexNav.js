var headNav = headNav || {}

//execute after resize
headNav._resizeEvt;

headNav.activate = function () {

//	headNav.loadNavItem();

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

	headNav._setFirstCateActive();

    headNav._bindMorePanelTriggered();
}


headNav._adjustOpacity = function () {
	if (this._enableAdjustOpacity) {
		var scrollTop = jQuery(document).scrollTop();

		var opacity = scrollTop / headNav.track;
		opacity = opacity.toPrecision(3);


		jQuery(".headerNavBackground").css({
			"opacity": (opacity > 0.9 ? 0.9 : opacity)
		});
	}
}

headNav._getTrack = function () {
	var prev = jQuery(".imgNavContainerBackground").prev();
	//console.log(prev);
	var prevTop = prev.offset().top;
	var prevHeight = prev.outerHeight(true);

	var top = prevTop + prevHeight;


	jQuery(".imgNavContainer").css({
		"top": top
	});


	return top;
}

headNav._setImgNavContainerPosition = function () {
	var flag = headNav.track - headNav.height - jQuery(window).scrollTop();


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
    var width = 0;
    var num = 0;
    var marginLR = 20;
    var numThreshold = 0;


	var MoreButton = jQuery("#moreBtn");

    var MoreButtonWidth = 0;

    if(MoreButton.length) {
        MoreButtonWidth = MoreButton.outerWidth(true);
        numThreshold = 1; //leave a space for moreBtn
    }


	var windowWidth = jQuery(window).width();

	var containerMaxWidth = windowWidth - marginLR - MoreButtonWidth;

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
		if (num-- > numThreshold) {
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

    headNav._setMorePanelPos();
}

headNav._bindResizeEvt = function () {
	var obj = this;

	if (!GLOBAL_IS_MOBILE) {
		jQuery(window).resize(function () {
			clearTimeout(obj._resizeEvt);
			obj._resizeEvt = setTimeout(function () {
				obj.track = obj._getTrack();
				
				//console.log(obj.track);

				obj._setLinkList();

				obj._setBodyPosition();

				obj._setImgNavContainerPosition();

			}, 10);
		});
	}

}

headNav._setFirstCateActive = function () {
    var tagId = Init.router('tag');

    if (tagId !== null) {
        var sectionId = 'nav_' + tagId;
        var obj = jQuery('#' + sectionId);
    }

    if (typeof obj == 'undefined' || obj.length == 0) {
        var sectionInMore = headNav._loadSectionInMore(tagId);

        if (sectionInMore) {
            //already loaded, exit.
            return;
        } else {
            obj = jQuery('.nav_li:first');
        }
    }

	if (obj.length > 0) {
		headNav._setActive(obj);
	}
}

headNav._loadSectionInMore = function (tagId) {
    var data = headNav._loadMoreTags();

    if (data == null || data.data.length < 1) {
        return false;
    }

    var exist = false;

    jQuery(data.data).each(function () {
        if (this.id == tagId) {
            exist = true;
        }
    });

    if (!exist) {
        return false;
    }

    headNav._updateUrl(tagId);

    Img_Grid_Manager.loadImgSection(tagId, 0);

    jQuery('#moreBtn').addClass('active');

    return true;
}

headNav._setUrl = function (navObj) {

    if (typeof navObj == 'undefined') {
        return;
    }

    var tagId = navObj.attr('id');
    tagId = tagId.substring(4);

    var newUrl = "";
    var userId = Init.router('user');

    if (userId !== null) {
        newUrl = document.location.origin + '/user/' + userId + '/tag/' + tagId;
        history.pushState(null, null, newUrl);
    }
}

headNav._setActive = function (obj) {
    //update browser url
    headNav._setUrl(obj);

    obj.addClass("active");
	var activeSectionId = obj.attr('id').substr(4);

	//load img section
	Img_Grid_Manager.loadImgSection(activeSectionId, 0);


}

headNav._setDeactive = function () {
	jQuery(".linkContainer li").each(function () {
		jQuery(this).removeClass("active");
	});
}

headNav._liOnClick = function (obj) {
	headNav._setNavColor("clear");

	headNav._setDeactive();

	headNav._setActive(obj);

	headNav._setNavColor();

    headNav._clearMorePanelTags();
}

//todo need modify
headNav._bindClickEvt = function () {
	jQuery(".linkContainer .nav_li").each(function () {

		jQuery(this).off('click').on('click', function(e) {
			headNav._liOnClick(jQuery(this));              //todo
		});

	});

	//remove last one button  -- More
//	jQuery(".linkContainer ").last().off('click');
}

headNav._setMorePanelPos = function () {
    var trigger = jQuery('[data-jq-dropdown="#jq-dropdown-more"]');
    var jDropDown = jQuery('#jq-dropdown-more');

    if (typeof trigger.attr('id') == 'undefined' || typeof jDropDown.attr('id') == 'undefined') {
        return;
    }

    var right = jQuery(window).width() - trigger.offset().left - 249;

    if (right < 6) {
        right = 6;
    }

    if (right + jDropDown.width() >= jQuery(window).width()) {
        right = 0;
    }


    jDropDown.css({
        right: right + 'px'
    });
}

//todo need to be modified
headNav._bindMorePanelTriggered = function () {
    var trigger = jQuery('[data-jq-dropdown="#jq-dropdown-more"]');
    var jDropDown = jQuery('#jq-dropdown-more');

    trigger.off('click').on("click", function(event) {
        headNav._setMorePanelPos();

        headNav._composeMoreTags();
    });

    jDropDown.css({
        top: '50px'
    });
}

//
headNav._loadMoreTags = function () {
    var result = null;

    var userUrl = document.location.origin + '/user/' + Init.router('user');
    jQuery.ajax({
        method: 'GET',
        url: userUrl + '/tags',
        dataType: 'json',
        async: false,
        success: function (data) {
            result = data;
        },
        error: function (data) {
            console.error('cannot load more tags '+ JSON.stringify(data));
        }
    });

    return result;
}

headNav._composeMoreTags = function () {
    var data = headNav._loadMoreTags();

    if (data !== null && data.data.length > 0) {
        //clear the panel
        headNav._clearMorePanelTags();

        var htmlStr = "";

        for(var i = 0; i < data.data.length; i++) {
            var tmpStr = "<td id='more_nav_" + data.data[i].id + "'><a href=\"" + data.data[i].id + "\">" + data.data[i].name + "</a></td>";

            if (i == 0) {
                tmpStr = "<tr>" + tmpStr;
            } else if (i % 2 == 0) {
                tmpStr = "</tr><tr>" + tmpStr;
            }

            if (i == data.data.length - 1) {
                tmpStr = tmpStr + "</tr>";
            }

            htmlStr = htmlStr + tmpStr;
        }

        jQuery('#jq-dropdown-more tr:last').after(htmlStr);
        //bind panel tags click event
        headNav._bindMorePanelTagTriggered();

        var sid = Init.router('tag');

        if (sid !== null) {
            jQuery('#more_nav_' + sid).addClass('active');
        }

    } else {
        jQuery('#jq-dropdown-more tr:last').html('no data');
    }
}

headNav._bindMorePanelTagTriggered = function () {
    jQuery('#jq-dropdown-more').find('td').find('a').each(function () {
        var obj = this;
        var currentTd = jQuery(obj).closest('td');

        jQuery(currentTd).off('click').on('click', function (event) {
            event.preventDefault();

            var sid = jQuery(obj).attr("href");

            headNav._morePanelTagClicked(sid);
        });
    });
}

headNav._morePanelTagClicked = function (sid) {
    headNav._updateUrl(sid);

    headNav._setNavColor("clear");

    headNav._setDeactive();

    headNav._clearMorePanelTagActive();

    // obj.addClass('active');

    jQuery('#moreBtn').addClass('active');

    Img_Grid_Manager.loadImgSection(sid, 0);
}

headNav._updateUrl = function (sid) {
    var userId = Init.router('user');

    if (userId !== null) {
        var newUrl = document.location.origin + '/user/' + userId + '/tag/' + sid;
        history.pushState(null, null, newUrl);
    }
}

headNav._clearMorePanelTagActive = function () {
    jQuery('#moreBtn').removeClass('active');

    jQuery('#jq-dropdown-more').find('.active').each(function () {
        jQuery(this).removeClass('active');
    });

}

headNav._clearMorePanelTags = function () {
    jQuery("#jq-dropdown-more").find("tr:gt(1)").remove();
}