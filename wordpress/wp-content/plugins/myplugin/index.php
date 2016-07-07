<?php
/*
Plugin Name: Simple Popup
Plugin URI: http://example.com/wordpress-plugins/halloween-plugin
Description: This is a brief description of my plugin
Version: 1.0
Author: Jesus Erwin Suarez
Author URI: http://example.com
License: GPLv2
*/
?>


<?php
add_filter ( 'the_content', 'spp_subscriber_footer',2  );
function spp_subscriber_footer( $content ) {


	//add option
	add_option( 'prowp_display_mode', 'Fright Night' );

	//update option
	update_option( 'prowp_display_mode', 'Fright Night' );

	//get  option
	echo get_option( 'prowp_display_mode' );
// delete_option( 'prowp_display_mode' );

	//adding option as an array format
	$prowp_options_arr = array(
			'prowp_display_mode' => 'Fright Night',
			'prowp_default_browser' => 'Chrome',
			'prowp_favorite_book' => 'Professional WordPress',
	);
	update_option( 'prowp_plugin_options', $prowp_options_arr );

	// delete option
 	delete_option( 'prowp_display_mode_test' );



 	$content.= '<h1>Enjoyed this article? asdasd</h1>' . get_option( 'prowp_display_mode' . '<pre>'  . print_r(get_option('prowp_plugin_options')) . '</pre>' );
	$content.= '<p>Subscribe <input type="text" name="name"/> ';
	return $content;
}

add_filter( 'the_title', 'spp_custom_title',2 );
function spp_custom_title( $title ) {
	$title .= ' - By Jesus Erwin Suarez';
	return $title;
}


add_filter( 'the_permalink', 'spp_permalink', 5);
function spp_permalink( $permalink ) {
	return $permalink . ' <--- <br>';
}



add_action('wp_head', 'ssp_header', 4);

function ssp_header(){
	?>
		 <link rel="stylesheet" href="<?php echo plugin_dir_url(__file__) . '/assets/style.css'; ?>" />
	<?php
}

add_action( 'wp_footer', 'ssp_footer',6 );
function ssp_footer() {
	 
}


function prowp_main_plugin_page(){ ?>



	<div class="wrap">
		<h2>Halloween Plugin Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'prowp-settings-group' ); ?>
			<?php $prowp_options = get_option( 'prowp_options' ); ?>
			<table class="form-table">


				<tr valign="top">
					<th scope="row">Name</th>
					<td><input type="text" name="prowp_options[option_name]"
							   value="<?php echo esc_attr( $prowp_options['option_name'] ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Email</th>
					<td><input type="text" name="prowp_options[option_email]"
							   value="<?php echo esc_attr( $prowp_options['option_email'] ); ?>"
						/></td>
				</tr>
				<tr valign="top">
					<th scope="row">URL</th>
					<td><input type="text" name="prowp_options[option_url]"
							   value="<?php echo esc_url( $prowp_options['option_url'] ); ?>" />
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="button-primary"
					   value="Save Changes" />
			</p>
		</form>
	</div>

	<?php

		if(isset($_POST['settings'])) {
			echo '<br>' . $_POST['settings']. ' saved ';


			if(add_option('ssp_settings', $_POST['settings'])){
				echo '<br>' . "Settings successfully saved. ";
			} else {
				update_option('ssp_settings', $_POST['settings']);
				echo '<br>' . "Settings failed to save. ";
			}
		}

	?>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=myplugin_main_menu" name="formData" >
		<input name="settings" type="text" value="<?php echo get_option('ssp_settings') ?>" /> <br>
		<input type="text" value="this is the value" /> <br>
		<input type="text" value="this is the value" /> <br>
		<input type="text" value="this is the value" /> <br>
		<input type="text" value="this is the value" /> <br>
		<input type="submit" value="save" />
	</form>

<?php
}
function ssp_settings() {
	echo "<h1> This is the settings! </h1>";
}
function ssp_support_page () {
	echo "<h2>Support!</h2>";
}

// create custom plugin settings menu
add_action( 'admin_menu', 'prowp_create_menu' );
function prowp_create_menu() {
	//create new top-level menu
	add_menu_page(
			'My Plugin Page',
			'My Plugin',
			'manage_options',
			'myplugin_main_menu',
			'prowp_main_plugin_page',
			plugins_url( '/images/wordpress.png', __FILE__ )
	);

	//create two sub-menus: settings and support
		add_submenu_page(
				'myplugin_main_menu',
				'My Plugin Page Page',
				'Settings',
				'manage_options',
				'my_plugin_settings',
				'ssp_settings'
		);

		add_submenu_page(
				'myplugin_main_menu',
				'My Plugin Page Page',
				'Support',
				'manage_options',
				'ssp_support',
				'ssp_support_page'
		);



	//call register settings function
	add_action( 'admin_init', 'prowp_settings_init' );
}




//execute our settings section function
// not sure how to use this

function prowp_settings_init() {
	//create the new setting section on the Settings > Reading page
	add_settings_section( 'prowp_setting_section', 'Halloween Plugin Settings',
			'prowp_setting_section', 'reading' );
	// register the individual setting options
	add_settings_field( 'prowp_setting_enable_id', 'Enable Halloween Feature?',
			'prowp_setting_enabled', 'reading', 'prowp_setting_section' );
	add_settings_field( 'prowp_saved_setting_name_id', 'Your Name',
			'prowp_setting_name', 'reading', 'prowp_setting_section' );
	// register the setting to store our array of values
	register_setting( 'reading', 'prowp_setting_values' );
}


// EXECUTE SHORT CODES

//simple short code
//add to page: [mytwitter person='brad']
add_shortcode( 'mytwitter', 'prowp_twitter' );
function prowp_twitter() {
	return '<a href="http://twitter.com/williamsba">@williamsba amazing short codes here</a>';
}

add_shortcode( 'mytwitter', 'prowp_twitter1' );
function prowp_twitter1( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'person' => 'brad' // set attribute default
	), $atts ) );

	if ( $person == 'brad' ) {
		return '<a href="http://twitter.com/williamsba">@williamsba </a>';
	}elseif ( $person == 'david' ) {
		return '<a href="http://twitter.com/mirmillo">@mirmillo  with parameter</a>';
	}elseif ( $person == 'hal' ) {
		return '<a href="http://twitter.com/freeholdhal">@freeholdhal  with parameter</a>';
	}
}