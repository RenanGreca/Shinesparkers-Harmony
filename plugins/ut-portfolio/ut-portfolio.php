<?php
/*
 * Plugin Name: Portfolio Management by United Themes
 * Version: 4.3
 * Plugin URI: http://www.unitedthemes.com/
 * Description: Easily present your works to the crowd
 * Author: United Themes 
 * Author URI: http://www.unitedthemes.com/
 * Requires at least: 3.4
 * Tested up to: 4.5
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

define( 'UT_PORTFOLIO_DIR' , plugin_dir_path(__FILE__));
define( 'UT_PORTFOLIO_URL' , plugin_dir_url(__FILE__));
define( 'UT_PORTFOLIO_ASSETS_URL' , UT_PORTFOLIO_URL . 'assets/');
define( 'UT_PORTFOLIO_VERSION' , '4.3');

/* custom portfolio slug for single pages */
$ut_portfolio_slug = get_option('portfolio_slug_setting');
$ut_portfolio_slug = ( !empty($ut_portfolio_slug) ) ? $ut_portfolio_slug : 'portfolio-item';
define( 'UT_PORTFOLIO_ITEM' , $ut_portfolio_slug );

/*
|--------------------------------------------------------------------------
| load main style
|--------------------------------------------------------------------------
*/

if( !function_exists('ut_portfolio_enqueuestyles') ) :

	function ut_portfolio_enqueuestyles() {
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		$ut_portfolio = file_exists( get_template_directory() . '/css/ut.portfolio.style' . $min . '.css' ) ? get_template_directory_uri() . '/css/ut.portfolio.style' . $min . '.css' : UT_PORTFOLIO_ASSETS_URL . '/css/ut.portfolio.style' . $min . '.css';
				
		if( !is_admin() ) {
			
            wp_enqueue_style( 'wp-mediaelement' );
			
            wp_enqueue_style(
                'ut-portfolio', 
                $ut_portfolio, 
                array('ut-flexslider')
            );
                
            wp_enqueue_style(
                'ut-lightgallery',
                UT_PORTFOLIO_ASSETS_URL . 'vendor/lightGallery/css/lightgallery' . $min . '.css'
            );            
            
		}
		
	}
	
	add_action('get_header', 'ut_portfolio_enqueuestyles');

endif;

if( !function_exists('ut_portfolio_enqueuescripts') ) :

	function ut_portfolio_enqueuescripts() {
		
        $min = NULL;
        
        if( !WP_DEBUG ){
            $min = '.min';
        }
        
		if( !is_admin() ) {
			
            wp_enqueue_script(
                'ut-lightgallery-js',
                UT_PORTFOLIO_ASSETS_URL . 'vendor/lightGallery/js/lightgallery-all' . $min . '.js' , 
                array('jquery'),
                '1.2.6',
                true            
            ); 
        
            wp_enqueue_script(
                'ut-scrollTo',
                UT_PORTFOLIO_ASSETS_URL . 'js/jquery.scrollTo' . $min . '.js',
                array('jquery'),
                '1.4.6', 
                true
            );
			
            wp_enqueue_script(
                'ut-isotope-js',
                UT_PORTFOLIO_ASSETS_URL . 'js/jquery.isotope.min.js',
                array('jquery'),
                UT_PORTFOLIO_VERSION,
                false
            );
			
		}
		
	}
	add_action('wp_enqueue_scripts', 'ut_portfolio_enqueuescripts');

endif;

/*
|--------------------------------------------------------------------------
| Include plugin class files
|--------------------------------------------------------------------------
*/

/* portfolio functions */
require_once( 'ut-portfolio-functions.php' );

/* image resizer */
require_once( 'inc/ut-image-resize.php' );

/* ajax call */
require_once( 'inc/ut-ajax-call-media.php' );
require_once( 'inc/ut-ajax-call-content.php' );

/* base settings */
require_once( 'classes/class-ut-portfolio-template.php' );

/* portfolio settings */
require_once( 'classes/class-ut-portfolio-settings.php' );

/* post types */
require_once( 'classes/post-types/class-portfolio.php' );
require_once( 'classes/post-types/class-portfolio-manager.php' );

/* shortcode */
require_once( 'classes/class-ut-portfolio-shortcode.php' ); 

/*
|--------------------------------------------------------------------------
| Instantiate necessary classes
|--------------------------------------------------------------------------
*/

global $ut_portfolio_obj;

$ut_portfolio_obj = new UT_Portfolio_Template( __FILE__ );
$ut_portfolio_type_obj = new UT_Portfolio( __FILE__ );
$ut_portfolio_manager_obj = new UT_Portfolio_Manager( __FILE__ );
$ut_portfolio_settings_obj = new UT_Portfolio_Settings( __FILE__ );


/*
|--------------------------------------------------------------------------
| Correct Menu Highlighter
|--------------------------------------------------------------------------
*/
if ( !function_exists( 'ut_current_type_nav_class' ) ) {
	
    function ut_current_type_nav_class($css_class, $item) {
		
		$post_type = get_query_var('post_type');
		
		if ( get_post_type() == 'portfolio' ) {
			$css_class = array_filter($css_class, "ut_sortmenucss");		
		}
		
		if ($item->attr_title != '' && $item->attr_title == $post_type) {   	
			array_push( $css_class, 'current_page_parent' );
		};
		
		return $css_class; 
	}
    
    add_filter('nav_menu_css_class', 'ut_current_type_nav_class', 10, 2);
        
}

if ( !function_exists( 'ut_sortmenucss' ) ) {
	
    function ut_sortmenucss($css_class) {
		
		$current_value = "current_page_parent";
		return ($css_class != $current_value);
		
	}
    
}




/**
 * Deactivate Comments on Portfolio Add
 *
 * @since 1.0
 */

function ut_unchecked_page_discussion () {
    
    if( isset( $_REQUEST[ 'post_type' ] ) && $_REQUEST[ 'post_type' ] == 'portfolio'  ) {

        add_filter( 'pre_option_default_comment_status', 'ut_unchecked_page_discussion_filter' );
        
    }
    
}

add_action( 'load-post-new.php', 'ut_unchecked_page_discussion' );

function ut_unchecked_page_discussion_filter ( $val ) {
    return 'closed';
}