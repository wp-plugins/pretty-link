<?php
require_once 'prli-config.php';
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$controller_file = 'prli-links.php';

if($_GET['action'] == null and $_POST['action'] == null)
{
  if(isset($_GET['regenerate']) and $_GET['regenerate'] == 'true')
  {
    $wp_rewrite->flush_rules();
  }

  // Required for Pagination to work
  if($_GET['paged'] != null)
  {
    $current_page = $_GET['paged'];
  }
  else
  {
    $current_page = 1;
  }

  $record_count = $prli_link->getRecordCount();
  $page_count = $prli_link->getPageCount($page_size);
  $links = $prli_link->getPage($current_page,$page_size);
  $page_last_record = $prli_utils->getLastRecordNum($record_count,$current_page,$page_size);
  $page_first_record = $prli_utils->getFirstRecordNum($record_count,$current_page,$page_size);
  $page_params = "";
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

    require_once 'classes/views/prli-links/list.php';
  }
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
  require_once 'classes/views/prli-links/list.php';
}
?>
