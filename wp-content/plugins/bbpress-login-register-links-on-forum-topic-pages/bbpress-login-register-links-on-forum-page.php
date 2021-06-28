<?php
/**
 * Plugin Name: bbPress Login Register Links On Forum Topic Pages
 * Plugin URI:  https://www.bbp.design/product/bbpress-login-register-pro-single-site/
 * Description: Add bbpress login link, register links, on forum pages or topic pages so users can use our forums more easier. Any feature request is welcome at our <a href='http://tomas.zhu.bz/forums/forum/bbpress-notification-plugin-support/'>Support Forum</a>, like our plugin? <a href='https://wordpress.org/support/view/plugin-reviews/bbpress-login-register-links-on-forum-topic-pages/'>Submit a review</a>
 * Author:      https://bbp.design
 * Author URI:  https://bbp.design
 * Version:     3.0.5
 * Text Domain: tomas-bbpress-custom
 * Domain Path: /languages
 * License: GPLv3 or later
   */
if (!defined('ABSPATH'))
{
	exit;
}

add_action('plugins_loaded','tomas_load_bbpress_login_url_textdomain');

require_once("includes/bbpress-sidebar.php");

function tomas_load_bbpress_login_url_textdomain()
{
	load_plugin_textdomain('tomas-bbpress-custom', false, dirname( plugin_basename( __FILE__ ) ).'/languages/');
}

//!!!start
function bbpressProMenuPanel()
{
	add_menu_page(__('bbPress Custom', 'tomas-bbpress-custom'), __('bbPress Custom', 'tomas-bbpress-custom'), 'manage_options', 'bbPressCustom', 'tomas_bbPressCustomLoginRedirect');
	add_submenu_page('bbPressCustom', __('Global Settings','tomas-bbpress-custom'), __('Global Settings','tomas-bbpress-custom'), 'manage_options', 'bbPressCustom', 'tomas_bbPressCustomLoginRedirect');
	add_submenu_page('bbPressCustom', __('Login Admin Bar','tomas-bbpress-custom'), __('Login Admin Bar','tomas-bbpress-custom'), 'manage_options', 'bbploginbarsettings', 'tomas_bbPressLoginAdminBar');
	add_submenu_page('bbPressCustom', __('Custom Login Links','tomas-bbpress-custom'), __('Custom Login Links','tomas-bbpress-custom'), 'manage_options', 'bbplogincustomloginlinks', 'tomas_bbPressCustomLoginLinks');
	add_submenu_page('bbPressCustom', __('Style Customize','tomas-bbpress-custom'), __('Style Customize','tomas-bbpress-custom'), 'manage_options', 'bbPressCustomPage', 'bbPressCustomMenu');
}
//!!!end

add_action( 'admin_menu',  'bbpressProMenuPanel');

//!!!start
$tomas_bbpress_login_bar_disable_all_feature = get_option('tomas_bbpress_login_bar_disable_all_feature');

if ('YES' == $tomas_bbpress_login_bar_disable_all_feature)
{
	return;
}
//!!!end


function bbpressLoginRegisterLinksOnForumPage()
{

	echo '<div class="bbpressloginlinks">';
	$tomas_bbpress_custom_links_login = get_option('tomas_bbpress_custom_links_login');;
	
	$bbpress_logged_in_user_id = get_current_user_id();
	
	$tomas_trim_bbpress_custom_links_login = trim($tomas_bbpress_custom_links_login);
	$bbpress_login_redirect_free = get_option('bbpress_login_redirect_free');

	if (!(empty($tomas_trim_bbpress_custom_links_login)))
	{
		if ( !is_user_logged_in() )
		{
			$login_url = get_option('siteurl').'/'.$tomas_bbpress_custom_links_login;
			
			if ($bbpress_login_redirect_free == 'Yes')
			{
				$args['redirect_to'] = urlencode( get_permalink() );
				$login_url = add_query_arg($args, $login_url);				
			}

			
			echo "<a href='$login_url' class='bbpressloginurl'>".__('Log In','tomas-bbpress-custom').'</a> ';
		
			$register_url = get_option('siteurl').'/'.$tomas_bbpress_custom_links_login.'?action=register';
			echo " <a href='$register_url' class='bbpressregisterurl'>".__('Register','tomas-bbpress-custom') .'</a> ';
	
			$lost_password_url = get_option('siteurl').'/'.$tomas_bbpress_custom_links_login.'?action=lostpassword';
			echo " <a href='$lost_password_url' class='bbpresslostpasswordurl'>". __('Lost Password','tomas-bbpress-custom').'</a> ';
		}
		else
		{
			$logout_url = wp_logout_url( get_permalink() );
			//!!! old echo "<a href='$logout_url' class='bbpresslogouturl'>".__('Log Out','tomas-bbpress-custom') .'</a> ';
			echo "<a class='bbpresslogouturl' href='$logout_url' class='bbpresslogouturl'>".__('Log Out','tomas-bbpress-custom') .'</a> ';
		}
	}
	else
	{
		if ( !is_user_logged_in() )
		{
			$login_url = site_url( 'wp-login.php' );
			if ($bbpress_login_redirect_free == 'Yes')
			{
				$args['redirect_to'] = urlencode( get_permalink() );
				$login_url = add_query_arg($args, $login_url);				
			}

			
			echo "<a href='$login_url' class='bbpressloginurl'>".__('Log In','tomas-bbpress-custom').'</a> ';
		
			$register_url = site_url( 'wp-login.php?action=register' );
			echo " <a href='$register_url' class='bbpressregisterurl'>".__('Register','tomas-bbpress-custom') .'</a> ';
		
			$lost_password_url = site_url( 'wp-login.php?action=lostpassword' );
			echo " <a href='$lost_password_url' class='bbpresslostpasswordurl'>". __('Lost Password','tomas-bbpress-custom').'</a> ';
		}
		else
		{
			?>
			<a  class='bbpresscustomprofileurl' href="<?php bbp_user_profile_url($bbpress_logged_in_user_id); ?>" title="<?php bbp_displayed_user_field( 'display_name' ); ?>" rel="me">
				<?php echo __('Profile','tomas-bbpress-custom'); ?>
			</a>
			<?php 
			$logout_url = wp_logout_url( get_permalink() );
			echo "<a class='bbpresslogouturl' href='$logout_url' class='bbpresslogouturl'>".__('Log Out','tomas-bbpress-custom') .'</a> ';
		}		
	}
	echo '</div>'; // class of "bbpressloginlinks"
	
}

