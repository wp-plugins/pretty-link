<div class="wrap">
  <img style="float: left;" src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/><div style="min-height: 36px;"><div style="min-height: 18px; margin-left: 45px; margin-top: 0px; padding-top: 0px; border: 1px solid #e5e597; background-color: #ffffa0; display: block;"><p style="font-size: 12px; margin:0px; padding: 0px; padding-left: 10px;"><?php echo $message; ?></p></div></div>

<form name="form1" method="post" action="?page=<?php echo PRLI_PLUGIN_NAME ?>/prli-links.php">
<input type="hidden" name="action" value="quick-create">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
  <tr class="form-field">
    <td width="75px" valign="top">Target URL*</td>
    <td><input type="text" name="url" value="" size="75">
  </tr>
  <tr>
    <td valign="top">Pretty Link*</td>
    <td><strong><?php echo $prli_blogurl; ?></strong>/<input type="text" name="slug" value="<?php echo $prli_link->generateValidSlug(); ?>">
  </tr>
</table>

<p class="submit">
<input type="submit" name="Submit" value="Create" />
</p>
</form>
</div>
