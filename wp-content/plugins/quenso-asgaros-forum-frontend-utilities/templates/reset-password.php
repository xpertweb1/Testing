<div id="affu-ajax-reset-password" style="display:none">
	<form id="affu_reset_password_form" class="affu_reset_password_form" action="" method="post" name="affu_reset_password_form">
			<div class="affu-form-container">
				<div class="affu-form-row">
					<div class="affu-form-field">
						<p class="hide-on-success"><?php esc_html_e( 'Please enter your username or email address.', 'af-front-utils'); ?></p>
						<p class="hide-on-success"><?php esc_html_e( 'You will receive a link to create a new password via email.', 'af-front-utils'); ?></p>
						<p style="color:green;" id="affu-reset-password-success-message"></p>
					</div>
					<div class="affu-form-field">
						<div class="affu-error">
							<p id="affu-reset-password-error-message"></p>
						</div>
					</div>
					<div class="affu-form-field hide-on-success">
						<div class="affu-form-icon">
							<i class="fas fa-user"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_rp_login" class="affu-form-input" type="text" name="affu_login" placeholder="<?php _e('Username or Email', 'af-front-utils'); ?>">
						</div>
					</div>
					<div class="affu-form-field hide-on-success">
						<button type="submit" class="affu-form-submit">
							<span id="affu-form-submit-text"><?php _e('Reset Password', 'af-front-utils'); ?></span>
							<img style="display:none" id="affu-ajax-loader" src="<?php echo plugin_dir_url(AFFrontUtils::PLUGIN_FILE) . 'assets/img/ajax_loader.gif'; ?>">
						</button>
					</div>
				</div>
			</div>
	<input type="hidden" id="affu_rp_nonce" name="affu_nonce" value="<?php echo wp_create_nonce('affu_ajax_reset_password_nonce'); ?>"/>
	</form>
</div>