<?php
/*
Plugin Name: bl-plugin-template
Description: Custom site functions
Version: 100000
Author: FreshMuse
Author URI: http://freshmuse.com
Text Domain: bl-plugin-template-textdomain
*/
define( 'BL_TEXTDOMAIN', 'bl-plugin-template-textdomain' );
define( 'BL_PLUGIN_DIR', trailingslashit( dirname( __FILE__) ) );
define( 'BL_PLUGIN_URL', trailingslashit ( WP_PLUGIN_URL . "/" . basename( __DIR__  ) ) );
define( 'BL_PLUGIN_FILE', BL_PLUGIN_DIR . basename( __DIR__  ) . ".php" );

/*
 * Required bl-plugin includes
 */
require_once( BL_PLUGIN_DIR . 'lib/bl/bl-includes.php' ); // Required to setup bl functionality


/*
 * **************************************************************************
 * **************************************************************************
 * ******** YOU MAY BEGIN YOUR CUSTOM PLUGIN CODE BELOW THIS COMMENT ********
 * **************************************************************************
 * **************************************************************************
 */

add_action( 'init', 'testage' );
function testage() {
    global $current_user;
    //die(BL_PLUGIN_URL);
   // bl_dump( 'user admin bar pref', get_user_meta( $current_user->ID, 'show_admin_bar_front', true ) );
    //bl_dump( 'current user info', $current_user);
    bl_debug( 'plugin file', BL_PLUGIN_FILE );
    bl_debug( 'wp plugin url', WP_PLUGIN_URL, 'log' );
    bl_debug( 'plugin url', BL_PLUGIN_URL, 'warning' );
    bl_debug( 'path to css', BL_PLUGIN_URL . 'css/debug-bar.css', 'error' );
    bl_debug( 'wtf', 'this is a test of the emergency debugging system', 'notice' );
    bl_debug( 'plugin file', array('this', 'some', 'stuff'), 'dump' );
}