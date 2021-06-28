<?php 
/*
Plugin Name: Property Calculator
Description: Calculate the Property of switching over to our service.
Version: 1.0
Author: Douglas Karr
Author URI: http://www.dknewmedia.com
*/

// Initialize the plugin and add the menu
add_action( 'admin_menu', 'sc_add_admin_menu' );
add_action( 'admin_init', 'sc_settings_init' );

// Add an Admin Menu option for Settings
function sc_add_admin_menu( ) {
add_options_page( 'Property Calculator', 'Property Calculator',
'manage_options', 'savings_calculator', 'savings_calculator_options_page' );
}

// Add the Property Calculator settings to the Settings Page
function sc_settings_init( ) {
register_setting( 'pluginPage', 'sc_settings' );
add_settings_section(
'sc_pluginPage_section',
__( 'Settings Page', 'sc_' ),
'sc_settings_section_callback',
'pluginPage'
);
add_settings_field(
'sc_oldamount',
__( 'Amount', 'sc_' ),
'sc_oldamount_render',
'pluginPage',
'sc_pluginPage_section'
);
}

// Set the settings input field to render
/* function sc_oldamount_render() {
$options = get_option( 'sc_settings' );
?>
<input name="sc_settings[sc_oldamount]" type="text" value="<?php echo $options['sc_oldamount']; ?>">
<?php
} */

// Build the Administrative form to save the default amount
function savings_calculator_options_page() {
?>
<form action='options.php' method='post'>
<h2>Savings Calculator</h2>
<?php
settings_fields( 'pluginPage' );
do_settings_sections( 'pluginPage' );
submit_button();
?>
</form>
<h3>Savings Calculator Usage</h3>
<p>Examples of shortcode usage:</p>
<ul>
<li><strong>[savingscalculator symbol="$"]</strong> - publishes the form using the US dollar sign to the left of the currency amount.</li>
<li><strong>[savingscalculator amount="9.99" symbol="$"]</strong> - publishes the form calculated to the custom amount rather than default.</li>
<li><strong>[savingscalculator symbol="$"]Fill in the Amount You Are Currently Paying:[/savingscalculator]</strong> - publishes the form with instructions before the form.</li>
<li><strong>[savingscalculator position="right" symbol=" ¥"]</strong> - publishes the form using the US dollar sign to the left of the currency amount.</li>
</ul>
<?php
}


// Register and return the shortcode
function savingscalculator( $atts, $content = null ) {
//if( is_array( $atts ) ) extract($atts);
//$options = get_option( 'sc_settings' );
if($amount == null ) { $location = $_POST['location']; } else { $location = $amount; }
return $content.sc_buildform($position, $symbol, $location);
}
add_shortcode('savingscalculator', 'savingscalculator');

// Build the form to display
function sc_buildform($position, $symbol, $location) {
if(is_numeric($_POST['location'])) {
$location = $_POST['location'];
$abitazione = $_POST['abitazione'];
$mansarda = $_POST['mansarda'];
$taverna = $_POST['taverna'];
$balconi = $_POST['balconi'];
$terrazzo = $_POST['terrazzo'];
$giardino = $_POST['giardino'];
$indirizzo = $_POST['indirizzo'];
$numero_civico = $_POST['numero_civico'];
$piano = $_POST['piano'];
$totale_piani_edificio = $_POST['totale_piani_edificio'];
$before = $_POST['before'];
$between = $_POST['between'];
$after = $_POST['after'];

}
$sc_form = '<form id="savingscalculator" action="'.get_permalink().'" method="post" name="savingscalculator">';
if ( !empty($_POST) && !is_numeric($location) ) { $sc_form .= 'You must enter a numeric amount.'; }
$sc_form .= '';
$sc_form .= '<label for="location">Location </label> :';
$sc_form .= '<select id="location" tabindex="1" maxlength="10" name="location" value="" class="">
<option value="70">Abruzzo</option>
<option value="65">Basilicata</option>
<option value="78">Calabria</option>
<option value="78">Campania</option>
<option value="65">Friuli</option>
<option value="98">Lazio</option>
<option value="98">Marche</option>
<option value="78">Molise </option>
<option value="56">Puglia </option>
<option value="88">Sardegna </option>
<option value="77">Sicilia </option>
<option value="56">Toscana </option>
</select>
';
$sc_form .= '<br><label for="superficie">Superficie (Mq </label> :<br>';
$sc_form .= '<input id="abitazione" placeholder="Abitazione" name="abitazione" type="number" value="'.$abitazione.'" class="">
<input id="mansarda" required placeholder="Mansarda" name="mansarda" type="number" value="'.$mansarda.'" class="">
<input id="taverna" required placeholder="Taverna" name="taverna" type="number" value="'.$taverna.'" class="">
<input id="balconi" required placeholder="Balconi" name="balconi" type="number" value="'.$balconi.'" class="">
<input id="terrazzo" required placeholder="Terrazzo" name="terrazzo" type="number" value="'.$terrazzo.'" class="">
<input id="giardino" required placeholder="Giardino" name="giardino" type="number" value="'.$giardino.'" class="">

<br><label for="indirizzo">Indirizzo </label> :<br>
<input id="Indirizzo" type="text" value="" placeholder="Indirizzo" name="indirizzo">

<br><label for="indirizzo">Numero civico: </label> <br>
<input id="numero_civico" type="text" value="" placeholder="Numero civico" name="numero_civico">
<input id="piano" type="text" value="" placeholder="Piano" name="piano">
<br><label for="indirizzo">Totale piani edificio: </label> <br>
<input id="totale_piani_edificio" type="text" value="" placeholder="Totale piani edificio:" name="totale_piani_edificio:">

<br><label for="costruzione">Anno Costruzione: </label> <br>
<span>
<input id="before" type="radio" value="1.4" name="before">Before 1990</span><br>
<span>
<input id="between" type="radio" value="" name="between">Between 1990 - 2009</span><br>
<span>
<input id="after" type="radio" value="1.4" name="after">after 2010</span><br>
';

$sc_form .= '<input id="submit" tabindex="2" type="submit" value="Submit">';
$sc_form .= '';
$sc_form .= '';
if (!empty($_POST) ) {
$sc_diff = round($location * ($abitazione + $mansarda + $taverna + $balconi + $terrazzo + $giardino) - ($before) + ($after), 2);

//$sc_percent = round(($sc_newamount - $location) * 100 / $location, 1);
if($position=="right") {
$sc_currency = $sc_diff.$symbol;
$sc_oldamount = $location.$symbol;
} else {
$sc_currency = $symbol.$sc_diff;
$sc_oldamount = $symbol.$location;
}
if($sc_diff > 0) {
$sc_form .= '
<br>
Price '.$sc_currency.' Location price is '.$sc_oldamount.'!
';
} elseif ($sc_diff == 0) {
$sc_form .= '
<br>
Well, you\’re already getting a great deal over our price of '.$sc_oldamount.' and aren\’t going to save anything.

';
}
}
return $sc_form;
}