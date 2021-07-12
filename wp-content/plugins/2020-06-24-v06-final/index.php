<?php 
/**
 * Plugin Name: Mark Type plugin
 */
ob_start();
require('inc/taxonomy-icons.php');

require('setting.php');
require('activate.php');
//hook into the init action and call create_book_taxonomies when it fires
//add_action( 'init', 'create_topics_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it topics for your posts

      add_action( 'init', 'create_topics_hierarchical_taxonomy', 0 );

register_activation_hook( __FILE__, 'pluginUninstall');

    function pluginUninstall() {
      global $wpdb;


      add_action( 'init', 'create_topics_hierarchical_taxonomy', 0 );



    }






 
function create_topics_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Marktype', 'taxonomy general name' ),
    'singular_name' => _x( 'Marktype', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Marktypes' ),
    'all_items' => __( 'All Marktypes' ),
    'parent_item' => __( 'Parent Marktype' ),
    'parent_item_colon' => __( 'Parent Marktype:' ),
    'edit_item' => __( 'Edit Marktype' ), 
    'update_item' => __( 'Update Marktype' ),
    'add_new_item' => __( 'Add New Marktype' ),
    'new_item_name' => __( 'New Marktype Name' ),
    'menu_name' => __( 'Marktypes' ),
  );    
 
// Now register the taxonomy
   $postype=array();
 $postypes=get_option('post_allowed');

if(empty($postypes))
{

                              $args = array(
                     'public'   => true,
                     '_builtin' => true
                );

                  $show_post_types = get_post_types( $args );

                    foreach ( $show_post_types as $type ) {
                    if($type!='attachment')
                    {
            
                      array_push($postype,$type);
            

                    }
                  }
}
else
{
     $postype=get_option('post_allowed');

}


  register_taxonomy('marktypes',$postype, array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'marktype' ),
	'public' => false,
	'show_in_rest' => true,
  ));


if ( get_option( 'my_run_only_once_01' ) != 'completed' ) {


// The term to add or update. 
$term = 'Produktempfehlung'; 
  
// The taxonomy to which to add the term. 
$taxonomy = 'marktypes'; 
  
// Optional. Array or string of arguments for inserting a term. 
$args = array( 
    'alias_of' => '', 
    'description' => 'In diesem Artikel erwähnen und empfehlen wir Produkte ohne dass wir dafür finanzielle oder geldwerte Leistung erhalten haben. <a href="google.com">mehr Informationen</a>', 
    'parent' => 0 
); 
  
// NOTICE! Understand what this does before running. 
$result = wp_insert_term($term, $taxonomy, $args); 

if(!empty($result->error_data['term_exists']))
{
  $ctermid=$result->error_data['term_exists'];
}
else
{
  $ctermid=$result['term_id'];
}

if(!empty($ctermid))
{
  $term_meta=array('term_icon'=>'fa fa-info-circle');
  update_option( 'tax_term_icon_' .$ctermid, $term_meta );
}






// The term to add or update. 
$term1 = 'Enthält Affiliate Links'; 
  
// The taxonomy to which to add the term. 
$taxonomy1 = 'marktypes'; 
  
// Optional. Array or string of arguments for inserting a term. 
$args1 = array( 
    'alias_of' => '', 
    'description' => ' Dieser Artikel enthält sogenannte Affiliatelinks von unseren Partnern wie z.B. Amazon. Wenn über diesen Link Produkte gekauft werden erhalten wir ggf. eine Provision. <a href="google.com">mehr Informationen</a>', 
    'parent' => 0 
); 
  
// NOTICE! Understand what this does before running. 
$result1 = wp_insert_term($term1, $taxonomy1, $args1); 

if(!empty($result1->error_data['term_exists']))
{
  $ctermid1=$result1->error_data['term_exists'];
}
else
{
  $ctermid1=$result1['term_id'];
}

if(!empty($ctermid1))
{
  $term_meta1=array('term_icon'=>'fa fa-amazon');
  update_option( 'tax_term_icon_' .$ctermid1, $term_meta1 );
}






  

// The term to add or update. 
$term2 = 'Produktplatzierung'; 
  
// The taxonomy to which to add the term. 
$taxonomy2 = 'marktypes'; 
  
// Optional. Array or string of arguments for inserting a term. 
$args2 = array( 
    'alias_of' => '', 
    'description' => 'Wir haben ein oder mehrere der erwähnten Produkte zur Verfügung gestellt bekommen <a href="google.com">mehr Informationen</a>', 
    'parent' => 0 
); 
  
// NOTICE! Understand what this does before running. 
$result2 = wp_insert_term($term2, $taxonomy2, $args2); 

if(!empty($result2->error_data['term_exists']))
{
  $ctermid2=$result2->error_data['term_exists'];
}
else
{
  $ctermid2=$result2['term_id'];
}

if(!empty($ctermid2))
{
  $term_meta2=array('term_icon'=>'fa fa-info-circle');
  update_option( 'tax_term_icon_' .$ctermid2, $term_meta2 );
}         
  
  





// The term to add or update. 
$term3 = 'Anzeige / Werbung'; 
  
// The taxonomy to which to add the term. 
$taxonomy3 = 'marktypes'; 
  
// Optional. Array or string of arguments for inserting a term. 
$args3 = array( 
    'alias_of' => '', 
    'description' => 'Wir haben ein oder mehrere der erwähnten Produkte zur Verfügung gestellt bekommen <a href="google.com">mehr Informationen</a>', 
    'parent' => 0 
); 
  
// NOTICE! Understand what this does before running. 
$result3 = wp_insert_term($term3, $taxonomy3, $args3); 

if(!empty($result3->error_data['term_exists']))
{
  $ctermid3=$result3->error_data['term_exists'];
}
else
{
  $ctermid3=$result3['term_id'];
}

if(!empty($ctermid3))
{
  $term_meta3=array('term_icon'=>'fa fa-cc-mastercard');
  update_option( 'tax_term_icon_' .$ctermid3, $term_meta3 );
}         






  
        update_option( 'my_run_only_once_01', 'completed' );
    }



 
}

