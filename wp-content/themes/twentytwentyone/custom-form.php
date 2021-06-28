<?php
/**
/* Template Name: Custom Form
*
*
*	@package WordPress
*/
get_header(); ?>
<?php
        if (!empty($_POST)) {
        global $wpdb;
            $table = request;
            $data = array(
                'Name'    => $_POST['your-name'],
				'Email'    => $_POST['your-email'],
				'Service'    => $_POST['Service'],
				'Date'    => $_POST['date'],
				'Address'    => $_POST['address'],
				'Phone'    => $_POST['tel'],
				'Message'    => $_POST['your-message']
            );
            $format = array(
                '%s','%s','%s','%s','%s','%s','%s'
            );
            $success=$wpdb->insert( $table, $data, $format );
            if($success){
				echo '<h3>Your request successfully send to HomeFix! Our Staff will contact you!</h3>' ; 
			}
		}
		else   { ?>
	<div id="primary" class="content-area">
		<form method="post">
		<p><label> Your Name<br />
			<input type="text" name="your-name" value="" size="40" /></label></p>
		<p><label> Your Email<br />
			<input type="email" name="your-email" value="" size="40"/></label></p>
		<p><label> Select Service<br />
			<select name="Service">
				<option value="Plumber">Plumber</option>
				<option value="Electrician">Electrician</option>
				<option value="Carpenter">Carpenter</option>
				</select>
			</label></p>
		<p><label> Date <br />
			<input type="date" name="date" value="" placeholder="Select Date" /></label></p>
		<p><label> Your Address<br />
			<textarea name="address" cols="40" rows="10"></textarea></label></p>
		<p><label> Your Phone Number<br />
			<input type="tel" name="tel" value="" size="40" placeholder="Mobile Number" /></label></p>
		<p><label> Your Message <br />
			<textarea name="your-message" cols="10" rows="10" ></textarea></label></p>
		<p><input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit" /></p>
		</form>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
	<?php }  ?>
<?php get_footer(); ?>