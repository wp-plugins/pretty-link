<?php
require_once(PRLI_MODELS_PATH.'/PrliLink.php');
require_once(PRLI_MODELS_PATH.'/PrliClick.php');
require_once(PRLI_MODELS_PATH.'/PrliGroup.php');
require_once(PRLI_MODELS_PATH.'/PrliUtils.php');
require_once(PRLI_MODELS_PATH.'/PrliUrlUtils.php');
require_once(PRLI_MODELS_PATH.'/PrliLinkMeta.php');

global $prli_link;
global $prli_link_meta;
global $prli_click;
global $prli_group;
global $prli_utils;
global $prli_url_utils;

$prli_link      = new PrliLink();
$prli_link_meta = new PrliLinkMeta();
$prli_click     = new PrliClick();
$prli_group     = new PrliGroup();
$prli_utils     = new PrliUtils();
$prli_url_utils = new PrliUrlUtils();
?>
