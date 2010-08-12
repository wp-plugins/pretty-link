<?php
/*
Plugin Name: Pretty Link
Plugin URI: http://blairwilliams.com/pretty-link
Description: Creates shortened, named URLs using your blog. This plugin makes the best possible links for your affiliate campaigns or other endeavors because the links appear to be coming from your site instead of from tinyurl, budurl or one of the other link shrinking services. You can track stats on your links easily and keep that data on your own database (instead of allowing it to be managed on other machines).
Version: 0.0.1
Author: Blair Williams
Author URI: http://blairwilliams.com/
Copyright: 2009, Caseproof, LLC

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once('prli-config.php');
require_once(PRLI_MODELS_PATH . '/models.inc.php');

register_activation_hook(__FILE__,'prli_install');

add_action('admin_menu', 'prli_menu');

function prli_menu() {
      add_menu_page('Pretty Link', 'Pretty Link', 8, PRLI_PATH.'/prli-links.php','',PRLI_URL.'/images/bookmark.png'); 
//      add_submenu_page(PRLI_PATH.'/prli-main.php', 'Pretty Link | Links', 'Links', 8, PRLI_PATH.'/prli-links.php');
//      add_submenu_page(PRLI_PATH.'/prli-main.php', 'Pretty Link | Reports', 'Reports', 8, PRLI_PATH.'/prli-links.php');
}

/********* ADD LINK FIELDS ***********/
/*
function prli_add_custom_box() {
  add_meta_box( 'prli_1', __( 'Pretty Link', 'prli_pretty_link' ), 
                'prli_custom_box', 'link', 'advanced', 'high');

}

function prli_add_link_custom_box($link_id) {
    global $wpdb;
    global $wp_rewrite;
    $pretty_links_table = $wpdb->prefix . "prli_links";
    if( $link_id )
    {
      // Insert the new value into the db
      $insert = "INSERT INTO $pretty_links_table (link_id,pretty_link,created_at) VALUES ($link_id,'".$_POST['link_pretty_link']."',NOW())";
      $wpdb->query($insert);
      $wp_rewrite->flush_rules();
    }
}

function prli_edit_link_custom_box($link_id)
{
    global $wpdb;
    global $wp_rewrite;
    $pretty_links_table = $wpdb->prefix . "prli_links";
    $select_stmt = "SELECT * FROM $pretty_links_table WHERE link_id=".$link_id." LIMIT 1";
    $pretty_link = $wpdb->get_results($select_stmt);
    if( $link_id )
    {
      if($pretty_link == null)
      {
        // Insert the new value into the db
        $insert = "INSERT INTO $pretty_links_table (link_id,pretty_link,created_at) VALUES ($link_id,'".$_POST['link_pretty_link']."',NOW())";
        $wpdb->query($insert);
        $wp_rewrite->flush_rules();
      }
      else
      {
        // Update the record
        $update = "UPDATE $pretty_links_table SET pretty_link='".$_POST['link_pretty_link']."' WHERE link_id=".$link_id;
        $wpdb->query($update);
        $wp_rewrite->flush_rules();
      }
    }
}

function prli_custom_box() {
    global $link, $wpdb;
    $base_url = get_option('siteurl');
    $pretty_links_table = $wpdb->prefix . "prli_links";
    $pretty_link = $wpdb->get_var("SELECT pretty_link FROM $pretty_links_table WHERE link_id=".$link->link_id);

    ?>
      <span><strong><?php print $base_url . "/"; ?></strong></span><input type="text" name="link_pretty_link" value="<?php print $pretty_link; ?>" id="link_pretty_link" />
      <p>This is the URL that will display for this link. When clicked, it will simply redirect to the main URL (Web Address) above. If it is left blank then the link will appear as it looks in the Web Address field on this page.</p>
    <?php
}

add_action('admin_menu', 'prli_add_custom_box');
//add_action('submitlink_box', 'prli_custom_box');
add_action('add_link', 'prli_add_link_custom_box');
add_action('edit_link', 'prli_edit_link_custom_box');
*/

