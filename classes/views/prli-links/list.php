<div class="wrap">
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Links</h2>
  <div id="message" class="updated fade" style="padding:5px;"><?php echo $prli_message; ?></div> 
<p><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new"><img src="<?php echo PRLI_URL.'/images/pretty-link-add.png'; ?>"/> Add a Pretty Link</a>&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&regenerate=true">Manually Regenerate Pretty Links</a></p>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>
<table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
      <th class="manage-column" width="30%">Slug</th>
      <th class="manage-column" width="8%">Clicks</th>
      <th class="manage-column" width="37%">URL</th>
      <th class="manage-column" width="25%">Pretty Link</th>
    </tr>
    </thead>
  <?php

  if(count($links) <= 0)
  {
      ?>
    <tr>
      <td colspan="5"><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new"><img src="<?php echo PRLI_URL.'/images/pretty-link-add.png'; ?>"/> Add your First Pretty Link</a></td>
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
          <a href="<? print $pretty_link_url; ?>" target="_blank" title="Visit <?php echo $pretty_link_url; ?> in New Window"><img src="<?php echo PRLI_URL.'/images/url_icon.gif'; ?>" name="Visit" alt="Visit"/></a>&nbsp;&nbsp;<a class="slug_name" href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php print $link->id; ?>" title="Edit <?php echo $link->slug; ?>"><?php print $link->slug; ?></a>
          <br/>
          <div class="link_actions" style="display:none;">
            <a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php print $link->id; ?>" title="Edit <?php echo $link->slug; ?>">Edit</a>&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=destroy&id=<?php print $link->id; ?>"  onclick="return confirm('Are you sure you want to delete your <?php print $link->slug; ?> Pretty Link?');" title="Delete <?php echo $link->slug; ?>">Delete</a>&nbsp;|&nbsp;<a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-clicks.php&l=<?php echo $link->id; ?>" title="View clicks for <?php print $link->slug; ?>">Clicks</a>&nbsp;|&nbsp;<a href="http://twitter.com/home?status=<?php echo $pretty_link_url; ?>" target="_blank" title="Post <?php echo $pretty_link_url; ?> to Twitter">Twitter</a>&nbsp;|&nbsp;<a href="mailto:?subject=Pretty Link&body=<?php echo $pretty_link_url; ?>" target="_blank" title="Send <?php echo $pretty_link_url; ?> in an Email">Email</a>
          </div>
        </td>
        <td><?php print $link->clicks; ?></td>
        <td><a href="<? print $link->url; ?>" target="_blank" title="Visit <?php echo $link->url; ?> in New Window"><img src="<?php echo PRLI_URL.'/images/url_icon.gif'; ?>" name="Visit" alt="Visit"/></a>&nbsp;&nbsp;<? print $link->url; ?></td>
        <td><input type='text' style="font-size: 10px;" readonly="true" onclick='this.select();' onfocus='this.select();' value='<?php echo $pretty_link_url; ?>' size="30" /></td>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Slug</th>
      <th class="manage-column">Clicks</th>
      <th class="manage-column">URL</th>
      <th class="manage-column">Pretty Link</th>
    </tr>
    </tfoot>
</table>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
