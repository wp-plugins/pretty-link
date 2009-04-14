<?php
/* This file tracks clicks */

require_once(dirname(__FILE__) . '/../../../wp-config.php');

// reverse compatibility -- get rid of this within the next couple of releases
if( !isset($_GET['sprli']) and isset($_GET['s']) )
  $_GET['sprli'] = $_GET['s'];

if( $_GET['sprli'] != null and $_GET['sprli'] != '' )
{
    $slug = $_GET['sprli'];

    $click_table = $wpdb->prefix . "prli_clicks";
    $pretty_links_table = $wpdb->prefix . "prli_links";

    $query = "SELECT * FROM $pretty_links_table WHERE slug='$slug' LIMIT 1";
    $pretty_link = $wpdb->get_row($query);

    $first_click = false;

    $click_ip = $_SERVER['REMOTE_ADDR'];
    $click_browser = $_SERVER['HTTP_USER_AGENT'];

    //Set Cookie if it doesn't exist
    $cookie_name = 'prli_click_' . $pretty_link->id;
    $cookie_expire_time = time()+60*60*24*30; // Expire in 30 days

    if($_COOKIE[$cookie_name] == null)
    {
        setcookie($cookie_name,$slug,$cookie_expire_time);
        $first_click = true;
    }

    //Record Click in DB
    $insert = "INSERT INTO $click_table (link_id,ip,browser,first_click,created_at) VALUES ($pretty_link->id,'$click_ip','$click_browser','$first_click',NOW())";

    $results = $wpdb->query( $insert );

    $param_string = '';

    if(isset($pretty_link->forward_params) and $pretty_link->forward_params and isset($_GET) and count($_GET) > 1)
    {
      $first_param = true;
      foreach($_GET as $key => $value)
      {
        // Ignore the 'sprli' parameter
        if($key != 'sprli')
        {
          if($first_param)
          {
            $param_string = (preg_match("#\?#", $pretty_link->url)?"&":"?");
            $first_param = false;
          }
          else
            $param_string .= "&";

          $param_string .= "$key=$value";
        }
      }
    }

    //Redirect to Product URL
    if(isset($pretty_link->track_as_img) and $pretty_link->track_as_img)
    {
      $size = getimagesize($pretty_link->url); 
      header('Content-Type: '.$size['mime']);
      echo file_get_contents($pretty_link->url.$param_string);
    }
    else
      header("Location: $pretty_link->url".$param_string);
}
?>
