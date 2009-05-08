<?php
require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$errors = array();

// variables for the field and option names 
$prli_exclude_ips  = 'prli_exclude_ips';
$prettybar_image_url  = 'prli_prettybar_image_url';
$prettybar_background_image_url  = 'prli_prettybar_background_image_url';
$prettybar_color  = 'prli_prettybar_color';
$prettybar_text_color  = 'prli_prettybar_text_color';
$prettybar_link_color  = 'prli_prettybar_link_color';
$prettybar_hover_color  = 'prli_prettybar_hover_color';
$prettybar_visited_color  = 'prli_prettybar_visited_color';
$prettybar_show_title  = 'prli_prettybar_show_title';
$prettybar_show_description  = 'prli_prettybar_show_description';
$prettybar_show_share_links  = 'prli_prettybar_show_share_links';
$prettybar_show_target_url_link  = 'prli_prettybar_show_target_url_link';
$hidden_field_name  = 'prli_update_options';

$prli_domain = "pretty-link";

// Read in existing option value from database
$prli_exclude_ips_val = get_option( $prli_exclude_ips );
$prettybar_image_url_val = get_option( $prettybar_image_url );
$prettybar_background_image_url_val = get_option( $prettybar_background_image_url );
$prettybar_color_val = get_option( $prettybar_color );
$prettybar_text_color_val = get_option( $prettybar_text_color );
$prettybar_link_color_val = get_option( $prettybar_link_color );
$prettybar_hover_color_val = get_option( $prettybar_hover_color );
$prettybar_visited_color_val = get_option( $prettybar_visited_color );
$prettybar_show_title_val = get_option( $prettybar_show_title );
$prettybar_show_description_val = get_option( $prettybar_show_description );
$prettybar_show_share_links_val = get_option( $prettybar_show_share_links );
$prettybar_show_target_url_link_val = get_option( $prettybar_show_target_url_link );

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( $_POST[ $hidden_field_name ] == 'Y' ) 
{
  // Validate This
  if( !empty($_POST[$prettybar_image_url]) and !preg_match('/^http.?:\/\/.*\..*$/', $_POST[$prettybar_image_url] ) )
    $errors[] = "Logo Image URL must be a correctly formatted URL";

  if( !empty($_POST[$prettybar_background_image_url]) and !preg_match('/^http.?:\/\/.*\..*$/', $_POST[$prettybar_background_image_url] ) )
    $errors[] = "Background Image URL must be a correctly formatted URL";

  if( !empty($_POST[ $prli_exclude_ips ]) and !preg_match( "#^[ \t]*(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})([ \t]*,[ \t]*\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*$#", $_POST[ $prli_exclude_ips ] ) )
    $errors[] = "Must be a comma separated list of IP addresses.";

  if( !empty($_POST[ $prettybar_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_color ] ) )
    $errors[] = "PrettyBar Background Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_text_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_text_color ] ) )
    $errors[] = "PrettyBar Text Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_link_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_link_color ] ) )
    $errors[] = "PrettyBar Link Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_hover_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_hover_color ] ) )
    $errors[] = "PrettyBar Hover Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_visited_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_visited_color ] ) )
    $errors[] = "PrettyBar Hover Color must be an actual RGB Value";

  // Read their posted value
  $prli_exclude_ips_val = stripslashes($_POST[ $prli_exclude_ips ]);
  $prettybar_image_url_val = stripslashes($_POST[ $prettybar_image_url ]);
  $prettybar_background_image_url_val = stripslashes($_POST[ $prettybar_background_image_url ]);
  $prettybar_color_val = stripslashes($_POST[ $prettybar_color ]);
  $prettybar_text_color_val = stripslashes($_POST[ $prettybar_text_color ]);
  $prettybar_link_color_val = stripslashes($_POST[ $prettybar_link_color ]);
  $prettybar_hover_color_val = stripslashes($_POST[ $prettybar_hover_color ]);
  $prettybar_visited_color_val = stripslashes($_POST[ $prettybar_visited_color ]);
  $prettybar_show_title_val = (int)isset($_POST[ $prettybar_show_title ]);
  $prettybar_show_description_val = (int)isset($_POST[ $prettybar_show_description ]);
  $prettybar_show_share_links_val = (int)isset($_POST[ $prettybar_show_share_links ]);
  $prettybar_show_target_url_link_val = (int)isset($_POST[ $prettybar_show_target_url_link ]);


  if( count($errors) > 0 )
  {
    require(PRLI_VIEWS_PATH.'/shared/errors.php');
  }
  else
  {
    // Save the posted value in the database
    update_option( $prli_exclude_ips, $prli_exclude_ips_val );
    update_option( $prettybar_image_url, $prettybar_image_url_val );
    update_option( $prettybar_background_image_url, $prettybar_background_image_url_val );
    update_option( $prettybar_color, $prettybar_color_val );
    update_option( $prettybar_text_color, $prettybar_text_color_val );
    update_option( $prettybar_link_color, $prettybar_link_color_val );
    update_option( $prettybar_hover_color, $prettybar_hover_color_val );
    update_option( $prettybar_visited_color, $prettybar_visited_color_val );
    update_option( $prettybar_show_title, $prettybar_show_title_val );
    update_option( $prettybar_show_description, $prettybar_show_description_val );
    update_option( $prettybar_show_share_links, $prettybar_show_share_links_val );
    update_option( $prettybar_show_target_url_link, $prettybar_show_target_url_link_val );

    // Put an options updated message on the screen
?>

<div class="updated"><p><strong><?php _e('Options saved.', $prli_domain ); ?></strong></p></div>
<?php
  }
}
else if($_GET['action'] == 'clear_all_clicks4134' or $_POST['action'] == 'clear_all_clicks4134')
{
  $prli_click->clearAllClicks();
?>

<div class="updated"><p><strong><?php _e('Hit Database Was Cleared.', $prli_domain ); ?></strong></p></div>
<?php
}


