<?php
require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$controller_file = 'prli-links.php';

if($_GET['action'] == null and $_POST['action'] == null)
{
  $prli_message = "Get started by <a href=\"?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new\">adding a URL</a> that you want to turn into a pretty link.<br/>Come back to see how many times it was clicked.";

  if(isset($_GET['regenerate']) and $_GET['regenerate'] == 'true')
  {
    $wp_rewrite->flush_rules();
    $prli_message = "Your Pretty Links were Successfully Regenerated";
  }

  // Required for Pagination to work
  if($_GET['paged'] != null)
    $current_page = $_GET['paged'];
  else
    $current_page = 1;

  $where_clause = '';
  $count_where_clause = ''; // we need this var because we can't do a count of the meta-field "clicks"
  $page_params = '';

  // These will have to work with both get and post
  $sort_str = (isset($_GET['sort'])?$_GET['sort']:$_POST['sort']);
  $sdir_str = (isset($_GET['sdir'])?$_GET['sdir']:$_POST['sdir']);
  $search_str = (isset($_GET['search'])?$_GET['search']:$_POST['search']);

  // Insert search string
  if(!empty($search_str))
  {
    $where_clause = " WHERE name like '%$search_str%' OR slug like '%$search_str%' or url like '%$search_str%' or created_at like '%$search_str%'";
    $count_where_clause = $where_clause;
    $page_params .="&search=$search_str";
  }

  // make sure page params stay correct
  if(!empty($sort_str))
    $page_params .="&sort=$sort_str";

  if(!empty($sdir_str))
    $page_params .= "&sdir=$sdir_str";

  // Add order by clause
  switch($sort_str)
  {
    case "name":
      $where_clause .= " ORDER BY name";
      $count_where_clause = $where_clause;
      break;
    case "clicks":
      $where_clause .= " ORDER BY clicks";
      $count_where_clause = "";
      break;
    case "slug":
      $where_clause .= " ORDER BY slug";
      $count_where_clause = $where_clause;
      break;
    default:
      $where_clause .= " ORDER BY created_at";
      $count_where_clause = $where_clause;
      $sort_str = 'created_at';
  }

  // Toggle ascending / descending
  if((empty($sort_str) and empty($sdir_str)) or $sdir_str == 'desc')
  {
    $where_clause .= ' DESC';
    $sdir_str = 'desc';
  }
  else
    $sdir_str = 'asc';

  $record_count = $prli_link->getRecordCount($count_where_clause);
  $page_count = $prli_link->getPageCount($page_size,$count_where_clause);
  $links = $prli_link->getPage($current_page,$page_size,$where_clause);
  $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
  $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
  require_once 'classes/views/prli-links/list.php';
}
else if($_GET['action'] == 'new' or $_POST['action'] == 'new')
{
  require_once 'classes/views/prli-links/new.php';
}
else if($_GET['action'] == 'create' or $_POST['action'] == 'create')
{
  $errors = $prli_link->validate($_POST);
  if( count($errors) > 0 )
  {
    require_once 'classes/views/prli-links/new.php';
  }
  else
  {
    $record = $prli_link->create( $_POST );

    // Required for Pagination to work
    $current_page = 1;
    $record_count = $prli_link->getRecordCount();
    $page_count = $prli_link->getPageCount($page_size);
    $links = $prli_link->getPage($current_page,$page_size);
    $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
    $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
    $page_params = "";
    $prli_message = "Your Pretty Link was Successfully Created";

    require_once 'classes/views/prli-links/list.php';
  }
}
else if($_GET['action'] == 'edit' or $_POST['action'] == 'edit')
{
  $record = $prli_link->getOne( $_GET['id'] );
  $id = $_GET['id'];
  require_once 'classes/views/prli-links/edit.php';
}
else if($_GET['action'] == 'update' or $_POST['action'] == 'update')
{
  $errors = $prli_link->validate($_POST);
  $id = $_POST['id'];
  if( count($errors) > 0 )
  {
    require_once 'classes/views/prli-links/edit.php';
  }
  else
  {
    $record = $prli_link->update( $_POST['id'], $_POST );

    // Required for Pagination to work
    $current_page = 1;
    $record_count = $prli_link->getRecordCount();
    $page_count = $prli_link->getPageCount($page_size);
    $links = $prli_link->getPage($current_page,$page_size);
    $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
    $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
    $page_params = "";
    $prli_message = "Your Pretty Link was Successfully Updated";

    require_once 'classes/views/prli-links/list.php';
  }
}
else if($_GET['action'] == 'reset')
{
  $prli_link->reset( $_GET['id'] );

  // Required for Pagination to work
  $current_page = 1;
  $record_count = $prli_link->getRecordCount();
  $page_count = $prli_link->getPageCount($page_size);
  $links = $prli_link->getPage($current_page,$page_size);
  $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
  $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
  $page_params = "";
  $prli_message = "Your Pretty Link was Successfully Reset";
  require_once 'classes/views/prli-links/list.php';
}
else if($_GET['action'] == 'destroy')
{
  $prli_link->destroy( $_GET['id'] );

  // Required for Pagination to work
  $current_page = 1;
  $record_count = $prli_link->getRecordCount();
  $page_count = $prli_link->getPageCount($page_size);
  $links = $prli_link->getPage($current_page,$page_size);
  $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
  $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
  $page_params = "";
  $prli_message = "Your Pretty Link was Successfully Destroyed";
  require_once 'classes/views/prli-links/list.php';
}
?>
