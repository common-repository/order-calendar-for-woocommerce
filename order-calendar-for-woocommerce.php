<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              piwebsolution.com
 * @since             1.6.47
 * @package           Pisol_Dtt_Edd_Calendar
 *
 * @wordpress-plugin
 * Plugin Name:       Order Calendar for WooCommerce
 * Plugin URI:        piwebsolution.com/pisol-dtt-edd-calendar
 * Description:       Show orders received on a calendar
 * Version:           1.6.47
 * Author:            PI Websolution
 * Author URI:        piwebsolution.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       order-calendar-for-woocommerce
 * Domain Path:       /languages
 * WC tested up to: 9.3.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/* 
    Making sure woocommerce is there 
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(!is_plugin_active( 'woocommerce/woocommerce.php')){
    function pisol_dtt_edd_calendar_woo_test() {
        ?>
        <div class="error notice">
            <p><?php _e( 'Please Install and Activate WooCommerce plugin, without that this plugin cant work', 'order-calendar-for-woocommerce' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'pisol_dtt_edd_calendar_woo_test' );
    return;
}


if(is_plugin_active( 'order-calendar-for-woocommerce-pro/order-calendar-for-woocommerce-pro.php')){
    function dtt_calendar_pro_error_notice() {
        ?>
        <div class="error notice">
            <p><?php _e( 'Please uninstall the Pro version of Order Calendar for WooCommerce and type then activate the Free version', 'order-calendar-for-woocommerce' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'dtt_calendar_pro_error_notice' );
    return;

}else{
/**
 * Currently plugin version.
 * Start at version 1.6.47 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PISOL_DTT_EDD_CALENDAR_VERSION', '1.6.47' );
define( 'PISOL_DTT_EDD_CALENDAR_URL', plugin_dir_url(__FILE__));
define( 'PISOL_DTT_EDD_CALENDAR_PATH', plugin_dir_path( __FILE__ ));
define( 'PISOL_DTT_EDD_CALENDAR_BASE', plugin_basename(__FILE__));
define( 'PISOL_DTT_EDD_CALENDAR_BUY_URL', 'https://www.piwebsolution.com/cart/?add-to-cart=4052&variation_id=4054');
define( 'PISOL_DTT_EDD_PRICE', '$25');

/**
 * Declare compatible with HPOS new order table 
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pisol-dtt-edd-calendar-activator.php
 */
function activate_pisol_dtt_edd_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pisol-dtt-edd-calendar-activator.php';
	Pisol_Dtt_Edd_Calendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pisol-dtt-edd-calendar-deactivator.php
 */
function deactivate_pisol_dtt_edd_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pisol-dtt-edd-calendar-deactivator.php';
	Pisol_Dtt_Edd_Calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pisol_dtt_edd_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_pisol_dtt_edd_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pisol-dtt-edd-calendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.6.47
 */
function run_pisol_dtt_edd_calendar() {

	$plugin = new Pisol_Dtt_Edd_Calendar();
	$plugin->run();

}
run_pisol_dtt_edd_calendar();
}