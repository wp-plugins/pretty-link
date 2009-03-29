<?php
class PrliLink
{
    public $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'prli_links';
    }
    
    public function tableName()
    {
      return $this->table_name;
    }

    public function create( $values )
    {
      global $wpdb, $wp_rewrite;
      $query = 'INSERT INTO ' . $this->table_name . 
               ' (url,slug,created_at) VALUES (\'' .
                     $values['url'] . '\',\'' . 
                     $values['slug'] . '\',' . 
                     'NOW())';
      $query_results = $wpdb->query($query);
      $wp_rewrite->flush_rules();
      return $query_results;
    }

    public function update( $id, $values )
    {
      global $wpdb, $wp_rewrite;
      $query = 'UPDATE ' . $this->table_name . 
                  ' SET url=\'' . $values['url'] . '\', ' .
                      ' slug=\'' . $values['slug'] . '\' ' .
                  'WHERE id='.$id;
      $query_results = $wpdb->query($query);
      $wp_rewrite->flush_rules();
      return $query_results;
    }

    public function destroy( $id )
    {
      require_once(PRLI_MODELS_PATH.'/models.inc.php');
      global $wpdb, $wp_rewrite;
      $destroy = 'DELETE FROM ' . $this->table_name .  ' WHERE id=' . $id;
      $wp_rewrite->flush_rules();
      return $wpdb->query($destroy);
    }

    public function getOne( $id )
    {
        global $wpdb;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT li.*, (SELECT COUNT(*) FROM ' . $click_table . ' cl WHERE cl.link_id = li.id) as clicks FROM ' . $this->table_name . ' li WHERE id=' . $id . ';';
        return $wpdb->get_row($query);
    }

    public function getAll()
    {
        global $wpdb;
        $click_table = $wpdb->prefix . "prli_clicks";
        $query = 'SELECT li.*, (SELECT COUNT(*) FROM ' . $click_table . ' cl WHERE cl.link_id = li.id) as clicks FROM ' . $this->table_name . ' li;';
        return $wpdb->get_results($query);
    }

    // Pagination Methods
    public function getRecordCount($where="")
    {
        global $wpdb;
        $query = 'SELECT COUNT(*) FROM ' . $this->table_name . $where;
        return $wpdb->get_var($query);
    }

    public function getPageCount($p_size, $where="")
    {
        return ceil((int)$this->getRecordCount($where) / (int)$p_size);
    }

    public function getPage($current_p,$p_size, $where = "")
    {
        global $wpdb;
        $click_table = $wpdb->prefix . "prli_clicks";
        $end_index = $current_p * $p_size;
        $start_index = $end_index - $p_size;
        $query = 'SELECT li.*, (SELECT COUNT(*) FROM ' . $click_table . ' cl WHERE cl.link_id = li.id) as clicks FROM ' . $this->table_name . ' li' . $where . ' LIMIT ' . $start_index . ',' . $p_size . ';';
        $results = $wpdb->get_results($query);
        return $results;
    }

    /** I'm generating a slug that is by default 2-3 characters long.
      * This gives us a possibility of 36^3 - 37 = 46,619 possible
      * random slugs. That should be *more* than enough slugs for
      * any website -- if I get any feedback that we need more then
      * I can always make a config option to raise the # of chars.
      */
    public function generateValidSlug($num_chars = 3)
    {
      global $wpdb, $prli_utils;

      // We're doing a base 36 hash which is why we're always doing everything by 36
      $max_slug_value = pow(36,$num_chars);
      $min_slug_value = 37; // we want to have at least 2 characters in the slug
      $slug = base_convert( rand($min_slug_value,$max_slug_value), 10, 36 );

      $query = "SELECT slug FROM " . $this->table_name; // . " WHERE slug='" . $slug . "'";
      $slugs = $wpdb->get_col($query,0);

      // It is highly unlikely that we'll ever see 2 identical random slugs
      // but just in case, here's some code to prevent collisions
      while( in_array($slug,$slugs) or !$prli_utils->slugIsAvailable($slug) )
        $slug = base_convert( rand($min_slug_value,$max_slug_value), 10, 36 );

      return $slug;
    }

    public function validate( $values )
    {
      global $wpdb, $prli_utils;

      $errors = array();
      if( $values['url'] == null or $values['url'] == '' )
        $errors[] = "Link URL can't be blank";

      if( $values['slug'] == null or $values['slug'] == '' )
        $errors[] = "Pretty Link can't be blank";

      if( !preg_match('/^http.?:\/\/.*\..*$/', $values['url'] ) )
        $errors[] = "Link URL must be a correctly formatted url";

      if( !preg_match('/^[a-z0-9\.\-_]+$/', $values['slug'] ) )
        $errors[] = "Pretty Link must not contain spaces or special characters";

      if($values['id'] != null and $values['id'] != '')
        $query = "SELECT slug FROM " . $this->table_name . " WHERE slug='" . $values['slug'] . "' AND id <> " . $values['id'];
      else
        $query = "SELECT slug FROM " . $this->table_name . " WHERE slug='" . $values['slug'] . "'";

      $slug_already_exists = $wpdb->get_var($query);

      if( $slug_already_exists or !$prli_utils->slugIsAvailable($values['slug']) )
        $errors[] = "This pretty link slug is already taken, please choose a different one";

      return $errors;
    }
};
?>
