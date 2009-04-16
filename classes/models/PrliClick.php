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

    function getOne( $id )
    {
        global $wpdb;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT * FROM ' . $this->table_name() . ' li WHERE id=' . $id;
        return $wpdb->get_row($query);
    }

    function getAll($where = "")
    {
        global $wpdb;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT * FROM ' . $this->table_name() . $where . " ORDER BY created_at DESC";
        return $wpdb->get_results($query);
    }

    // Pagination Methods
    function getRecordCount($where="")
    {
        global $wpdb;
        $query = 'SELECT COUNT(*) FROM ' . $this->table_name() . $where;
        return $wpdb->get_var($query);
    }

    function getPageCount($p_size, $where="")
    {
        return ceil((int)$this->getRecordCount($where) / (int)$p_size);
    }

    function getPage($current_p,$p_size, $where = "")
    {
        global $wpdb;
        $click_table = $wpdb->prefix . "prli_clicks";
        $end_index = $current_p * $p_size;
        $start_index = $end_index - $p_size;
        $query = 'SELECT * FROM ' . $this->table_name() . $where . ' ORDER BY created_at DESC LIMIT ' . $start_index . ',' . $p_size . ';';
        $results = $wpdb->get_results($query);
        return $results;
    }

}
?>
