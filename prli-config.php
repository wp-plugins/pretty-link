<?php
define(PRLI_PLUGIN_NAME,"pretty-link");
define(PRLI_PATH,WP_PLUGIN_DIR.'/'.PRLI_PLUGIN_NAME);
define(PRLI_MODELS_PATH,PRLI_PATH.'/classes/models');
define(PRLI_VIEWS_PATH,PRLI_PATH.'/classes/views');
define(PRLI_URL,WP_PLUGIN_URL.'/'.PRLI_PLUGIN_NAME);

// The number of items per page on a table
$page_size = 15;

$prli_blogurl = ((get_option('home'))?get_option('home'):get_option('siteurl'));
$prli_siteurl = get_option('siteurl');
$prli_blogname = get_option('blogname');
$prli_blogdescription = get_option('blogdescription');

function setup_new_vars($groups)
{
  global $prli_link;

  $values = array();
  $values['url'] =  (($_POST['url'] != null)?$_POST['url']:'');
  $values['slug'] = (($_POST['slug'] != null)?$_POST['slug']:$prli_link->generateValidSlug());
  $values['name'] = htmlspecialchars((($_POST['name'] != null)?stripslashes($_POST['name']):''));
  $values['description'] = htmlspecialchars((($_POST['description'] != null)?stripslashes($_POST['description']):''));

  $values['use_prettybar'] = ((isset($_POST['use_prettybar']) and $_POST['use_prettybar'] == 'on')?'checked="true"':'');
  $values['use_ultra_cloak'] = ((isset($_POST['use_ultra_cloak']) and $_POST['use_ultra_cloak'] == 'on')?'checked="true"':'');
  $values['track_me'] = (((!isset($_POST['track_me']) or empty($_POST['track_me'])) or (isset($_POST['track_me']) and $_POST['track_me'] == 'on'))?'checked="true"':'');
  $values['nofollow'] = ((isset($_POST['nofollow']) and $_POST['nofollow'] == 'on')?'checked="true"':'');

  $values['groups'] = array();
  foreach($groups as $group)
  {
    $values['groups'][] = array( 'id' => $group->id,
                                 'value' => (($_POST['group_id'] == $group->id)?' selected="true"':''),
                                 'name' => $group->name );
  }
  $values['gorder'] = (isset($_POST['gorder'])?$_POST['gorder']:'0');

  $values['param_forwarding'] = array();
  $values['param_forwarding']['off'] = (((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'off') or !isset($_POST['param_forwarding']))?'checked="true"':'');
  $values['param_forwarding']['on'] = ((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'on')?'checked="true"':'');
  $values['param_forwarding']['custom'] = ((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'custom')?'checked="true"':'');

  $values['redirect_type'] = array();
  $values['redirect_type']['307'] = ((!isset($_POST['redirect_type']) or (isset($_POST['redirect_type']) and $_POST['redirect_type'] == '307'))?'checked="true"':'');
  $values['redirect_type']['301'] = ((isset($_POST['redirect_type']) and $_POST['redirect_type'] == '301')?'checked="true"':'');

  $values['track_as_img'] = ((isset($_POST['track_as_img']) and $_POST['track_as_img'] == 'on')?'checked="true"':'');

  return $values;
}

function setup_edit_vars($groups,$record)
{
  global $prli_link;

  $values = array();
  $values['url'] =  (($_POST['url'] != null and $record == null)?$_POST['url']:$record->url);
  $values['slug'] = (($_POST['slug'] != null and $record == null)?$_POST['slug']:$record->slug);
  $values['name'] = htmlspecialchars(stripslashes((($_POST['name'] != null and $record == null)?$_POST['name']:$record->name)));
  $values['description'] = htmlspecialchars(stripslashes((($_POST['description'] != null and $record == null)?$_POST['description']:$record->description)));
  $values['use_prettybar'] = ((($_POST['use_prettybar'] or $record->use_prettybar) and ($_POST['use_prettybar'] == 'on' or $record->use_prettybar == 1))?'checked="true"':'');
  $values['use_ultra_cloak'] = ((($_POST['use_ultra_cloak'] or $record->use_ultra_cloak) and ($_POST['use_ultra_cloak'] == 'on' or $record->use_ultra_cloak == 1))?'checked="true"':'');
  $values['track_me'] = ((($_POST['track_me'] or $record->track_me) and ($_POST['track_me'] == 'on' or $record->track_me == 1))?'checked="true"':'');
  $values['nofollow'] = ((($_POST['nofollow'] or $record->nofollow) and ($_POST['nofollow'] == 'on' or $record->nofollow == 1))?'checked="true"':'');

  $values['groups'] = array();
  foreach($groups as $group)
  {
    $values['groups'][] = array( 'id' => $group->id,
                                 'value' => ((($_POST['group_id'] == $group->id) or ($record->group_id == $group->id))?' selected="true"':''),
                                 'name' => $group->name );
  }
  $values['gorder'] = (($_POST['gorder'] != null and $record == null)?$_POST['gorder']:$record->gorder);
  $values['param_forwarding'] = array();
  $values['param_forwarding']['off'] = ((!isset($_POST['param_forwarding']) or $record->param_forwarding == 'off')?'checked="true"':'');
  $values['param_forwarding']['on'] = (((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'on') or (isset($record->param_forwarding) and $record->param_forwarding == 'on'))?'checked="true"':'');
  $values['param_forwarding']['custom'] = (((isset($_POST['param_forwarding']) and $_POST['param_forwarding'] == 'custom') or (isset($record->param_forwarding) and $record->param_forwarding == 'custom'))?'checked="true"':'');

  $values['redirect_type'] = array();
  $values['redirect_type']['307'] = ((!isset($_POST['redirect_type']) or $_POST['redirect_type'] == '307' or $record->redirect_type == '307')?'checked="true"':'');
  $values['redirect_type']['301'] = (((isset($_POST['redirect_type']) and $_POST['redirect_type'] == '301') or (isset($record->redirect_type) and $record->redirect_type == '301'))?'checked="true"':'');

  $values['track_as_img'] = ((($_POST['track_as_img'] or $record->track_as_img) and ($_POST['track_as_img'] == 'on' or $record->track_as_img == 1))?'checked="true"':'');

  return $values;
}
?>
