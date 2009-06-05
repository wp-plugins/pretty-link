<?php
/**
 * Pretty Link WordPress Plugin API
 */

/**
 * Returns the API Version as a string.
 */
function prli_api_version()
{
  return '1.0';
}

/**
 * Create a Pretty Link for a long, ugly URL.
 *
 * @param string $target_url Required, it is the value of the Target URL you
 *                           want the Pretty Link to redirect to
 * 
 * @param string $slug Optional, slug for the Pretty Link (string that comes 
 *                     after the Pretty Link's slash) if this value isn't set
 *                     then a random slug will be automatically generated.
 *
 * @param string $name Optional, name for the Pretty Link. If this value isn't
 *                     set then the name will be the slug.
 *
 * @param string $description Optional, description for the Pretty Link.
 *
 * @param integer $group_id Optional, the group that this link will be placed in.
 *                          If this value isn't set then the link will not be
 *                          placed in a group.
 *
 * @param boolean $show_prettybar Optional, If true the prettybar will be shown,
 *                                if not set the default value (from the pretty
 *                                link option page) will be used
 *
 * @param boolean $ultra_cloak Optional, If true then the link will be ultra-cloaked,
 *                             if not set the default value (from the pretty link
 *                             option page) will be used
 *
 * @param boolean $link_track_me Optional, If true the link will be tracked,
 *                               if not set the default value (from the pretty
 *                               link option page) will be used
 *
 * @param boolean $link_nofollow Optional, If true the nofollow attribute will
 *                               be set for the link, if not set the default
 *                               value (from the pretty link option page) will
 *                               be used
 *
 * @param string $link_redirect_type Optional, valid values include '307' or '301',
 *                                   if not set the default value (from the pretty
 *                                   link option page) will be used
 *
 * @return boolean / string The Full Pretty Link if Successful and false for Failure.
 *                          This function will also set a global variable named 
 *                          $prli_pretty_slug which gives the slug of the link 
 *                          created if the link is successfully created -- it will
 *                          set a variable named $prli_error_messages if the link 
 *                          was not successfully created.
 */
function prli_create_pretty_link( $target_url,
                                  $slug = '',
                                  $name = '',
                                  $description = '',
                                  $group_id = '',
                                  $show_prettybar = '',
                                  $ultra_cloak = '',
                                  $track_me = '',
                                  $nofollow = '',
                                  $redirect_type = '' )
{
  global $wpdb, $prli_link, $prli_blogurl;
  global $prli_error_messages, $prli_pretty_link, $prli_pretty_slug;

  $prli_error_messages = array();

  $values = array();
  $values['url']              = $target_url;
  $values['slug']             = ((empty($slug))?$prli_link->generateValidSlug():$slug);
  $values['name']             = $name;
  $values['description']      = $description;
  $values['group_id']         = $group_id;
  $values['redirect_type']    = ((empty($redirect_type))?get_option( 'prli_link_redirect_type' ):$redirect_type);
  $values['nofollow']         = ((empty($nofollow))?get_option( 'prli_link_nofollow' ):$nofollow);
  $values['use_prettybar']    = ((empty($show_prettybar))?(int)get_option( 'prli_link_show_prettybar' ):$show_prettybar);
  $values['use_ultra_cloak']  = ((empty($ultra_cloak))?(int)get_option( 'prli_link_ultra_cloak' ):$use_ultra_cloak);
  $values['track_me']         = ((empty($track_me))?get_option( 'prli_link_track_me' ):$track_me);
  $values['param_forwarding'] = 'off'; // not supported by this function
  $values['param_struct']     = '';    // not supported by this function
  $values['gorder']           = '0';     // not supported by this function

  // make array look like $_POST
  if(empty($values['nofollow']) or !$values['nofollow'])
    unset($values['nofollow']);
  if(empty($values['use_prettybar']) or !$values['use_prettybar'])
    unset($values['use_prettybar']);
  if(empty($values['use_ultra_cloak']) or !$values['use_ultra_cloak'])
    unset($values['use_ultra_cloak']);
  if(empty($values['track_me']) or !$values['track_me'])
    unset($values['track_me']);
  unset($values['track_as_img']);     // not supported by this function

  $prli_error_messages = $prli_link->validate( $values );
    
  if( count($prli_error_messages) == 0 )
  {
    if( $id = $prli_link->create( $values ) )
    {
      return $id;
    }
    else
    {
      $prli_error_messages[] = "An error prevented your Pretty Link from being created";
      return false;
    }
  }
  else
  {
    return false;
  }
}

