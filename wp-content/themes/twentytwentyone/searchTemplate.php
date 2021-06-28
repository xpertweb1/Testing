<?php
/*Template Name: Search template */

get_header(); 


?>

<div id="primary">
	<div id="content" role="main">
	<div id="container">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



		<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
	<?php
		if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) : 
 
			echo '<select name="categoryfilter"><option value="">Select category...</option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
			endforeach;
			echo '</select>';
		endif;
	?>
					<input type="text" placeholder="Search City" name="city" class="city" id="city">
					<input type="text" placeholder="Search State" name="state" class="state" id="state">
					<button>Apply filter</button>
					<input type="hidden" name="action" value="myfilter">
		</form>
		<div id="response"></div>



			<!-- Display movie review contents -->
			<div class="entry-content"><?php //the_content(); ?></div>
		</article>

	</div>
	</div>
</div>


<?php wp_reset_query(); ?>
<?php get_footer(); ?>

<script>

jQuery(function($){
	$('#filter').submit(function(){
		var filter = $('#filter');
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(xhr){
				filter.find('button').text('Processing...'); // changing the button label
			},
			success:function(data){
				filter.find('button').text('Apply filter'); // changing the button label back
				$('#response').html(data); // insert data
			}
		});
		return false;
	});
});

</script>

	<!--<script>
		jQuery(document).ready(function($){
			//alert(1212);
			$('#search_post').submit(function(e){
				
				e.preventDefault();
				 		 
				var city = $("#city1").val();
				var state = $("#state").val();
				var formData=new FormData($("#search_post")[0]);
				var ajaxurl = "<?php //echo admin_url('admin-ajax.php'); ?>";
			 
				$.ajax({ 
					 type: 'POST',
					 data:formData,
                     processData: false,
				     contentType: false,
					 url: ajaxurl+'?action=Search_custom_post_data',

					 success: function(response) {
						//alert(21212);
					  console.log(response);
							
					}
					
				}); 
			});
			
		});

	</script>-->
