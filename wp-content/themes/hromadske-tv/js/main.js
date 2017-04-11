$=jQuery;

$(document).ready(function(){

    artificialLink  (".item-important-posts");
    artificialLink  (".item-project");
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

    // $(".last-news .wrapper").dotdotdot({
    //     //	configuration goes here
    // });
});


