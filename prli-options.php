<?php
require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$errors = array();

// variables for the field and option names 
$prli_rewrite_mode  = 'prli_rewrite_mode';
$hidden_field_name  = 'prli_update_options';

$prli_domain = "pretty-link";

// Read in existing option value from database
$prli_rewrite_mode_val = get_option( $prli_rewrite_mode );

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( $_POST[ $hidden_field_name ] == 'Y' ) 
{
  // Validate This

  // Read their posted value
  $prli_rewrite_mode_val = stripslashes($_POST[ $prli_rewrite_mode ]);


  if( count($errors) > 0 )
  {
    require(PRLI_VIEWS_PATH.'/shared/errors.php');
  }
  else
  {
    // Save the posted value in the database
    update_option( $prli_rewrite_mode, $prli_rewrite_mode_val );

    $wp_rewrite->flush_rules();

  // Put an options updated message on the screen
?>

<div class="updated"><p><strong><?php _e('Options saved.', $prli_domain ); ?></strong></p></div>
<?php
  }
}

?>
<div class="wrap">
<h2 id="prli_title">Pretty Link: Options</h2>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
  <tr>
    <td colspan="2">
      <input type="checkbox" name="<?php echo $prli_rewrite_mode; ?>" <?php print (((isset($prli_rewrite_mode_val) and $prli_rewrite_mode_val == 'on') or (isset($_POST[$prli_rewrite_mode]) and $_POST[$prli_rewrite_mode] == 'on'))?'checked="true"':''); ?>/>&nbsp; Apache Rewrite Mode
      <br/><span class="setting-description">When Pretty Link is set to "Apache Rewrite Mode" it uses apache's mod_rewrite instead of WordPress's built in pretty permalink mechanism. This method is slightly faster than the standard mode but should only be checked if you have mod_rewrite running on your server and your apache user has permission to modify wordpress's .htaccess file.</span>
    </td>
  </tr>
</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', $prli_domain ) ?>" />
</p>

</form>
</div>
