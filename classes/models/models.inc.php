<?php
require_once(PRLI_MODELS_PATH.'/PrliLink.php');
require_once(PRLI_MODELS_PATH.'/PrliClick.php');
require_once(PRLI_MODELS_PATH.'/PrliGroup.php');
require_once(PRLI_MODELS_PATH.'/PrliUtils.php');

global $prli_link;
global $prli_click;
global $prli_group;
global $prli_utils;

$prli_link = new PrliLink();
$prli_click = new PrliClick();
$prli_group = new PrliGroup();
$prli_utils = new PrliUtils();
?>
