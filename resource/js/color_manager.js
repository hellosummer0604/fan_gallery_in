var Color_scroller = Class.create({
    default: function () {
        this.period = 500;
        this.blue = new jQuery.Color('rgb(0, 171, 230)');
        this.pink = new jQuery.Color('rgb(255, 51, 153)');
        this.color = this.blue;
    },

    initialize: function () {
        this.default();
    },

    action: function () {
        var distance = jQuery(document).scrollTop();

        var percent = distance % this.period / this.period;

        var direction = Math.floor(distance / this.period);

        if (direction % 2 == 0) {
            this.color = this._actScroll(this.blue, this.pink, percent);
            //console.log(percent);
        } else {
            this.color = this._actScroll(this.pink, this.blue, percent);
            //console.log(percent);
        }

        return this.color;
    },

    _actScroll: function (start, end, percent) {
        var newRed = start.red() + (end.red() - start.red()) * percent;
        var newGreen = start.green() + (end.green() - start.green()) * percent;
        var newBlue = start.blue() + (end.blue() - start.blue()) * percent;
        return new jQuery.Color(newRed, newGreen, newBlue);
    }


})