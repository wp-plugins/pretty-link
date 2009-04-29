<div class="wrap">
<h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Add Group</h2>

<?php
  require(PRLI_VIEWS_PATH.'/shared/errors.php');
?>

<form name="form1" method="post" action="?page=<?php echo PRLI_PLUGIN_NAME ?>/prli-groups.php">
<input type="hidden" name="action" value="create">
<?php wp_nonce_field('update-options'); ?>
<input type="hidden" name="id" value="<?php echo $id; ?>">

<table class="form-table">
  <tr class="form-field">
    <td width="75px" valign="top">Name*: </td>
    <td><input type="text" name="name" value="<?php echo (($_POST['name'] != null)?$_POST['name']:''); ?>" size="75">
      <br/><span class="setting-description">This is how you'll identify your Group.</span></td>
  </tr>
  <tr class="form-field">
    <td valign="top">Description: </td>
    <td><textarea style="height: 100px;" name="description"><?php echo (($_POST['description'] != null)?$_POST['description']:''); ?></textarea>
    <br/><span class="setting-description">A Description of this group.</span></td>
  </tr>
</table>
</div>

<p class="submit">
<input type="submit" name="Submit" value="Create" />&nbsp;or&nbsp;<a href="?page=<?php echo PRLI_PLUGIN_NAME ?>/prli-groups.php">Cancel</a>
</p>

</form>
</div>