register_deactivation_hook( __FILE__, update_option( 'my_run_only_once_01', 'proceed' ) );

function property_slideshow( $title ) {


  $postype=array();
 $postypes=get_option('post_allowed');

if(empty($postypes))
{

                              $args = array(
                     'public'   => true,
                     '_builtin' => true
                );

                  $show_post_types = get_post_types( $args );

                    foreach ( $show_post_types as $type ) {
                    if($type!='attachment')
                    {
            
                      array_push($postype,$type);
            

                    }
                  }
}
else
{
  $postype=get_option('post_allowed');
}

$show_location=get_option('show_location');
$custom_content='';

  //  if ( is_single() && in_the_loop() && !is_archive() ) {



        if(in_array(get_post_type(), $postype)){


global $post;
$term_list = get_the_terms($post->ID, 'marktypes');
$types ='';
$markids=array();
 if(!empty($term_list))
 {

    foreach($term_list as $term_single) {
   // print_r($term_single->term_id);
   $markids[]=$term_single->term_id;
   $taxico=tax_icons_output_term_icon( $term_single->term_id, 'extra-class' );





    
   //  $types .= '<div class="tooltip">'.ucfirst($term_single->name).' '.$taxico.'<span class="tooltiptext">'.$term_single->description.'</span></div> ';

   $types.='<div class="con-tooltip top"><p>'.ucfirst($term_single->name).' '.$taxico.'</p><div class="tooltip "><p>'.$term_single->description.'</p></div></div>';

}

 }





$args = array(

'exclude' => $markids,

'taxonomy'  => 'marktypes',
);
$markterms = get_terms( $args );




if(!empty($markterms))
{

  foreach ($markterms as $key => $value) {
    
 

      $term_meta = get_option( 'enable_marktype_global_' . $value->term_id );
  $term_meta=$term_meta['enable_marktype_global'];


  if($term_meta)
  {

   $taxico=tax_icons_output_term_icon( $value->term_id, 'extra-class' );





    
   //  $types .= '<div class="tooltip">'.ucfirst($term_single->name).' '.$taxico.'<span class="tooltiptext">'.$term_single->description.'</span></div> ';

   $types.='<div class="con-tooltip top"><p>'.ucfirst($value->name).' '.$taxico.'</p><div class="tooltip "><p>'.$value->description.'</p></div></div>';
  }

  }




}











$typesz = rtrim($types, ', ');






        if($show_location=='show_above' || $show_location=='show_both')
        {


              $custom_content.='<div class="con">';
             $custom_content.= $typesz;
             $custom_content.='</div>';
       
        }
        $custom_content .= $title;
        if($show_location=='show_below' || $show_location=='show_both')
        {
             
              $custom_content.='<div class="con">';
             $custom_content.= $typesz;
             $custom_content.='</div>';
       
        }




             $styling='

             .con-tooltip.top p {
    margin: 0;
}


.con-tooltip.top {
    display: inline-block;
    border: 1px solid #ddd;
    color: #999;
    background-color: white;
    font-family: "Open Sans", "Source Sans Pro", "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    padding: 0.1rem .3rem !important;
    text-transform: uppercase;
    font-size: 11px;
    border-radius: 0;
    font-weight: bold;
    margin: 0 .4rem .2rem 0;
}
/*tooltip Box*/
.con-tooltip {

  position: relative;
  background: #F2D1C9;
  
  border-radius: 9px;
  padding: 0 20px;
  margin: 10px;
  
  display: inline-block;
  
  transition: all 0.3s ease-in-out;
  cursor: default;

}

/*tooltip */
.tooltip {
    font-size: 11px;
    visibility: hidden;
    font-weight: 100;
    z-index: 1;
    opacity: .40;
    text-transform: capitalize;
    width: 100%;
    padding: 10px 10px;
    background: #ddd;
    color: #000;
    position: absolute;
    bottom: 42px;
    left: 0%;
    border-radius: 9px;
    font: 16px;
    transform: translateY(9px);
    transition: all 0.3s ease-in-out;
}
.tooltip a {
    color: #000;
}

/* tooltip  after*/
.tooltip::after {
    content: " ";
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 12px 12.5px 0 12.5px;
    border-color: #ddd transparent transparent transparent;
    position: absolute;
    left: 40%;
    bottom: -9px;
}

.con-tooltip:hover .tooltip{
  visibility: visible;
  transform: translateY(-10px);
  opacity: 1;
    transition: .3s linear;
  animation: odsoky 1s ease-in-out infinite  alternate;

}
@keyframes odsoky {
  0%{
    transform: translateY(6px); 
  }

  100%{
    transform: translateY(1px); 
  }

}

.top:hover {transform: translateY(-6px);  }


';


        $marktypecss=get_option('marktypcss');



        if(!empty($marktypecss))
        {
            $styling=$marktypecss;
        }






         if(!empty($styling))
         {
              $custom_content.='<style>';
              
              $custom_content.=$styling;
              $custom_content.='</style>';  
         }


        
        return $custom_content;

        }
        else
        {
            return$title;
        }
    

  //  } else {
  //      return $title;
  //  }
}
add_filter( 'the_content', 'property_slideshow' );






?>