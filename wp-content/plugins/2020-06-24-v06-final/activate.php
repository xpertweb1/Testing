<?php 
$myvar = 'whatever';

function myplugin_activate() {

echo 'fghfhfghfghfg';
exit;
}

register_activation_hook( __FILE__, 'myplugin_activate' );