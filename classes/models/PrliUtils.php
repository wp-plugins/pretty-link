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

// This is where the magic happens!
function track_link($slug,$values)
{
  global $wpdb, $prli_click, $prli_link;

  $query = "SELECT * FROM ".$prli_link->table_name()." WHERE slug='$slug' LIMIT 1";
  $pretty_link = $wpdb->get_row($query);
  
  if(isset($pretty_link->track_me) and $pretty_link->track_me)
  {
    $first_click = false;
    
    $click_ip = $_SERVER['REMOTE_ADDR'];
    $click_referer = $_SERVER['HTTP_REFERER'];
    $click_host = gethostbyaddr($click_ip);
    
    $click_uri = $_SERVER['REQUEST_URI'];
    $click_user_agent = $_SERVER['HTTP_USER_AGENT'];
    $click_browser = $this->php_get_browser();
    
    //Set Cookie if it doesn't exist
    $cookie_name = 'prli_click_' . $pretty_link->id;
    //Used for unique click tracking
    $cookie_expire_time = time()+60*60*24*30; // Expire in 30 days
   
    $visitor_cookie = 'prli_visitor';
    //Used for visitor activity
    $visitor_cookie_expire_time = time()+60*60*24*365; // Expire in 1 year
    
    
    if($_COOKIE[$cookie_name] == null)
    {
      setcookie($cookie_name,$slug,$cookie_expire_time);
      $first_click = true;
    }
   
    // Retrieve / Generate visitor id
    if($_COOKIE[$visitor_cookie] == null)
    {
      $visitor_uid = $prli_click->generateUniqueVisitorId();
      setcookie($visitor_cookie,$visitor_uid,$visitor_cookie_expire_time);
    }
    else
      $visitor_uid = $_COOKIE[$visitor_cookie];
   
    //Record Click in DB
    $insert = "INSERT INTO ".$prli_click->table_name()." (link_id,vuid,ip,browser,btype,bversion,os,referer,uri,host,first_click,created_at) VALUES ($pretty_link->id,'$visitor_uid','$click_ip','$click_user_agent','".$click_browser['browser']."','".$click_browser['version']."','".$click_browser['platform']."','$click_referer','$click_uri','$click_host','$first_click',NOW())";
    
    $results = $wpdb->query( $insert );
    
  }

  // Reformat Parameters
  $param_string = '';
    
  if(isset($pretty_link->param_forwarding) and $pretty_link->param_forwarding and isset($values) and count($values) > 1)
  {
    $first_param = true;
    foreach($values as $key => $value)
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
  
  //Redirect to Product URL
  if(!isset($pretty_link->track_as_img) or $pretty_link->track_as_img == 0)
  {
    if(isset($pretty_link->nofollow) and $pretty_link->nofollow)
      header('X-Robots-Tag: noindex, nofollow');

    // If we're using the pretty bar then don't redirect -- load the pretty bar view
    if( isset($pretty_link->use_prettybar) and $pretty_link->use_prettybar )
    {
      global $prli_blogurl;
      require_once PRLI_VIEWS_PATH . '/prli-links/bar.php';
    }
    else if( isset($pretty_link->use_ultra_cloak) and $pretty_link->use_ultra_cloak )
      require_once PRLI_VIEWS_PATH . '/prli-links/ultra-cloak.php';
    else
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

    // Detects whether an array is a true numerical array or an
    // associative array (or hash).
    function prli_array_type($item)
    {
      $array_type = 'unknown';

      if(is_array($item))
      {
        $array_type = 'array';

        foreach($item as $key => $value)
        {
          if(!is_numeric($key))
          {
            $array_type = 'hash';
            break;
          }
        }
      }

      return $array_type;
    }

    // This eliminates the need to use php's built in json_encoder
    // which only works with PHP 5.2 and above.
    function prli_json_encode($json_array)
    {
      $json_str = '';

      if(is_array($json_array))
      {
        if($this->prli_array_type($json_array) == 'array')
        {
          $first = true;
          $json_str .= "[";
          foreach($json_array as $item)
          {
            if(!$first)
              $json_str .= ",";

            if(is_numeric($item))
              $json_str .= (($item < 0)?"\"$item\"":$item);
            else if(is_array($item))
              $json_str .= $this->prli_json_encode($item);
            else if(is_string($item))
              $json_str .= '"'.$item.'"';
            else if(is_bool($item))
              $json_str .= (($item)?"true":"false");

            $first = false;
          }
          $json_str .= "]";
        }
        else if($this->prli_array_type($json_array) == 'hash')
        {
          $first = true;
          $json_str .= "{";
          foreach($json_array as $key => $item)
          {
            if(!$first)
              $json_str .= ",";

            $json_str .= "\"$key\":";

            if(is_numeric($item))
              $json_str .= (($item < 0)?"\"$item\"":$item);
            else if(is_array($item))
              $json_str .= $this->prli_json_encode($item);
            else if(is_string($item))
              $json_str .= "\"$item\"";
            else if(is_bool($item))
              $json_str .= (($item)?"true":"false");

            $first = false;
          }
          $json_str .= "}";
        }
      }

      return $json_str;
    }

    // Get the timestamp of the start date
    function get_start_date($values,$min_date = '')
    {
      // set default to 30 days ago
      if(empty($min_date))
        $min_date = 30;

      if(!empty($values['sdate']))
      {
        $sdate = explode("-",$values['sdate']);
        $start_timestamp = mktime(0,0,0,$sdate[1],$sdate[2],$sdate[0]);
      }
      else
        $start_timestamp = time()-60*60*24*(int)$min_date;
    
      return $start_timestamp;
    }
    
    // Get the timestamp of the end date
    function get_end_date($values)
    {
      if(!empty($values['edate']))
      {
        $edate = explode("-",$values['edate']);
        $end_timestamp = mktime(0,0,0,$edate[1],$edate[2],$edate[0]);
      }
      else
        $end_timestamp = time();
    
      return $end_timestamp;
    }

    function prepend_and_or_where( $starts_with = ' WHERE', $where = '' )
    {
      return (( $where == '' )?'':$starts_with . $where);
    }

}
?>
