<?php
/*
Plugin Name: Genesis sticky menu
Plugin URI: http://iniyan.in/plugins/genesis-sticky-menu/
Description: This plugin adds a sticky menu to Genesis powered site. Requires the Genesis framework.
Version: 1.0.0
Author: Iniyan
Author URI: http://iniyan.in
*/
/** Define our constants */
define( 'GSM_SETTINGS_FIELD', 'gsm-settings' );
define( 'GSM_PLUGIN_DIR', dirname( __FILE__ ) );
register_activation_hook( __FILE__, 'gsm_activation' );


/**
 * This function runs on plugin activation. It checks to make sure Genesis
 * or a Genesis child theme is active. If not, it deactivates itself.
 *
 * @since 0.1.0
 */
function gsm_activation() {

	if ( 'genesis' != basename( TEMPLATEPATH ) ) {

		gsm_deactivate( '1.8.0', '3.3' );

	}

}
/**
 * Deactivate GS Design.
 *
 *
 * @since 1.8.0.2
 */

function gsm_deactivate( $genesis_version = '1.8.0', $wp_version = '3.3' ) {

	deactivate_plugins( plugin_basename( __FILE__ ) );

	wp_die( sprintf( __( 'Sorry, you cannot run Genesis Sticky Menu without WordPress %s and <a href="%s">Genesis %s</a> or greater.', 'gsdesign' ), $wp_version, 'http://mobiuztech.com/', $genesis_version ) );
}

add_action( 'genesis_init', 'gsm_init', 20 );

/**

 * Load admin menu and helper functions. Hooked to `genesis_init`.

 *

 * @since 1.8.0

 */

function gsm_init() {
	/** Deactivate if not running Genesis 1.8.0 or greater */

	if ( ! class_exists( 'Genesis_Admin_Boxes' ) )

		add_action( 'admin_init', 'gsm_deactivate', 10, 0 );

	/** Admin Menu */

	if ( is_admin() )

	require_once( GSM_PLUGIN_DIR . '/gsm-design.php' );

	/** CSS generator function */

	require_once( GSM_PLUGIN_DIR . '/gsm-style.php' );

}

//* enqueue script *//
add_action( 'wp_enqueue_scripts', 'gsm_enqueue_script' );

function gsm_enqueue_script() {
					wp_enqueue_script( 'sticky-menu', plugins_url( 'js/sticky-menu.js', __FILE__ ), array( 'jquery' ), '', true );
}
 
//*Adding Sticky Menu
add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Primary Navigation Menu' , 'secondary' => 'Secondary Navigation Menu' ,'stickymenu' => 'Genesis Sticky Menu' ) );

// Add new navbar
add_action('genesis_before', 'stickymenu');

function stickymenu() {
	echo '<div id="subnav"><div class="wrap">';
	wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_id' => '' , 'menu_class' => 'menu genesis-nav-menu menu-secondary', 'theme_location' => 'stickymenu') ); 
	echo '</div></div>'; 
}
