<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twenty_twenty_one_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Twenty-One, use a find and replace
		 * to change 'twentytwentyone' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'twentytwentyone', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary menu', 'twentytwentyone' ),
				'footer'  => __( 'Secondary menu', 'twentytwentyone' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		$background_color = get_theme_mod( 'background_color', 'D1E4DD' );
		if ( 127 > Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $background_color ) ) {
			add_theme_support( 'dark-editor-style' );
		}

		$editor_stylesheet_path = './assets/css/style-editor.css';

		// Note, the is_IE global variable is defined by WordPress and is used
		// to detect if the current browser is internet explorer.
		global $is_IE;
		if ( $is_IE ) {
			$editor_stylesheet_path = './assets/css/ie-editor.css';
		}

		// Enqueue editor styles.
		add_editor_style( $editor_stylesheet_path );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Extra small', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XS', 'Font size', 'twentytwentyone' ),
					'size'      => 16,
					'slug'      => 'extra-small',
				),
				array(
					'name'      => esc_html__( 'Small', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'S', 'Font size', 'twentytwentyone' ),
					'size'      => 18,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'M', 'Font size', 'twentytwentyone' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'L', 'Font size', 'twentytwentyone' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Extra large', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XL', 'Font size', 'twentytwentyone' ),
					'size'      => 40,
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XXL', 'Font size', 'twentytwentyone' ),
					'size'      => 96,
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', 'twentytwentyone' ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', 'twentytwentyone' ),
					'size'      => 144,
					'slug'      => 'gigantic',
				),
			)
		);

		// Custom background color.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'd1e4dd',
			)
		);

		// Editor color palette.
		$black     = '#000000';
		$dark_gray = '#28303D';
		$gray      = '#39414D';
		$green     = '#D1E4DD';
		$blue      = '#D1DFE4';
		$purple    = '#D1D1E4';
		$red       = '#E4D1D1';
		$orange    = '#E4DAD1';
		$yellow    = '#EEEADD';
		$white     = '#FFFFFF';

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Black', 'twentytwentyone' ),
					'slug'  => 'black',
					'color' => $black,
				),
				array(
					'name'  => esc_html__( 'Dark gray', 'twentytwentyone' ),
					'slug'  => 'dark-gray',
					'color' => $dark_gray,
				),
				array(
					'name'  => esc_html__( 'Gray', 'twentytwentyone' ),
					'slug'  => 'gray',
					'color' => $gray,
				),
				array(
					'name'  => esc_html__( 'Green', 'twentytwentyone' ),
					'slug'  => 'green',
					'color' => $green,
				),
				array(
					'name'  => esc_html__( 'Blue', 'twentytwentyone' ),
					'slug'  => 'blue',
					'color' => $blue,
				),
				array(
					'name'  => esc_html__( 'Purple', 'twentytwentyone' ),
					'slug'  => 'purple',
					'color' => $purple,
				),
				array(
					'name'  => esc_html__( 'Red', 'twentytwentyone' ),
					'slug'  => 'red',
					'color' => $red,
				),
				array(
					'name'  => esc_html__( 'Orange', 'twentytwentyone' ),
					'slug'  => 'orange',
					'color' => $orange,
				),
				array(
					'name'  => esc_html__( 'Yellow', 'twentytwentyone' ),
					'slug'  => 'yellow',
					'color' => $yellow,
				),
				array(
					'name'  => esc_html__( 'White', 'twentytwentyone' ),
					'slug'  => 'white',
					'color' => $white,
				),
			)
		);

		add_theme_support(
			'editor-gradient-presets',
			array(
				array(
					'name'     => esc_html__( 'Purple to yellow', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'purple-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to purple', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'yellow-to-purple',
				),
				array(
					'name'     => esc_html__( 'Green to yellow', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'green-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to green', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
					'slug'     => 'yellow-to-green',
				),
				array(
					'name'     => esc_html__( 'Red to yellow', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'red-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to red', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'yellow-to-red',
				),
				array(
					'name'     => esc_html__( 'Purple to red', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'purple-to-red',
				),
				array(
					'name'     => esc_html__( 'Red to purple', 'twentytwentyone' ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'red-to-purple',
				),
			)
		);

		/*
		* Adds starter content to highlight the theme on fresh sites.
		* This is done conditionally to avoid loading the starter content on every
		* page load, as it is a one-off operation only needed once in the customizer.
		*/
		if ( is_customize_preview() ) {
			require get_template_directory() . '/inc/starter-content.php';
			add_theme_support( 'starter-content', twenty_twenty_one_get_starter_content() );
		}

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Add support for custom units.
		// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support( 'custom-units' );
	}
}
add_action( 'after_setup_theme', 'twenty_twenty_one_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @return void
 */
function twenty_twenty_one_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'twentytwentyone' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'twentytwentyone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'twenty_twenty_one_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @global int $content_width Content width.
 *
 * @return void
 */
function twenty_twenty_one_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'twenty_twenty_one_content_width', 750 );
}
add_action( 'after_setup_theme', 'twenty_twenty_one_content_width', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twenty_twenty_one_scripts() {
	// Note, the is_IE global variable is defined by WordPress and is used
	// to detect if the current browser is internet explorer.
	global $is_IE, $wp_scripts;
	if ( $is_IE ) {
		// If IE 11 or below, use a flattened stylesheet with static values replacing CSS Variables.
		wp_enqueue_style( 'twenty-twenty-one-style', get_template_directory_uri() . '/assets/css/ie.css', array(), wp_get_theme()->get( 'Version' ) );
	} else {
		// If not IE, use the standard stylesheet.
		wp_enqueue_style( 'twenty-twenty-one-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	}

	// RTL styles.
	wp_style_add_data( 'twenty-twenty-one-style', 'rtl', 'replace' );

	// Print styles.
	wp_enqueue_style( 'twenty-twenty-one-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	// Threaded comment reply styles.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register the IE11 polyfill file.
	wp_register_script(
		'twenty-twenty-one-ie11-polyfills-asset',
		get_template_directory_uri() . '/assets/js/polyfills.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Register the IE11 polyfill loader.
	wp_register_script(
		'twenty-twenty-one-ie11-polyfills',
		null,
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_add_inline_script(
		'twenty-twenty-one-ie11-polyfills',
		wp_get_script_polyfill(
			$wp_scripts,
			array(
				'Element.prototype.matches && Element.prototype.closest && window.NodeList && NodeList.prototype.forEach' => 'twenty-twenty-one-ie11-polyfills-asset',
			)
		)
	);

	// Main navigation scripts.
	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_script(
			'twenty-twenty-one-primary-navigation-script',
			get_template_directory_uri() . '/assets/js/primary-navigation.js',
			array( 'twenty-twenty-one-ie11-polyfills' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	// Responsive embeds script.
	wp_enqueue_script(
		'twenty-twenty-one-responsive-embeds-script',
		get_template_directory_uri() . '/assets/js/responsive-embeds.js',
		array( 'twenty-twenty-one-ie11-polyfills' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'twenty_twenty_one_scripts' );

/**
 * Enqueue block editor script.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_block_editor_script() {

	wp_enqueue_script( 'twentytwentyone-editor', get_theme_file_uri( '/assets/js/editor.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'twentytwentyone_block_editor_script' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twenty_twenty_one_skip_link_focus_fix() {

	// If SCRIPT_DEBUG is defined and true, print the unminified file.
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		echo '<script>';
		include get_template_directory() . '/assets/js/skip-link-focus-fix.js';
		echo '</script>';
	}

	// The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())}),!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twenty_twenty_one_skip_link_focus_fix' );

/** Enqueue non-latin language styles
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twenty_twenty_one_non_latin_languages() {
	$custom_css = twenty_twenty_one_get_non_latin_css( 'front-end' );

	if ( $custom_css ) {
		wp_add_inline_style( 'twenty-twenty-one-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'twenty_twenty_one_non_latin_languages' );

// SVG Icons class.
require get_template_directory() . '/classes/class-twenty-twenty-one-svg-icons.php';

// Custom color classes.
require get_template_directory() . '/classes/class-twenty-twenty-one-custom-colors.php';
new Twenty_Twenty_One_Custom_Colors();

// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Menu functions and filters.
require get_template_directory() . '/inc/menu-functions.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';

// Customizer additions.
require get_template_directory() . '/classes/class-twenty-twenty-one-customize.php';
new Twenty_Twenty_One_Customize();

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Block Styles.
require get_template_directory() . '/inc/block-styles.php';

// Dark Mode.
require_once get_template_directory() . '/classes/class-twenty-twenty-one-dark-mode.php';
new Twenty_Twenty_One_Dark_Mode();

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_customize_preview_init() {
	wp_enqueue_script(
		'twentytwentyone-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_enqueue_script(
		'twentytwentyone-customize-preview',
		get_theme_file_uri( '/assets/js/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'twentytwentyone-customize-helpers' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_preview_init', 'twentytwentyone_customize_preview_init' );

/**
 * Enqueue scripts for the customizer.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_customize_controls_enqueue_scripts() {

	wp_enqueue_script(
		'twentytwentyone-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'twentytwentyone_customize_controls_enqueue_scripts' );

/**
 * Calculate classes for the main <html> element.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_the_html_classes() {
	$classes = apply_filters( 'twentytwentyone_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}

/**
 * Add "is-IE" class to body if the user is on Internet Explorer.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function twentytwentyone_add_ie_class() {
	?>
	<script>
	if ( -1 !== navigator.userAgent.indexOf( 'MSIE' ) || -1 !== navigator.appVersion.indexOf( 'Trident/' ) ) {
		document.body.classList.add( 'is-IE' );
	}
	</script>
	<?php
}
add_action( 'wp_footer', 'twentytwentyone_add_ie_class' );

// Our custom post type function
function create_posttype() {
 
    register_post_type( 'property',
    // CPT Options
        array(
			    'labels' => array(
				
                'name' => __( 'Propertes' ),
           'singular_name' => __( 'Property' ),
		'menu_name'           => __( 'Propertes', 'twentytwentyone' ),
        'parent_item_colon'   => __( 'Parent Property', 'twentytwentyone' ),
        'all_items'           => __( 'All Property', 'twentytwentyone' ),
        'view_item'           => __( 'View Property', 'twentytwentyone' ),
        'add_new_item'        => __( 'Add New Property', 'twentytwentyone' ),
        'add_new'             => __( 'Add New', 'twentytwentyone' ),
        'edit_item'           => __( 'Edit Property', 'twentytwentyone' ),
        'update_item'         => __( 'Update Property', 'twentytwentyone' ),
        'search_items'        => __( 'Search Property', 'twentytwentyone' ),
        'not_found'           => __( 'Not Found', 'twentytwentyone' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentyone' ),
		
		            ),
            'label'               => __( 'Propertes', 'twentytwentyone' ),
        'description'         => __( 'property news and reviews', 'twentytwentyone' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
		'hierarchical'        => true,
		//'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'show_in_rest'        => true,
		'register_meta_box_cb' => 'wpt_add_event_metaboxes',		
        // This is where we add taxonomies to our CPT
        'taxonomies'          => array( 'category' ),


 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );



// Add the custom columns to the property post type :
add_filter( 'manage_property_posts_columns', 'set_custom_edit_property_columns' );
function set_custom_edit_property_columns($columns) {
    unset( $columns['state'] );
    $columns['state'] = __( 'State', 'your_text_domain' );
    $columns['city'] = __( 'City', 'your_text_domain' );

    return $columns;
}

// Add the data to the custom columns for the Property post type:
add_action( 'manage_property_posts_custom_column' , 'custom_property_column', 10, 2 );
function custom_property_column( $column, $post_id ) {
    switch ( $column ) {

        case 'state' :
            $terms = get_post_meta( $post_id , 'state' , true );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get State(s)', 'your_text_domain' );
            break;

        case 'city' :
            echo get_post_meta( $post_id , 'city' , true ); 
            break;

    }
}

/**
 * Adds a metabox to the right side of the screen under the box
 */
function wpt_add_event_metaboxes() {
	add_meta_box(
		'wpt_address_location',
		'Address',
		'wpt_address_location',
		'property',
		'side',
		'default'
	);
	
	add_meta_box(
		'wpt_location',
		'Location',
		'wpt_location',
		'property',
		'normal',
		'high'
	);
}

/**
 * Output the HTML for the metabox.
 */
 add_action( 'admin_head', function () { ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqsKEglBEK_zLg41RA4XMTHWXoIsT0_MI&callback=initMap&libraries=&v=weekly" async type="text/javascript"></script>
<?php } );

add_action( 'admin_enqueue_scripts', 'mgms_enqueue_assets' );
function mgms_enqueue_assets() {
	wp_enqueue_script( 
	  'google-maps', 
	  'https://maps.googleapis.com/maps/api/js?key=AIzaSyAqsKEglBEK_zLg41RA4XMTHWXoIsT0_MI&callback=initMap&libraries=&v=weekly', 
	  array(), 
	  '1.0', 
	  true 
	);
}

function wpt_location() {
	global $post;

	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'event_fields' );

	// Get the location data if it's already been entered
	$txt_latlng = get_post_meta( $post->ID, 'txt_latlng', true );
	

	// Output the field
	echo '<body onload="initialize();"> <input placeholder="Latitude, Longitude" type="text" value="' . esc_textarea( $txt_latlng )  . '" name="txt_latlng" id="txt_latlng" style="width:480px;" class="widefat">';
    echo'<div id="map_canvas" style="width:600px;height:400px;border:solid black 1px;"></div>';
	
	 echo'<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script><script>function initialize(){
		 var latlng = new google.maps.LatLng(37.7699298, -122.4469157);
		 // Set map options
		 var myOptions = {
		 zoom: 16,
		 center: latlng,
		 panControl: true,
		 zoomControl: true,
		 scaleControl: true,
		 mapTypeId: google.maps.MapTypeId.ROADMAP
		 }
		 // Create map object with options
		 map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		 // Create and set the marker
		 marker = new google.maps.Marker({
		 map: map,
		 draggable:true,
		 position: latlng
		 });
		 
		 // Register Custom "dragend" Event
		 google.maps.event.addListener(marker, "dragend", function() {
		 
		 // Get the Current position, where the pointer was dropped
		 var point = marker.getPosition();
		 // Center the map at given point
		 map.panTo(point);
		 // Update the textbox
		 document.getElementById("txt_latlng").value=point.lat()+", "+point.lng();
		 });
		}
		 </script></body>
		';
	}

function wpt_address_location() {
	global $post;

	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'address_fields' );

	// Get the location data if it's already been entered
	$address = get_post_meta( $post->ID, 'address', true );
	$city = get_post_meta( $post->ID, 'city', true );
	$state = get_post_meta( $post->ID, 'state', true );

	// Output the field
	echo '<input type="text" placeholder="Enter Address" name="address" value="' . esc_textarea( $address )  . '" class="widefat"> ';
	echo '<input type="text" placeholder="Enter City" name="city" value="' . esc_textarea( $city )  . '" class="widefat" style="width:50%;float: left;">';
	echo '<input type="text" placeholder="Enter State" name="state" value="' . esc_textarea( $state )  . '" class="widefat" style="width:50%;">';

}
/**
 * Save the metabox data
 */
function wpt_save_events_meta( $post_id, $post ) {

	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['txt_latlng'] ) || ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	if ( ! isset( $_POST['address'] ) || ! wp_verify_nonce( $_POST['address_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}
	if ( ! isset( $_POST['city'] ) || ! wp_verify_nonce( $_POST['address_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}
	if ( ! isset( $_POST['state'] ) || ! wp_verify_nonce( $_POST['address_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	$events_meta['address'] = esc_textarea( $_POST['address'] );
	$events_meta['city'] = esc_textarea( $_POST['city'] );
	$events_meta['state'] = esc_textarea( $_POST['state'] );
	$events_meta['txt_latlng'] = esc_textarea( $_POST['txt_latlng'] );
	

	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $events_meta as $key => $value ) :

		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}

	endforeach;

}
add_action( 'save_post', 'wpt_save_events_meta', 1, 2 );



// Post Submition

function ajax_form_scripts() {
	$translation_array = array(
        'ajax_url' => admin_url( '/property/wp-content/themes/twentytwentyone/property.php' )
    );
    wp_localize_script( '', 'cpm_object', $translation_array );
	
}

add_action( 'wp_enqueue_scripts', 'ajax_form_scripts' );

function set_form(){
	$name = $_POST['name'];
	$message = $_POST['message'];
	$admin =get_option('admin_email');
	// wp_mail($email,$name,$message);  main sent to admin and the user
	
	die();
}

//To Save The Message In Custom Post Type
$new_post = array(
   'post_title'    => $name,
   'post_content'  => $message,
   'post_status'   => 'draft',           // Choose: publish, preview, future, draft, etc.
   'post_type' => 'property'  //'post',page' or use a custom post type if you want to
);




function get_lat_long($address){

    $address = str_replace(" ", "+", $address);

   // $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}


add_action('wp_ajax_Submit_custom_post_data', 'Submit_custom_post_data');
add_action('wp_ajax_nopriv_Submit_custom_post_data', 'Submit_custom_post_data');

function Submit_custom_post_data() 
{	
	if(isset($_POST['message']) && !empty($_POST['message']))
	{
		$post_title = $_POST['name'];	
		if ( post_exists(  $post_title  ) == null ) 
		{	

			
			$new_post = array(
				   $name = 'post_title'    => $_POST['name'],
				   'post_content'  => $_POST['message'],
				   'address'  => $_POST['address'],
				   'city'  => $_POST['city'],
				   'state'  => $_POST['state'],
				   'featured_image' => $_FILES['images'],
				   'post_category' => array($_POST['category']),
				   'post_status'   => 'publish',  // Choose: publish, preview, future, draft, etc.
				   'post_author'   => 1,
				   'post_type'     => 'property'  //'post',page' or use a custom post type if you want to
				);
				
				// Create Category  
				$new_cat_ID = wp_create_category($_POST['category'] );
			  
			 
				 //Insert Post data 
				$postid = wp_insert_post( $new_post );
				add_post_meta($postid, 'times', '1');
				//get_post_meta($post_ID, $meta_key, $single); 
				
				//insert data in post custom field
				update_post_meta( $postid , 'address',$_POST['address']  );	
				update_post_meta( $postid , 'city',$_POST['city']  );	
				update_post_meta( $postid , 'state',$_POST['state']  );	
				update_post_meta( $postid , 'txt_latlng',$_POST['txt_latlng']  );	
				


				//Set Post Category
				$append = false; 
				wp_set_post_categories( $postid, $new_cat_ID, $append  );
						
				
			   //Add data in data media
		 
				if (!function_exists('wp_generate_attachment_metadata')){
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					require_once(ABSPATH . "wp-admin" . '/includes/file.php');
					require_once(ABSPATH . "wp-admin" . '/includes/media.php');
				}
				 if ($_FILES) {
					foreach ($_FILES as $file => $array) {
						if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
							return "upload error : " . $_FILES[$file]['error'];
						}
						$attach_id = media_handle_upload( $file, $new_post );
						
					}   
				}
				if ($attach_id > 0){
					//and if you want to set that image as Post  then use:
					update_post_meta($new_post,'_thumbnail_id',$attach_id);
				}  

			   // Set post Image
			   set_post_thumbnail( $postid, $attach_id  );
			   
				/* $uploaddir = wp_upload_dir();
				$file = $_FILES['images']['name'];
				$uploadfile = $uploaddir['path'] . '/' . basename( $file );

				move_uploaded_file( $file['tmp_name'] , $uploadfile );
				$filename = basename( $uploadfile );

				$wp_filetype = wp_check_filetype(basename($filename), null );

				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
					'post_content' => '',
					'guid' => $IMGUrl,
					'post_type' => 'property',
					'post_status' => 'inherit',
					'menu_order' => $_i + 1000
				);
				$attach_id = wp_insert_attachment( $attachment, $uploadfile  );  
				require_once( ABSPATH . 'wp-admin/includes/image.php' );  
					
				set_post_thumbnail( $postid, $attach_id  ); */
			   
			echo 'OK';
		
			die;
		}
		else
		{
		
			echo "Exist";
		}				
	}
	
	die;

}



add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');
 
function misha_filter_function(){
	$args = array(
		'orderby' => 'date',// we will sort posts by date
		'post_type' => 'property', 		
		'city'	=> $_POST['city'],
		'state'	=> $_POST['state']
	);
	
	// for taxonomies / categories
	if( isset( $_POST['categoryfilter'] ) )
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $_POST['categoryfilter']
			)
		);
	
	// create $args['meta_query'] array if one of the following fields is filled
	if( isset( $_POST['city'] ) && $_POST['city'] || isset( $_POST['state'] ) && $_POST['state']  )
		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true
 
	// if both city and state are specified we will use BETWEEN comparison
	if( isset( $_POST['city'] ) && $_POST['city'] || isset( $_POST['state'] ) && $_POST['state'] ) {
		$args['meta_query'][] = array(
			'value' => array( $_POST['city'], $_POST['state'] ),
			//'compare' => 'between'
		);
	} else {
		// if only city is set
		if( isset( $_POST['city'] ) && $_POST['city'] )
			$args['meta_query'][] = array(
				'value' => $_POST['city'],
				//'compare' => '>'
			);
 
		// if only state is set
		if( isset( $_POST['state'] ) && $_POST['state'] )
			$args['meta_query'][] = array(
				'value' => $_POST['state'],
				//'compare' => '<'
			);
	}
 
	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox
 
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
		echo '<a href="' . $query->post->guid . '">';
			echo '<h4>' . $query->post->post_title . '</h4>';
			echo '<p>City : ' . $query->post->city . '</p>';
			echo '<p>State : ' . $query->post->state . '</p>';
			echo'</a>';
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;
 
	die();
}

// Applies the redirection filter to users that login using Social Login
add_filter('oa_social_login_filter_login_redirect_url', 'oa_social_login_set_redirect_url', 10, 2);
include_once( get_stylesheet_directory() .'/subfunction.php');

?>
