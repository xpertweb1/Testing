<?php
 /*Template Name: Test */
 
get_header(); 
?>
<div id="primary">
    <div id="content" role="main">
	
	<form action="" id="new_post">
	<input type="text" name="name" id="t1" placeholder="Enter Name">
	<input type="submit" value="submit">
	
	</form>
	</div>
	</div>
       
<?php get_footer(); ?>
<script>
	jQuery(document).ready(function($){
				$('#new_post').submit(function(e){
					e.preventDefault();
					  // $('#someHiddenDiv').show();
					
					var title = $("#t1").val();
					var desc = $("#d1").val();
					var cat = $("#c1").val();
					var address = $("#a1").val();
					var city = $("#city1").val();
					var state = $("#state").val();
					var formData=new FormData($("#new_post")[0]);
					$("#loader_img").show();
					var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				 
					$.ajax({ 
						 //data: {action: 'Submit_custom_post_data', name:title , message:desc , category:cat },
						 //data: {action: 'Submit_custom_post_data', formData },
						 type: 'POST',
						 data:formData,
						 cache:false,
						 contentType: false,
						 processData: false,
						 url: ajaxurl+'?action=Submit_custom_post_data',

						 success: function(response) {
							
							if(response == "OK") 
							{
								
									jQuery('.err_msg').text('');	
									jQuery('.sucs_msg').text('Successfully add post');						
									
											
							}
							else if(response == "Exist")
							{
								
									jQuery('.sucs_msg').text('');
									jQuery('.err_msg').text('Already Exist'); 
																
							
							}
								
						}
						
					}); 
					
				 
			 return false;

				})
				
			});

</script>