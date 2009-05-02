<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pretty_link->name; ?></title>
  </head>
  <frameset rows="66,*" framespacing=0 frameborder=0>
    <frame src="<?php echo PRLI_URL . "/pretty-bar.php?link=".$prli_blogurl."/".$pretty_link->slug . "&url=".$pretty_link->url.$param_string; ?>" noresize frameborder=0 scrolling=no marginwidth=0 marginheight=0 style="background-color: #f5f6eb;">
    <frame src="<?php echo $pretty_link->url.$param_string; ?>" frameborder=0 marginwidth=0 marginheight=0>
    <noframes>Your browser does not support frames. Click <a href="<?php echo $pretty_link->url.$param_string; ?>">here</a> to view the page.</noframes>
  </frameset>
</html>
