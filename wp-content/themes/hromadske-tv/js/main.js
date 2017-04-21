$=jQuery;

$(document).ready(function(){

    artificialLink  (".item-important-posts");
    artificialLink  (".related-item");
    artificialLink  (".item-project");
    artificialLink  (".big-item-project");

    artificialLink  (".list-stories li");

    artificialLink  (".list-episodes li");

    function artificialLink(element) {

        $(element).on("click", function (e) {
            if (!(e.target.getAttribute('href')== null)) {
                href= e.target.getAttribute('href');
            }
            else {
                href = $(this).attr("data-href");
            }
            window.location.href=href;
            e.preventDefault();
        });
    }

    $(".item-important-posts").dotdotdot({
        //	configuration goes here
    });

    $(".related-item").dotdotdot({
        //	configuration goes here
    });

    $(".front-project-section .item-project").dotdotdot({
        //	configuration goes here
    });

    $(".list-stories article.regular").dotdotdot({
        //	configuration goes here
    });

    $(".list-stories .dark-bg").dotdotdot({
        //	configuration goes here
    });

    $(".list-episodes article.regular").dotdotdot({
        //	configuration goes here
    });

    $(".list-episodes .dark-bg").dotdotdot({
        //	configuration goes here
    });

    $(".list-projects .small-content").dotdotdot({
        //	configuration goes here
    });


    $('.gallery-columns-1').slick({
        centerMode: true,
        centerPadding: '25%',
        slidesToShow: 1,
        autoplay: true,
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




    // var $gallery = $('.gallery-columns-1');
    // var slideCount = null;
    //
    // $gallery.on('init', function(event, slick){
    //     slideCount = slick.slideCount;
    //     console.log("slideCount" +slideCount);
    //     $(".gallery-columns-1 .gallery-item").append("<div class='index'><span class='current'></span>/" + slideCount +"</div>");
    //     setCurrentSlideNumber(slick.currentSlide);
    // });
    //
    // $gallery.on('beforeChange', function(event, slick, currentSlide, nextSlide){
    //     setCurrentSlideNumber(nextSlide);
    // });
    //
    //
    // function setCurrentSlideNumber(currentSlide) {
    //
    //     console.log(currentSlide + 1);
    //     var $el = $('.index').find('.current');
    //     $el.text(currentSlide + 1);
    // }



});

$(window).scroll(function() {
    if ($(this).scrollTop() > 1){
        $('#masthead').addClass("sticky");
    }
    else{
        $('#masthead').removeClass("sticky");
    }
});


