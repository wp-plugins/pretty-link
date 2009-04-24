<?php
/* This file tracks clicks */

require_once(dirname(__FILE__) . '/../../../wp-config.php');
require_once(dirname(__FILE__) . '/prli-config.php');
require_once(PRLI_MODELS_PATH . '/models.inc.php');

// reverse compatibility -- get rid of this within the next couple of releases
if( !isset($_GET['sprli']) and isset($_GET['s']) )
  $_GET['sprli'] = $_GET['s'];

if( $_GET['sprli'] != null and $_GET['sprli'] != '' )
{
    $slug = $_GET['sprli'];

    $prli_utils->track_link($slug,$_GET); 
}
?>
