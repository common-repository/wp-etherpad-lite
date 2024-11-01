<?php
/**
 * Plugin Name: WP Etherpad Lite
 * Plugin URI:  http://wordpress.org/extend/plugins/wp-etherpad-lite/
 * Description: Network administrator(s) may set up a connection to a Etherpad host and the WordPress users may display the etherpad using a simple shortcode on a post or page
 * Author:      ctlt-dev, ubcdev, michaelha
 * Version:     0.1
 * Author URI:  http://ctlt.ubc.ca/
 * Network:     true
 */

//load the jquery etherpad lite plugin
function etherpad_js_init_method() {
    wp_deregister_script( 'etherpad' );
    wp_register_script( 'etherpad', plugins_url('/js/etherpad.js', __FILE__) );;
    wp_enqueue_script( 'etherpad' );
}    
 
add_action('wp_enqueue_scripts', 'etherpad_js_init_method');

//load jquery
add_action('init', 'load_jquery');

function load_jquery(){
	wp_enqueue_script( 'jquery' );
}

//create a shortcode to display the etherpad
add_shortcode('wp_ep', 'display_etherpad_func');

function display_etherpad_func() {
	if ( is_null(get_site_option('wp_ep_host_url'))) {
		echo "<div style=''>WP Etherpad is not configured correctly!</div>";
	} else {
?>
	<div id="showEtherPadLite"></div>
	
<script type="text/javascript">
	jQuery(document).ready(function($){
	<?php global $current_user; get_currentuserinfo(); ?>
	
	// The most basic example
	$('#showEtherPadLite').pad({'padId':'test', 'userName':'<?php echo $current_user->user_login; ?>', 'width':'600px', 'height':'600px', 'showControls':'true'}); // sets the pad id and puts the pad in the div
});
	</script>
<?php
	}
}