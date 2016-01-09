var Obj_move_animation = Obj_move_animation || {}

Obj_move_animation.resizeEvt;

Obj_move_animation.moveTo = function (obj, left, top, speed) {
    if (typeof speed == "undefined") {
        speed = 100;
    }

    obj.stop(true, true).animate(function () {

    });
}

jQuery(window).off("resize").resize(function () {
    clearTimeout(Obj_move_animation.resizeEvt);
    Obj_move_animation.resizeEvt = setTimeout(function () {
        //Obj_move_animation._resize_background();
    }, 10);

});