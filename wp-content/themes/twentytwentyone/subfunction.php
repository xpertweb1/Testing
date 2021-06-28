<?php
function user_pop_message_rgster(){
    add_menu_page( 
        __( 'User Pop Message', 'textdomain' ),
        'User Pop Message',
        'manage_options',
        'pop_message_user',
        'user_pop_message_fn',
        '',
    ); 
}
add_action( 'admin_menu', 'user_pop_message_rgster' );
 
/**
 * Display a custom menu page
 */
function user_pop_message_fn(){
	global $wpdb;
	$table_name='loginuser_popmessage';
	$qry_lg="SELECT * FROM {$wpdb->prefix}$table_name";
	$lg_rst=$wpdb->get_results($qry_lg);
	
	$pop_status=$lg_rst['0']->pop_status;
	$pop_off_time=$lg_rst['0']->pop_off_time;
	$pop_message=$lg_rst['0']->pop_message;
	if($pop_status=='1'){
		$slt_ls='selected="selected"';
	}else{$slt_ls='';}
	$msg='';
	if(isset($_GET['sucess']) and $_GET['sucess']=='1'){
		$msg='<div id="message" class="updated notice is-dismissible">
				<p>Updated Successfully.</p>
			</div>';
	}
	if(isset($_GET['fail']) and $_GET['fail']=='0'){
		$msg='<div class="notice notice-error ld-notice-error is-dismissible">
				<p>Something Wrong</p>
			</div>';
	}
	
	echo'<style>
			.fld_mn label{color:#1d2327; font-weight:bold;margin:10px 0px;display:inline-block;}
			.smt_mn{margin-top:10px;max-width:630px; text-align:right}
		</style>
		<div id="wpbody">
			'.$msg.'
			<div id="bp_main" class="bp-admin-card section-bp_main">
				<h2 class="has_tutorial_btn">Login User Pop Message </h2>
				<form method="POST" action="?page=pop_message_user">
					<input type="hidden" value="'.$lg_rst['0']->id.'" name="id">
					'.wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ).'
					 <div class="fld_mn">
						<label>Message Show:</label></br>
						<select name="pop_status" required>
							<option value="0">No</option>
							<option value="1" '.$slt_ls.'>Yes</option>
						</select>
					 </div> 
					 <div class="fld_mn" style="display:none;">
						<label>Pop Close Time:</label></br>
						<input text="" name="pop_off_time" value='.$pop_off_time.'>
					</div>
					 <div class="fld_mn">
						<label>Pop Message:</label></br>
						<textarea id="pop_message" name="pop_message" rows="10" cols="100" required>'.$pop_message.'</textarea>
					</div>
					<div class="smt_mn"><input type="submit" value="Save" class="button-primary"/></div>
				</form>';
	echo'	</div>
		</div>';
		
	if ( ! isset( $_POST['name_of_nonce_field'] ) || ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ) 
	)
	{
		
	} 
	else {
		$pop_status=$_REQUEST['pop_status'];
		$pop_off_time=$_REQUEST['pop_off_time'];
		$pop_message=$_REQUEST['pop_message'];
		$data= array(
			'pop_status'=>$pop_status,
			'pop_off_time'=>$pop_off_time,
			'pop_message'=>$pop_message
		);
        if($wpdb->update($wpdb->prefix.$table_name,$data,array("id"=>$_REQUEST['id']))){
			 $wpdb->query('DELETE  FROM '.$wpdb->prefix.'popview_user');
			print('<script>window.location.href="admin.php?page=pop_message_user&sucess=1"</script>');
		}
		else{
			print('<script>window.location.href="admin.php?page=pop_message_user&fail=0"</script>');
		}
	}

}
add_action('wp_ajax_nopriv_ajax_pop_function', 'ajax_pop_function');
add_action('wp_ajax_ajax_pop_function', 'ajax_pop_function');
function ajax_pop_function(){
	global $wpdb;
	$table_name='loginuser_popmessage';
	$query_rs= "SELECT * FROM {$wpdb->prefix}$table_name where pop_status=1";
	$relt=$wpdb->get_results($query_rs);
	$pop_message=$relt['0']->pop_message;
	
	$table_name2='popview_user';
	$usr_id=get_current_user_id();
	$relt_usr=hw_user_vw($usr_id,$table_name2);
	if(!empty($relt_usr)){
		$pop_vw='false';
	}
	else{
		$pop_vw='true';
	}
	if(!empty($relt)){
		echo json_encode(['pop_upp'=>$pop_vw, 'pop_msg'=>$pop_message]);
	}else{
		echo json_encode(['pop_upp'=>false]);
	}
	
	exit();
}
function hw_user_vw($usr_id,$table_name){
	global $wpdb;
	$qusr_id= "SELECT * FROM {$wpdb->prefix}$table_name where user_id=$usr_id";
	return $relt_usr_vl=$wpdb->get_results($qusr_id);
}
add_action('wp_ajax_nopriv_pop_userVew', 'pop_userVew');
add_action('wp_ajax_pop_userVew', 'pop_userVew');
function pop_userVew(){
	global $wpdb;
	$table_name='popview_user';
	$usr_id=get_current_user_id();
	$relt_usr=hw_user_vw($usr_id,$table_name);
	$dt=date("Y/m/d h:i:sa");
	$data= array(
		'user_id'=>$usr_id,
		'date'=>$dt,
		'view_status'=>1
	);
	if(empty($relt_usr)){
		$wpdb->insert($wpdb->prefix.$table_name,$data);
	}else{
		$wpdb->update($wpdb->prefix.$table_name,$data,array("id"=>$usr_id));
	}
	exit;
	/*	
	$pop_message=$relt['0']->pop_message;
	if(!empty($relt)){
		echo json_encode(['pop_upp'=>true, 'pop_msg'=>$pop_message]);
	}else{
		echo json_encode(['pop_upp'=>false]);
	}
	*/
	exit();
}


