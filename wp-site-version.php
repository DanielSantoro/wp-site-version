<?php
/**
 *
 * @link              https://danielsantoro.com
 * @since             1.0.0
 * @package           Wp_Site_Version
 *
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
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version using SemVer - https://semver.org
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-site-version-activator.php
 */
function activate_wp_site_version() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-version-activator.php';
	Wp_Site_Version_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-site-version-deactivator.php
 */
function deactivate_wp_site_version() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-version-deactivator.php';
	Wp_Site_Version_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_site_version' );
register_deactivation_hook( __FILE__, 'deactivate_wp_site_version' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-version.php';


/**
 * Add custom action links on the plugin screen.
 */
define( 'project_domain', 'https://danielsantoro.com' );
define( 'analytics_source', '?utm_source=pw-strength-plugin&utm_medium=plugin-overview-link' );
define( 'github', 'https://github.com/DanielSantoro/wc-password-strength-settings/' );
function wcpss_add_plugin_links( $links ) {
    $new_links = '<a href="'.github.'wiki/Documentation/" target="_blank">' . __( 'Documentation' ) . '</a>' . ' | ' . '<a href="'.project_domain.'/support/'.analytics_source.'" target="_blank">' . __( 'Help' ) . '</a>';
    array_push( $links, $new_links );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wcpss_add_plugin_links' );



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_site_version() {

	$plugin = new Wp_Site_Version();
	$plugin->run();

}
run_wp_site_version();

// Add Toolbar Menus
function wp_version_name() {
	global $wp_admin_bar;

	$args = array(
		'id'     => 'site-version',
		'title'  => __( 'LIVE SITE', 'wp_version_name' ),
		'group'  => false,
	);
	$wp_admin_bar->add_menu( $args );

}
add_action( 'wp_before_admin_bar_render', 'wp_version_name', 20 );