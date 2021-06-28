jQuery(document).ready(function($) {

    // Edit profile
	if (affu_ajax.edit_profile_option == 1) {
		$('#af-wrapper a.edit-profile-link').on('click', function(e){
			$('#af-wrapper .error-message').hide();
			document.getElementById('profile-content').innerHTML = document.getElementById('affu-edit-profile').innerHTML;
			e.preventDefault();
		});
		
		$('#af-wrapper .success-message').delay(2000).fadeOut(600);
	}
	
	// Login
	if (affu_ajax.login_option == 1) {
		// Show login popup on link click
		$('#af-wrapper a.login-link').on('click', function(e){
			$('#affu-ajax-login').fadeToggle(600);
			$('#affu-ajax-register').fadeOut(1);
			$('#affu-ajax-reset-password').fadeOut(1);
			e.preventDefault();
		});
		
		// Perform AJAX login on form submit
		$('form#affu_login_form').on('submit', function(e){
			$('#affu-ajax-login #affu-form-submit-text').hide();
			$('#affu-ajax-login #affu-ajax-loader').show();
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: affu_ajax.ajaxurl,
				data: { 
					'action': 'affu_process_ajax_login',
					'affu_login': $('form#affu_login_form #affu_l_login').val(),
					'affu_password': $('form#affu_login_form #affu_l_password').val(),
					'affu_remember': $('form#affu_login_form #affu_l_remember').val(),
					'affu_redirect': $('form#affu_login_form #affu_l_redirect').val(),
					'affu_nonce': $('form#affu_login_form #affu_l_nonce').val() 
				},
				success: function(response){
					if (response.success == true){
						window.location = response.data;
					} else {
						$('#affu-ajax-login #affu-form-submit-text').show();
						$('#affu-ajax-login #affu-ajax-loader').hide();
						document.getElementById('affu-login-error-message').innerHTML = response.data;
						// Resend confirmation email
						$('a.affu-resend-confirmation').on('click', function(e){										
							$.ajax({
								type: 'POST',
								dataType: 'json',
								url: affu_ajax.ajaxurl,
								data: { 
									'action': 'affu_process_ajax_resend_confirmation',
									'affu_uid': $('a.affu-resend-confirmation').attr('affu_uid'),
									'affu_nonce': $('a.affu-resend-confirmation').attr('affu_nonce')
								},
								success: function(response){
									$('#affu-ajax-login .hide-on-success').hide();
									$('#affu-ajax-login .affu-error').hide();
									document.getElementById('affu-login-success-message').innerHTML = response.data;
									$('#affu-ajax-login').delay(4000).fadeOut(600);
								}
							});		
							e.preventDefault();
						});
					}
				}
			});
			e.preventDefault();
		});
		
		if (affu_ajax.reset_password_option == 1) {
			// Show reset password popup on link click
			$('#affu-ajax-login a.reset-password').on('click', function(e){
				$('#affu-ajax-reset-password').fadeToggle(600);
				$('#affu-ajax-login').fadeOut(1);
				e.preventDefault();
			});
			
			// Perform AJAX lost password on form submit
			$('form#affu_reset_password_form').on('submit', function(e){
				$('#affu-ajax-reset-password #affu-form-submit-text').hide();
				$('#affu-ajax-reset-password #affu-ajax-loader').show();
				
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: affu_ajax.ajaxurl,
					data: { 
						'action': 'affu_process_ajax_reset_password',
						'affu_login': $('form#affu_reset_password_form #affu_rp_login').val(),
						'affu_nonce': $('form#affu_reset_password_form #affu_rp_nonce').val() 
					},
					success: function(response){
						if (response.success == true){
							$('#affu-ajax-reset-password .hide-on-success').hide();
							document.getElementById('affu-reset-password-success-message').innerHTML = response.data;
							$('#affu-ajax-reset-password').delay(4000).fadeOut(600);
						} else {
							$('#affu-ajax-reset-password #affu-form-submit-text').show();
							$('#affu-ajax-reset-password #affu-ajax-loader').hide();
							document.getElementById('affu-reset-password-error-message').innerHTML = response.data;
						}
					}
				});
				e.preventDefault();
			});
		}
	}
	
	// Register
	if (affu_ajax.login_option == 1) {
		// Show register popup on link click
		$('#af-wrapper a.register-link').on('click', function(e){
			$('#affu-ajax-register').fadeToggle(600);
			$('#affu-ajax-login').fadeOut(1);
			$('#affu-ajax-reset-password').fadeOut(1);
			e.preventDefault();
		});
		
		// Perform AJAX register on form submit
		$('form#affu_register_form').on('submit', function(e){
			$('#affu-ajax-register #affu-form-submit-text').hide();
			$('#affu-ajax-register #affu-ajax-loader').show();
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: affu_ajax.ajaxurl,
				data: { 
					'action': 'affu_process_ajax_register',
					'affu_username': $('form#affu_register_form #affu_r_username').val(),
					'affu_email': $('form#affu_register_form #affu_r_email').val(),
					'affu_password': $('form#affu_register_form #affu_r_password').val(),
					'affu_password2': $('form#affu_register_form #affu_r_password2').val(),
					'affu_redirect': $('form#affu_register_form #affu_r_redirect').val(),
					'affu_nonce': $('form#affu_register_form #affu_r_nonce').val() 
				},
				success: function(response){
					if (response.success == true){
						if (affu_ajax.confirm_registration_option == 1) {
							$('#affu-ajax-register .hide-on-confirm').hide();
							document.getElementById('affu-register-confirm-message').innerHTML = response.data;
							$('#affu-ajax-register').delay(8000).fadeOut(600);
						} else {
							window.location = response.data;
						}
					} else {
						$('#af-wrapper #affu-form-submit-text').show();
						$('#af-wrapper #affu-ajax-loader').hide();
						document.getElementById('affu-register-error-message').innerHTML = response.data;
					}
				}
			});
			e.preventDefault();
		});
	}

});