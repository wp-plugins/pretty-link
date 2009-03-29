<?php
require_once 'models.inc.php';

class PrliUtils
{

/** Okay I realize that Percentagize isn't really a word but
  * this is so that the values we have will work with google
  * charts.
  */
public function percentagizeArray($data,$max_value)
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

public function getTopValue($values_array)
{
  rsort($values_array);
  return $values_array[0];
}


public function getMonthsArray()
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
public function getLastRecordNum($r_count,$current_p,$p_size)
{
    return (($r_count < ($current_p * $p_size))?$r_count:($current_p * $p_size));
}

// For Pagination
public function getFirstRecordNum($r_count,$current_p,$p_size)
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

public function slugIsAvailable($slug)
{
  global $wpdb;

  $posts_table = $wpdb->prefix . "posts";
  $terms_table = $wpdb->prefix . "terms";

  $post_slug = $wpdb->get_var("SELECT post_name FROM $posts_table WHERE post_name='$slug'");
  $term_slug = $wpdb->get_col("SELECT slug FROM $terms_table WHERE slug='$slug'");

  return ( $post_slug != $slug and $term_slug != $slug );
}

};
?>
