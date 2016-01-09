//$(function(){
//    addId();
//})


//add attribute
var addId = function () {
    var i = 0;
    $(".homeImgContainer img").each(function(){
        $(this).attr('thumb_img_id', 'img_'+i);
        i++;
    });
}


var group1 = {
    "id": "s12g1",
    "imgList":[

        {
            "id": "img2",
            "src": "upload/origin/img2.jpg",
            "thumb": "img2.jpg",
            "width": 5616,
            "height": 3744
        },
        {
            "id": "img3",
            "src": "upload/origin/img3.jpg",
            "thumb": "img3.jpg",
            "width": 5695,
            "height": 3992
        },
        {
            "id": "img4",
            "src": "upload/origin/img4.jpg",
            "thumb": "img4.jpg",
            "width": 5976,
            "height": 1740
        },
        {
            "id": "img5",
            "src": "upload/origin/img5.jpg",
            "thumb": "img5.jpg",
            "width": 5976,
            "height": 2695
        },
        {
            "id": "img6",
            "src": "upload/origin/img6.jpg",
            "thumb": "img6.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img7",
            "src": "upload/origin/img7.jpg",
            "thumb": "img7.jpg",
            "width": 5976,
            "height": 2619
        },
        {
            "id": "img8",
            "src": "upload/origin/img8.jpg",
            "thumb": "img8.jpg",
            "width": 3992,
            "height": 5429
        },
        {
            "id": "img9",
            "src": "upload/origin/img9.jpg",
            "thumb": "img9.jpg",
            "width": 2981,
            "height": 5602
        },
        {
            "id": "img10",
            "src": "upload/origin/img10.jpg",
            "thumb": "img10.jpg",
            "width": 5562,
            "height": 3992
        }, {
            "id": "img11",
            "src": "upload/origin/img11.jpg",
            "thumb": "img11.jpg",
            "width": 5976,
            "height": 3184
        },
        {
            "id": "img12",
            "src": "upload/origin/img12.jpg",
            "thumb": "img12.jpg",
            "width": 5363,
            "height": 3584
        },
        {
            "id": "img13",
            "src": "upload/origin/img13.jpg",
            "thumb": "img13.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img14",
            "src": "upload/origin/img14.jpg",
            "thumb": "img14.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img15",
            "src": "upload/origin/img15.jpg",
            "thumb": "img15.jpg",
            "width": 3992,
            "height": 5876
        }
    ],
    "serverInfo" :[]
};

var group2 = {
    "id": "s12g2",
    "imgList": [
        {
            "id": "img16",
            "src": "upload/origin/img16.jpg",
            "thumb": "img16.jpg",
            "width": 5976,
            "height": 1951
        },
        {
            "id": "img17",
            "src": "upload/origin/img17.jpg",
            "thumb": "img17.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img18",
            "src": "upload/origin/img18.jpg",
            "thumb": "img18.jpg",
            "width": 3992,
            "height": 5976
        },
        {
            "id": "img19",
            "src": "upload/origin/img19.jpg",
            "thumb": "img19.jpg",
            "width": 5616,
            "height": 3744
        },
        {
            "id": "img20",
            "src": "upload/origin/img20.jpg",
            "thumb": "img20.jpg",
            "width": 3840,
            "height": 5760
        }, {
            "id": "img21",
            "src": "upload/origin/img21.jpg",
            "thumb": "img21.jpg",
            "width": 5178,
            "height": 3840
        },
        {
            "id": "img22",
            "src": "upload/origin/img22.jpg",
            "thumb": "img22.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img23",
            "src": "upload/origin/img23.jpg",
            "thumb": "img23.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img24",
            "src": "upload/origin/img24.jpg",
            "thumb": "img24.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img25",
            "src": "upload/origin/img25.jpg",
            "thumb": "img25.jpg",
            "width": 3840,
            "height": 5760
        },
        {
            "id": "img26",
            "src": "upload/origin/img26.jpg",
            "thumb": "img26.jpg",
            "width": 3840,
            "height": 5760
        },
        {
            "id": "img27",
            "src": "upload/origin/img27.jpg",
            "thumb": "img27.jpg",
            "width": 5595,
            "height": 3730
        },
        {
            "id": "img28",
            "src": "upload/origin/img28.jpg",
            "thumb": "img28.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img29",
            "src": "upload/origin/img29.jpg",
            "thumb": "img29.jpg",
            "width": 5616,
            "height": 3744
        },
        {
            "id": "img30",
            "src": "upload/origin/img30.jpg",
            "thumb": "img30.jpg",
            "width": 3744,
            "height": 5616
        },
        {
            "id": "img31",
            "src": "upload/origin/img31.jpg",
            "thumb": "img31.jpg",
            "width": 3744,
            "height": 5616
        },
        {
            "id": "img32",
            "src": "upload/origin/img32.jpg",
            "thumb": "img32.jpg",
            "width": 5616,
            "height": 3744
        }
    ],
    "serverInfo": []
};

var section = {'id': 'sectionid', 'groups': [group1, group2]};

var sectionList = {'sectionid': section};


