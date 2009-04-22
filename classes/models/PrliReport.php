<?php

//include PRLI_PATH.'/includes/version-2-ichor/php-ofc-library/open-flash-chart.php';

class PrliReport {

function setupClickReport($start_timestamp,$end_timestamp, $link_id = "all", $type = "all")
{
  global $wpdb, $prli_utils, $prli_click;

  $clicks_table = $wpdb->prefix . "prli_clicks";
  $links_table = $wpdb->prefix . "prli_links";

  // Scrub times and leave the dates
  $start_timestamp = mktime(0, 0, 0, date('n', $start_timestamp), date('j', $start_timestamp), date('Y', $start_timestamp));
  $end_timestamp   = mktime(0, 0, 0, date('n', $end_timestamp),   date('j', $end_timestamp),   date('Y', $end_timestamp)  );

  $day_timestamp = $start_timestamp;
  $data_array = array();

  while($day_timestamp <= ($end_timestamp + 60*60*24))
  {
    $dyear = date('Y',$day_timestamp);
    $dmon  = date('n',$day_timestamp);
    $ddom  = date('j',$day_timestamp);

    $query = "SELECT count(*) FROM $clicks_table c2 WHERE c2.created_at BETWEEN '$dyear-$dmon-$ddom 00:00:00' AND '$dyear-$dmon-$ddom 23:59:59'" . $prli_click->get_exclude_where_clause( ' AND' );

    if($link_id != "all")
    {
      $query .= " AND link_id=$link_id";
    }

    if($type == "unique")
    {
      $query .= " AND first_click=1";
    }

    $data_array[date("Y-n-j",$day_timestamp)] = (int)$wpdb->get_var($query);
    $day_timestamp += 60*60*24; // Advance one day
  }

  $top_click_count = $prli_utils->getTopValue(array_values($data_array));

  if($link_id == "all")
    $link_slug = "all links";
  else
    $link_slug = "'".$wpdb->get_var("SELECT slug FROM $links_table WHERE id=$link_id") . "'";

  if($type == "all")
    $type_string = "All hits";
  else
    $type_string = "Unique hits";

  $json_array = array(
    "elements" => array( array( 
      "type" => "line", 
      "values" => array_values($data_array),
      "dot-style" => array( 
        "type" => "dot",
        "dot-size" => 4,
        "colour" => "#ffc94e",
        "halo-size" => 1,
        "tip" => "#val# $type_string"
      ),
      "width" => 2
    ) ),
    "title" => array(
      "text" => 'Pretty Link: '.$type_string.' on '.$link_slug. ' between ' . date("Y-n-j",$start_timestamp) . ' and ' . date("Y-n-j",$end_timestamp),
      "style" => "font-size: 16px; font-weight: bold; color: #3030d0; text-align: center; padding-bottom: 5px;"
    ),
    "bg_colour" => "-1",
    "y_axis" => array(
      "min" => 0,
      "max" => $top_click_count,
      "steps" => (int)(($top_click_count>=10)?$top_click_count/10:1),
      "colour" => "#A2ACBA"
    ),
    "x_axis" => array(
      "colour" => "#A2ACBA",
      "grid-colour" => "#ffefa7",
      "offset" => false,
      "steps" => 4,
      "labels" => array(
        "steps" => 2,
        "rotate" => 45,
        "colour" => "#000000",
        "labels" => array_keys($data_array) 
      )
    )
  );

  return $this->prli_json_encode($json_array);

  /*
  $title = new title('Pretty Link: '.$type_string.' on '.$link_slug. ' between ' . date("Y-n-j",$start_timestamp) . ' and ' . date("Y-n-j",$end_timestamp));

  $title->set_style('font-size: 16px; font-weight: bold; color: #3030d0; text-align: center; padding-bottom: 5px;');

  $default_dot = new dot();
  $default_dot->size(4);
  //$default_dot->rotation(-15);
  //$default_dot->hollow(false);
  $default_dot->colour('#ffc94e');
  $default_dot->halo_size(1);
  $default_dot->tooltip( '#val# Hits' );

  $line = new line();
  $line->set_default_dot_style($default_dot);
  $line->set_values( array_values($data_array) );
  $line->set_width(2);

  $y = new y_axis();
  $y->set_range( 0, $top_click_count, (int)(($top_click_count>=10)?$top_click_count/10:1)  ); 
  $y->set_colour( '#A2ACBA' );

  $chart = new open_flash_chart();
  $chart->set_title( $title );
  $chart->set_bg_colour("-1");
  $chart->set_y_axis( $y );
  $chart->add_element( $line );

  $x_labels = new x_axis_labels();
  $x_labels->set_steps( 2 );
  $x_labels->rotate(45);
  $x_labels->set_colour( '#000000' );
  $x_labels->set_labels( array_keys($data_array) );

  $x = new x_axis();
  $x->set_colour( '#A2ACBA' );
  $x->set_grid_colour( '#ffefa7' );
  $x->set_offset( false );
  $x->set_steps(4);

  // Add the X Axis Labels to the X Axis
  $x->set_labels( $x_labels );
  $chart->set_x_axis( $x );

  return $chart->toPrettyString();
  */
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
}

?>