/********* MODIFY BOOKMARK LIST ***********/
/*
function prli_bookmark_list($bookmarks_html)
{
  global $wpdb;
  $base_url = get_option('siteurl');
  $pretty_links_table = $wpdb->prefix . "prli_links";

  $bookmark_query = "SELECT * FROM $pretty_links_table";
  $pretty_links = $wpdb->get_results($bookmark_query);

  foreach($pretty_links as $pretty_link)
  {
    if($pretty_link->pretty_link != null and $pretty_link->pretty_link != '')
    {
      $ugly_link = get_bookmark($pretty_link->link_id);
      $bookmarks_html = preg_replace('#' . $ugly_link->link_url . '#', $base_url . '/' . $pretty_link->pretty_link, $bookmarks_html);
    }
  }

  echo $bookmarks_html;
}

add_filter('wp_list_bookmarks', 'prli_bookmark_list');
*/

/********* ADD LINK COLUMNS ***********/
/*
function prli_link_custom_column($column_name, $id) {
  global $wpdb;
  $base_url = get_option('siteurl');
  echo 'WORDDDD!';
  $pretty_links_table = $wpdb->prefix . "prli_links";

  if( $column_name == 'pretty_link' )
  {
    $query = "SELECT pretty_link FROM $pretty_link_table ".
             "WHERE link_id='$id'";
    $pretty_link = $base_url . "/" . $wpdb->get_var($query);
    echo $pretty_link;
  }
  else
  {
    echo '<i>'.__('None').'</i>';
  }
}
function prli_link_columns($defaults) {
    echo $defaults;
    $defaults['pretty_link'] = 'Pretty Link';
    unset($defaults['name']);
    return $defaults;
}
add_action('manage_link_custom_column','prli_link_custom_column', 2, 3);
add_filter('manage_link_list','prli_link_columns');
*/

/********* ADD REDIRECTS YO ***********/
function link_rewrite($wp_rewrite) {
  global $prli_link, $prli_utils;

  $pretty_links = $prli_link->getAll();

  foreach($pretty_links as $pl)
  {
    if( $pl->slug != null and $pl->slug != '' and $prli_utils->slugIsAvailable($pl->slug) )
    {
      add_rewrite_rule('(' . $pl->slug . ')/?$', 'wp-content/plugins/' . PRLI_PLUGIN_NAME . '/prli.php?s=$1');
    }
      
  }
}

// Add rules after the rest of the rules are run
add_filter('generate_rewrite_rules', 'link_rewrite');

/********* INSTALL PLUGIN ***********/
$prli_db_version = "0.0.3";

function prli_install() {
  global $wpdb;
  global $prli_db_version;


  $clicks_table = $wpdb->prefix . "prli_clicks";
  $pretty_links_table = $wpdb->prefix . "prli_links";

  $prli_db_version = 'prli_db_version';
  $prli_current_db_version = get_option( $prli_db_version );

  if( empty($prli_current_db_version) or ($prli_current_db_version != $prli_new_db_version))
  {
    /* Create/Upgrade Clicks Table */
    $sql = "CREATE TABLE " . $clicks_table . " (
              id int(11) NOT NULL auto_increment,
              ip varchar(255) default NULL,
              browser varchar(255) default NULL,
              first_click tinyint default 0,
              created_at datetime NOT NULL,
              link_id int(11) default NULL,
              PRIMARY KEY  (id),
              KEY link_id (link_id),
              CONSTRAINT ".$clicks_table."_ibfk_1 FOREIGN KEY (link_id) REFERENCES $pretty_links_table (link_id)
            );";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($sql);
    
    /* Create/Upgrade Pretty Links Table */
    $sql = "CREATE TABLE " . $pretty_links_table . " (
              id int(11) NOT NULL auto_increment,
              url varchar(255) default NULL,
              slug varchar(255) default NULL,
              created_at datetime NOT NULL,
              PRIMARY KEY  (id),
              KEY slug (slug)
            );";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($sql);
  }
}
?>
