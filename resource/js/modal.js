/******************Start img modal*******************************/


//rearrange the image in container
var _resizeImageInContainer = function (img, container) {
    //default is #imgBox
    if (typeof img == 'undefined') {
        img = $("#imgBox > img");
    }

    if (typeof container == 'undefined') {
        container = $("#imgBox");
    }


    var imgWidth = $(img).attr("img-org-width");
    var imgHeight = $(img).attr("img-org-height");

    var imgRatio = imgWidth / imgHeight;

    var containerHeight = container[0].getBoundingClientRect().height;
    var containerWidth = container[0].getBoundingClientRect().width;

    var containerBorderHeight = (container.innerHeight() - container.height()) / 2;
    var containerBorderWidth = (container.innerWidth() - container.width()) / 2;

    if ((containerWidth * imgHeight / imgWidth) > containerHeight) {
        var imgWidth = containerHeight * imgWidth / imgHeight;
        img.width(imgWidth);
        img.height(containerHeight);
        img.css('margin-top', 0 + "px");
        img.css('margin-left', ((containerWidth - imgWidth) / 2) + "px");
    } else {
        var imgHeight = containerWidth * imgHeight / imgWidth;
        img.width(containerWidth);
        img.height(imgHeight);
        img.css('margin-left', 0 + "px");
        img.css('margin-top', (containerHeight - imgHeight) / 2 + "px");
    }

    var imgSize = [img.width(), img.height()];

    return imgSize;
}

//rearrange imgBox and imgDes
var _resizeImgBoxAndImgDes = function () {
    var modalWidth = $("#imgModal").width();

    $("#modalX").width(modalWidth);


    //before resize the image,
    if (modalWidth < MODAL_MIN_WIDTH) {
        $("#imgBox").width(modalWidth + "px");
        $("#imgBox").height(MODAL_DEFAULT_HEIGHT + "px");
        $("#imgDes").width(modalWidth + "px");
    } else {
        $("#imgBox").width((modalWidth - IMGDES_WIDTH - 2) + "px");
        $("#imgDes").width(IMGDES_WIDTH + "px");
    }

    //img resize functoin
    var imgSize = _resizeImageInContainer();

    // after resize the image, cut the imgBox
    if (modalWidth < MODAL_MIN_WIDTH) {
        $("#imgBox").css('margin-top', CLOSE_MARIN_TOP + "px");
        $("#imgBox > img").css('margin-top', "0px");
        $("#imgBox").height(imgSize[1] + "px");
        if ($("#imgBox").height() < PAGEBUTTON_HEIGHT) {
            $("#imgBox > img").css('margin-top', (PAGEBUTTON_HEIGHT - $("#imgBox").height()) / 2);
            $("#imgBox").height(PAGEBUTTON_HEIGHT);
        }
        $("#imgDes").width(modalWidth + "px");
        $("#imgModalHead").height($("#imgBox").height() + $("#imgDes").height() + CLOSE_MARIN_TOP + "px");
    } else {
        $("#imgBox").css('margin-top', "0px");
        $("#imgBox").height(MODAL_DEFAULT_HEIGHT + "px");
        $("#imgDes").width(IMGDES_WIDTH + "px");
        $("#imgModalHead").height(MODAL_DEFAULT_HEIGHT + "px");
    }


}

//binding click event to display full screen img
var _bindingImgBox = function() {
    var img = $("#imgBox > img");
    if (typeof img == 'undefined') {
        console.error("no img");
        return;
    }

    //img.toggle(function(){
    //    //alert("on");
    //}, function(){
    //    //alert("off");
    //})
}

//add pagination button into imgBox
var _pageButton = function() {
    var imgBox = $("#imgBox");
    //add button
    if (imgBox.find(".changImg").length == 0 ) {
        var html = "<div id = 'left_arrow' class = 'changImg'><img src='resource/img/left_arrow_1.png'></div>" +
            "<div id = 'right_arrow' class = 'changImg'><img src='resource/img/right_arrow_1.png'></div>";
        imgBox.append(html);
    }

    //set location of button
    var top = (imgBox[0].getBoundingClientRect().height - $("#left_arrow")[0].getBoundingClientRect().height) / 2;
    var right = ($("#modalX")[0].getBoundingClientRect().width - imgBox[0].getBoundingClientRect().width);

    if ($("#modalX").width() <= MODAL_MIN_WIDTH) {
        top = CLOSE_MARIN_TOP + top;
    }

    $(".changImg").css("top", top + "px").css("opacity", 0.2);
    $("#right_arrow").css("right", right + "px");

    _bindButtonEvent();


}

//bind event to button
var _bindButtonEvent = function() {
    //add animation
    $(".changImg").off("mouseenter").mouseenter(
        function() {
            $(this).animate({
                opacity: 0.6
            }, 200);
        });

    $(".changImg").off("mouseleave").mouseleave(
        function() {
            $(this).animate({
                opacity: 0.2
            }, 200);
        }
    );

    //add pagination event
    $("#right_arrow").off("click").click(function(){
        _switchPage("next");
    });

    $("#left_arrow").off("click").click(function(){
        _switchPage("pre");
    });
}

//request for next or pre page

var _switchPage = function(page) {
    if ((typeof page == 'undefined') || (page == "next")) {
        page = "next";
    } else {
        page = "pre";
    }

    console.log(page);
}

//clear the imgBox when close
var _closeModal = function () {
    $("#imgModal .close").off("click").click(function() {
        _clearModal();
    });
}

//clear modal
var _clearModal = function() {

    setTimeout(function(){
        //clear img
        $("#imgBox > img").attr('src', 'resource/img/loading.gif');


        //clear text


    }, 100);

}


//render the image modal
var renderModal = function () {
    _resizeImgBoxAndImgDes();
    _pageButton();
}

var bandModalEvent = function () {
    _closeModal();
}


/******************End img modal*******************************/