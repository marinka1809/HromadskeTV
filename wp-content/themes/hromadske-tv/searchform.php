<div class="menu-search-container">
    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ) ?>" >
        <button class="submit" type="submit" id="searchsubmit">
            <span class="icon-search"></span>
        </button>
        <input class="menu-search-input" type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Пошук..." autofocus>
        <a class="menu-search-close icon-search-cross" href="#"></a>
    </form>
</div>