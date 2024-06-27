$(document).ready(function() {


    $('.main-nav > ul > li > a').each(function() {
        if($(this).attr('href') === CNV.categoryActive) {
            $(this).parent().addClass('active');
        }
    });

    // Gets the video src from the data-src on each button

    var $videoSrc;
    var $videoTitle;
    $('.video-show').click(function() {
        $videoSrc = $(this).data( "src" );
        $videoTitle = $(this).attr( "data-title-video" );
    });


    $('#myVideo').on('shown.bs.modal', function (e) {
    $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" );
    $('.model_title_video').html($videoTitle);
    })



    $('#myVideo').on('hide.bs.modal', function (e) {
        $("#video").attr('src',$videoSrc);
    })
});
