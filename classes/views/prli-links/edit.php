<div class="wrap">
<h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Edit Link</h2>

<?php
  require(PRLI_VIEWS_PATH.'/shared/errors.php');
?>

<form name="form1" method="post" action="?page=<?php echo PRLI_PLUGIN_NAME ?>/prli-links.php">
<input type="hidden" name="action" value="update">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
  <tr class="form-field">
    <td width="75px" valign="top">Target URL*: </td>
    <td><input type="text" name="url" value="<?php echo (($_POST['url'] != null and $record == null)?$_POST['url']:$record->url); ?>" size="75">
      <br/><span class="setting-description">Enter the URL you want to mask and track. Don't forget to start your url with <code>http://</code> or <code>https://</code>. Example: <code>http://www.yoururl.com</code></span></td>
  </tr>
  <tr>
    <td valign="top">Pretty Link*: </td>
    <td><strong><?php echo $prli_blogurl; ?></strong>/<input type="text" name="slug" value="<?php echo (($_POST['slug'] != null and $record == null)?$_POST['slug']:$record->slug); ?>" size="25">
    <br/><span class="setting-description">Enter the slug (word trailing your main URL) that will form your pretty link and redirect to the URL above.</span></td>
  </tr>
  <tr class="form-field">
    <td width="75px" valign="top">Title: </td>
    <td><input type="text" name="name" value="<?php echo (($_POST['name'] != null and $record == null)?$_POST['name']:$record->name); ?>" size="75">
      <br/><span class="setting-description">This will act as the title of your Pretty Link. If a name is not entered here then the slug name will be used.</span></td>
  </tr>
  <tr class="form-field">
    <td valign="top">Description: </td>
    <td><textarea style="height: 100px;" name="description"><?php echo (($_POST['description'] != null and $record == null)?$_POST['description']:$record->description); ?></textarea>
    <br/><span class="setting-description">A Description of this link.</span></td>
  </tr>
  <tr class="form-field">
    <td valign="top">Group:</td>
    <td>
    <select name="group_id">
      <option>None</option>
    <?php
      foreach($groups as $group)
      {
    ?>
        <option value="<?php echo $group->id; ?>"<?php echo ((($_POST['group_id'] == $group->id) or ($record->group_id == $group->id))?' selected="true"':''); ?>><?php echo $group->name; ?></option>
    <?php
      }
    ?>
    </select>
    <br/><span class="setting-description">Select a group for this link. <strong>(optional)</strong></span></td>
  </tr>
</table>
<a href="#" class="advanced_toggle">Advanced Options</a>
<div class="advanced_pane">
<table class="form-table">
  <tr>
    <td valign="top" colspan="2">
    <h3>Group Options</h3>
    <span>Group Listing Order:&nbsp;</span><input type="text" name="gorder" value="<?php echo (($_POST['gorder'] != null and $record == null)?$_POST['gorder']:$record->gorder); ?>" size="10">
    <br/><span class="setting-description"><strong>(OPTIONAL)</strong> You can use this to determine the order that your link show up in the group it's in. The group will default to alphabetic order -- but this will override that default behavior. I also realize this isn't the easiest way for you to re-order links but we'll get a better way in the future.</span></td>
  </tr>
  <tr>
    <td colspan="2">
      <h3>Parameter Forwarding</h3>
      <ul style="list-style-type: none">
      <li>
        <input type="radio" name="param_forwarding" value="off" <?php echo ((!isset($_POST['param_forwarding']) or $record->param_forwarding == 'off')?'checked="true"':''); ?>/>&nbsp; Forward Parameters Off
        <br/><span class="setting-description">You may want to leave this option off if you don't need to forward any parameters on to your Target URL.</span>
      </li>
      <li>
        <input type="radio" name="param_forwarding" value="on" <?php echo (((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'on') or (isset($record->param_forwarding) and $record->param_forwarding == 'on'))?'checked="true"':''); ?> />&nbsp;Standard Parameter Forwarding
        <br/><span class="setting-description">Select this option if you want to forward parameters through your pretty link to your Target URL. This will allow you to pass parameters in the standard syntax for example the pretty link <code>http://yoururl.com/coollink?product_id=4&sku=5441</code> will forward to the target URL and append the same parameters like so: <code>http://anotherurl.com?product_id=4&sku=5441</code>.</span>
      </li>
      <li>
        <input type="radio" name="param_forwarding" value="custom" <?php echo (((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'custom') or (isset($record->param_forwarding) and $record->param_forwarding == 'custom'))?'checked="true"':''); ?> />&nbsp;Custom Parameter Forwarding&nbsp;&nbsp;<input type="text" name="param_struct" value="<?php echo (($_POST['param_struct'] != null and $record == null)?$_POST['param_struct']:$record->param_struct); ?>" size="25"/>
        <br/><span class="setting-description">Select this option if you want to forward parameters through your Pretty Link to your Target URL and write the parameters in a custom format. For example, say I wanted to to have my links look like this: <code>http://yourdomain.com/products/14/4</code> and I wanted this to forward to <code>http://anotherurl.com?product_id=14&dock=4</code> you'd just select this option and enter the following string into the text field <code>/products/%product_id%/%dock%</code>. This will tell Pretty Link where each variable will be located in the URL and what each variable name is.</span>
      </li>
      </ul>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <h3>Redirect Type</h3>
      <ul style="list-style-type: none">
      <li>
        <input type="radio" name="redirect_type" value="307" <?php echo ((!isset($_POST['redirect_type']) or $_POST['redirect_type'] == '307' or $record->redirect_type == '307')?'checked="true"':''); ?>/>&nbsp;Temporary Redirect (307)
        <br/><span class="setting-description">This is the best option if you're planning on changing your Target URL and want accurate reporting for this link.</span>
      </li>
      <li>
        <input type="radio" name="redirect_type" value="301" <?php echo (((isset($_POST['redirect_type']) and $_POST['redirect_type'] == '301') or (isset($record->redirect_type) and $record->redirect_type == '301'))?'checked="true"':''); ?> />&nbsp;Permanent Redirect (301)
        <br/><span class="setting-description">This is the best option if you're <strong>NOT</strong> planning on changing your Target URL. Traditionally this option is considered to be the best approach to use for your SEO/SEM efforts but since Pretty Link uses your domain name either way this notion isn't necessarily true for Pretty Links. Also, this option may not give you accurate reporting since proxy and caching servers may go directly to your Target URL once it's cached.</span>
      </li>
      </ul>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <h3>Pixel Tracking</h3>
      <input type="checkbox" name="track_as_img" <?php echo ((($_POST['track_as_img'] or $record->track_as_img) and ($_POST['track_as_img'] == 'on' or $record->track_as_img == 1))?'checked="true"':''); ?>/>&nbsp; Track as a Pixel
      <br/><span class="setting-description">Select this option if you want this link to behave as a tracking pixel instead of as a link. This option is useful if you want to track the number of times a page or email is opened. If you place your Pretty Link inside an img tag on the page (Example: <code>&lt;img src="<?php echo $prli_blogurl . "/yourslug"; ?>" /&gt;</code>) then the page load will be tracked as a click and then displayed. Note: If this option is selected your Target URL will simply be ignored if there's a value in it.</span>
    </td>
  </tr>
</table>
</div>

<p class="submit">
<input type="submit" name="Submit" value="Update" />&nbsp;or&nbsp;<a href="?page=<?php echo PRLI_PLUGIN_NAME ?>/prli-links.php">Cancel</a>
</p>

</form>
</div>
