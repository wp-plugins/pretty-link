<div class="wrap">
  <p style="font-size: 14px; font-weight: bold; float: right; padding-top: 25px;"><a href="http://blairwilliams.com/faq" target="_blank">Get Help</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/blog" target="_blank">Blog</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/don" target="_blank">Donate</a></p>
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Links</h2>
  <?php
  if(empty($params['group']))
  {
  ?>
  <div id="message" class="updated fade" style="padding:5px;"><?php echo $prli_message; ?></div> 
  <div id="search_pane" style="float: right;">
    <form class="form-fields" name="link_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <?php wp_nonce_field('prli-links'); ?>
      <input type="hidden" name="sort" id="sort" value="<?php echo $sort_str; ?>" />
      <input type="hidden" name="sdir" id="sort" value="<?php echo $sdir_str; ?>" />
      <input type="text" name="search" id="search" value="<?php echo $search_str; ?>" style="display:inline;"/>
      <div class="submit" style="display: inline;"><input type="submit" name="Submit" value="Search"/>
      <?php
      if(!empty($search_str))
      {
      ?>
      or <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php">Reset</a>
      <?php
      }
      ?>
      </div>
    </form>
  </div>
  <div id="button_bar">
    <p><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-add-link.php"><img src="<?php echo PRLI_URL.'/images/pretty-link-add.png'; ?>"/> Add a Pretty Link</a>
    &nbsp;|&nbsp;<a href="options-general.php?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-options.php">Options</a>
    </p>
  </div>
  <?php
  }
  else
  {
  ?>
  <h3><?php echo $prli_message; ?></h3> 
  <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-groups.php">&laquo Back to Groups</a>
  <br/><br/>
  <?php
  }
  ?>

<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>
<table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
      <th class="manage-column" width="45%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=name<?php echo (($sort_str == 'name' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Name<?php echo (($sort_str == 'name')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="5%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=clicks<?php echo (($sort_str == 'clicks' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Hits<?php echo (($sort_str == 'clicks')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="5%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=group_name<?php echo (($sort_str == 'group_name' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Group<?php echo (($sort_str == 'group_name')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="3%"><span title="Redirect">Re</span></th>
      <th class="manage-column" width="12%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=created_at<?php echo (($sort_str == 'created_at' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Created<?php echo ((empty($sort_str) or $sort_str == 'created_at')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.((empty($sort_str) or $sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="30%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=slug<?php echo (($sort_str == 'slug' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Links<?php echo (($sort_str == 'slug')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
    </tr>
    </thead>
  <?php

  if($record_count <= 0)
  {
      ?>
    <tr>
      <td colspan="5">No Pretty Links were found</td>
    </tr>
    <?php
  }
  else
  {
    foreach($links as $link)
    {
      $pretty_link_url = $prli_link->get_pretty_link_url($link->slug);//$prli_blogurl . '/' . $link->slug;
      ?>
      <tr>
        <td class="edit_link">
        <?php if( !$link->track_as_img )
        {
        ?>
          <a href="<? echo $link->url; ?>" target="_blank" title="Visit Target URL: <?php echo $link->url; ?> in a New Window"><img src="<?php echo PRLI_URL.'/images/url_icon.gif'; ?>" width="13px" height="13px" name="Visit" alt="Visit"/></a>&nbsp;
          <a href="<? echo $pretty_link_url; ?>" target="_blank" title="Visit Pretty Link: <?php echo $pretty_link_url; ?> in a New Window"><img src="<?php echo PRLI_URL.'/images/url_icon.gif'; ?>" width="13px" height="13px" name="Visit" alt="Visit"/></a>&nbsp;
        <?php
        }
        else
        {
        ?>
          <img src="<?php echo PRLI_URL.'/images/pixel_track.png'; ?>" width="13px" height="13px" name="Pixel Tracking Enabled" alt="Pixel Tracking Enabled" title="Pixel Tracking Enabled"/>&nbsp;
        <?php
        }

        if($link->param_forwarding == 'on')
        {
        ?>
          <img src="<?php echo PRLI_URL.'/images/forward_params.png'; ?>" width="13px" height="13px" name="Standard Parameter Forwarding Enabled" alt="Standard Parameter Forwarding Enabled" title="Standard Parameter Forwarding Enabled"/>&nbsp;
        <?php
        }
        else if($link->param_forwarding == 'custom')
        {
        ?>
          <img src="<?php echo PRLI_URL.'/images/forward_params.png'; ?>" width="13px" height="13px" name="Custom Parameter Forwarding Enabled" alt="Custom Parameter Forwarding Enabled" title="Custom Parameter Forwarding Enabled"/>&nbsp;
        <?php
        }
        ?>

        <a class="slug_name" href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php echo $link->id; ?>" title="Edit <?php echo $link->name; ?>"><?php echo "$link->name"; ?></a>
          <br/>
          <div class="link_actions">
            <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php echo $link->id; ?>" title="Edit <?php echo $link->slug; ?>">Edit</a>&nbsp;|
            <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&action=destroy&id=<?php echo $link->id; ?>"  onclick="return confirm('Are you sure you want to delete your <?php echo $link->name; ?> Pretty Link? This will delete the Pretty Link and all of the statistical data about it in your database.');" title="Delete <?php echo $link->slug; ?>">Delete</a>&nbsp;|
            <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&action=reset&id=<?php echo $link->id; ?>"  onclick="return confirm('Are you sure you want to reset your <?php echo $link->name; ?> Pretty Link? This will delete all of the statistical data about this Pretty Link in your database.');" title="Reset <?php echo $link->name; ?>">Reset</a>&nbsp;|
            <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&l=<?php echo $link->id; ?>" title="View clicks for <?php echo $link->slug; ?>">Hits</a>
            <?php if( !$link->track_as_img )
            {
            ?>
            |&nbsp;<a href="http://twitter.com/home?status=<?php echo $pretty_link_url; ?>" target="_blank" title="Post <?php echo $pretty_link_url; ?> to Twitter">Tweet</a>&nbsp;|
            <a href="mailto:?subject=Pretty Link&body=<?php echo $pretty_link_url; ?>" target="_blank" title="Send <?php echo $pretty_link_url; ?> in an Email">Email</a>
            <?php
            }
            ?>
          </div>
        </td>
        <td><?php echo $link->clicks; ?></td>
        <td><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&group=<?php echo $link->group_id; ?>"><?php echo $link->group_name; ?></a></td>
        <td><span title="<?php echo ($link->track_as_img?'':(($link->redirect_type == '307')?"Temporary Redirection (307)":"Permanent Redirection (301)")); ?>"><?php echo ($link->track_as_img?'':(($link->redirect_type == '307')?"T":"P")); ?></span></td>
        <td><?php echo $link->created_at; ?></td>
        </td>
        <td><input type='text' style="font-size: 10px; width: 100%;" readonly="true" onclick='this.select();' onfocus='this.select();' value='<?php echo $pretty_link_url; ?>' /><br/>
        <?php if( !$link->track_as_img )
        {
        ?>
        <span style="font-size: 8px;"><strong>Target URL:</strong> <? echo $link->url; ?></span></td>
        <?php
        }
        ?>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Name</th>
      <th class="manage-column">Hits</th>
      <th class="manage-column">Group</th>
      <th class="manage-column">Redirect</th>
      <th class="manage-column">Created</th>
      <th class="manage-column">Links</th>
    </tr>
    </tfoot>
</table>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
