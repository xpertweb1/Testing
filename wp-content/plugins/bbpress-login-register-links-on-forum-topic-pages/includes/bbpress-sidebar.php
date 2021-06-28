<?php
if (!defined('ABSPATH'))
{
	exit;
}

$bbpress_enable_bbpress_sidebar_free = get_option('bbpress_enable_bbpress_sidebar');
{
	$bbpress_enable_bbpress_sidebar_free == 'Yes';
}

if ($bbpress_enable_bbpress_sidebar_free == 'No')
{
	return;
}


add_action( 'widgets_init', 'bbpressLoginRegisterLinksRegisterbbPressSidebars', 30 );

function bbpressLoginRegisterLinksRegisterbbPressSidebars()
{
	if ( function_exists('register_sidebar') )
	{
		register_sidebar(
			array(
				'name'              => __('bbPress Sidebar', 'tomas-bbpress-custom'), 
				'id'                => 'bbpress-sidebar',
				'description'  		=> __( 'Widgets in this area will be shown on the bbPress Page.', 'tomas-bbpress-custom' ),
				'before_title' 		=> '<h3 class="bbpress-login-widget-title">',
				'after_title'  		=> '</h3>',
				'before_widget' 	=> '<div class="bbpress-login-widget-content">',
				'after_widget' 		=>'</div>'
			)
		);
	}
}

add_filter('sidebars_widgets', 'bbpressLoginRegisterLinksSidebarsWidgets');
function bbpressLoginRegisterLinksSidebarsWidgets( $sidebars_widgets ) 
{
	global $wp_registered_sidebars;

	$bbpress_selected_bbpress_sidebar_free = get_option('tomas_bbpress_only_selected_sidebar');
	
	if (function_exists('is_bbpress'))
	{
		if (is_bbpress())
		{
			if ((is_array($wp_registered_sidebars)) && count($wp_registered_sidebars) > 0)
			{
				$bbpress_sidebars_array_keys = array_keys($wp_registered_sidebars);
				if ((is_array($bbpress_sidebars_array_keys)) && count($bbpress_sidebars_array_keys) > 0)
				{
					//!!!start
					if (!(empty($bbpress_selected_bbpress_sidebar_free)))
					{
						$bbpress_login_sidebars_key =  $bbpress_selected_bbpress_sidebar_free;
					}
					else 
					{
						$bbpress_login_sidebars_key =  $bbpress_sidebars_array_keys[0];
					}
					//!!!end
					//!!! $bbpress_login_sidebars_key =  $bbpress_sidebars_array_keys[0];
					if (!(empty($bbpress_login_sidebars_key)))
					{
						if (isset($sidebars_widgets[$bbpress_login_sidebars_key]))
						{
							$sidebars_widgets[$bbpress_login_sidebars_key] = $sidebars_widgets['bbpress-sidebar'];
							return $sidebars_widgets;
						}
						else
						{
							return $sidebars_widgets;
						}
					}
					else
					{
						return $sidebars_widgets;
					}
				}
				else
				{
					return $sidebars_widgets;
				}
					
				
			}
		}
		else 
		{
			return $sidebars_widgets;
		}
	}
	else 
	{
		return $sidebars_widgets;
	}

	return $sidebars_widgets;

}



		