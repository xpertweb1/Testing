<?php
/*
 Template Name: Insert
 */

get_header();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<form method="POST" action="#">
<input type="text" name="name">
<input type="email" name="email">
<input type="submit" name="submited"  value="true">
</form>
<?php
if(isset($_POST['submited'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	global $wpdb;
	$sql=$wpdb->insert("insertData",array("name"=>$name, "email"=>$eamil));

	if ($sql==true){
		echo"<script>alert('Inserted')</script>";
		
	}else{
		echo"<script>alert('not Inserted')</script>";
	}
}
 ?>
<?php
get_footer();
