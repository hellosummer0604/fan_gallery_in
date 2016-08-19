var popupBox = popupBox || {}

//execute after resize
popupBox._resizeEvt;

popupBox._BACKGROUND_IMAGE_HEIGHT = -1;
popupBox._BACKGROUND_IMAGE_WIDTH = -1;
popupBox._POPUP_IMG_URL = -1;
popupBox._FADE_TIME = 300;
popupBox._canClose = true;


popupBox.activate = function () {
    if (GLOBAL_IS_MOBILE) {
        popupBox._FADE_TIME = 0;
    }

    popupBox.bindSmallPopup();


    popupBox.bindSwitchSignPopUp();

    popupBox._bindResizeEvt("#popImgBox");
}

popupBox.showPopup = function (target, obj, callback) {

    callback();

    jQuery(function () {

        //basic setting
        jQuery('body').css({
            overflowY: 'hidden',
        });

        jQuery.when(jQuery(target).hide().fadeIn(popupBox._FADE_TIME)).done(function () {
            if (typeof obj == 'undefined') {
                return;
            }

            popupBox._addBlur();

        });
    });

}

popupBox.bindSmallPopup = function () {
    popupBox.bindNavButtons();

    //for remember me checkbox
    popupBox._handleRememberMe();

    popupBox.voidSmallBoxClose();

    popupBox._bindSubmit();
}

popupBox.bindNavButtons = function () {
    jQuery(".loginBtn").off('click').on("click", function (event) {
        event.preventDefault();
        popupBox._showLoginPopup();
    });

    jQuery(".signupBtn").off('click').on("click", function (event) {
        event.preventDefault();
        popupBox._showSignupPopup();
    });

    jQuery("#logoutBtn").off('click').on("click", function (event) {
        event.preventDefault();
        popupBox._logout();
    });
}

popupBox.showImgBoxPopup = function (target, obj) {
    popupBox.showPopup(target, obj, function () {
        ///load img
        var objId = jQuery(obj).find('.hide_cur_id').html();

        popupBox._loadImgdetail(objId);
    });
}

popupBox._showLoginPopup = function () {
    var target = jQuery('#loginBox');
    popupBox.showPopup(target, null, function () {

    });

}

popupBox._showSignupPopup = function () {
    var target = jQuery('#signupBox');
    popupBox.showPopup(target, null, function () {

    });

}

popupBox.voidSmallBoxClose = function () {
    jQuery('.mainBox').off('click').on('click', function (event) {
        event.stopPropagation();
    });
}

popupBox._bindSubmit = function () {
    var btnClicked = jQuery('.btn-smallpop-submit');

    btnClicked.off('click').on('click', function () {
        popupBox._canClose = false;

        var self = this;
        var baseUrl = document.location.origin;
        var targetForm = jQuery(self).closest('form');
        var actionUrl = baseUrl + targetForm.attr("action");

        //disable button
        jQuery(self).prop("disabled", true);
        //loading notice
        popupBox._popupMsgBanner("notice", "Processing...");

        //get all input
        var uploadData = {};
        jQuery("#" + targetForm.attr("id") + " :input").each(function () {
            var temp = jQuery(this);

            if (typeof temp.attr("name") != 'undefined') {
                uploadData[temp.attr("name")] = temp.val();
            }
        });

        jQuery.ajax({
            method: 'POST',
            url: actionUrl,
            data: uploadData,
            dataType: 'json',
            async: 'false',
            success: function (data) {

                switch (jQuery(self).attr('id')) {
                    case "logInBtn":
                        popupBox._login(data);
                        break;
                    case "signUpBtn":
                        popupBox._signUp(data);
                        break;
                    default:

                }
            },
            error: function (data) {
                popupBox._popupMsgBanner("error", "Server error, please retry again.");
            }
        });

        popupBox._canClose = true;
        jQuery(self).prop("disabled", false);
    });
}

