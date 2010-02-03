<?php
require_once(PRLI_MODELS_PATH.'/PrliLink.php');
require_once(PRLI_MODELS_PATH.'/PrliClick.php');
require_once(PRLI_MODELS_PATH.'/PrliGroup.php');
require_once(PRLI_MODELS_PATH.'/PrliUtils.php');
require_once(PRLI_MODELS_PATH.'/PrliUrlUtils.php');
require_once(PRLI_MODELS_PATH.'/PrliLinkMeta.php');
require_once(PRLI_MODELS_PATH.'/PrliUpdate.php');

global $prli_link;
global $prli_link_meta;
global $prli_click;
global $prli_group;
global $prli_utils;
global $prli_url_utils;
global $prli_update;

$prli_link      = new PrliLink();
$prli_link_meta = new PrliLinkMeta();
$prli_click     = new PrliClick();
$prli_group     = new PrliGroup();
$prli_utils     = new PrliUtils();
$prli_url_utils = new PrliUrlUtils();
$prli_update    = new PrliUpdate();

function prli_get_main_message( $message = "Get started by <a href=\"?page=pretty-link/prli-links.php&action=new\">adding a URL</a> that you want to turn into a pretty link.<br/>Come back to see how many times it was clicked.")
{
  global $prli_update;
  include_once(ABSPATH."/wp-includes/class-IXR.php");

  if($prli_update->pro_is_installed_and_authorized())
  {
    $client = new IXR_Client('http://prettylinkpro.com/xmlrpc.php');
    if ($client->query('prlipro.get_main_message'))
      $message = $client->getResponse();
  }
  else
  {
    $client = new IXR_Client('http://blairwilliams.com/xmlrpc.php');
    if ($client->query('prli.get_main_message'))
      $message = $client->getResponse();
  }
  return $message;
}

?>
