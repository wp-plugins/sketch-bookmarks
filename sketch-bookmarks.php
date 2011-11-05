<?php

/*

Plugin Name: Sketch Bookmarks

Version: 1.2.02

Plugin URI: http://www.sitesketch101.com

Description: This plugin contains amazing looking, sketched icons for only the top social bookmarking sites.  Quit confusing your readers with dozens of bookmarking options and go start to really go after those that or actually getting used with these amazing looking sketch icons.  

Author: Nicholas Cardot

Author URI: http://www.sitesketch101.com/

*/



function add_me($content) {

	global $post;

	$sketch_width = get_option('width');

	$sketch_align = get_option('alignment');

	$sketch_link  = get_permalink($post->ID);

	$sketch_title = urlencode(the_title_attribute('echo=0'));

	$sketch_style = "margin: 2px; float: left; width: 48px; height: 48px; border: 0;";

	$sketch_images_folder = get_option('siteurl') . '/wp-content/plugins/sketch-bookmarks/images/';

	if (!is_feed() && !is_page()  && !is_front_page() || is_front_page() && get_option('homepage') == "show") {

		$content .= "\n\n" . '<!--Begin Sketched Bookmarks-->' . "\n" . 

							 '<div style="margin: 10px auto;">';				 

		if (get_option('share_image') == "show") {
			$content .= '<div style="background-image:url(' . $sketch_images_folder . 'sharethispost.png); width: 270px; height: 48px; float: left;"></div>';
		}

		if (get_option('delicious') == "show") {
			$content .= '<a style="' . $sketch_style . ' background: url(' . $sketch_images_folder . 'delicious.png)" href="http://del.icio.us/post?url=' . $sketch_link . '&amp;title=' . $sketch_title . '" rel="nofollow" title="del.icio.us"></a>' . "\n";
		}

		if (get_option('digg') == "show") {
			$content .= '<a style="' . $sketch_style . ' background: url(' . $sketch_images_folder . 'digg.png)" href="http://digg.com/submit?phase=2&amp;url=' . $sketch_link . '&amp;title=' . $sketch_title . '" rel="nofollow" title="Digg"></a>' . "\n";
		}

		if (get_option('facebook') == "show") {
			$content .= '<a style="' . $sketch_style . ' background: url(' . $sketch_images_folder . 'facebook.png)" href="http://facebook.com/sharer.php?u=' . $sketch_link . '&amp;t=' . $sketch_title . '" rel="nofollow" title="Facebook"></a>' . "\n";
		}

		if (get_option('stumbleupon') == "show") {
			$content .= '<a style="' . $sketch_style . ' background: url(' . $sketch_images_folder . 'stumbleupon.png)" href="http://stumbleupon.com/submit?url=' . $sketch_link . '&amp;title=' . $sketch_title . '&amp;newcomment=' . $sketch_title . '" rel="nofollow" title="StumbleUpon"></a>' . "\n";
		}

		if (get_option('technorati') == "show") {
			$content .= '<a style="' . $sketch_style . ' background: url(' . $sketch_images_folder . 'technorati.png)" href="http://technorati.com/faves?add=' . $sketch_link . '" title="Technorati"></a>' . "\n";
		}

		if (get_option('twitter') == "show") {

			$content .= '<a style="' . $sketch_style . ' background: url(' . $sketch_images_folder . 'twitter.png)" href="http://twitter.com/home?status=' . $sketch_title . '%20' . $sketch_link . '" rel="nofollow" title="Twitter"></a>' . "\n";
		}
		
		if (get_option('twitter') == "show") {
			$content .= '<style>.gplus #___plusone_0, .gplus #___plusone_1,.gplus #___plusone_2, .gplus #___plusone_3, .gplus #___plusone_4, .gplus #___plusone_5, .gplus #___plusone_6, .gplus #___plusone_7, .gplus #___plusone_8, .gplus #___plusone_9, .gplus #___plusone_10 {-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);-moz-opacity:0.0;-khtml-opacity: 0.0;opacity: 0;}</style><!-- Place this tag where you want the +1 button to render -->
<div class="gplus" style="background:url(' . $sketch_images_folder . 'googleplus.png);height:48px;width:48px;overflow:hidden;padding:0;">
	<div style="margin:7px 0 -11px 0;padding:0;">
		<g:plusone size="tall" annotation="none"></g:plusone>
	</div>
	<g:plusone size="tall" annotation="none"></g:plusone>
</div>
<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    po.src = \'https://apis.google.com/js/plusone.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>' . "\n";
		}
		
		$content .= "</div>\n<!--End Sketched Bookmarks--><div style=\"clear:both;width:100%;height:10px;\"></div>\n\n";
	}
	return $content;
}

