<?php
/*
Plugin Name: Smart Photo Gallery
Plugin URI: 
Description: 
Version: 0.0.1
Author: Xennis
Text Domain: smart-photo-gallery
*/

/**
 * Plugin name
 */
define('SPG_NAME', dirname(plugin_basename( __FILE__ )));
/**
 * Plugin directory 
 */
define('SPG_DIR', WP_PLUGIN_DIR.'/'.SPG_NAME);
/**
 * WordPress Lightweight Develop Kit directory
 */
define('WPLDK_DIR', SPG_DIR.'/lib/wpldk/src');

require_once(SPG_DIR.'/src/php/helper.php');

/**
 * Register activation hook 
 */
function spg_register_activation() {
	//require_once(SPG_DIR . '/src/php/config/Db.php');
	//SPG_Config_Db::__setup_database_tables();
}
register_activation_hook( __FILE__, 'spg_register_activation' );

/**
 * Admin enqueue scripts and styles.
 */
function spg_admin_enqueue_scripts() {
    wp_enqueue_style(SPG_NAME, plugins_url('/dist/'.SPG_NAME.'.min.css', __FILE__));
    wp_enqueue_script(SPG_NAME, plugins_url('/dist/'.SPG_NAME.'.js', __FILE__), array('jquery-ui-sortable'));
}
add_action('admin_enqueue_scripts', 'spg_admin_enqueue_scripts');

/*
 * Admin notices hook
 */
require_once(WPLDK_DIR.'/Helper/AdminNotice.php');
$wpldkHelperAdminNotice = new WPLDK_Helper_AdminNotice('spg_deferred_admin_notices');
function spg_admin_notices() {
	global $wpldkHelperAdminNotice;
	$wpldkHelperAdminNotice->hook();
}
add_action('admin_notices', 'spg_admin_notices');

/**
 * 
 * @param array $links
 */
function spg_plugin_action_links( $links ) {
   $links[] = '<a href="'.admin_url('admin.php?page=spg-settings').'">Settings</a>';
   return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'spg_plugin_action_links');

/*
 * Include scripts
 */
require_once(SPG_DIR.'/'.SPG_NAME.'.routing.php');
require_once(SPG_DIR.'/'.SPG_NAME.'.shortcodes.php');
require_once(SPG_DIR.'/'.SPG_NAME.'.pages.php');