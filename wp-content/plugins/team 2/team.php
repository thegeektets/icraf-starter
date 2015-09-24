<?php
/*
Plugin Name: Team
Plugin URI: http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress/
Description: Fully responsive and mobile ready meet the team showcase plugin for wordpress.
Version: 1.7
Author: paratheme, pickplugins
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright: 	2015 ParaTheme

*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class Team{
	
	public function __construct(){
	
		define('team_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
		define('team_plugin_dir', plugin_dir_path( __FILE__ ) );
		define('team_wp_url', 'http://wordpress.org/plugins/team/' );
		define('team_wp_reviews', 'http://wordpress.org/support/view/plugin-reviews/team' );
		define('team_pro_url', 'http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress/' );
		define('team_demo_url', 'http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress/' );
		define('team_conatct_url', 'http://paratheme.com/contact' );
		define('team_qa_url', 'http://paratheme.com/qa/' );
		define('team_plugin_name', 'Team' );
		define('team_plugin_version', '1.7' );
		define('team_customer_type', 'free' );	 // pro & free	
		define('team_share_url', 'http://wordpress.org/plugins/team/' );
		define('team_tutorial_video_url', '//www.youtube.com/embed/8OiNCDavSQg?rel=0' );
		define('team_tutorial_doc_url', 'http://paratheme.com/documentation/documentation/team/' );		
		
		include( 'includes/class-post-types.php' );
		include( 'includes/class-post-meta.php' );		
		include( 'includes/class-settings.php' );		
		include( 'includes/class-functions.php' );
		include( 'includes/class-shortcodes.php' );

		add_action( 'wp_enqueue_scripts', array( $this, 'team_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'team_admin_scripts' ) );
		//add_action( 'admin_footer', array( $this, 'colorpickersjs' ) );				
		//add_action( 'admin_enqueue_scripts', 'wptuts_add_color_picker' );

		}
		
		

		

		
	public function team_install(){
		
		do_action( 'team_action_install' );
		
		}		
		
	public function team_uninstall(){
		
		do_action( 'team_action_uninstall' );
		}		
		
	public function team_deactivation(){
		
		do_action( 'team_action_deactivation' );
		}
		
		
	public function team_front_scripts(){
			
		wp_enqueue_script('jquery');
		wp_enqueue_script('team_front_js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));	
		wp_localize_script('team_front_js', 'team_ajax', array( 'team_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		//wp_enqueue_style('team_front_style', team_plugin_url.'css/style.css'); //ssl issue
		wp_enqueue_style('team_front_style', plugins_url( 'css/style.css', __FILE__ ));

		do_action('team_action_front_scripts');
		}		
		
	public function team_admin_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		//wp_enqueue_script('jquery-ui-droppable');
		
		wp_enqueue_style('team_admin_style', plugins_url( 'css/style-admin.css', __FILE__ ));	
		
		wp_enqueue_script('team_admin_js', plugins_url( '/js/scripts-admin.js' , __FILE__ ) , array( 'jquery' ));			
		
		//wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'color-picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), true, true );
		
		
		//ParaAdmin
		//wp_enqueue_style('ParaAdmin', team_plugin_url.'ParaAdmin/css/ParaAdmin.css'); //ssl issue
		wp_enqueue_style('ParaAdmin', plugins_url( 'ParaAdmin/css/ParaAdmin.css', __FILE__ ));
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));
		
		
		do_action('team_action_admin_scripts');
		}		
		


	}
	
	new Team();