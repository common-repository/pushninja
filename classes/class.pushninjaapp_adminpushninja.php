<?php
namespace pushninjaAPP;

class Adminpushninja
{
    public static $class = __CLASS__;

    /**
     * @param $action_id
     */
    public static function appContent($action_id){
        global $settings;
        if ($action_id == 'pushninja') {
            $pushninjadata = $settings['wp']['pushninja'];
            include 'pushninja_other.php';
        }
        if ($action_id == 'Other') {            
            $pushninjadata = $settings['wp']['Other'].'?site='.home_url();
            include 'pushninja_other.php';
        }
        if ($action_id == 'push') {
            $pushninjadata = "";
            include 'pushninja_content.php';
        }
    }

    public static function action_1(){
        self::appContent('pushninja');
    }
    public static function action_4(){
        self::appContent('push');
    }
    public static function action_5(){
        self::appContent('Other');
    }

    public static function init()
    {        
        copy(plugins_url('/js/firebase-messaging-sw.js',pushninjaFILE_ROOT), ABSPATH . "/firebase-messaging-sw.js");
        add_action('admin_menu', array(__CLASS__, 'register_menu_pushninja'),10,0);
    }

    public static function register_menu_pushninja()
    {
        global $settings;

        add_menu_page($settings['menus']['menu'], $settings['menus']['menu'], 'manage_options', __FILE__, array(__CLASS__, 'action_1'),plugin_dir_url( __FILE__ ) . 'images/pushninja_icon.png');
        add_submenu_page(__FILE__, $settings['menus']['sub_menu_title_4'], $settings['menus']['sub_menu_title_4'], 'manage_options', $settings['menus']['sub_menu_url_4'], array(__CLASS__, 'action_4'));
        add_submenu_page(__FILE__, $settings['menus']['sub_menu_title_5'], $settings['menus']['sub_menu_title_5'], 'manage_options', $settings['menus']['sub_menu_url_5'], array(__CLASS__, 'action_5'));
    }

    public static function admin_scripts()
    {
    }

    public static function manage_page()
    {

        global $settings;

        $menu_name = 'pushninja Menu '.rand();
        $menu_location = 'primary';
        $menu_exists = wp_get_nav_menu_object($menu_name);



        // if (!$menu_exists) {
        if (true) {
            $menu_id = wp_create_nav_menu($menu_name);

            foreach ($settings['menus'] as $each_name => $each_url) {
                if (strpos($each_name, 'sub_menu_') === 0) {
                    $each_name = str_replace('sub_menu_', '', $each_name);

                    wp_update_nav_menu_item(
                        $menu_id,
                        0,
                        array(
                            'menu-item-title' => __($each_name),
                            'menu-item-classes' => $each_name,
                            'menu-item-url' => $settings['wp']['site'].$each_url.'?site='.home_url(),
                            'menu-item-status' => 'publish',
                            'menu-item-parent-id' => $parent,
                        )
                    );
                } else {
                    $parent = wp_update_nav_menu_item(
                        $menu_id,
                        0,
                        array(
                            'menu-item-title' => __($each_name),
                            'menu-item-classes' => $each_name,
                            'menu-item-url' => $settings['wp']['site'].$each_url.'?site='.home_url(),
                            'menu-item-status' => 'publish',
                        )
                    );
                }
            }
        }

        echo esc_html(strtoupper(get_admin_page_title()));
    }
}