//just for test
var data = {
    "id": "s12g2",
    "imgList": [

        {
            "id": "img2",
            "src": "upload/origin/img2.jpg",
            "thumb": "img2.jpg",
            "width": 5616,
            "height": 3744
        },
        {
            "id": "img3",
            "src": "upload/origin/img3.jpg",
            "thumb": "img3.jpg",
            "width": 5695,
            "height": 3992
        },
        {
            "id": "img4",
            "src": "upload/origin/img4.jpg",
            "thumb": "img4.jpg",
            "width": 5976,
            "height": 1740
        },
        {
            "id": "img5",
            "src": "upload/origin/img5.jpg",
            "thumb": "img5.jpg",
            "width": 5976,
            "height": 2695
        },
        {
            "id": "img6",
            "src": "upload/origin/img6.jpg",
            "thumb": "img6.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img7",
            "src": "upload/origin/img7.jpg",
            "thumb": "img7.jpg",
            "width": 5976,
            "height": 2619
        },
        {
            "id": "img8",
            "src": "upload/origin/img8.jpg",
            "thumb": "img8.jpg",
            "width": 3992,
            "height": 5429
        },
        {
            "id": "img9",
            "src": "upload/origin/img9.jpg",
            "thumb": "img9.jpg",
            "width": 2981,
            "height": 5602
        },
        {
            "id": "img10",
            "src": "upload/origin/img10.jpg",
            "thumb": "img10.jpg",
            "width": 5562,
            "height": 3992
        }, {
            "id": "img11",
            "src": "upload/origin/img11.jpg",
            "thumb": "img11.jpg",
            "width": 5976,
            "height": 3184
        },
        {
            "id": "img12",
            "src": "upload/origin/img12.jpg",
            "thumb": "img12.jpg",
            "width": 5363,
            "height": 3584
        },
        {
            "id": "img13",
            "src": "upload/origin/img13.jpg",
            "thumb": "img13.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img14",
            "src": "upload/origin/img14.jpg",
            "thumb": "img14.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img15",
            "src": "upload/origin/img15.jpg",
            "thumb": "img15.jpg",
            "width": 3992,
            "height": 5876
        },
        {
            "id": "img16",
            "src": "upload/origin/img16.jpg",
            "thumb": "img16.jpg",
            "width": 5976,
            "height": 1951
        },
        {
            "id": "img17",
            "src": "upload/origin/img17.jpg",
            "thumb": "img17.jpg",
            "width": 5976,
            "height": 3992
        },
        {
            "id": "img18",
            "src": "upload/origin/img18.jpg",
            "thumb": "img18.jpg",
            "width": 3992,
            "height": 5976
        },
        {
            "id": "img19",
            "src": "upload/origin/img19.jpg",
            "thumb": "img19.jpg",
            "width": 5616,
            "height": 3744
        },
        {
            "id": "img20",
            "src": "upload/origin/img20.jpg",
            "thumb": "img20.jpg",
            "width": 3840,
            "height": 5760
        }, {
            "id": "img21",
            "src": "upload/origin/img21.jpg",
            "thumb": "img21.jpg",
            "width": 5178,
            "height": 3840
        },
        {
            "id": "img22",
            "src": "upload/origin/img22.jpg",
            "thumb": "img22.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img23",
            "src": "upload/origin/img23.jpg",
            "thumb": "img23.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img24",
            "src": "upload/origin/img24.jpg",
            "thumb": "img24.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img25",
            "src": "upload/origin/img25.jpg",
            "thumb": "img25.jpg",
            "width": 3840,
            "height": 5760
        },
        {
            "id": "img26",
            "src": "upload/origin/img26.jpg",
            "thumb": "img26.jpg",
            "width": 3840,
            "height": 5760
        },
        {
            "id": "img27",
            "src": "upload/origin/img27.jpg",
            "thumb": "img27.jpg",
            "width": 5595,
            "height": 3730
        },
        {
            "id": "img28",
            "src": "upload/origin/img28.jpg",
            "thumb": "img28.jpg",
            "width": 5760,
            "height": 3840
        },
        {
            "id": "img29",
            "src": "upload/origin/img29.jpg",
            "thumb": "img29.jpg",
            "width": 5616,
            "height": 3744
        },
        {
            "id": "img30",
            "src": "upload/origin/img30.jpg",
            "thumb": "img30.jpg",
            "width": 3744,
            "height": 5616
        },
        {
            "id": "img31",
            "src": "upload/origin/img31.jpg",
            "thumb": "img31.jpg",
            "width": 3744,
            "height": 5616
        },
        {
            "id": "img32",
            "src": "upload/origin/img32.jpg",
            "thumb": "img32.jpg",
            "width": 5616,
            "height": 3744
        }
    ],
    "serverInfo": []
};



var console_test = function (data) {
    console.log(JSON.stringify(data));
}

var table_test = function (data) {

    jQuery("#testGrid").html("");

    var html = "<table>";
    for (var row = 0; row < data.length; row++) {
        html = html + "<tr>";
        for (var col = 0; col < data.length; col++) {
            html = html + "<td><center>";
            html = html + JSON.stringify(data[row][col]);
            html = html + "</center></td>";
        }
        html = html + "</tr>";
    }

    html = html + "</table>";
    jQuery("#testGrid").append(html);
}