//update the nav bar after successful login/signup
popupBox._updateNav = function () {
    var baseUrl = document.location.origin;
    var actionUrl = baseUrl + "/head";

    jQuery.ajax({
        method: 'POST',
        url: actionUrl,
        dataType: 'html',
        async: 'false',
        success: function (data) {
            try {
                data = data.trim();
                if (data.substring(0, 33) != '<div class="headerNavBackground">') {//need rewrite this validate function
                    location.reload();
                }

                var opacityVal = jQuery("#headContainer .headerNavBackground").css("opacity");
                jQuery("#headContainer").html(data);
                jQuery("#headContainer .headerNavBackground").css({
                    opacity: opacityVal
                });

                popupBox.bindNavButtons();
                popupBox._bindAClick();
            }
            catch (err) {
                console.error(JSON.stringify(err));
                console.error(JSON.stringify(data));
                location.reload();
            }
        },
        error: function (data) {
            console.error(JSON.stringify(data));
            location.reload();
        }
    });
}

popupBox._signUp = function (data) {
    if (data.result) {
        popupBox._updateNav();
        popupBox._hideSmallPopup();
    } else {
        popupBox._popupMsgBanner("warning", data.msg);
    }
}

popupBox._login = function (data) {
    if (data.result) {
        popupBox._updateNav();
        popupBox._hideSmallPopup();
    } else {
        popupBox._popupMsgBanner("warning", data.msg);
    }
}

popupBox._logout = function (data) {
    var baseUrl = document.location.origin;
    var actionUrl = baseUrl + "/logout";

    jQuery.ajax({
        method: 'POST',
        url: actionUrl,
        dataType: 'html',
        async: 'false',
        success: function (data) {
            popupBox._updateNav();
        },
        error: function (data) {
            console.error(JSON.stringify(data));
            location.reload();
        }
    });
}


popupBox._handleRememberMe = function () {
    jQuery("#remembermeChk").click(function () {
        var checkbox = jQuery("input[name=rememberme]");
        if (checkbox.prop("checked")) {
            checkbox.prop("checked", false);
            checkbox.val(false);
        } else {
            checkbox.prop("checked", true);
            checkbox.val(true);
        }
    });
}

popupBox._popupMsgBanner = function (type, msg) {
    if (typeof type == 'undefined') {
        type = "close";
    }

    if (typeof msg == 'undefined') {
        msg = type;
    }

    var className = "ajaxNotice";
    var banner = jQuery("." + className);
    banner.removeClass();
    banner.html('');
    banner.addClass(className);

    switch (type) {
        case "notice":
        case "warning":
        case "success":
        case "error":
            banner.html(msg);
            banner.addClass(type);
            banner.fadeIn(popupBox._FADE_TIME);
            break;
        default:
            banner.hide();
            break;
    }
}

//clear all input in smallbox
popupBox._clearInput = function () {
    jQuery(".smallPopup input:text, .smallPopup input:password").each(function () {
        jQuery(this).val("");
    });
}
//popupBox.hideSignPopup = function (targetArray) {
//	popupBox.hidePopup(targetArray, function() {
//		///clear
//		popupBox._clearImgdetail();
//	});
//}

popupBox.bindSwitchSignPopUp = function () {
    var target = null;

    jQuery('a[href="switchtosignin"]').off('click').on('click', function (event) {
        event.preventDefault();

        target = jQuery('#signupBox');

        popupBox._hideSmallPopup();

        popupBox.showPopup(target, null, function () {
        });
    });

    jQuery('a[href="switchtosignup"]').off('click').on('click', function (event) {
        event.preventDefault();

        target = jQuery('#loginBox');

        popupBox._hideSmallPopup();

        popupBox.showPopup(target, null, function () {
        });
    });

    if (target == null) {
        return;
    }


}

popupBox._hideSmallPopup = function () {
    popupBox.hideImgBoxPopup(['.smallPopup']);
}

popupBox.hidePopup = function (targetArray, callback) {

    popupBox._removeBlur();
    //basic setting
    targetArray.forEach(function (entry) {
        var target = jQuery(entry);

        if (target.is(":visible")) {


            jQuery.when(target.fadeOut(popupBox._FADE_TIME)).done(function () {

                jQuery('body').css({
                    overflowY: 'scroll',
                    overflowX: 'auto',
                });

                callback();

            });
        }
    });


}

popupBox.hideImgBoxPopup = function (targetArray) {
    popupBox.hidePopup(targetArray, function () {
        ///clear
        popupBox._clearImgdetail();
        popupBox._clearInput();

        popupBox._popupMsgBanner('close');

        popupBox._resetGenericPopup();
    });
}


