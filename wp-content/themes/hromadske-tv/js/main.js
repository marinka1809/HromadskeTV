$=jQuery;

$(document).ready(function(){

    artificialLink  (".item-important-posts");
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

    // $(".last-news .wrapper").dotdotdot({
    //     //	configuration goes here
    // });
});

$(window).scroll(function() {
    if ($(this).scrollTop() > 1){
        $('#masthead').addClass("sticky");
    }
    else{
        $('#masthead').removeClass("sticky");
    }
});


