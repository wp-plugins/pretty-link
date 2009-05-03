<?php
require_once('../../../wp-config.php');
require_once('prli-config.php');
require_once(PRLI_MODELS_PATH . '/models.inc.php');

$link = $prli_link->getOneFromSlug($_GET['slug']);
$bar_image = get_option('prli_prettybar_image_url');
$bar_color = get_option('prli_prettybar_color');

if(empty($bar_image) or !$bar_image)
  $bar_image = 'images/pretty-link-48x48.png';

if(empty($bar_color) or !$bar_color)
  $bar_color = 'f5f6eb';
?>
<html>
<head>
<title><?php echo $link->name; ?></title>
<style type="text/css">
html, body {
  margin: 0px;
  padding: 0px;
  background-color: #<?php echo $bar_color; ?>;
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
}

h1,h2,h3,h4,p {
  font-family: Arial;
  padding: 0px;
  margin: 0px;
}

a {
  text-decoration: none;
}

a:hover {
  color: #ababab;
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

#right_container {
  float: right;
  margin-top: 8px;
  margin-right: 8px;
}

#closebutton:hover {
  background-position: -200px -30px;
}

#closebutton:active {
  background-position: -200px -60px;
}

ul#baritems li {
  display: inline;
  float: left;
  padding-left: 15px;
}

#retweet {
  padding-top: 5px;
  padding-left: 50px;
  line-height: 26px;
}

#blog_image {
  padding-top: 7px;
}

#small_text {
  font-size: 10px;
}

.powered_by {
  padding-top: 40px;
}
</style>
</head>
<body>
  <div id="prettybar">
    <div id="right_container">
      <p id="closebutton" class="map"><a href="<?php echo $_GET['url']; ?>" target="_top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
      <p id="small_text" class="powered_by">Powered by <a href="http://blairwilliams.com/pl" target="_top"><img src="images/pretty-link-small.png" width="12px" height="12px" border="0"/> Pretty Link</a></p>
    </div>
    <ul id="baritems">
      <li>
        <div id="blog_image"><a href="<?php echo $prli_blogurl; ?>" target="_top"><img src="<?php echo $bar_image; ?>" width="48px" height="48px" border="0"/></a></div>
      </li>
      <li>
        <div id="blog_title">
          <h2><a href="<?php echo $prli_blogurl; ?>" target="_top"><?php echo $prli_blogname; ?></a></h2> 
          <p><?php echo $prli_blogdescription; ?></p> 
        </div>
      </li>
      <li>
        <div id="retweet">
          <h4><a href="<?php echo $_GET['url']; ?>" target="_top">You're Viewing: <?php echo $_GET['url']; ?></a></h4>
          <h4><a href="http://twitter.com/home?status=<?php echo $prli_blogurl . "/" . $_GET['slug']; ?>" target="_top">Share on Twitter</a></h4> 
        </div>
      </li>
    </ul>
  </div>
</div>
</body>
</html>