popupBox._loadImgdetail = function (imgId) {
    if (typeof imgId == 'undefined') {
        console.error('loading img  ' + JSON.stringify(imgId) + ' fail: ');
        //show error and closepopup
        popupBox._loadError();
        return;
    }

    var imgId = {'imgId': imgId};

    jQuery.ajax({
        method: 'POST',
        url: 'http://north.gallery/ajax_controller/getImgDetail',
        data: imgId,
        dataType: 'json',
        success: function (resObj) {
            if (resObj == null) {
                console.error('loading img  ' + JSON.stringify(imgId) + ' fail: ');
                //show error and closepopup
                popupBox._loadError();
                return;
            }

            //success
            //set backgorund image size
            popupBox._BACKGROUND_IMAGE_HEIGHT = resObj['data']['orgHeight'];
            popupBox._BACKGROUND_IMAGE_WIDTH = resObj['data']['orgWidth'];

            popupBox._displayImgdetail(resObj);
        },
        error: function (errorMsg) {
            //show error and closepopup
            popupBox._loadError();
            console.error('loading img  ' + imgId + ' fail: ' + JSON.stringify(errorMsg));
        }
    });

}

popupBox._displayImgdetail = function (data) {
    //display image
    var imgUrl = data['data']['path'];
    //global id, avoid img load sequence error
    popupBox._POPUP_IMG_URL = imgUrl;

    var container = "#popImgBox";


    if (popupBox.isEditPopup()) {
        jQuery('#imgTitle >input').val('asdasd');
    } else {
        jQuery('.mainBox > #imgTitle').html("我就是图片标题怎么了");
    }

    jQuery('#imgBox > #authorBox').html("North Fan<br>2016-01-12");

    jQuery('.innerBox > #imgTags').html("<div class='itag'><a href='#'>Drink</a></div><div class='itag'><a href='#'>Smoothy</a></div><div class='itag'><a href='#'>Interior</a></div><div class='itag'><a href='#'>Light</a></div><div class='itag'><a href='#'>Night</a></div>");


    if (popupBox.isEditPopup()) {
        jQuery('#imgText > textarea').css('overflow', 'hidden').autogrow();
    } else {
        jQuery('#popImgText > #imgText').html("微软推出了诺基亚230，这款只要399元的手机采用了铝制机身，不仅双卡双待，而且一次充电待机长达22天，这款手机于1月19日正式开卖。其实不只是在船上。一切封闭的场所，最后都会导致这种文明准则丧失、大家弱肉强食的事。历史上的围城战，人相食者有多少？历史上的大饥荒，村子里互相杀戮的有多少？海难则争夺食物，雪灾则互相撕咬。");
    }

    jQuery('<img/>').attr('src', imgUrl).load(function () {
        jQuery(this).remove(); // prevent memory leaks as @benweet suggested

        if (popupBox._POPUP_IMG_URL == imgUrl) {

            jQuery(container).css({
                'background-image': "url(" + imgUrl + ")",
            });
            popupBox._setPopImgBoxHeight(container);


            jQuery(container).removeClass("loadingBg");
            jQuery(container).addClass("displayBg");

            //jQuery(container).fadeIn(200);
            jQuery(function () {
                //jQuery(container).hide().fadeIn(popupBox._FADE_TIME);
                jQuery(container).hide().show();
            });
        }

    });
    //display text
}


popupBox._loadError = function () {
    setTimeout(function () {
        popupBox.hideImgBoxPopup(['#imgBox', '#uploadBox', '.smallPopup', '#genericBox']);
    }, 1000);

}


popupBox._clearImgdetail = function () {

    //clear imgBox
    var container = "#popImgBox";

    jQuery(container).css({
        'background-image': "url(http://" + window.location.hostname + "/resource/loader2.gif)",
        //'background-image': "none",
        'height': "500px",
    });

    jQuery(container).removeClass("displayBg");
    jQuery(container).addClass("loadingBg");

    popupBox._BACKGROUND_IMAGE_HEIGHT = -1;
    popupBox._BACKGROUND_IMAGE_WIDTH = -1;


    //CLEAR TEXT HERE

    if (popupBox.isEditPopup()) {
        jQuery('#imgTitle >input').val('');
    } else {
        jQuery('.mainBox > #imgTitle').html("");
    }

    jQuery('#imgBox > #authorBox').html("");

    if (popupBox.isEditPopup()) {
        jQuery('#imgText > textarea').css('overflow', 'hidden');
        jQuery('#imgText > textarea').css('height', '220px').autogrow();
        jQuery('#imgText > textarea').val('');
    } else {
        jQuery('#popImgText > #imgText').html("");
    }


}

