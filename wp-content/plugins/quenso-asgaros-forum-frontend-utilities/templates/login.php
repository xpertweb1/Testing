<div id="affu-ajax-login" style="display:none">
	<form id="affu_login_form" class="affu_login_form" action="" method="post" name="affu_login_form">
			<div class="affu-form-container">
				<div class="affu-form-row">
					<div class="affu-form-field">
						<div class="affu-error">
							<p id="affu-login-error-message"></p>
						</div>
						<div class="affu-sucess">
							<p id="affu-login-success-message"></p>
						</div>
					</div>
					<div class="affu-form-field hide-on-success">
						<div class="affu-form-icon">
							<i class="fas fa-user"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_l_login" class="affu-form-input" type="text" name="affu_login" placeholder="<?php _e('Username or Email', 'af-front-utils'); ?>">
						</div>
					</div>
					<div class="affu-form-field hide-on-success">
						<div class="affu-form-icon">
							<i class="fas fa-lock"></i>
						</div>
						<div class="affu-form-input">
							<input id="affu_l_password" class="affu-form-input" type="password" name="affu_password" placeholder="<?php _e('Password', 'af-front-utils'); ?>">
						</div>
					</div>	
					<div class="affu-form-field hide-on-success">
						<button type="submit" class="affu-form-submit">
							<span id="affu-form-submit-text"><?php _e('Login', 'af-front-utils'); ?></span>
							<img style="display:none" id="affu-ajax-loader" src="<?php echo plugin_dir_url(AFFrontUtils::PLUGIN_FILE) . 'assets/img/ajax_loader.gif'; ?>">
						</button>
					</div>
				</div>
				<div class="affu-form-row">
					<div class="affu-form-field hide-on-success">
						<div class="affu-form-checkbox">
							<input type="checkbox" alt="Remember Me" value="yes" id="affu_l_remember" name="affu_remember" checked="">
							<label for="affu_remember"><?php _e('Remember me', 'af-front-utils'); ?></label>
						</div>
						<?php if (1 == AFFrontUtils::get_option('reset_password', 0)) { ?>
						<div class="affu-form-link">
							<a class="affu-form-link reset-password"><?php _e('Forgot Password', 'af-front-utils'); ?></a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<input type="hidden" id="affu_l_redirect" name="affu_redirect" value="<?php echo home_url($wp->request) ?>"/>
		<input type="hidden" id="affu_l_nonce" name="affu_nonce" value="<?php echo wp_create_nonce('affu_ajax_login_nonce'); ?>"/>
	</form>
</div>