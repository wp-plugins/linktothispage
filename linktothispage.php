<?php
// LinkToThisPage
//
// Copyright (c) 2008 IntellectualCapitalReport
// http://intellectualcapitalreport.com/linktothispage-wordpress-plugin
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// This is an add-on for WordPress
// http://wordpress.org/
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// *****************************************************************

/*
Plugin Name: LinkToThisPage
Plugin URI: http://intellectualcapitalreport.com/linktothispage-wordpress-plugin
Description: The LinkToThisPage (BETA) WordPress plugin provides a quick, simple to use, and unobtrusive way for users to obtain a link to your page or post for their own web site. Questions on configuration, etc.? Make sure to read the README.
Version: 1.0
Author: IntelCapRep
Author URI: http://intellectualcapitalreport.com
*/

load_plugin_textdomain('linktothispage');

// Hook wp_head to add css
add_action('wp_head', 'linktothispage_wp_head');

function linktothispage_wp_head() {

	echo '<link rel="stylesheet" type="text/css" media="screen" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/linktothispage/lttp.css" />';

}


// Hook the content to add the widget
add_filter('the_content', 'linktothispage_display_hook');
add_filter('the_excerpt', 'linktothispage_display_hook');

function linktothispage_display_hook($content='') {

	if (
		    is_single() or is_page()

	)

			$content .= lttp_widget();

		return $content;

	}


// The HTML to display
function lttp_widget() {
	global $post;

	$linktothispage = '<div class="lttp_header" id="lttp_header">' . "\n";
	$linktothispage .= '<a class="lttp_link" link="lttp_link" href = "javascript:void(0)" onclick = "document.getElementById(\'lttp_box\').style.display=\'block\';document.getElementById(\'lttp_header\').style.display=\'none\';document.getElementById(\'lttp_header2\').style.display=\'block\';document.getElementById(\'lttp_footer\').style.display=\'block\'"><img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/linktothispage/link.png" border="0">&nbsp;Link to this page</a>' . "\n";
	$linktothispage .= '</div>' . "\n";
	$linktothispage .= '<div class="lttp_header2" id="lttp_header2">' . "\n";
	$linktothispage .= '<a class="lttp_link" link="lttp_link" href = "javascript:void(0)" onclick = "document.getElementById(\'lttp_box\').style.display=\'none\';document.getElementById(\'lttp_header\').style.display=\'block\';document.getElementById(\'lttp_header2\').style.display=\'none\';document.getElementById(\'lttp_footer\').style.display=\'none\'"><img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/linktothispage/link.png" border="0">&nbsp;Link to this page</a>' . "\n";
	$linktothispage .= '</div>' . "\n";
	$linktothispage .= '<div class="lttp_box" id="lttp_box">' . "\n";
	$linktothispage .= '<div id="lttp_left" class="lttp_left">Copy the code below to your web site.</div>' . "\n";
	$linktothispage .= '<div id="lttp_right" class="lttp_right"><a class="lttp_link" link="lttp_link" href = "javascript:void(0)" onclick = "document.getElementById(\'lttp_box\').style.display=\'none\';document.getElementById(\'lttp_header\').style.display=\'block\';document.getElementById(\'lttp_header2\').style.display=\'none\';document.getElementById(\'lttp_footer\').style.display=\'none\'">x</a>&nbsp;</div>' . "\n";
	$linktothispage .= '<div id="lttp_dialog" class="lttp_dialog">' . "\n";
	$linktothispage .= '<textarea name="siteinfo" rows="6" wrap="virtual" style="overflow: hidden; width: 396px;"><a href="'.get_permalink($post->ID).'" title="'.str_replace('"', '\"', strip_tags(get_the_title())).'">'.str_replace('"', '\"', strip_tags(get_the_title())).'</a></textarea>' . "\n";
	$linktothispage .= '</div>' . "\n";
	$linktothispage .= '</div>' . "\n";
	$linktothispage .= '<div class="lttp_footer" id="lttp_footer">' . "\n";
	$linktothispage .= 'Get a copy of <a href="http://intellectualcapitalreport.com/linktothispage-wordpress-plugin" title="LinkToThisPage">LinkToThisPage</a> here.' . "\n";
	$linktothispage .= '</div>' . "\n";

	return $linktothispage;
}

?>