<?php
require_once('../../../wp-config.php');
require_once('prli-config.php');
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$link = $prli_link->getOneFromSlug($_GET['slug']);
$bar_image = get_option('prli_prettybar_image_url');
$bar_background_image = get_option('prli_prettybar_background_image_url');
$bar_color = get_option('prli_prettybar_color');
$bar_text_color = get_option('prli_prettybar_text_color');
$bar_link_color = get_option('prli_prettybar_link_color');
$bar_visited_color = get_option('prli_prettybar_visited_color');
$bar_hover_color = get_option('prli_prettybar_hover_color');
$bar_show_title = get_option('prli_prettybar_show_title');
$bar_show_description = get_option('prli_prettybar_show_description');
$bar_show_share_links = get_option('prli_prettybar_show_share_links');
$bar_show_target_url_link = get_option('prli_prettybar_show_target_url_link');
$bar_title_limit = (int)get_option('prli_prettybar_title_limit');
$bar_desc_limit = (int)get_option('prli_prettybar_desc_limit');
$bar_link_limit = (int)get_option('prli_prettybar_link_limit');

$target_url = $_GET['url'];

if(empty($bar_image) or !$bar_image)
  $bar_image = 'images/pretty-link-48x48.png';

if((empty($bar_background_image) and empty($bar_color)) or (!$bar_background_image and !$bar_color))
  $bar_background_image = 'images/bar_background.png';

if(empty($bar_text_color) or !$bar_text_color)
  $bar_text_color = '000000';

if(empty($bar_link_color) or !$bar_link_color)
  $bar_link_color = '0000ee';

if(empty($bar_visited_color) or !$bar_visited_color)
  $bar_visited_color = '551a8b';

if(empty($bar_hover_color) or !$bar_hover_color)
  $bar_hover_color = 'ababab';

$shortened_title = htmlspecialchars(stripslashes(substr($prli_blogname,0,$bar_title_limit)));
$shortened_desc  = htmlspecialchars(stripslashes(substr($prli_blogdescription,0,$bar_desc_limit)));
$shortened_link  = htmlspecialchars(stripslashes(substr($target_url,0,$bar_link_limit)));

if(strlen($prli_blogname) > $bar_title_limit)
  $shortened_title .= "...";

if(strlen($prli_blogdescription) > $bar_desc_limit)
  $shortened_desc .= "...";

if(strlen($target_url) > $bar_link_limit)
  $shortened_link .= "...";

?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title><?php echo htmlspecialchars(stripslashes($link->name)); ?></title>
<style type="text/css">
html, body {
  margin: 0px;
  padding: 0px;
<?php
  if(!empty($bar_background_image) and $bar_background_image)
  {
?>
  background-image: url(<?php echo $bar_background_image; ?>);
  background-repeat: repeat-x;
<?php
  }
  else
  {
?>
  background-color: #<?php echo $bar_color; ?>;
<?php
  }
?>
  color: #<?php echo $bar_text_color; ?>;
}

#prettybar {
  position: fixed;
  top: 0;
  padding: 0px;
  margin: 0px;
  width: 100%;
  height: 65px;
  border-bottom: 2px solid black;
}

#baritems {
  margin-top: 0px;
  padding: 0px;
}

#blog_title {
  padding-top: 5px;
  margin: 0px;
  width: 200px;
}

h1,h2,h3,h4,p {
  font-family: Arial;
  padding: 0px;
  margin: 0px;
}

a {
  color: #<?php echo $bar_link_color; ?>;
  text-decoration: none;
}

a:visited {
  color: #<?php echo $bar_visited_color; ?>;
}

a:hover {
  color: #<?php echo $bar_hover_color; ?>;
}

.map {
  background-image: url(./images/bar_map.png);
  background-repeat: no-repeat;
}

#closebutton {
  background-position: -200px 0;
  height: 20px;
  width: 20px;
  overflow: hidden;
  /*text-indent: -999em;*/
  cursor: pointer;
  text-align: right;
  float: right;
}

.pb-cell {
  white-space: nowrap;
  overflow: hidden;
}

#right_container {
  float: right;
  margin-top: 8px;
  margin-right: 8px;
  text-align: right;
}

#closebutton:hover {
  background-position: -200px -30px;
}

#closebutton:active {
  background-position: -200px -60px;
}

ul#baritems li {
  display: inline;
  /*float: left;*/
  /*padding-left: 15px;*/
}

#retweet {
  padding-top: 5px;
  padding-left: 15px;
  line-height: 26px;
  width: 200px;
}

#blog_image {
  padding-top: 7px;
  padding-left: 5px;
  padding-right: 5px;
  width: 50px;
}

#small_text {
  font-size: 10px;
}

.powered_by {
  padding-top: 15px;
  text-align: right;
}

/*
td {
  border: 1px solid black;
}
*/
</style>
</head>
<body>
  <div id="prettybar">
    <table width="100%" height="65px">
      <tr>
      <td id="blog_image" valign="top">
        <div class="pb-cell">
        <a href="<?php echo $prli_blogurl; ?>" target="_top"><img src="<?php echo $bar_image; ?>" width="48px" height="48px" border="0"/></a></div>
      </td>
      <td id="blog_title" valign="top">
        <div class="pb-cell">
          <h2>
          <?php if( $bar_show_title ) { ?>
          <a href="<?php echo $prli_blogurl; ?>" title="<?php echo $shortened_title; ?>" target="_top"><?php echo $shortened_title; ?></a>
          <?php } else echo "&nbsp;"; ?>
          </h2> 
          <?php if( $bar_show_description ) { ?>
          <p title="<?php echo $prli_blogdescription; ?>"><?php echo $shortened_desc; ?></p> 
          <?php } else echo "&nbsp;"; ?>
        </div>
      </td>
      <td id="retweet" valign="top">
        <div class="pb-cell">
          <h4>
          <?php if( $bar_show_target_url_link ) { ?>
            <a href="<?php echo $target_url; ?>" title="You're viewing: <?php echo $target_url; ?>" target="_top">Viewing: <?php echo $shortened_link; ?></a>
          <?php } else echo "&nbsp;"; ?>
          </h4>
          <h4>
          <?php if( $bar_show_share_links ) { ?>
            <a href="http://twitter.com/home?status=<?php echo $prli_blogurl . "/" . $_GET['slug']; ?>" target="_top">Share on Twitter</a>
          <?php } else echo "&nbsp;"; ?>
          </h4> 
        </div>
      </td>
      <td valign="top">
        <div id="right_container" class="pb-cell">
          <table width="100%" cellpadding="0" cellspacing="0" style="padding: 0px; margin: 0px;">
            <tr>
              <td>
                <p id="closebutton" class="map"><a href="<?php echo $target_url; ?>" target="_top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
              </td>
            <tr>
              <td>
                <p id="small_text" class="powered_by">Powered by <a href="http://blairwilliams.com/pl" target="_top"><img src="images/pretty-link-small.png" width="12px" height="12px" border="0"/> Pretty Link</a></p>
              </td>
            </tr>
          </table>
        </div>
      </td>
      </tr>
    </table>
  </div>
</div>
</body>
</html>
