<div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
<h2 id="prli_title">Pretty Link: Options</h2>
<br/>
<?php
$permalink_structure = get_option('permalink_structure');
if(!$permalink_structure or empty($permalink_structure))
{
?>
  <div class="error" style="padding-top: 5px; padding-bottom: 5px;"><strong>WordPress Must be Configured:</strong> Pretty Link won't work until you select a Permalink Structure other than "Default" ... <a href="<?php echo $prli_siteurl; ?>/wp-admin/options-permalink.php">Permalink Settings</a></div>
<?php
}
?>
<?php do_action('prli-options-message'); ?>
<a href="admin.php?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php">&laquo Pretty Link Admin</a>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php wp_nonce_field('update-options'); ?>

<h3><a class="toggle link-toggle-button">Link Option Defaults <span class="link-expand" style="display: none;">[+]</span><span class="link-collapse">[-]</span></a></h3>
<ul class="link-toggle-pane" style="list-style-type: none;">
    <input type="checkbox" name="<?php echo $link_track_me; ?>" <?php echo (($prli_options->link_track_me != 0)?'checked="true"':''); ?>/>&nbsp; Track Link
    <br/><span class="description">Default all new links to be tracked.</span>
  </li>
  <li>
    <input type="checkbox" name="<?php echo $link_nofollow; ?>" <?php echo (($prli_options->link_nofollow != 0)?'checked="true"':''); ?>/>&nbsp; Add <code>nofollow</code> to Link
    <br/><span class="description">Add the <code>nofollow</code> attribute by default to new links.</span>
  </li>
  <li>
    <h4>Default Link Redirection Type:</h4>
    <select name="<?php echo $link_redirect_type; ?>">
        <option value="307" <?php echo (($prli_options->link_redirect_type == '307')?' selected="selected"':''); ?>/>Temporary (307)</option>
        <option value="301" <?php echo (($prli_options->link_redirect_type == '301')?' selected="selected"':''); ?>/>Permanent (301)</option>
        <option value="prettybar" <?php echo (($prli_options->link_redirect_type == 'prettybar')?' selected="selected"':''); ?>/>Pretty Bar</option>
        <option value="cloak" <?php echo (($prli_options->link_redirect_type == 'cloak')?' selected="selected"':''); ?>/>Cloak</option>
        <option value="pixel" <?php echo (($prli_options->link_redirect_type == 'pixel')?' selected="selected"':''); ?>/>Pixel</option>
    </select>
    <br/><span class="description">Select the type of redirection you want your newly created links to have.</span>
  </li>
