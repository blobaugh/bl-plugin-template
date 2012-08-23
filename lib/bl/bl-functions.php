<?php

if( !function_exists( 'bl_debug' ) ) {
    /**
     * Sends debugging data to a custom debug bar extension
     * 
     * @since 1.0
     * @param String $title
     * @param Mixed $data
     * @param String $format Optional - (Default:log) log | warning | error | notice | dump
     */
    function bl_debug( $title, $data, $format='log' ) { 
        do_action( 'bl_debug', $title, $data, $format );
    }
}

if( !function_exists( 'bl_dump' ) ) {
    /**
     * Sends an object to a custom debug bar extension to be dumped with a 
     * fancy var_dump variant
     * 
     * @since 1.0
     * @param String $title
     * @param Mixed $data 
     */
    function bl_dump( $title, $data) { 
        do_action( 'bl_debug', $title, $data, 'dump' );
    }
}

///*
// * Log that the plugin has initialized
// */
//add_action( 'admin_init', 'new_log_init');
///**
// * Logs that the plugin has started
// * @since 1.0 
// */
//function new_log_init() {
//    $data = get_plugin_data( BL_PLUGIN_FILE );
//    bl_debug( 'Plugin loaded', 'Plugin ' . $data['Name'] . ' successfully loaded' );
//}



/*
 * Load stuff that should ONLY happen in wp-admin
 */
if( is_admin() ) {
    wp_enqueue_style( 'bl-wp-admin-css', BL_PLUGIN_URL . 'css/wp-admin.css' );
    wp_register_script('bl-wp-admin-js', BL_PLUGIN_URL.'js/wp-admin.js', array('jquery'));
    wp_enqueue_script('bl-wp-admin-js');
}