function set_sketch_options() {
	add_option('share_image','show','Show "Share:"');
	add_option('delicious','show','del.icio.us');
	add_option('digg','show','Digg');
	add_option('facebook','show','Facebook');
	add_option('stumbleupon','show','StumbleUpon');
	add_option('technorati','show','Technorati');
	add_option('twitter','show','Twitter');
	add_option('google','show','google');
	add_option('width','100%','Width');
	add_option('alignment','left','Alignment');
	add_option('homepage','show','Homepage');
}

function unset_sketch_options() {
	delete_option('share_image');
	delete_option('delicious');
	delete_option('digg');
	delete_option('facebook');
	delete_option('stumbleupon');
	delete_option('technorati');
	delete_option('twitter');
	delete_option('google');
	delete_option('width');
	delete_option('alignment');
	delete_option('homepage');
}

register_activation_hook(__FILE__,'set_sketch_options');
register_deactivation_hook(__FILE__,'unset_sketch_options');

 
function admin_sketch_options() {

	?>

	<div class="admin-sketch-options">

		<h2>Sketch Bookmarks Options</h2>

	<?php

	if ($_REQUEST['submit']) {

		update_sketch_options();

	}

	print_sketch_form();

	?>

	</div>

	<?php

}

function update_sketch_options() {
	$ok = FALSE;
	if ($_REQUEST['share_image']) {
		update_option('share_image', $_REQUEST['share_image']);
		$ok = TRUE;
	}

	if ($_REQUEST['delicious']) {
		update_option('delicious', $_REQUEST['delicious']);
		$ok = TRUE;
	}

	if ($_REQUEST['digg']) {
		update_option('digg', $_REQUEST['digg']);
		$ok = TRUE;
	}

	if ($_REQUEST['facebook']) {
		update_option('facebook', $_REQUEST['facebook']);
		$ok = TRUE;
	}

	if ($_REQUEST['stumbleupon']) {
		update_option('stumbleupon', $_REQUEST['stumbleupon']);
		$ok = TRUE;
	}

	if ($_REQUEST['technorati']) {
		update_option('technorati', $_REQUEST['technorati']);
		$ok = TRUE;
	}

	if ($_REQUEST['twitter']) {
		update_option('twitter', $_REQUEST['twitter']);
		$ok = TRUE;
	}

	if ($_REQUEST['google']) {
		update_option('google', $_REQUEST['google']);
		$ok = TRUE;
	}

	if ($_REQUEST['homepage']) {
		update_option('homepage', $_REQUEST['homepage']);
		$ok = TRUE;
	}

	if ($ok === TRUE) { ?>

		<div id="message" class="updated fade">
			<p>Options saved.</p>
		</div>
		<?php	} else {	?>

		<div id="message" class="error fade">
			<p>Failed to save options.</p>
		</div>
		<?php

	}
}

