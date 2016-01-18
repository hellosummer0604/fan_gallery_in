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
//	console.log("try to display" + data['data']['path']);
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

	//

}


popupBox.bindCloseAction = function (func) {
	jQuery(document).keyup(function (e) {
		if (e.keyCode === 27) {
			func();
		}
	});

	jQuery('.closeButton').click(function () {
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

	jQuery(window).resize(function () {
		clearTimeout(obj._resizeEvt);
		obj._resizeEvt = setTimeout(function () {
			popupBox._setPopImgBoxHeight();
		}, 10);
	});

}


