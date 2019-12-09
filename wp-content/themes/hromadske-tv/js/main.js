$=jQuery;

$(document).ready(function(){

    $(function() {
        var pull 		= $('.si-icons-default > .si-icon');
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


    $('.toggle-menu  .menu-search-input').on('input', function(e) {
        console.log ('11111111');
        if ($('.toggle-menu  .menu-search-input').val) {
            $('.toggle-menu form').addClass('active');
        } else {
            $('.toggle-menu form').removeClass('active');
        }
    });

    $('.gform_button_select_files').val('Додати файл');

    if ($(".front-content").length) {
        $(".item-important-posts").dotdotdot({});
        $(".front-project-section .item-project").dotdotdot({});
    }

    if ($(".related-item").length) {
        $(".related-item").dotdotdot({});
    }

    if ($(".list-stories").length) {
        $(".list-stories article.regular").dotdotdot({});
        $(".list-stories .dark-bg").dotdotdot({});
    }

    if ($(".list-episodes article.regular").length) {
        $(".list-episodes article.regular").dotdotdot({});
        $(".list-episodes .dark-bg").dotdotdot({});
    }

    if ($(".list-projects .small-content").length) {
        $(".list-projects .small-content").dotdotdot({});
    }

    if ($(".gallery-columns-1").length) {
        $('.gallery-columns-1').slick({
            infinite: false,
            centerMode: true,
            centerPadding: '25%',
            slidesToShow: 1,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        centerPadding: '14%',
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        centerPadding: '10%',
                    }
                }
            ]
        });

        $(".gallery-columns-1 .gallery-item").append('<span class="pagingInfo"></span>');
        var $status = $('.pagingInfo');
        var $slickElement = $('.gallery-columns-1');

        $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $status.text(i + '/' + slick.slideCount);
        });
    }




    $('#up').click(function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });

    $('.image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });


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

(function() {
    // initialize all

    [].slice.call( document.querySelectorAll( '.si-icons-default > .si-icon' ) ).forEach( function( el ) {
        var svgicon = new svgIcon( el, svgIconConfig );
    } );


})();