/*!!!old
function bbpressProMenuPanel()
{
	add_menu_page(__('bbPress Custom', 'tomas-bbpress-custom'), __('bbPress Custom', 'tomas-bbpress-custom'), 10, 'bbPressCustom', 'bbPressCustomMenu');
	add_submenu_page('bbPressCustom', __('bbPress Custom','tomas-bbpress-custom'), __('bbPress Custom','tomas-bbpress-custom'), 10, 'bbPressCustom', 'bbPressCustomMenu');
	add_submenu_page('bbPressCustom', __('Login Admin Bar','tomas-bbpress-custom'), __('Login Admin Bar','tomas-bbpress-custom'), 10, 'bbploginbarsettings', 'tomas_bbPressLoginAdminBar');
	add_submenu_page('bbPressCustom', __('Custom Login Links','tomas-bbpress-custom'), __('Custom Login Links','tomas-bbpress-custom'), 10, 'bbplogincustomloginlinks', 'tomas_bbPressCustomLoginLinks');
	add_submenu_page('bbPressCustom', __('Global Settings','tomas-bbpress-custom'), __('Global Settings','tomas-bbpress-custom'), 10, 'bbplogincustomloginredirect', 'tomas_bbPressCustomLoginRedirect');
}
!!!old*/




function bbPressCustomMenu()
{
	global $wpdb;

	if (isset($_POST['bpoptionsettinspanelsubmit']))
	{
		check_admin_referer( 'bpoptionsettinspanelsubmit_free_nonce' ); //!!!
		$bbpressCustomCSS = get_option('bbpresscustomcss');		
		if (isset($_POST['bbpresscustomcss']))
		{
			$bbpressCustomCSS = $wpdb->escape($_POST['bbpresscustomcss']);
			update_option('bbpresscustomcss',$bbpressCustomCSS);
		}
		else
		{
			delete_option('bbpresscustomcss');
		}

		$tomas_bbPressMessageString =  __( 'Your changes has been saved.', 'tomas-bbpress-custom' );
		tomas_bbPressCustomMessage($tomas_bbPressMessageString);
	}
	echo "<br />";
	?>

<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/bbpress-login-register-links-on-forum-topic-pages/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>bbPress Custom Settings:</div>
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body"  style="width:60%;">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:98%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'bbPress Style Settings Panel :', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="bpmoform" name="bpmoform" action="" method="POST">
										<table id="bpmotable" width="100%">
										
										<tr style="margin-top:30px;">
										<td width="100%" style="padding: 20px;">
										<?php 
										$bbpressCustomCSS = get_option('bbpresscustomcss');

										if (empty($bbpressCustomCSS))
										{
											/* old
										}
											$bbpressCustomCSS = 
'.bbpressloginlinks{float:right;padding-right:20px;}
.bbpressregisterurl{margin-left:20px;}
.bbpresslostpasswordurl{margin-left:20px;}';
											*/
$bbpressCustomCSS =
'.bbpressloginlinks{float:right;padding-right:20px;}
.bbpressregisterurl{margin-left:20px;}
.bbpresslostpasswordurl{margin-left:20px;}
.bbpresslogouturl{margin-left:20px;}';
										}
										
										if (!(empty($bbpressCustomCSS)))
										{
											
										}
										else
										{
											$bbpressCustomCSS = '';
										}
										?>
<textarea id="bbpress-custom-css-box" rows="30" name="bbpresscustomcss" style="width:95%;">
<?php echo $bbpressCustomCSS;?>
</textarea>
										<p><font color="Gray"><i>
										<?php 
											echo  __( 'Please enter your css codes in here', 'tomas-bbpress-custom' );
										?>
										</i></p>
										
								<p><font color="Gray"><i>
								<?php 
									echo  __( 'Need more guide? Check ', 'tomas-bbpress-custom' ). '<a href="https://www.bbp.design/forums/" target="_blank">' .__( 'support form for examples', 'tomas-bbpress-custom' ) . '</a>' ;
								?>
								</i></p>
								<p><font color="Gray"><i>
								<a class=""  target="_blank" href="https://paypal.me/sunpayment">
								<span>
								Buy me a coffee 								
								</span>
								</a>
								?
								<span style="margin-right:20px;">
								Thank you :)
								</span>
								</i></p>

										</td>
										</tr>
										</table>
										<br />
										<?php 
										wp_nonce_field('bpoptionsettinspanelsubmit_free_nonce'); //!!!
										?>
										<input type="submit" id="bpoptionsettinspanelsubmit" name="bpoptionsettinspanelsubmit" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<?php 
					echo tomas_bbpress_admin_sidebar_about();
					?>

					<div style='clear:both'></div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />

		
		
		<?php
}

