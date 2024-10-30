<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link            	https://www.advicelocal.com/
 * @package         	local_listing_pro
 * Plugin Name:       	Local Listing Pro
 * Plugin URI:       	https://www.advicelocal.com/
 * Description:      	Submit Buisness with Local Listing Pro Plugin
 * Version:     		1.0.11
 * Author:          	Advice Interactive Group
 * Author URI:       	https://www.advicelocal.com/
 * License:           	GPL2
 * License URI:       	https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:			llsp-text-domain
 * Domain Path: 		/languages
 */

if (!defined('WPINC') || ! defined( 'ABSPATH' )) {
    
 exit;
}



define('local_listing_pro_path', plugin_dir_path(__FILE__));
define('local_listing_pro_url', plugins_url() . '/local-listing-pro/');
define('local_listing_pro', plugin_basename(__FILE__));
require local_listing_pro_path . 'inc/class_local_listing_pro.php';
register_activation_hook(__FILE__, array(
    'local_listing_pro',
    'activate_llsp'
));
register_deactivation_hook(__FILE__, array(
    'local_listing_pro',
    'deactivate_llsp'
));
function local_listing_pro()
{	
    return new local_listing_pro;
}
local_listing_pro();

?>
