<?php 
/**
*
*
*
* Plugin Name: Latest Post Notification
* Description: A test project for potential position
* Author:      Juls Terobas
* Plugin Type: Extension
* Author URI: https://maennche.com/
* Version: 1.0.0
* Text Domain: latest-post-notification
* License:     GPLv3
* License URI: https://www.gnu.org/licenses/gpl.html
*
*
*
*
*/


defined( 'ABSPATH' ) or die( 'No access area' );
define('LPN_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('LPN_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('LPN_PLUGIN_VERSION','1.0.0');


/**
*
*
* Load text domain from languages
* @since 1.0.0
*
*
*/
add_action( 'init', 'lpn_load_text_domain' );

function lpn_load_text_domain() {
	load_plugin_textdomain( 'latest-post-notices', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

register_activation_hook( __FILE__, 'lpn_activate_plugin' );

if (!function_exists('lpn_activate_plugin')) {
	function lpn_activate_plugin()
	{
	    //do all activation hooks here
	}
}


register_deactivation_hook( __FILE__, 'lpn_deactivate_plugin' );

if (!function_exists('lpn_deactivate_plugin')) {
	function lpn_deactivate_plugin()
	{
        //do all inactivation hooks here
	}
}


//autoload classes
/**
*
*
* @since 1.0.11
* restructure folder added public, common and public
*
*
*/


spl_autoload_register(function ($class) {
    if(strpos($class,'lpn') !== false){
        $class = preg_replace('/\\\\/', '{lpn}', $class);

        $class = explode('{lpn}', $class);
        if(!empty(end($class))){
            $filename = str_replace("_", "-", end($class));
            $fullclass = strtolower($filename);
            if(strpos($fullclass,'admin') !== false){
                $folder = 'admin/includes/';
            }elseif(strpos($fullclass,'public') !== false){
                $folder = 'public/includes/';
            }else{
                $folder = 'common/';
            }
            if (file_exists(LPN_PLUGIN_PATH.$folder.$filename.'.php')) {
                include $folder.$filename.'.php';
            }
        }
    }
});

add_action('plugins_loaded', 'lpn_plugin_loaded');
function lpn_plugin_loaded(){
    //initialize main class here
    new \lpn\admin\lpnAdminClass();
}