<?php
// LinkToThisPage
//
// Copyright (c) 2008-2009 Creative Real Estate Investing Guide
// http://CreativeRealEstateInvestingGuide.com/linktothispage-wordpress-plugin
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
Plugin URI: http://CreativeRealEstateInvestingGuide.com/linktothispage-wordpress-plugin
Description: The Link To This Page WordPress plugin provides a quick, simple to use, and unobtrusive way for users to obtain a link to your page or post for their own web site. Questions on configuration, etc.? Make sure to read the README.
Version: 1.2
Author: Mike Ginese
Author URI: http://CreativeRealEstateInvestingGuide.com
*/

load_plugin_textdomain('linktothispage');

// Add some options if they don't exist along with the defaults
add_option("lttp_show_default", "no"); // Don't show the link box by default
add_option("lttp_where_to_show", "both"); // Show on Posts and Pages by default

// Hook wp_head to add css
add_action('wp_head', 'linktothispage_wp_head');

function linktothispage_wp_head() {

        $opt_show_default = get_option("lttp_show_default");

        if ($opt_show_default == "no") {
                $css_file = "lttp.css";
        } else {
                $css_file = "lttp2.css";
        } 

	echo '<link rel="stylesheet" type="text/css" media="screen" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/linktothispage/' . $css_file . '" />';

}


// Hook the content to add the widget
add_filter('the_content', 'linktothispage_display_hook');
add_filter('the_excerpt', 'linktothispage_display_hook');

function linktothispage_display_hook($content='') {

        $opt_where_to_show = get_option("lttp_where_to_show");

        if ($opt_where_to_show == "page") {
                $where_to_show = is_page();
        } elseif ($opt_where_to_show == "post") {
                $where_to_show = is_single();
        } else {
                $where_to_show = is_single() . " or " . is_page();
        }

	if (
		    $where_to_show

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
	$linktothispage .= 'Get <a href="http://creativerealestateinvestingguide.com/linktothispage-wordpress-plugin" title="LinkToThisPage">LinkToThisPage</a> from the <a href="http://creativerealestateinvestingguide.com" title="Creative Real Estate Investing Guide">Creative Real Estate Investing Guide</a>.' . "\n";
	$linktothispage .= '</div>' . "\n";

	return $linktothispage;
        
}

// Admin menu
add_action('admin_menu', 'lttp_plugin_menu');

function lttp_plugin_menu() {
  add_options_page('LinkToThisPage Plugin Options', 'LinkToThisPage', 8, __FILE__, 'lttp_plugin_options');
}

function lttp_plugin_options() {
if (isset($_POST['lttp_form_update'])) {
        update_option(lttp_show_default, $_POST['form_show_default']);
        update_option(lttp_where_to_show, $_POST['form_where_to_show']);
        echo "<div class=\"updated\"><p><strong>Options saved.</strong></p></div>\n";
}
?>
<div class=wrap>
  <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <h2>LinkToThisPage</h2>
      <h3>General Settings</h3>
      <table width="100%" cellspacing="2" cellpadding="5" class="editform">
        <tr>
          <th nowrap valign="top" width="33%">Show by default</th>
          <td><input type="radio" name="form_show_default" value="yes" <?php if (get_option("lttp_show_default") == "yes") echo "checked"; ?>> Show<br>
          <input type="radio" name="form_show_default" value="no" <?php if (get_option("lttp_show_default") == "no") echo "checked"; ?>> Hide
            <br />Would you like the link box to be displayed or hidden?  By default, the words "LinkToThisPage" will show.  When the site visitor clicks the link, a box will be shown that displays the anchor text.  If you would like this box to be visible by default, check this box.<br /><br /><br />
          </td>
        </tr>
        <tr>
          <th nowrap valign="top" width="33%">Where to show</th>
          <td><input type="radio" name="form_where_to_show" value="post" <?php if (get_option("lttp_where_to_show") == "post") echo "checked"; ?>> Posts only<br>
              <input type="radio" name="form_where_to_show" value="page" <?php if (get_option("lttp_where_to_show") == "page") echo "checked"; ?>> Pages only<br>
              <input type="radio" name="form_where_to_show" value="both" <?php if (get_option("lttp_where_to_show") == "both") echo "checked"; ?>> Pages and Posts
            <br />If you would like the link plugin to show only on blog posts, check "Posts only."  If you would like the link plugin to show only on static pages, click "Pages only."  If you would like the link plugin to show on both blog posts as well as static pages, click "Pages and Posts."
          </td>
        </tr>
      </table>
    
    <div class="submit">
      <input type="submit" name="lttp_form_update" value="Update Options" />
	  </div>
  </form>
</div>
<?php
}
?>
