<div class="wrap">
<h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Add Link</h2>

<?php
  require(PRLI_VIEWS_PATH.'/shared/errors.php');
?>

<form name="form1" method="post" action="?page=<?php print PRLI_PLUGIN_NAME ?>/prli-links.php">
<input type="hidden" name="action" value="create">
<?php wp_nonce_field('update-options'); ?>
<input type="hidden" name="id" value="<?php print $id; ?>">

<table class="form-table">
  <tr class="form-field">
    <td width="75px" valign="top">Target URL*: </td>
    <td><input type="text" name="url" value="<?php print (($_POST['url'] != null)?$_POST['url']:''); ?>" size="75">
      <br/><span class="setting-description">Enter the URL you want to mask and track. Don't forget to start your url with <code>http://</code> or <code>https://</code>. Example: <code>http://www.yoururl.com</code></span></td>
  </tr>
  <tr>
    <td valign="top">Pretty Link*: </td>
    <td><strong><?php print $prli_blogurl; ?></strong>/<input type="text" name="slug" value="<?php print (($_POST['slug'] != null)?$_POST['slug']:$prli_link->generateValidSlug()); ?>" size="25">
    <br/><span class="setting-description">Use the auto-generated short slug (2-3 characters) here or enter any word (must only contain letters, numbers or the following special characters: ".","-" or "_") that will form your pretty link and redirect to the URL above. Just refresh this page to auto-generate another slug.</span></td>
  </tr>
  <tr class="form-field">
    <td width="75px" valign="top">Title: </td>
    <td><input type="text" name="name" value="<?php print (($_POST['name'] != null)?$_POST['name']:''); ?>" size="75">
      <br/><span class="setting-description">This will act as the title of your Pretty Link. If a name is not entered here then the slug name will be used.</span></td>
  </tr>
  <tr class="form-field">
    <td valign="top">Description: </td>
    <td><textarea style="height: 100px;" name="description"><?php print (($_POST['description'] != null)?$_POST['description']:''); ?></textarea>
    <br/><span class="setting-description">A Description of this link.</span></td>
  </tr>
</table>
<a href="#" class="advanced_toggle">Advanced Options</a>
<div class="advanced_pane">
<table class="form-table">
  <tr>
    <td colspan="2">
      <ul style="list-style-type: none">
      <li>
        <input type="radio" name="param_forwarding" value="off" <?php print (((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'off') or !isset($_POST['param_forwarding']))?'checked="true"':''); ?>/>&nbsp; Forward Parameters Off
        <br/><span class="setting-description">You may want to leave this option off if you don't need to forward any parameters on to your Target URL.</span>
      </li>
      <li>
        <input type="radio" name="param_forwarding" value="on" <?php print ((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'on')?'checked="true"':''); ?>/>&nbsp; Standard Parameter Forwarding
        <br/><span class="setting-description">Select this option if you want to forward parameters through your pretty link to your Target URL. This will allow you to pass parameters in the standard syntax for example the pretty link <code>http://yoururl.com/coollink?product_id=4&sku=5441</code> will forward to the target URL and append the same parameters like so: <code>http://anotherurl.com?product_id=4&sku=5441</code>.</span>
      </li>
      <li>
        <input type="radio" name="param_forwarding" value="custom" <?php print ((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'custom')?'checked="true"':''); ?>/>&nbsp; Custom Parameter Forwarding&nbsp;&nbsp;<input type="text" name="param_struct" value="<?php print (($_POST['param_struct'] != null)?$_POST['param_struct']:''); ?>" size="25"/>
        <br/><span class="setting-description">Select this option if you want to forward parameters through your Pretty Link to your Target URL and write the parameters in a custom format. For example, say I wanted to to have my links look like this: <code>http://yourdomain.com/products/14/4</code> and I wanted this to forward to <code>http://anotherurl.com?product_id=14&dock=4</code> you'd just select this option and enter the following string into the text field <code>/products/%product_id%/%dock%</code>. This will tell Pretty Link where each variable will be located in the URL and what each variable name is.</span>
      </li>
      </ul>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="checkbox" name="track_as_img" <?php print ((isset($_POST['track_as_img']) and $_POST['track_as_img'] == 'on')?'checked="true"':''); ?>/>&nbsp; Track as a Pixel
      <br/><span class="setting-description">Select this option if you want this link to behave as a tracking pixel instead of as a link. This option is useful if you want to track the number of times a page or email is opened. If you place your Pretty Link inside an img tag on the page (Example: <code>&lt;img src="<?php echo $prli_blogurl . "/yourslug"; ?>" /&gt;</code>) then the page load will be tracked as a click and then displayed. Note: If this option is selected your Target URL will simply be ignored if there's a value in it.</span>
    </td>
  </tr>
</table>
</div>

<p class="submit">
<input type="submit" name="Submit" value="Create" />&nbsp;or&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME ?>/prli-links.php">Cancel</a>
</p>

</form>
</div>
