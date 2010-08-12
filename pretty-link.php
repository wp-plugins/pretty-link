<?php
/*
Plugin Name: Pretty Link
Plugin URI: http://blairwilliams.com/pretty-link
Description: Shrink, track and share any URL on the Internet from your WordPress website!
Version: 1.4.23
Author: Blair Williams
Author URI: http://blairwilliams.com
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
require_once('prli-api.php'); // load api methods
require_once('prli-xmlrpc.php'); // load xml-rpc api methods

$prli_inc_utils = new PrliUtils();

add_action('admin_menu', 'prli_menu');

// Provide Back End Hooks to the Pro version of Pretty Link
if($prli_inc_utils->pro_is_installed())
  require_once(PRLI_PATH.'/pro/pretty-link-pro.php');

function prli_menu()
{
  add_menu_page('Pretty Link', 'Pretty Link', 8, PRLI_PATH.'/prli-links.php','',PRLI_URL.'/images/pretty-link-small.png'); 
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Add New Link', 'Add New Link', 8, PRLI_PATH.'/prli-add-link.php');
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Groups', 'Groups', 8, PRLI_PATH.'/prli-groups.php');
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Hits', 'Hits', 8, PRLI_PATH.'/prli-clicks.php');
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Tools', 'Tools', 8, PRLI_PATH.'/prli-tools.php');
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Options', 'Options', 8, PRLI_PATH.'/prli-options.php');
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Pretty Link Pro', 'Pretty Link Pro', 8, PRLI_PATH.'/prli-pro-settings.php');

  add_action('admin_head-pretty-link/prli-clicks.php', 'prli_reports_admin_header');
  add_action('admin_head-pretty-link/prli-links.php', 'prli_links_admin_header');
  add_action('admin_head-pretty-link/prli-add-link.php', 'prli_links_admin_header');
  add_action('admin_head-pretty-link/prli-groups.php', 'prli_groups_admin_header');
  add_action('admin_head-pretty-link/prli-options.php', 'prli_options_admin_header');
}

/* Add header to prli-options page */
function prli_options_admin_header()
{
  require_once 'classes/views/prli-options/head.php';
}

/* Add header to prli-clicks page */
function prli_reports_admin_header()
{
  // Don't show this sheesh if we're displaying the vuid or ip grouping
  if(!isset($_GET['ip']) and !isset($_GET['vuid']))
  {
    global $prli_siteurl, $prli_click, $prli_utils;

    $params = $prli_click->get_params_array();
    $first_click = $prli_utils->getFirstClickDate();

    // Adjust for the first click
    if(isset($first_click))
    {
      $min_date = (int)((time()-$first_click)/60/60/24);

      if($min_date < 30)
        $start_timestamp = $prli_utils->get_start_date($params,$min_date);
      else
        $start_timestamp = $prli_utils->get_start_date($params,30);

      $end_timestamp = $prli_utils->get_end_date($params);
    }
    else
    {
      $min_date = 0;
      $start_timestamp = time();
      $end_timestamp = time();
    }

    $link_id = $params['l'];
    $type = $params['type'];
    $group = $params['group'];

    require_once 'classes/views/prli-clicks/head.php';
  }
}

/* Add header to the prli-links page */
function prli_links_admin_header()
{
  global $prli_siteurl;
  require_once 'classes/views/prli-links/head.php';
}

/* Add header to the prli-links page */
function prli_groups_admin_header()
{
  global $prli_siteurl;
  require_once 'classes/views/prli-groups/head.php';
}

