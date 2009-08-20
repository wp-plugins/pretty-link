<?php
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) 
  require_once($root.'/wp-load.php');
else
  require_once($root.'/wp-config.php');

require_once('prli-config.php');
require_once(PRLI_MODELS_PATH . '/models.inc.php');

if(isset($_GET['k']))
{
  if($_GET['k'] == $prli_options->bookmarklet_auth)
  {
    $result = prli_create_pretty_link( $_GET['target_url'] );

    $pretty_link = prli_get_pretty_link_url($result);
    ?>
    <html>
      <head><title>Here's your Pretty Link</title></head>
      <style type="text/css">
        body {
          font-family: Arial;
          text-align: center;
          margin-top: 25px;
        }
        
        h4 {
          font-size: 18px;
          color: #aaaaaa;
        }

        h2 {
          font-size: 24px;
          font-weight: bold;
        }

        h2 a {
          text-decoration: none;
          color: #1f487e;
        }

        h2 a:hover {
          text-decoration: none;
          color: blue;
        }
      </style>
      <body>
        <p><img src="<?php echo PRLI_URL; ?>/images/prettylink_logo.jpg" /></p>
        <h4>Here's your Pretty Link for<br/><?php echo $_GET['target_url']; ?></h4>
        <h2><a href="<?php echo $pretty_link; ?>"><?php echo $pretty_link; ?></a></h2>
        <p><a href="<?php echo $_GET['target_url']; ?>">&laquo; Back</a></p>
      </body>
    </html>
  <?php
  }
  else
  {
    wp_redirect($prli_blogurl);
    exit;
  }
}
else
{
  wp_redirect($prli_blogurl);
  exit;
}
?>
