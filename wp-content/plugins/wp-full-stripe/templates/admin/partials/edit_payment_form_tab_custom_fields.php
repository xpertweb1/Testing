<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.02.23.
 * Time: 14:30
 */

/** @var array $customInputLabels */

$customInputFieldMaxCount = MM_WPFS::get_custom_input_field_max_count();

?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Include Terms of Use Checkbox?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="show_terms_of_use" id="show_terms_of_use_no" value="0" <?php echo ( $form->showTermsOfUse == '0' ) ? 'checked' : '' ?>>
				<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="show_terms_of_use" id="show_terms_of_use_yes" value="1" <?php echo ( $form->showTermsOfUse == '1' ) ? 'checked' : '' ?>>
				<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
			</label>
			<p class="description"><?php esc_html_e( 'You can ask the customer to accept the Terms of Use.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
</table>
<table id="termsOfUseSection" class="form-table" style="<?php echo ( $form->showTermsOfUse == '0' ) ? 'display:none;' : '' ?>">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Checkbox Label: ', 'wp-full-stripe-admin' ); ?></label>
		</th>
		<td>
			<input id="terms_of_use_label" type="text" class="large-text" name="terms_of_use_label" value="<?php echo esc_attr( stripslashes( $form->termsOfUseLabel ) ); ?>"/>
			<p class="description"><?php esc_html_e( 'The label which is displayed next to the checkbox.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Not Checked Error Message: ', 'wp-full-stripe-admin' ); ?></label>
		</th>
		<td>
			<input id="terms_of_use_not_checked_error_message" type="text" class="large-text" name="terms_of_use_not_checked_error_message" value="<?php echo esc_attr( $form->termsOfUseNotCheckedErrorMessage ); ?>"/>
			<p class="description"><?php esc_html_e( 'The error message to display if the checkbox is not checked when the form is submitted.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
</table>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Include Custom Input Fields?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_include_custom_input" id="noinclude_custom_input" value="0" <?php echo ( $form->showCustomInput == '0' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_include_custom_input" id="include_custom_input" value="1" <?php echo ( $form->showCustomInput == '1' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
			</label>

			<p class="description"><?php esc_html_e( 'You can ask for extra information from the customer to be included in the payment details.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
</table>
<table id="customInputSection" class="form-table" style="<?php echo ( $form->showCustomInput == '0' ) ? 'display:none;' : '' ?>">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Make Custom Input Fields Required?', 'wp-full-stripe-admin' ); ?></label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_custom_input_required" id="custom_input_required_no" value="0" <?php echo ( $form->customInputRequired == '0' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_custom_input_required" id="custom_input_required_yes" value="1" <?php echo ( $form->customInputRequired == '1' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Number of inputs:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<select id="customInputNumberSelect">
				<?php for ( $i = 1; $i <= $customInputFieldMaxCount; $i ++ ) {
					$option = '<option';
					$option .= " value=\"{$i}\"";
					if ( count( $customInputLabels ) == $i ) {
						$option .= ' selected="selected"';
					}
					$option .= '>';
					$option .= $i;
					$option .= '</option>';
					echo $option;
				}
				?>
			</select>
		</td>
	</tr>
	<?php for ( $i = 1; $i <= $customInputFieldMaxCount; $i ++ ): ?>
		<?php
		$customInputFieldRowAttributes = ' class="wpfs-admin-form-custom-field"';
		$customInputFieldRowAttributes .= " data-row-number=\"$i\"";
		if ( $i > 1 ) {
			$customInputFieldRowAttributes .= ' style="display: none;"';
		}

		$labelId = esc_attr( "form_custom_input_label_$i" );

		$customInputLabelValue = count( $customInputLabels ) >= $i ? esc_attr( $customInputLabels[ $i - 1 ] ) : '';
		?>
		<tr valign="top" <?php echo $customInputFieldRowAttributes; ?>>
			<th scope="row">
				<label class="control-label"><?php echo esc_html( sprintf( __( 'Custom Input Label %d:', 'wp-full-stripe-admin' ), $i ) ); ?> </label>
			</th>
			<td>
				<input type="text" class="regular-text" name="<?php echo $labelId; ?>" id="<?php echo $labelId; ?>" value="<?php echo $customInputLabelValue; ?>" maxlength="<?php echo MM_WPFS_Utils::STRIPE_METADATA_KEY_MAX_LENGTH; ?>"/>
				<?php if ( $i == 1 ): ?>
					<p class="description"><?php esc_html_e( 'The text for the label next to the custom input field.', 'wp-full-stripe-admin' ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
	<?php endfor; ?>
</table>
