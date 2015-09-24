<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Includes
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class team_class_settings  {
	
	
    public function __construct()
    {
		
		
		//$this->settings_page = new Team_Settings();
		
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
       //add_action('admin_menu', array($this, 'create_menu'));
    }
	
	
	public function admin_menu() {
		add_submenu_page( 'edit.php?post_type=team', __( 'Settings', 'team' ), __( 'Settings', 'team' ), 'manage_options', 'team-settings', array( $this, 'settings_page' ) );
		
		//add_submenu_page( 'edit.php?post_type=team', __( 'License', 'team' ), __( 'License', 'team' ), 'manage_options', 'team-license', array( $this, 'license_page' ) );		


	}
	
	public function settings_page(){
		
		include( 'menu/settings.php' );	
		
		}
	
	public function license_page(){
		
		include( 'menu/license.php' );	
		
		}	

	
	
	
	
	
	

}


new team_class_settings();

