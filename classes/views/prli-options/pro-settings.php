<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2 id="prli_title">Pretty Link: Pro Account Information</h2>
<?php $this_uri = preg_replace('#&.*?$#', '', str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])); ?>
<form name="proaccount_form" method="post" action="<?php echo $this_uri; ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<input type="hidden" name="action" value="pro-settings">
<?php wp_nonce_field('update-options'); ?>

<h3>Pretty Link Pro Account Information</h3>
<?php if($prli_utils->pro_is_installed()) { ?>
  <p><a href="http://prettylinkpro.com/user-manual">User Manual</a></p>
<?php } ?>
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

<?php if($prli_utils->pro_is_installed()) { ?>
  <div><p><strong>The <?php echo $prli_utils->get_pro_version(); ?> Version of Pretty LInk Pro is Installed</strong></p><p><a href="<?php echo $this_uri; ?>&action=force-pro-reinstall" title="Re-Install">Re-Install</a>&nbsp;|&nbsp;<a href="<?php echo $this_uri; ?>&action=pro-uninstall" onclick="return confirm('Are you sure you want to Un-Install Pretty Link Pro? This will delete your pro username & password from your local database, remove all the pro software but will leave all your data intact incase you want to reinstall sometime :) ...');" title="Un-Install" >Un-Install</a></p><br/><p><strong>Edit/Update Your Profile:</strong><br/><span class="description">Use your account username and password to log in to your Account and Affiliate Control Panel</span></p><p><a href="http://prettylinkpro.com/amember/member.php">Account</a>&nbsp;|&nbsp;<a href="http://prettylinkpro.com/amember/aff_member.php">Affiliate Control Panel</a></div>
  
<?php } else { ?>
  <a href="http://prettylinkpro.com">Upgrade to Pretty Link Pro</a>
<?php } ?>

</form>
</div>
