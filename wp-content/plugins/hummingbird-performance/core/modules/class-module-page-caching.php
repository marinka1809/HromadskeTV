<?php
/**
 * Page caching class.
 *
 * For easier code maintenance and support, class is split into sections:
 * I.   INIT FUNCTIONS
 * II.  HELPER FUNCTIONS
 * III. FILESYSTEM FUNCTIONS
 * IV.  CACHE CONTROL FUNCTIONS
 * V.   ACTIONS AND FILTERS
 *
 * @package Hummingbird
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WP_Hummingbird_Module_Page_Caching
 *
 * @since 1.7.0
 */
class WP_Hummingbird_Module_Page_Caching extends WP_Hummingbird_Module {

	/**
	 * Last error.
	 *
	 * @since 1.7.0
	 * @var   WP_Error $error
	 */
	public $error = false;

	/**
	 * Start time when caching a file.
	 * Used for calculating the amount of time it takes to build the cached file.
	 *
	 * @since 1.7.0
	 * @var   int $start_tine
	 */
	private $start_tine;

	/**
	 * Execute module actions
	 *
	 * @since 1.7.0
	 */
	public function run() {
		// - Try to define( 'WP_CACHE', true ) in wp-config.php.

		// Post status transitions.
		add_action( 'edit_post', array( $this, 'post_edit' ), 0 );
		add_action( 'transition_post_status',  array( $this, 'post_status_change' ), 10, 3 );
	}

	/**
	 * Initialize module.
	 *
	 * @since 1.7.0
	 */
	public function init() {
		// Init modules and perform pre-run checks.
		$this->check_plugin_compatibility();
		$this->check_minification_queue();
		$this->init_filesystem();

		// Only cache pages when the module is active and there are no errors.
		if ( $this->is_active() && ! is_wp_error( $this->error ) ) {
			add_action( 'init', array( $this, 'init_caching' ) );
		}
	}

	/**
	 * Activate page cache.
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Caching_Page::run_actions()
	 */
	public function activate() {
		wphb_update_setting( 'page_cache', true );
		if ( $this->check_wp_settings() ) {
			$this->init_filesystem();
			$this->write_wp_config();
		}
	}

	/**
	 * Disable page caching:
	 * - removes advanced-cache.php file
	 * - removes WP_CACHE from wp-config.php
	 * - purge cache folder
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Caching_Page::run_actions()
	 */
	public function deactivate() {
		wphb_update_setting( 'page_cache', false );
		$this->cleanup();
	}

	/***************************
	 *
	 * I. INIT FUNCTIONS
	 *
	 * check_plugin_compatibility()
	 * check_minification_queue()
	 * init_filesystem()
	 *
	 ***************************/

	/**
	 * Check for other caching plugins.
	 * Add error if incompatible plugin detected.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::init()
	 */
	private function check_plugin_compatibility() {
		if ( is_wp_error( $this->error ) || ! $this->is_active() ) {
			return;
		}

		$caching_plugins = array(
			'wp-super-cache/wp-cache.php'         => 'WP Super Cache',
			'w3-total-cache/w3-total-cache.php'   => 'W3 Total Cache',
			'wp-fastest-cache/wpFastestCache.php' => 'WP Fastest Cache',
			'litespeed-cache/litespeed-cache.php' => 'LiteSpeed Cache',
		);

		foreach ( $caching_plugins as $plugin => $plugin_name ) {
			if ( in_array( $plugin, get_option( 'active_plugins', array() ), true ) ) {
				$this->error = new WP_Error(
					'caching-plugin-detected',
					/* translators: %s: plugin name. */
					sprintf( __( '%s plugin detected. Please disable it to use Hummingbird page caching functionality.', 'wphb' ), $plugin_name )
				);
				break;
			}
		}

		// See if there's already an advanced-cache.php file in place.
		$adv_cache_file = dirname( get_theme_root() ) . '/advanced-cache.php';
		if ( file_exists( $adv_cache_file ) && false === strpos( file_get_contents( $adv_cache_file ), 'WPHB_ADVANCED_CACHE' ) ) {
			$this->error = new WP_Error(
				'advanced-cache-detected',
				__( 'Hummingbird detected an advanced-cache.php file in wp-content directory. Please disable any other caching plugins on order to use Page Caching.', 'wphb' )
			);
		}
	}

	/**
	 * Check for active minification queue.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::init()
	 */
	private function check_minification_queue() {
		if ( is_wp_error( $this->error ) || ! $this->is_active() ) {
			return;
		}

		/*
		 * Maybe better to check queue this way?
		 * get_transient( 'wphb-processing' )
		 */
		$queue = get_option( 'wphb_process_queue', array() );
		if ( ! empty( $queue ) ) {
			$this->error = new WP_Error(
				'min-queue-present',
				__( 'Page caching halted while minification queue is being processed. This can take a few minutes..', 'wphb' )
			);
		}
	}

