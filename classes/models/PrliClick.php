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

    function get_exclude_where_clause( $where = '')
    {
      $exclude_list = $this->get_ip_exclude_list();

      if($where == '')
        $starts_with = '';
      else
        $starts_with = ' AND';
      
      if( $exclude_list != '')
        return $starts_with . ' cl.ip NOT IN (' . $exclude_list . ')';
      else
        return '';
    }

    function prepend_and_or_where( $starts_with = ' WHERE', $where = '' )
    {
      return (( $where == '' )?'':$starts_with . $where);
    }

    function getOne( $id )
    {
        global $wpdb, $prli_link;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT cl.*, (SELECT count(*) FROM '. $this->table_name() .' cl2 WHERE cl2.ip = cl.ip) as ip_count, (SELECT count(*) FROM '. $this->table_name() .' cl3 WHERE cl3.vuid = cl.vuid) as vuid_count, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id AND id=' . $id . $this->prepend_and_or_where(' AND',$this->get_exclude_where_clause());
    
        return $wpdb->get_row($query);
    }

    // SELECT cl.*,li.name as link_name FROM wp_prli_clicks cl, wp_prli_links li WHERE li.id = cl.link_id ORDER BY created_at DESC
    function getAll($where = '', $order = '')
    {
        global $wpdb, $prli_link;
        $click_table = $wpdb->prefix . "prli_clicks";
        $where .= $this->get_exclude_where_clause( $where );
        $where = $this->prepend_and_or_where(' AND', $where);
        $query = 'SELECT cl.*, (SELECT count(*) FROM '. $this->table_name() .' cl2 WHERE cl2.ip = cl.ip) as ip_count, (SELECT count(*) FROM '. $this->table_name() .' cl3 WHERE cl3.vuid = cl.vuid) as vuid_count, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id' . $where . $order;
        return $wpdb->get_results($query);
    }

    // Pagination Methods
    function getRecordCount($where='')
    {
        global $wpdb, $prli_link;
        $where .= $this->get_exclude_where_clause( $where );
        $where = $this->prepend_and_or_where(' WHERE', $where);
        $query = 'SELECT COUNT(*) FROM ' . $this->table_name() . ' cl'. $where;
        return $wpdb->get_var($query);
    }

    function getPageCount($p_size, $where='')
    {
        return ceil((int)$this->getRecordCount($where) / (int)$p_size);
    }

    function getPage($current_p,$p_size, $where = '', $order = '')
    {
        global $wpdb, $prli_link;
        $click_table = $wpdb->prefix . "prli_clicks";
        $end_index = $current_p * $p_size;
        $start_index = $end_index - $p_size;
        $where .= $this->get_exclude_where_clause( $where );
        $where = $this->prepend_and_or_where(' AND', $where);
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

}
?>
