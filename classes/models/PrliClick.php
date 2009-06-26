<?php
class PrliClick
{
    function table_name()
    {
      global $wpdb;
      return $wpdb->prefix . 'prli_clicks';
    }

    function get_ip_exclude_list()
    {
      $exclude_list = get_option('prli_exclude_ips');
      $exclude_list = preg_replace('#[ \t]#','',$exclude_list);

      if($exclude_list)
        return "'" . implode("','", explode(',',$exclude_list)) . "'";
      else
        return '';
    }

    function get_exclude_where_clause( $where = '', $abbr = 'cl')
    {
      $exclude_list = $this->get_ip_exclude_list();

      if($where == '')
        $starts_with = '';
      else
        $starts_with = ' AND';
      
      if( $exclude_list != '')
        return $starts_with . " $abbr.ip NOT IN (" . $exclude_list . ')';
      else
        return '';
    }

    function getOne( $id )
    {
        global $wpdb, $prli_link, $prli_utils;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT cl.*, (SELECT count(*) FROM '. $this->table_name() .' cl2 WHERE cl2.ip = cl.ip) as ip_count, (SELECT count(*) FROM '. $this->table_name() .' cl3 WHERE cl3.vuid = cl.vuid) as vuid_count, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id AND id=' . $id . $prli_utils->prepend_and_or_where(' AND',$this->get_exclude_where_clause());
    
        return $wpdb->get_row($query);
    }

    // SELECT cl.*,li.name as link_name FROM wp_prli_clicks cl, wp_prli_links li WHERE li.id = cl.link_id ORDER BY created_at DESC
    function getAll($where = '', $order = '')
    {
        global $wpdb, $prli_link, $prli_utils;
        $click_table = $wpdb->prefix . "prli_clicks";
        $where .= $this->get_exclude_where_clause( $where );
        $where = $prli_utils->prepend_and_or_where(' AND', $where);
        $query = 'SELECT cl.*, (SELECT count(*) FROM '. $this->table_name() .' cl2 WHERE cl2.ip = cl.ip) as ip_count, (SELECT count(*) FROM '. $this->table_name() .' cl3 WHERE cl3.vuid = cl.vuid) as vuid_count, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id' . $where . $order;
        return $wpdb->get_results($query);
    }

    // Delete all of the clicks from the database.
    function clearAllClicks()
    {
      global $wpdb;
      $query = "TRUNCATE TABLE " . $this->table_name();
      return $wpdb->query($query);
    }

    // Pagination Methods
    function getRecordCount($where='')
    {
        global $wpdb, $prli_link, $prli_utils;
        $where .= $this->get_exclude_where_clause( $where );
        $where = $prli_utils->prepend_and_or_where(' WHERE', $where);
        $query = 'SELECT COUNT(*) FROM ' . $this->table_name() . ' cl'. $where;
        return $wpdb->get_var($query);
    }

    function getPageCount($p_size, $where='')
    {
        return ceil((int)$this->getRecordCount($where) / (int)$p_size);
    }

    function getPage($current_p,$p_size, $where = '', $order = '')
    {
        global $wpdb, $prli_link, $prli_utils;
        $click_table = $wpdb->prefix . "prli_clicks";
        $end_index = $current_p * $p_size;
        $start_index = $end_index - $p_size;
        $where .= $this->get_exclude_where_clause( $where );
        $where = $prli_utils->prepend_and_or_where(' AND', $where);
        $query = 'SELECT cl.*, (SELECT count(*) FROM '. $this->table_name() .' cl2 WHERE cl2.ip = cl.ip) as ip_count, (SELECT count(*) FROM '. $this->table_name() .' cl3 WHERE cl3.vuid = cl.vuid) as vuid_count, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id' . $where . $order . ' LIMIT ' . $start_index . ',' . $p_size . ';';
        $results = $wpdb->get_results($query);
        return $results;
    }

    function generateUniqueVisitorId($num_chars = 6)
    {
      global $wpdb, $prli_utils;

      // We're doing a base 36 hash which is why we're always doing everything by 36
      $max_vuid_value = pow(36,$num_chars);
      $min_vuid_value = 37; 
      $vuid = base_convert( mt_rand($min_vuid_value,$max_vuid_value), 10, 36 );
     
      $query = "SELECT DISTINCT vuid FROM ".$this->table_name();
      $vuids = $wpdb->get_col($query,0);
     
      // It is highly unlikely that we'll ever see 2 identical random vuids
      // but just in case, here's some code to prevent collisions
      while( in_array($vuid,$vuids) )
        $vuid = base_convert( mt_rand($min_vuid_value,$max_vuid_value), 10, 36 );
     
      return $vuid;
    }

