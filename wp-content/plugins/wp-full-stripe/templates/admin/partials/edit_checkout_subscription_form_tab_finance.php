<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.08.25.
 * Time: 18:28
 */
?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Collect Billing Address?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_show_address_input" id="hide_address_input" value="0" <?php echo ( $form->showBillingAddress == '0' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'Hide', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_show_address_input" id="show_address_input" value="1" <?php echo ( $form->showBillingAddress == '1' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'Show', 'wp-full-stripe-admin' ); ?>
			</label>

			<p class="description"><?php esc_html_e( 'Should this form also ask for the customers billing address?', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
</table>
