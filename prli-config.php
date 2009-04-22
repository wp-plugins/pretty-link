<?php
define(PRLI_PLUGIN_NAME,"pretty-link");
define(PRLI_PATH,WP_PLUGIN_DIR.'/'.PRLI_PLUGIN_NAME);
define(PRLI_MODELS_PATH,PRLI_PATH.'/classes/models');
define(PRLI_VIEWS_PATH,PRLI_PATH.'/classes/views');
define(PRLI_URL,WP_PLUGIN_URL.'/'.PRLI_PLUGIN_NAME);

// The number of items per page on a table
$page_size = 15;

$prli_blogurl = ((get_option('home'))?get_option('home'):get_option('siteurl'));
?>
