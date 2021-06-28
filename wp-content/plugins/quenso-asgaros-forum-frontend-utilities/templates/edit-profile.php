			<div id="affu-edit-profile" style="display:none">
				<div id="edit-profile">						
					<form id="affu_profile_editor" class="affu_profile_form" action="<?php echo home_url($wp->request) ?>" method="post" enctype="multipart/form-data">
					
						<fieldset id="affu_profile_personal_fieldset">								
							<legend id="affu_profile_personal_label"><?php _e('Personal', 'af-front-utils'); ?></legend>									
							<p id="affu_profile_first_name_wrap">
								<label for="affu_first_name"><?php _e('First Name:', 'af-front-utils'); ?></label>
								<input name="affu_first_name" id="affu_first_name" class="text affu-input" type="text" value="<?php echo esc_attr($first_name); ?>" />
							</p>									
							<p id="affu_profile_last_name_wrap">
								<label for="affu_last_name"><?php _e('Last Name:', 'af-front-utils'); ?></label>
								<input name="affu_last_name" id="affu_last_name" class="text affu-input" type="text" value="<?php echo esc_attr($last_name); ?>" />
							</p>									
							<p id="affu_profile_nickname_wrap">
								<label for="affu_nickname"><?php _e('Nickname:', 'af-front-utils'); ?></label>
								<input name="affu_nickname" id="affu_nickname" class="text affu-input" type="text" value="<?php echo esc_attr($nickname); ?>" />
							</p>									
							<p id="affu_profile_website_wrap">
								<label for="affu_website"><?php _e('Website:', 'af-front-utils'); ?></label>
								<input name="affu_website" id="affu_website" class="text affu-input" type="url" value="<?php echo esc_attr($current_user->user_url); ?>" />
							</p>									
							<p id="affu_profile_display_name_wrap">
								<label for="affu_display_name"><?php _e('Display Name:', 'af-front-utils'); ?></label>
								<select name="affu_display_name" id="affu_display_name" class="select affu-select">
									<option <?php selected($display_name, $current_user->user_nicename); ?> value="<?php echo esc_attr($nickname); ?>"><?php echo esc_html($nickname); ?></option>
									<?php if (!empty($current_user->first_name)) { ?>
									<option <?php selected($display_name, $current_user->first_name); ?> value="<?php echo esc_attr($current_user->first_name); ?>"><?php echo esc_html($current_user->first_name); ?></option>
									<?php } ?>
									<?php if (!empty($current_user->last_name)) { ?>
									<option <?php selected($display_name, $current_user->last_name); ?> value="<?php echo esc_attr($current_user->last_name); ?>"><?php echo esc_html($current_user->last_name); ?></option>
									<?php } ?>
									<?php if (!empty($current_user->first_name) && !empty($current_user->last_name)) { ?>
									<option <?php selected($display_name, $current_user->first_name . ' ' . $current_user->last_name); ?> value="<?php echo esc_attr($current_user->first_name . ' ' . $current_user->last_name); ?>"><?php echo esc_html($current_user->first_name . ' ' . $current_user->last_name); ?></option>
									<option <?php selected($display_name, $current_user->last_name . ' ' . $current_user->first_name); ?> value="<?php echo esc_attr($current_user->last_name . ' ' . $current_user->first_name); ?>"><?php echo esc_html($current_user->last_name . ' ' . $current_user->first_name); ?></option>
									<?php } ?>
								</select>
							</p>									
							<p id="affu_profile_biography_wrap">
								<label for="affu_biography"><?php _e('Biographical Info:', 'af-front-utils'); ?></label>
								<textarea cols="50" rows="10" name="affu_biography" id="affu_biography" class="text affu-input" type="text"><?php echo esc_attr($biography); ?></textarea>
							</p>
						<?php do_action('affu_profile_editor_after_personal'); ?>									
						</fieldset>
						<?php 
						if (class_exists('Easy_Digital_Downloads')) { 
							$address      = edd_get_customer_address($user_id);
							$states       = edd_get_shop_states($address['country']);
							$state 		  = $address['state'];
						?>
							<fieldset id="affu_profile_billing_fieldset">
								<legend id="affu_profile_billing_label"><?php _e('Billing Address', 'af-front-utils'); ?></legend>									
								<p id="affu_profile_billing_address_line_1_wrap">
									<label for="affu_address_line1"><?php _e('Line 1:', 'af-front-utils'); ?></label>
									<input name="affu_address_line1" id="affu_address_line1" class="text affu-input" type="text" value="<?php echo esc_attr($address['line1']); ?>" />
								</p>
								<p id="affu_profile_billing_address_line_2_wrap">
									<label for="affu_address_line2"><?php _e('Line 2:', 'af-front-utils'); ?></label>
									<input name="affu_address_line2" id="affu_address_line2" class="text affu-input" type="text" value="<?php echo esc_attr($address['line2']); ?>" />
								</p>
								<p id="affu_profile_billing_address_city_wrap">
									<label for="affu_address_city"><?php _e('City:', 'af-front-utils'); ?></label>
									<input name="affu_address_city" id="affu_address_city" class="text affu-input" type="text" value="<?php echo esc_attr($address['city']); ?>" />
								</p>
								<p id="affu_profile_billing_address_postal_wrap">
									<label for="affu_address_zip"><?php _e('Zip / Postal Code:', 'af-front-utils'); ?></label>
									<input name="affu_address_zip" id="affu_address_zip" class="text affu-input" type="text" value="<?php echo esc_attr($address['zip']); ?>" />
								</p>
								<p id="affu_profile_billing_address_country_wrap">
									<label for="edd_address_country"><?php _e('Country:', 'af-front-utils'); ?></label>
									<select name="edd_address_country" id="edd_address_country" class="select affu-select" data-nonce="<?php echo wp_create_nonce('edd-country-field-nonce'); ?>">
										<?php foreach(edd_get_country_list() as $key => $country) { ?>
										<option value="<?php echo $key; ?>"<?php selected($address['country'], $key); ?>><?php echo esc_html($country); ?></option>
										<?php } ?>
									</select>
								</p>
								<p id="affu_profile_billing_address_state_wrap">
									<label for="edd_address_state"><?php _e('State / Province:', 'af-front-utils'); ?></label>
									<?php if(!empty($states)) { ?>
										<select name="edd_address_state" id="edd_address_state" class="select affu-select">
											<?php
												foreach($states as $state_code => $state_name) {
													echo '<option value="' . $state_code . '"' . selected($state_code, $state, false) . '>' . $state_name . '</option>';
												}
											?>
										</select>
									<?php } else { ?>
										<input name="edd_address_state" id="edd_address_state" class="text affu-input" type="text" value="<?php echo esc_attr($state); ?>" />
									<?php } ?>
								</p>
							<?php do_action('affu_profile_editor_after_edd'); ?>
							</fieldset>
						<?php } ?>
						<fieldset id="affu_profile_forum_fieldset">								
							<legend id="affu_profile_forum_label"><?php _e('Forum', 'af-front-utils'); ?></legend>									
							<?php if ($asgarosforum->options['enable_mentioning']) { ?>
								<p id="affu_profile_mention_wrap">
									<label for="affu_mention"><?php _e('Notify me when mentioned:', 'af-front-utils'); ?></label>
									<input name="affu_mention" id="affu_mention" class="checkbox affu-input" type="checkbox" value="1" <?php if ('yes' == get_user_meta($user_id, 'asgarosforum_mention_notify', true)) { echo 'checked'; }?>/>
								</p>
							<?php } ?>								
							<?php if ($asgarosforum->options['enable_avatars'] && 1 == AFFrontUtils::get_option('custom_avatars', 1)) { ?>
								<p id="affu_profile_avatar_wrap">
									<label for="affu_avatar"><?php _e('Profile picture:', 'af-front-utils'); ?></label>							
									<input name="affu_avatar" id="affu_avatar" class="file affu-input" type="file" accept="image/*" />
								</p>
							<?php } ?>									
							<?php if ($asgarosforum->options['allow_signatures'] && $asgarosforum->permissions->can_use_signature(get_current_user_id())) { ?>	
								<p id="affu_profile_signature_wrap">
									<label for="affu_signature"><?php _e('Signature:', 'af-front-utils'); ?></label>
									<textarea cols="50" rows="10" name="affu_signature" id="affu_signature" class="text affu-input" type="text"><?php echo esc_attr($signature); ?></textarea>
								</p>
								<p id="affu_profile_signature_info">
									<label>&nbsp;</label>
									<span>
									<?php if ($asgarosforum->options['signatures_html_allowed']) { ?>
										<?php _e('You can use the following HTML tags in signatures:', 'af-front-utils');?> <br><code><?php echo esc_html($asgarosforum->options['signatures_html_tags']);?></code>
									<?php } else { ?>
										<?php _e('HTML tags are not allowed in signatures.', 'af-front-utils');?>
									<?php } ?>
									</span>
								</p>
							<?php } ?>
						<?php do_action('affu_profile_editor_after_forum'); ?>
						</fieldset>
						<fieldset id="affu_profile_account_fieldset">
							<legend id="affu_profile_account_label"><?php _e('Account', 'af-front-utils'); ?></legend>									
							<p id="affu_profile_email_wrap">
								<label for="affu_email"><?php _e('Email Address:', 'af-front-utils'); ?></label>
								<input name="affu_email" id="affu_email" class="text affu-input required" type="email" value="<?php echo esc_attr($current_user->user_email); ?>" />
							</p>									
							<p id="affu_profile_password_wrap">
								<label for="affu_user_pass"><?php _e('New Password:', 'af-front-utils'); ?></label>
								<input name="affu_new_user_pass1" id="affu_new_user_pass1" class="password affu-input" type="password"/>
							</p>
							<p id="affu_profile_confirm_password_wrap">
								<label for="affu_user_pass"><?php _e('Re-enter Password:', 'af-front-utils'); ?></label>
								<input name="affu_new_user_pass2" id="affu_new_user_pass2" class="password affu-input" type="password"/>
							</p>
						</fieldset>								
						<fieldset id="affu_profile_submit_fieldset">
							<p id="affu_profile_submit_wrap">
								<input type="hidden" name="affu_profile_editor_nonce" value="<?php echo wp_create_nonce('affu-profile-editor-nonce'); ?>"/>
								<input name="affu_profile_editor_submit" id="affu_profile_editor_submit" type="submit" class="affu_submit affu-submit" value="<?php _e('Save Changes', 'af-front-utils'); ?>"/>
							</p>
						</fieldset>
					<?php do_action('affu_profile_editor_after_account'); ?>
					</form>						
				</div>
				<?php
				$current_user_id = get_current_user_id();

				if ($userData->ID == $current_user_id) {
					?>
					<a href="" class="affu-back-to-profile">
						<span class="fas fa-arrow-left"></span>
					<?php
						echo __('Back to profile', 'af-front-utils');
					?></a><?php
				}
			?></div>