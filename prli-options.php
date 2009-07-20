<?php
require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$errors = array();

if($_GET['action'] == 'pro-settings' OR $_POST['action'] == 'pro-settings')
{
  // variables for the field and option names 
  $prlipro_username = 'prlipro_username';
  $prlipro_password = 'prlipro_password';
  $hidden_field_name = 'prli_update_options';
  
  $prli_domain = "pretty-link";
  
  // Read in existing option value from database
  $prlipro_username_val = get_option( $prlipro_username );
  $prlipro_password_val = get_option( $prlipro_password );
  
  if($_GET['action'] == 'force-pro-reinstall')
  {
    $prli_utils->download_and_install_pro($prlipro_username_val, $prlipro_password_val, true);
    ?>
    
    <div class="updated"><p><strong><?php _e('Pretty Link Pro Successfully Reinstalled.', $prli_domain ); ?></strong></p></div>
    <?php
  }
  else
  {
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) 
    {
      // Validate This
      // This is where the remote username / password will be validated
      //if( !empty($_POST[$prettybar_image_url]) and !preg_match('/^http.?:\/\/.*\..*$/', $_POST[$prettybar_image_url] ) )
      //  $errors[] = "Logo Image URL must be a correctly formatted URL";
    
      // Read their posted value
      $prlipro_username_val = stripslashes($_POST[ $prlipro_username ]);
      $prlipro_password_val = stripslashes($_POST[ $prlipro_password ]);
    
      if( count($errors) > 0 )
      {
        require(PRLI_VIEWS_PATH.'/shared/errors.php');
      }
      else
      {
        // TODO: Download & Install Pretty Link Pro if Account is valid and software isn't currently installed
        // Save the posted value in the database
        update_option( $prlipro_username, $prlipro_username_val );
        update_option( $prlipro_password, $prlipro_password_val );
    
        // Put an options updated message on the screen
        $message = $prli_utils->download_and_install_pro($prlipro_username_val, $prlipro_password_val, true);
  
        $message = (($message == 'SUCCESS')?'Pretty Link Pro has been installed click here to get started: <a href="/wp-admin/options-general.php?page=pretty-link/pro/prlipro-options.php">Pretty Link Pro Options</a>':$message);
    ?>
    
    <div class="updated"><p><strong><?php _e($message, $prli_domain ); ?></strong></p></div>
    <?php
      }
    }
  }
  
  require_once 'classes/views/prli-options/pro-settings.php';
  
}
else
{
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
  $link_show_prettybar = 'prli_link_show_prettybar';
  $link_ultra_cloak = 'prli_link_ultra_cloak';
  $link_track_me = 'prli_link_track_me';
  $link_track_as_pixel = 'prli_link_track_as_pixel';
  $link_nofollow = 'prli_link_nofollow';
  $link_redirect_type = 'prli_link_redirect_type';
  $hidden_field_name = 'prli_update_options';
  
  $prli_domain = "pretty-link";
  
  // Read in existing option value from database
  $prli_exclude_ips_val = get_option( $prli_exclude_ips );
  $prettybar_image_url_val = get_option( $prettybar_image_url );
  $prettybar_background_image_url_val = get_option( $prettybar_background_image_url );
  $prettybar_color_val = get_option( $prettybar_color );
  $prettybar_text_color_val = get_option( $prettybar_text_color );
  $prettybar_link_color_val = get_option( $prettybar_link_color );
  $prettybar_hover_color_val = get_option( $prettybar_hover_color );
  $prettybar_visited_color_val = get_option( $prettybar_visited_color );
  $prettybar_show_title_val = get_option( $prettybar_show_title );
  $prettybar_show_description_val = get_option( $prettybar_show_description );
  $prettybar_show_share_links_val = get_option( $prettybar_show_share_links );
  $prettybar_show_target_url_link_val = get_option( $prettybar_show_target_url_link );
  $prettybar_title_limit_val = get_option( $prettybar_title_limit );
  $prettybar_desc_limit_val = get_option( $prettybar_desc_limit );
  $prettybar_link_limit_val = get_option( $prettybar_link_limit );
  $link_show_prettybar_val = get_option( $link_show_prettybar );
  $link_ultra_cloak_val = get_option( $link_ultra_cloak );
  $link_track_me_val = get_option( $link_track_me );
  $link_track_as_pixel_val = get_option( $link_track_as_pixel );
  $link_nofollow_val = get_option( $link_nofollow );
  $link_redirect_type_val = get_option( $link_redirect_type );
  
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
    $prli_exclude_ips_val = stripslashes($_POST[ $prli_exclude_ips ]);
    $prettybar_image_url_val = stripslashes($_POST[ $prettybar_image_url ]);
    $prettybar_background_image_url_val = stripslashes($_POST[ $prettybar_background_image_url ]);
    $prettybar_color_val = stripslashes($_POST[ $prettybar_color ]);
    $prettybar_text_color_val = stripslashes($_POST[ $prettybar_text_color ]);
    $prettybar_link_color_val = stripslashes($_POST[ $prettybar_link_color ]);
    $prettybar_hover_color_val = stripslashes($_POST[ $prettybar_hover_color ]);
    $prettybar_visited_color_val = stripslashes($_POST[ $prettybar_visited_color ]);
    $prettybar_show_title_val = (int)isset($_POST[ $prettybar_show_title ]);
    $prettybar_show_description_val = (int)isset($_POST[ $prettybar_show_description ]);
    $prettybar_show_share_links_val = (int)isset($_POST[ $prettybar_show_share_links ]);
    $prettybar_show_target_url_link_val = (int)isset($_POST[ $prettybar_show_target_url_link ]);
    $prettybar_title_limit_val = stripslashes($_POST[ $prettybar_title_limit ]);
    $prettybar_desc_limit_val = stripslashes($_POST[ $prettybar_desc_limit ]);
    $prettybar_link_limit_val = stripslashes($_POST[ $prettybar_link_limit ]);
    $link_show_prettybar_val = (int)isset($_POST[ $link_show_prettybar ]);
    $link_ultra_cloak_val = (int)isset($_POST[ $link_ultra_cloak ]);
    $link_track_me_val = (int)isset($_POST[ $link_track_me ]);
    $link_track_as_pixel_val = (int)isset($_POST[ $link_track_as_pixel ]);
    $link_nofollow_val = (int)isset($_POST[ $link_nofollow ]);
    $link_redirect_type_val = $_POST[ $link_redirect_type ];
  
    if( count($errors) > 0 )
    {
      require(PRLI_VIEWS_PATH.'/shared/errors.php');
    }
    else
    {
      // Save the posted value in the database
      update_option( $prli_exclude_ips, $prli_exclude_ips_val );
      update_option( $prettybar_image_url, $prettybar_image_url_val );
      update_option( $prettybar_background_image_url, $prettybar_background_image_url_val );
      update_option( $prettybar_color, $prettybar_color_val );
      update_option( $prettybar_text_color, $prettybar_text_color_val );
      update_option( $prettybar_link_color, $prettybar_link_color_val );
      update_option( $prettybar_hover_color, $prettybar_hover_color_val );
      update_option( $prettybar_visited_color, $prettybar_visited_color_val );
      update_option( $prettybar_show_title, $prettybar_show_title_val );
      update_option( $prettybar_show_description, $prettybar_show_description_val );
      update_option( $prettybar_show_share_links, $prettybar_show_share_links_val );
      update_option( $prettybar_show_target_url_link, $prettybar_show_target_url_link_val );
      update_option( $prettybar_title_limit, $prettybar_title_limit_val );
      update_option( $prettybar_desc_limit, $prettybar_desc_limit_val );
      update_option( $prettybar_link_limit, $prettybar_link_limit_val );
      update_option( $link_show_prettybar, $link_show_prettybar_val );
      update_option( $link_ultra_cloak, $link_ultra_cloak_val );
      update_option( $link_track_me, $link_track_me_val );
      update_option( $link_track_as_pixel, $link_track_as_pixel_val );
      update_option( $link_nofollow, $link_nofollow_val );
      update_option( $link_redirect_type, $link_redirect_type_val );
  
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
}

?>
