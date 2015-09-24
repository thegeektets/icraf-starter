<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		
			$html.= '<div class="team-social '.$team_social_icon_style.'" >';
			
			
			$team_member_social_field = get_option( 'team_member_social_field' );
			
			if(empty($team_member_social_field))
				{
					$team_member_social_field = array("skype"=>"skype","email"=>"email","website"=>"website", "facebook"=>"facebook","twitter"=>"twitter","googleplus"=>"googleplus","pinterest"=>"pinterest");
					
				}
			
			$html_social = '';
			
            foreach ($team_member_social_field as $value) {
                if(!empty($value) && !empty($team_member_social_links[$value]))
                    {
						
						if(!empty($team_member_social_icon[$value]))
							{
							$icon_bg = 'style="background-image:url('.$team_member_social_icon[$value].')"';
							}
						else
							{
							$icon_bg = '';
							}
						
						
					
					
					if($value == 'website')
						{
							$html_social.= '<span '.$icon_bg.' class="website">
								<a target="_blank" href="'.$team_member_social_links[$value].'"></a>
							</span>';
						}
					elseif($value == 'email')
						{
							$html_social.= '<span '.$icon_bg.' class="email">
								<a href="mailto:'.$team_member_social_links[$value].'"></a>
							</span>';
						}
						
					elseif($value == 'skype')
						{
							$html_social.= '<span '.$icon_bg.' class="skype">
								<a  title="'.$value.'" href="skype:'.$team_member_social_links[$value].'"></a>
							</span>';
						}
						
					elseif($value == 'mobile')
						{
							$html_social.= '<span '.$icon_bg.' class="mobile">
								<a  title="'.$value.'" href="tel:'.$team_member_social_links[$value].'"></a>
							</span>';
						}
						
						
					elseif($value == 'phone')
						{
							$html_social.= '<span '.$icon_bg.' class="mobile">
								<a  title="'.$value.'" href="tel:'.$team_member_social_links[$value].'"></a>
							</span>';
						}						
											
						
					else
						{
							$html_social.= '<span '.$icon_bg.' class="'.$value.'" >
								<a target="_blank" href="'.$team_member_social_links[$value].'"> </a>
							</span>';
						}					
						

                    
                    }
            }

			$html .= apply_filters( 'team_grid_filter_social', $html_social );

			$html.= '</div>';
			