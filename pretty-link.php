<?php
/*
Plugin Name: Pretty Link
Plugin URI: http://blairwilliams.com/pretty-link
Description: Pretty Link is a superior alternative to using TinyURL, BudURL or other link shrinking service. With Pretty Link you can create random shortened or named URLs using your website's domain name. When these links are used, pretty link keeps track of the click count.
Version: 0.0.5
Author: Blair Williams
Author URI: http://blairwilliams.com
Copyright: 2009, Blair Williams

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
      add_menu_page('Pretty Link', 'Pretty Link', 8, PRLI_PATH.'/prli-links.php','',PRLI_URL.'/images/pretty-link-small.png'); 
//      add_submenu_page(PRLI_PATH.'/prli-main.php', 'Pretty Link | Links', 'Links', 8, PRLI_PATH.'/prli-links.php');
//      add_submenu_page(PRLI_PATH.'/prli-main.php', 'Pretty Link | Reports', 'Reports', 8, PRLI_PATH.'/prli-links.php');
}

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
