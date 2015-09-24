<?php


/*
* @Author 		ParaTheme
* @Folder	 	Team/Includes
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

add_action('init', 'team_member_register');
 
function team_member_register() {
 
        $labels = array(
                'name' => _x('Team Member', 'post type general name'),
                'singular_name' => _x('Team Member', 'post type singular name'),
                'add_new' => _x('Add Team Member', 'team_member'),
                'add_new_item' => __('Add Team Member'),
                'edit_item' => __('Edit Team Member'),
                'new_item' => __('New Team Member'),
                'view_item' => __('View Team Member'),
                'search_items' => __('Search Team Member'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title','editor','thumbnail'),
				'menu_icon' => 'dashicons-admin-users',
				

          );
 
        register_post_type( 'team_member' , $args );

}












// Custom Taxonomy
 
function add_team_member_taxonomies() {
 
        register_taxonomy('team_group', 'team_member', array(
                // Hierarchical taxonomy (like categories)
                'hierarchical' => true,
                'show_admin_column' => true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                        'name' => _x( 'Team Group', 'taxonomy general name' ),
                        'singular_name' => _x( 'Team Group', 'taxonomy singular name' ),
                        'search_items' =>  __( 'Search Team Groups' ),
                        'all_items' => __( 'All Team Groups' ),
                        'parent_item' => __( 'Parent Team Group' ),
                        'parent_item_colon' => __( 'Parent Team Group:' ),
                        'edit_item' => __( 'Edit Team Group' ),
                        'update_item' => __( 'Update Team Group' ),
                        'add_new_item' => __( 'Add New Team Group' ),
                        'new_item_name' => __( 'New Team Group Name' ),
                        'menu_name' => __( 'Team Groups' ),

                ),
                // Control the slugs used for this taxonomy
				

                'rewrite' => array(
                        'slug' => 'team_group', // This controls the base slug that will display before each term
                        'with_front' => false, // Don't display the category base before "/locations/"
                        'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
                ),
        ));
}
add_action( 'init', 'add_team_member_taxonomies', 0 );









/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_team_member()
	{
		$screens = array( 'team_member' );
		foreach ( $screens as $screen )
			{
				add_meta_box('team_member_metabox',__( 'Team Member Options','team_member' ),'meta_boxes_team_member_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_team_member' );


function meta_boxes_team_member_input( $post ) {
	
	global $post;
	wp_nonce_field( 'meta_boxes_team_member_input', 'meta_boxes_team_member_input_nonce' );
	


	$team_member_position = get_post_meta( $post->ID, 'team_member_position', true );
	$team_member_social_links = get_post_meta( $post->ID, 'team_member_social_links', true );	
	$team_member_link_to_post = get_post_meta( $post->ID, 'team_member_link_to_post', true );




?>


    <div class="para-settings">
		<div class="option-box">
			<p class="option-title"><?php _e('Member Position.','team'); ?></p>
 			<p class="option-info"></p>
			<input type="text" size="30" placeholder="Team Leader"   name="team_member_position" value="<?php if(!empty($team_member_position)) echo $team_member_position; ?>" />
		</div>

		<?php
        $team_member_social_field = get_option( 'team_member_social_field' );
		
		if(empty($team_member_social_field))
			{
				$team_member_social_field = array("facebook"=>"facebook","twitter"=>"twitter","googleplus"=>"googleplus","pinterest"=>"pinterest");
				
			}

		foreach ($team_member_social_field as $value) {
			if(!empty($value))
				{
					if($value == 'skype')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Skype.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="skypeusername"   name="team_member_social_links[<?php echo $value; ?>]" value="<?php if(!empty($team_member_social_links[$value])) echo $team_member_social_links[$value]; ?>" />
                        </div> 
						
						<?php
						}
						
						
						
						
					else if($value == 'mobile')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Mobile/Telephone .','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="+01895632456"   name="team_member_social_links[<?php echo $value; ?>]" value="<?php if(!empty($team_member_social_links[$value])) echo $team_member_social_links[$value]; ?>" />
                        </div> 
						
						<?php
						}						
						
						
					else if($value == 'email')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Email.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="hello@exapmle.com"   name="team_member_social_links[<?php echo $value; ?>]" value="<?php if(!empty($team_member_social_links[$value])) echo $team_member_social_links[$value]; ?>" />
                        </div> 
						
						<?php
						}
					else if($value == 'website')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Website.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="http://exapmle.com"   name="team_member_social_links[<?php echo $value; ?>]" value="<?php if(!empty($team_member_social_links[$value])) echo $team_member_social_links[$value]; ?>" />
                        </div> 
						
						<?php
						}
					else
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php echo ucfirst($value); ?><?php _e(' Profile url.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="http://exapmle.com/username"   name="team_member_social_links[<?php echo $value; ?>]" value="<?php if(!empty($team_member_social_links[$value])) echo $team_member_social_links[$value]; ?>" />
                        </div> 
						
						<?php
						}					
					
					

                    
                    }
            }
            
            ?>
            
            
		<div class="option-box">
			<p class="option-title"><?php _e('Custom link to this member.','team'); ?></p>
 			<p class="option-info"></p>
        <input type="text" size="30" placeholder=""   name="team_member_link_to_post" value="<?php if(!empty($team_member_link_to_post)) echo $team_member_link_to_post; ?>" />
		</div> 
            
            
            
 
	</div> <!-- para-settings -->



<?php


	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_team_member_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_team_member_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_team_member_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_team_member_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  
 	$team_member_position = sanitize_text_field( $_POST['team_member_position'] );
 	update_post_meta( $post_id, 'team_member_position', $team_member_position );


	

	$team_member_social_links = stripslashes_deep( $_POST['team_member_social_links'] );
	update_post_meta( $post_id, 'team_member_social_links', $team_member_social_links );

	$team_member_link_to_post = sanitize_text_field( $_POST['team_member_link_to_post'] );
	update_post_meta( $post_id, 'team_member_link_to_post', $team_member_link_to_post );

}
add_action( 'save_post', 'meta_boxes_team_member_save' );




















function team_posttype_register() {
 
        $labels = array(
                'name' => _x('Team', 'team'),
                'singular_name' => _x('Team', 'team'),
                'add_new' => _x('New Team', 'team'),
                'add_new_item' => __('New Team'),
                'edit_item' => __('Edit Team'),
                'new_item' => __('New Team'),
                'view_item' => __('View Team'),
                'search_items' => __('Search Team'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-groups',
				
          );
 
        register_post_type( 'team' , $args );

}

add_action('init', 'team_posttype_register');





/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_team()
	{
		$screens = array( 'team' );
		foreach ( $screens as $screen )
			{
				add_meta_box('team_metabox',__( 'Team Options','team' ),'meta_boxes_team_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_team' );


function meta_boxes_team_input( $post ) {
	
	global $post;
	
	$team_id = $post->ID;
	
	wp_nonce_field( 'meta_boxes_team_input', 'meta_boxes_team_input_nonce' );
	
	
	$team_bg_img = get_post_meta( $post->ID, 'team_bg_img', true );
	
	$team_themes = get_post_meta( $post->ID, 'team_themes', true );
	$team_social_icon_style = get_post_meta( $post->ID, 'team_social_icon_style', true );	
	$team_masonry_enable = get_post_meta( $post->ID, 'team_masonry_enable', true );	
	
	$team_grid_item_align = get_post_meta( $post->ID, 'team_grid_item_align', true );	
	$team_item_text_align = get_post_meta( $post->ID, 'team_item_text_align', true );	
	$team_total_items = get_post_meta( $post->ID, 'team_total_items', true );	
	$team_pagination_display = get_post_meta( $post->ID, 'team_pagination_display', true );	

	$team_query_order = get_post_meta( $post->ID, 'team_query_order', true );
	$team_query_orderby = get_post_meta( $post->ID, 'team_query_orderby', true );


	$team_content_source = get_post_meta( $post->ID, 'team_content_source', true );
	$team_content_year = get_post_meta( $post->ID, 'team_content_year', true );
	$team_content_month = get_post_meta( $post->ID, 'team_content_month', true );
	$team_content_month_year = get_post_meta( $post->ID, 'team_content_month_year', true );	


	$team_taxonomy_category = get_post_meta( $post->ID, 'team_taxonomy_category', true );
	
	$team_post_ids = get_post_meta( $post->ID, 'team_post_ids', true );	

	
	
	
	$team_items_title_color = get_post_meta( $post->ID, 'team_items_title_color', true );	
	$team_items_title_font_size = get_post_meta( $post->ID, 'team_items_title_font_size', true );

	$team_items_position_color = get_post_meta( $post->ID, 'team_items_position_color', true );
	$team_items_position_font_size = get_post_meta( $post->ID, 'team_items_position_font_size', true );

	$team_items_content = get_post_meta( $post->ID, 'team_items_content', true );
	$team_items_content_color = get_post_meta( $post->ID, 'team_items_content_color', true );	
	$team_items_content_font_size = get_post_meta( $post->ID, 'team_items_content_font_size', true );		

	$team_items_excerpt_count = get_post_meta( $post->ID, 'team_items_excerpt_count', true );	
	$team_items_excerpt_text = get_post_meta( $post->ID, 'team_items_excerpt_text', true );	
	
	$team_items_thumb_size = get_post_meta( $post->ID, 'team_items_thumb_size', true );
	$team_items_link_to_post = get_post_meta( $post->ID, 'team_items_link_to_post', true );	
	$team_items_max_width = get_post_meta( $post->ID, 'team_items_max_width', true );
	$team_items_width_mobile = get_post_meta( $post->ID, 'team_items_width_mobile', true );	
	$team_items_thumb_max_hieght = get_post_meta( $post->ID, 'team_items_thumb_max_hieght', true );	
	
	$team_items_margin = get_post_meta( $post->ID, 'team_items_margin', true );		
	$team_items_social_icon_width = get_post_meta( $post->ID, 'team_items_social_icon_width', true );	
	$team_items_social_icon_height = get_post_meta( $post->ID, 'team_items_social_icon_height', true );	
	
	$team_items_custom_css = get_post_meta( $post->ID, 'team_items_custom_css', true );		
 
	$team_items_popup_content = get_post_meta( $post->ID, 'team_items_popup_content', true );	
	$team_items_popup_excerpt_count = get_post_meta( $post->ID, 'team_items_popup_excerpt_count', true );
	$team_items_popup_excerpt_text = get_post_meta( $post->ID, 'team_items_popup_excerpt_text', true );

	$team_items_post_per_page_mixitup = get_post_meta( $post->ID, 'team_items_post_per_page_mixitup', true );
	$team_items_default_filter_mixitup = get_post_meta( $post->ID, 'team_items_default_filter_mixitup', true );


?>





	<div class="para-settings">
    
    
				<div class="option-box">
                    <p class="option-title"><?php _e('Shortcode.','team'); ?></p>
                    <p class="option-info"><?php _e('Copy this shortcode and paste on page or post where you want to display Team. <br />Use PHP code to your themes file to display Team.','team'); ?></p>
					<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" >[team <?php echo ' id="'.$post->ID.'"';?> ]</textarea><br />
					<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team id='; echo "'".$post->ID."' ]"; echo '"); ?>'; ?></textarea>  

                </div> 
    
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active"><?php _e('Options','team'); ?></li>
            <li nav="2" class="nav2"><?php _e('Style','team'); ?></li>
            <li nav="3" class="nav3"><?php _e('Content','team'); ?></li>
            <li nav="4" class="nav4"><?php _e('MixitUp','team'); ?></li>            
            <li nav="5" class="nav5"><?php _e('Custom CSS','team'); ?></li>            
            
        </ul> <!-- tab-nav end -->
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
				<div class="option-box">
                    <p class="option-title"><?php _e('Total number of members on each page(pagination).','team'); ?></p>
                    <p class="option-info"><?php _e('You can display pagination or Total number of member on grid.','team'); ?></p>
                    <input type="text" placeholder="ex:5 - Number Only"   name="team_total_items" value="<?php if(!empty($team_total_items))echo $team_total_items; else echo 5; ?>" />
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Display Pagination</p>
                    <p class="option-info"></p>
                    
					<select name="team_pagination_display"  >
                    <option value="no" <?php if($team_pagination_display=="no")echo "selected"; ?>>No</option>
                    <option value="yes" <?php if($team_pagination_display=="yes")echo "selected"; ?>>Yes</option>
                                      
                    </select>
                  
                </div>  
                
                
                
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Thumbnail Size.','team'); ?></p>
                    <p class="option-info"><?php _e('Thumbnail size of member on grid.','team'); ?></p>
                    <select name="team_items_thumb_size" >
                    <option value="none" <?php if($team_items_thumb_size=="none")echo "selected"; ?>>None</option>
                    <option value="thumbnail" <?php if($team_items_thumb_size=="thumbnail")echo "selected"; ?>>Thumbnail</option>
                    <option value="medium" <?php if($team_items_thumb_size=="medium")echo "selected"; ?>>Medium</option>
                    <option value="large" <?php if($team_items_thumb_size=="large")echo "selected"; ?>>Large</option>                               
                    <option value="full" <?php if($team_items_thumb_size=="full")echo "selected"; ?>>Full</option>   

                    </select>
                </div>      
                          
				<div class="option-box">
                    <p class="option-title"><?php _e('Link to Member.','team'); ?></p>
                    <p class="option-info"><?php _e('Clickable link to post team member.','team'); ?></p>
                    <select name="team_items_link_to_post" >
                   		<option value="no" <?php if($team_items_link_to_post=="no")echo "selected"; ?>>No</option>
                    	<option value="yes" <?php if($team_items_link_to_post=="yes")echo "selected"; ?>>Custom Post</option>
                        <option value="custom" <?php if($team_items_link_to_post=="custom")echo "selected"; ?>>Custom Link</option>
                        <option value="popup" <?php if($team_items_link_to_post=="popup")echo "selected"; ?>>Popup Profile</option>                        
                        
                    </select>
                </div>   

            
				
				<div class="option-box">
                    <p class="option-title">Member Bio Popup Content Display</p>
                    <p class="option-info"></p>
                    <ul class="content_source_area" >

                        <li>
                        	<input class="team_content_source" name="team_items_popup_content" id="team_items_popup_content" type="radio" value="full" <?php if($team_items_popup_content=="full")  echo "checked";?> /> 
                            <label for="team_items_popup_content">Display full content</label>
                            <div class="team_items_popup_content content-source-box">
                            Member bio content will display from full content.
                            </div>
                        </li>
                        
                        
                        <li>
                        	<input class="team_content_source" name="team_items_popup_content" id="team_items_popup_excerpt" type="radio" value="excerpt" <?php if($team_items_popup_content=="excerpt")  echo "checked";?> /> 
                            <label for="team_items_popup_excerpt">Display excerpt</label>
                            <div class="team_items_popup_excerpt content-source-box">
                            Member bio content will display from excerpt.<br />
                            Excrept Length:
                            <input type="text" placeholder="25" size="4" name="team_items_popup_excerpt_count" value="<?php if(isset($team_items_popup_excerpt_count))  echo $team_items_popup_excerpt_count; ?>" />
                            <br />
                            Read More Text: 
                            <input type="text" placeholder="Read More..." size="10" name="team_items_popup_excerpt_text" value="<?php if(isset($team_items_popup_excerpt_text))  echo $team_items_popup_excerpt_text; ?>" />
                            
                            </div>
                        </li>                        

					</ul>
                </div>






				<div class="option-box">
                    <p class="option-title"><?php _e('Grid item max Width(px).','team'); ?></p>
                    <p class="option-info"><?php _e('Maximum width for grid items.','team'); ?></p>
                    
                    For Destop:<br/>
                    
                    
					<input type="text" name="team_items_max_width" placeholder="ex:150px, px or %" id="team_items_max_width" value="<?php if(!empty($team_items_max_width)) echo $team_items_max_width; else echo ""; ?>" />
                    For Mobile:<br/>
					<input type="text" name="team_items_width_mobile" placeholder="ex:150px, px or %" id="team_items_width_mobile" value="<?php if(!empty($team_items_width_mobile)) echo $team_items_width_mobile; else echo "90%"; ?>" />
                    
                </div> 



				<div class="option-box">
                    <p class="option-title"><?php _e('Grid item thumbnail max Height(px).','team'); ?></p>
                    <p class="option-info"><?php _e('Maximum Height for grid items thumbnail.','team'); ?></p>
					<input type="text" name="team_items_thumb_max_hieght" placeholder="ex:150px number with px" id="team_items_thumb_max_hieght" value="<?php if(!empty($team_items_thumb_max_hieght)) echo $team_items_thumb_max_hieght; else echo ""; ?>" />
				</div>

				<div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Margin (px).','team'); ?></p>
                    <p class="option-info"><?php _e('You can use general CSS rules for margin, ex:10px, <br /> 10px 10px, <br /> 10px 10px 10px, <br /> 10px 10px 10px 10px.','team'); ?></p>
					<input type="text" name="team_items_margin" placeholder="ex:20px number with px" id="team_items_margin" value="<?php if(!empty($team_items_margin)) echo $team_items_margin; else echo ""; ?>" />
				</div>

            
				<div class="option-box">
                    <p class="option-title"><?php _e('Social icons size(px).','team'); ?></p>
                    <p class="option-info"><?php _e('you can change social icons height & width here.','team'); ?></p>					Width:<br />
					<input type="text" name="team_items_social_icon_width" placeholder="ex:20px number with px"  value="<?php if(!empty($team_items_social_icon_width)) echo $team_items_social_icon_width; else echo ""; ?>" />
                    <br />
                    Height:<br/>
					<input type="text" name="team_items_social_icon_height" placeholder="ex:20px number with px"  value="<?php if(!empty($team_items_social_icon_height)) echo $team_items_social_icon_height; else echo ""; ?>" />                    
                    
				</div>            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Social icon style.','team'); ?></p>
                    <p class="option-info"><?php _e('','team'); ?></p>
                    <select name="team_social_icon_style"  >
                    <option  value="flat" <?php if($team_social_icon_style=="flat")echo "selected"; ?>>Flat</option>
                    <option  value="rounded" <?php if($team_social_icon_style=="rounded")echo "selected"; ?>>Rounded</option>
                    <option  value="rounded-border" <?php if($team_social_icon_style=="rounded-border")echo "selected"; ?>>Rounded Border</option>                    
                    <option  value="semi-rounded" <?php if($team_social_icon_style=="semi-rounded")echo "selected"; ?>>Semi Rounded</option>                    
                    
             
                    </select>
				</div> 
            
            
            
            
            
            </li>
			<li style="display: none;" class="box2 tab-box">
				<div class="option-box">
                    <p class="option-title"><?php _e('Themes.','team'); ?></p>
                    <p class="option-info"><?php _e('Themes for Team grid.','team'); ?></p>
                    
                    
                    <?php
                    
						$team_themes_define = team_themes();
						
						$team_themes_list = get_option( 'team_themes_list' );
						
						if(empty($team_themes_list))
							{
								$team_themes_list = $team_themes_define;
							}
					?>
                    
                    
                    
                    <select name="team_themes"  >
                    
                    <?php
                    	
						foreach($team_themes_list as $key => $value)
							{
								?>
                                <option value="<?php echo $key; ?>" <?php if($team_themes== $key )echo "selected"; ?>><?php echo $value; ?></option>
                                
                                <?php
								
								
							}
					
					?>

                    </select>
				</div>
            
            
            
            
            
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Active Masonry Grid.','team'); ?></p>
                    <p class="option-info"><?php _e('Masonry Style grid.','team'); ?></p>
                    <select name="team_masonry_enable"  >
                    <option  value="no" <?php if($team_masonry_enable=="no")echo "selected"; ?>>No</option>
                    <option  value="yes" <?php if($team_masonry_enable=="yes")echo "selected"; ?>>Yes</option>
             
                    </select>
				</div>            
            
            
            
            
            
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Grid Item Align.','team'); ?></p>
                    <p class="option-info"></p>
                    <select id="team_grid_item_align" name="team_grid_item_align"  >
                    <option class="team_grid_item_align" value="left" <?php if($team_grid_item_align=="left")echo "selected"; ?>>Left</option>
                    
                    <option class="team_grid_item_align" value="center" <?php if($team_grid_item_align=="center")echo "selected"; ?>>Center</option>
                    
                    <option class="team_grid_item_align" value="right" <?php if($team_grid_item_align=="right")echo "selected"; ?>>Right</option>                    
                    </select>
				</div>
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Text Align.','team'); ?></p>
                    <p class="option-info"></p>
                    <select id="team_item_text_align" name="team_item_text_align"  >
                    <option class="team_item_text_align" value="left" <?php if($team_item_text_align=="left")echo "selected"; ?>>Left</option>
                    
                    <option class="team_item_text_align" value="center" <?php if($team_item_text_align=="center")echo "selected"; ?>>Center</option>
                    
                    <option class="team_item_text_align" value="right" <?php if($team_item_text_align=="right")echo "selected"; ?>>Right</option>                    
                    </select>
				</div>    
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Background Image.','team'); ?></p>
                    <p class="option-info"><?php _e('Background image for team area.','team'); ?></p>
                                           
            <script>
            jQuery(document).ready(function(jQuery)
                {
                        jQuery(".team_bg_img_list li").click(function()
                            { 	
                                jQuery('.team_bg_img_list li.bg-selected').removeClass('bg-selected');
                                jQuery(this).addClass('bg-selected');
                                
                                var team_bg_img = jQuery(this).attr('data-url');
            
                                jQuery('#team_bg_img').val(team_bg_img);
                                
                            })	
            
                                
                })
            
            </script> 
                    
            
            <?php
            
            
            
                $dir_path = team_plugin_dir."css/bg/";
                $filenames=glob($dir_path."*.png*");
            
            
                $team_bg_img = get_post_meta( $post->ID, 'team_bg_img', true );
                
                if(empty($team_bg_img))
                    {
                    $team_bg_img = "";
                    }
            
            
                $count=count($filenames);
                
            
                $i=0;
                echo "<ul class='team_bg_img_list' >";
            
                while($i<$count)
                    {
                        $filelink= str_replace($dir_path,"",$filenames[$i]);
                        
                        $filelink= team_plugin_url."css/bg/".$filelink;
                        
                        
                        if($team_bg_img==$filelink)
                            {
                                echo '<li  class="bg-selected" data-url="'.$filelink.'">';
                            }
                        else
                            {
                                echo '<li   data-url="'.$filelink.'">';
                            }
                        
                        
                        echo "<img  width='70px' height='50px' src='".$filelink."' />";
                        echo "</li>";
                        $i++;
                    }
                    
                echo "</ul>";
                
                echo "<input style='width:100%;' value='".$team_bg_img."'    placeholder='Please select image or left blank' id='team_bg_img' name='team_bg_img'  type='text' />";
            
            
            
            ?>
				</div>             


				<div class="option-box">
                    <p class="option-title"><?php _e('Member Name Font Color.','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" name="team_items_title_color" id="team_items_title_color" value="<?php if(!empty($team_items_title_color)) echo $team_items_title_color; else echo ""; ?>" />
				</div>

				<div class="option-box">
                    <p class="option-title"><?php _e('Member Name Font Size.','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" name="team_items_title_font_size" placeholder="ex:14px number with px" id="team_items_title_font_size" value="<?php if(!empty($team_items_title_font_size)) echo $team_items_title_font_size; else echo "14px"; ?>" />
				</div>


				<div class="option-box">
                    <p class="option-title"><?php _e('Member Position Font Color.','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" name="team_items_position_color" placeholder="#ffffff" id="team_items_position_color" value="<?php if(!empty($team_items_position_color)) echo $team_items_position_color; else echo ""; ?>" />
				</div>

				<div class="option-box">
                    <p class="option-title"><?php _e('Member Position Font Size.','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" name="team_items_position_font_size" placeholder="ex:12px number with px" id="team_items_position_font_size" value="<?php if(!empty($team_items_position_font_size)) echo $team_items_position_font_size; else echo ""; ?>" />
				</div>


				<div class="option-box">
                    <p class="option-title"><?php _e('Member Bio Font Color.','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" name="team_items_content_color" id="team_items_content_color" value="<?php if(!empty($team_items_content_color)) echo $team_items_content_color; else echo ""; ?>" />
				</div>


				<div class="option-box">
                    <p class="option-title"><?php _e('Member Bio Font Size.','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" placeholder="ex:12px number with px" name="team_items_content_font_size" id="team_items_content_font_size" value="<?php if(!empty($team_items_content_font_size)) echo $team_items_content_font_size; else echo "13px"; ?>" />
				</div>


				


            
            </li>
			<li style="display: none;" class="box3 tab-box">
            
            
            
				<div class="option-box">
                    <p class="option-title">Member Bio Content Display</p>
                    <p class="option-info"></p>
                    <ul class="content_source_area" >

                        <li>
                        	<input class="team_content_source" name="team_items_content" id="team_items_content" type="radio" value="full" <?php if($team_items_content=="full")  echo "checked";?> /> 
                            <label for="team_items_content">Display full content</label>
                            <div class="team_items_content content-source-box">
                            Member bio content will display from full content.
                            </div>
                        </li>
                        
                        
                        <li>
                        	<input class="team_content_source" name="team_items_content" id="team_items_excerpt" type="radio" value="excerpt" <?php if($team_items_content=="excerpt")  echo "checked";?> /> 
                            <label for="team_items_excerpt">Display excerpt</label>
                            <div class="team_items_excerpt content-source-box">
                            Member bio content will display from excerpt.<br />
                            Excrept Length:
                            <input type="text" placeholder="25" size="4" name="team_items_excerpt_count" value="<?php if(isset($team_items_excerpt_count))  echo $team_items_excerpt_count; ?>" />
                            <br />
                            Read More Text: 
                            <input type="text" placeholder="Read More..." size="10" name="team_items_excerpt_text" value="<?php if(isset($team_items_excerpt_text))  echo $team_items_excerpt_text; ?>" />
                            
                            </div>
                        </li>                        

					</ul>
                </div>
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Post query orderby','team'); ?></p>
                    <p class="option-info"></p>
                    <select name="team_query_orderby" >
                    <option value="none" <?php if($team_query_orderby=="none") echo "selected"; ?>>None</option>
                    <option value="ID" <?php if($team_query_orderby=="ID") echo "selected"; ?>>ID</option>
                    <option value="date" <?php if($team_query_orderby=="date") echo "selected"; ?>>Date</option>
                    <option value="rand" <?php if($team_query_orderby=="rand") echo "selected"; ?>>Rand</option>
                    <option value="title" <?php if($team_query_orderby=="title") echo "selected"; ?>>Title(post title)</option>
                    <option value="name" <?php if($team_query_orderby=="name") echo "selected"; ?>>Name(post slug)</option>                          
                    
                    
               

                    </select>
                </div> 
            
            
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Post query order','team'); ?></p>
                    <p class="option-info"></p>
                    <select name="team_query_order" >
                    <option value="ASC" <?php if($team_query_order=="ASC") echo "selected"; ?>>ASC</option>
                    <option value="DESC" <?php if($team_query_order=="DESC") echo "selected"; ?>>DESC</option>

                    </select>
                </div>
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Filter Member.','team'); ?></p>
                    <p class="option-info"></p>
<ul class="content_source_area" >

            <li><input class="team_content_source" name="team_content_source" id="team_content_source_latest" type="radio" value="latest" <?php if($team_content_source=="latest")  echo "checked";?> /> <label for="team_content_source_latest"><?php _e('Display from Latest Published Member.','team'); ?></label>
            <div class="team_content_source_latest content-source-box">Team items will query from latest published Members.</div>
            </li>

            <li><input class="team_content_source" name="team_content_source" id="team_content_source_year" type="radio" value="year" <?php if($team_content_source=="year")  echo "checked";?> /> <label for="team_content_source_year"><?php _e('Display from Only Year.','team'); ?></label>
            
            <div class="team_content_source_year content-source-box"><?php _e('Member items will query from a year.','team'); ?>
            <input type="text" size="7" class="team_content_year" name="team_content_year" value="<?php if(!empty($team_content_year))  echo $team_content_year;?>" placeholder="2014" />
            </div>
            </li>
            
            
            <li><input class="team_content_source" name="team_content_source" id="team_content_source_month" type="radio" value="month" <?php if($team_content_source=="month")  echo "checked";?> /> <label for="team_content_source_month"><?php _e('Display from Month.','team'); ?></label>
            
            <div class="team_content_source_month content-source-box"><?php _e('Member items will query from Month of a year.','team'); ?><br />
			<input type="text" size="7" class="team_content_month_year" name="team_content_month_year" value="<?php if(!empty($team_content_month_year))  echo $team_content_month_year;?>" placeholder="2014" />            
			<input type="text" size="7" class="team_content_month" name="team_content_month" value="<?php if(!empty($team_content_month))  echo $team_content_month;?>" placeholder="06" />
            </div>
            </li>            

            <li><input class="team_content_source" name="team_content_source" id="team_content_source_taxonomy" type="radio" value="taxonomy" <?php if($team_content_source=="taxonomy")  echo "checked";?> /> <label for="team_content_source_taxonomy"><?php _e('Display from Member Group.','team'); ?></label>
            
            <div class="team_content_source_taxonomy content-source-box" >
				<?php

					echo team_get_taxonomy_category($post->ID);
				
				?>
            
            </div>
            </li>           
            <li><input class="team_content_source" name="team_content_source" id="team_content_source_post_id" type="radio" value="post_id" <?php if($team_content_source=="post_id")  echo "checked";?> /> <label for="team_content_source_post_id"><?php _e('Display by Member id.','team'); ?></label>
            
            <div  class="team_content_source_post_id content-source-box" >
				<?php

                      echo  team_get_all_post_ids($post->ID);

                ?>
          
            </div>
            </li>
            </ul>
            </div>
            
            
            
            
            
            
            
            </li>
            
            <li style="display: none;" class="box4 tab-box">
				<div class="option-box">
                    <p class="option-title"><?php _e('MixitUp post per page(pagination).','team'); ?></p>
                    <p class="option-info"></p>
                    <input type="text" placeholder="3" name="team_items_post_per_page_mixitup" id="team_items_post_per_page_mixitup" value="<?php if(!empty($team_items_post_per_page_mixitup)) echo $team_items_post_per_page_mixitup; else echo "3"; ?>" />
				</div>
                
				<div class="option-box">
                    <p class="option-title"><?php _e('MixitUp default active filter.','team'); ?></p>
                    <p class="option-info">Display group of member at first.</p>
                    
                    <?php
                    
					//var_dump($team_taxonomy_category);
					$team_taxonomy = 'team_group';
					if(!empty($team_taxonomy_category))
						{
							foreach($team_taxonomy_category as $term_id)
								{
									$term = get_term( $term_id, $team_taxonomy );
									$term_slug = $term->slug;
									$term_name = $term->name;
									echo '<label><input type="radio" name="team_items_default_filter_mixitup" value="'.$term_slug.'" ';
									
									if($team_items_default_filter_mixitup == $term_slug)
										{
											echo 'checked';
										}
									
									echo '/>'.$term_name.'</label><br />';

								}
						}
					else
						{
							echo 'Please select team group first from <b>Content(tab) > Filter Member > Display from Member Group</b>.';
						}
					
					?>
                  

				</div>                
                
                
                
            </li>          
            
            <li style="display: none;" class="box5 tab-box">
				<div class="option-box">
                    <p class="option-title"><?php _e('Custom CSS for this Team Grid.','team'); ?></p>
                    <p class="option-info">Do not use &lt;style>&lt;/style> tag, you can use bellow prefix to your css, sometime you need use "!important" to overrid.
                    <br/>
                    <b>#team-<?php echo $team_id ; ?></b>
                    </p>
                   	<?php
                    
					$empty_css_sample = '.team-container #team-'.$team_id.'{}\n.team-container #team-'.$team_id.' .team-item{}\n.team-container #team-'.$team_id.' .team-thumb{}\n.team-container #team-'.$team_id.' .team-title{}\n.team-container #team-'.$team_id.' .team-content{}';
					
					
					?>

                    <textarea style="width:80%; min-height:150px" name="team_items_custom_css"><?php if(!empty($team_items_custom_css)) echo htmlentities($team_items_custom_css); else echo str_replace('\n', PHP_EOL, $empty_css_sample); ?></textarea>
                    
				</div>
            
            
            </li>
            
		</ul><!-- box end -->
        
    </div> <!-- para-settings end -->

<script>
jQuery(document).ready(function($)
	{
		
		
<?php

        $team_license_key = get_option('team_license_key');
        
        if(empty($team_license_key))
            {
                echo '$("#team_metabox .para-settings").fadeOut();';
                echo '$("#team_metabox .inside").html("<b>Error:</b> Please activate your license.");';				
				
            }

?>
		
	});	
</script>





<?php

















	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_team_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_team_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_team_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_team_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
	$team_bg_img = sanitize_text_field( $_POST['team_bg_img'] );
	
	$team_themes = sanitize_text_field( $_POST['team_themes'] );
	$team_social_icon_style = sanitize_text_field( $_POST['team_social_icon_style'] );	
	$team_masonry_enable = sanitize_text_field( $_POST['team_masonry_enable'] );	
	
	$team_grid_item_align = sanitize_text_field( $_POST['team_grid_item_align'] );	
	$team_item_text_align = sanitize_text_field( $_POST['team_item_text_align'] );	
	$team_total_items = sanitize_text_field( $_POST['team_total_items'] );		
	$team_pagination_display = sanitize_text_field( $_POST['team_pagination_display'] );

	$team_items_content = sanitize_text_field( $_POST['team_items_content'] );
	$team_items_excerpt_count = sanitize_text_field( $_POST['team_items_excerpt_count'] );	
	$team_items_excerpt_text = sanitize_text_field( $_POST['team_items_excerpt_text'] );	
	
	$team_query_order = sanitize_text_field( $_POST['team_query_order'] );	
	$team_query_orderby = sanitize_text_field( $_POST['team_query_orderby'] );		
	
	$team_content_source = sanitize_text_field( $_POST['team_content_source'] );
	$team_content_year = sanitize_text_field( $_POST['team_content_year'] );
	$team_content_month = sanitize_text_field( $_POST['team_content_month'] );
	$team_content_month_year = sanitize_text_field( $_POST['team_content_month_year'] );
		
	if(empty($_POST['team_taxonomy_category']))
		{
			$_POST['team_taxonomy_category'] = '';
		}
		
	$team_taxonomy_category = stripslashes_deep( $_POST['team_taxonomy_category'] );
	
	if(empty($_POST['team_post_ids']))
		{
			$_POST['team_post_ids'] = '';
		}
		
	$team_post_ids = stripslashes_deep( $_POST['team_post_ids'] );	

	
	$team_items_title_color = sanitize_text_field( $_POST['team_items_title_color'] );	
	$team_items_title_font_size = sanitize_text_field( $_POST['team_items_title_font_size'] );	

	$team_items_position_color = sanitize_text_field( $_POST['team_items_position_color'] );
	$team_items_position_font_size = sanitize_text_field( $_POST['team_items_position_font_size'] );	

	$team_items_content_color = sanitize_text_field( $_POST['team_items_content_color'] );	
	$team_items_content_font_size = sanitize_text_field( $_POST['team_items_content_font_size'] );	
	

	$team_items_thumb_size = sanitize_text_field( $_POST['team_items_thumb_size'] );
	$team_items_link_to_post = sanitize_text_field( $_POST['team_items_link_to_post'] );	
	$team_items_max_width = sanitize_text_field( $_POST['team_items_max_width'] );
	$team_items_width_mobile = sanitize_text_field( $_POST['team_items_width_mobile'] );	
	$team_items_thumb_max_hieght = sanitize_text_field( $_POST['team_items_thumb_max_hieght'] );	
	
	$team_items_margin = sanitize_text_field( $_POST['team_items_margin'] );	
	$team_items_social_icon_width = sanitize_text_field( $_POST['team_items_social_icon_width'] );	
	$team_items_social_icon_height = sanitize_text_field( $_POST['team_items_social_icon_height'] );
				
	$team_items_custom_css = sanitize_text_field( $_POST['team_items_custom_css'] );
	
	
	$team_items_popup_content = sanitize_text_field( $_POST['team_items_popup_content'] );
	$team_items_popup_excerpt_count = sanitize_text_field( $_POST['team_items_popup_excerpt_count'] );
	$team_items_popup_excerpt_text = sanitize_text_field( $_POST['team_items_popup_excerpt_text'] );

	$team_items_post_per_page_mixitup = sanitize_text_field( $_POST['team_items_post_per_page_mixitup'] );
	$team_items_default_filter_mixitup = sanitize_text_field( $_POST['team_items_default_filter_mixitup'] );






  // Update the meta field in the database.
	update_post_meta( $post_id, 'team_bg_img', $team_bg_img );
	
	update_post_meta( $post_id, 'team_themes', $team_themes );
	update_post_meta( $post_id, 'team_social_icon_style', $team_social_icon_style );	
	update_post_meta( $post_id, 'team_masonry_enable', $team_masonry_enable );	
	
	update_post_meta( $post_id, 'team_grid_item_align', $team_grid_item_align );	
	update_post_meta( $post_id, 'team_item_text_align', $team_item_text_align );	
	update_post_meta( $post_id, 'team_total_items', $team_total_items );	
	update_post_meta( $post_id, 'team_pagination_display', $team_pagination_display );

	update_post_meta( $post_id, 'team_query_order', $team_query_order );
	update_post_meta( $post_id, 'team_query_orderby', $team_query_orderby );

	update_post_meta( $post_id, 'team_items_content', $team_items_content );
	update_post_meta( $post_id, 'team_items_excerpt_count', $team_items_excerpt_count );	
	update_post_meta( $post_id, 'team_items_excerpt_text', $team_items_excerpt_text );	

	update_post_meta( $post_id, 'team_content_source', $team_content_source );
	update_post_meta( $post_id, 'team_content_year', $team_content_year );
	update_post_meta( $post_id, 'team_content_month', $team_content_month );
	update_post_meta( $post_id, 'team_content_month_year', $team_content_month_year );	


	update_post_meta( $post_id, 'team_taxonomy_category', $team_taxonomy_category );

	update_post_meta( $post_id, 'team_post_ids', $team_post_ids );	



	update_post_meta( $post_id, 'team_items_title_color', $team_items_title_color );
	update_post_meta( $post_id, 'team_items_title_font_size', $team_items_title_font_size );

	update_post_meta( $post_id, 'team_items_position_color', $team_items_position_color );
	update_post_meta( $post_id, 'team_items_position_font_size', $team_items_position_font_size );	

	update_post_meta( $post_id, 'team_items_content_color', $team_items_content_color );
	update_post_meta( $post_id, 'team_items_content_font_size', $team_items_content_font_size );


	update_post_meta( $post_id, 'team_items_thumb_size', $team_items_thumb_size );
	update_post_meta( $post_id, 'team_items_link_to_post', $team_items_link_to_post );	
	update_post_meta( $post_id, 'team_items_max_width', $team_items_max_width );
	update_post_meta( $post_id, 'team_items_width_mobile', $team_items_width_mobile );	
	update_post_meta( $post_id, 'team_items_thumb_max_hieght', $team_items_thumb_max_hieght );
	
	update_post_meta( $post_id, 'team_items_margin', $team_items_margin );
	update_post_meta( $post_id, 'team_items_social_icon_width', $team_items_social_icon_width );	
	update_post_meta( $post_id, 'team_items_social_icon_height', $team_items_social_icon_height );
	
	update_post_meta( $post_id, 'team_items_custom_css', $team_items_custom_css );
	
	
	update_post_meta( $post_id, 'team_items_popup_content', $team_items_popup_content );	
	update_post_meta( $post_id, 'team_items_popup_excerpt_count', $team_items_popup_excerpt_count );	
	update_post_meta( $post_id, 'team_items_popup_excerpt_text', $team_items_popup_excerpt_text );	
	
	update_post_meta( $post_id, 'team_items_post_per_page_mixitup', $team_items_post_per_page_mixitup );	
	update_post_meta( $post_id, 'team_items_default_filter_mixitup', $team_items_default_filter_mixitup );		

	
	
	
}
add_action( 'save_post', 'meta_boxes_team_save' );


























?>