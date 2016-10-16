jQuery.noConflict();


//GLOBAL VAR

//scrollbar width
GLOBAL_IS_MOBILE = false;
//current user id
CURRENT_USER = null;



jQuery(window).ready(function () {

	//first step is set global variable
	Init.Init_Global_Variable();

	Init.act_headNav();

	Init.act_Poster();

	Init.Act_Img_Grid_Manager();

	Init.Act_popupBox();

    Init.MonitorEvents();
});


var Init = Init || {}


/**
 * Load the function to adjust background image of container
 */
Init.act_Poster = function () {
	if (typeof Image_adjuster != "undefined") {
		var poster = new Image_adjuster(".poster");
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





//		
//		
//		Img_Grid_Manager._loadImgSection('repository');
//		
//		Img_Grid_Manager._loadImgSection('repository');

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


/**
 * monitor <a> customize data
 */
Init.MonitorEvents = function () {
    popupBox._bindAClick();
}

////global var

Init.Init_Global_Variable = function () {
	Init._detect_mobile();

}

Init._detect_mobile = function () {
	GLOBAL_IS_MOBILE = false; //initiate as false
// device detection
	if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
			|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))){
				GLOBAL_IS_MOBILE = true;
				//GLOBAL_IS_MOBILE = false;
			}


}

Init.router = function (property) {
    var url = window.location.href;

    var parts = url.split('/');

    var index = -1;

    for(var i = 0; i < parts.length; i++) {
        if (parts[i] == property) {
            index = i;
            break;
        }
    }

    index++;

    if (index != -1 && index < parts.length) {
        return parts[index].trim();
    }

    return null;
}

Init.setLoggedIn = function (userid) {
    CURRENT_USER = userid;
}

Init.setLoggedOut = function () {
    CURRENT_USER = null;
}

Init.userLoggedIn = function () {
    return CURRENT_USER;
}