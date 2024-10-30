<?php
/*
Plugin Name: Brad's Google Analytics
Plugin URI: http://mehder.com/
Description: Adds the Google analytics tracking code to the <head> of your theme by hooking to wp_head.
Author: Brad Mehder
Version: 1.0

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */


function bsm_google_analytics_add_admin_menu(  ) { 
	
	# @admin menu (dashboard sidebar)
	# ADD ENTRY IN WORDPRESS ADMIN MENU
	add_options_page(
		'Brad\'s Google Analytics',
		'Brad\'s Google Analytics',
		'manage_options',
		'Brad_google_analytics',
		'bsm_google_analytics_options_page'
	);

}


function bsm_google_analytics_settings_init(  ) { 
	
	# @plugin settings page
	# SETTINGS INTERFACE FOR PLUGIN SETTINGS PAGE
	register_setting( 'pluginPage', 'bsm_google_analytics_settings' );

	# SECTION: main section for plugin settings page
	add_settings_section(
		'bsm_google_analytics_plugin_Page_section', 
		__( 'Google Tracking Settings', 'mehder' ), 
		'bsm_google_analytics_settings_section_callback', 
		'pluginPage'
	);
	
	# TEXT FIELD: for entering Google Analytics Tracking Code
	add_settings_field( 
		'bsm_google_analytics_text_field_tracking_code', 
		__( 'Enter Google Analytics Tracking Code', 'mehder' ), 
		'bsm_google_analytics_text_field_tracking_code_render', 
		'pluginPage', 
		'bsm_google_analytics_plugin_Page_section' 
	);

}


function bsm_google_analytics_text_field_tracking_code_render(  ) { 
	
	# @bsm_google_analytics_text_field_tracking_code hook
	# OUTPUTS TEXT FIELD ON PLUGIN SETTINGS PAGE
	$options = get_option( 'bsm_google_analytics_settings' );
	
	?>
	<input type='text' name='bsm_google_analytics_settings[bsm_google_analytics_text_field_tracking_code]' value='<?php echo $options['bsm_google_analytics_text_field_tracking_code']; ?>'>
	<?php

}


function bsm_google_analytics_settings_section_callback(  ) { 
	
	echo __( '', 'mehder' );

}


function bsm_google_analytics_options_page(  ) { 
	
	# @plugin settings page
	# OUTPUT FORM ON PLUGIN SETTINGS PAGE
	?>
	<form action='options.php' method='post'>

		<h2>Brad's Google Analytics</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
<?php }


function bsm_google_analytics_google_analytics() {
	
	# @wp_head
	# OUTPUT GOOGLE ANALYTICS SCRIPT
	
	$options = get_option( 'bsm_google_analytics_settings' ); ?>
	
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		ga('create', '<?php echo $options['bsm_google_analytics_text_field_tracking_code']; ?>', 'auto');
		ga('send', 'pageview');
		
		</script>
<?php }

# hook for admin_menu entry (dashboard sidebar)
add_action( 'admin_menu', 'bsm_google_analytics_add_admin_menu' );

# hook for defining plugin settings page elements
add_action( 'admin_init', 'bsm_google_analytics_settings_init' );

# hook for adding google analytics script to <head>
add_action( 'wp_head', 'bsm_google_analytics_google_analytics', 10 );

?>
