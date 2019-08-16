<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
		return $context;
	}

	public function theme_supports() {
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

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( new Twig_SimpleFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();

// Enqueuing main minified files
function webpack_custom_styles() {
	// Enqueue main js file
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/main.min.js', array(), filemtime(get_template_directory() . '/main.min.js'), true);
	// Enqueue css
	wp_enqueue_style('custom-css', get_template_directory_uri() . '/main.min.css', array(), filemtime(get_template_directory() . '/main.min.css'));
}
add_action( 'wp_enqueue_scripts', 'webpack_custom_styles');

//Disable gutenberg style in Front
function wps_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );

// Enable theme support for alignwide and alignfull classes from editor
add_theme_support( 'align-wide' );
        
// Adding Bulma classes to Block Editor Button
add_filter( 'render_block', function( $block_content, $block ) {
	if ( 'core/button' === $block['blockName'] && isset( $block['attrs']['className'] ) ) {
		// Setting up a subset of custom button link classes. Using regex to avoid breaking container classes
		$allowed_button_link_classes = array(
			'/\sbutton/',
			'/is-primary/',
			'/is-link/',
			'/is-info/',
			'/is-success/',
			'/is-warning/',
			'/is-danger/',
			'/is-white/',
			'/is-light/',
			'/is-dark/',
			'/is-black/',
			'/is-text/',
			'/is-small/',
			'/is-normal/',
			'/is-medium/',
			'/is-large/',
			'/is-outlined/',
			'/is-fullwidth/',
			'/is-inverted/',
			'/is-rounded/',
			'/is-hovered/',
			'/is-focused/',
			'/is-active/',
			// ...
		);

		
		// Remove allowed button link classes from the button container first.
		$block_content = preg_replace(
			$allowed_button_link_classes,
			'',
			$block_content
		);

		// Replacing regex with strings to make it able to use array_intersect
		$allowed_button_link_classes = str_replace(array('/', '\s'), '', $allowed_button_link_classes);

		// Get custom button classes set for the block.
		$custom_classes = explode( ' ', $block['attrs']['className'] );

		// Apply allowed custom button link classes.
		$block_content = str_replace(
			'wp-block-button__link',
			'wp-block-button__link ' . implode( ' ', array_intersect( $custom_classes, $allowed_button_link_classes ) ),
			$block_content
		);
	}

	return $block_content;
}, 5, 2 );

        'grid-wide' => __( 'Grid Wide' ),
	// Stop recording IP address in comments
function mj_remove_commentsip( $comment_author_ip ) {
	return '';
	}
add_filter( 'pre_comment_user_ip', 'mj_remove_commentsip' );

// Remove script tags for better compliancy with W3C Recomendations

add_filter('style_loader_tag', 'mj_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'mj_remove_type_attr', 10, 2);
function mj_remove_type_attr($tag, $handle) {
	return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}
