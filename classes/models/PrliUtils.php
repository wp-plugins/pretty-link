<?php
require_once 'models.inc.php';

class PrliUtils
{

/** Okay I realize that Percentagize isn't really a word but
  * this is so that the values we have will work with google
  * charts.
  */
function percentagizeArray($data,$max_value)
{
    $new_data = array();
    foreach($data as $point)
    {
        if( $max_value > 0 )
        {
            $new_data[] = $point / $max_value * 100;
        }
        else
        {
            $new_data[] = 0;
        }
    }
    return $new_data;
}

function getTopValue($values_array)
{
  rsort($values_array);
  return $values_array[0];
}

function getFirstClickDate()
{
  global $wpdb;

  $clicks_table = $wpdb->prefix . "prli_clicks";
  $query = "SELECT created_at FROM $clicks_table ORDER BY created_at LIMIT 1";
  $first_click = $wpdb->get_var($query);

  if(isset($first_click))
  {
    return strtotime($first_click);
  }
  else
    return null; 
}

function getMonthsArray()
{
    global $wpdb;
    global $prli_click;

    $months = array(); 
    $year = date("Y");
    $month = date("m");
    $current_timestamp = time();
    $current_month_timestamp = mktime(0, 0, 0, date("m", $current_timestamp), 1, date("Y", $current_timestamp));

    $clicks_table = $prli_click->tableName();
    $first_click = $wpdb->get_var("SELECT created_at FROM $clicks_table ORDER BY created_at LIMIT 1;");
    $first_timestamp = ((empty($first_click))?$current_timestamp:strtotime($first_click));
    $first_date = mktime(0, 0, 0, date("m", $first_timestamp), 1, date("Y", $first_timestamp));

    while($current_month_timestamp >= $first_date)
    {
        $months[] = $current_month_timestamp;
        if(date("m") == 1)
        {
          $current_month_timestamp = mktime(0, 0, 0, 12, 1, date("Y", $current_month_timestamp)-1);
        }
        else
        {
          $current_month_timestamp = mktime(0, 0, 0, date("m", $current_month_timestamp)-1, 1, date("Y", $current_month_timestamp));
        }
    }
    return $months;
}

// For Pagination
function getLastRecordNum($r_count,$current_p,$p_size)
{
    return (($r_count < ($current_p * $p_size))?$r_count:($current_p * $p_size));
}

// For Pagination
function getFirstRecordNum($r_count,$current_p,$p_size)
{
    if($current_p == 1)
    {
      return 1;
    }
    else
    {
      return ($this->getLastRecordNum($r_count,($current_p - 1),$p_size) + 1);
    }
}

function slugIsAvailable($slug)
{
  global $wpdb;

  $posts_table = $wpdb->prefix . "posts";
  $terms_table = $wpdb->prefix . "terms";

  $post_slug = $wpdb->get_var("SELECT post_name FROM $posts_table WHERE post_name='$slug'");
  $term_slug = $wpdb->get_col("SELECT slug FROM $terms_table WHERE slug='$slug'");

  return ( $post_slug != $slug and $term_slug != $slug );
}

/* Needed because we don't know if the target uesr will have a browsercap file installed
   on their server ... particularly in a shared hosting environment this is difficult
*/
function php_get_browser($agent = NULL)
{
  $agent=$agent?$agent:$_SERVER['HTTP_USER_AGENT'];
  $yu=array();
  $q_s=array("#\.#","#\*#","#\?#");
  $q_r=array("\.",".*",".?");
  $brows=parse_ini_file(PRLI_PATH."/includes/php/php_browsecap.ini",true);
  foreach($brows as $k=>$t)
  {
    if(fnmatch($k,$agent))
    {
      $yu['browser_name_pattern']=$k;
      $pat=preg_replace($q_s,$q_r,$k);
      $yu['browser_name_regex']=strtolower("^$pat$");
      foreach($brows as $g=>$r)
      {
        if($t['Parent']==$g)
        {
          foreach($brows as $a=>$b)
          {
            if($r['Parent']==$a)
            {
              $yu=array_merge($yu,$b,$r,$t);
              foreach($yu as $d=>$z)
              {
                $l=strtolower($d);
                $hu[$l]=$z;
              }
            }
          }
        }
      }

      break;
    }
  }

  return $hu;
}

function track_link($slug,$values)
{
  global $wpdb;
  $click_table = $wpdb->prefix . "prli_clicks";
  $pretty_links_table = $wpdb->prefix . "prli_links";
  
  $query = "SELECT * FROM $pretty_links_table WHERE slug='$slug' LIMIT 1";
  $pretty_link = $wpdb->get_row($query);
  
  $first_click = false;
  
  $click_ip = $_SERVER['REMOTE_ADDR'];
  $click_referer = $_SERVER['HTTP_REFERER'];
  $click_host = gethostbyaddr($click_ip);
  
  $click_uri = $_SERVER['REQUEST_URI'];
  $click_user_agent = $_SERVER['HTTP_USER_AGENT'];
  $click_browser = $this->php_get_browser();
  
  //Set Cookie if it doesn't exist
  $cookie_name = 'prli_click_' . $pretty_link->id;
  $cookie_expire_time = time()+60*60*24*30; // Expire in 30 days
  
  if($_COOKIE[$cookie_name] == null)
  {
      setcookie($cookie_name,$slug,$cookie_expire_time);
      $first_click = true;
  }
  
  //Record Click in DB
  $insert = "INSERT INTO $click_table (link_id,ip,browser,btype,bversion,os,referer,uri,host,first_click,created_at) VALUES ($pretty_link->id,'$click_ip','$click_user_agent','".$click_browser['browser']."','".$click_browser['version']."','".$click_browser['platform']."','$click_referer','$click_uri','$click_host','$first_click',NOW())";
  
  $results = $wpdb->query( $insert );
  
  $param_string = '';
  
  if(isset($pretty_link->param_forwarding) and $pretty_link->param_forwarding and isset($values) and count($values) > 1)
  {
    $first_param = true;
    foreach($values as $key => $value)
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
  if(!isset($pretty_link->track_as_img) or $pretty_link->track_as_img == 0)
  {
    wp_redirect($pretty_link->url.$param_string, (int)$pretty_link->redirect_type);
  }
}

function get_custom_forwarding_rule($param_struct)
{
  $param_struct = preg_replace('#%.*?%#','(.*?)',$param_struct);
  return preg_replace('#\(\.\*\?\)$#','(.*)',$param_struct); // replace the last one with a greedy operator
}

function get_custom_forwarding_params($param_struct, $start_index = 1)
{
  preg_match_all('#%(.*?)%#', $param_struct, $matches);

  $param_string = '';
  $match_index = $start_index;
  for($i = 0; $i < count($matches[1]); $i++)
  {
    if($i == 0 and $start_index == 1)
      $param_string .= "?";
    else
      $param_string .= "&";

    $param_string .= $matches[1][$i] . "=$$match_index";
    $match_index++;
  }

  return $param_string;
}

function decode_custom_param_str($param_struct, $uri_string)
{
  // Get the structure matches (param names)
  preg_match_all('#%(.*?)%#', $param_struct, $struct_matches);

  // Get the uri matches (param values)
  $match_str = '#'.$this->get_custom_forwarding_rule($param_struct).'#';
  preg_match($match_str, $uri_string, $uri_matches);

  $param_array = array();
  for($i = 0; $i < count($struct_matches[1]); $i++)
    $param_array[$struct_matches[1][$i]] = $uri_matches[$i+1];

  return $param_array;
}

}
?>
