jQuery(document).ready(function($){
    var count_click = 0;
    $(document).on('click', '.more-news', function(){
        $(this).text('Загружаю...');
        var my_url = window.location.href;
        count_click ++;
        console.log (count_click);
        $.ajax({
            type: 'POST',
            url:   ajaxurl,
            data: {
                action: 'add_news_func',
                query: true_posts,
                page : current_page,
                click: count_click,
                my_url: my_url
            },
            success: function (data) {
               // console.log('success');
                //console.log(data);
                if( data ) {
                    $('.more-news').text('Більше новин').before(data); // вставляем новые посты
                    current_page++; // увеличиваем номер страницы на единицу

                    if (current_page == max_pages) $(".more-news").remove(); // если последняя страница, удаляем кнопку
                    if (count_click == 2) $(".more-news").remove(); // если последняя страница, удаляем кнопку
                }
                else {
                    $('.more-news').remove();
                }

            }, error: function (errorThrow) {
                console.log('error');
            }
        });
    });

});

