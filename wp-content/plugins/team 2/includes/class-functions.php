<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Includes
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_team_functions  {
	
	
    public function __construct()
    {
		
		
		//$this->settings_page = new Team_Settings();
		
		
		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
       //add_action('admin_menu', array($this, 'create_menu'));
    }
	

		
		
	public function team_member_posttype($posttype = array('team_member'))
		{
			return apply_filters('team_member_posttype', $posttype);
		}
		
	public function team_member_taxonomy($taxonomy = 'team_group')
		{
			return apply_filters('team_member_taxonomy', $taxonomy); //string only
		}		
		
		
		
		
	public function team_member_social_field()
		{
			
			$social_field = array(
									"mobile"=>"mobile",					
									"website"=>"website",						
									"email"=>"email",						
									"skype"=>"skype",					
									"facebook"=>"facebook",
									"twitter"=>"twitter",
									"googleplus"=>"googleplus",
									"pinterest"=>"pinterest",
									"linkedin"=>"linkedin",
									"vimeo"=>"vimeo",															
					);




			return apply_filters( 'team_member_social_field', $social_field );

			}		
		
		
		
		
		
	public function team_grid_items()
		{

			$team_grid_items = array(
					'thumbnail'=>__('Thumbnail','team'),
					'title'=>__('Title','team'),
					'position'=>__('Position','team'),
					'content'=>__('Content','team'),
					'social'=>__('Social','team'),			
					);

			return $team_grid_items;
			}




		
	public function team_themes($themes = array())
		{

			$themes = array(
							'flat'=>'Flat',
							'rounded'=>'Rounded',									
							);
			
			foreach(apply_filters( 'team_themes', $themes ) as $theme_key=> $theme_name)
				{
					$theme_list[$theme_key] = $theme_name;
				}

			
			return $theme_list;

		}
	
		
	public function team_themes_dir($themes_dir = array())
		{
			$main_dir = team_plugin_dir.'themes/';
			
			$themes_dir = array(
							'flat'=>$main_dir.'flat',
							'rounded'=>$main_dir.'rounded',												
							);
			
			foreach(apply_filters( 'team_themes_dir', $themes_dir ) as $theme_key=> $theme_dir)
				{
					$theme_list_dir[$theme_key] = $theme_dir;
				}

			
			return $theme_list_dir;

		}


	public function team_themes_url($themes_url = array())
		{
			$main_url = team_plugin_url.'themes/';
			
			$themes_url = array(
							'flat'=>$main_url.'flat',
							'rounded'=>$main_url.'rounded',												
							);
			
			foreach(apply_filters( 'team_themes_url', $themes_url ) as $theme_key=> $theme_url)
				{
					$theme_list_url[$theme_key] = $theme_url;
				}

			return $theme_list_url;

		}



public function team_get_all_post_ids($postid)
	{
		
		$team_post_ids = get_post_meta( $postid, 'team_post_ids', true );
		
		
		$return_string = '';
		$return_string .= '<ul style="margin: 0;">';

		$args_product = array(
		'post_type' => array('team_member'),
		'posts_per_page' => -1,
		);

		$member_query = new WP_Query( $args_product );
	
		if($member_query->have_posts())
		
			{
				while($member_query->have_posts()): $member_query->the_post();
				
		
			   $return_string .= '<li><label ><input class="team_post_ids" type="checkbox" name="team_post_ids['.get_the_ID().']" value ="'.get_the_ID().'" ';
				
				if ( isset( $team_post_ids[get_the_ID()] ) )
					{
						$return_string .= "checked";
					}
		
				$return_string .= '/>';
		
				$return_string .= get_the_title().'</label ></li>';
					
				endwhile; 
				wp_reset_query();
			}
		

		
		
		else
			{
		$return_string .= '<span style="color:#f00;">'.__('Sorry No Post Found, Please create some team member first.','team');
			}

	
		
		
		$return_string .= '</ul>';
		return $return_string;
	
	}
	
	public function team_get_taxonomy_category($postid)
		{
	
		$team_taxonomy = array('team_group');
		
		if(empty($team_taxonomy))
			{
				$team_taxonomy= "";
			}
		$team_taxonomy_terms = get_post_meta( $postid, 'team_taxonomy_terms', true );
		
			
			if(empty($team_taxonomy_terms))
				{
					$team_taxonomy_terms =array('none'); // an empty array when no category element selected
	
				}
	
			if(!isset($_POST['taxonomy']))
				{
				$taxonomy =$team_taxonomy;
				}
			else
				{
				$taxonomy = $_POST['taxonomy'];
				}
			
			
			$args=array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'taxonomy' => $taxonomy,
			  );
		
		$categories = get_categories($args);
		
		
		if(empty($categories))
			{
			echo __("No Items Found!",'team');
			}
		
		
			$return_string = '';
			$return_string .= '<ul style="margin: 0;">';
		
		foreach($categories as $category){
			
			if(array_search($category->cat_ID, $team_taxonomy_terms))
			{
		   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="team_taxonomy_terms" checked type="checkbox" name="team_taxonomy_terms['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';
			}
			
			else
				{
					   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="team_taxonomy_terms" type="checkbox" name="team_taxonomy_terms['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';			
				}
			
			}
		
			$return_string .= '</ul>';
			
			return $return_string;
		
		if(isset($_POST['taxonomy']))
			{
				die();
			}
		
			
		}
		
	public function team_share_plugin()
		{
			
			?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=652982311485932";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
            
            <br /><br />
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="<?php echo team_share_url; ?>"></div>
            
            <br />
            <br />
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo team_share_url; ?>" data-text="<?php echo team_plugin_name; ?>" data-via="ParaTheme" data-hashtags="WordPress">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>



            <?php
			
			
			
		
		
		}






}


new class_team_functions();

