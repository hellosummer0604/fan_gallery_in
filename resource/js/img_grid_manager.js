var Img_Grid_Manager = Img_Grid_Manager || {}

Img_Grid_Manager._resizeEvt;

Img_Grid_Manager.canLoad = true;

Img_Grid_Manager.sectionList = [];

Img_Grid_Manager.default = function () {

}

Img_Grid_Manager.activate = function () {
	//dont init too early
	Img_Grid_Manager.grid_handler = new ImgGrid();

	Img_Grid_Manager._bindMoreGroup();
	//test one section

//
//	imgGridManager._renderImgGroup(data);
//
//	imgGridManager.resizeWindow();
	Img_Grid_Manager.bindResizeWindow();
}

Img_Grid_Manager.loadImgSection = function (sid, page) {
	if (typeof page == 'undefined') {
		page = 0;
	}

    var userId = Init.router('user');

    if (userId == null) {
        window.location.href = document.location.origin;
    }

    var sectionInfo = {'sectionId': sid};

    Img_Grid_Manager.canLoad = false;

    jQuery.ajax({
        method: 'POST',
        // url: 'http://north.gallery/user/' + userId + '/tag/' + sid + '/page/' + page,
        url: document.location.origin + '/user/' + userId + '/tag/' + sid + '/page/' + page,
        data: sectionInfo,
        dataType: 'json',
        async: 'false',
        success: function (section) {
            console.log('frist loading image section ' + sid);
            if (section != null && section.id != null && section.loadingList != null) {
                Init.setCurrentPage(page);
                Init.setCurrentSection(sid);

                Img_Grid_Manager.removeImgSection();

                Img_Grid_Manager.sectionList[section.id] = section;

                //add first group
                Img_Grid_Manager._addImgGroup(sid);

                Img_Grid_Manager._setPagination(section.pagination);
            }

            Img_Grid_Manager.canLoad = true;
        },
        error: function (section) {
            console.error('loading img section ' + sid + ' fail: ' + JSON.stringify(section));
            Img_Grid_Manager.canLoad = true;
        }
    });
}

//move one img group from waiting list to loading list
Img_Grid_Manager._addImgGroup = function (sid) {
	var insertPosition = jQuery("#" + sid + " > .beforeThis");

	//it is reference
	var waitingList = Img_Grid_Manager.sectionList[sid]['waitingList'];
	var loadingList = Img_Grid_Manager.sectionList[sid]['loadingList'];

	//move group from waiting list to loading list
	//add div for group
	for (var key in waitingList) {
		console.log("loading "+ key);
		if (waitingList.hasOwnProperty(key)) {
			//pick one group
			var temp_group = waitingList[key];

			//move to loading list
			loadingList.push(temp_group);

			//remove from waiting list
			delete waitingList[key];

			//add new div for group
			jQuery("<div class=\"imgGroup\" id=\"" + temp_group.id + "\">" + temp_group.id + 'asdasda' + "</div>").insertBefore(insertPosition);

//			console.log("add group" + temp_group.id);


			//render new groups
			Img_Grid_Manager._renderGroup(temp_group);

//			console.log(JSON.stringify(Img_Grid_Manager.sectionList[sid]));

		}

		break;
	}


}

//add new group by click
//Img_Grid_Manager._bindMoreGroup = function () {
//	jQuery(".moreGroup").each(function () {
//		var obj = this;
//		jQuery(obj).click(function () {
//			var sectionId = jQuery(obj).parent().attr('id');
//
//			Img_Grid_Manager._addImgGroup(sectionId);
//		});
//	});
//}

Img_Grid_Manager._bindMoreGroup = function () {

	jQuery(window).scroll(function () {
		var sectionLoadId = null
		jQuery(".moreGroup").each(function () {
			var obj = this;
			var sectionId = jQuery(obj).parent().attr('id');
			var display = jQuery('#' + sectionId).css('display');
			if (display == 'block') {
				sectionLoadId = sectionId;
			}
		});
		
		//auto load by visibility of paging block 
		var needLoad = false;
		
		var pagingBlockToTop = jQuery('#' + sectionLoadId + " > .moreGroup").offset().top;
		var windowScroll = jQuery(window).scrollTop();
		var windowSize = jQuery(window).height();
		
		
		if (pagingBlockToTop - windowScroll < windowSize) {
			needLoad = true;
		}
		
		if (needLoad && Img_Grid_Manager.canLoad && sectionLoadId != null) {
			Img_Grid_Manager._addImgGroup(sectionLoadId);
		}
		

		
	});
}