	/**
	 * Init filesystem.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::init()
	 */
	private function init_filesystem() {
		if ( is_wp_error( $this->error ) || ! $this->is_active() ) {
			return;
		}

		// Init filesystem.
		global $wphb_fs;

		if ( ! $wphb_fs ) {
			$wphb_fs = WP_Hummingbird_Filesystem::instance();
		}

		if ( is_wp_error( $wphb_fs->status ) ) {
			$this->error = $wphb_fs->status;
		}

		// Try to add advanced-cache.php file.
		$adv_cache_file_source = dirname( plugin_dir_path( __FILE__ ) ) . '/advanced-cache.php';
		$adv_cache_file_destination = dirname( get_theme_root() ) . '/advanced-cache.php';
		if ( file_exists( $adv_cache_file_source ) ) {
			copy( $adv_cache_file_source, $adv_cache_file_destination );
		}

		// Try to define WP_CACHE in wp-config.php file.
		$this->check_wp_settings();
	}

	/***************************
	 *
	 * II. HELPER FUNCTIONS
	 * Most of the methods here are private and static because they are internal.
	 *
	 * load_config()
	 * get_settings()
	 * check_wp_settings()
	 * get_page_types()
	 * get_file_cache_path()
	 * get_site_slug()
	 * get_cookies()
	 * skip_url()
	 * skip_user_agent()
	 * skip_page_type()
	 * logged_in_user()
	 *
	 ***************************/

	/**
	 * Get config from file and prepare for use.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::should_cache_request()
	 */
	private static function load_config() {
		global $wphb_cache_config;

		wphb_log( 'Loading config file.', 'page-caching' );

		$config_file = WP_CONTENT_DIR . '/wphb-cache/wphb-cache.php';
		if ( ! file_exists( $config_file ) ) {
			// TODO: create file if it does not exist
			wphb_log( 'Config file does not exist.', 'page-caching' );
			return;
		}

		$settings = json_decode( file_get_contents( $config_file ), true );

		$wphb_cache_config = new stdClass();
		$wphb_cache_config->cache_dir  = WP_CONTENT_DIR . '/wphb-cache/cache/';
		// Cache selected page types.
		$wphb_cache_config->page_types = $settings['page_types'];

		// Cache if user is logged in.
		$wphb_cache_config->cache_logged_in       = (bool) $settings['settings']['logged_in'];
		// Cache if the URL has $_GET params or not.
		$wphb_cache_config->cache_with_get_params = (bool) $settings['settings']['url_queries'];
		// Clear cache on update
		$wphb_cache_config->clear_on_update       = (bool) $settings['settings']['clear_update'];
		// Enable debug log
		$wphb_cache_config->debug_log             = (bool) $settings['settings']['debug_log'];

		$wphb_cache_config->exclude_url    = $settings['exclude']['url_strings'];
		$wphb_cache_config->exclude_agents = $settings['exclude']['user_agents'];
	}

	/**
	 * Check if the config file is in place and get the settings.
	 *
	 * TODO: refactor this. Now only used to get settings in page caching page. We need to create a file if id doesn't exist for the method above
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Caching_Page::page_caching_metabox()
	 */
	public function get_settings() {
		/* @var WP_Hummingbird_Filesystem $wphb_fs */
		global $wphb_fs;

		$config_file = $wphb_fs->basedir . 'wphb-cache.php';

		if ( file_exists( $config_file ) ) {
			$settings = json_decode( file_get_contents( $config_file ), true );
		} else {
			wphb_log( 'Config file not found at: ' . $config_file, 'page-caching' );
			$settings = array(
				'page_types' => array_keys( $this->get_page_types() ),
				'settings'   => array(
					'logged_in'    => 0,
					'url_queries'  => 0,
					'clear_update' => 0,
					'debug_log'    => 0,
				),
				'exclude'    => array(
					'url_strings' => array( 'wp-.*\.php', 'index\.php', 'xmlrpc\.php' ),
					'user_agents' => array( 'bot', 'is_archive', 'slurp', 'crawl', 'spider', 'Yandex' ),
				),
			);

			$this->write_file( $config_file, json_encode( $settings ) );
		}

		return $settings;
	}

	/**
	 * Check if WP_CACHE is set.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::activate()
	 * @return  bool
	 */
	private function check_wp_settings() {
		// WP_CACHE is already defined.
		if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
			return true;
		}

		$config_file = ABSPATH . 'wp-config.php';

		// Could not find the file.
		if ( ! file_exists( $config_file ) ) {
			$this->error = new WP_Error(
				'no-wp-config-file',
				__( "Hummingbird could not locate the wp-config.php file for WordPress. Please make sure the following line is added to the file: <br><code>define('WP_CACHE', true);</code>", 'wphb' )
			);

			return false;
		}

		// wp-config.php is not writable.
		if ( ! is_writeable( $config_file ) || ! is_writable( dirname( $config_file ) ) ) {
			$this->error = new WP_Error(
				'wp-config-not-writable',
				__( "Hummingbird could not write to the wp-config.php file. Please add the following line to the file manually: <br><code>define('WP_CACHE', true);</code>", 'wphb' )
			);

			return false;
		}

