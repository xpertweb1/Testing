<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.02.21.
 * Time: 16:09
 */

$customInputLabels = array();
if ( $form->customInputs ) {
	$customInputLabels = MM_WPFS_Utils::decode_custom_input_labels( $form->customInputs );
}

$form_id_css = MM_WPFS_Utils::generate_form_hash( MM_WPFS_Utils::getFormType( $form ), MM_WPFS_Utils::getFormId( $form ), $form->name );
?>
<h2 id="edit-subscription-form-tabs" class="nav-tab-wrapper wpfs-admin-form-tabs">
	<a href="#edit-subscription-form-tab-payment" class="nav-tab"><?php esc_html_e( 'Payment', 'wp-full-stripe-admin' ); ?></a>
	<a href="#edit-subscription-form-tab-finance" class="nav-tab"><?php esc_html_e( 'Finance', 'wp-full-stripe-admin' ); ?></a>
	<a href="#edit-subscription-form-tab-appearance" class="nav-tab"><?php esc_html_e( 'Appearance', 'wp-full-stripe-admin' ); ?></a>
	<a href="#edit-subscription-form-tab-custom-fields" class="nav-tab"><?php esc_html_e( 'Custom Fields', 'wp-full-stripe-admin' ); ?></a>
	<a href="#edit-subscription-form-tab-actions-after-payment" class="nav-tab"><?php esc_html_e( 'Actions after payment', 'wp-full-stripe-admin' ); ?></a>
