/**
 * section has 100 imgs, group has 50 imgs
 *
 * 1. load first group
 * 2. load image, assign to group, render the group, append group to section
 * 3. if this.display == true render it
 * 4. when resize, render the whole section
 * 5. next pre page, clear the section, reload new imgs
 *
 *
 */

var ImgGrid = Class.create({
	/* 1.can not less than imgMinWidth, abandon this arrangement;
	 * 2.cost is 3 to the power of |real height - imgBestHeight|;
	 * 3.if less than imgMinHeight and there is only one img in row, scale the img to imgMinHeight, then cut the image's width, increase the cost;
	 * 4.if higher than imgMaxHeight, cut the image's height to imgMaxHeight, increase the cost;
	 *
	 * 5.the border of each img is 5px;
	 * */
	default: function () {
		this._resizeEvt;


//		this._imgThumbPath = location.protocol + "//" + location.host + "/resource/gallery/img_publish/img_thumb/";
		this._imgThumbPath = location.protocol + "//" + location.host ;

		this.imgBorder = 5;
        this.imgFatBorder = 5;
        this.imgThinBorder = 2;
		this.imgMinWidth = 150;
		this.imgMinHeight = 150;
		this.imgMaxHeight = 600;
        this.imgBestHeight = 300;

		//
		//this.firstLoad = 50;
		//this.appendLoad = 25;

		//
//		this._setContainerWidth();


		//same to id of bodySection
		this.typeId = null;
		this.imgGroup = new Array();
		this.display = false;
		
		this.imgData = null;

		popupBox.bindCloseAction(function () {
			popupBox.hideImgBoxPopup(['#imgBox', '#uploadBox', '.smallPopup', '#genericBox']);
		});
	},
	
	_setContainerWidth: function () {
		
		var curId = this.imgData.id;
		
		this.containerWidth = jQuery("#" + curId).innerWidth();
		
		if (this.containerWidth < 1024) {
			this.imgBorder = this.imgThinBorder;
		} else {
			this.imgBorder = this.imgFatBorder;
		}
	},
	
	initialize: function (typeId, page) {

		this.default();

		this.typeId = typeId;
		this.page = page;
		this.groupId = 0;

	},
	
	/**
	 * Render the group
	 * @param imgArray
	 * @private
	 */
	renderImgGroup: function () {
		
		var imgArray = this.imgData;
		
		this._setContainerWidth();
		
		//temp, this should be move to append image function
		this._preProcessImgArray(imgArray['imgList']);

		var containerWidth = this.containerWidth;

		var imgSum = imgArray['imgList'].length;

		//make grid
		var costGrid = [];


		for (var row = 0; row < imgSum; row++) {
			var costRow = [];

			for (var col = 0; col < imgSum; col++) {
				costRow.push(this._calCost(imgArray['imgList'], row, col));
			}

			costGrid.push(costRow);
		}
		
		

		var shortestPath = this._shortestPath(costGrid);

		var groupDetail = this._scaleImgGroup(imgArray['imgList'], shortestPath);

		var containerId = imgArray['id'];

		this._insertDiv(groupDetail, containerId);

		this._assignImgAndEvent(imgArray['imgList'], containerId);

		//console_test(groupDetail);
	},
	
	
	setImgArray: function(imgArray){
		this.imgData = imgArray;
	},
	/**
	 *
	 * @param section the n-th group of one page
	 * @private
	 */
	_loadImgGroup: function (groupId) {

	},
	/**
	 * render all group
	 * @private
	 */
	_renderImgs: function (imgArray) {


	},
	_preProcessImgArray: function (imgArray) {
		for (var img = 0; img < imgArray.length; img++) {
			imgArray[img]['ratio'] = (imgArray[img]['width'] / imgArray[img]['height']);
		}
	},
	_calCost: function (imgArray, start, end) {
		var entry = this._calImgRow(imgArray, start, end);

		if (entry == null) {
			return null;
		} else {
			return entry;
		}
	},
	_calImgRow: function (imgArray, start, end) {
		if (start > end) {
			return null;
		}
		/****each image has border****/
		var widthExpBorder = this.containerWidth - (end - start + 1) * 2 * this.imgBorder;
		
		/**
		 * - cost
		 * - imgArray
		 */
		var gridEntry = [];

		/**
		 * - Array of imgEntry (width, height)
		 *
		 */
		var gridImgArray = [];

		var ratioSum = 0;

		var narrowImgRatio = Number.MAX_VALUE;

		for (var i = start; i <= end; i++) {
			narrowImgRatio = narrowImgRatio < imgArray[i]['ratio'] ? narrowImgRatio : imgArray[i]['ratio'];

			ratioSum += imgArray[i]['ratio'];
		}

		/**** the reconciled height of img row ***/
		var reconciledHeight = Math.floor(widthExpBorder / ratioSum);

		/****1. check min width, if violate, abandon ****/
		if (Math.round(narrowImgRatio * reconciledHeight) < this.imgMinWidth) {
			return null;
		}


		/** calculate cost***/
		var cost = Math.pow(Math.abs(reconciledHeight - this.imgBestHeight), 3);
		gridEntry = cost;

		/****2. check min height, if violate, cut image, increase cost****/
		if (reconciledHeight < this.imgMinHeight) {
			if (start == end) {
				return gridEntry;
			} else {// too many images
				return null
			}
		}

		return gridEntry;
	},
	
	_shortestPath: function (costGrid) {
		if (costGrid.length < 1) {
			console.error("_shortestPath error: none path table error");
			return null;
		}

		$partition = [];

		var len = costGrid.length;

		//var pathGrid = Array(len).fill(Array(len).fill(new Array()));

		for (var col = 0; col < len; col++) {
			if (costGrid[0][col] != null) {
				costGrid[0][col] = {'cost': costGrid[0][col], 'path': [{'start': 0, 'end': col}]};
			}
		}


		for (var row = 1; row < len; row++) {
			for (var col = row; col < len; col++) {
				if (costGrid[row][col] != null) {
					var minCost = Number.MAX_VALUE;
					var minRow = null;
					var minCol = null;
					for (var temp_row = 0; temp_row < row; temp_row++) {
						if (costGrid[temp_row][row - 1] != null) {
							if (minCost > costGrid[temp_row][row - 1]['cost']) {
								minCost = costGrid[temp_row][row - 1]['cost'];
								minRow = temp_row;
								minCol = row - 1;
							}
						}
					}
					costGrid[row][col] += minCost;

					var tempPath = costGrid[minRow][minCol]['path'].concat({'start': row, 'end': col});

					costGrid[row][col] = {'cost': costGrid[row][col], 'path': tempPath};
				}
			}
		}

		var minCost = Number.MAX_VALUE;
		var posRow = null;
		for (var row = 0; row < len; row++) {
			if (costGrid[row][len - 1] != null) {
				if (minCost > costGrid[row][len - 1]['cost']) {
					minCost = costGrid[row][len - 1]['cost'];
					posRow = row;
				}
			}
		}

		var path = costGrid[posRow][len - 1]['path'];

		return path;
	},
	_scaleImgRow: function (imgArray, start, end, offset) {
		if (start > end) {
			return null;
		}
		/****each image has border****/
		var widthExpBorder = this.containerWidth - (end - start + 1) * 2 * this.imgBorder;

		/**
		 * - cost
		 * - imgArray
		 */
		var gridEntry = [];

		/**
		 * - Array of imgEntry (width, height)
		 *
		 */
		var gridImgArray = [];

		var ratioSum = 0;

		var narrowImgRatio = Number.MAX_VALUE;

		for (var i = start; i <= end; i++) {
			ratioSum += imgArray[i]['ratio'];
		}

		/**** the reconciled height of img row ***/
		var reconciledHeight = Math.floor(widthExpBorder / ratioSum);


		/****2. check min height, if violate, cut image ****/
		var realHeight = 0;

		if (reconciledHeight < this.imgMinHeight) {
			//scale then cut image
			realHeight = this.imgMinHeight;

			var temp_ele = {
				'width': widthExpBorder,
				'height': realHeight,
				'left': this.imgBorder,
				'top': (offset + this.imgBorder)
			};

			gridImgArray.push(temp_ele);

		} else {
			/****3. check max height, if violate, cut image, increase cost****/

			var refinedHeight = reconciledHeight > this.imgMaxHeight ? this.imgMaxHeight : reconciledHeight;

			var lastWidth = widthExpBorder;

			var leftOffset = this.imgBorder;

			for (var i = start; i < end; i++) {
				var temp_width = Math.round(reconciledHeight * imgArray[i]['ratio']);

				var temp_ele = {
					'width': temp_width,
					'height': refinedHeight,
					'left': leftOffset,
					'top': (offset + this.imgBorder)
				};

				gridImgArray.push(temp_ele);

				lastWidth -= temp_width;

				leftOffset += (temp_width + 2 * this.imgBorder);
			}

			var last_ele = {
				'width': lastWidth,
				'height': refinedHeight,
				'left': leftOffset,
				'top': (offset + this.imgBorder)
			};

			realHeight = refinedHeight;

			gridImgArray.push(last_ele);
		}

		gridEntry = {'entris': gridImgArray, 'offset': (offset + realHeight + this.imgBorder * 2)};

		return gridEntry;
	},
	_scaleImgGroup: function (imgArray, shortestPath) {
		var offset = 0;

		var group = [];

		for (var i = 0; i < shortestPath.length; i++) {
			var rowPlan = this._scaleImgRow(imgArray, shortestPath[i]['start'], shortestPath[i]['end'], offset);

			offset = rowPlan['offset'];

			group.push(rowPlan);
		}

		return group;
	},
	
	_insertDiv: function (obj, target) {

		target = jQuery("#" + target);

		target.height(obj[obj.length - 1]['offset']);

		target.html("");

		for (var row = 0; row < obj.length; row++) {
			/***<div class='imgThumbBox' style="cursor:pointer; position: absolute; width:285px; height: 190px; left: 5px; top: 5px; background-color: red"></div>**/

			for (var col = 0; col < obj[row]['entris'].length; col++) {
				var div_html = "<div class='imgThumbBox loadingBgLight' style='width:"
                    + obj[row]['entris'][col]['width'] + "px; height: "
                    + obj[row]['entris'][col]['height'] + "px; left: "
                    + obj[row]['entris'][col]['left'] + "px; top: "
                    + obj[row]['entris'][col]['top'] + "px;'>"
                    + "</div>";
				target.append(div_html);
			}
		}

	},
    //todo click and popup event is here
	_assignImgAndEvent: function (imgArray, target) {
		var clazz = this;

		jQuery("#" + target + " .imgThumbBox").each(function (index) {
			/****console.log( index + ": " + jQuery( this ).text() );****/
			var container = this;
			var imgUrl = clazz._imgThumbPath + imgArray[index]['thumb'];

			jQuery('<img/>').attr('src', imgUrl).load(function () {
				jQuery(this).remove(); // prevent memory leaks as @benweet suggested

				//remove loading gif
				jQuery(container).removeClass('loadingBg');

				jQuery(container).css({
					'background-image': "url(" + imgUrl + ")",
					"background-repeat": "no-repeat",
					"background-size": "100% 100%",
					"background-position": "0px 0px"
				});
				//jQuery(container).fadeIn(200);

//just temp text for test
				var curId = imgArray[index]['id'];
				var preId = "";
				var postId = "";

				if(index > 0) {
					preId = imgArray[index - 1]['id'];
				}

				if (index + 1 < imgArray.length) {
					postId = imgArray[index + 1]['id'];
				}

				var tempHtml = "<div class='textBox'><span>Private Photo<span></div>"
                            + "<div class='hideImgId'>"
                                    + "<div class='hide_cur_id'>" + curId + "</div>"
                                    + "<div class='hide_pre_id'>" + preId + "</div>"
                                    + "<div class='hide_post_id'>" + postId + "</div>"
                            + "</div>"
                            + "<div class='thumbPlate'>"
                            + "<div class='topBox editImgInfoBtn'></div>"
                            // + "<div class='bottomBox'><span class='invisibleIcon'></span>the best coffee you can get</div>"
                            + "<div class='bottomBox'>the best coffee you can get</div>"
                            + "</div>";

                jQuery(container).html(tempHtml);

                //bind onmouseover and onmouseout
                var fadeInEnabled = true;
                jQuery(container).on({
                    mouseenter: function () {
                        if (fadeInEnabled) {
                            fadeInEnabled = false;
                            jQuery(container).find(".thumbPlate").fadeIn('fast', function () {
                                fadeInEnabled = true;
                            });
                        }
                    },
                    mouseleave: function () {
                        jQuery(container).find(".thumbPlate").fadeOut(0);
                    }
                });

				//bind event;
				jQuery(container).off('click').on('click', function() {
					popupBox.showImgBoxPopup(container, 'imgPopup');
				});

                jQuery('.editImgInfoBtn', container).off('click').on("click", function (event) {
                    event.stopPropagation();

                    popupBox.showImgBoxPopup(container, 'imgPopupEdit');
                });

			});
		});


	},
	_renderImgSection: function () {

	},
	appendImgGroup: function () {

	},
	_bindResizeEvt: function () {

	},
	_changePage: function () {

	},
	nextPage: function () {

	},
	prePage: function () {

	},
	resizeWindow: function () {
//		var obj = this;
//
//		jQuery(window).resize(function () {
//			clearTimeout(obj._resizeEvt);
//			obj._resizeEvt = setTimeout(function () {
//				obj._setContainerWidth();
//
//				obj._renderImgGroup(data);
//
//			}, 10);
//		});

	}


});