		return true;
	}

	/**
	 * Return the list of available page types.
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Module_Page_Caching::get_settings()
	 * @used-by WP_Hummingbird_Caching_Page::page_caching_metabox()
	 *
	 * @return array
	 */
	public function get_page_types() {
		$pages = array(
			'frontpage' => __( 'Frontpage', 'wphb' ),
			'home'      => __( 'Blog', 'wphb' ),
			'page'      => __( 'Pages', 'wphb' ),
			'single'    => __( 'Posts', 'wphb' ),
			'archive'   => __( 'Archives', 'wphb' ),
			'category'  => __( 'Categories', 'wphb' ),
			'tag'       => __( 'Tags', 'wphb' ),
			'product'   => __( 'Products', 'wphb' ),
		);

		return $pages;
	}

	/**
	 * Return file path for the cached file.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::serve_cache()
	 * @used-by WP_Hummingbird_Module_Page_Caching::init_caching()
	 * @param   string $request_uri  URI string.
	 */
	private static function get_file_cache_path( $request_uri ) {
		global $wphb_cache_config, $wphb_cache_file;

		// Prepare some varibales.
		$http_host   = htmlentities( stripslashes( $_SERVER['HTTP_HOST'] ) ); // Input var ok.
		$port        = isset( $_SERVER['SERVER_PORT'] ) ? intval( $_SERVER['SERVER_PORT'] ) : 0; // Input var ok.

		// TODO: move this out to the fs module?
		// Will get rid of a big function below.
		$site_slug = self::get_site_slug( $http_host, $request_uri );

		// We drop the site slug on directory multisite and only keep it for main page of main blog.
		if ( wphb_cache_is_multisite() && ! wphb_cache_is_subdomain_install() && '/' !== $request_uri ) {
			$site_slug = '';
		}

		/**
		 * Generate cache hash.
		 */
		// Remove index.php from query.
		$hash = str_replace( '/index.php', '/', $request_uri );
		// Remove any query hash from request URI.
		$hash = preg_replace( '/#.*$/', '', $hash );
		$cookies = self::get_cookies();
		$hash = md5( $http_host . $hash . $port . $cookies );

		// Remove get params.
		$request_uri = preg_replace( '/(\?.*)?$/', '', $request_uri );

		$wphb_cache_file = str_replace( '//', '/', $wphb_cache_config->cache_dir . $site_slug . $request_uri . $hash . '.html' );
		wphb_log( 'Caching to file: ' . $wphb_cache_file, 'page-caching' );
	}

	/**
	 * Get site slug based on the type of website (multisite or single).
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Module_Page_Caching::get_file_cache_path()
	 * @used-by WP_Hummingbird_Module_Page_Caching::purge_cache_dir()
	 * @param   string $http_host    HTTP host.
	 * @param   string $request_uri  Request uri.
	 *
	 * @return bool|mixed|string
	 */
	private static function get_site_slug( $http_host, $request_uri ) {
		// Will define the subfolder in cache for multisites.
		$site_slug = $http_host;

		if ( wphb_cache_is_multisite() && ! wphb_cache_is_subdomain_install() ) {
			// Thanks to WP Super Cache.
			$request_uri = str_replace( '..', '', preg_replace( '/[ <>\'\"\r\n\t\(\)]/', '', $request_uri ) );
			if ( strpos( $request_uri, '/', 1 ) ) {
				// This code will execute everywhere on directory multisite, except home page of main blog.
				$site_slug = $request_uri;
				$site_slug = substr( $site_slug, 0, strpos( $site_slug, '/', 1 ) );
				if ( '/' === substr( $site_slug, - 1 ) ) {
					$site_slug = substr( $site_slug, 0, - 1 );
				}
			}
			$site_slug = str_replace( '/', '', $site_slug );
		}

		$site_slug = rtrim( $site_slug, '/\\' ) . '/';

		return $site_slug;
	}

	/**
	 * Get cookie keys for generating file hash.
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Module_Page_Caching::prepare_file()
	 *
	 * @return string
	 */
	private static function get_cookies() {
		static $cookie_value = '';

		if ( ! empty( $cookie_value ) ) {
			wphb_log( 'Cookie cached: ' . $cookie_value, 'page-caching' );
			return $cookie_value;
		}

		foreach ( (array) $_COOKIE as $key => $value ) { // Input var ok.
			// Check password protected post, comment author, logged in user.
			if ( preg_match( '/^wp-postpass_|^comment_author_|^wordpress_logged_in_/', $key ) ) {
				wphb_log( 'Found cookie: ' . $key, 'page-caching' );
				$cookie_value .= $_COOKIE[ $key ] . ','; // Input var ok.
			}
		}

		if ( ! empty( $cookie_value ) ) {
			$cookie_value = md5( $cookie_value );
			wphb_log( 'Cookie hashed value: ' . $cookie_value, 'page-caching' );
		}

		return $cookie_value;
	}

	/**
	 * Check if the URL is in the exception list in the settings.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::should_cache_request()
	 * @param   string $uri
	 *
	 * @return bool
	 */
	private static function skip_url( $uri ) {
		global $wphb_cache_config;

		if ( ! is_array( $wphb_cache_config->exclude_url ) ) {
			return false;
		}

		$uri_pattern = implode( '|', $wphb_cache_config->exclude_url );
		if ( preg_match( "/{$uri_pattern}/i", $uri ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the user agent is in the exception list in the settings.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::should_cache_request()
	 *
	 * @return bool
	 */
	private static function skip_user_agent() {
		global $wphb_cache_config;

		if ( ! is_array( $wphb_cache_config->exclude_agents ) ) {
			return false;
		}

		$agent = $_SERVER['HTTP_USER_AGENT'];
		$agent_pattern = implode( '|', $wphb_cache_config->exclude_agents );

		// In case no user agent or agen in exclude list, we do not cache the page.
		// TODO: maybe in_array() will be better here?
		if ( empty( $agent ) || preg_match( "/{$agent_pattern}/i", $agent ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Skip page type selected in settings.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::cache_request()
	 *
	 * @return bool
	 */
	private static function skip_page_type() {
		global $wphb_cache_config;

		if ( ! is_array( $wphb_cache_config->page_types ) ) {
			return false;
		}

		// TODO: add search, author, feed and 404 pages.
		if ( is_front_page() && ! in_array( 'frontpage', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( is_home() && ! in_array( 'home', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( is_page() && ! in_array( 'page', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( is_single() && ! in_array( 'single', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( is_archive() && ! in_array( 'archive', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( is_category() && ! in_array( 'category', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( is_tag() && ! in_array( 'tag', $wphb_cache_config->page_types, true ) ) {
			return true;
		} elseif ( in_array( 'product', $wphb_cache_config->page_types, true ) ) {
			// Check if WooCommerce product.
			if ( function_exists( 'is_product' ) && is_product() ) {
				return true;
			}

			// Check if MarketPress product.
			if ( class_exists( 'MP_Product' ) ) {
				return ( is_singular( 'product' ) || is_singular( 'mp_product' ) );
			}
		}

		return false;
	}

	/**
	 * Check if the user is logged in.
	 *
	 * @since 1.7.0
	 * @access private
	 * @used-by WP_Hummingbird_Module_Page_Caching::should_cache_request()
	 *
	 * @return bool
	 */
	private static function logged_in_user() {
		if ( function_exists( 'is_user_logged_in' ) ) {
			return is_user_logged_in();
		}

		foreach ( (array) $_COOKIE as $key => $value ) { // Input var ok.
			// Check logged in user.
			if ( preg_match( '/^wordpress_logged_in_/', $key ) ) {
				return true;
			}
		}

		return false;
	}

	/***************************
	 *
	 * III. FILESYSTEM FUNCTIONS
	 *
	 * write_file()
	 * add_index()
	 * save_settings()
	 * cleanup()
	 * write_wp_config()
	 *
	 ***************************/

	/**
	 * Write page buffer to file.
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Module_Page_Caching::get_settings()
	 * @used-by WP_Hummingbird_Module_Page_Caching::cache_request()
	 * @param   string $file     File name.
	 * @param   string $content  File content.
	 */
	private function write_file( $file, $content ) {
		/* @var WP_Hummingbird_Filesystem $wphb_fs */
		global $wphb_fs;

		// TODO: maybe write to a temp file first?
		$wphb_fs->write( $file, $content );
		$this->add_index( dirname( $file ) );
	}

	/**
	 * Add empty index.html file for protection.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @param   string $dir  Directory path.
	 * @used-by WP_Hummingbird_Module_Page_Caching::write_file()
	 */
	private function add_index( $dir ) {
		if ( is_dir( $dir ) && is_file( "{$dir}/index.html" ) ) {
			return;
		}

		$file = fopen( "{$dir}/index.html", 'w' );
		if ( $file ) {
			fclose( $file );
		}
	}

	/**
	 * Save settings to file.
	 *
	 * @since   1.7.0
	 * @param   array $settings  Settings array.
	 * @used-by WP_Hummingbird_Caching_Page::on_load()
	 */
	public function save_settings( $settings ) {
		if ( ! is_array( $settings ) ) {
			return;
		}

		/* @var WP_Hummingbird_Filesystem $wphb_fs */
		global $wphb_cache_config, $wphb_fs;

		$wphb_cache_config = new stdClass();
		$wphb_cache_config->cache_dir = $wphb_fs->cache_dir;

		$config_file = $wphb_fs->basedir . 'wphb-cache.php';

		wphb_log( 'Writing configuration to: ' . $config_file, 'page-caching' );
		$this->write_file( $config_file, json_encode( $settings ) );

		$this->purge_cache_dir();
	}

	/**
	 * Cleanup procedures: purge cache folder and remove advanced-cache.php file.
	 *
	 * @since   1.7.0
	 * @used-by uninstall.php
	 * @used-by WP_Hummingbird_Installer::deactivate()
	 * @used-by WP_Hummingbird_Module_Page_Caching::deactivate()
	 */
	public function cleanup() {
		// Purge cache folder.
		/* @var WP_Hummingbird_Filesystem $wphb_fs */
		global $wphb_fs;
		if ( $wphb_fs->purge( 'cache' ) ) {
			wphb_log( 'Page cache deactivation: successfully purged cache folder.', 'page-caching' );
		} else {
			wphb_log( 'Page cache deactivation: error purging cache folder.', 'page-caching' );
		}

		$this->write_wp_config( true );

		// Remove advanced-cache.php.
		$adv_cache_file = dirname( get_theme_root() ) . '/advanced-cache.php';

		// If no file or file not writable - exit.
		if ( ! file_exists( $adv_cache_file ) || ! is_writable( $adv_cache_file ) ) {
			return;
		}

		// Remove only Hummingbird file.
		if ( false !== strpos( file_get_contents( $adv_cache_file ), 'WPHB_ADVANCED_CACHE' ) ) {
			unlink( $adv_cache_file );
			wphb_log( 'Page cache deactivation: advanced-cache.php file removed.', 'page-caching' );
		}
	}

	/**
	 * Try to add define('WP_CACHE', true); to wp-config.php file.
	 *
	 * @since   1.7.0
	 * @acess   private
	 * @used-by WP_Hummingbird_Module_Page_Caching::activate()
	 * @param   bool $uninstall  Remove WP_CACHE from wp-config.php file.
	 * @return  bool
	 */
	private function write_wp_config( $uninstall = false ) {
		$config_file = ABSPATH . 'wp-config.php';

		$fp = fopen( $config_file, 'r+' );
		if ( ! $fp ) {
			wphb_log( 'Failed to open wp-config.php for writing.', 'page-caching' );
			return false;
		}

		// Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
		flock( $fp, LOCK_EX );

		$lines = array();
		while ( ! feof( $fp ) ) {
			$lines[] = rtrim( fgets( $fp ), "\r\n" );
		}

		// Generate the new file data
		$new_file = array();
		$found_code = false;
		foreach ( $lines as $line ) {
			if ( preg_match( '/WP_CACHE/i', $line ) ) {
				$found_code = true;
				if ( ! $uninstall ) {
					wphb_log( "Added define('WP_CACHE', true) to wp-config.php file.", 'page-caching' );
					$new_file[] = "define('WP_CACHE', true); // Added by WP Hummingbird";
				} else {
					wphb_log( "Removed define('WP_CACHE', true) from wp-config.php file.", 'page-caching' );
				}
			} elseif ( ! $found_code && ! $uninstall && preg_match( "/\/\*\ That\'s all, stop editing! Happy blogging.\ \*\//i", $line ) ) {
				wphb_log( "Added define('WP_CACHE', true) to wp-config.php file.", 'page-caching' );
				$new_file[] = "define('WP_CACHE', true); // Added by WP Hummingbird";
				$new_file[] = $line;
			} else {
				$new_file[] = $line;
			}
		}

		$new_file_data = implode( "\n", $new_file );

		// Write to the start of the file, and truncate it to that length
		fseek( $fp, 0 );
		$bytes = fwrite( $fp, $new_file_data );
		if ( $bytes ) {
			ftruncate( $fp, ftell( $fp ) );
		}
		fflush( $fp );
		flock( $fp, LOCK_UN );
		fclose( $fp );

		return (bool) $bytes;
	}

	/***************************
	 *
	 * IV. CACHE CONTROL FUNCTIONS
	 *
	 * should_cache_request()
	 * cache_request()
	 * send_headers()
	 * purge_cache_dir()
	 * purge_post_cache()
	 *
	 ***************************/

	/**
	 * Should we cache the request or not.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::serve_cache()
	 * @used-by WP_Hummingbird_Module_Page_Caching::init_caching()
	 * @param   string $request_uri
	 *
	 * @return bool
	 */
	private static function should_cache_request( $request_uri ) {
		global $wphb_cache_config;

		self::load_config();

		if ( ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wphb_log( 'Page not cached because of active cron or ajax request.', 'page-caching' );
			return false;
		} elseif ( is_admin() ) {
			wphb_log( 'Do not cache admin pages.', 'page-caching' );
			return false;
		} elseif ( self::logged_in_user() && ! $wphb_cache_config->cache_logged_in ) {
			wphb_log( 'Do not cache pages for logged in users.', 'page-caching' );
			return false;
		} elseif ( isset( $_SERVER['REQUEST_METHOD'] ) && 'GET' !== $_SERVER['REQUEST_METHOD'] ) { // Input var okay.
			wphb_log( 'Skipping page. Used ' . $_SERVER['REQUEST_METHOD'] . ' method. Only GET allowed.', 'page-caching' );
			return false;
		} elseif ( isset( $_GET['preview'] ) ) { // Input var okay.
			wphb_log( 'Do not cache preview post pages.', 'page-caching' );
			return false;
		} elseif ( false === empty( $_GET ) && ! $wphb_cache_config->cache_with_get_params ) { // Input var ok.
			wphb_log( 'Skipping page with GET params.', 'page-caching' );
			return false;
		} elseif ( preg_match( '/^\/wp.*php$/', strtok( $request_uri, '?' ) ) ) {
			// Remove string parameters and do not cache any /wp-login.php or /wp-admin/*.php pages.
			// TODO: Maybe improve regex, as it takes a bit more than needed.
			wphb_log( 'Do not cache wp-admin pages.', 'page-caching' );
			return false;
		} elseif ( self::skip_url( $request_uri ) ) {
			wphb_log( 'Do not cache page. URL exclusion rule match: ' . $request_uri, 'page-caching' );
			return false;
		} elseif ( self::skip_user_agent() ) {
			wphb_log( 'Do not cache page. User-Agent is empty or excluded in settings.', 'page-caching' );
			return false;
		} elseif ( ! isset( $_SERVER['HTTP_HOST'] ) ) { // Input var ok.
			wphb_log( 'Page can not be cached, no HTTP_HOST set.', 'page-caching' );
			return false;
		} // End if().

		// TODO Check for object cache?
		wphb_log( 'Request passed should_cache_request check. Ready to cache.', 'page-caching' );

		return true;
	}

	/**
	 * Parse the buffer. Used in callback for ob_start in init_caching().
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Module_Page_Caching::init_caching()
	 * @param   string $buffer  Page buffer.
	 *
	 * @return mixed
	 */
	public function cache_request( $buffer ) {
		global $wphb_cache_file;

		$cache_page = true;

		if ( empty( $buffer ) ) {
			$cache_page = false;
			wphb_log( 'Empty buffer. Exiting.', 'page-caching' );
		}

		if ( defined( 'DONOTCACHEPAGE' ) && DONOTCACHEPAGE ) {
			$cache_page = false;
			wphb_log( 'Page not cached because DONOTCACHEPAGE is defined.', 'page-caching' );
		} elseif ( is_404() ) {
			$cache_page = false;
			wphb_log( 'Do not cache 404 pages.', 'page-caching' );
		} elseif ( self::skip_page_type() ) {
			$cache_page = false;
			wphb_log( 'Do not cache page. Skipped in settings.', 'page-caching' );
		} elseif ( ! preg_match( '/(<\/html>|<\/rss>|<\/feed>|<\/urlset|<\?xml)/i', $buffer ) ) {
			$cache_page = false;
			wphb_log( 'HTML corrupt. Page not cached.', 'page-caching' );
		}

		if ( ! $cache_page ) {
			return $buffer;
		}

		$content = $buffer;
		$time_to_create = microtime( true ) - $this->start_tine;
		$content .= '<!-- Hummingbird cache file was created in ' . $time_to_create . ' seconds, on ' . date( 'd-m-y G:i:s', current_time( 'timestamp' ) ) . ' -->';

		if ( $wphb_cache_file ) {
			wphb_log( 'Saving page to cache file: ' . $wphb_cache_file, 'page-caching' );
			$this->write_file( $wphb_cache_file, $content );
		}

		return $buffer;
	}

	/**
	 * Send headers to the browser.
	 *
	 * @since   1.7.0
	 * @access  private
	 * @used-by WP_Hummingbird_Module_Page_Caching::init_caching()
	 * @used-by WP_Hummingbird_Module_Page_Caching::start_cache()
	 */
	private static function send_headers() {
		global $wphb_cache_file;

		// Get meta from meta file. Meta should contain headers.
		$meta = array(
			'headers' =>
				array(
					/*
					 * Vary: Accept-Encoding only with Content-Encoding: gzip
					 * Do we want to Vary: Cookie?
					 * https://www.fastly.com/blog/best-practices-using-vary-header/
					 */
					'Vary'          => 'Vary: Accept-Encoding, Cookie',
					//'Expires'       => 'Expires: Thu, 19 Nov 1981 08:52:00 GMT',
					'Content-Type'  => 'Content-Type: text/html; charset=UTF-8',
					'Cache-Control' => 'Cache-Control: max-age=3, must-revalidate',
					//'Cache-Control' => 'Cache-Control: max-age=0, no-store, no-cache, must-revalidate',
					/* Pragma is used for backward compatibility with HTTP/1.0 clients */
					//'Pragma'        => 'Pragma: no-cache',
					//'Last-Modified' => 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', filemtime( $wphb_cache_file ) ) . ' GMT',
				),
			'uri'     => 'local.wordpress.dev/?switched_off=true',
			'blog_id' => 1,
			'post'    => 0,
			'hash'    => 'local.wordpress.dev80/?switched_off=true',
		);

		// Check last modified time or file.
		$file_modified = filemtime( $wphb_cache_file );
		if ( isset( $file_modified ) ) {
			$meta['headers']['Last-Modified'] = 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $file_modified ) . ' GMT';
		} else {
			$meta['headers']['Last-Modified'] = 'HTTP/1.0 304 Not Modified';
		}

		foreach ( $meta['headers'] as $t => $header ) {
			/*
			 * Godaddy fix, via http://blog.gneu.org/2008/05/wp-supercache-on-godaddy/ and
			 * http://www.littleredrails.com/blog/2007/09/08/using-wp-cache-on-godaddy-500-error/.
			 */
			if ( strpos( $header, 'Last-Modified:' ) === false ) {
				header( $header );
			}
		}

		header( 'Hummingbird-Cache: Served' );
	}

	/**
	 * Purge cache directory.
	 *
	 * @since   1.7.0
	 * @used-by WP_Hummingbird_Caching_Page::run_actions()
	 * @used-by WP_Hummingbird_Module_Page_Caching::save_settings()
	 * @used-by WP_Hummingbird_Module_Page_Caching::purge_post_cache()
	 * @used-by WP_Hummingbird_Module_Page_Caching::post_edit()
	 * @used-by WP_Hummingbird_Module_Page_Caching::post_status_change()
	 * @param   string $directory  Directory to remove.
	 *
	 * @return bool
	 */
	public function purge_cache_dir( $directory = 'cache' ) {
		/* @var WP_Hummingbird_Filesystem $wphb_fs */
		global $wphb_fs;

		// Purge cache directory.
		if ( 'cache' === $directory ) {
			wphb_log( 'Cache direcotry purged', 'page-caching' );
			return $wphb_fs->purge( 'cache' );
		}

		// Purge specific folder.
		$http_host   = htmlentities( wp_unslash( $_SERVER['HTTP_HOST'] ) ); // Input var ok.
		$site_slug = self::get_site_slug( $http_host, $directory );

		$directory = $site_slug . $directory;
		$full_path = $wphb_fs->cache_dir . $directory;

		// If dir does not exist - return.
		if ( empty( $full_path ) || ! is_dir( $full_path ) ) {
			return false;
		}

		return $wphb_fs->purge( 'cache/' . $directory );
	}

	/**
	 * Purge single post page cache and relative pages (tags, category and author pages).
	 *
	 * @since   1.7.0
	 * @param   int $post_id  Post ID.
	 * @used-by WP_Hummingbird_Module_Page_Caching::post_status_change()
	 * @used-by WP_Hummingbird_Module_Page_Caching::post_edit()
	 */
	private function purge_post_cache( $post_id ) {
		global $post_trashed, $wphb_cache_config;

		//$post_url = urldecode( get_permalink( $post_id ) );
		$permalink = trailingslashit( str_replace( get_option( 'home' ), '', get_permalink( $post_id ) ) );

		// If post is being trashed.
		if ( $post_trashed ) {
			$permalink = preg_replace( '/__trashed(-?)(\d*)\/$/', '/', $permalink );
		}

		$this->purge_cache_dir( $permalink );
		wphb_log( 'Cache for has been purged for post id: ' . $post_id, 'page-caching' );

		// Clear categories and tags pages if cached.
		$meta_array = array(
			'category' => 'category',
			'tag'      => 'post_tag',
		);
		foreach ( $meta_array as $meta_name => $meta_key ) {
			// If not cached, skip meta.
			if ( ! in_array( $meta_name, $wphb_cache_config->page_types, true ) ) {
				continue;
			}

			$metas = get_the_terms( $post_id, $meta_key );
			/* @var WP_Term $meta */
			foreach ( $metas as $meta ) {
				$meta_link = str_replace( get_option( 'home' ), '', get_category_link( $meta->term_id ) );
				$this->purge_cache_dir( $meta_link );
				wphb_log( "Cache has been purged for {$meta_name}: {$meta->name}", 'page-caching' );
			}
		}

		$post = get_post( $post_id );
		if ( ! is_object( $post ) ) {
			return;
		}

		// Author page.
		$author_link = str_replace( get_option( 'home' ), '', get_author_posts_url( $post->post_author ) );
		if ( $author_link ) {
			$this->purge_cache_dir( $author_link );
			wphb_log( "Cache has been purged for author page: $author_link", 'page-caching' );
		}
	}

	/***************************
	 *
	 * V. ACTIONS AND FILTERS
	 *
	 * serve_cache()
	 * init_caching()
	 * post_status_change()
	 * post_edit()
	 *
	 ***************************/

	/**
	 * Server a cached file.
	 *
	 * @since 1.7.0
	 * @used-by advanced-cache.php
	 */
	public static function serve_cache() {
		global $wphb_cache_file;

		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? stripslashes( $_SERVER['REQUEST_URI'] ) : ''; // Input var ok.

		if ( ! self::should_cache_request( $request_uri ) ) {
			return;
		}

		/**
		 * 1. Get the file and header names.
		 * $wphb_cache_file available with path to cached file
		 * Generate file path where the cache will be saved.
		 */
		self::get_file_cache_path( $request_uri );

		/**
		 * 2. Check if the files are there?
		 */
		if ( file_exists( $wphb_cache_file ) ) {
			wphb_log( 'Cached file found. Serving to user.', 'page-caching' );

			self::send_headers();

			if ( defined( 'WPMU_ACCEL_REDIRECT' ) && WPMU_ACCEL_REDIRECT ) {
				header( 'X-Accel-Redirect: ' . str_replace( WP_CONTENT_DIR, '/wp-content/', $wphb_cache_file ) );
				exit;
			} elseif ( defined( 'WPMU_SENDFILE' ) && WPMU_SENDFILE ) {
				header( 'X-Sendfile: ' . $wphb_cache_file );
				exit;
			} else {
				@readfile( $wphb_cache_file );
				exit();
			}
		}
	}

	/**
	 * Try to avoid WP functions here (though we need to test).
	 *
	 * @since   1.7.0
	 * @used-by init action
	 */
	public function init_caching() {
		global $wphb_cache_file;

		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? stripslashes( $_SERVER['REQUEST_URI'] ) : ''; // Input var ok.

		if ( ! self::should_cache_request( $request_uri ) ) {
			return;
		}

		/**
		 * 1. Get the file and header names.
		 * $wphb_cache_file available with path to cached file
		 * Generate file path where the cache will be saved.
		 */
		self::get_file_cache_path( $request_uri );

		/**
		 * 2. Check if the files are there?
		 */
		if ( file_exists( $wphb_cache_file ) ) {
			wphb_log( 'Cached file found. Serving to user.', 'page-caching' );

			self::send_headers();

			if ( defined( 'WPMU_ACCEL_REDIRECT' ) && WPMU_ACCEL_REDIRECT ) {
				header( 'X-Accel-Redirect: ' . str_replace( WP_CONTENT_DIR, '/wp-content/', $wphb_cache_file ) );
				exit;
			} elseif ( defined( 'WPMU_SENDFILE' ) && WPMU_SENDFILE ) {
				header( 'X-Sendfile: ' . $wphb_cache_file );
				exit;
			} else {
				@readfile( $wphb_cache_file );
				exit();
			}
		} else {
			wphb_log( 'Cached file not found. Passing to ob_start.', 'page-caching' );
			// Write the file and send headers.
			$this->start_tine = microtime( true );
			// TODO: Add support for caching headers.
			//$this->send_headers();
			ob_start( array( $this, 'cache_request' ) );
		} // End if().
	}

	/**
	 * Parse post status transitions.
	 *
	 * @since   1.7.0
	 * @param   string  $new_status  New post status.
	 * @param   string  $old_status  Old post status.
	 * @param   WP_Post $post        Post object.
	 * @used-by transition_post_status action
	 */
	public function post_status_change( $new_status, $old_status, $post ) {
		global $post_trashed, $wphb_cache_config;

		// Nothing changed or revision. Exit.
		if ( $new_status === $old_status || wp_is_post_revision( $post->ID ) ) {
			return;
		}

		// Clear all cache files and return.
		if ( $wphb_cache_config->clear_on_update ) {
			$this->purge_cache_dir();
			return;
		}

		$post_trashed = false;
		if ( 'trash' === $new_status ) {
			$post_trashed = true;
		}

		// Purge cache on post publish/un-publish/move to trash.
		if (
			( 'publish' === $new_status && 'publish' !== $old_status )
			//|| ( 'publish' !== $new_status && 'publish' === $old_status )
			|| ( 'trash' === $new_status )
		) {
			// Delete category and tag cache.
			// Delete page cache.
			$this->purge_post_cache( $post->ID );
		}
	}

	/**
	 * Fires on edit_post action.
	 *
	 * @since   1.7.0
	 * @param   int   $post_id  Post ID.
	 * @used-by edit_post action
	 */
	public function post_edit( $post_id ) {
		global $wphb_cache_config;

		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// Clear all cache files and return.
		if ( $wphb_cache_config->clear_on_update ) {
			$this->purge_cache_dir();
			return;
		}

		// Delete category and tag cache.
		// Delete page cache.
		$this->purge_post_cache( $post_id );
	}

}

/**
 * Helper function to check if blog is multisite.
 *
 * @since 1.6.0
 * @return bool
 */
function wphb_cache_is_multisite() {
	if ( function_exists( 'is_multisite' ) ) {
		return is_multisite();
	}

	if ( defined( 'WP_ALLOW_MULTISITE' ) && true === WP_ALLOW_MULTISITE ) {
		return true;
	}

	if ( defined( 'SUBDOMAIN_INSTALL' ) || defined( 'VHOST' ) || defined( 'SUNRISE' ) ) {
		return true;
	}

	return false;
}

/**
 * Helper function to check if multisite is subdomain install.
 *
 * @since 1.6.0
 * @return bool
 */
function wphb_cache_is_subdomain_install() {
	if ( function_exists( 'is_subdomain_install' ) ) {
		return is_subdomain_install();
	}

	if ( defined( 'SUBDOMAIN_INSTALL' ) && true === SUBDOMAIN_INSTALL ) {
		return true;
	}

	return ( defined( 'VHOST' ) && VHOST === 'yes' );
}

/* function wp_cache_postload() {} */
