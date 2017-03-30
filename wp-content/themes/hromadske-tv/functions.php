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
    add_meta_box( 'extra_fields', esc_html__( 'Additional notation', 'hromadske-tv' ), 'extra_fields_box_func', 'post', 'side', 'high'  );
    add_meta_box( 'stories_extra_fields', esc_html__( 'Additional notation', 'hromadske-tv'), 'stories_extra_fields_box', 'stories', 'side', 'high'  );
    add_meta_box( 'episodes_extra_fields', esc_html__( 'Additional notation', 'hromadske-tv'), 'episodes_extra_fields_box', 'episodes', 'side', 'high'  );
}
add_action('add_meta_boxes', 'my_extra_fields', 1);

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
        <li>
            <input type="hidden" name="extra[video]" value="">
            <label><input type="checkbox" name="extra[video]" value="1" <?php checked( get_post_meta($post->ID, 'video', 1), 1 ) ?>"><?php esc_html_e( 'There is video', 'hromadske-tv' ); ?></label>
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
    $q = new WP_Query($args);
    if( $q->have_posts() ):?>
        <ul class="list-news">
            <?php while($q->have_posts()): $q->the_post(); ?>
                <li>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('news'); ?> >
                        <div class="info-news">
                            <?php
                            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
                            }

                            $time_string = sprintf( $time_string,
                                esc_attr( get_the_date( 'c' ) ),
                                esc_html( get_the_date() ),
                                esc_attr( get_the_modified_date( 'c' ) ),
                                esc_html( get_the_modified_date() )
                            );
                            ?>
                            <a href="<?php  get_permalink();?>" rel="bookmark"> <?php echo $time_string?> </a>
                            <?php if ( get_post_meta($q->the_post->ID,'important')):
                                $important = "important" ?>
                                <span class="important-label"><?php echo get_theme_mod('label-important-news'); ?></span>
                            <?php endif;?>
                            <?php if ( get_post_meta($q->the_post->ID,'updated')):?>
                                <span class="updated-label"><?php echo get_theme_mod('label-updated-news'); ?></span>
                            <?php endif;?>

                        </div>
                        <h2 class="<?php echo $important;?>">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title();?>
                                <?php if ( get_post_meta($q->the_post->ID,'video')):?>
                                    <span class="fa <?php echo get_theme_mod('video-icon'); ?>" aria-hidden="true"></span>
                                <?php endif; ?>
                            </a>
                        </h2>
                    </article><!-- #post-## -->
                </li>
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
                'base' => $_POST['my_url'] .'%_%',
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
