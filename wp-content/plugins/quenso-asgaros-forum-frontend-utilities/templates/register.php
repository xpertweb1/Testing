<div id="affu-ajax-register" style="display:none">
	<form id="affu_register_form" class="affu_register_form" action="" method="post" name="affu_register_form">
			<div class="affu-form-container">
				<div class="affu-form-row">
					<div class="affu-form-field">
						<div class="affu-error">
							<p id="affu-register-error-message"></p>
						</div>
						<div class="affu-confirm">
							<p id="affu-register-confirm-message"></p>
						</div>
					</div>
					<div class="affu-form-field hide-on-confirm">
						<div class="affu-form-icon">
							<i class="fas fa-user"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_r_username" class="affu-form-input" type="text" name="affu_username" placeholder="<?php _e('Username', 'af-front-utils'); ?>">
						</div>
					</div>
					<div class="affu-form-field hide-on-confirm">
						<div class="affu-form-icon">
							<i class="fas fa-envelope"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_r_email" class="affu-form-input" type="email" name="affu_email" placeholder="<?php _e('Email', 'af-front-utils'); ?>">
						</div>
					</div>
					<div class="affu-form-field hide-on-confirm">
						<div class="affu-form-icon">
							<i class="fas fa-lock"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_r_password" class="affu-form-input" type="password" name="affu_password" placeholder="<?php _e('Password', 'af-front-utils'); ?>">
						</div>
					</div>
					<div class="affu-form-field hide-on-confirm">
						<div class="affu-form-icon">
							<i class="fas fa-redo-alt"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_r_password2" class="affu-form-input" type="password" name="affu_password2" placeholder="<?php _e('Confirm Password', 'af-front-utils'); ?>">
						</div>
					</div>
					<div class="affu-form-field hide-on-confirm">
						<button type="submit" class="affu-form-submit">
							<span id="affu-form-submit-text"><?php _e('Register', 'af-front-utils'); ?></span>
							<img style="display:none" id="affu-ajax-loader" src="<?php echo plugin_dir_url(AFFrontUtils::PLUGIN_FILE) . 'assets/img/ajax_loader.gif'; ?>">
						</button>
					</div>
				</div>
			</div>
		<input type="hidden" id="affu_r_redirect" name="affu_redirect" value="<?php echo $asgarosforum->get_link('home'); ?>"/>
		<input type="hidden" id="affu_r_nonce" name="affu_nonce" value="<?php echo wp_create_nonce('affu_ajax_register_nonce'); ?>"/>
	</form>
</div>