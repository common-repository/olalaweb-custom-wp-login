<?php 
/* ---------------------------------------------------------------------------------- 
SETTING STUFF
   ---------------------------------------------------------------------------------- */
function ola_ll_styles() {
	// Styles
	if ( is_admin() ) { 
		wp_register_style( 'ola-ll-style', plugins_url('css/stylesheet.css', __FILE__) );
		wp_enqueue_style( 'ola-ll-style' ); // Load css 
		wp_enqueue_style('thickbox');
	}
}
function ola_ll_scripts() {
	// Styles
	if ( is_admin() ) { 
		wp_register_script( 'ola-ll-script', plugins_url( 'js/script.js', __FILE__ ) );
		wp_enqueue_script( 'ola-ll-script' ); // Load script

		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}
}
//add_action( 'admin_init', 'ola_ll_styles_scripts' ); 

function ola_ll_settings() {
	// ADD SUBPAGE
	add_submenu_page( 'tools.php', 'Login Logo', 'Login Logo', 'manage_options', 'ola-ll', 'ola_ll_admin' ); 
	//print_r ($_POST["sizes"]);
	 // print $_POST['save_sizes'];
	// Save API Key
	if ( isset( $_POST['ola_upload_image'] ) ){
		
		// Security check
		//check_admin_referer( 'ola-ll-nonce' );

		// Update the database (save the logo)
		$currentLogo = get_option ('ola_ll_img_url', null); 
		$newLogo = $_POST['ola_upload_image'];
		
		if ( $newLogo != $currentLogo ) {
			update_option( 'ola_ll_img_url', $newLogo );
			print '<div id="message" class="updated fade"><p>Successfully saved your new logo</p></div>';
		}	
		if ( isset( $_POST['delete_check'] ) && $_POST['delete_check'] == 'DELETE' )  { 
			update_option( 'ola_ll_img_url', '' );
			print '<div id="message" class="error fade"><p>We deleted your custom logo.</p></div>';
		}
		elseif ( isset( $_POST['delete_check'] ) && $_POST['delete_check'] != 'DELETE' ) {
			print '<div id="message" class="error fade"><p>Incorrect spelling<br />Please try again.</p></div>';		
		}
	}
	
	if ( isset( $_POST['save_sizes'] ) ){
		
		// Security check
		//check_admin_referer( 'ola-ll-sizes-nonce' );

		// Update the database (save the logo)
		$newSizes = $_POST['sizes'];
		update_option( 'ola_ll_sizes', $newSizes );
		print '<div id="message" class="updated fade"><p>Successfully saved your settings<br /><b>Check out your new Login form!</b></p></div>';

		if ( isset( $_POST['delete_check'] ) && $_POST['delete_check'] == 'DELETE' )  { 
			update_option( 'ola_ll_sizes', '' );
			print '<div id="message" class="error fade"><p>We deleted your custom logo.</p></div>';
		}
		elseif ( isset( $_POST['delete_check'] ) && $_POST['delete_check'] != 'DELETE' ) {
			print '<div id="message" class="error fade"><p>Incorrect spelling<br />Please try again.</p></div>';		
		}

	}


}
add_action( 'admin_menu', 'ola_ll_settings' ); // Load ola-ll-settings.php

