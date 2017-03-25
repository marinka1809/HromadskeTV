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
add_action( 'after_setup_theme', 'hromadske_tv_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hromadske_tv_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hromadske_tv_content_width', 640 );
}
add_action( 'after_setup_theme', 'hromadske_tv_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hromadske_tv_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'hromadske-tv' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'hromadske-tv' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
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
        'before_widget' => '<li id="%1$s" class="col-md-4 widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widget-title-social">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'hromadske_tv_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hromadske_tv_scripts() {
	wp_enqueue_style( 'hromadske-tv-style', get_stylesheet_uri() );
    wp_enqueue_style( 'libs-css', get_template_directory_uri() . '/style/libs.css', array(), true );
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
    add_meta_box( 'extra_fields', 'Additional notation', 'extra_fields_box_func', 'post', 'side', 'high'  );
    add_meta_box( 'stories_extra_fields', 'Additional notation', 'stories_extra_fields_box', 'stories', 'side', 'high'  );
}
add_action('add_meta_boxes', 'my_extra_fields', 1);

// Block code
function extra_fields_box_func( $post ){
    ?>
    <ul>
        <li>
            <input type="hidden" name="extra[important]" value="">
            <label><input type="checkbox" name="extra[important]" value="1" <?php checked( get_post_meta($post->ID, 'important', 1), 1 )?> > Important</label>
        </li>
        <li>
            <input type="hidden" name="extra[updated]" value="">
            <label><input type="checkbox" name="extra[updated]" value="1" <?php checked( get_post_meta($post->ID, 'updated', 1), 1 ) ?>"> Updated</label>
        </li>
        <li>
            <input type="hidden" name="extra[video]" value="">
            <label><input type="checkbox" name="extra[video]" value="1" <?php checked( get_post_meta($post->ID, 'video', 1), 1 ) ?>"> There is video</label>
        </li>
    </ul>

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

// Block code
function stories_extra_fields_box( $stories ){
    ?>
    <ul>
        <li>
            <input type="hidden" name="extra[stick-stories]" value="">
            <label><input type="checkbox" name="extra[stick-stories]" value="1" <?php checked( get_post_meta($stories->ID, 'stick-stories', 1), 1 )?> > Stick front page</label>
        </li>
        <li>
            <input type="hidden" name="extra[big-thumbnail]" value="">
            <label><input type="checkbox" name="extra[big-thumbnail]" value="1" <?php checked( get_post_meta($stories->ID, 'big-thumbnail', 1), 1 ) ?>"> Big Thumbnail</label>
        </li>
    </ul>

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
