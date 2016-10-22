/*********/

//img modal min-width
MODAL_MIN_WIDTH = 450;
CLOSE_MARIN_TOP = 50;
MODAL_DEFAULT_HEIGHT = 650;
PAGEBUTTON_HEIGHT = 90;
IMGDES_WIDTH = 300;


// configure the default type of numbers as fraction
math.config({
    number: 'bignumber'  // Choose 'number' (default), 'bignumber', or 'fraction'
});


/*********/


//handle screen resize
$(window).resize(function () {
    renderModal();

});


//init function into page
$(function () {
    //binding event, open the modal, on image list
    loadImgList(data);
    //add modal event
    bandModalEvent();

    // renderNavBar();
})





/******************Start home page*******************************/

//after get the data from the server
var loadImgList = function(data) {
    if(typeof data == 'undefined'){
        return;
    }
    data = data['imgList'];

    var html = "";
    data.forEach(function(img){
        html += "<img img-org-src = '" + img['src'] + "' img-org-width ='" + img['width'] +"' img-org-height = '" + img['height'] + "' img-id ='" + img['id'] + "' src='"+ img['thumb'] +"'>";
    });

    $(".homeImgContainer").html(html);

    _bindingOpenModel();
}


//binding event, open the modal, on image list
var _bindingOpenModel = function () {
    $(".homeImgContainer img").each(function () {
        $(this).off('click').on('click', function() {
            _openImgModal(this);
        });
    });
}

//get source img and open the modal
var _openImgModal = function(img) {
    $('#imgModal').modal('show');

    $(document).keyup(function(e) {
        if (e.keyCode == 27) { // escape key maps to keycode `27`
            $('#imgModal').modal('hide');
            _clearModal();
        }
    });


    var imgWidth = $(img).attr("img-org-width");
    var imgHeight = $(img).attr("img-org-height");
    var imgSrc = $(img).attr("img-org-src");


    var img = $("#imgBox > img");

    img.attr("img-org-width", imgWidth);
    img.attr("img-org-height", imgHeight);

    img.attr('src', imgSrc).load(function() {

    });


    renderModal();
}

/**********Start nav***************/




/**********End nav***************/





/******************End home page*******************************/