?>
<div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
<h2 id="prli_title">Pretty Link: Options</h2>
<br/>
<a href="admin.php?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php">&laquo Pretty Link Admin</a>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
  <tr>
    <td colspan="2">
      <h3>PrettyBar Options</h3>
    </td>
  </tr>
  <tr class="form-field">
    <td valign="top" width="15%"><?php _e("Image URL:", $prettybar_image_url ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_image_url; ?>" value="<?php echo $prettybar_image_url_val; ?>"/>
      <br/><span class="setting-description">If set, this will replace the logo image on the PrettyBar. The image that this URL references should be 48x48 Pixels to fit.</span>
    </td>
  </tr>
  <tr class="form-field">
    <td valign="top" width="15%"><?php _e("Background Image URL:", $prettybar_background_image_url ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_background_image_url; ?>" value="<?php echo $prettybar_background_image_url_val; ?>"/>
      <br/><span class="setting-description">If set, this will replace the background image on PrettyBar. The image that this URL references should be 65px tall -- this image will be repeated horizontally across the bar.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Background Color:", $prettybar_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_color; ?>" value="<?php echo $prettybar_color_val; ?>" size="6"/>
      <br/><span class="setting-description">This will alter the background color of the PrettyBar if you haven't specified a PrettyBar background image.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Text Color:", $prettybar_text_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_text_color; ?>" value="<?php echo $prettybar_text_color_val; ?>" size="6"/>
      <br/><span class="setting-description">If not set, this defaults to black (RGB value <code>#000000</code>) but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Link Color:", $prettybar_link_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_link_color; ?>" value="<?php echo $prettybar_link_color_val; ?>" size="6"/>
      <br/><span class="setting-description">If not set, this defaults to blue (RGB value <code>#0000ee</code>) but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Link Hover Color:", $prettybar_hover_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_hover_color; ?>" value="<?php echo $prettybar_hover_color_val; ?>" size="6"/>
      <br/><span class="setting-description">If not set, this defaults to RGB value <code>#ababab</code> but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Visited Link Color:", $prettybar_visited_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_visited_color; ?>" value="<?php echo $prettybar_visited_color_val; ?>" size="6"/>
      <br/><span class="setting-description">If not set, this defaults to RGB value <code>#551a8b</code> but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_title; ?>" <?php echo (($prettybar_show_title_val != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Title
      <br/><span class="setting-description">Make sure this is checked if you want the title of your blog (and link) to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_description; ?>" <?php echo (($prettybar_show_description_val != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Description
      <br/><span class="setting-description">Make sure this is checked if you want your site description to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_share_links; ?>" <?php echo (($prettybar_show_share_links_val != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Share Links
      <br/><span class="setting-description">Make sure this is checked if you want "share links" to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_target_url_link; ?>" <?php echo (($prettybar_show_target_url_link_val != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Target URL
      <br/><span class="setting-description">Make sure this is checked if you want a link displaying the Target URL to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <h3>Reporting Options</h3>
      <h4 style="color: red;">Your Current IP Address is <?php echo $_SERVER['REMOTE_ADDR']; ?></h4>
    </td>
  </tr>
  <tr class="form-field">
    <td valign="top">Excluded IP Addresses: </td>
    <td>
      <input type="text" name="<?php echo $prli_exclude_ips; ?>" value="<?php echo $prli_exclude_ips_val; ?>"> 
      <br/><span class="setting-description">Enter IP Addresses you want to exclude from your Hit data and Stats. Each IP Address should be separated by commas. Example: <code>192.168.0.1, 192.168.2.1, 192.168.3.4</code></span>
    </td>
  </tr>
</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', $prli_domain ) ?>" />
</p>

<p><a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>&action=clear_all_clicks4134" onclick="return confirm('***WARNING*** If you click OK you will delete ALL of the Hit data in your Database. Your data will be gone forever -- no way to retreive it. Do not click OK unless you are absolutely sure you want to delete all your data because there is no going back!');">Delete All Hits</a>
      <br/><span class="setting-description">Seriously, only click this link if you want to delete all the Hit data in your database.</span></p>

</form>
</div>
