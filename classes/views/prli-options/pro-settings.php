<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2 id="prli_title">Pretty Link: Pro Account Information</h2>
<?php $this_uri = preg_replace('#&.*?$#', '', str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])); ?>
<form name="proaccount_form" method="post" action="<?php echo $this_uri; ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<input type="hidden" name="action" value="pro-settings">
<?php wp_nonce_field('update-options'); ?>

<h3>Pretty Link Pro Account Information</h3>
<table class="form-table">
  <tr class="form-field">
    <td valign="top" width="15%"><?php _e("Pretty Link Pro Username*:", $prlipro_username ); ?> </td>
    <td width="85%">
      <input type="text" name="<?php echo $prlipro_username; ?>" value="<?php echo $prlipro_username_val; ?>"/>
      <br/><span class="description">Your Pretty Link Pro Username.</span>
    </td>
  </tr>
  <tr class="form-field">
    <td valign="top" width="15%"><?php _e("Pretty Link Pro Password:", $prlipro_password ); ?> </td>
    <td width="85%">
      <input type="password" name="<?php echo $prlipro_password; ?>" value="<?php echo $prlipro_password_val; ?>"/>
      <br/><span class="description">Your Pretty Link Pro Password.</span>
    </td>
  </tr>
</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save', $prli_domain ) ?>" />
</p>

<a href="http://prettylinkpro.com">Get Pretty Link Pro</a><?php if($prli_utils->pro_is_installed()) { ?>&nbsp;|&nbsp;<a href="<?php echo $this_uri; ?>&action=force-pro-reinstall">Re-Install Pretty Link Pro</a><?php } ?>

</form>
</div>
