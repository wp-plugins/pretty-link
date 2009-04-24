<?php
class PrliClick
{
    function table_name()
    {
      global $wpdb;
      return $wpdb->prefix . 'prli_clicks';
    }

    /*
    function create( $values )
    {
      global $wpdb, $wp_rewrite;
      $query = 'INSERT INTO ' . $this->table_name() . 
               ' (url,slug,forward_params,track_as_img,created_at) VALUES (\'' .
                     $values['url'] . '\',\'' . 
                     $values['slug'] . '\',' . 
                     (int)isset($values['forward_params']) . ',' . 
                     (int)isset($values['track_as_img']) . ',' . 
                     'NOW())';
      $query_results = $wpdb->query($query);
      $wp_rewrite->flush_rules();
      return $query_results;
    }

    function update( $id, $values )
    {
      global $wpdb, $wp_rewrite;
      $query = 'UPDATE ' . $this->table_name() . 
                  ' SET url=\'' . $values['url'] . '\', ' .
                      ' slug=\'' . $values['slug'] . '\', ' .
                      ' forward_params=' . (int)isset($values['forward_params']) . ', ' .
                      ' track_as_img=' . (int)isset($values['track_as_img']) .
                  ' WHERE id='.$id;
      $query_results = $wpdb->query($query);
      $wp_rewrite->flush_rules();
      return $query_results;
    }

    function destroy( $id )
    {
      require_once(PRLI_MODELS_PATH.'/models.inc.php');
      global $wpdb, $wp_rewrite;
      $destroy = 'DELETE FROM ' . $this->table_name() .  ' WHERE id=' . $id;
      $wp_rewrite->flush_rules();
      return $wpdb->query($destroy);
    }
    */

    function get_ip_exclude_list()
    {
      $exclude_list = get_option('prli_exclude_ips');
      $exclude_list = preg_replace('#[ \t]#','',$exclude_list);

      if($exclude_list)
        return "'" . implode("','", explode(',',$exclude_list)) . "'";
      else
        return '';
    }

    function get_exclude_where_clause( $starts_with = " WHERE")
    {
      $exclude_list = $this->get_ip_exclude_list();
      
      if( $exclude_list != '')
        return $starts_with . ' cl.ip NOT IN (' . $exclude_list . ')';
      else
        return '';
    }

    function getOne( $id )
    {
        global $wpdb, $prli_link;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT cl.*, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id AND id=' . $id . $this->get_exclude_where_clause( ' AND' );
    
        return $wpdb->get_row($query);
    }

    // SELECT cl.*,li.name as link_name FROM wp_prli_clicks cl, wp_prli_links li WHERE li.id = cl.link_id ORDER BY created_at DESC
    function getAll($where = "")
    {
        global $wpdb, $prli_link;
        $click_table = $wpdb->prefix . "prli_clicks";
        $where = $this->get_exclude_where_clause( ' AND' ) . $where;
        $query = 'SELECT cl.*, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id' . $where;
        return $wpdb->get_results($query);
    }

    // Pagination Methods
    function getRecordCount($where="")
    {
        global $wpdb, $prli_link;
        $where = $this->get_exclude_where_clause( ' WHERE' ).$where;
        $query = 'SELECT COUNT(*) FROM ' . $this->table_name() . ' cl'. $where;
        return $wpdb->get_var($query);
    }

    function getPageCount($p_size, $where="")
    {
        return ceil((int)$this->getRecordCount($where) / (int)$p_size);
    }

    function getPage($current_p,$p_size, $where = "")
    {
        global $wpdb, $prli_link;
        $click_table = $wpdb->prefix . "prli_clicks";
        $end_index = $current_p * $p_size;
        $start_index = $end_index - $p_size;
        $where = $this->get_exclude_where_clause( ' AND' ) . $where;
        $query = 'SELECT cl.*, li.name as link_name FROM ' . $this->table_name() . ' cl, ' . $prli_link->table_name() . ' li WHERE li.id = cl.link_id' . $where . ' LIMIT ' . $start_index . ',' . $p_size . ';';
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