add_action('wp_footer', 'ajax_script' );
function ajax_script(){ ?>
	<style>
		.lgn_pp_mn {
		  display:none;
		  position:fixed;
		  z-index:1;
		  left:0;
		  top:0;
		  width:100%; 
		  height:100%;
		  overflow:auto;
		  background-color:rgb(0,0,0);
		  background-color:rgba(0,0,0,0.4); 
		}

		.mdl_cntt {
		  background-color:#fefefe;
		  margin:15% auto;
		  padding:20px;
		  border:1px solid #888;
		  width:100%; 
		  max-width:590px;
		}
		.cls {
		  color:#aaa;
		  float:right;
		  font-size:28px;
		  font-weight:bold;
		}
		.cls:hover,
		.cls:focus {
		  color:black;
		  text-decoration:none;
		  cursor:pointer !important;
		}
	</style>
	<script>
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		jQuery(document).ready(function() {
			jQuery("footer").after('<div class="lgn_pp_mn"><div class="mdl_cntt"><span class="cls">&times;</span> <p class="msg_bx"></p></div></div>');
			function auto_hit_ajx(){
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
						data: {
							action:'ajax_pop_function'
						},
					success: function (data2) {
						var data2 = $.parseJSON(data2);
						if (data2.pop_upp=='true'){
							jQuery(".lgn_pp_mn").show();
							jQuery('.msg_bx').text(data2.pop_msg);
							
						}else{
							jQuery(".lgn_pp_mn").hide();
						}	
					   
					}
				});
			};	
			function pop_userVew(){
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
						data: {
							action:'pop_userVew'
						},
					success: function (data2) {
							//alert("hello");  
					}
				});
			};
			jQuery(".cls").click(function(){
				pop_userVew();
				jQuery(".lgn_pp_mn").hide();
			});
			/* jQuery(".button-primary").click(function(){
				jQuery(".lgn_pp_mn").show();
				jQuery(".lgn_pp_mn").add();
			}); */
			
			setInterval(auto_hit_ajx,3000);
		});
		
	</script>	
<?php		
}
?>