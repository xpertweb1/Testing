<?php
 /*Template Name: Proprty template */
 
get_header(); 


?>

<div id="primary">
    <div id="content" role="main">
		<div id="container" onload="initialize()">
    <?php
	

    $mypost = array( 'post_type' => 'property', );
    $loop = new WP_Query( $mypost );
    ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post();?>	<?php endwhile; ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
         <!-- New Post Form -->
		 
		 
		<p class="sucs_msg"></p>
		<p class="err_msg"></p>
       <form action="" method="post" class="ajax" name="new_post" id="new_post" enctype="multipart/form-data">

        
        <label><b>Title</b></label>

         <input type="text" placeholder="Enter Your Title" name="name" required class="name" id="t1">
		  
		  <!-- post Category -->
       <label for="Category">Category:</label>

         <!--<input type="text" placeholder="Enter Your Category" name="category" required class="category" id="c1">-->
		  <select name="category" required class="category" id="c1">
		  <option>Commercial</option>
		  <option>Residential</option>
		  </select>
		 
           <label class="control-label">Upload Post Image</label>

			<input type="file" name="images" id="loader_img"/>

			<br>
			
			<label for="Category">Location:</label>
			
		<!--	<input type="text" name="latitude" id="latitude" placeholder="latitude">
			<input type="text" name="longitude" id="longitude" placeholder="longitude">-->
              <input placeholder="Latitude, Longitude" type="text" value="30.9986127, 73.1565595" name="txt_latlng" id="txt_latlng" >
           <div id="map_canvas" style="width:600px;height:400px;border:solid black 1px;"></div>



         <label for="Category">Address:</label>

         <input type="text" name="address" placeholder="Address" class="address" id="a1">
		 <input type="text" placeholder="Enter City" name="city" class="city" id="city">
		 <input type="text" placeholder="Enter State" name="state" class="state" id="state">
		  <br>
          <label><b>Description</b></label>

          <textarea placeholder="Description" name="message" required class="message" id="d1"></textarea>		
          		     <div id="map"></div>
           <input type = "submit" name="submit" id="" class="submitbtn" value="submit">			  
		   <div id="result"> </div>
		
		
 </form>

   <button type="button" onclick="resetForm();"> Reset Button</button>
            <!-- Display movie review contents -->
            <div class="entry-content"><?php //the_content(); ?></div>
        </article>
     
  
    </div>
	</div>
</div>


<?php wp_reset_query(); ?>
<?php get_footer(); ?>

<script>
function resetForm() {
    document.getElementById("new_post").reset();
}
</script>

 <script>
// Map Initialize function
function initialize()
{
 // Set static latitude, longitude value
 var latlng = new google.maps.LatLng(30.9986127, 73.1565595);
 // Set map options
 var myOptions = {
 zoom: 16,
 center: latlng,
 panControl: true,
 zoomControl: true,
 scaleControl: true,
 mapTypeId: google.maps.MapTypeId.ROADMAP
 }
 // Create map object with options
 map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
 // Create and set the marker
 marker = new google.maps.Marker({
 map: map,
 draggable:true,
 position: latlng
 });
 
 // Register Custom "dragend" Event
 google.maps.event.addListener(marker, 'dragend', function() {
 
 // Get the Current position, where the pointer was dropped
 var point = marker.getPosition();
 // Center the map at given point
 map.panTo(point);
 // Update the textbox
 document.getElementById('txt_latlng').value=point.lat()+", "+point.lng();
 });
}
 </script>


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
