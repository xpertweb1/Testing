<?php
 /*Template Name: Calculator template */
 
get_header(); 


?>

<div id="primary">
    <div id="content" role="main">
		<div id="container" onload="initialize()">
      <?php while ( $loop->have_posts() ) : $loop->the_post();?>	<?php endwhile; ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
         <!-- New Post Form -->
		 <?php

require_once('/wp-config.php');
global $wpdb;
if ( isset( $_POST['submit'] ) ){
$wpdb->insert( 'wp_post_job', array(
'fname' => $_POST['fname'],
'lname' => $_POST['lname'],
'email' => $_POST['email'],
'city' => $_POST['city'],
array( '%s', '%s', '%s', '%s')
);
}
		 ?>
	
       <form action="http://localhost/property/thank-you/" method="post" name="calculator" id="calculator" enctype="multipart/form-data">
 
        <label><b>Location</b></label>

        <select name="location" required class="location" id="location" data-amount>
		  <option value="70">ABRUZZO</option>
		  <option value="65">BASILICATA</option>
		  <option value="78">CALABRIA</option>
		  <option value="78">CAMPANIA</option>
		  <option value="65">FRIULI</option>
		  <option value="98">LAZIO</option>
		  <option value="98">MARCHE</option>
		  <option value="78">MOLISE</option>
		  <option value="56">PUGLIA</option>
		  <option value="88">SARDEGNA</option>
		  <option value="77">SICILIA</option>
		  <option value="56">TOSCANA</option>
		</select>

		<br>
		<label><b>Superficie (Mq) :</b></label>
        <br>
        <input placeholder="Abitazione" type="number" name="abitazione" id="abitazione" data-amount>
		<input placeholder="Mansarda" type="number" value="" name="mansarda" id="mansarda" data-amount>
		<input placeholder="Taverna" type="number" value="" name="taverna" id="taverna" data-amount>
		<input placeholder="Balconi" type="number" value="" name="balconi" id="balconi" data-amount>
		<input placeholder="Terrazzo" type="number" value="" name="terrazzo" id="terrazzo" data-amount><br>


        <label for="Category">Indirizzo:</label><br>
        <input type="text" name="indirizzo" placeholder="Indirizzo" class="indirizzo" id="indirizzo" data-amount><br>
		 
		<label for="Category">Numero Civico:</label><br>
        <input type="text" placeholder="Enter Piano" name="piano" class="piano" id="piano" data-amount><br>
		
		<label for="Category">Totale piani edificio:</label><br>
		<input type="text" placeholder="piani edificio" name="edificio" class="edificio" id="edificio" data-amount><br>
		
		<label><b>Anno Costruzione:</b></label><br>
        <select name="costruzione" required class="costruzione" id="costruzione" data-amount>
		  <option value="-2%">Before 1990 </option>
		  <option value="">Between 1990 - 2009</option>
		  <option value="+2%">After 2010</option>
		</select><br>
		
		<label><b>Anno Ultima Ristrutturazione:</b></label><br>
		
		before 1990 <input type="radio" name="ristrutturazione" value="before 1990 " class="ristrutturazione" id="ristrutturazione" data-amount>
		Between 1990 - 2009 <input type="radio" name="ristrutturazione" value="Between 1990 - 2009 " class="ristrutturazione" id="ristrutturazione" data-amount>
		After 2010 <input type="radio" name="ristrutturazione" value="After 2010 " class="ristrutturazione" id="ristrutturazione" data-amount>
       <br>
		
		<label><b>Stato immobile :</b></label><br>
        <select name="immobile" required class="immobile" id="immobile" data-amount>
		  <option value="+2%">Nuovo</option>
		  <option value="+1%">Ottimo</option>
		  <option value="">Buono</option>
		  <option value="-1%">Abitabile</option>
		  <option value="-1%">Da Ristrutturare</option>		  
		</select><br>
		
		<label><b>Riscaldamento :</b></label><br>
        <select name="riscaldamento" class="riscaldamento" id="riscaldamento" data-amount>
		  <option value="">Centralizzato</option>
		  <option value="">Autonomo</option>
		  <option value="">Assente</option>
		</select><br>
		
		<label><b>Tipologia impianto riscaldamento:</b></label><br>
        <select name="impianto" required class="impianto" id="impianto" data-amount>
		  <option value="+1%">A Radiatori</option>
		  <option value="">A Pavimento</option>
		  <option value="">Ad Aria</option>
		</select><br>		
		
				 
        <label class="control-label">Property Images</label>
        <input type="file" name="images1" id="loader_img"/><input type="file" name="images2" id="loader_img"/><input type="file" name="images3" id="loader_img"/><br>
		
		<label class="control-label">Property Plan Image</label>
        <input type="file" name="img_size" id="loader_img"/><br>
		
     <br><br><input type = "submit" name="submit" id="" class="submitbtn" value="submit">			  

 </form>
 <br><br> Result <input type="text" id="result">


    <script>
 /*     $(document).ready(function() {
			alert(121);
			  $('#calculator').submit(function(e){
    e.preventDefault();
    $("#location, #abitazione").keyup(function() {
        var p = $("#location").val();
        var q = $("#abitazione").val();
        $("#result").val(q * p);
    });
}); */
		/* 	
            var main = $('#location').val();
            var disc = $('#abitazione').val();
            //var dec = (disc / 100).toFixed(2); //its convert 10 into 0.10
            var mult = main * disc; // gives the value for subtract from main value
            //var discont = main - mult;
            $('#result').val(mult); */
        });
    </script>

            <!-- Display movie review contents -->
            <div class="entry-content"><?php //the_content(); ?></div>
        </article>
     
  
    </div>
	</div>
</div>


<?php wp_reset_query(); ?>
<?php get_footer(); ?>


<script>


/* 
$(document).ready(function() {
    $('#calculator').submit(function(e){
    e.preventDefault();

    var total = 0;
    var amount = '[data-amount]';

    $(amount).each(function(index){
        total += parseInt($(this).val());
    });

    $("#result-container").html(total);
    $("#result-container").show();
    $("calculator").hide();
    return false;
    })
}); */
</script>


     <script>
/* 
			jQuery(document).ready(function($){
				$('#calculator').submit(function(e){
					e.preventDefault();
					
					var title = $("#t1").val();
					var desc = $("#d1").val();
					var cat = $("#c1").val();
					var address = $("#a1").val();
					var city = $("#city1").val();
					var state = $("#state").val();
					var formData=new FormData($("#calculator")[0]);
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
			
			}); */

    </script>
