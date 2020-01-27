<?php
/**
 * Plugin Name:       WP Site Version
 * Plugin URI:        https://danielsantoro.com
 * Description:       This plugin allows for you to add text and styling to the WordPress administrator bar so you can tell which version of the site you're working on.
 * Version:           1.0.0
 * Author:            Daniel Santoro
 * Author URI:        https://danielsantoro.com
 * License:           GPL 2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-site-version
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined( 'WPINC' ) ) {
	die;
}
/**
 * Plugin Definitions
 *
 * @package WP Site Version
 * @since 1.0.0
 */
if( !defined( 'WPSV_DIR' ) ) {
  define( 'WPSV_DIR', dirname( __FILE__ ) );           // Plugin directory
}
if( !defined( 'WPSV_VERSION' ) ) {
  define( 'WPSV_VERSION', '1.0.0' );                   // Plugin Version
}
if( !defined( 'WPSV_URL' ) ) {
  define( 'WPSV_URL', plugin_dir_url( __FILE__ ) );    // Plugin URL
}
if( !defined( 'WPSV_INC_DIR' ) ) {
  define( 'WPSV_INC_DIR', WPSV_DIR.'/includes' );     // Plugin 'include' directory
}
if( !defined( 'WPSV_INC_URL' ) ) {
  define( 'WPSV_INC_URL', WPSV_URL.'includes' );      // Plugin 'include' directory URL
}
if( !defined( 'WPSV_ADMIN_DIR' ) ) {
  define( 'WPSV_ADMIN_DIR', WPSV_INC_DIR.'/admin' );  // Plugin 'admin' directory
}
if(!defined('WPSV_PREFIX')) {
  define('WPSV_PREFIX', 'WPSV');                      // Plugin Prefix
}
if(!defined('WPSV_VAR_PREFIX')) {
  define('WPSV_VAR_PREFIX', '_WPSV_');                // Variable Prefix
}

/**
 * Add custom action links on the plugin screen.
 */
define( 'project_domain', 'https://danielsantoro.com' );
define( 'analytics_source', '?utm_source=pw-strength-plugin&utm_medium=plugin-overview-link' );
define( 'github', 'https://github.com/DanielSantoro/wp-site-version/' );
function wcpss_add_plugin_links( $links ) {
    $new_links = '<a href="'.github.'wiki/Documentation/" target="_blank">' . __( 'Documentation' ) . '</a>' . ' | ' . '<a href="'.project_domain.'/support/'.analytics_source.'" target="_blank">' . __( 'Help' ) . '</a>';
    array_push( $links, $new_links );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wcpss_add_plugin_links' );


/**
 * Activation & Deactivation Hooks
 */
register_activation_hook( __FILE__, 'wcpss_install' );

function wcpss_install(){
  
}

register_deactivation_hook( __FILE__, 'wcpss_uninstall');

function wcpss_uninstall(){
  
}


/**
 * Global Class
 */
global $wpsv_admin;

/**
 * Administration Panel Class
 */
include_once( WPSV_ADMIN_DIR.'/class-wpsv-admin.php' );
$wpsv_admin = new wpsv_admin();
$wpsv_admin->add_hooks();