function ola_ll_admin() {
	// The file that will handle uploads is this one
	$action_url = $_SERVER['REQUEST_URI'];
	$currentLogo = get_option ('ola_ll_img_url', null); 
	?>

	<div class="wrap">
		<h2>OlalaWeb - Custom Login Logo</h2>

	<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">
		<div id="postbox-container-1" class="postbox-container">

			<div id="normal-sortables" class="meta-box-sortables ui-sortable">

				<div id="ola-logo" class="postbox" style="">		
						<h3 class="hndle" style="padding: 10px;"><span>Upload a logo to your website.</span></h3>
						<?php $logo	=	get_option ( 'ola_ll_img_url', null ); if ( $logo != null ) { ?>
                        <div class="inside" style="text-align:center; margin:0 auto;">
                        	<img src="<?php echo $logo ?>" />
                        </div>
                        <?php } ?>
                        <div class="clear"></div><br />
						<div class="inside">
						<form enctype="multipart/form-data" action="<?php echo $action_url ?>" method="POST">
							<?php wp_nonce_field('ola-ll-nonce');	?>
                            <input id="upload_image" type="text" size="36" name="ola_upload_image" value="<?php echo $currentLogo ?>" />
                            <input id="upload_image_button" type="button" value="Upload Image" />
                            <br />
                            <label for="upload_bk">Enter an URL or upload an image for the logo.</label>
                            <div class="clear"></div><br /><br />
							<input type="submit" class="button-primary" name="save_logo" value="Save" />
							<div class="clear"></div>
						</form>	 <!-- END OF <form> -->	
						</div>
				</div>	<!-- END OF #settings -->
			</div><!-- END id="normal -->

		</div><!-- END id="postbox1 -->

		<div id="postbox-container-2" class="postbox-container">

			<div id="normal-sortables" class="meta-box-sortables ui-sortable">

				<div id="ola-sizes" class="postbox" style="">		
						<h3 class="hndle" style="padding: 10px;"><span>Resize the login form.</span></h3>
						<div class="inside">
						<form enctype="multipart/form-data" action="<?php echo $action_url ?>" method="POST">
							<?php wp_nonce_field('ola-ll-sizes-nonce');	?>
                            <?php $sizes = get_option( 'ola_ll_sizes', null ); ?>
                            <table cellpadding="2" cellspacing="0"><tr valign="middle"> 
                                <tr class="margin"><td colspan="2">MARGIN TOP<br /><input id="sizes-mgt" type="number" name="sizes[mgt]" min="-999" max="999" value="<?php echo $sizes['mgt'];?>">px </td></tr>
                                <tr class="padding"><td colspan="2">PADDING TOP<br /><input id="sizes-pgt" type="number" name="sizes[pgt]" min="-999" max="999" value="<?php echo $sizes['pgt'];?>">px</td></tr>
                                <tr>
                                	<td id="h"><label for="sizes-h">HEIGHT</label><br /><input id="sizes-h" type="number" name="sizes[h]" min="-999" max="999" value="<?php echo $sizes['h'];?>">px</td>
                                	<td id="w"><label for="sizes-w">WIDTH</label><br /><input id="sizes-w" type="number" name="sizes[w]" min="-999" max="999" value="<?php echo $sizes['w'];?>">px</td>
                                </tr>
                                <tr class="padding"><td colspan="2"><input id="sizes-pgb" type="number" name="sizes[pgb]" min="-999" max="999" value="<?php echo $sizes["pgb"];?>">px<br />PADDING BOTTOM</td></tr>
                                <tr class="margin"><td colspan="2"><input id="sizes-mgb" type="number" name="sizes[mgb]" min="-999" max="999" value="<?php echo $sizes["mgb"];?>">px<br />MARGIN BOTTOM</td></tr>
                            </table>
                            <div class="clear"></div><br />
							<input type="submit" class="button-primary" name="save_sizes" value="Save" />
							<div class="clear"></div>
						</form>	 <!-- END OF <form> -->	
						</div>
				</div>	<!-- END OF #settings -->
			</div><!-- END id="normal -->
		</div><!-- END id="postbox2 -->

		<div class="clear"></div><br />
		
   		<div id="normal-sortables" class="meta-box-sortables ui-sortable">
			<div id="ola-table" class="postbox">
					<h3 class="hndle" style="padding: 10px;"><span>Preview</span></h3>
					<div class="inside">
						<div id="campaigns-list" class="postbox" style="">
                        	<iframe src="<?php echo home_url() . '/wp-login.php';?>"></iframe>
                        </div>
                    </div>
            </div>
		</div><!-- END id="normal -->

	</div><!-- END id="dashboard-widgets-wrap" -->

	</div><!-- END id="dashboard-widgets" -->
	</div><!-- END WRAP -->


<?php } // END OF FUNTIONC 

//this should be your plugin page link, in the following format
$plugin_file = 'olalaweb-custom-wp-login/ola-ll.php';
add_filter( "plugin_action_links_{$plugin_file}", 'ola_ll_plugin_action_links', 10, 2 );
 

//modify the link by unshifting the array
function ola_ll_plugin_action_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'tools.php?page=ola-ll') . '">' . __( 'Settings', 'olalaweb' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}