</ul>
<h3><a class="toggle prettybar-toggle-button">PrettyBar Options <span class="prettybar-expand" style="display: none;">[+]</span><span class="prettybar-collapse">[-]</span></a></h3>
<table class="prettybar-toggle-pane form-table">
  <tr class="form-field">
    <td valign="top" width="15%"><?php _e("Image URL:", $prettybar_image_url ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_image_url; ?>" value="<?php echo $prli_options->prettybar_image_url; ?>"/>
      <br/><span class="description">If set, this will replace the logo image on the PrettyBar. The image that this URL references should be 48x48 Pixels to fit.</span>
    </td>
  </tr>
  <tr class="form-field">
    <td valign="top" width="15%"><?php _e("Background Image URL:", $prettybar_background_image_url ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_background_image_url; ?>" value="<?php echo $prli_options->prettybar_background_image_url; ?>"/>
      <br/><span class="description">If set, this will replace the background image on PrettyBar. The image that this URL references should be 65px tall -- this image will be repeated horizontally across the bar.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Background Color:", $prettybar_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_color; ?>" value="<?php echo $prli_options->prettybar_color; ?>" size="6"/>
      <br/><span class="description">This will alter the background color of the PrettyBar if you haven't specified a PrettyBar background image.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Text Color:", $prettybar_text_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_text_color; ?>" value="<?php echo $prli_options->prettybar_text_color; ?>" size="6"/>
      <br/><span class="description">If not set, this defaults to black (RGB value <code>#000000</code>) but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Link Color:", $prettybar_link_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_link_color; ?>" value="<?php echo $prli_options->prettybar_link_color; ?>" size="6"/>
      <br/><span class="description">If not set, this defaults to blue (RGB value <code>#0000ee</code>) but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Link Hover Color:", $prettybar_hover_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_hover_color; ?>" value="<?php echo $prli_options->prettybar_hover_color; ?>" size="6"/>
      <br/><span class="description">If not set, this defaults to RGB value <code>#ababab</code> but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Visited Link Color:", $prettybar_visited_color ); ?> </td>
    <td width="85%">
      #<input type="text" name="<?php echo $prettybar_visited_color; ?>" value="<?php echo $prli_options->prettybar_visited_color; ?>" size="6"/>
      <br/><span class="description">If not set, this defaults to RGB value <code>#551a8b</code> but you can change it to whatever color you like.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Title Char Limit*:", $prettybar_title_limit ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_title_limit; ?>" value="<?php echo $prli_options->prettybar_title_limit; ?>" size="4"/>
      <br/><span class="description">If your Website has a long title then you may need to adjust this value so that it will all fit on the PrettyBar. It is recommended that you keep this value to <code>30</code> characters or less so the PrettyBar's format looks good across different browsers and screen resolutions.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Description Char Limit*:", $prettybar_desc_limit ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_desc_limit; ?>" value="<?php echo $prli_options->prettybar_desc_limit; ?>" size="4"/>
      <br/><span class="description">If your Website has a long Description (tagline) then you may need to adjust this value so that it will all fit on the PrettyBar. It is recommended that you keep this value to <code>40</code> characters or less so the PrettyBar's format looks good across different browsers and screen resolutions.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Target URL Char Limit*:", $prettybar_link_limit ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_link_limit; ?>" value="<?php echo $prli_options->prettybar_link_limit; ?>" size="4"/>
      <br/><span class="description">If you link to a lot of large Target URLs you may want to adjust this value. It is recommended that you keep this value to <code>40</code> or below so the PrettyBar's format looks good across different browsers and URL sizes</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_title; ?>" <?php echo (($prli_options->prettybar_show_title != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Title
      <br/><span class="description">Make sure this is checked if you want the title of your blog (and link) to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_description; ?>" <?php echo (($prli_options->prettybar_show_description != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Description
      <br/><span class="description">Make sure this is checked if you want your site description to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_share_links; ?>" <?php echo (($prli_options->prettybar_show_share_links != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Share Links
      <br/><span class="description">Make sure this is checked if you want "share links" to show up on the PrettyBar.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prettybar_show_target_url_link; ?>" <?php echo (($prli_options->prettybar_show_target_url_link != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar Target URL
      <br/><span class="description">Make sure this is checked if you want a link displaying the Target URL to show up on the PrettyBar.</span>
    </td>
  </tr>

  <?php do_action('prli-prettybar-options'); ?>
</table>
<h3><a class="toggle reporting-toggle-button">Reporting Options <span class="reporting-expand" style="display: none;">[+]</span><span class="reporting-collapse">[-]</span></a></h3>
<table class="reporting-toggle-pane form-table">
  <tr class="form-field">
    <td valign="top">Excluded IP Addresses: </td>
    <td>
      <input type="text" name="<?php echo $prli_exclude_ips; ?>" value="<?php echo $prli_options->prli_exclude_ips; ?>"> 
      <br/><span class="description">Enter IP Addresses or IP Ranges you want to exclude from your Hit data and Stats. Each IP Address should be separated by commas. Example: <code>192.168.0.1, 192.168.2.1, 192.168.3.4 or 192.168.*.*</code></span>
      <br/><span class="description" style="color: red;">Your Current IP Address is <?php echo $_SERVER['REMOTE_ADDR']; ?></span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" class="filter-robots-checkbox" name="<?php echo $filter_robots; ?>" <?php echo (($prli_options->filter_robots != 0)?'checked="true"':''); ?>/>&nbsp; Filter Robots
      <br/><span class="description">Filter known Robots and unidentifiable browser clients from your hit data, stats and reports. <code>IMPORTANT: Any robot hits recorded with any version of Pretty Link before 1.4.22 won't be filtered by this setting.</code></span>
      <table class="option-pane whitelist-ips">
        <tr class="form-field">
          <td valign="top">Whitelist IP Addresses: </td>
          <td>
            <input type="text" name="<?php echo $whitelist_ips; ?>" value="<?php echo $prli_options->whitelist_ips; ?>"> 
            <br/><span class="description">Enter IP Addresses or IP Ranges you want to always include in your Hit data and Stats even if they are flagged as robots. Each IP Address should be separated by commas. Example: <code>192.168.0.1, 192.168.2.1, 192.168.3.4 or 192.168.*.*</code></span>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', $prli_domain ) ?>" />
</p>


<h3>Trim Hit Database</h3>

<p><a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>&action=clear_30day_clicks" onclick="return confirm('***WARNING*** If you click OK you will delete ALL of the Hit data that is older than 30 days. Your data will be gone forever -- no way to retreive it. Do not click OK unless you are absolutely sure you want to delete this data because there is no going back!');">Delete Hits older than 30 days</a>
<br/><span class="description">This will clear all hits in your database that are older than 30 days.</span></p>

<p><a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>&action=clear_90day_clicks" onclick="return confirm('***WARNING*** If you click OK you will delete ALL of the Hit data that is older than 90 days. Your data will be gone forever -- no way to retreive it. Do not click OK unless you are absolutely sure you want to delete this data because there is no going back!');">Delete Hits older than 90 days</a>
<br/><span class="description">This will clear all hits in your database that are older than 90 days.</span></p>

<p><a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>&action=clear_all_clicks" onclick="return confirm('***WARNING*** If you click OK you will delete ALL of the Hit data in your Database. Your data will be gone forever -- no way to retreive it. Do not click OK unless you are absolutely sure you want to delete all your data because there is no going back!');">Delete All Hits</a>
<br/><span class="description">Seriously, only click this link if you want to delete all the Hit data in your database.</span></p>

</form>
</div>
