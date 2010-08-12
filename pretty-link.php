<?php
/*
Plugin Name: Pretty Link
Plugin URI: http://blairwilliams.com/pretty-link
Description: Create clean, simple, trackable links on your website that redirect to other URLs and then analyze the number of clicks and unique clicks they get per day using Pretty Link. For instance you could create this URL: http://www.yourdomain.com/cnn that could redirect to http://www.cnn.com. This type of trackable redirection is EXTREMELY useful for masking Affiliate Links. Pretty Link is a superior alternative to using TinyURL, BudURL or other link shrinking service because the URLs are coming from your website's domain name. When these links are used, pretty link not only redirects but also keeps track of their clicks, unique clicks and other data about them which can be analyzed immediately.
Version: 1.1.8
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

register_activation_hook(basename(__FILE__),'prli_install');

add_action('admin_menu', 'prli_menu');

function prli_menu()
{
  add_menu_page('Pretty Link', 'Pretty Link', 8, PRLI_PATH.'/prli-links.php','',PRLI_URL.'/images/pretty-link-small.png'); 
  add_submenu_page(PRLI_PATH.'/prli-links.php', 'Pretty Link | Reports', 'Reports', 8, PRLI_PATH.'/prli-reports.php');

  add_action('admin_head-pretty-link/prli-reports.php', 'prli_reports_admin_header');
}


/* Add header to prli-reports page */
function prli_reports_admin_header()
{
    global $prli_report, $prli_utils;

    if(isset($_POST['link']))
      $link_id = $_POST['link'];
    else
      $link_id = "all";

    if(isset($_POST['type']))
      $type = $_POST['type'];
    else
      $type = "all";

    $first_click = $prli_utils->getFirstClickDate();

    // Adjust for the first click
    if(isset($first_click))
    {
      $min_date = (int)((time()-$first_click)/60/60/24);

      if(isset($_POST['sdate']) and $_POST['sdate'] != '')
      {
        $sdate = explode("-",$_POST['sdate']);
        $start_timestamp = mktime(0,0,0,$sdate[1],$sdate[2],$sdate[0]);
      }
      else
      {
        // Default to min_date or 30 days ago
        if($min_date < 30)
          $start_timestamp = time()-60*60*24*(int)$min_date;
        else
          $start_timestamp = time()-60*60*24*30;
      }

      if(isset($_POST['edate']) and $_POST['edate'] != '')
      {
        $edate = explode("-",$_POST['edate']);
        $end_timestamp = mktime(0,0,0,$edate[1],$edate[2],$edate[0]);
      }
      else
      {
        $end_timestamp = time();
      }
    }
    else
    {
      $min_date = 0;
      $start_timestamp = time();
      $end_timestamp = time();
    }
?>
<link type="text/css" href="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/jquery/css/ui-lightness/jquery-ui-1.7.1.custom.css" rel="stylesheet" />
<script type="text/javascript" src="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/jquery/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/jquery/js/jquery-ui-1.7.1.custom.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
                $("#sdate").datepicker({ dateFormat: 'yy-mm-dd', defaultDate: -30, minDate: -<?php echo $min_date; ?>, maxDate: 0 });
                $("#edate").datepicker({ dateFormat: 'yy-mm-dd', minDate: -<?php echo $min_date; ?>, maxDate: 0 });
                  });
</script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/version-2-ichor/js/json/json2.js"></script>
<script type="text/javascript" src="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/version-2-ichor/js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF("/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/version-2-ichor/open-flash-chart.swf", "my_chart", "100%", "400", "9.0.0");
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#sdate").datepicker();
    $("#edate").datepicker();
  });
</script>


<script type="text/javascript">

function ofc_ready() 
{ 
  //alert('ofc_ready');
}

function open_flash_chart_data()
{
  //alert( 'reading data' );
  return JSON.stringify(data);
}

function findSWF(movieName) {
  if (navigator.appName.indexOf("Microsoft")!= -1) {
    return window[movieName];
  } else {
    return document[movieName];
  }
}
 
OFC = {};
 
OFC.jquery = {
  name: "jQuery",
  version: function(src) { return $('#'+ src)[0].get_version() },
  rasterize: function (src, dst) { $('#'+ dst).replaceWith(OFC.jquery.image(src)) },
  image: function(src) { return "<img src='data:image/png;base64," + $('#'+src)[0].get_img_binary() + "' />"},
  popup: function(src) {
    var img_win = window.open('', 'Charts: Export as Image')
    with(img_win.document) {
      write('<html><head><title>Charts: Export as Image<\/title><\/head><body>' + OFC.jquery.image(src) + '<div>Right-Click on the above Image to Save<\/div><\/body><\/html>') }
    // stop the 'loading...' message
    img_win.document.close();
  }
}
 
// Using an object as namespaces is JS Best Practice. I like the Control.XXX style.
//if (!Control) {var Control = {}}
//if (typeof(Control == "undefined")) {var Control = {}}
if (typeof(Control == "undefined")) {var Control = {OFC: OFC.jquery}}
 
 
// By default, right-clicking on OFC and choosing "save image locally" calls this function.
// You are free to change the code in OFC and call my wrapper (Control.OFC.your_favorite_save_method)
// function save_image() { alert(1); Control.OFC.popup('my_chart') }
function save_image() {
    //alert(1);
    OFC.jquery.popup('my_chart')
}

function moo() {
    //alert(99);
};
    
var data = <?php echo $prli_report->setupClickReport($start_timestamp,$end_timestamp,$link_id,$type); ?>;

</script>

<?php
}

/********* ADD REDIRECTS YO ***********/
function prli_link_rewrite($wp_rewrite) {
  global $prli_link, $prli_utils;

  $pretty_links = $prli_link->getAll();

  foreach($pretty_links as $pl)
  {
    if( $pl->slug != null and $pl->slug != '' and $prli_utils->slugIsAvailable($pl->slug) )
    {
      if(isset($pl->forward_params) and $pl->forward_params)
        add_rewrite_rule('(' . $pl->slug . ')/?\??(.*?)$', 'wp-content/plugins/' . PRLI_PLUGIN_NAME . '/prli.php?sprli=$1&$2');
      else
        add_rewrite_rule('(' . $pl->slug . ')/?$', 'wp-content/plugins/' . PRLI_PLUGIN_NAME . '/prli.php?sprli=$1');
    }
      
  }
}

// Add rules after the rest of the rules are run
add_filter('generate_rewrite_rules', 'prli_link_rewrite');

/********* INSTALL PLUGIN ***********/
$prli_db_version = "0.0.8";

function prli_install() {
  global $wpdb, $prli_db_version;

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
              track_as_img tinyint(1) default 0,
              forward_params tinyint(1) default 0,
              created_at datetime NOT NULL,
              PRIMARY KEY  (id),
              KEY slug (slug)
            );";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($sql);
  }
}
?>