popupBox.isEditPopup = function () {
    if (typeof popupBoxEdit == "undefined") {
        return false;
    } else {
        return true;
    }
}


popupBox.bindCloseAction = function (func) {
    if (!popupBox._canClose) {
        return;
    }

    jQuery(document).keyup(function (e) {
        if (e.keyCode === 27) {
            func();
        }
    });


    jQuery('.popupImg').off('click').on('click', function (event) {
        event.stopPropagation();
    });

    //for mobile phone, click image to close
    jQuery('#popImgBox').off('click').on('click', function (event) {
        if (jQuery(window).width() < 512 && !popupBox.isEditPopup()) {
            func();
        } else {
            event.stopPropagation();
        }
    });

    jQuery('.baseLayer').off('click').on('click', function (event) {
        func();
    });

    //for smallPopup, if click on cancel
    jQuery('.btn-smallpop-cancel').off('click').on('click', function (event) {
        func();
    });
}


popupBox.unbindCloseAction = function () {
    jQuery(document).unbind('keyup');
}

popupBox._setPopImgBoxHeight = function (container) {
    var height = popupBox._BACKGROUND_IMAGE_HEIGHT;
    var width = popupBox._BACKGROUND_IMAGE_WIDTH;

    if (height > 0 && width > 0) {
        var containerWidth = jQuery(container).width();

        var container_height = Math.round(height * containerWidth / width);

        jQuery(container).css({
            'height': container_height + "px",
        });
    }


}

popupBox._bindResizeEvt = function (container) {
    var obj = this;
    if (!GLOBAL_IS_MOBILE) {
        jQuery(window).resize(function () {
            clearTimeout(obj._resizeEvt);
            obj._resizeEvt = setTimeout(function () {
                popupBox._setPopImgBoxHeight(container);
            }, 10);
        });
    }
}

popupBox._addBlur = function () {
    if (GLOBAL_IS_MOBILE) {
        return true;
    }

    jQuery("section").each(function () {
        jQuery(this).addClass('blurred');
    });

    jQuery("nav").each(function () {
        jQuery(this).addClass('blurred');
    });

    jQuery(".headerNavBackground").addClass('blurred');
}

popupBox._removeBlur = function () {
    jQuery("section").each(function () {
        jQuery(this).removeClass('blurred');
    });

    jQuery("nav").each(function () {
        jQuery(this).removeClass('blurred');
    });

    jQuery(".headerNavBackground").removeClass('blurred');
}


/************************* start generic popup box ****************************/
popupBox._bindAClick = function () {
    jQuery("a").each(function () {
        var popupView = jQuery(this).attr('data-popup-view');
        var popupStyle = jQuery(this).attr('data-popup-style');

        if (typeof popupView !== typeof undefined && popupView !== false) {

            jQuery(this).off('click').on("click", function (event) {
                event.preventDefault();
                popupBox._loadPopupView(popupView, popupStyle);
            });
        }
    });
}

popupBox._loadPopupView = function (viewUrl, className) {
    //default loading popup
    popupBox._showGenericPopup();

    //start loading popup
    var viewUrl = document.location.origin + viewUrl;

    jQuery('#genericBox .mainBox').load(viewUrl, function (responseTxt, statusTxt, xhr) {
        //todo callback function needs to be rewritten
        if (statusTxt == "success") {
            if (typeof className != 'undefined') {
                jQuery('#genericBox .mainBox').removeClass('defaultBox').addClass(className);
            }

            console.log("External content loaded successfully!");
        }

        if (statusTxt == "error") {
            popupBox._resetGenericPopup();

            console.error("Error: " + xhr.status + ": " + xhr.statusText);
        }
    });
}

popupBox._showGenericPopup = function() {
    var target = jQuery('#genericBox');

    popupBox.showPopup(target, null, function () {

    });
}

popupBox._resetGenericPopup = function() {
    jQuery('#genericBox .mainBox').removeClass().addClass('mainBox').addClass('defaultBox');
    jQuery('#genericBox .mainBox').html();
}

/************************* end generic popup box ****************************/