<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

			
			$html.= '<div class="team-content" style="color:'.$team_items_content_color.';font-size:'.$team_items_content_font_size.';">';

			$content = apply_filters( 'team_grid_filter_content', apply_filters('the_content', get_the_content()) );		
			
			
			if($team_items_content=='full')
				{
					$html.= $content;
				}
			elseif($team_items_content=='excerpt')
				{

				if($team_items_link_to_post == 'yes')
					{
						$html.= wp_trim_words( $content , $team_items_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more"  href="'. get_permalink() .'">'.$team_items_excerpt_text.'</a>' );	
					}
	
				else
					{
						$html.= wp_trim_words( $content , $team_items_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more" href="'. get_permalink() .'">'.$team_items_excerpt_text.'</a>' );
					}					
					
					

				}			
			$html.= '</div>';
	

