<?php
  require_once('prli-config.php');
  require_once(PRLI_MODELS_PATH . '/models.inc.php');

  include_once(ABSPATH."/wp-includes/class-IXR.php");

  $client = new IXR_Client('http://blairwilliams.com/xmlrpc.php');

  $message = "Add a pretty link right hereâ";

  if ($client->query('prli.get_main_message'))
    $message = $client->getResponse();

  global $prli_group,$prli_link,$prli_blogurl;

  $groups = $prli_group->getAll('',' ORDER BY name');
  $values = setup_new_vars($groups);

  require_once(PRLI_VIEWS_PATH . "/prli-dashboard-widget/widget.php");
?>
