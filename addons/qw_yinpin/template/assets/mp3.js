$(document).ready(function() {
    var vid = $("#vid").attr({
        // 'autoplay' : 'autoplay',
        // 'controls' : 'controls',
        'loop'     : 'loop',
        'preload'  : 'auto'
    });

    var vidDOM = vid[0];
    vidDOM.volume = 0.2;
    $(".play-button").on({
        click : function(){
            $(this).children().toggleClass(function(){
                if ($(this).hasClass("icon-play")) {
                    return "icon-pause";
                } else {
                    return "icon-play";
                };
            });

            if (vidDOM.paused) {
                vidDOM.play();
            } else {
                vidDOM.pause();
            };
            return false;
        }
    });
});