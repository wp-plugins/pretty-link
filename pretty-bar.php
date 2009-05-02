<?php
  require_once('../../../wp-config.php');
  require_once('prli-config.php');
?>
<html>
<head>
<style type="text/css">
html, body {
  margin: 0px;
  padding: 0px;
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

#blog_title, #baritems {
  margin-top: 3px;
  padding: 0px;
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

#closebutton {
  padding-top: 20px;
  padding-right: 10px;
  float: right;
}

ul#baritems li {
  display: inline;
  float: left;
  padding-left: 15px;
}

#retweet {
  padding-top: 10px;
  padding-left: 50px;
}

</style>
</head>
<body>
  <div id="prettybar">
    <p id="closebutton"><a href="<?php echo $_GET['url']; ?>" target="_top">Close</a></p>
    <ul id="baritems">
      <li>
        <div id="blog_title">
          <h2><a href="<?php echo $prli_blogurl; ?>" target="_top"><?php echo $prli_blogname; ?></a></h2> 
          <p><?php echo $prli_blogdescription; ?></p> 
        </div>
      </li>
      <li>
        <div id="retweet">
          <h4><a href="<?php echo $_GET['url']; ?>" target="_top">You're Viewing: <?php echo $_GET['url']; ?></a></h4>
          <h4><a href="http://twitter.com/home?status=<?php echo $_GET['link']; ?>" target="_top">Share on Twitter</a></h4> 
        </div>
      </li>
    </ul>
  </div>
</div>
</body>
</html>
