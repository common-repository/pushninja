<?php
namespace pushninjaplugin;
class Pushninja
{
    public static $class = __CLASS__;

    /**
     * @param $action_id
     */
    public static function pushninja_content($action_id){
        global $settings;
        if ($action_id == 'pushninja') {
            $pushninjadata = $settings['wp']['pushninja'];
            $websitename_value = get_bloginfo('name');
            $websiteurl_value = get_site_url();

            $results = json_decode(get_option('pushninja_website'), true);
            $script_value = $results['website_installscript'];
            if(empty($script_value)){
                $script_value = "false";
            }
            $verified_value = $results['website_verify'];
            if(empty($verified_value)){
                $verified_value = "false";
            }
            $pushninja_url = "https://infinity.500apps.com/pushninja?a=s&menu=false&websitename=$websitename_value&websiteurl=$websiteurl_value&script=$script_value&verified=$verified_value";
            include 'pushninja_other.php';
        }
        if ($action_id == 'Other') {            
            $pushninjadata = $settings['wp']['Other'].'?site='.home_url();
            include 'pushninja_other.php';
        }
        if ($action_id == 'push') {
            $pushninjadata = "";
        }
    }
    public static function action_1(){
        self::pushninja_content('pushninja');
    }
    public static function action_2(){
        self::pushninja_content('push');
    }
    public static function action_3(){
        self::pushninja_content('Other');
    }

    public static function init()
    {        
        copy(plugins_url('/js/firebase-messaging-sw.js',pushninjaFILE_ROOT), ABSPATH . "/firebase-messaging-sw.js");
        add_action('admin_menu', array(__CLASS__, 'pushninja_register_menu'),10,0);
    }

    /** registering the menus on admin page **/
    public static function pushninja_register_menu()
    {
        global $settings;
        add_menu_page('Send Push Notifications with PushNinja', $settings['menus']['menu'], 'manage_options', __FILE__, array(__CLASS__, 'action_1'),plugin_dir_url( __FILE__ ) . 'images/pushninja_icon.png');
        add_submenu_page(__FILE__, $settings['menus']['sub_menu_title_4'], $settings['menus']['sub_menu_title_4'], 'manage_options', $settings['menus']['sub_menu_url_4'], array(__CLASS__, 'action_3'));
    }
}