</h2>
<form class="form-horizontal wpfs-admin-form" action="" method="POST" id="edit-subscription-form">
	<p class="tips"></p>
	<input type="hidden" name="action" value="wp_full_stripe_edit_subscription_form"/>
	<input type="hidden" name="formID" value="<?php echo $form->subscriptionFormID; ?>">
	<div id="edit-subscription-form-tab-payment" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Type:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td><?php esc_html_e( 'Inline subscription form', 'wp-full-stripe-admin' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Name:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_name" id="form_name" value="<?php echo $form->name; ?>" maxlength="<?php echo $form_data::NAME_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'This name will be used to identify this form in the shortcode i.e. [fullstripe_form name="formName" type="inline_subscription"].', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Include Coupon Input Field?', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_include_coupon_input" id="noinclude_coupon_input" value="0" <?php echo ( $form->showCouponInput == '0' ) ? 'checked' : '' ?> >
						<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_include_coupon_input" id="include_coupon_input" value="1" <?php echo ( $form->showCouponInput == '1' ) ? 'checked' : '' ?> >
						<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php printf( __( 'You can allow customers to input coupon codes for discounts. Must create the coupon in your <a href="%s" target="_blank">Stripe account dashboard</a>.', 'wp-full-stripe-admin' ), 'https://dashboard.stripe.com/' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Allow Multiple Subscriptions?', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_allow_multiple_subscriptions_input" id="allow_multiple_subscriptions_input_no" value="0" <?php echo ( $form->allowMultipleSubscriptions == '0' ) ? 'checked' : '' ?>>
						<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_allow_multiple_subscriptions_input" id="allow_multiple_subscriptions_input_yes" value="1" <?php echo ( $form->allowMultipleSubscriptions == '1' ) ? 'checked' : '' ?>>
						<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
					</label>
					<p class="description"><?php esc_html_e( 'Allow customers to choose how many subscriptions they want to subscribe.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top" id="maximum_number_of_subscriptions_row" <?php echo ( $form->allowMultipleSubscriptions == '0' ) ? 'style="display: none;"' : '' ?>>
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Maximum Number of Subscriptions:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_maximum_quantity_of_subscriptions" id="form_maximum_quantity_of_subscriptions" value="<?php echo esc_attr( $form->maximumQuantityOfSubscriptions ); ?>">
					<p class="description"><?php esc_html_e( 'Enter 0 (zero) if customers can subscribe to any number of subscriptions.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Billing Cycle Anchor Day:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <label class="radio inline">
                        <input type="radio" name="form_anchor_billing_cycle_input" id="anchor_billing_cycle_no" value="0" <?php echo ( $form->anchorBillingCycle == '0' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( 'When customer subscribed', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="form_anchor_billing_cycle_input" id="anchor_billing_cycle_yes" value="1" <?php echo ( $form->anchorBillingCycle == '1' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( 'On this day of month:', 'wp-full-stripe-admin' ); ?>
                        <select name="form_billing_cycle_anchor_day_input" id="billing_cycle_anchor_day_select" <?php echo ( $form->anchorBillingCycle == '0' ) ? 'disabled' : '' ?>>
                            <?php for ( $dayIdx = 1; $dayIdx <= 28; $dayIdx++ ) { ?>
                                <option value="<?php echo $dayIdx ?>" <?php echo ( $form->billingCycleAnchorDay == $dayIdx ) ? 'selected' : '' ?>><?php echo $dayIdx ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <p class="description"><?php esc_html_e( 'Anchor day of the month for monthly subscription plans.', 'wp-full-stripe-admin' ); ?></p>
                </td>
            </tr>
            <tr valign="top" id="prorate_until_anchor_day_row" style="<?php echo ( $form->anchorBillingCycle == '0' ) ? 'display: none;' : '' ?>">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Prorate until Anchor Day?', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <label class="radio inline">
                        <input type="radio" name="form_prorate_until_anchor_day_input" id="prorate_until_anchor_day_no" value="0" <?php echo ( $form->prorateUntilAnchorDay == '0' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="form_prorate_until_anchor_day_input" id="prorate_until_anchor_day_yes" value="1" <?php echo ( $form->prorateUntilAnchorDay == '1' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <p class="description"><?php esc_html_e( 'Should the plugin prorate the charges resulting from the billing anchor day?', 'wp-full-stripe-admin' ); ?></p>
                </td>
            </tr>

            <tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Plans:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<div class="plan_checkboxes">
						<ul class="plan_checkbox_list">
							<?php
							$form_plans    = json_decode( $form->plans );
							$ordered_plans = array();
							$plan_order    = array();
							foreach ( $plans as $plan ) {
								$i = array_search( $plan->id, $form_plans );
								if ( $i !== false ) {
									$ordered_plans[ $i ] = $plan;
								}
							}
							ksort( $ordered_plans );
							?>
							<?php foreach ( $ordered_plans as $plan ): ?>
								<?php
								$plan_order[]   = $plan->id;
								$interval_label = MM_WPFS_Admin::formatIntervalLabelAdmin( $plan->interval, $plan->interval_count );
								$amount_label   = isset( $plan->amount ) ? MM_WPFS_Currencies::formatAndEscape( $plan->currency, $plan->amount ) : '';
								?>
								<li class="ui-state-default" data-toggle="tooltip" title="<?php esc_attr_e( 'You can reorder this list by using drag\'n\'drop.', 'wp-full-stripe-admin' ); ?>" data-plan-id="<?php echo esc_attr( $plan->id ); ?>">
									<label class="checkbox inline">
										<input type="checkbox" class="plan_checkbox" id="check_<?php echo esc_attr( $plan->id ); ?>" value="<?php echo esc_attr( $plan->id ); ?>" checked>
                                        <span class="plan_checkbox_text"><?php echo esc_html( $plan->product->name ); ?>
	                                        (<?php echo $amount_label; ?> / <?php echo esc_html( $interval_label ); ?>)
                                        </span>
									</label>
								</li>
							<?php endforeach; ?>
							<?php foreach ( $plans as $plan ): ?>
								<?php if ( ! in_array( $plan->id, $form_plans ) ): ?>
									<?php
									$plan_order[]   = $plan->id;
									$interval_label = MM_WPFS_Admin::formatIntervalLabelAdmin( $plan->interval, $plan->interval_count );
									$amount_label   = isset( $plan->amount ) ? MM_WPFS_Currencies::formatAndEscape( $plan->currency, $plan->amount ) : '';
									?>
									<li class="ui-state-default" data-toggle="tooltip" title="<?php esc_attr_e( 'You can reorder this list by using drag\'n\'drop.', 'wp-full-stripe-admin' ); ?>" data-plan-id="<?php echo esc_attr( $plan->id ); ?>">
										<label class="checkbox inline">
											<input type="checkbox" class="plan_checkbox" id="check_<?php echo esc_attr( $plan->id ); ?>" value="<?php echo esc_attr( $plan->id ); ?>">
                                            <span class="plan_checkbox_text"><?php echo esc_html( $plan->product->name ); ?>
	                                        (<?php echo $amount_label; ?> / <?php echo esc_html( $interval_label ); ?>)
                                            </span>
										</label>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
					<p class="description"><?php esc_html_e( 'Which subscription plans can be chosen on this form. The list can be reordered by using drag\'n\'drop.', 'wp-full-stripe-admin' ); ?></p>
					<input type="hidden" name="plan_order" value="<?php echo rawurlencode( json_encode( $plan_order ) ); ?>"/>
				</td>
			</tr>
		</table>
	</div>
	<div id="edit-subscription-form-tab-finance" class="wpfs-tab-content">
		<?php include('edit_subscription_form_tab_finance.php'); ?>
	</div>
	<div id="edit-subscription-form-tab-appearance" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form ID for Custom CSS:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<p>
						<input class="wpfsadm-ro-clipboard" type="text" size="30" value="<?php echo( $form_id_css ); ?>" readonly>
						<a class="wpfsadm-copy-to-clipboard" data-form-id="<?php echo( $form_id_css ); ?>">Copy to
							clipboard</a>
					</p>
					<p class="description"><?php esc_html_e( 'Use this CSS selector to add custom styles to this form.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label" for=""><?php esc_html_e( 'Plan Selector Style: ', 'wp-full-stripe-admin' ); ?></label>
				</th>
				<td>
					<select name="plan_selector_style">
						<option value="<?php echo MM_WPFS::PLAN_SELECTOR_STYLE_DROPDOWN; ?>" <?php echo ( $form->planSelectorStyle == MM_WPFS::PLAN_SELECTOR_STYLE_DROPDOWN ) ? 'selected' : '' ?>><?php esc_html_e( 'Dropdown', 'wp-full-stripe-admin' ); ?></option>
						<option value="<?php echo MM_WPFS::PLAN_SELECTOR_STYLE_LIST; ?>" <?php echo ( $form->planSelectorStyle == MM_WPFS::PLAN_SELECTOR_STYLE_LIST ) ? 'selected' : '' ?>><?php esc_html_e( 'List', 'wp-full-stripe-admin' ); ?></option>
					</select>

					<p class="description"><?php esc_html_e( 'Style of the plan selector component.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Subscribe Button Text:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_button_text" id="form_button_text" value="<?php echo $form->buttonTitle; ?>" maxlength="<?php echo $form_data::BUTTON_TITLE_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'The text on the subscribe button.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label" for=""><?php esc_html_e( "Card Input Field Language: ", 'wp-full-stripe-admin' ); ?></label>
                </th>
                <td>
                    <select name="form_preferred_language">
                        <option value="<?php echo MM_WPFS::PREFERRED_LANGUAGE_AUTO; ?>"><?php esc_html_e( 'Auto', 'wp-full-stripe-admin' ); ?></option>
                        <?php
                        foreach ( MM_WPFS::get_available_stripe_elements_languages() as $language ) {
                            $option = '<option value="' . $language['value'] . '"';
                            if ( $form->preferredLanguage == $language['value'] ) {
                                $option .= ' selected="selected"';
                            }
                            $option .= '>';
                            $option .= $language['name'];
                            $option .= '</option>';
                            echo $option;
                        }
                        ?>
                    </select>

                    <p class="description"><?php esc_html_e( "Display the card info field in the selected language. Use 'Auto' to determine the language from the locale sent by the customer's browser.", 'wp-full-stripe-admin' ); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Format decimals with:', 'wp-full-stripe-admin' ); ?></label>
                </th>
                <td>
                    <label class="checkbox">
                        <input type="radio" name="decimal_separator" id="decimal_separator_dot" value="<?php echo MM_WPFS::DECIMAL_SEPARATOR_SYMBOL_DOT; ?>" <?php echo ( $form->decimalSeparator == MM_WPFS::DECIMAL_SEPARATOR_SYMBOL_DOT ) ? 'checked' : '' ?>>
                        <?php esc_html_e( '$10.99 (dot)', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <label class="checkbox">
                        <input type="radio" name="decimal_separator" id="decimal_separator_comma" value="<?php echo MM_WPFS::DECIMAL_SEPARATOR_SYMBOL_COMMA; ?>" <?php echo ( $form->decimalSeparator == MM_WPFS::DECIMAL_SEPARATOR_SYMBOL_COMMA ) ? 'checked' : '' ?>>
                        <?php esc_html_e( '$10,99 (comma)', 'wp-full-stripe-admin' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Use currency symbol or code?', 'wp-full-stripe-admin' ); ?></label>
                </th>
                <td>
                    <label class="checkbox">
                        <input type="radio" name="show_currency_symbol_instead_of_code" id="use_currency_symbol" value="1" <?php echo ( $form->showCurrencySymbolInsteadOfCode == '1' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( '$10.99 (symbol)', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <label class="checkbox">
                        <input type="radio" name="show_currency_symbol_instead_of_code" id="use_currency_code" value="0" <?php echo ( $form->showCurrencySymbolInsteadOfCode == '0' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( 'USD 10.99 (code)', 'wp-full-stripe-admin' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Put currency identifier on:', 'wp-full-stripe-admin' ); ?></label>
                </th>
                <td>
                    <label class="checkbox">
                        <input type="radio" name="show_currency_sign_at_first_position" id="put_currency_identifier_to_the_left" value="1" <?php echo ( $form->showCurrencySignAtFirstPosition == '1' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( '€10.99 (left)', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <label class="checkbox">
                        <input type="radio" name="show_currency_sign_at_first_position" id="put_currency_identifier_to_the_right" value="0" <?php echo ( $form->showCurrencySignAtFirstPosition == '0' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( '10.99€ (right)', 'wp-full-stripe-admin' ); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Insert space between amount and currency?', 'wp-full-stripe-admin' ); ?></label>
                </th>
                <td>
                    <label class="checkbox">
                        <input type="radio" name="put_whitespace_between_currency_and_amount" id="do_not_put_whitespace_between_currency_and_amount" value="0" <?php echo ( $form->putWhitespaceBetweenCurrencyAndAmount == '0' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( '$10.99 (no)', 'wp-full-stripe-admin' ); ?>
                    </label>
                    <label class="checkbox">
                        <input type="radio" name="put_whitespace_between_currency_and_amount" id="put_whitespace_between_currency_and_amount" value="1" <?php echo ( $form->putWhitespaceBetweenCurrencyAndAmount == '1' ) ? 'checked' : '' ?>>
                        <?php esc_html_e( 'USD 10.99 (yes)', 'wp-full-stripe-admin' ); ?>
                    </label>
                </td>
            </tr>
		</table>
	</div>
	<div id="edit-subscription-form-tab-custom-fields" class="wpfs-tab-content">
		<?php include('edit_payment_form_tab_custom_fields.php'); ?>
	</div>
	<div id="edit-subscription-form-tab-actions-after-payment" class="wpfs-tab-content">
		<?php include('edit_payment_form_tab_actions_after_payment.php'); ?>
	</div>
	<p class="submit">
		<button class="button button-primary" type="submit"><?php esc_html_e( 'Save Changes', 'wp-full-stripe-admin' ); ?></button>
		<a href="<?php echo admin_url( 'admin.php?page=fullstripe-subscriptions&tab=forms' ); ?>" class="button"><?php esc_html_e( 'Cancel', 'wp-full-stripe-admin' ); ?></a>
		<img src="<?php echo MM_WPFS_Assets::images( 'loader.gif' ); ?>" alt="<?php esc_attr_e( 'Loading...', 'wp-full-stripe-admin' ); ?>" class="showLoading"/>
	</p>
</form>
