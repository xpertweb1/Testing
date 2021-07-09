<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.02.23.
 * Time: 14:57
 */
?>
<h2 id="create-checkout-form-tabs" class="nav-tab-wrapper wpfs-admin-form-tabs">
	<a href="#create-checkout-form-tab-payment" class="nav-tab"><?php esc_html_e( 'Payment', 'wp-full-stripe-admin' ); ?></a>
	<a href="#create-checkout-form-tab-appearance" class="nav-tab"><?php esc_html_e( 'Appearance', 'wp-full-stripe-admin' ); ?></a>
	<a href="#create-checkout-form-tab-custom-fields" class="nav-tab"><?php esc_html_e( 'Custom Fields', 'wp-full-stripe-admin' ); ?></a>
	<a href="#create-checkout-form-tab-actions-after-payment" class="nav-tab"><?php esc_html_e( 'Actions after payment', 'wp-full-stripe-admin' ); ?></a>
</h2>
<form class="form-horizontal wpfs-admin-form" action="" method="POST" id="create-checkout-form">
	<p class="tips"></p>
	<input type="hidden" name="action" value="wp_full_stripe_create_popup_card_capture_form">
	<div id="create-checkout-form-tab-payment" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Type:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td><?php esc_html_e( 'Checkout save card form', 'wp-full-stripe-admin' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Name:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_name" id="form_name" maxlength="<?php echo $form_data::NAME_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'This name will be used to identify this form in the shortcode i.e. [fullstripe_form name="formName" type="popup_save_card"].', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
            <tr valign="top" id="stripe_description_row">
                <th scope="row">
                    <label class="control-label">
                        <?php esc_html_e( 'Description: ', 'wp-full-stripe-admin' ); ?>
                    </label>
                </th>
                <td>
                    <textarea rows="3" class="large-text code" name="stripe_description"><?php echo esc_html( MM_WPFS_Utils::createDefaultCardSavedDescription() ); ?></textarea>
                    <p class="description"><?php printf( __( 'It appears in the customer\'s "Details" section on the Stripe dashboard. You can use placeholders, see the <a target="_blank" href="%s">Help page</a> for more options.', 'wp-full-stripe-admin' ), admin_url( "admin.php?page=fullstripe-help#receipt-tokens" ) ); ?> </p>
                </td>
            </tr>
			<input type="hidden" name="form_custom" value="custom_amount">
		</table>
	</div>
	<div id="create-checkout-form-tab-appearance" class="wpfs-tab-content">
		<?php include('create_checkout_card_capture_form_tab_appearance.php'); ?>
	</div>
	<div id="create-checkout-form-tab-custom-fields" class="wpfs-tab-content">
		<?php include('create_payment_form_tab_custom_fields.php'); ?>
	</div>
	<div id="create-checkout-form-tab-actions-after-payment" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Send Email Receipt?', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_send_email_receipt" value="0" checked="checked">
						<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_send_email_receipt" value="1">
						<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php esc_html_e( 'Send an email receipt on successful payment?', 'wp-full-stripe-admin' ); ?> </p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Redirect On Success?', 'wp-full-stripe-admin' ); ?></label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_do_redirect" id="do_redirect_no" value="0" checked="checked">
						<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_do_redirect" id="do_redirect_yes" value="1">
						<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php esc_html_e( 'When payment is successful you can choose to redirect to another page or post.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<?php include('redirect_to_for_create.php'); ?>
		</table>
	</div>
	<p class="submit">
		<button class="button button-primary" type="submit"><?php esc_html_e( 'Create Form', 'wp-full-stripe-admin' ); ?></button>
		<a href="<?php echo admin_url( 'admin.php?page=fullstripe-saved-cards&tab=forms' ); ?>" class="button"><?php esc_html_e( 'Cancel', 'wp-full-stripe-admin' ); ?></a>
		<img src="<?php echo MM_WPFS_Assets::images( 'loader.gif' ); ?>" alt="<?php esc_attr_e( 'Loading...', 'wp-full-stripe-admin' ); ?>" class="showLoading"/>
	</p>
</form>
