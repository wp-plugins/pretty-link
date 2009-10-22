<?php
class PrliLink
{
    var $table_name;

    function PrliLink()
    {
      global $wpdb;
      $this->table_name = "{$wpdb->prefix}prli_links";
    }

    function create( $values )
    {
      global $wpdb, $prli_url_utils;

      $values['name'] = (!empty($values['name'])?$values['name']:$prli_url_utils->get_title($values['url'],$values['slug']));
      $query_str = "INSERT INTO {$this->table_name} " . 
                     '(url,'.
                      'slug,'.
                      'name,'.
                      'param_forwarding,'.
                      'param_struct,'.
                      'redirect_type,'.
                      'description,'.
                      'track_me,'.
                      'nofollow,'.
                      'group_id,'.
                      'created_at) ' .
                      'VALUES (%s,%s,%s,%s,%s,%s,%s,%d,%d,%d,NOW())';

      $query = $wpdb->prepare( $query_str,
                               $values['url'],
                               $values['slug'],
                               $values['name'],
                               $values['param_forwarding'],
                               $values['param_struct'],
                               $values['redirect_type'],
                               $values['description'],
                               (int)isset($values['track_me']),
                               (int)isset($values['nofollow']),
                               (isset($values['group_id'])?(int)$values['group_id']:'NULL') );
      $query_results = $wpdb->query($query);

     if($query_results)
        return $wpdb->insert_id;
      else
        return false;
    }

    function update( $id, $values )
    {
      global $wpdb, $prli_url_utils;

      $values['name'] = (!empty($values['name'])?$values['name']:$prli_url_utils->get_title($values['url'],$values['slug']));
      $query_str = "UPDATE {$this->table_name} " . 
                      'SET url=%s, ' .
                          'slug=%s, ' .
                          'name=%s, ' .
                          'param_forwarding=%s, ' .
                          'param_struct=%s, ' .
                          'redirect_type=%s, ' .
                          'description=%s, ' .
                          'track_me=%d, ' .
                          'nofollow=%d, ' .
                          'group_id=%d ' .
                     ' WHERE id=%d';

      $query = $wpdb->prepare( $query_str,
                               $values['url'],
                               $values['slug'],
                               $values['name'],
                               $values['param_forwarding'],
                               $values['param_struct'],
                               $values['redirect_type'],
                               $values['description'],
                               (int)isset($values['track_me']),
                               (int)isset($values['nofollow']),
                               (isset($values['group_id'])?(int)$values['group_id']:'NULL'),
                               $id );

      $query_results = $wpdb->query($query);
      return $query_results;
    }

    function update_group( $id, $value, $group_id )
    {
      global $wpdb;
      $query = 'UPDATE ' . $this->table_name . 
                  ' SET group_id=' . (isset($value)?$group_id:'NULL') . 
                  ' WHERE id='.$id;
      $query_results = $wpdb->query($query);
      return $query_results;
    }

    function destroy( $id )
    {
      require_once(PRLI_MODELS_PATH.'/models.inc.php');
      global $wpdb, $prli_click;

      $reset = 'DELETE FROM ' . $prli_click->table_name .  ' WHERE link_id=' . $id;
      $destroy = 'DELETE FROM ' . $this->table_name .  ' WHERE id=' . $id;

      $wpdb->query($reset);
      return $wpdb->query($destroy);
    }

    function reset( $id )
    {
      require_once(PRLI_MODELS_PATH.'/models.inc.php');
      global $wpdb, $prli_click;

      $reset = 'DELETE FROM ' . $prli_click->table_name .  ' WHERE link_id=' . $id;
      return $wpdb->query($reset);
    }

    function getOneFromSlug( $slug, $return_type = OBJECT, $include_stats = false )
    {
      global $wpdb, $prli_click;
      if($include_stats)
        $query = 'SELECT li.*, ' .
                    '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                        'WHERE cl.link_id = li.id' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as clicks, ' .
                    '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                        'WHERE cl.link_id = li.id ' .
                        'AND cl.first_click <> 0' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as uniques ' .
                 "FROM {$this->table_name} li " .
                 'WHERE slug=%s';
      else
        $query = "SELECT * FROM {$this->table_name} WHERE slug=%s";

      $query = $wpdb->prepare($query, $slug);
      return $wpdb->get_row($query, $return_type);
    }

