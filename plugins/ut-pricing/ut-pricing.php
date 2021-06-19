<?php
/*
 * Plugin Name: Pricing Tables by United Themes
 * Version: 3.1
 * Plugin URI: http://www.unitedthemes.com 
 * Description: Plugin for creating nice pricing tables
 * Author: United Themes
 * Author URI: http://www.unitedthemes.com 
 * Requires at least: 3.0
 * Tested up to: 4.0
 *
 * @package WordPress
 * @author United Themes
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/*
|--------------------------------------------------------------------------
| Basic Constants 
|--------------------------------------------------------------------------
*/

define('UT_PRICING_DIR', plugin_dir_path(__FILE__));
define('UT_PRICING_URL', plugin_dir_url(__FILE__));
define('UT_PRICING_ASSETS_URL' , UT_PRICING_URL . 'assets');
define('UT_PRICING_VERSION', '3.1');

/*
|--------------------------------------------------------------------------
| load main style
|--------------------------------------------------------------------------
*/

if( !function_exists('ut_table_enqueuestyles') ) :

	function ut_table_enqueuestyles() {
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		$ut_table = file_exists( get_stylesheet_directory() . '/css/ut.table.style' . $min . '.css' ) ? get_stylesheet_directory_uri() . '/css/ut.table.style' . $min . '.css' : UT_PRICING_ASSETS_URL . '/css/ut.table.style' . $min . '.css';
				
		if( !is_admin() ) {
		    
			wp_enqueue_style(
                'ut-table',
                $ut_table
            );
			
		}
		
	}
	
	add_action('get_header', 'ut_table_enqueuestyles');

endif;



/*
|--------------------------------------------------------------------------
| Include plugin class files
|--------------------------------------------------------------------------
*/

/* settings */
require_once( 'classes/class-table-template.php' );

/* post types */
require_once( 'classes/post-types/class-table-manager.php' );
require_once( 'classes/post-types/class-menu-manager.php' );

/* shortcode */
require_once( 'classes/class-ut-table-shortcode.php' );
require_once( 'classes/class-ut-menu-shortcode.php' );  

/*
|--------------------------------------------------------------------------
| Instantiate necessary classes
|--------------------------------------------------------------------------
*/

new UT_Table_Template( __FILE__ );
new UT_Table_Manager( __FILE__ ); 
new UT_Menu_Manager( __FILE__ ); 

?>