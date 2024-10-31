<?php

/*
Plugin Name: PushNinja
Plugin URI: https://pushninja.com/
Author: 500apps
Author URI: 500apps.com/
Version: 0.3
Description:  PushNinja is a push notification software that allows website owners to create engaging push notifications and opt-ins to engage website visitors and improve conversion rates. 
 */

define('pushninjaFILE_ROOT', __FILE__);
define('pushninja_DIR', plugin_dir_path(__FILE__));

require __DIR__ . '/pushninja_functions.php';
spl_autoload_register('pushninja_class_loader');

/**
 * Parse configuration
 */
$settings = parse_ini_file(__DIR__ . '/pushninja_settings.ini', true);
add_action('plugins_loaded', array(\pushninjaplugin\Pushninja::$class, 'init'));

add_action('admin_print_styles', 'pushninja_stylesheet');

/** registering the style sheet **/
function pushninja_stylesheet() 
{
	wp_enqueue_style( 'pushninja_CSS', plugins_url( '/pushninja.css', __FILE__ ) );
}

/** registering the script file **/
function pushninja_scripts(){
	wp_register_script('pushninja_script', plugins_url('/js/pushninja_admin.js', pushninjaFILE_ROOT), array('jquery'),time(),true);
	wp_enqueue_script('pushninja_script');
}    

add_action('admin_enqueue_scripts', 'pushninja_scripts');
add_action( 'wp_head', 'pushninja_script' );
//add_action( 'wp_head', 'pushninja_script_infinity' );
add_action('wp_ajax_pushninja_save_website', 'pushninja_save_website');
add_action('wp_ajax_pushninja_addwebsite', 'pushninja_addwebsite');
add_action('wp_ajax_pushninja_addtoken', 'pushninja_addtoken');
?>