function prli_update_pretty_link( $id,
                                  $target_url = '',
                                  $slug = '',
                                  $name = '',
                                  $description = '',
                                  $group_id = '',
                                  $show_prettybar = '',
                                  $ultra_cloak = '',
                                  $track_me = '',
                                  $nofollow = '',
                                  $redirect_type = '' )
{
  global $wpdb, $prli_link, $prli_blogurl;
  global $prli_error_messages, $prli_pretty_link, $prli_pretty_slug;

  $record = $prli_link->getOne($id);

  $prli_error_messages = array();

  $values = array();
  $values['id']               = $id;
  $values['url']              = ((empty($target_url)?$record->url:$target_url));
  $values['slug']             = ((empty($slug))?$record->slug:$slug);
  $values['name']             = ((empty($name))?$record->name:$name);
  $values['description']      = ((empty($description))?$record->description:$description);
  $values['group_id']         = ((empty($group_id))?$record->group_id:$group_id);
  $values['redirect_type']    = ((empty($redirect_type))?$record->redirect_type:$redirect_type);
  $values['nofollow']         = ((empty($nofollow))?$record->nofollow:$nofollow);
  $values['use_prettybar']    = ((empty($show_prettybar))?(int)$record->use_prettybar:$show_prettybar);
  $values['use_ultra_cloak']  = ((empty($ultra_cloak))?(int)$record->use_ultra_cloak:$use_ultra_cloak);
  $values['track_me']         = ((empty($track_me))?(int)$record->track_me:$track_me);
  $values['track_as_img']     = (int)$record->track_as_img;
  $values['param_forwarding'] = $record->param_forwarding; // not supported by this function
  $values['param_struct']     = $record->param_struct;    // not supported by this function
  $values['gorder']           = $record->gorder;     // not supported by this function

  // make array look like $_POST
  if(empty($values['nofollow']) or !$values['nofollow'])
    unset($values['nofollow']);
  if(empty($values['use_prettybar']) or !$values['use_prettybar'])
    unset($values['use_prettybar']);
  if(empty($values['use_ultra_cloak']) or !$values['use_ultra_cloak'])
    unset($values['use_ultra_cloak']);
  if(empty($values['track_me']) or !$values['track_me'])
    unset($values['track_me']);
  if(empty($values['track_as_img']) or !$values['track_as_img'])
    unset($values['track_as_img']);

  $prli_error_messages = $prli_link->validate( $values );
    
  if( count($prli_error_messages) == 0 )
  {
    if( $prli_link->update( $id, $values ) )
    {
      return true;
    }
    else
    {
      $prli_error_messages[] = "An error prevented your Pretty Link from being created";
      return false;
    }
  }
  else
  {
    return false;
  }
}

/**
 * Get all the pretty link groups in an array suitable for creating a select box.
 *
 * @return bool (false if failure) | array A numerical array of associative arrays 
 *                                         containing all the data about the pretty
 *                                         link groups.
 */
function prli_get_all_groups()
{
  global $prli_group;
  $groups = $prli_group->getAll('',' ORDER BY gr.name', ARRAY_A);
  return $groups;
}

/**
 * Get all the pretty links in an array suitable for creating a select box.
 *
 * @return bool (false if failure) | array A numerical array of associative arrays
 *                                         containing all the data about the pretty
 *                                         links.
 */
function prli_get_all_links()
{
  global $prli_link;
  $links = $prli_link->getAll('',' ORDER BY li.name', ARRAY_A);
  return $links;
}
                             
/**
 * Gets a specific link from a slug and returns info about it in an array
 *
 * @return bool (false if failure) | array An associative array with all the
 *                                         data about the given pretty link.
 */
function prli_get_link_from_slug($slug)
{
  global $prli_link;
  $link = $prli_link->getOneFromSlug($slug, ARRAY_A);
  return $link;
}

/**
 * Gets a specific link from id and returns info about it in an array
 *
 * @return bool (false if failure) | array An associative array with all the
 *                                         data about the given pretty link.
 */
function prli_get_link($id)
{
  global $prli_link;
  $link = $prli_link->getOne($id, ARRAY_A);
  return $link;
}

/**
 * Gets the full pretty link url from an id
 *
 * @return bool (false if failure) | string the pretty link url
 */
function prli_get_pretty_link_url($id)
{
  global $prli_blogurl;

  if($pretty_link = prli_get_link($id))
    return "{$prli_blogurl}/{$pretty_link->slug}";

  return false;
}
                             
?>
