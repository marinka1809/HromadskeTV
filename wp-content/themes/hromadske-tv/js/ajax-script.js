jQuery(document).ready(function($){

    var count_click = 0;
    $(document).on('click', '#more-news', function(){
        $(this).text('Загружаю...');
        this.disabled=true;
        var my_url = window.location.href;
        count_click ++;
       // console.log (count_click);
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
                if( data ) {
                    $('#more-news').text(label_button).before(data); // add new posts
                    $('#more-news').removeAttr("disabled");
                    current_page++; //Increase the page number

                    if (current_page == max_pages) $("#more-news").remove(); // Delete the button
                    if (count_click == 2) $("#more-news").remove(); // Delete the button

                }
                else {
                    $('.more-news').remove();
                }

            }, error: function (errorThrow) {
                console.log('error');
            }
        });
    });

    var search_click_all = 0;
    var search_click_news = 0;
    var search_click_stories = 0;
    var search_click_episode = 0;
    var paged_all = 1;
    var paged_news = 1;
    var paged_stories = 1;
    var paged_episode = 1;

    $(document).on('click', '#more-search', function(){
        $(this).text('Загружаю...');
        var current_page = 0;
        var count_click_search = 0;
        var tab ='#' + $(this).parent().attr('id');
        var max_pages = $(tab + ' .count_post').attr('data-count');

        if (tab=='#news-content') {
            search_click_news += 1;
            paged_news += 1;
            count_click_search = search_click_news;
            current_page = paged_news;
        }
        if (tab=='#stories-content') {
            search_click_stories += 1;
            paged_stories += 1;
            count_click_search = search_click_stories;
            current_page = paged_stories;
        }
        if (tab=='#project-content') {
            search_click_episode += 1;
            paged_episode += 1;
            count_click_search = search_click_episode;
            current_page = paged_episode;
        }
        if (tab=='#all-content') {
            search_click_all += 1;
            paged_all += 1;
            count_click_search = search_click_all;
            current_page = paged_all;
        }

        var my_url = window.location.href;

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_search_func',
                search: search,
                page: current_page,
                click: count_click_search,
                tab: tab,
                event: 'click_more'
            },
            success: function (data) {
                //console.log('success');
                var button = tab + ' #more-search';
                if (data) {

                    $(button).text('Більше новин').before(data); //add new posts

                    if (current_page == max_pages) $(button).remove(); // Delete button
                    if (count_click_search == 2) $(button).remove(); // Delete button
                }
                else {
                      $(button).remove();
                }

            }, error: function (errorThrow) {
                console.log('error');

            }
        });
    });

    $(document).on('click', '.search-page .page-numbers', function(e){
        e.preventDefault();
        var tab ='#' + $(this).parent().parent().attr('id');
        var current_page = 0;

        if (tab=='#news-content') {
            search_click_news = 0;
            if ($(this).text() == '<') {
                paged_news -= 1;
            } else if ($(this).text() == '>') {
                paged_news += 1;
            } else {
                paged_news = Number($(this).text());
            }
            current_page = paged_news;
        }
        if (tab=='#stories-content') {
            search_click_stories = 0;
            if ($(this).text() == '<') {
                paged_stories -= 1;
            } else if ($(this).text() == '>') {
                paged_stories += 1;
            } else {
                paged_stories = Number($(this).text());
            }
            current_page = paged_stories;
        }
        if (tab=='#project-content') {
            search_click_episode = 0;
            if ($(this).text() == '<') {
                paged_episode -= 1;
            } else if ($(this).text() == '>') {
                paged_episode += 1;
            } else {
                paged_episode = Number($(this).text());
            }
            current_page = paged_episode;
        }
        if (tab=='#all-content') {
            search_click_all = 0;
            if ($(this).text() == '<') {
                paged_all -= 1;
            } else if ($(this).text() == '>') {
                paged_all += 1;
            } else {
                paged_all = Number($(this).text());
            }
            current_page = paged_all;
        }
        var my_url = window.location.href;

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_search_func',
                search: search,
                page: current_page,
                click: 0,
                tab: tab,
                event: 'click_pag'
            },
            success: function (data) {
               // console.log('success');

                if (data) {
                    $(tab).empty();
                    $(tab).append(data); //add new posts
                }

            }, error: function (errorThrow) {
                console.log('error');

            }
        });
    });

    var all_show = 0;
    var news_show = 0;
    var stories_show = 0;
    var episode_show = 0;

    $('.search-nav a').on('show.bs.tab',  function (e) {

        var tab = $(this).attr('href');
        if (((tab=='#news-content') && (news_show == 0)) ||
            ((tab=='#stories-content') && (stories_show == 0)) ||
            ((tab=='#project-content') && (episode_show == 0)) ||
            ((tab=='#all-content') && (all_show == 0))) {

            if (tab=='#news-content') {news_show += 1;}
            if (tab=='#stories-content') {stories_show += 1;}
            if (tab=='#project-content') {episode_show += 1;};
            if (tab=='#all-content') {all_show += 1;};

            var my_url = window.location.href;
           // console.log(tab);
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'add_search_func',
                    search: search,
                    page: 1,
                    click: 0,
                    tab: tab,
                    event: 'show.tab'
                },
                success: function (data) {
                    console.log('success');
                    if (data) {
                        $(tab).append(data); // add new posts
                    }
                }, error: function (errorThrow) {
                    console.log('error');

                }
            });


        };

    }
    );

    $( ".search-nav #first" ).trigger( "click" );


    $(document).on('click', '.payment', function() {
        if (($('#price').val() == '') || (!/^\d+$/.test($('#price').val()))) { //Если в форму ничего не введено и нажата нопка ОК или введены не цифры, то
            $('#price').css('border-color', 'red'); //граница поля СУММЫ станет красным
        } else{
            $.ajax({
                type: 'GET',
                url:   ajaxurl,
                data: {
                    action: 'make_form_func',
                    price: $('#price').val(), //В качестве параметра передадим сумму (введенную в поле)
                    post: post
                },
                success: function (data) {
                    // console.log('success');
                   // console.log(data);
                    $('#form_responce').html(data); //И передаем эту форму в невидимое поле form_responce
                    $('#form_responce form').submit() //Сразу же автоматически сабмитим эту форму, так как всеравно клиент её не видит

                }, error: function (errorThrow) {
                    console.log('error');
                }
            });
        }
    });

});