    function get_counts_by_days($start_timestamp, $end_timestamp, $link_id = "all", $type = "all", $group = '')
    {
      global $wpdb, $prli_link;

      $query = "SELECT DATE(cl.created_at) as cldate,COUNT(*) as clcount FROM ".$this->table_name()." cl WHERE cl.created_at BETWEEN '".date("Y-n-j",$start_timestamp)." 00:00:00' AND '".date("Y-n-j",$end_timestamp)." 23:59:59'".$search_where.$this->get_exclude_where_clause( ' AND' );

      if($link_id != "all")
        $query .= " AND link_id=$link_id";

      if(!empty($group))
        $query .= " AND link_id IN (SELECT id FROM " . $prli_link->table_name() . " WHERE group_id=$group)";

      if($type == "unique")
        $query .= " AND first_click=1";

      $query .= ' GROUP BY DATE(cl.created_at)';

      $clicks_array = $wpdb->get_results($query);

      $temp_array = array();
      $counts_array = array();
      $dates_array = array();

      // Refactor Array for use later on
      foreach($clicks_array as $c)
        $temp_array[$c->cldate] = $c->clcount;

      // Get the dates array
      for($c = $start_timestamp; $c <= $end_timestamp; $c += 60*60*24)
        $dates_array[] = date("Y-m-d",$c);

      // Make sure counts array is in order and includes zero click days
      foreach($dates_array as $date_str)
      {
        if(isset($temp_array[$date_str]))
          $counts_array[$date_str] = $temp_array[$date_str];
        else
          $counts_array[$date_str] = 0;
      }

      return $counts_array;
    }


    function setupClickLineGraph($start_timestamp,$end_timestamp, $link_id = "all", $type = "all", $group = '')
    {
      global $wpdb, $prli_utils, $prli_link, $prli_group;

      $dates_array = $this->get_counts_by_days($start_timestamp,$end_timestamp,$link_id,$type,$group);

      $top_click_count = $prli_utils->getTopValue(array_values($dates_array));

      if(!empty($group))
        $link_slug = "group: '" . $wpdb->get_var("SELECT name FROM ".$prli_group->table_name()." WHERE id=$group") . "'";
      else if($link_id == "all")
        $link_slug = "all links";
      else
        $link_slug = "'/".$wpdb->get_var("SELECT slug FROM ".$prli_link->table_name()." WHERE id=$link_id") . "'";

      if($type == "all")
        $type_string = "All hits";
      else
        $type_string = "Unique hits";

      $json_array = array(
        "elements" => array( array( 
          "type" => "line", 
          "values" => array_values($dates_array),
          "dot-style" => array( 
            "type" => "dot",
            "dot-size" => 4,
            "colour" => "#ffc94e",
            "halo-size" => 1,
            "tip" => "#val# Hits<br>#x_label#"
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
            "rotate" => 25,
            "colour" => "#000000",
            "labels" => array_keys($dates_array) 
          )
        )
      );

      return $prli_utils->prli_json_encode($json_array);
    }


    // Set defaults and grab get or post of each possible param
    function get_params_array()
    {
      $values = array(
         'paged'  => (isset($_GET['paged'])?$_GET['paged']:(isset($_POST['paged'])?$_POST['paged']:1)),
         'l'      => (isset($_GET['l'])?$_GET['l']:(isset($_POST['l'])?$_POST['l']:'all')),
         'group'  => (isset($_GET['group'])?$_GET['group']:(isset($_POST['group'])?$_POST['group']:'')),
         'ip'     => (isset($_GET['ip'])?$_GET['ip']:(isset($_POST['ip'])?$_POST['ip']:'')),
         'vuid'   => (isset($_GET['vuid'])?$_GET['vuid']:(isset($_POST['vuid'])?$_POST['vuid']:'')),
         'sdate'  => (isset($_GET['sdate'])?$_GET['sdate']:(isset($_POST['sdate'])?$_POST['sdate']:'')),
         'edate'  => (isset($_GET['edate'])?$_GET['edate']:(isset($_POST['edate'])?$_POST['edate']:'')),
         'type'   => (isset($_GET['type'])?$_GET['type']:(isset($_POST['type'])?$_POST['type']:'all')),
         'search' => (isset($_GET['search'])?$_GET['search']:(isset($_POST['search'])?$_POST['search']:'')),
         'sort'   => (isset($_GET['sort'])?$_GET['sort']:(isset($_POST['sort'])?$_POST['sort']:'')),
         'sdir'   => (isset($_GET['sdir'])?$_GET['sdir']:(isset($_POST['sdir'])?$_POST['sdir']:''))
      );

      return $values;
    }

}
?>
