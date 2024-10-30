<?php
/**
 * Plugin Name:       Messenger Buttons Light
 * Plugin URI:
 * Description:       Easily create floating menus of varying complexity
 * Version:           1.0
 * Author:            Pinta Webware
 * Author URI:
 * License:           GPL-2.0+
 * License URI:
 * Text Domain: MBWPL
 * Domain Path: /lang
 */
/*  Copyright 2019  Pinta webware  (email : info@pinta.com.ua)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software

*/

if ( ! defined( 'WPMB_FILE' ) ) {
    define( 'WPMB_FILE', __FILE__ );
}
if ( ! defined( 'WPMB_PATH' ) ) {
    define( 'WPMB_PATH', plugin_dir_path( WPMB_FILE ) );
}
if ( ! defined( 'WPMB_IMAGE' ) ) {
    define( 'WPMB_IMAGE', plugin_dir_url( WPMB_FILE).'image/' );
}

if ( ! defined( 'WPMB_BASENAME' ) ) {
    define( 'WPMB_BASENAME', plugin_basename( WPMB_FILE ) );
}
if ( ! defined( 'WPMB_PLUGIN_NAME' ) ) {
    define( 'WPMB_PLUGIN_NAME', basename(__DIR__)  );
}


register_activation_hook(__FILE__, array('MBWPL_Float_Menu_Class', 'plugin_activate'));
register_uninstall_hook(__FILE__, array('MBWPL_Float_Menu_Class', 'plugin_deactivate'));

require_once plugin_dir_path(__FILE__) . 'include/mb-functions.php';
add_action( 'plugins_loaded', function(){
    load_plugin_textdomain( 'MBWPL', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
} );

if (!class_exists('MBWPL_Float_Menu_Class')) {
    class MBWPL_Float_Menu_Class
    {
        // Activate & diactivate
        function plugin_activate()
        {

            require_once plugin_dir_path(__FILE__) . 'include/activator.php';
        }

        function plugin_deactivate()
        {
            require_once plugin_dir_path(__FILE__) . 'include/deactivator.php';
        }
    }
}

add_action('admin_enqueue_scripts', 'mbwpl_wpdocs_enqueue_custom_admin_style', 100);

function mbwpl_wpdocs_enqueue_custom_admin_style()
{
    wp_enqueue_script('messen', plugin_dir_url(__FILE__) . 'admin/js/imask.js');
    wp_enqueue_script('messenger-button', plugin_dir_url(__FILE__) . 'admin/js/form_xtz.js');
}

?>