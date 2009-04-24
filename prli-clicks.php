<?php

if(isset($_GET['action']) and $_GET['action'] == 'csv')
  require_once(dirname(__FILE__) . '/../../../wp-config.php');

require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');
require_once(PRLI_PATH . '/prli-image-lookups.php');

$controller_file = 'prli-clicks.php';

if($_GET['action'] == null and $_POST['action'] == null)
{
  // Required for Pagination to work
  if($_GET['paged'] != null)
  {
    $current_page = $_GET['paged'];
  }
  else
  {
    $current_page = 1;
  }

  if(isset($_GET['l']))
  {
    $where_clause = " AND link_id=".$_GET['l'];
    $link_name = $wpdb->get_var("SELECT name FROM ".$wpdb->prefix."prli_links WHERE id=".$_GET['l']);
    $link_slug = $wpdb->get_var("SELECT slug FROM ".$wpdb->prefix."prli_links WHERE id=".$_GET['l']);

    $link_name = ((empty($link_name))?$link_slug:$link_name);
    $page_params = "&l=".$_GET['l'];
  }
  else
  {
    $link_name = "All Links";
    $where_clause = "";
    $page_params = "";
  }

  $click_vars = prli_get_click_sort_vars($where_clause);
  $page_params .= $click_vars['page_params'];
  $sort_str = $click_vars['sort_str'];
  $sdir_str = $click_vars['sdir_str'];
  $search_str = $click_vars['search_str'];

  $where_clause .= $click_vars['where_clause'];
  $count_where_clause .= $click_vars['count_where_clause'];

  $record_count = $prli_click->getRecordCount($count_where_clause);
  $page_count = $prli_click->getPageCount($page_size,$count_where_clause);
  $clicks = $prli_click->getPage($current_page,$page_size,$where_clause);
  $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
  $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);

  require_once 'classes/views/prli-clicks/list.php';
}
else if($_GET['action'] == 'csv' or $_POST['action'] == 'csv')
{
  if(isset($_GET['l']))
  {
    $where_clause = " AND link_id=".$_GET['l'];
    $link_name = $wpdb->get_var("SELECT name FROM ".$wpdb->prefix."prli_links WHERE id=".$_GET['l']);
    $link_slug = $wpdb->get_var("SELECT slug FROM ".$wpdb->prefix."prli_links WHERE id=".$_GET['l']);

    $link_name = ((empty($link_name))?$link_slug:$link_name);
  }
  else
  {
    $link_name = "all_links";
    $where_clause = "";
  }

  $clicks = $prli_click->getAll($where_clause);
  require_once 'classes/views/prli-clicks/csv.php';
}

// Helpers
function prli_get_click_sort_vars($where_clause = '')
{
  $count_where_clause = '';
  $page_params = '';

  // These will have to work with both get and post
  $sort_str = (isset($_GET['sort'])?$_GET['sort']:$_POST['sort']);
  $sdir_str = (isset($_GET['sdir'])?$_GET['sdir']:$_POST['sdir']);
  $search_str = (isset($_GET['search'])?$_GET['search']:$_POST['search']);

  // Insert search string
  if(!empty($search_str))
  {
    $search_params = explode(" ", $search_str);

    foreach($search_params as $search_param)
    {
      $where_clause .= ' AND';
      $where_clause .= " (cl.ip LIKE '%$search_param%' OR ".
                         "cl.btype LIKE '%$search_param%' OR ".
                         "cl.bversion LIKE '%$search_param%' OR ".
                         "cl.host LIKE '%$search_param%' OR ".
                         "cl.referer LIKE '%$search_param%' OR ".
                         "cl.uri LIKE '%$search_param%' OR ".
                         "cl.created_at LIKE '%$search_param%'";
      $count_where_clause = $where_clause . ")";
      $where_clause .= " OR li.name LIKE '%$search_param%')";
    }

    $page_params .="&search=$search_str";
  }

  // make sure page params stay correct
  if(!empty($sort_str))
    $page_params .="&sort=$sort_str";

  if(!empty($sdir_str))
    $page_params .= "&sdir=$sdir_str";

  if(empty($count_where_clause))
    $count_where_clause = $where_clause;

  // Add order by clause
  switch($sort_str)
  {
    case "ip":
    case "btype":
    case "bversion":
    case "host":
    case "referer":
    case "uri":
      $where_clause .= " ORDER BY cl.$sort_str";
      break;
    case "link":
      $where_clause .= " ORDER BY li.name";
      break;
    default:
      $where_clause .= " ORDER BY cl.created_at";
  }

  // Toggle ascending / descending
  if((empty($sort_str) and empty($sdir_str)) or $sdir_str == 'desc')
  {
    $where_clause .= ' DESC';
    $sdir_str = 'desc';
  }
  else
    $sdir_str = 'asc';

  return array('count_where_clause' => $count_where_clause,
               'sort_str' => $sort_str, 
               'sdir_str' => $sdir_str, 
               'search_str' => $search_str, 
               'where_clause' => $where_clause, 
               'page_params' => $page_params);
}
?>
