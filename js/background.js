$(document).ready(function() {

    var $fader = $("#fader");
    var $bg = $("#background");
    var cur_img = 0;
    var img_num = 5;

    setInterval(function () {
        var next_img = (cur_img === img_num - 1) ? 0 : cur_img + 1;
        $fader.removeClass().addClass("img" + cur_img.toString()).css("display", "block").fadeOut(2000);
        $bg.removeClass().addClass("img" + next_img.toString());
        cur_img = next_img;
    }, 5000);
});