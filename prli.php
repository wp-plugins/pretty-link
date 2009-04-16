<?php
/* This file tracks clicks */

require_once(dirname(__FILE__) . '/../../../wp-config.php');
require_once(dirname(__FILE__) . '/prli-config.php');
require_once(PRLI_MODELS_PATH . '/models.inc.php');

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

    // Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040803 Firefox/0.9.3
    // Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.0.8) Gecko/2009032608 Firefox/3.0.8
    // Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7
    // Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)
    // Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_6; en-us) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.2.1 Safari/525.27.1
    $click_ip = $_SERVER['REMOTE_ADDR'];
    $click_referer = $_SERVER['HTTP_REFERER'];
    $click_host = gethostbyaddr($click_ip);

    $click_user_agent = $_SERVER['HTTP_USER_AGENT'];
    $click_browser = $prli_utils->php_get_browser();

    //Set Cookie if it doesn't exist
    $cookie_name = 'prli_click_' . $pretty_link->id;
    $cookie_expire_time = time()+60*60*24*30; // Expire in 30 days

    if($_COOKIE[$cookie_name] == null)
    {
        setcookie($cookie_name,$slug,$cookie_expire_time);
        $first_click = true;
    }

    //Record Click in DB
    $insert = "INSERT INTO $click_table (link_id,ip,browser,btype,bversion,os,referer,host,first_click,created_at) VALUES ($pretty_link->id,'$click_ip','$click_user_agent','".$click_browser['browser']."','".$click_browser['version']."','".$click_browser['platform']."','$click_referer','$click_host','$first_click',NOW())";

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
