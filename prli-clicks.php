<?php
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
    $where_clause = " WHERE link_id=".$_GET['l'];
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

  $record_count = $prli_click->getRecordCount($where_clause);
  $page_count = $prli_click->getPageCount($page_size,$where_clause);
  $clicks = $prli_click->getPage($current_page,$page_size,$where_clause);
  $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
  $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
  require_once 'classes/views/prli-clicks/list.php';
}
?>