function tomas_bbpress_admin_sidebar_about($place = '')
{
?>

					<div id="post-body"  style="width:40%; float:right;">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">

								<div class="postbox">
									<h3 class='hndle' style='padding: 20px 0px; !important'>
									<span>
									<?php 
											echo  __( 'bbPress Login Pro Features', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
									<div class="inside">
									<ul>
										<li>
										* <a class="" target="_blank" href="https://www.bbp.design/features/">Login and Logout Auto Dedirect Based on User Roles</a>
										<br /><i>For example, redirect to referer URL, or redirect to a certain URL which you enter in setitng panel for any different user roles.</i> 
										</li>
										<li>
											* <a class=""  target="_blank" href="https://www.bbp.design/features/">Brute Force Protection</a>
											<br /><i>Options to enable Google reCAPTCHA in bbPress Login Page, Registration Page, New Topic Form, New Reply Form</i> 
										</li>
										<li>								
											* <a class=""  target="_blank" href="https://www.bbp.design/features/">Anti Proxy Spammer Open Login / Register Page</a>
											<br /><i>In the current time, we have stopped 23 types of proxy spammer</i> 
										</li>
										<li>								
											* <a class=""  target="_blank" href="https://www.bbp.design/features/">Customize Logo of Login / Register Page</a>
											<br /><i>Customize login Logo image, logo title, logo URL...</i> 
										</li>
										<li>								
											* <a class=""  target="_blank" href="https://www.bbp.design/features/">Pretty Background images on Login / Register Page</a>
											<br /><i>12 preset pretty background image </i> 
										</li>										
										<li>								
											* <a class=""  target="_blank" href="https://www.bbp.design/shop/">Only $9, Lifetime Upgrades, Unlimited Download, Ticket Support</a>
										</li>
									</ul>
									</div>									
									
									</div>
								</div>
								
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px 0px; !important'>
									<span>
									<?php 
											echo  __( 'Other Plugins Maybe You Like', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
									<div class="inside">
										<ul>
										<li>
											* <a class="" target="_blank" href="https://www.bbp.design/product/bbpress-members-only-pro-single-site/">bbPress Members Only Membership Plugin</a></b>
											<p> Help you to make your bbPress site only viewable to logged in member users, based on user role.</p>
										</li>
										<li>
											* <a class="" target="_blank" href="https://www.bbp.design/product/bbpress-most-liked-topics-plugin/">bbPress Most Liked Topics Plugin</a></b>
											<p> The plugin add a like button to bbPress topics and replies, bbPress forum members can like topics and replies, When users View forum topic, he will find most liked replies at the top of the topic page, show most valuable replies to users is a good way to let users like and join in your forum</p>
										</li>
										<li>
											* <a class="" target="_blank" href="https://www.bbp.design/product/bbpress-woocommerce-payment-gateway-plugin/">bbPress WooCommerce Payment Gateway Plugin</a></b>
											<p> A bbPress plugin to integrate WooCommerce Payment Gateway to help webmaster charge money from users of bbPress forums.</p>
										</li>
										<li>
											* <a class="" target="_blank" href="https://www.bbp.design/product/bbpress-blacklist-whitelist-security-plugin-product/">bbPress Blacklist Plugin</a></b>
											<p> A bbPress plugin which allow you build a blacklist to prevent spammers register as your users..</p>
										</li>
										<li>
											* <a class="" target="_blank" href="https://www.bbp.design/product/bbpress-new-user-approve/">bbPress New User Approve</a></b>
											<p> When users register as members, they need awaiting administrator approve their account manually, at the same time when unapproved users try to login your site, they can not login your site and they will get a message that noticed they have to waiting for admin approve their access first</p>
										</li>
										<li>
											* <a class="" target="_blank" href="https://tooltips.org/wordpress-tooltip-plugin/wordpress-tooltips-demo/">WordPress Tooltip with bbPress Tooltip Addon</a></b>
											<p> WordPress tooltip pro is a tooltips plugin for wordpress, which be designed to help you create colorful, varied and graceful tooltip styles to present the content to your users, with lively and elegant animation effects, and save your valuable screen space.

When the users hover over an item, the colorful tooltip popup box will display with the animation effect. You can add video, audio, image, and even other content which generated by 3rd wordpress plugins like QR code, Amazon AD, Google Map in tooltip popup box via wordpress standard editor, it is very easy to use.</p>
										</li>										
										</ul>
									</div>									
									</div>
								</div>
																
								
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px 0px; !important'>
									<span>
									<?php 
											echo  __( 'bbPress Wordpress Tips Feed:', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
						<?php 
							wp_widget_rss_output('https://tomas.zhu.bz/feed/', array(
							'items' => 3, 
							'show_summary' => 0, 
							'show_author' => 0, 
							'show_date' => 1)
							);
						?>
										<br />
									</div>
								</div>
							</div>
						</div>
											
					</div>
<?php
}
function tomas_bbpress_custom_css(){
	$bbpressCustomCSS = get_option('bbpresscustomcss');
	
	if (empty($bbpressCustomCSS))
	{
		$bbpressCustomCSS =
		'.bbpressloginlinks{float:right;padding-right:20px;}
.bbpressregisterurl{margin-left:20px;}
.bbpresslostpasswordurl{margin-left:20px;}
.bbpresslogouturl{margin-left:20px;}';
	}
	?>
        <style type="text/css">
			<?php echo $bbpressCustomCSS;?>
		</style>
        <?php
	}

function tomas_bbPressCustomMessage($p_message)
{
	
		echo "<div id='message' class='updated fade' style='padding: 10px;'>";
	
		echo $p_message;
	
		echo "</div>";
	
}

function tomas_bbPressLoginAdminBar()
{

	if ((isset($_POST['tomas_bbpress_submit_admin_bar'])) && (!(empty($_POST['tomas_bbpress_submit_admin_bar']))))
	{
		check_admin_referer( 'tomas_bbpress_submit_admin_bar_free_nonce' );
		if ((isset($_POST['tomas_bbpress_login_admin_bar'])) && (!(empty($_POST['tomas_bbpress_login_admin_bar']))))
		{
			$tomas_bbpress_login_admin_bar = $_POST['tomas_bbpress_login_admin_bar'];
			update_option('bbpress_login_admin_bar',$tomas_bbpress_login_admin_bar);
			$tomas_bbpress_MessageString =  __( 'Your changes of "Login Admin Bar" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
	}

	$bbpress_login_admin_bar = get_option('bbpress_login_admin_bar');
	?>
 
<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/bbpress-login-register-links-on-forum-topic-pages/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>bbPress Login Top Admin Bar Settings:</div>
</div>
<div style='clear:both'></div>

		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body" style="width:60%;">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:98%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Disable Top Admin Bar for Non-Admin Logged-in Users : ', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_form" name="tomas_bbpress_form" action="" method="POST">
										<table id="tomas_bbpress_table" width="100%">
										<tr valign="top">
										<td scope="row"  width="40%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'Disable Top Admin Bar: ', 'tomas-bbpress-custom' );
										?>
										</td>
										
										<td width="60%" style="padding: 20px;">
										<select name = "tomas_bbpress_login_admin_bar" id = "tomas_bbpress_login_admin_bar">
										<?php 
											if ($bbpress_login_admin_bar == 'Yes')
											{
												?>
												<option selected = "selected" value="Yes">Yes</option>
												<?php 
											}
											else 
											{
												
										?>
												<option value="Yes">Yes</option>
										<?php 
											}
											if ($bbpress_login_admin_bar == 'No')
											{
												?>
												<option selected = "selected" value="No">No</option>
												<?php 
											}
											else 
											{											
										?>
												<option value="No">No</option>
										<?php 
											}
										?>
										</select>

										</td>
										</tr>
										
										</table>
										<br />
										<?php 
										wp_nonce_field('tomas_bbpress_submit_admin_bar_free_nonce'); //!!!
										?>
										<input type="submit" id="tomas_bbpress_submit_admin_bar" name="tomas_bbpress_submit_admin_bar" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
								<p><font color="Gray"><i>
								<?php 
									echo  __( 'Need more guide? Check ', 'tomas-bbpress-custom' ). '<a href="https://www.bbp.design/forums/" target="_blank">' .__( 'support form for examples', 'tomas-bbpress-custom' ) . '</a>' ;
								?>
								</i></p>
								<p><font color="Gray"><i>
								<a class=""  target="_blank" href="https://paypal.me/sunpayment">
								<span>
								Buy me a coffee 								
								</span>
								</a>
								?
								<span style="margin-right:20px;">
								Thank you :)
								</span>
								</i></p>										
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 
					tomas_bbpress_admin_sidebar_about();
					?>
		    	</div>
			</div> <!--   dashboard-widgets-wrap -->
		</div> <!--  wrap -->
		
		<div style="clear:both"></div>
		<br />		
<?php 	
}

function tomas_bbPressCustomLoginRedirect()
{
	global $wp_registered_sidebars; //!!!
	
	if ((isset($_POST['bbpress_login_redirect_free_submit'])) && (!(empty($_POST['bbpress_login_redirect_free_submit']))))
	{
		check_admin_referer( 'bbpress_login_redirect_free_submit_free_nonce' );
		if ((isset($_POST['tomas_bbpress_login_redirect'])) && (!(empty($_POST['tomas_bbpress_login_redirect']))))
		{
			$bbpress_login_redirect_free = $_POST['tomas_bbpress_login_redirect'];
			update_option('bbpress_login_redirect_free',$bbpress_login_redirect_free);
			$tomas_bbpress_MessageString =  __( 'Your changes of "bbPress Login Redirect" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
	}
	
	if ((isset($_POST['bbpress_login_enable_bbpress_sidebar_submit'])) && (!(empty($_POST['bbpress_login_enable_bbpress_sidebar_submit']))))
	{
		check_admin_referer( 'bbpress_login_enable_bbpress_sidebar_submit_free_nonce' );
		if ((isset($_POST['tomas_bbpress_only_sidebar'])) && (!(empty($_POST['tomas_bbpress_only_sidebar']))))
		{
			$bbpress_enable_bbpress_sidebar_free = $_POST['tomas_bbpress_only_sidebar'];
			update_option('bbpress_enable_bbpress_sidebar',$bbpress_enable_bbpress_sidebar_free);
			$tomas_bbpress_MessageString =  __( 'Your changes of "Enable bbPress Only Sidebar" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
	}
	
	if ((isset($_POST['bbpress_login_enable_bbpress_selected_sidebar_submit'])) && (!(empty($_POST['bbpress_login_enable_bbpress_selected_sidebar_submit']))))
	{
		if ((isset($_POST['tomas_bbpress_only_selected_sidebar'])) && (!(empty($_POST['tomas_bbpress_only_selected_sidebar']))))
		{
			$bbpress_selected_bbpress_sidebar_free = $_POST['tomas_bbpress_only_selected_sidebar'];
			update_option('tomas_bbpress_only_selected_sidebar',$bbpress_selected_bbpress_sidebar_free);
			$tomas_bbpress_MessageString =  __( 'Your changes of "Please select an existed sidebar to be replaced as bbpress sidebar" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
	}
	
	if ((isset($_POST['tomas_bbpress_login_bar_location_submit'])) && (!(empty($_POST['tomas_bbpress_login_bar_location_submit']))))
	{
		check_admin_referer( 'tomas_bbpress_login_bar_location_submit_free_nonce' ); //!!!
		if ((isset($_POST['tomas_bbpress_login_bar_location'])) && (!(empty($_POST['tomas_bbpress_login_bar_location']))))
		{
			$tomas_bbpress_login_bar_location_free = $_POST['tomas_bbpress_login_bar_location'];
			update_option('tomas_bbpress_login_bar_location',$tomas_bbpress_login_bar_location_free);
			$tomas_bbpress_MessageString =  __( 'Your changes of "Please select the location of the bbPress login bar" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
	}
	
	
	if ((isset($_POST['tomas_bbpress_login_bar_disable_all_feature_submit'])) && (!(empty($_POST['tomas_bbpress_login_bar_disable_all_feature_submit']))))
	{
		check_admin_referer( 'tomas_bbpress_login_bar_disable_all_feature_submit_free_nonce' ); 
		if ((isset($_POST['tomas_bbpress_login_bar_disable_all_feature'])) && (!(empty($_POST['tomas_bbpress_login_bar_disable_all_feature']))))
		{
			$tomas_bbpress_login_bar_disable_all_feature = $_POST['tomas_bbpress_login_bar_disable_all_feature'];
			update_option('tomas_bbpress_login_bar_disable_all_feature',$tomas_bbpress_login_bar_disable_all_feature);
			$tomas_bbpress_MessageString =  __( 'Your changes of "Temporarily Turn Off All Featrures:" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
	}
	
	$tomas_bbpress_login_bar_disable_all_feature = get_option('tomas_bbpress_login_bar_disable_all_feature');
	
	$bbpress_login_redirect_free = get_option('bbpress_login_redirect_free');
	$bbpress_enable_bbpress_sidebar_free = get_option('bbpress_enable_bbpress_sidebar');
	if (empty($bbpress_enable_bbpress_sidebar_free))
	{
		$bbpress_enable_bbpress_sidebar_free == 'Yes';
	}
	$bbpress_selected_bbpress_sidebar_free = get_option('tomas_bbpress_only_selected_sidebar');
	$tomas_bbpress_login_bar_location_free = get_option('tomas_bbpress_login_bar_location');
	?>
 
<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/bbpress-login-register-links-on-forum-topic-pages/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>bbPress Login Global Settings:</div>
</div>
<div style='clear:both'></div>

		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body" style="width:60%;">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:98%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Login redirected to the same topic page from where clicked the login link : ', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_form" name="tomas_bbpress_form" action="" method="POST">
										<table id="tomas_bbpress_table" width="100%">
										<tr valign="top">
										<td scope="row"  width="40%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'Enable Login redirect: ', 'tomas-bbpress-custom' );
										?>
										</td>
										
										<td width="60%" style="padding: 20px;">
										<select name = "tomas_bbpress_login_redirect" id = "tomas_bbpress_login_admin_bar">
										<?php 
											if ($bbpress_login_redirect_free == 'Yes')
											{
												?>
												<option selected = "selected" value="Yes">Yes</option>
												<?php 
											}
											else 
											{
												
										?>
												<option value="Yes">Yes</option>
										<?php 
											}
											if ($bbpress_login_redirect_free == 'No')
											{
												?>
												<option selected = "selected" value="No">No</option>
												<?php 
											}
											else 
											{											
										?>
												<option value="No">No</option>
										<?php 
											}
										?>
										</select>

										</td>
										</tr>
										
										</table>
										<br />
										<?php 
										//!!!
										wp_nonce_field('bbpress_login_redirect_free_submit_free_nonce');
										?>
										<input type="submit" id="bbpress_login_redirect_free_submit" name="bbpress_login_redirect_free_submit" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
									</div>
								</div>
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Enable bbPress only sidebar to allow admin to add widgets for bbPress topics and replies', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_form" name="tomas_bbpress_form" action="" method="POST">
										<table id="tomas_bbpress_table" width="100%">
										<tr valign="top">
										<td scope="row"  width="40%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'bbPress Only Sidebar? ', 'tomas-bbpress-custom' );
										?>
										</td>
										
										<td width="60%" style="padding: 20px;">
										<select name = "tomas_bbpress_only_sidebar" id = "tomas_bbpress_login_admin_bar">
										<?php 
											if ($bbpress_enable_bbpress_sidebar_free == 'Yes')
											{
												?>
												<option selected = "selected" value="Yes">Yes</option>
												<?php 
											}
											else 
											{
												
										?>
												<option value="Yes">Yes</option>
										<?php 
											}
											if ($bbpress_enable_bbpress_sidebar_free == 'No')
											{
												?>
												<option selected = "selected" value="No">No</option>
												<?php 
											}
											else 
											{											
										?>
												<option value="No">No</option>
										<?php 
											}
										?>
										</select>

										</td>
										</tr>
										
										</table>
										<br />
										<?php 
										//!!!
										wp_nonce_field('bbpress_login_enable_bbpress_sidebar_submit_free_nonce');
										?>
										<input type="submit" id="bbpress_login_enable_bbpress_sidebar_submit" name="bbpress_login_enable_bbpress_sidebar_submit" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
									</div>
								</div>
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Please select an existed sidebar to be replaced as bbpress sidebar', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_form" name="tomas_bbpress_form" action="" method="POST">
										<table id="tomas_bbpress_table" width="100%">
										<tr valign="top">
										<td scope="row"  width="40%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'Which sidebar will be replaced as bbpress sidebar? ', 'tomas-bbpress-custom' );
										?>
										</td>
										<td width="60%" style="padding: 20px;">
										<select name = "tomas_bbpress_only_selected_sidebar" id = "tomas_bbpress_only_selected_sidebar">
										<?php 
											if ((isset($wp_registered_sidebars)) && (is_array($wp_registered_sidebars)) && (count($wp_registered_sidebars) >0))
											{
												foreach ($wp_registered_sidebars as $sidebarid => $sidebarattribute)
												{
													if ('bbpress-sidebar' == $sidebarattribute['id'])
													{
														continue;
													}
													
													if ($bbpress_selected_bbpress_sidebar_free == $sidebarattribute['id'])
													{
														?>
														<option selected = "selected"  value="<?php echo $sidebarattribute['id']; ?>"><?php echo $sidebarattribute['name']; ?></option>
														<?php
													}
													else 
													{
													?>
														<option value="<?php echo $sidebarattribute['id']; ?>"><?php echo $sidebarattribute['name']; ?></option>
													<?php
													}
												}
											}
										?>
										</select>
										</td>
										</tr>
										</table>
										<br />
										<input type="submit" id="bbpress_login_enable_bbpress_selected_sidebar_submit" name="bbpress_login_enable_bbpress_selected_sidebar_submit" value=" Submit " style="margin:1px 20px;">
										</form>
										<br />
									</div>
								</div>
<?php //!!!start ?>								
									<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Please select the location of the bbPress login bar', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_form" name="tomas_bbpress_form" action="" method="POST">
										<table id="tomas_bbpress_table" width="100%">
										<tr valign="top">
										<td scope="row"  width="40%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'bbPress login bar location:', 'tomas-bbpress-custom' );
										?>
										</td>
										<td width="60%" style="padding: 20px;">
										<select name = "tomas_bbpress_login_bar_location" id = "tomas_bbpress_login_bar_location">
										<?php 
											$tomas_bbpress_login_bar_location_free = get_option('tomas_bbpress_login_bar_location');
											if ($tomas_bbpress_login_bar_location_free == 'beforeandafter')
											{
												?>
												<option selected = "selected" value="beforeandafter">Before bbPress forum and after bbPress forum</option>
												<?php 
											}
											else 
											{
												
										?>
												<option value="beforeandafter">Before bbPress forum and after bbPress forum</option>
										<?php 
											}
											if ($tomas_bbpress_login_bar_location_free == 'before')
											{
												?>
												<option selected = "selected" value="before">Before bbPress forum</option>
												<?php 
											}
											else 
											{											
										?>
												<option value="before">Before bbPress forum</option>
										<?php 
											}
										?>
										<?php 
											if ($tomas_bbpress_login_bar_location_free == 'after')
											{
												?>
												<option selected = "selected" value="after">After bbPress forum</option>
												<?php 
											}
											else 
											{											
										?>
												<option value="after">After bbPress forum</option>
										<?php 
											}
										?>
										</select>
										</td>
										</tr>
										</table>
										<br />
										<?php 
										//!!!
										wp_nonce_field('tomas_bbpress_login_bar_location_submit_free_nonce');
										?>
										<input type="submit" id="tomas_bbpress_login_bar_location_submit" name="tomas_bbpress_login_bar_location_submit" value=" Submit " style="margin:1px 20px;">
										</form>
										<br />
									</div>
								</div>
<?php //!!! start ?>
									<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Temporarily Turn off All Featrures:', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_form" name="tomas_bbpress_form" action="" method="POST">
										<table id="tomas_bbpress_table" width="100%">
										<tr valign="top">
										<td scope="row"  width="40%" style="padding: 20px; text-align:left;">
										<?php 
											echo  __( 'Temporarily Turn Off All Featrures:', 'tomas-bbpress-custom' );
										?>
										</td>
										<td width="60%" style="padding: 20px;">
										<select name = "tomas_bbpress_login_bar_disable_all_feature" id = "tomas_bbpress_login_bar_disable_all_feature">
										<?php 
											$tomas_bbpress_login_bar_disable_all_feature = get_option('tomas_bbpress_login_bar_disable_all_feature');
											if ($tomas_bbpress_login_bar_disable_all_feature == 'YES')
											{
												?>
												<option selected = "selected" value="YES">Yes, disable all features now</option>
												<?php 
											}
											else 
											{
												
										?>
												<option value="YES">Yes, disable all features now</option>
										<?php 
											}
											if ($tomas_bbpress_login_bar_disable_all_feature == 'NO')
											{
												?>
												<option selected = "selected" value="NO">NO</option>
												<?php 
											}
											else 
											{											
										?>
												<option value="NO">NO</option>
										<?php 
											}
										?>
										</select>
										</td>
										</tr>
										</table>
										<br />
										<?php 
										//!!!
										wp_nonce_field('tomas_bbpress_login_bar_disable_all_feature_submit_free_nonce');
										?>
										<input type="submit" id="tomas_bbpress_login_bar_disable_all_feature_submit" name="tomas_bbpress_login_bar_disable_all_feature_submit" value=" Submit " style="margin:1px 20px;">
										</form>
										<br />
									</div>
								</div>
<?php //!!!end ?>								
								<p><font color="Gray"><i>
								<?php 
									echo  __( 'Need more guide? Check ', 'tomas-bbpress-custom' ). '<a href="https://www.bbp.design/forums/" target="_blank">' .__( 'support form for examples', 'tomas-bbpress-custom' ) . '</a>' ;
								?>
								</i></p>
								<p><font color="Gray"><i>
								<a class=""  target="_blank" href="https://paypal.me/sunpayment">
								<span>
								Buy me a coffee 								
								</span>
								</a>
								?
								<span style="margin-right:20px;">
								Thank you :)
								</span>
								</i></p>

							</div>
						</div>
					</div>
					<?php 
					tomas_bbpress_admin_sidebar_about();
					?>
		    	</div>
			</div> <!--   dashboard-widgets-wrap -->
		</div> <!--  wrap -->
		
		<div style="clear:both"></div>
		<br />		
<?php 	
}


function tomas_bbPressCustomLoginLinks()
{

	
	if ((isset($_POST['tomas_bbpress_custom_links_form_submit'])) && (!(empty($_POST['tomas_bbpress_custom_links_form_submit']))))
	{
		check_admin_referer( 'tomas_bbpress_custom_links_form_submit_free_nonce' ); //!!!
		if ((isset($_POST['tomas_bbpress_custom_links_login'])) && (!(empty($_POST['tomas_bbpress_custom_links_login']))))
		{
			//!!! $tomas_bbpress_custom_links_login = $_POST['tomas_bbpress_custom_links_login'];
			
			$tomas_bbpress_custom_links_login = sanitize_text_field($_POST['tomas_bbpress_custom_links_login']);
			//if (!(empty(trim($tomas_bbpress_custom_links_login))))
			$tomas_trim_bbpress_custom_links_login = trim($tomas_bbpress_custom_links_login);
			if (!(empty($tomas_trim_bbpress_custom_links_login)))
			{
				update_option('tomas_bbpress_custom_links_login',$tomas_bbpress_custom_links_login);
				add_rewrite_rule( $tomas_bbpress_custom_links_login.'/?$', 'wp-login.php', 'top' );
				flush_rewrite_rules();
			}
			$tomas_bbpress_MessageString =  __( 'Your changes of "Custom Login Links" has been saved.', 'tomas-bbpress-custom' );
			tomas_bbPressCustomMessage($tomas_bbpress_MessageString);
		}
		else
		{
			delete_option('tomas_bbpress_custom_links_login');
			flush_rewrite_rules();
		}
	}

	$tomas_bbpress_custom_links_login = get_option('tomas_bbpress_custom_links_login');
	?>
 
<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/bbpress-login-register-links-on-forum-topic-pages/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>bbPress Custom Login Links Settings:</div>
</div>
<div style='clear:both'></div>

		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body" style="width:60%;">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:98%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'bbPress Custom Login Links Settings : ', 'tomas-bbpress-custom' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="tomas_bbpress_custom_links_form" name="tomas_bbpress_custom_links_form" action="" method="POST">
										<table id="tomas_bbpress_custom_links_form_table" width="100%">
										<tr>
										<td width="30%" style="padding: 20px;">
										<?php 
											echo  __( 'Login URL:', 'tomas-bbpress-custom' );
										?>
										</td>
										<td width="70%" style="padding: 20px;text-align:left;">
										<span><font color='gray'><?php echo get_option('siteurl').'/'; ?></font></span> <input type="text" id="tomas_bbpress_custom_links_login" name="tomas_bbpress_custom_links_login" size='10' value="<?php  echo $tomas_bbpress_custom_links_login; ?>"> <font color='gray'>/</font>
										</td>
										</tr>
										
					
										
										
										</table>
										<br />
										<?php
										//!!!
										wp_nonce_field('tomas_bbpress_custom_links_form_submit_free_nonce');
										?>

										<input type="submit" id="tomas_bbpress_custom_links_form_submit" name="tomas_bbpress_custom_links_form_submit" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
								<p><font color="Gray"><i>
								<?php 
									echo  __( 'Need more guide? Check ', 'tomas-bbpress-custom' ). '<a href="https://www.bbp.design/forums/" target="_blank">' .__( 'support form for examples', 'tomas-bbpress-custom' ) . '</a>' ;
								?>
								</i></p>
								<p><font color="Gray"><i>
								<a class=""  target="_blank" href="https://paypal.me/sunpayment">
								<span>
								Buy me a coffee 								
								</span>
								</a>
								?
								<span style="margin-right:20px;">
								Thank you :)
								</span>
								</i></p>										
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 
					tomas_bbpress_admin_sidebar_about();
					?>
		    	</div>
			</div> <!--   dashboard-widgets-wrap -->
		</div> <!--  wrap -->
		
		<div style="clear:both"></div>
		<br />		
<?php 	
}


add_filter('plugin_action_links', 'tomas_bbPress_login_settings_link', 10, 2);
function tomas_bbPress_login_settings_link($links, $file) 
{
	$tomas_bbPress_login_file = plugin_basename(__FILE__);

	if ($file == $tomas_bbPress_login_file) 
	{
		$settings_link = '<i><a href="https://bbp.design/">Features of Pro Version</a></i>';
		array_unshift($links, $settings_link);
		$settings_link = '<a href="' . admin_url( 'admin.php?page=bbPressCustom' ) . '">' .__( 'Settings', 'tomas-bbpress-custom' ) . '</a>';
		array_unshift( $links, $settings_link );		
	}
	return $links;
}

add_action( 'init', 'tomas_bbPress_custom_Links_rewrite' );
function tomas_bbPress_custom_Links_rewrite() 
{
	$bbpress_login_admin_bar = get_option('bbpress_login_admin_bar');
	$bbpress_trim_login_admin_bar = trim($bbpress_login_admin_bar);
	if (!(empty($bbpress_trim_login_admin_bar)))
	{
		add_rewrite_rule( $bbpress_login_admin_bar.'/?$', 'wp-login.php', 'top' );
	}
}


//!!!start
$tomas_bbpress_login_bar_location_free = get_option('tomas_bbpress_login_bar_location');

if (empty($tomas_bbpress_login_bar_location_free))
{
	$tomas_bbpress_login_bar_location_free = 'beforeandafter';
}

if ($tomas_bbpress_login_bar_location_free == 'beforeandafter')
{
	add_action('bbp_template_after_forums_loop','bbpressLoginRegisterLinksOnForumPage');
	add_action('bbp_template_before_pagination_loop','bbpressLoginRegisterLinksOnForumPage');
	add_action('bbp_template_before_forums_loop','bbpressLoginRegisterLinksOnForumPage');
}

if ($tomas_bbpress_login_bar_location_free == 'before')
{
	add_action('bbp_template_before_forums_loop','bbpressLoginRegisterLinksOnForumPage');
	add_action('bbp_template_before_single_forum','bbpressLoginRegisterLinksOnForumPage');
	add_action('bbp_template_before_single_topic', 'bbpressLoginRegisterLinksOnForumPage');
}

if ($tomas_bbpress_login_bar_location_free == 'after')
{
	add_action('bbp_template_after_forums_loop','bbpressLoginRegisterLinksOnForumPage');
	add_action('bbp_template_after_single_forum','bbpressLoginRegisterLinksOnForumPage');
	add_action('bbp_template_after_single_topic', 'bbpressLoginRegisterLinksOnForumPage');
}
//!!!end


add_action('wp_head','tomas_bbpress_custom_css');

/* //!!!old
add_action('bbp_template_after_forums_loop','bbpressLoginRegisterLinksOnForumPage'); 
add_action('bbp_template_before_pagination_loop','bbpressLoginRegisterLinksOnForumPage'); 
add_action('bbp_template_after_single_forum','bbpressLoginRegisterLinksOnForumPage'); 
add_action('bbp_template_before_forums_loop','bbpressLoginRegisterLinksOnForumPage');
*/



//!!! 3.0.5
function bbploginuser_first_run_guide_bar()
{
	$is_user_first_run_guide_bar = get_option('bbploginuser_first_run_guide_bar');
	if (empty($is_user_first_run_guide_bar))
	{
		echo "<div class='notice bbplogi-notice notice-info'><p>Thanks for installing <strong>bbPress Login</strong>! Please check <a href='" . admin_url() . "?page=bbPressCustom' target='_blank'>Global Settings Panel</a>, Any question or feature request please contact <a href='https://bbp.design/contact-us/'  target='_blank'>Support</a> :)</p></div>";
		update_option('bbploginuser_first_run_guide_bar','yes');
	}
}

add_action( 'admin_notices', 'bbploginuser_first_run_guide_bar' );
