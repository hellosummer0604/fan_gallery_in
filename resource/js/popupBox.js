var popupBox = popupBox || {}

//execute after resize
popupBox._resizeEvt;

popupBox.activate = function () {


	
}

popupBox.showPopup = function () {
	jQuery('#shadowWrapper').fadeIn(200);
	
	document.body.style.overflow='hidden';
}

popupBox.hidePopup = function () {
	jQuery('#shadowWrapper').fadeOut(200, function(){
		document.body.style.overflow='auto';
	});
	
	
}


popupBox.bindCloseAction = function (func) {
	jQuery(document).keyup(function (e) {
		if (e.keyCode === 27)
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
