var Img_Grid_Manager = Img_Grid_Manager || {}

Img_Grid_Manager.sectionList = [];

Img_Grid_Manager.default = function () {

}



Img_Grid_Manager.activate = function () {
	var imgGridManager = new ImgGrid();

	//test one section


	imgGridManager._renderImgGroup(data);

	imgGridManager.resizeWindow();
}

Img_Grid_Manager._loadImgSection = function (sid) {
	
	if (typeof Img_Grid_Manager.sectionList[sid] != 'undefined') {
		console.log(sid + 'has been loaded');
	} else {
		var sectionInfo = {'sectionId': 'repository'};

		jQuery.ajax({
			method: 'POST',
			url: 'http://north.gallery/ajax_controller/getImg',
			data: sectionInfo,
			dataType: 'json',
			async: false,
			success: function (section) {
				if (section!= null && section.id != null && section.loadingList != null) {
					Img_Grid_Manager.sectionList[section.id] = section.loadingList ;
				}
			},
			error: function () {
				console.error('loading img section ' + sid +  ' fail' );
			}
		});
	}
}
//
//Img_Grid_Manager._loadImgAll = function (idList) {
//	if (typeof idList == 'undefined') {
//		return null;
//	}
//
//	var sectionList = {};
//
//
//	jQuery.each(idList, function (index, value) {
//		var section = Img_Grid_Manager._loadImgSection(value);
//
//		if ((!empty(section['id'])) && (!empty(section['loadingList']))) {
//
//			sectionList[section['id']] = section;
//		}
//
//	});
//
//	return sectionList;
//}


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