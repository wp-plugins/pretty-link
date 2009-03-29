<div class="wrap">
<h2>Pretty Link: Edit Link</h2>

<?php
  require(PRLI_VIEWS_PATH.'/shared/errors.php');
?>

<form name="form1" method="post" action="?page=<?php print PRLI_PLUGIN_NAME ?>/prli-links.php">
<input type="hidden" name="action" value="update">
<input type="hidden" name="id" value="<?php print $id; ?>">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
  <tr>
    <td width="75px">URL*: </td>
    <td><input type="text" name="url" value="<?php print (($_POST['url'] != null and $record == null)?$_POST['url']:$record->url); ?>" size="75">
      <br/><span class="setting-description">Enter the URL you want to mask and track.</span></td>
  </tr>
  <tr>
    <td>Pretty Link*: </td>
    <td><strong><?php print get_option('siteurl'); ?></strong>/<input type="text" name="slug" value="<?php print (($_POST['slug'] != null and $record == null)?$_POST['slug']:$record->slug); ?>" size="25">
    <br/><span class="setting-description">Enter the slug (word trailing your main URL) that will form your pretty link and redirect to the URL above.</span></td>
  </tr>
</table>

<p class="submit">
<input type="submit" name="Submit" value="Create" />&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME ?>/prli-links.php">Cancel</a>
</p>

</form>
</div>