/********* ADD REDIRECTS FOR STANDARD MODE ***********/
function prli_redirect()
{
  global $prli_blogurl, $wpdb, $prli_link;
 
  // Resolve WP installs in sub-directories
  preg_match('#^http://.*?(/.*)$#', $prli_blogurl, $subdir);

  $match_str = '#^'.$subdir[1].'/(.*?)([\?/].*?)?$#';
 
  if(preg_match($match_str, $_SERVER['REQUEST_URI'], $match_val))
  {
    // match short slugs (most common)
    prli_link_redirect_from_slug($match_val[1],$match_val[2]);

    // Match nested slugs (pretty link sub-directory nesting)
    $possible_links = $wpdb->get_col("SELECT slug FROM " . $prli_link->table_name . " WHERE slug like '".$match_val[1]."/%'",0);
    foreach($possible_links as $possible_link)
    {
      // Try to match the full link against the URI
      if( preg_match('#^'.$subdir[1].'/('.$possible_link.')([\?/].*?)?$#', $_SERVER['REQUEST_URI'], $match_val) )
        prli_link_redirect_from_slug($possible_link,$match_val[2]);
    }
  }
}

// For use with the prli_redirect function
function prli_link_redirect_from_slug($slug,$param_str)
{
  global $prli_link, $prli_utils;

  $link = $prli_link->getOneFromSlug(urldecode($slug));
  
  if(isset($link->slug) and !empty($link->slug))
  {
    $custom_get = $_GET;
  
    if(isset($link->param_forwarding) and $link->param_forwarding == 'custom')
      $custom_get = $prli_utils->decode_custom_param_str($link->param_struct, $param_str);
  
    $prli_utils->track_link($link->slug,$custom_get); 
    exit;
  }
}

add_action('init', 'prli_redirect'); //Redirect

/********* DASHBOARD WIDGET ***********/
function prli_dashboard_widget_function() {
  require_once 'prli-dashboard-widget.php';
} 

// Create the function use in the action hook
function prli_add_dashboard_widgets() {
  global $current_user;
  get_currentuserinfo();
  if($current_user->user_level >= 8)
  {
    wp_add_dashboard_widget('prli_dashboard_widget', 'Pretty Link Quick Add', 'prli_dashboard_widget_function');   

    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;

    // Get the regular dashboard widgets array 
    $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

    // Backup and delete our new dashbaord widget from the end of the array
    $prli_widget_backup = array('prli_dashboard_widget' => $normal_dashboard['prli_dashboard_widget']);
    unset($normal_dashboard['prli_dashboard_widget']);

    // Merge the two arrays together so our widget is at the beginning
    $i = 0;
    foreach($normal_dashboard as $key => $value)
    {
      if($i == 1 or (count($normal_dashboard) <= 1 and $i == count($normal_dashboard) - 1))
        $sorted_dashboard['prli_dashboard_widget'] = $prli_widget_backup['prli_dashboard_widget'];
      
      $sorted_dashboard[$key] = $normal_dashboard[$key];
      $i++;
    }

    // Save the sorted array back into the original metaboxes 
    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
  }
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'prli_add_dashboard_widgets' );

/********* EXPORT PRETTY LINK API VIA XML-RPC ***********/
function prli_export_api($api_methods)
{
  $api_methods['prli.create_pretty_link']  = 'prli_xmlrpc_create_pretty_link';
  $api_methods['prli.get_all_groups']      = 'prli_xmlrpc_get_all_groups';
  $api_methods['prli.get_all_links']       = 'prli_xmlrpc_get_all_links';
  $api_methods['prli.get_link']            = 'prli_xmlrpc_get_link';
  $api_methods['prli.get_link_from_slug']  = 'prli_xmlrpc_get_link_from_slug';
  $api_methods['prli.get_pretty_link_url'] = 'prli_xmlrpc_get_pretty_link_url';
  $api_methods['prli.api_version']         = 'prli_xmlrpc_api_version';

  return $api_methods;
}

add_filter('xmlrpc_methods', 'prli_export_api');