function print_sketch_form() {
	if (get_option('share_image') == "show") {
		$displayShareImage = TRUE;
	} else {
		$displayShareImage = FALSE;
	}

	if (get_option('delicious') == "show") {
		$displayDelicious = TRUE;
	} else {
		$displayDelicious = FALSE;
	}

	if (get_option('digg') == "show") {
		$displayDigg = TRUE;
	} else {
		$displayDigg = FALSE;
	}

	if (get_option('facebook') == "show") {
		$displayFacebook = TRUE;
	} else {
		$displayFacebook = FALSE;
	}

	if (get_option('technorati') == "show") {
		$displayTechnorati = TRUE;
	} else {
		$displayTechnorati = FALSE;
	}

	if (get_option('twitter') == "show") {
		$displayTwitter = TRUE;
	} else {
		$displayTwitter = FALSE;
	}

	if (get_option('stumbleupon') == "show") {
		$displayStumbleUpon = TRUE;
	} else {
		$displayStumbleUpon = FALSE;
	}

	if (get_option('google') == "show") {
		$displayGoogle = TRUE;
	} else {
		$displayGoogle = FALSE;
	}

	if (get_option('homepage') == "show") {
		$displayHomePage = TRUE;
	} else {
		$displayHomePage = FALSE;
	} ?>

    <p style="width:475px">Welcome to the Sketch Bookmarks settings page. This plugin contains amazing looking, sketched icons for only the top social bookmarking sites. Below you can select which icons you would like to display and which you would like to hide. </p>

	<form method="post">
    	<table width="468" border="1" cellpadding="5">
  			<tr style="text-align:left;">
				<th>Social Bookmark</th>
		      <th>Display?</th>
			</tr>
			<tr>
				<td><label for="share_image">"Share Label"</label></td>
				<td><input name="share_image" type="radio" value="show"<?php if ($displayShareImage) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="share_image" type="radio" value="hide"<?php if (!$displayShareImage) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="delicious">Del.icio.us</label></td>
				<td><input name="delicious" type="radio" value="show"<?php if ($displayDelicious) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="delicious" type="radio" value="hide"<?php if (!$displayDelicious) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="digg">Digg</label></td>
				<td><input name="digg" type="radio" value="show"<?php if ($displayDigg) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="digg" type="radio" value="hide"<?php if (!$displayDigg) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="facebook">Facebook</label></td>
				<td><input name="facebook" type="radio" value="show"<?php if ($displayFacebook) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="facebook" type="radio" value="hide"<?php if (!$displayFacebook) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="stumbleupon">StumbleUpon</label></td>
				<td><input name="stumbleupon" type="radio" value="show"<?php if ($displayStumbleUpon) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="stumbleupon" type="radio" value="hide"<?php if (!$displayStumbleUpon) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="technorati">Technorati</label></td>
				<td><input name="technorati" type="radio" value="show"<?php if ($displayTechnorati) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="technorati" type="radio" value="hide"<?php if (!$displayTechnorati) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="twitter">Twitter</label></td>
				<td><input name="twitter" type="radio" value="show"<?php if ($displayTwitter) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="twitter" type="radio" value="hide"<?php if (!$displayTwitter) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="google">Google+</label></td>
				<td><input name="google" type="radio" value="show"<?php if ($displayGoogle) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="google" type="radio" value="hide"<?php if (!$displayGoogle) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
			<tr>
				<td><label for="homepage">Display on the homepage also?</label></td>
				<td><input name="homepage" type="radio" value="show"<?php if ($displayHomePage) { echo ' selected="selected" checked'; } ?>>Yes</option>
					<input name="homepage" type="radio" value="hide"<?php if (!$displayHomePage) { echo ' selected="selected" checked'; }?>>No</option></td>
			</tr>
		</table>
		<br /><input type="submit" name="submit" value="Submit" />
	</form>
	<br /><a href="http://www.sitesketch101.com"><img src="<?php echo get_option('siteurl') . '/wp-content/plugins/sketch-bookmarks/images/'; ?>468x60-B.jpg" /></a>
	<p style="width:475px;">Sketch Bookmarks was created by Nicholas Cardot from <a href="http://www.sitesketch101.com">Site Sketch 101</a>. If you're looking for the tips, advice, and knowledge necessary to make your blog into something amazing and influental then check out <a href="http://www.sitesketch101.com">Site Sketch 101.</a></p>

	<?php }

function sketch_icons_menu() {
	add_options_page(
		'Sketch Bookmarks',				/* Page Title */
		'Sketch Bookmarks',				/* Sub-menu Title */
		'manage_options',					/* access/capability */
		__FILE__,							/* file */
		'admin_sketch_options'			/* function */
	);
}

add_action('admin_menu','sketch_icons_menu');
add_filter('the_content', 'add_me', 1097);

?>