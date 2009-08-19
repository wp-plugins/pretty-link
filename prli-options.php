<?php
require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$errors = array();

// variables for the field and option names 
$prli_exclude_ips  = 'prli_exclude_ips';
$prettybar_image_url  = 'prli_prettybar_image_url';
$prettybar_background_image_url  = 'prli_prettybar_background_image_url';
$prettybar_color  = 'prli_prettybar_color';
$prettybar_text_color  = 'prli_prettybar_text_color';
$prettybar_link_color  = 'prli_prettybar_link_color';
$prettybar_hover_color  = 'prli_prettybar_hover_color';
$prettybar_visited_color  = 'prli_prettybar_visited_color';
$prettybar_show_title  = 'prli_prettybar_show_title';
$prettybar_show_description  = 'prli_prettybar_show_description';
$prettybar_show_share_links  = 'prli_prettybar_show_share_links';
$prettybar_show_target_url_link  = 'prli_prettybar_show_target_url_link';
$prettybar_title_limit = 'prli_prettybar_title_limit';
$prettybar_desc_limit = 'prli_prettybar_desc_limit';
$prettybar_link_limit = 'prli_prettybar_link_limit';

$link_track_me = 'prli_link_track_me';
$link_nofollow = 'prli_link_nofollow';
$link_redirect_type = 'prli_link_redirect_type';
$hidden_field_name = 'prli_update_options';

$prli_domain = "pretty-link";

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( $_POST[ $hidden_field_name ] == 'Y' ) 
{
  // Validate This
  if( !empty($_POST[$prettybar_image_url]) and !preg_match('/^http.?:\/\/.*\..*$/', $_POST[$prettybar_image_url] ) )
    $errors[] = "Logo Image URL must be a correctly formatted URL";

  if( !empty($_POST[$prettybar_background_image_url]) and !preg_match('/^http.?:\/\/.*\..*$/', $_POST[$prettybar_background_image_url] ) )
    $errors[] = "Background Image URL must be a correctly formatted URL";

  if( !empty($_POST[ $prli_exclude_ips ]) and !preg_match( "#^[ \t]*(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})([ \t]*,[ \t]*\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*$#", $_POST[ $prli_exclude_ips ] ) )
    $errors[] = "Must be a comma separated list of IP addresses.";

  if( !empty($_POST[ $prettybar_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_color ] ) )
    $errors[] = "PrettyBar Background Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_text_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_text_color ] ) )
    $errors[] = "PrettyBar Text Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_link_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_link_color ] ) )
    $errors[] = "PrettyBar Link Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_hover_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_hover_color ] ) )
    $errors[] = "PrettyBar Hover Color must be an actual RGB Value";

  if( !empty($_POST[ $prettybar_visited_color ]) and !preg_match( "#^[0-9a-fA-F]{6}$#", $_POST[ $prettybar_visited_color ] ) )
    $errors[] = "PrettyBar Hover Color must be an actual RGB Value";

  if( empty($_POST[ $prettybar_title_limit ]) )
    $errors[] = "PrettyBar Title Character Limit must not be blank";

  if( empty($_POST[ $prettybar_desc_limit ]) )
    $errors[] = "PrettyBar Description Character Limit must not be blank";

  if( empty($_POST[ $prettybar_link_limit ]) )
    $errors[] = "PrettyBar Link Character Limit must not be blank";

  if( !empty($_POST[ $prettybar_title_limit ]) and !preg_match( "#^[0-9]*$#", $_POST[ $prettybar_title_limit ] ) )
    $errors[] = "PrettyBar Title Character Limit must be a number";

  if( !empty($_POST[ $prettybar_desc_limit ]) and !preg_match( "#^[0-9]*$#", $_POST[ $prettybar_desc_limit ] ) )
    $errors[] = "PrettyBar Description Character Limit must be a number";

  if( !empty($_POST[ $prettybar_link_limit ]) and !preg_match( "#^[0-9]*$#", $_POST[ $prettybar_link_limit ] ) )
    $errors[] = "PrettyBar Link Character Limit must be a number";

  // Read their posted value
  $prli_options->prli_exclude_ips = stripslashes($_POST[ $prli_exclude_ips ]);
  $prli_options->prettybar_image_url = stripslashes($_POST[ $prettybar_image_url ]);
  $prli_options->prettybar_background_image_url = stripslashes($_POST[ $prettybar_background_image_url ]);
  $prli_options->prettybar_color = stripslashes($_POST[ $prettybar_color ]);
  $prli_options->prettybar_text_color = stripslashes($_POST[ $prettybar_text_color ]);
  $prli_options->prettybar_link_color = stripslashes($_POST[ $prettybar_link_color ]);
  $prli_options->prettybar_hover_color = stripslashes($_POST[ $prettybar_hover_color ]);
  $prli_options->prettybar_visited_color = stripslashes($_POST[ $prettybar_visited_color ]);
  $prli_options->prettybar_show_title = (int)isset($_POST[ $prettybar_show_title ]);
  $prli_options->prettybar_show_description = (int)isset($_POST[ $prettybar_show_description ]);
  $prli_options->prettybar_show_share_links = (int)isset($_POST[ $prettybar_show_share_links ]);
  $prli_options->prettybar_show_target_url_link = (int)isset($_POST[ $prettybar_show_target_url_link ]);
  $prli_options->prettybar_title_limit = stripslashes($_POST[ $prettybar_title_limit ]);
  $prli_options->prettybar_desc_limit = stripslashes($_POST[ $prettybar_desc_limit ]);
  $prli_options->prettybar_link_limit = stripslashes($_POST[ $prettybar_link_limit ]);
  $prli_options->link_track_me = (int)isset($_POST[ $link_track_me ]);
  $prli_options->link_nofollow = (int)isset($_POST[ $link_nofollow ]);
  $prli_options->link_redirect_type = $_POST[ $link_redirect_type ];

  if( count($errors) > 0 )
  {
    require(PRLI_VIEWS_PATH.'/shared/errors.php');
  }
  else
  {
    // Save the posted value in the database
    $prli_options_str = serialize($prli_options);

    // Save the posted value in the database
    delete_option( 'prli_options' );
    add_option( 'prli_options', $prli_options_str );


    // Put an options updated message on the screen
?>

<div class="updated"><p><strong><?php _e('Options saved.', $prli_domain ); ?></strong></p></div>
<?php
  }
}
else if($_GET['action'] == 'clear_all_clicks4134' or $_POST['action'] == 'clear_all_clicks4134')
{
  $prli_click->clearAllClicks();
?>

<div class="updated"><p><strong><?php _e('Hit Database Was Cleared.', $prli_domain ); ?></strong></p></div>
<?php
}

require_once 'classes/views/prli-options/form.php';

?>
