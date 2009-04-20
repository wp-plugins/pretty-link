<div class="wrap">
<h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Edit Link</h2>

<?php
  require(PRLI_VIEWS_PATH.'/shared/errors.php');
?>

<form name="form1" method="post" action="?page=<?php print PRLI_PLUGIN_NAME ?>/prli-links.php">
<input type="hidden" name="action" value="update">
<input type="hidden" name="id" value="<?php print $id; ?>">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
  <tr>
    <td width="75px" valign="top">URL*: </td>
    <td><input type="text" name="url" value="<?php print (($_POST['url'] != null and $record == null)?$_POST['url']:$record->url); ?>" size="75">
      <br/><span class="setting-description">Enter the URL you want to mask and track. Don't forget to start your url with <code>http://</code> or <code>https://</code>. Example: <code>http://www.yoururl.com</code></span></td>
  </tr>
  <tr>
    <td valign="top">Pretty Link*: </td>
    <td><strong><?php print get_option('siteurl'); ?></strong>/<input type="text" name="slug" value="<?php print (($_POST['slug'] != null and $record == null)?$_POST['slug']:$record->slug); ?>" size="25">
    <br/><span class="setting-description">Enter the slug (word trailing your main URL) that will form your pretty link and redirect to the URL above.</span></td>
  </tr>
  <tr class="form-field">
    <td width="75px" valign="top">Title: </td>
    <td><input type="text" name="name" value="<?php print (($_POST['name'] != null and $record == null)?$_POST['name']:$record->name); ?>" size="75">
      <br/><span class="setting-description">This will act as the title of your Pretty Link. If a name is not entered here then the slug name will be used.</span></td>
  </tr>
  <tr class="form-field">
    <td valign="top">Description: </td>
    <td><textarea style="height: 100px;" name="description"><?php print (($_POST['description'] != null and $record == null)?$_POST['description']:$record->description); ?></textarea>
    <br/><span class="setting-description">A Description of this link.</span></td>
  </tr>
</table>
<a href="#" class="advanced_toggle">Advanced Options</a>
<div class="advanced_pane" style="display:none;">
<table class="form-table">
  <tr>
    <td colspan="2">
      <input type="checkbox" name="forward_params" <?php print ((($_POST['forward_params'] or $record->forward_params) and ($_POST['forward_params'] == 'on' or $record->forward_params == 1))?'checked="true"':''); ?>/>&nbsp; Forward Parameters (experimental)
      <br/><span class="setting-description">Select this option if you want to forward custom parameters through your pretty link to your target url. Note: The Pretty Link plugin uses a parameter named <code>sprli</code> for tracking purposes and is therefore not available as one of your custom parameters.</span>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="track_as_img" <?php print ((($_POST['track_as_img'] or $record->track_as_img) and ($_POST['track_as_img'] == 'on' or $record->track_as_img == 1))?'checked="true"':''); ?>/>&nbsp; Track as an Image (experimental)
      <br/><span class="setting-description">Select this option if you want to track this link as an image instead of as a link. This option is useful if you want to track the number of times a page or email is opened. If you place your Pretty Link inside an img tag on the page (Example: <code>&lt;img src="<?php echo get_option('siteurl') . "/yourslug"; ?>" /&gt;</code>) then the image will be tracked as a click and then displayed. Note: If this option is selected your target url must be an image.</span>
    </td>
  </tr>
</table>
</div>

<p class="submit">
<input type="submit" name="Submit" value="Update" />&nbsp;or&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME ?>/prli-links.php">Cancel</a>
</p>

</form>
</div>