    function getOne( $id, $return_type = OBJECT, $include_stats = false )
    {
      global $wpdb, $prli_click;
      if( !isset($id) or empty($id) )
          return false;

      if($include_stats)
        $query = 'SELECT li.*, ' .
                    '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                        'WHERE cl.link_id = li.id' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as clicks, ' .
                    '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                        'WHERE cl.link_id = li.id ' .
                        'AND cl.first_click <> 0' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as uniques ' .
                 'FROM ' . $this->table_name . ' li ' .
                 'WHERE id=%d';
      else
        $query = "SELECT * FROM {$this->table_name} WHERE id=%d";

      $query = $wpdb->prepare($query, $id);
      return $wpdb->get_row($query, $return_type);
    }

    function find_first_target_url($target_url)
    {
      global $wpdb;
      $query_str = "SELECT id FROM {$this->table_name} WHERE url=%s LIMIT 1";
      $query = $wpdb->prepare($query_str,$target_url);
      return $wpdb->get_var($query);
    }

    function get_link_min( $id, $return_type = OBJECT )
    {
      global $wpdb;
      $query_str = "SELECT * FROM {$this->table_name} WHERE id=%d";
      $query = $wpdb->prepare($query_str, $id);
      return $wpdb->get_row($query, $return_type);
    }

    function getAll($where = '', $order_by = '', $return_type = OBJECT, $include_stats = false)
    {
      global $wpdb, $prli_click, $prli_group, $prli_utils;

      if($include_stats)
        $query = 'SELECT li.*, ' .
                    '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                        'WHERE cl.link_id = li.id' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as clicks, ' .
                    '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                        'WHERE cl.link_id = li.id ' .
                        'AND cl.first_click <> 0' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as uniques, ' .
                    'gr.name as group_name ' .
                 'FROM '. $this->table_name . ' li ' .
                 'LEFT OUTER JOIN ' . $prli_group->table_name . ' gr ON li.group_id=gr.id' . 
                 $prli_utils->prepend_and_or_where(' WHERE', $where) . $order_by;
      else
        $query = "SELECT li.*, gr.name as group_name FROM {$this->table_name} li " . 
                 'LEFT OUTER JOIN ' . $prli_group->table_name . ' gr ON li.group_id=gr.id' . 
                 $prli_utils->prepend_and_or_where(' WHERE', $where) . $order_by;
       

      return $wpdb->get_results($query, $return_type);
    }

    // Pagination Methods
    function getRecordCount($where="")
    {
      global $wpdb, $prli_utils;
      $query = 'SELECT COUNT(*) FROM ' . $this->table_name . ' li' . $prli_utils->prepend_and_or_where(' WHERE', $where);
      return $wpdb->get_var($query);
    }

    function getPageCount($p_size, $where="")
    {
      return ceil((int)$this->getRecordCount($where) / (int)$p_size);
    }

    function getPage($current_p,$p_size, $where = "", $order_by = '', $return_type = OBJECT)
    {
      global $wpdb, $prli_click, $prli_utils, $prli_group;
      $end_index = $current_p * $p_size;
      $start_index = $end_index - $p_size;
      $query = 'SELECT li.*, ' .
                  '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                      'WHERE cl.link_id = li.id' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as clicks, ' .
                  '(SELECT COUNT(*) FROM ' . $prli_click->table_name . ' cl ' .
                      'WHERE cl.link_id = li.id ' .
                      'AND cl.first_click <> 0' . $prli_click->get_exclude_where_clause( ' AND' ) . ') as uniques, ' .
                  'gr.name as group_name ' .
               'FROM ' . $this->table_name . ' li ' .
               'LEFT OUTER JOIN ' . $prli_group->table_name . ' gr ON li.group_id=gr.id' . 
               $prli_utils->prepend_and_or_where(' WHERE', $where) . $order_by . ' ' . 
               'LIMIT ' . $start_index . ',' . $p_size . ';';
      $results = $wpdb->get_results($query, $return_type);
      return $results;
    }

    /** I'm generating a slug that is by default 2-3 characters long.
      * This gives us a possibility of 36^3 - 37 = 46,619 possible
      * random slugs. That should be *more* than enough slugs for
      * any website -- if I get any feedback that we need more then
      * I can always make a config option to raise the # of chars.
      */
    function generateValidSlug($num_chars = 3)
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
    
