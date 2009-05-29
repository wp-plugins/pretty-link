<div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
<h2 id="prli_title">Pretty Link: Options</h2>
<br/>
<a href="admin.php?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php">&laquo Pretty Link Admin</a>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php wp_nonce_field('update-options'); ?>

<h3><a class="toggle link-toggle-button">Link Option Defaults <span class="link-expand" style="display: none;">[+]</span><span class="link-collapse">[-]</span></a></h3>
<ul class="link-toggle-pane" style="list-style-type: none;">
  <li>
    <input type="checkbox" name="<?php echo $link_show_prettybar; ?>" <?php echo (($link_show_prettybar_val != 0)?'checked="true"':''); ?>/>&nbsp; Show Pretty Bar
    <br/><span class="setting-description">Show PrettyBar by default when link is created.</span>
  </li>
  <li>
    <input type="checkbox" name="<?php echo $link_ultra_cloak; ?>" <?php echo (($link_ultra_cloak_val != 0)?'checked="true"':''); ?>/>&nbsp; Ultra Cloak Link
    <br/><span class="setting-description">Ultra Cloak all links as they are created.</span>
  </li>
  <li>
    <input type="checkbox" name="<?php echo $link_track_me; ?>" <?php echo (($link_track_me_val != 0)?'checked="true"':''); ?>/>&nbsp; Track Link
    <br/><span class="setting-description">Default all new links to be tracked.</span>
  </li>
  <li>
    <input type="checkbox" name="<?php echo $link_track_as_pixel; ?>" <?php echo (($link_track_as_pixel_val != 0)?'checked="true"':''); ?>/>&nbsp; Track Link as a Pixel
    <br/><span class="setting-description">Default all new links to be tracking pixels.</span>
  </li>
  <li>
    <input type="checkbox" name="<?php echo $link_nofollow; ?>" <?php echo (($link_nofollow_val != 0)?'checked="true"':''); ?>/>&nbsp; Add <code>nofollow</code> to Link
    <br/><span class="setting-description">Add the <code>nofollow</code> attribute by default to new links.</span>
  </li>
  <li>
    <h4>Default Link Redirect Type:</h4>
    <ul style="list-style-type: none">
      <li>
        <input type="radio" name="<?php echo $link_redirect_type; ?>" value="307" <?php echo (($link_redirect_type_val == '307')?' checked=true':''); ?>/>&nbsp;Temporary Redirect (307)
        <div class="setting-description">Default newly created links to have temporary (307) redirection.</div>
      </li>
      <li>
        <input type="radio" name="<?php echo $link_redirect_type; ?>" value="301" <?php echo (($link_redirect_type_val == '301')?' checked=true':''); ?> />&nbsp;Permanent Redirect (301)
        <div class="setting-description">Default newly created links to have permanent (307) redirection.</div>
      </li>
    </ul>
  </li>
</ul>
<h3><a class="toggle prettybar-toggle-button">PrettyBar Options <span class="prettybar-expand" style="display: none;">[+]</span><span class="prettybar-collapse">[-]</span></a></h3>
<table class="prettybar-toggle-pane form-table">
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
    <td valign="top" width="15%"><?php _e("Title Char Limit*:", $prettybar_title_limit ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_title_limit; ?>" value="<?php echo $prettybar_title_limit_val; ?>" size="4"/>
      <br/><span class="setting-description">If your Website has a long title then you may need to adjust this value so that it will all fit on the PrettyBar. It is recommended that you keep this value to <code>30</code> characters or less so the PrettyBar's format looks good across different browsers and screen resolutions.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Description Char Limit*:", $prettybar_desc_limit ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_desc_limit; ?>" value="<?php echo $prettybar_desc_limit_val; ?>" size="4"/>
      <br/><span class="setting-description">If your Website has a long Description (tagline) then you may need to adjust this value so that it will all fit on the PrettyBar. It is recommended that you keep this value to <code>40</code> characters or less so the PrettyBar's format looks good across different browsers and screen resolutions.</span>
    </td>
  </tr>
  <tr>
    <td valign="top" width="15%"><?php _e("Target URL Char Limit*:", $prettybar_link_limit ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prettybar_link_limit; ?>" value="<?php echo $prettybar_link_limit_val; ?>" size="4"/>
      <br/><span class="setting-description">If you link to a lot of large Target URLs you may want to adjust this value. It is recommended that you keep this value to <code>40</code> or below so the PrettyBar's format looks good across different browsers and URL sizes</span>
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

</table>
<h3><a class="toggle reporting-toggle-button">Reporting Options <span class="reporting-expand" style="display: none;">[+]</span><span class="reporting-collapse">[-]</span></a></h3>
<table class="reporting-toggle-pane form-table">
  <tr class="form-field">
    <td valign="top">Excluded IP Addresses: </td>
    <td>
      <input type="text" name="<?php echo $prli_exclude_ips; ?>" value="<?php echo $prli_exclude_ips_val; ?>"> 
      <br/><span class="setting-description">Enter IP Addresses you want to exclude from your Hit data and Stats. Each IP Address should be separated by commas. Example: <code>192.168.0.1, 192.168.2.1, 192.168.3.4</code></span>
      <br/><span class="setting-description" style="color: red;">Your Current IP Address is <?php echo $_SERVER['REMOTE_ADDR']; ?></span>
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
