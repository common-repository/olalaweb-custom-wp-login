<?php
/*
    Plugin Name: OlalaWeb - Custom WP Login
    Plugin Script: ola-ll.php
    Plugin URI: http://olalaweb.com/plugins/
    Description: Customize the logo displayed on wp-login.php without having to edit any php file ;)
    Author: OlalaWeb 
    Donate Link: http://olalaweb.com/donate/
    License: GPL    
    Version: 1.0
    Author URI: http://olalaweb.com/
    Text Domain: olalaweb
    Domain Path: languages/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* ---------------------------------------------------------------------------------- 
GLOBAL STUFF
   ---------------------------------------------------------------------------------- */
define('OLA_LL_PLUGIN_URL', plugin_dir_url(__FILE__ ));
define('OLA_LL_PLUGIN_DIR', plugin_dir_path(__FILE__ ));
define('OLA_LL_SETTINGS_URL', 'ola-ll-settings.php') ;

// Load the admin UI
require_once OLA_LL_PLUGIN_DIR . OLA_LL_SETTINGS_URL;

		
if (isset($_GET['page']) && $_GET['page'] == 'ola-ll') {
	add_action('admin_print_scripts', 'ola_ll_scripts');
	add_action('admin_print_styles', 'ola_ll_styles');
}

/* Login logo */
function olala_logo() { 
	$logo	=	get_option ( 'ola_ll_img_url', null );
	if ( $logo = null ) {
		$minw = 150; 
		$defw = 150; 
		$maxw = 150; 

		$minh = 150; 
		$defh = 150; 
		$maxh = 150; 
		
		$bkw = 150;
		$bkh = 150;
	} else { 
		list($w, $h, $type, $attr) = getimagesize( get_option ( 'ola_ll_img_url', null ) );
		$minw = $w + 10; 
		$defw = $w + 10; 
		$maxw = $w + 10; 

		$minh = $h + 10; 
		$defh = $h + 10; 
		$maxh = $h + 10; 
			
		$bkw = $w;
		$bkh = $h;
	}
	?>
    <style type="text/css">
		.login h1 a {
            background-image: url('<?php echo get_option ( 'ola_ll_img_url', null ); ?>');
			background-size: <?php echo $bkw ?>px <?php echo $bkh ?>px;
			
			min-width: <?php echo $w ?>px;
			width: <?php echo $w ?>px;
			max-width: <?php echo $maxw ?>px;

			min-height: <?php echo $minh ?>px;
			height: <?php echo $defh ?>px;
			max-height: <?php echo $maxh ?>px;
		}
		#login {
			width: <?php $sizes	= get_option ( 'ola_ll_sizes', null ); echo $sizes['w'].'px'; ?>;
			height:<?php $sizes	= get_option ( 'ola_ll_sizes', null ); echo $sizes['h'].'px'; ?>;
			
			margin-top:<?php $sizes	= get_option ( 'ola_ll_sizes', null ); echo $sizes['mgt'].'px'; ?>;
			margin-bottom: <?php $sizes	= get_option ( 'ola_ll_sizes', null ); echo $sizes['mgb'].'px'; ?>;
				
			padding-top: <?php $sizes	= get_option ( 'ola_ll_sizes', null ); echo $sizes['pgt'].'px'; ?>;
			padding-bottom: <?php $sizes	= get_option ( 'ola_ll_sizes', null ); echo $sizes['pgb'].'px'; ?>;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'olala_logo' );