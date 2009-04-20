<div class="wrap">
  <p style="font-size: 14px; font-weight: bold; float: right; padding-top: 25px;"><a href="http://blairwilliams.com/faq" target="_blank">Get Help</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/blog" target="_blank">Blog</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/don" target="_blank">Donate</a></p>
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Links</h2>
  <div id="message" class="updated fade" style="padding:5px;"><?php echo $prli_message; ?></div> 
<p><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new"><img src="<?php echo PRLI_URL.'/images/pretty-link-add.png'; ?>"/> Add a Pretty Link</a>
&nbsp;|&nbsp;<a href="/wp-admin/options-general.php?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-options.php">Options</a>
<?php
  if(get_option('prli_rewrite_mode') == 'on')
  {
?>
&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&regenerate=true">Manually Regenerate Pretty Links</a>
<?php
  }
?>
</p>

<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>
<table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
      <th class="manage-column" width="35%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=name<?php echo (($sort_str == 'name' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Name<?php echo (($sort_str == 'name')?'&nbsp;&nbsp;&nbsp;<img src="/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="10%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=clicks<?php echo (($sort_str == 'clicks' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Clicks<?php echo (($sort_str == 'clicks')?'&nbsp;&nbsp;&nbsp;<img src="/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="15%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=created_at<?php echo (($sort_str == 'created_at' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Created<?php echo (($sort_str == 'created_at')?'&nbsp;&nbsp;&nbsp;<img src="/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="40%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-links.php&sort=slug<?php echo (($sort_str == 'slug' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Links<?php echo (($sort_str == 'slug')?'&nbsp;&nbsp;&nbsp;<img src="/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
    </tr>
    </thead>
  <?php

  if(count($links) <= 0)
  {
      ?>
    <tr>
      <td colspan="4"><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new"><img src="<?php echo PRLI_URL.'/images/pretty-link-add.png'; ?>"/> Add your First Pretty Link</a></td>
    </tr>
    <?php
  }
  else
  {
    foreach($links as $link)
    {
      $pretty_link_url = get_option('siteurl') . '/' . $link->slug;
      ?>
      <tr>
        <td class="edit_link">
          <a href="<? print $link->url; ?>" target="_blank" title="Visit Target URL: <?php echo $link->url; ?> in a New Window"><img src="<?php echo PRLI_URL.'/images/url_icon.gif'; ?>" name="Visit" alt="Visit"/></a>&nbsp;<a href="<? print $pretty_link_url; ?>" target="_blank" title="Visit Pretty Link: <?php echo $pretty_link_url; ?> in a New Window"><img src="<?php echo PRLI_URL.'/images/url_icon.gif'; ?>" name="Visit" alt="Visit"/></a>&nbsp;&nbsp;<a class="slug_name" href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php print $link->id; ?>" title="Edit <?php echo $link->name; ?>"><?php echo "$link->name"; ?></a>
          <br/>
          <div class="link_actions" style="display:none;">
            <a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php print $link->id; ?>" title="Edit <?php echo $link->slug; ?>">Edit</a>&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=destroy&id=<?php print $link->id; ?>"  onclick="return confirm('Are you sure you want to delete your <?php print $link->slug; ?> Pretty Link?');" title="Delete <?php echo $link->slug; ?>">Delete</a>&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-clicks.php&l=<?php echo $link->id; ?>" title="View clicks for <?php print $link->slug; ?>">Clicks</a>&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-reports.php&link=<?php echo $link->id; ?>" title="View stats for <?php print $link->slug; ?>">Stats</a>&nbsp;|&nbsp;<a href="http://twitter.com/home?status=<?php echo $pretty_link_url; ?>" target="_blank" title="Post <?php echo $pretty_link_url; ?> to Twitter">Twitter</a>&nbsp;|&nbsp;<a href="mailto:?subject=Pretty Link&body=<?php echo $pretty_link_url; ?>" target="_blank" title="Send <?php echo $pretty_link_url; ?> in an Email">Email</a>
          </div>
        </td>
        <td><?php print $link->clicks; ?></td>
        <td><?php print $link->created_at; ?></td>
        </td>
        <td><input type='text' style="font-size: 10px; width: 100%;" readonly="true" onclick='this.select();' onfocus='this.select();' value='<?php echo $pretty_link_url; ?>' /><br/><span style="font-size: 8px;">Target URL: <? print $link->url; ?></span></td>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Name</th>
      <th class="manage-column">Clicks</th>
      <th class="manage-column">Created</th>
      <th class="manage-column">Links</th>
    </tr>
    </tfoot>
</table>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
