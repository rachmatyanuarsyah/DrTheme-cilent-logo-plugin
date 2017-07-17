<?php
/**
* Plugin Name: DrTheme cilent logo plugin
* Plugin URI: "https://github.com/rachmatyanuarsyah/DrTheme-cilent-logo-plugin"
* Description: A plugin to show cilent logo.
* Version: 1.0.0
* Author: Rachmat Yanuarsyah
* Author URI: "https://github.com/rachmatyanuarsyah"
* 
*/

//Don't do anything if this file was called directly
if (defined('ABSPATH') && defined('WPINC') && !class_exists("DrThemeCilentLogoLoader", false)) {
	DrPlugin_Cilent_Logo_Setup();
}
/**
 * define our setting plugin
 * 
 * @since 1.0.0
 */

define('DRTHEME_LOGO_PLUGIN_BASENAME', 'DrTheme-Cilent-Logo');//the settings Basename
define('DRTHEME_LOGO_PLUGIN_OPTIONS_NAME','DrTheme_cilent_logo_options');//the option name
define('DRTHEME_LOGO_PLUGIN_VERSION', __FILE__);// the plugin version
define('DRTHEME_LOGO_PLUGIN', plugin_basename(__FILE__));// the settings Basename file
define('DRTHEME_LOGO_PLUGIN_URL', plugins_url( '', __FILE__ ) );// used to prefix plugin folder
define('DRTHEME_LOGO_PLUGIN_IMAGES', DRTHEME_LOGO_PLUGIN_URL . '/assets/image/' ); //image folder
define('DRTHEME_LOGO_PLUGIN_STYLES', DRTHEME_LOGO_PLUGIN_URL . '/assets/css/' ); //style folder
define('DRTHEME_LOGO_PLUGIN_SCRIPTS', DRTHEME_LOGO_PLUGIN_URL . '/assets/js/' );//js folder

/**
 * Check if the requirements of the DrTheme cilent logo plugin are met and loads the actual loader
 *
 * @since 1.0.0
 */
function DrPlugin_Cilent_Logo_Setup() {

	$fail = false;

	//Check minimum PHP requirements, which is 5.2 at the moment.
	if (version_compare(PHP_VERSION, "5.0", "<")) {
		if(!has_action('admin_notices', 'DrPlugin_AddPhpVersionError')){
			add_action('admin_notices', 'DrPlugin_AddPhpVersionError');
		}
		$fail = true;
	}

	//Check minimum WP requirements, which is 4.8 at the moment.
	if (version_compare($GLOBALS["wp_version"], "4.7", "<")) {
		if(!has_action('admin_notices', 'DrPlugin_AddWpVersionError')){
			add_action('admin_notices', 'DrPlugin_AddWpVersionError');
		}
		$fail = true;
	}
	
	if (!$fail) {
		require_once(trailingslashit(dirname(__FILE__))."include/drplugin-loader.php") ;
		register_activation_hook(__FILE__, array("DrThemeCilentLogoLoader", "ActivatePlugin"));
		register_deactivation_hook(__FILE__, array("DrThemeCilentLogoLoader", "DeactivatePlugin"));
	}
}

/**
 * Adds a notice to the admin interface that the WordPress version is too old for the plugin
 *
 *  @since 1.0.0
 */
if(!function_exists('DrPlugin_AddPhpVersionError')){
	function DrPlugin_AddWpVersionError() {
		echo "<div id='sm-version-error' class='error fade'><p><strong>" . __('Your WordPress version is too old for Cilent Logo Plugin.', 'drtheme') . "</strong><br /> " . sprintf(__('Unfortunately this release of Cilent Logo Plugin requires at least WordPress %3$s. You are using Wordpress %2$s, which is out-dated and insecure. Please upgrade or go to <a href="%1$s">active plugins</a> and deactivate the Cilent Logo Plugin to hide this message.', 'drtheme'), "plugins.php?plugin_status=active", $GLOBALS["wp_version"],"4.7") . "</p></div>";
	}
}
/**
 * Adds a notice to the admin interface that the WordPress version is too old for the plugin
 *
 *  @since 1.0.0
 */
if(!function_exists('DrPlugin_AddPhpVersionError')){
	function DrPlugin_AddPhpVersionError() {
		echo "<div id='sm-version-error' class='error fade'><p><strong>" . __('Your PHP version is too old for Cilent Logo Plugin.', 'drtheme') . "</strong><br /> " . sprintf(__('Unfortunately this release of Cilent Logo Plugin requires at least PHP %3$s. You are using PHP %2$s, which is out-dated and insecure. Please ask your web host to update your PHP installation or go to <a href="%1$s">active plugins</a> and deactivate the Cilent Logo Plugin to hide this message.', 'drtheme'), "plugins.php?plugin_status=active", PHP_VERSION,"5.2") . "</p></div>";
	}
}