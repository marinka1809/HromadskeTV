jQuery(document).ready(function($){
    $(document).on('click', '.more-news', function(){
        $(this).text('Загружаю...');
        $.ajax({
            type: 'POST',
            url:   ajaxurl,
            data: {
                action: 'add_news_func',
                query: true_posts,
                page : current_page
            },
            success: function (data) {
               // console.log('success');
                //console.log(data);
                if( data ) {
                    $('.more-news').text('Більше новин').before(data); // вставляем новые посты
                    current_page++; // увеличиваем номер страницы на единицу
                    if (current_page == max_pages) $(".more-news").remove(); // если последняя страница, удаляем кнопку
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