Img_Grid_Manager._renderGroup = function (gid) {
//	console.log("render group " + JSON.stringify(gid) + " need to impl");

	var gridHandler = Img_Grid_Manager.grid_handler;

	gridHandler.setImgArray(gid);

	gridHandler.renderImgGroup();
}

//render all groups inside loadingList
Img_Grid_Manager._renderLoadingList = function (sid) {
	if (typeof Img_Grid_Manager.sectionList[sid] == "undefined") {
		return;
	}

	var groupList = Img_Grid_Manager.sectionList[sid]['loadingList'];

	jQuery.each(groupList, function (index, obj) {
		Img_Grid_Manager._renderGroup(obj);
	});
}

//render visible section when resize
Img_Grid_Manager._renderVisibleSection = function () {
	var sectionId = null;

	jQuery(".imgSection").each(function () {
		var temp_obj = this;
		if (jQuery(temp_obj).css('display') == "block") {
			sectionId = jQuery(temp_obj).attr("id");
		}
	});

	Img_Grid_Manager._renderLoadingList(sectionId);
}

//clear this section, for paging
Img_Grid_Manager.removeImgSection = function () {
    //clear old img section
    jQuery('.imgGroup').remove();
}

//
Img_Grid_Manager.changePage = function (page) {
	Img_Grid_Manager.loadImgSection(Init.getCurrentSection(), page);
}


/**
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
Img_Grid_Manager.loadImg = function () {

}

Img_Grid_Manager.bindResizeWindow = function () {

	if (!GLOBAL_IS_MOBILE) {
		jQuery(window).resize(function () {
			clearTimeout(Img_Grid_Manager._resizeEvt);
			Img_Grid_Manager._resizeEvt = setTimeout(function () {
				Img_Grid_Manager._renderVisibleSection();
			}, 10);
		});
	}

}

Img_Grid_Manager._refreshCurrentImgList = function() {
    Img_Grid_Manager.loadImgSection(Init.getCurrentSection(), Init.getCurrentPage());
}


Img_Grid_Manager._setPagination = function(pagination) {
    //max number of page buttons is MAX_NEIGHBOR_PAGE_BUTTON * 2 + 1
    var PAGE_BUTTON_RADIUS = 4;

    if (typeof pagination == 'undefined') {
        return;
    }

    // jQuery('.pagingBanner.moreGroup').html('');

    var pages = pagination.pages;
    var current = pagination.current;
    var pageNo = parseInt(current) + 1;

    var left = pageNo - PAGE_BUTTON_RADIUS;
    var right = pageNo + PAGE_BUTTON_RADIUS;

    var validLeft = left;
    var validRight = right;

    if (left < 1) {
        validRight = right + (1 - left);
    }

    if (right > pages) {
        validLeft = left - (right - pages);
    }

    validRight = (validRight <= pages) ? validRight : pages;
    validLeft = (validLeft >= 1) ? validLeft : 1;

    var htmlStr = "<a href=\"#\" class=\"start\">First</a>";

    for(var i = validLeft; i <= validRight; i++) {
        if (i == pageNo) {
            htmlStr += "<a class=\"active\" href=\"#\">" + i + "</a>";
        } else {
            htmlStr += "<a href=\"#\">" + i + "</a>";
        }
    }

    htmlStr += "<a href=\"#\" class=\"end\">Last</a>";

    if (pages > 1) {
        jQuery('.pagingBanner.moreGroup:visible').html(htmlStr);
    } else {
        jQuery('.pagingBanner.moreGroup:visible').empty();
    }


    jQuery('.pagingBanner.moreGroup:visible').find('a').each(function () {
        var pageNo = jQuery(this).html();

        if (pageNo == 'First') {
            pageNo = 1;
        }

        if (pageNo == 'Last') {
            pageNo = pages;
        }

        jQuery(this).off('click').on('click', function(event) {
            event.preventDefault();

            Img_Grid_Manager.changePage(pageNo - 1);
        });
    });
}