    function get_pretty_link_url($slug)
    {
      global $prli_blogurl;

      $link = $this->getOneFromSlug($slug);

      if((isset($link->param_forwarding) and $link->param_forwarding == 'custom') and
         (isset($link->redirect_type) and $link->redirect_type == 'pixel'))
        return "&lt;img src=\"".$prli_blogurl . '/' . $link->slug . $link->param_struct . "\" width=\"1\" height=\"1\" style=\"display: none\" /&gt;";
      else if((!isset($link->param_forwarding) or $link->param_forwarding != 'custom') and
              (isset($link->redirect_type) and $link->redirect_type == 'pixel'))
        return "&lt;img src=\"".$prli_blogurl . '/' . $link->slug . "\" width=\"1\" height=\"1\" style=\"display: none\" /&gt;";
      else if((isset($link->param_forwarding) and $link->param_forwarding == 'custom') and
              (!isset($link->redirect_type) or $link->redirect_type != 'pixel'))
        return $prli_blogurl . '/' . $link->slug . $link->param_struct;
      else
        return $prli_blogurl . '/' . $link->slug;
    }

    // Set defaults and grab get or post of each possible param
    function get_params_array()
    {
      $values = array(
         'action'     => (isset($_GET['action'])?$_GET['action']:(isset($_POST['action'])?$_POST['action']:'list')),
         'regenerate' => (isset($_GET['regenerate'])?$_GET['regenerate']:(isset($_POST['regenerate'])?$_POST['regenerate']:'false')),
         'id'         => (isset($_GET['id'])?$_GET['id']:(isset($_POST['id'])?$_POST['id']:'')),
         'group_name' => (isset($_GET['group_name'])?$_GET['group_name']:(isset($_POST['group_name'])?$_POST['group_name']:'')),
         'paged'      => (isset($_GET['paged'])?$_GET['paged']:(isset($_POST['paged'])?$_POST['paged']:1)),
         'group'      => (isset($_GET['group'])?$_GET['group']:(isset($_POST['group'])?$_POST['group']:'')),
         'search'     => (isset($_GET['search'])?$_GET['search']:(isset($_POST['search'])?$_POST['search']:'')),
         'sort'       => (isset($_GET['sort'])?$_GET['sort']:(isset($_POST['sort'])?$_POST['sort']:'')),
         'sdir'       => (isset($_GET['sdir'])?$_GET['sdir']:(isset($_POST['sdir'])?$_POST['sdir']:''))
      );

      return $values;
    }

    function validate( $values )
    {
      global $wpdb, $prli_utils, $prli_blogurl;

      $errors = array();
      if( ( $values['url'] == null or $values['url'] == '') and $values['redirect_type'] != 'pixel' )
        $errors[] = "Target URL can't be blank";

      if( $values['slug'] == null or $values['slug'] == '' )
        $errors[] = "Pretty Link can't be blank";

      if( $values['url'] == "$prli_blogurl/".$values['slug'] )
        $errors[] = "Target URL must be different than the Pretty Link";

      if( !empty($values['url']) and !preg_match('/^http.?:\/\/.*\..*$/', $values['url'] ) )
        $errors[] = "Link URL must be a correctly formatted url";

      if( preg_match('/^[\?\&\#]+$/', $values['slug'] ) )
        $errors[] = "Pretty Link must not contain question marks, ampersands or number signs.";

      if( !$prli_utils->slugIsAvailable($values['slug'],$values['id']) )
        $errors[] = "This pretty link slug is already taken, please choose a different one";

      if( isset($values['param_forwarding']) and $values['param_forwarding'] == 'custom' and empty($values['param_struct']) )
        $errors[] = "If Custom Parameter Forwarding has been selected then you must specify a forwarding format.";

      if( isset($values['param_forwarding']) and $values['param_forwarding'] == 'custom' and !preg_match('#%.*?%#', $values['param_struct']) )
        $errors[] = "Your parameter forwarding must have at least one parameter specified in the format ex: <code>/%var1%/%var_two%/%varname3% ...</code>";

      return $errors;
    }
}
?>
