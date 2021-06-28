<?php
 /*Template Name: thank template */
 
get_header(); 




//require_once('http://localhost/property/wp-load.php');

global $wpdb;

$location = $_POST['location'];
$abitazione = $_POST['abitazione'];
$table_name = $wpdb->prefix . "calculator";
$wpdb->insert( $table_name, array(
    'location' => $name,
    'abitazione' => $email
) );