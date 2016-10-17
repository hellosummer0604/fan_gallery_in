var popupBox = popupBox || {}

//execute after resize
popupBox._resizeEvt;

popupBox._POPBOX_DIV_ID = '#imgBox';
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

popupBox.showImgBoxPopup = function (obj, target) {
    var objId = jQuery(obj).find('.hide_cur_id').html();

    popupBox._loadImgdetail(objId, target);


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
console_test(actionUrl);
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
popupBox._updateNav = function () {//
    var baseUrl = document.location.origin;
    var actionUrl = baseUrl + "/component/head";

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
        Init.setLoggedIn(data.data.id);
    } else {
        popupBox._popupMsgBanner("warning", data);
    }
}

popupBox._login = function (data) {
    if (data.result) {
        popupBox._updateNav();
        popupBox._hideSmallPopup();
        Init.setLoggedIn(data.data.id);
    } else {
        popupBox._popupMsgBanner("warning", data);
    }
}

popupBox._logout = function (data) {
    var baseUrl = document.location.origin;
    var actionUrl = baseUrl + "/account/logout";

    jQuery.ajax({
        method: 'POST',
        url: actionUrl,
        dataType: 'html',
        async: 'false',
        success: function (data) {
            Init.setLoggedOut();
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

popupBox._popupMsgBanner = function (type, data) {
    var msg = "";

    if (typeof type == 'undefined') {
        type = "close";
    }

    if (typeof data == 'undefined') {
        msg = type;
    } else if (typeof data == 'string') {
        msg = data;
    } else {
        msg = data.errorMsg;
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
    //basic setting
    targetArray.forEach(function (entry) {
        var target = jQuery(entry);

        if (target.is(":visible") && !target.data("disableClose")) {

            popupBox._removeBlur();

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

popupBox._loadImgdetail = function (imgId, target) {
    if (typeof imgId == 'undefined') {
        //show error and closepopup
        popupBox._loadError();
        return;
    }

    var url = document.location.origin + "/component/" + target + '/' + imgId;

    jQuery.ajax({
        method: 'POST',
        url: url,
        dataType: 'json',
        success: function (resObj) {
            if (resObj == null || typeof resObj == 'undefined') {
                popupBox._loadError();
                return;
            }

            //update html of div#imgBox
            jQuery(popupBox._POPBOX_DIV_ID).replaceWith(resObj['html']);

            //set backgorund image size
            popupBox._BACKGROUND_IMAGE_HEIGHT = resObj['imgInfo']['orgHeight'];
            popupBox._BACKGROUND_IMAGE_WIDTH = resObj['imgInfo']['orgWidth'];

            popupBox._displayImgdetail(resObj['imgInfo']);

            popupBox._bindEditSubmit();

            popupBox.bindCloseAction(function () {
                popupBox.hideImgBoxPopup(['#imgBox']);
            });
        },
        error: function (errorMsg) {
            popupBox._loadError();
            console.error('loading img  ' + imgId + ' fail: ' + JSON.stringify(errorMsg));
        }
    });

}

popupBox._displayImgdetail = function (data) {
    //display image
    var imgUrl = data['path'];
    //global id, avoid img load sequence error
    popupBox._POPUP_IMG_URL = imgUrl;

    var container = "#popImgBox";

    if (jQuery('#imgText > #imgDescription').length) {
        jQuery('#imgText > textarea').css('overflow', 'hidden').autogrow();
    }

    popupBox.showPopup(popupBox._POPBOX_DIV_ID, null, function () {

    });


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
        console.error('Error: cannot open this popup');
        popupBox.hideImgBoxPopup(['#imgBox', '#uploadBox', '.smallPopup', '#genericBox']);
    }, 1000);

}


popupBox._clearImgdetail = function () {
    jQuery(popupBox._POPBOX_DIV_ID).replaceWith('<div id="imgBox"></div>');
}

popupBox.isEditPopup = function () {
    if (jQuery('.isImgBoxEdit').length) {
        return true;
    } else {
        return false;
    }
}

popupBox.submitEditPopup = function () {
    var imageId = jQuery('#imgId').val();
    var data = {
        title: jQuery('#imgTitle').val(),
        desc: jQuery('#imgDescription').val()
    };

    jQuery.ajax({
        method: 'POST',
        url: document.location.origin + '/image/' + imageId + '/edit',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (data.result) {
                //set title of thumb
                jQuery('#thumb_title_' + imageId).html(data.data.title);
                //close popup
                popupBox.hideImgBoxPopup(['#imgBox']);
            }


        },
        error: function (data) {
            console.error('Updating img fail: ' + JSON.stringify(data));
//todo
        }
    });
}

popupBox._bindEditSubmit = function () {
    jQuery('#btn-img-edit-submit').off('click').on('click', function (event) {
        popupBox.submitEditPopup();
    });
}

//bind all close actions
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
        if (!popupBox.isEditPopup()) {
            func();
        } else {
            event.stopPropagation();
        }
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

popupBox._showGenericPopup = function () {
    var target = jQuery('#genericBox');

    popupBox.showPopup(target, null, function () {

    });
}

popupBox._resetGenericPopup = function () {
    var mainBox = jQuery('#genericBox .mainBox');
    mainBox.removeClass().addClass('mainBox').addClass('defaultBox');
    mainBox.html();
}

/************************* end generic popup box ****************************/