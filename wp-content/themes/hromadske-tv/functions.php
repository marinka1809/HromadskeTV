<?php
/**
 * hromadske-tv functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hromadske-tv
 */

if ( ! function_exists( 'hromadske_tv_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hromadske_tv_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on hromadske-tv, use a find and replace
	 * to change 'hromadske-tv' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hromadske-tv', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
    add_image_size( 'thumbnails', 675, 380, array( 'center', 'center' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'hromadske-tv' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hromadske_tv_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;


//Video YouTube
add_action( 'after_setup_theme', 'hromadske_tv_setup' );


add_filter( 'embed_defaults', 'bigger_embed_size' );

function bigger_embed_size()
{
    return array( 'width' => 970, 'height' => 1000 );
}

add_filter('embed_oembed_html', 'vnmFunctionality_embedWrapper', 10, 4);

function vnmFunctionality_embedWrapper($html, $url, $attr, $post_id) {

    if (strpos($html, 'youtube') !== false) {
        return '<div class="youtube-wrapper">' . $html . '</div>';
    }

    return $html;
}
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hromadske_tv_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Footer', 'hromadske-tv' ),
        'id'            => 'footer-menu',
        'description'   => esc_html__( 'Add widgets here.', 'hromadske-tv' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Social section', 'hromadske-tv' ),
        'id'            => 'social-sections',
        'description'   => esc_html__( 'Add widgets here.', 'hromadske-tv' ),
        'before_widget' => '<li id="%1$s" class="col-sm-offset-3 col-sm-6 col-md-offset-0 col-md-4 widget %2$s"> <div class="wrapper">',
        'after_widget'  => '</div></li>',
        'before_title'  => '<h2 class="widget-title-social">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'hromadske_tv_widgets_init' );

/**
 * Widget title
 */
function html_widget_title( $var) {
    $var = (str_replace( '[', '<', $var ));
    $var = (str_replace( ']', '>', $var ));
    return $var ;

}
add_filter( 'widget_title', 'html_widget_title' );

/**
 * Enqueue scripts and styles.
 */
function hromadske_tv_scripts() {
	wp_enqueue_style( 'hromadske-tv-style', get_stylesheet_uri() );
    wp_enqueue_style( 'libs-css', get_template_directory_uri() . '/style/libs.css', array(), true );
    wp_enqueue_style( 'icomoonHromadske', get_template_directory_uri() . '/fonts/icomoonHromadske/style.css', array(), true );
    wp_enqueue_style( 'main', get_template_directory_uri() . '/style/main.css', array(), true );


    wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/95a5ddb753.js', true);
	wp_enqueue_script( 'hromadske-tv-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'hromadske-tv-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    wp_enqueue_script( 'libs', get_template_directory_uri() . '/js/libs.min.js', array(),  false );
    wp_enqueue_script( 'main-script', get_template_directory_uri() . '/js/main.js', array(),  false );
}
add_action( 'wp_enqueue_scripts', 'hromadske_tv_scripts' );

// We connect the function of activating the meta block (my_extra_fields)
function my_extra_fields() {
    add_meta_box( 'choice_cap', esc_html__( 'Choice of cap', 'hromadske-tv' ), 'choice_cap_func', array('post','stories','episodes'), 'side', 'high'  );
    add_meta_box( 'extra_fields', esc_html__( 'Additional notation', 'hromadske-tv' ), 'extra_fields_box_func', 'post', 'side', 'high'  );
    add_meta_box( 'stories_extra_fields', esc_html__( 'Additional notation', 'hromadske-tv'), 'stories_extra_fields_box', 'stories', 'side', 'high'  );
    add_meta_box( 'episodes_extra_fields', esc_html__( 'Additional notation', 'hromadske-tv'), 'episodes_extra_fields_box', 'episodes', 'side', 'high'  );
    global $post;
    if ( $post->post_name == donate ) {
        add_meta_box( 'bank_details', 'Section of bank details', 'bank_details_box_func', 'page', 'normal', 'high'  );
        add_meta_box( 'online_payment', 'Online payment section', 'online_payment_box_func', 'page', 'normal', 'high'  );
    };
}
add_action('add_meta_boxes', 'my_extra_fields', 1);

// Block code
function choice_cap_func( $post ){
    ?>
    <ul>
        <li>Appearance of title for single page: <?php $mark_v = get_post_meta($post->ID, 'content-cap', 1); ?></li>
        <li>
            <label><input type="radio" name="extra[content-cap]" value="image" <?php checked( $mark_v, 'image' ); ?> /> image</label>
            <label><input type="radio" name="extra[content-cap]" value="video" <?php checked( $mark_v, 'video' ); ?> /> video</label>
            <label><input type="radio" name="extra[content-cap]" value="clean" <?php checked( $mark_v, 'clean' ); ?> /> clean</label>
        </li>
        <li>
            <label>Url video: <input type="text" name="extra[url-video]" value="<?php echo get_post_meta($post->ID, 'url-video', 1); ?>" style="width:70%" /></label>
        </li>
    </ul>

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

// Block code
function extra_fields_box_func( $post ){
    ?>
    <ul>
        <li>
            <input type="hidden" name="extra[important]" value="">
            <label><input type="checkbox" name="extra[important]" value="1" <?php checked( get_post_meta($post->ID, 'important', 1), 1 )?> ><?php esc_html_e( 'Important', 'hromadske-tv' ); ?></label>
        </li>
        <li>
            <input type="hidden" name="extra[updated]" value="">
            <label><input type="checkbox" name="extra[updated]" value="1" <?php checked( get_post_meta($post->ID, 'updated', 1), 1 ) ?>"><?php esc_html_e( 'Updated', 'hromadske-tv' ); ?></label>
        </li>
    </ul>

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

// Block code stories
function stories_extra_fields_box( $stories ){
    ?>
    <ul>
        <li>
            <input type="hidden" name="extra[stick-stories]" value="">
            <label><input type="checkbox" name="extra[stick-stories]" value="1" <?php checked( get_post_meta($stories->ID, 'stick-stories', 1), 1 )?> ><?php esc_html_e( 'Stick front page', 'hromadske-tv' ); ?></label>
        </li>
        <li>
            <input type="hidden" name="extra[big-thumbnail]" value="">
            <label><input type="checkbox" name="extra[big-thumbnail]" value="1" <?php checked( get_post_meta($stories->ID, 'big-thumbnail', 1), 1 ) ?>"><?php esc_html_e( 'Big Thumbnail', 'hromadske-tv' ); ?></label>
        </li>
    </ul>

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

// Block code episodes
function episodes_extra_fields_box( $episodes ){
    ?>
    <ul>
        <li>
            <input type="hidden" name="extra[big-thumbnail]" value="">
            <label><input type="checkbox" name="extra[big-thumbnail]" value="1" <?php checked( get_post_meta($episodes->ID, 'big-thumbnail', 1), 1 ) ?>"><?php esc_html_e( 'Big Thumbnail', 'hromadske-tv' ); ?></label>
        </li>
    </ul>
    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

// Block code
function bank_details_box_func( $post ){ ?>
    <ul>
        <li>
            <label>Title for section
                <input type="text" name="extra[title-bank_details]" value="<?php echo get_post_meta($post->ID, 'title-bank_details', 1); ?>" style="width:50%" />
            </label>
        </li>
        <li>
            <label>Bank detailsn:
                <textarea type="text" rows="5" name="extra[bank_details]" style="width:100%;"><?php echo get_post_meta($post->ID, 'bank_details', 1); ?></textarea>
            </label>
        </li>
    </ul>
    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

// Block code
function online_payment_box_func( $post ){ ?>
    <ul>
        <li>
            <label>Title for section
                <input type="text" name="extra[title-online_payment]" value="<?php echo get_post_meta($post->ID, 'title-online_payment', 1); ?>" style="width:50%" />
            </label>
        </li>
        <li>
            <label>Placeholder text for the input field of sum
                <input type="text" name="extra[placeholder-sum]" value="<?php echo get_post_meta($post->ID, 'placeholder-sum', 1); ?>" style="width:50%" />
            </label>
        </li>
        <li>
            <label>Label for submit button:
                <input type="text" name="extra[label-submit]" value="<?php echo get_post_meta($post->ID, 'label-submit', 1); ?>" style="width:50%" />
            </label>
        </li>
    </ul>
    <fieldset style="border:1px solid #aaaaaa; border-radius: 5px; padding: 20px;">
        <legend>Setting for ligpay</legend>
        <ul>
            <li>
                <label>Public key:
                    <input type="text" name="extra[public-key]" value="<?php echo get_post_meta($post->ID, 'public-key', 1); ?>" style="width:50%" />
                </label>
            </li>
            <li>
                <label>Private key:
                    <input type="text" name="extra[private-key]" value="<?php echo get_post_meta($post->ID, 'private-key', 1); ?>" style="width:50%" />
                </label>
            </li>
            <li>
                <label>Purpose of payment:
                    <textarea type="text" name="extra[purpose-payment]" style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'purpose-payment', 1); ?></textarea>
                </label>
            </li>
        </ul>
    </fieldset>
    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

/* Save the data, if you save the post */
function my_extra_fields_update( $post_id ){
    if ( ! wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // Test
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // Exit if this autosave
    if ( !current_user_can('edit_post', $post_id) ) return false; // Exit if the user does not have the right to edit the record

    if( !isset($_POST['extra']) ) return false; // If there is no data? left

    // Все ОК! Теперь, нужно сохранить/удалить данные
    $_POST['extra'] = array_map('trim', $_POST['extra']); // Clean all data from spaces at the edges
    foreach( $_POST['extra'] as $key=>$value ){
        if( empty($value) ){
            delete_post_meta($post_id, $key); // Delete the field if the value is empty
            continue;
        }

        update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
    }
    return $post_id;
}

add_action('save_post', 'my_extra_fields_update', 0);


// Add term page
function pippin_taxonomy_add_new_meta_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[custom_term_meta]"><?php esc_html_e( 'Stick project', 'hromadske-tv' ); ?></label>
        <input type="hidden" name="term_meta[custom_term_meta]" value="">
        <input type="checkbox" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="1" <?php checked( get_term_meta($term->term_id, 'custom_term_meta', 1 ), 1); ?>"/>
    </div>
    <?php
}
add_action( 'projects_add_form_fields', 'pippin_taxonomy_add_new_meta_field', 10, 2 );
// Edit term page
function pippin_taxonomy_edit_meta_field($term) {?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="term_meta[custom_term_meta]"><?php esc_html_e( 'Stick project', 'hromadske-tv' ); ?></label>
        </th>
        <td>
            <input type="hidden" name="term_meta[custom_term_meta]" value="">
            <input type="checkbox" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="1" <?php checked( get_term_meta($term->term_id, 'custom_term_meta', 1 ), 1); ?>"/>
        </td>
    </tr>

    <?php
}
add_action( 'projects_edit_form_fields', 'pippin_taxonomy_edit_meta_field', 10, 2 );

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        foreach( $_POST['term_meta'] as $key=>$value ){
            if( empty($value) ){
                delete_term_meta( $term_id, $key); // Delete the field if the value is empty
                continue;
            }

            update_term_meta($term_id, $key, $value); // add_post_meta() работает автоматически
        }
    }

    return $term_id;
}
add_action( 'edited_projects', 'save_taxonomy_custom_meta', 10, 2 );
add_action( 'create_projects', 'save_taxonomy_custom_meta', 10, 2 );


/**
 * The excerpt max charlength
 */
function the_excerpt_max_charlength( $charlength ){
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}


/**
 * Plugin wptuts buttons
 */
add_action( 'init', 'wptuts_buttons' );
function wptuts_buttons() {
    add_filter( "mce_external_plugins", "wptuts_add_buttons" );
    add_filter( 'mce_buttons', 'wptuts_register_buttons' );
}
function wptuts_add_buttons( $plugin_array ) {
    $plugin_array['wptuts'] = get_template_directory_uri() . '/wptuts-editor-buttons/wptuts-plugin.js';
    return $plugin_array;
}
function wptuts_register_buttons( $buttons ) {
    array_push( $buttons, 'background-text', 'quote-type1', 'quote-type2' ); // dropcap', 'recentposts
    return $buttons;
}


/**
 * Shortcode
 */

add_shortcode( 'quote-type2', 'wp_quote_type2_func' );
function wp_quote_type2_func( $atts, $content) {
    extract( shortcode_atts( array(
        'author_name' => '',
        'author_photo'  => '',
        'author_description' => ''
    ), $atts, $content ) );
    $html = '';
    $html.= '<div class="quote-type2">';
        $html.='<blockquote>';
            $html.= $content;
        $html.='</blockquote>';
        $html.= '<cite>';
            $html.= '<div class="author-wrap">';
                $html.= '<img src="' .$atts['author_photo'] .'">';
            $html.= '</div>';
            $html.= '<span class="name">';
                $html.= $atts['author_name'];
            $html.= '</span>';
            $html.= '<span class="description">';
                $html.= $atts['author_description'];
            $html.= '</span>';
        $html.= '</cite>';
    $html.= '</div>';

    return $html;
}

function admin_ajax() {
  // wp_enqueue_script('libs');
   wp_enqueue_script( 'ajax-script', get_theme_file_uri( '/js/ajax-script.js' ), array('libs') );
}
add_action('wp_enqueue_scripts', 'admin_ajax');

function add_news_func(){
    $args = unserialize(stripslashes($_POST['query']));
    $args['paged'] = $_POST['page'] + 1;
    $args['post_status'] = 'publish';
    $args['click'] = (int)$_POST['click'];
    $url =  stristr( $_POST['my_url'], '/page', true);

    $q = new WP_Query($args);
    $important ='';
    if( $q->have_posts() ):?>
        <ul class="list-news">
            <?php while($q->have_posts()): $q->the_post(); ?>
                <?php get_template_part( 'template-parts/content-preview'); ?>
            <?php endwhile;?>
        </ul>
    <?php endif;
    wp_reset_postdata();
    if (( $args['click'] == 2)|| ($args['paged'] == $q->max_num_pages)):
        $paginate_args = array(
            'end_size'     => 2,
            'mid_size'     => 2,
        );
        $big = 999999999; // need an unlikely integer
    ?>
        <div class="blog-nav">
            <?php echo paginate_links(array(
                'base' => $url .'%_%',
                'format' => '?paged=%#%',
                'current' =>  $args['paged'],
                'total' => $q->max_num_pages,
                'prev_text'    => __('<'),
                'next_text'    => __('>'),
                'mid_size'     => 2,
            )
            );?>
        </div>
    <?php endif;
    die();
}
add_action( 'wp_ajax_add_news_func', 'add_news_func');
add_action( 'wp_ajax_nopriv_add_news_func', 'add_news_func');


function add_search_func()
{

    $fun_args['paged'] = $_POST['page'];
    $fun_args['search'] = $_POST['search'];
    $fun_args['tab'] = $_POST['tab'];
    $fun_args['click'] = (int)$_POST['click'];

    if ($fun_args ['tab'] == '#news-content') :
        $post_type = 'post';
    elseif ($fun_args ['tab'] == '#stories-content') :
        $post_type = 'stories';
    elseif ($fun_args ['tab'] == '#project-content') :
        $post_type = 'episodes';
    else:
        $post_type = array('post', 'stories', 'episodes');
    endif;

    $args = array(
        'post_type' => $post_type,
        's' => $fun_args['search'],
        'paged' => $fun_args['paged']
    );


    $q = new WP_Query($args);

    if( $q->have_posts() ):
        if (($_POST['event']=='show.tab') || ($_POST['event']=='click_pag')): ?>
            <span class="count_post" data-count="<?php echo $q->max_num_pages; ?>">
                <?php $count = $q->found_posts;
                echo 'Знайдено ' .$count .' результатів'; ?>
            </span>
        <?php endif; ?>
        <ul class="list-news">
            <?php while($q->have_posts()): $q->the_post(); ?>
                <?php get_template_part( 'template-parts/content-preview'); ?>
            <?php endwhile;?>
        </ul>

        <?php if (( ($q->max_num_pages >1) && ($fun_args['paged'] != $q->max_num_pages))
              && (($_POST['event']=='show.tab') || ($_POST['event']=='click_pag'))): ?>
            <button class="more-news" id="more-search"><?php echo get_theme_mod('label-news-button'); ?> </button>
        <?php endif;?>

    <?php endif;
    wp_reset_postdata();

    if ( (($_POST['event']=='click_more') && (( $fun_args['click']  == 2) || ($fun_args['paged']== $q->max_num_pages)))
        || (($_POST['event']=='click_pag') && ($fun_args['paged']== $q->max_num_pages) )  ):
        $paginate_args = array(
            'end_size'     => 2,
            'mid_size'     => 2,
        );
        $big = 999999999; // need an unlikely integer

        ?>
        <div class="blog-nav">
            <?php echo paginate_links(array(
                    //'base' => $_POST['my_url'] .'%_%',
                   // 'format' => '?paged=%#%',
                    'current' =>  $fun_args['paged'],
                    'total' => $q->max_num_pages,
                    'prev_text'    => __('<'),
                    'next_text'    => __('>'),
                    'mid_size'     => 2,
                )
            );?>
        </div>
    <?php endif;

    if ($_POST['event']=='click_pag'):
    endif;
    die();
}
add_action( 'wp_ajax_add_search_func', 'add_search_func');
add_action( 'wp_ajax_nopriv_add_search_func', 'add_search_func');



function make_form_func()
{
    require("payment/api.php"); //Все уже придумано за нас ...

    $micro = sprintf("%06d", (microtime(true) - floor(microtime(true))) * 1000000);
    $number = date("YmdHis");
    $order_id = $number . $micro;

    $price = $_GET['price'];
    $post = $_GET['post'];

    $merchant_id = get_post_meta($post, 'public-key', 1); //public_key
    $signature = get_post_meta($post, 'private-key', 1); //Private key



    $liqpay = new LiqPay($merchant_id, $signature);
    $html = $liqpay->cnb_form(array(
        'version' => '3',
        'amount' => "$price",
        'currency' => 'UAH',     //'EUR','UAH','USD','RUB','RUR'
        'description' => get_post_meta($post, 'purpose-payment', 1),
        'order_id' => $order_id
    ));

    echo $html;
}
add_action( 'wp_ajax_make_form_func', 'make_form_func');
add_action( 'wp_ajax_nopriv_make_form_func', 'make_form_func');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-logo.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Post Type and Custom Taxonomy
 */
require get_template_directory() . '/inc/custom-post-type.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load file wptuts editor buttons.
 */
require  get_template_directory() .'/wptuts-editor-buttons/wptuts.php';


/**
 * Autocomplete Search
 */

add_action( 'init', 'myprefix_autocomplete_init' );
function myprefix_autocomplete_init() {
    // Register our jQuery UI style and our custom javascript file
    wp_register_script( 'jquery-ui', "https://code.jquery.com/ui/1.12.1/jquery-ui.js");
    wp_register_style('myprefix-jquery-ui','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_register_script( 'my_acsearch', get_template_directory_uri() . '/js/myacsearch.js', array('libs','jquery-ui' ),null,true);
    wp_localize_script( 'my_acsearch', 'MyAcSearch', array('url' => admin_url( 'admin-ajax.php' )));
    // Function to fire whenever search form is displayed
    add_action( 'get_search_form', 'myprefix_autocomplete_search_form' );

    // Functions to deal with the AJAX request - one for logged in users, the other for non-logged in users.
    add_action( 'wp_ajax_myprefix_autocompletesearch', 'myprefix_autocomplete_suggestions' );
    add_action( 'wp_ajax_nopriv_myprefix_autocompletesearch', 'myprefix_autocomplete_suggestions' );
}

function myprefix_autocomplete_search_form(){
    wp_enqueue_script( 'my_acsearch' );
    wp_enqueue_style( 'myprefix-jquery-ui' );
}

function myprefix_autocomplete_suggestions(){
    // Query for suggestions
    $posts = get_posts( array(
        's' =>$_REQUEST['term'],
        'showposts' => 4
    ) );

    // Initialise suggestions array
    $suggestions=array();

    global $post;
    foreach ($posts as $post): setup_postdata($post);
        // Initialise suggestion array
        $suggestion = array();

        $suggestion['label'] = '<span>' .get_the_date() .'</span> ' .get_the_title();
        $suggestion['link'] = get_permalink();

        // Add suggestion to suggestions array
        $suggestions[]= $suggestion;
    endforeach;

    // JSON encode and echo
    $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
    echo $response;

    // Don't forget to exit!
    exit;
}

//https://code.tutsplus.com/tutorials/add-jquery-autocomplete-to-your-sites-search--wp-25155

function my_acf_google_map_api( $api ){

    $api['key'] = 'AIzaSyCWpDHIRvBTDtPcZj6mUk2575_Bj3kIXC0';

    return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


