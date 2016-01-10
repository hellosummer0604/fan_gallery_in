jQuery.noConflict();

jQuery(window).ready(function () {
	Init.act_headNav();

	Init.act_Poster();

	Init.Act_Img_Grid_Manager();

	Init.Act_popupBox();
});


var Init = Init || {}


/**
 * Load the function to adjust background image of container
 */
Init.act_Poster = function () {
	if (typeof Image_adjuster != "undefined") {
		var poster = new Image_adjuster(".poster", 2048, 1367);
		poster.activate();
		console.log("Loading poster_manager.js");
	} else {
		console.error("Haven't load poster_manager.js");
	}
}

/**
 * Load the function to adjust opacity of nav bar
 */
Init.act_headNav = function () {
	if (typeof headNav != "undefined") {
		headNav.activate();
		console.log("Loading indexNav.js");
	} else {
		console.error("Haven't load indexNav.js");
	}
}


/**
 * Load the function to manage the image grid
 */
Init.Act_Img_Grid_Manager = function () {
	if (typeof Img_Grid_Manager != "undefined") {
		Img_Grid_Manager.activate();
		console.log("Loading img_grid_manager.js");
	} else {
		console.error("Haven't load img_grid_manager.js");
	}
}

/**
 * Load the function to manage the popup
 */
Init.Act_popupBox = function () {
	if (typeof popupBox != "undefined") {
		popupBox.activate();
		console.log("Loading popupBox.js");
	} else {
		console.error("Haven't load popupBox.js");
	}
}