/********* INSTALL PLUGIN ***********/
function prli_install()
{
  global $wpdb, $prli_utils;
  $db_version = 4; // this is the version of the database we're moving to

  $groups_table       = $wpdb->prefix . "prli_groups";
  $clicks_table       = $wpdb->prefix . "prli_clicks";
  $pretty_links_table = $wpdb->prefix . "prli_links";
  $link_metas_table   = $wpdb->prefix . "prli_link_metas";

  $charset_collate = '';
  if( $wpdb->has_cap( 'collation' ) )
  {
    if( !empty($wpdb->charset) )
      $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
    if( !empty($wpdb->collate) )
      $charset_collate .= " COLLATE $wpdb->collate";
  }

  $prli_utils->migrate_before_db_upgrade();

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  
  /* Create/Upgrade Clicks (Hits) Table */
  $sql = "CREATE TABLE " . $clicks_table . " (
            id int(11) NOT NULL auto_increment,
            ip varchar(255) default NULL,
            browser varchar(255) default NULL,
            btype varchar(255) default NULL,
            bversion varchar(255) default NULL,
            os varchar(255) default NULL,
            referer varchar(255) default NULL,
            host varchar(255) default NULL,
            uri varchar(255) default NULL,
            robot tinyint default 0,
            first_click tinyint default 0,
            created_at datetime NOT NULL,
            link_id int(11) default NULL,
            vuid varchar(25) default NULL,
            PRIMARY KEY  (id),
            KEY link_id (link_id),
            KEY vuid (vuid)".
            // We won't worry about this constraint for now.
            //CONSTRAINT ".$clicks_table."_ibfk_1 FOREIGN KEY (link_id) REFERENCES $pretty_links_table (id)
          ") {$charset_collate};";
  
  dbDelta($sql);
  
  /* Create/Upgrade Pretty Links Table */
  $sql = "CREATE TABLE " . $pretty_links_table . " (
            id int(11) NOT NULL auto_increment,
            name varchar(255) default NULL,
            description text default NULL,
            url text default NULL,
            slug varchar(255) default NULL,
            nofollow tinyint(1) default 0,
            track_me tinyint(1) default 1,
            param_forwarding varchar(255) default NULL,
            param_struct varchar(255) default NULL,
            redirect_type varchar(255) default '307',
            created_at datetime NOT NULL,
            group_id int(11) default NULL,
            PRIMARY KEY  (id),
            KEY group_id (group_id),
            KEY slug (slug)
          ) {$charset_collate};";
  
  dbDelta($sql);

  /* Create/Upgrade Groups Table */
  $sql = "CREATE TABLE " . $groups_table . " (
            id int(11) NOT NULL auto_increment,
            name varchar(255) default NULL,
            description text default NULL,
            cmon_g varchar(255) default NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id)
          ) {$charset_collate};";
  
  dbDelta($sql);

  /* Create/Upgrade Groups Table */
  $sql = "CREATE TABLE {$link_metas_table} (
            id int(11) NOT NULL auto_increment,
            meta_key varchar(255) default NULL,
            meta_value longtext default NULL,
            link_id int(11) NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY link_id (link_id)
          ) {$charset_collate};";
  
  dbDelta($sql);

  $prli_utils->migrate_after_db_upgrade();

  // Install / Upgrade Pretty Link Pro
  $prlipro_username = get_option( 'prlipro_username' );
  $prlipro_password = get_option( 'prlipro_password' );

  if( !empty($prlipro_username) and !empty($prlipro_password) and
      $prli_utils->get_pro_user_type($prlipro_username,$prlipro_password) != false )
    $prlipro_response = $prli_utils->download_and_install_pro( $prlipro_username, $prlipro_password );

  /***** SAVE OPTIONS *****/
  $prli_options_str = get_option('prli_options');
  $prli_options = unserialize($prli_options_str);
  
  // If unserializing didn't work
  if(!$prli_options)
    $prli_options = new PrliOptions();
  else
    $prli_options->set_default_options(); // Sets defaults for unset options

  $prli_options_str = serialize($prli_options);
  delete_option('prli_options');
  add_option('prli_options',$prli_options_str);

  /***** SAVE DB VERSION *****/
  delete_option('prli_db_version');
  add_option('prli_db_version',$db_version);
}

// Ensure this gets called on first install
register_activation_hook(__FILE__,'prli_install');

?>
