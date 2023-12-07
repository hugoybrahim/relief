<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/hugoybrahim
 * @since      1.0.0
 *
 * @package    Re_Lief
 * @subpackage Re_Lief/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Re_Lief
 * @subpackage Re_Lief/admin
 * @author     Hugo Ontiveros <ybra72@gmail.com>
 */
class Re_Lief_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Re_Lief_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Re_Lief_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/re-lief-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Re_Lief_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Re_Lief_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/re-lief-admin.js', array( 'jquery' ), $this->version, false );

	}

}

function register_country_post_type() {
    $labels = array(
        'name'               => _x('Countries', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Country', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Countries', 'admin menu', 'textdomain'),
        'add_new'            => _x('Add New', 'Country', 'textdomain'),
        'add_new_item'       => __('Add New Country', 'textdomain'),
        'edit_item'          => __('Edit Country', 'textdomain'),
        'new_item'           => __('New Country', 'textdomain'),
        'view_item'          => __('View Country', 'textdomain'),
        'search_items'       => __('Search Countries', 'textdomain'),
        'not_found'          => __('No countries found', 'textdomain'),
        'not_found_in_trash' => __('No countries found in Trash', 'textdomain'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'countries'),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('country', $args);
}
add_action('init', 'register_country_post_type');

function register_business_post_type() {
    $labels = array(
        'name'               => _x('Businesses', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Business', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Businesses', 'admin menu', 'textdomain'),
        'add_new'            => _x('Add New', 'Business', 'textdomain'),
        'add_new_item'       => __('Add New Business', 'textdomain'),
        'edit_item'          => __('Edit Business', 'textdomain'),
        'new_item'           => __('New Business', 'textdomain'),
        'view_item'          => __('View Business', 'textdomain'),
        'search_items'       => __('Search Businesses', 'textdomain'),
        'not_found'          => __('No businesses found', 'textdomain'),
        'not_found_in_trash' => __('No businesses found in Trash', 'textdomain'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'businesses'),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('business', $args);
}
add_action('init', 'register_business_post_type');


/* function register_custom_post_type_area_code() {
    $labels = array(
        'name'               => _x('Area Codes', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Area Code', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Area Codes', 'admin menu', 'textdomain'),
        'name_admin_bar'     => _x('Area Code', 'add new on admin bar', 'textdomain'),
        'add_new'            => _x('Add New', 'Area Code', 'textdomain'),
        'add_new_item'       => __('Add New Area Code', 'textdomain'),
        'new_item'           => __('New Area Code', 'textdomain'),
        'edit_item'          => __('Edit Area Code', 'textdomain'),
        'view_item'          => __('View Area Code', 'textdomain'),
        'all_items'          => __('All Area Codes', 'textdomain'),
        'search_items'       => __('Search Area Codes', 'textdomain'),
        'parent_item_colon'  => __('Parent Area Codes:', 'textdomain'),
        'not_found'          => __('No area codes found.', 'textdomain'),
        'not_found_in_trash' => __('No area codes found in trash.', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'area-code'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title'),
    );

    register_post_type('area_code', $args);
}

add_action('init', 'register_custom_post_type_area_code'); */


function register_sidebar_menu() {
    register_nav_menu('sidebar-menu', __('Sidebar Menu'));
}
add_action('init', 'register_sidebar_menu');
