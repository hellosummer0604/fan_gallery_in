var popupBox = popupBox || {}

//execute after resize
popupBox._resizeEvt;

popupBox._BACKGROUND_IMAGE_HEIGHT = -1;
popupBox._BACKGROUND_IMAGE_WIDTH = -1;

popupBox.activate = function () {
	jQuery("#upload").click(function () {
		popupBox.showPopup("#uploadBox");
	});

	popupBox._bindResizeEvt();
}

popupBox.showPopup = function (target, obj) {
	//basic setting
	jQuery(target).fadeIn(200);

	jQuery('body').css({
		overflow: 'hidden',
	});

	jQuery('html').css({
		overflow: 'hidden',
	});

	if (typeof obj == 'undefined') {
		return;
	}
	///load img
	var objId = jQuery(obj).find('.hide_cur_id').html();

	popupBox._loadImgdetail(objId);



}

popupBox.hidePopup = function (targetArray) {
	//basic setting
	targetArray.forEach(function (entry) {
		jQuery(entry).fadeOut(200);
	});

	jQuery('body').css({
		overflow: 'auto',
	});

	jQuery('html').css({
		overflow: 'auto',
	});

	///clear 
	popupBox._clearImgdetail();
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

	var container = "#popImgBox";

	jQuery('<img/>').attr('src', imgUrl).load(function () {
		jQuery(this).remove(); // prevent memory leaks as @benweet suggested
		jQuery(container).css({
			'background-image': "url(" + imgUrl + ")",
		});
		popupBox._setPopImgBoxHeight();

		jQuery(container).fadeIn(200);
	});

	//display image info
	console.log('test');
	if (jQuery('#imgTitle > input').length > 0)  {
		jQuery('#imgTitle >input').val('asdasd');
	} else {
		jQuery('.baseLayer > #imgTitle').html("我就是图片标题怎么了");
	}
	
	jQuery('#imgBox > #authorBox').html("North Fan<br>2016-01-12");
	
	jQuery('#popImgText > #imgTags').html("<div><a href='#'>Drink</a></div><div><a href='#'>Smoothy</a></div><div><a href='#'>Interior</a></div><div><a href='#'>Light</a></div><div><a href='#'>Night</a></div>");
	
	
	if (jQuery('#imgText  textarea').length > 0) {
		jQuery('#imgText > textarea').css('overflow', 'hidden').autogrow();
	} else {
		jQuery('#popImgText > #imgText').html("微软推出了诺基亚230，这款只要399元的手机采用了铝制机身，不仅双卡双待，而且一次充电待机长达22天，这款手机于1月19日正式开卖。其实不只是在船上。一切封闭的场所，最后都会导致这种文明准则丧失、大家弱肉强食的事。历史上的围城战，人相食者有多少？历史上的大饥荒，村子里互相杀戮的有多少？海难则争夺食物，雪灾则互相撕咬。");
	}


	//display text
}



popupBox._loadError = function () {
	setTimeout(function () {
		popupBox.hidePopup(['#imgBox', '#uploadBox']);
	}, 1000);

}

popupBox._clearImgdetail = function () {
	//clear imgBox
	var container = "#popImgBox";

	jQuery(container).css({
//		'background-image': "url(../img/loading.gif)",
		'background-image': "none",
		'height': "500px",
	});

	popupBox._BACKGROUND_IMAGE_HEIGHT = -1;
	popupBox._BACKGROUND_IMAGE_WIDTH = -1;


	//CLEAR TEXT HERE
	
	if (jQuery('#imgTitle > input').length > 0)  {
		jQuery('#imgTitle >input').val('');
	} else {
		jQuery('.baseLayer > #imgTitle').html("");
	}
	
	jQuery('#imgBox > #authorBox').html("");
	
	if (jQuery('#imgText  textarea').length > 0) {
		jQuery('#imgText > textarea').css('overflow', 'hidden').autogrow();
		jQuery('#imgText > textarea').val('');
	} else {
		jQuery('#popImgText > #imgText').html("");
	}
}


popupBox.bindCloseAction = function (func) {
	jQuery(document).keyup(function (e) {
		if (e.keyCode === 27) {
			func();
		}
	});


	jQuery('.popupImg').click(function (event) {
		event.stopPropagation();


	});

	//for mobile phone, click image to close
	jQuery('#popImgBox').click(function (event) {
		if (jQuery(window).width() < 512) {
			func();
		} else {
			event.stopPropagation();
		}
	});

	jQuery('.baseLayer').click(function (event) {
		func();
	});

	//click on cross
}



popupBox.unbindCloseAction = function () {
	jQuery(document).unbind('keyup');
}

popupBox._setPopImgBoxHeight = function () {
	var height = popupBox._BACKGROUND_IMAGE_HEIGHT;
	var width = popupBox._BACKGROUND_IMAGE_WIDTH;

	if (height > 0 && width > 0) {
		var container = "#popImgBox";
		var containerWidth = jQuery(container).width();

		var container_height = Math.round(height * containerWidth / width);

		jQuery(container).css({
			'height': container_height + "px",
		});
	}


}

popupBox._bindResizeEvt = function () {
	var obj = this;
	if (!GLOBAL_IS_MOBILE) {
		jQuery(window).resize(function () {
			clearTimeout(obj._resizeEvt);
			obj._resizeEvt = setTimeout(function () {
				popupBox._setPopImgBoxHeight();
			}, 10);
		});
	}
}


