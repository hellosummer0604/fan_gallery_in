var popupBox = popupBox || {}

//execute after resize
popupBox._resizeEvt;

popupBox.activate = function () {
	jQuery("#upload").click(function(){
		popupBox.showPopup("#uploadBox");
	});
}

popupBox.showPopup = function (target) {
	//basic setting
	jQuery(target).fadeIn(200);
	
	jQuery('body').css({
		overflow:  'hidden',
	});
	
	jQuery('html').css({
		overflow:  'hidden',
	});
	
	///
	
}

popupBox.hidePopup = function (targetArray) {
	//basic setting
	targetArray.forEach(function (entry) {
		jQuery(entry).fadeOut(200);
	});

	jQuery('body').css({
		overflow:  'auto',
	});
	
	jQuery('html').css({
		overflow:  'auto',
	});
	
	///
	
}

popupBox._loadImgdetail = function () {
	
}

popupBox._clearImgdetail = function () {
	
}


popupBox.bindCloseAction = function (func) {
	jQuery(document).keyup(function (e) {
		if (e.keyCode === 27){
			func();
		}
	});
	
	jQuery('.closeButton').click(function(){
		func();
	});
	
	//click on cross
}



popupBox.unbindCloseAction = function () {
	jQuery(document).unbind('keyup');
}

popupBox._bindResizeEvt = function () {
	var obj = this;

	jQuery(window).resize(function () {
		clearTimeout(obj._resizeEvt);
		obj._resizeEvt = setTimeout(function () {
			
			

		}, 10);
	});

}
