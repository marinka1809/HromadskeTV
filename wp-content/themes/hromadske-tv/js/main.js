$=jQuery;

$(document).ready(function(){

    $(".item-important-posts").dotdotdot({
    });

    $(".related-item").dotdotdot({
    });

    $(".front-project-section .item-project").dotdotdot({
    });

    $(".list-stories article.regular").dotdotdot({
    });

    $(".list-stories .dark-bg").dotdotdot({
    });

    $(".list-episodes article.regular").dotdotdot({
    });

    $(".list-episodes .dark-bg").dotdotdot({
    });

    $(".list-projects .small-content").dotdotdot({
    });


    $('.gallery-columns-1').slick({
        infinite: false,
        centerMode: true,
        centerPadding: '25%',
        slidesToShow: 1,
        //autoplay: true,
       // dots: true,
        });

    $(".gallery-columns-1 .gallery-item").append('<span class="pagingInfo"></span>');
    var $status = $('.pagingInfo');
    var $slickElement = $('.gallery-columns-1');

    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $status.text(i + '/' + slick.slideCount);
    });

    $(function() {
        var pull 		= $('.burger');
        menu 		= $('.toggle-menu');
        menuHeight	= menu.height();

        $(pull).on('click', function(e) {

            menu.slideToggle();
        });

        $(window).resize(function(){
            var w = $(window).width();
            if(w > 320 && menu.is(':hidden')) {
                menu.removeAttr('style');
            }
        });
    });

    var $searchView = $('.menu-search-container');
    var $menu = $('#site-navigation a,#menu-search');
    var $fadeScreen = $('.fade-screen');

    $('#menu-search, .fade-screen,.site-header .menu-search-close').on('click', function(e) {

        $searchView.toggleClass('active');

        setTimeout(function(){
            $searchView.children().find('input').focus();
        }, 1100);

        $fadeScreen.fadeToggle();
        $menu.removeClass('is-closed');
        $menu.toggleClass('hidden');

        e.preventDefault();
    });

    $('.fade-screen,.site-header .menu-search-close').on('click', function(e) {
        $menu.toggleClass('is-closed');
        e.preventDefault();
    });

    $(' .search-page .menu-search-close').on('click', function(e) {
        e.preventDefault();
        $('.search-page .menu-search-input').val('');
    });



    $('#up').click(function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    })
});

$(window).scroll(function() {
    if ($(this).scrollTop() > 200){
        $('#masthead').addClass("sticky");
        $('#up').fadeIn();
    }
    else {
        $('#masthead').removeClass("sticky");
        $('#up').fadeOut();
    }


});


