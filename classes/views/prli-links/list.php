<div class="wrap">
  <h2>Pretty Link: Links</h2>
  <p>Get started by <a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new">adding a URL</a> that you want to turn into a pretty link. Come back to check how many times it was clicked.</p> 
<p><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new">+ Add Link</a></p>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>
<table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
      <th class="manage-column" width="15%">Slug</th>
      <th class="manage-column" width="25%">URL</th>
      <th class="manage-column" width="30%">Pretty Link</th>
      <th class="manage-column" width="20%">Clicks</th>
      <th class="manage-column" width="10%">Destroy</th>
    </tr>
    </thead>
  <?php

  if(count($links) <= 0)
  {
      ?>
    <tr>
      <td colspan="5"><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=new">Create your First Link</a></td>
    </tr>
    <?php
  }
  else
  {
    foreach($links as $link)
    {
      ?>
      <tr>
        <td><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=edit&id=<?php print $link->id; ?>"><?php print $link->slug; ?></a></td>
        <td><? print $link->url; ?>&nbsp;|&nbsp;<a href="<? print $link->url; ?>" target="_blank">Visit</a></td>
        <td><input type='text' style="font-size: 10px;" readonly="true" onclick='this.select();' onfocus='this.select();' value='<?php echo get_option('siteurl') . '/' . $link->slug; ?>' size="30" /></td>
        <td><?php print $link->clicks; ?></td>
        <td><a href="?page=<?php print PRLI_PLUGIN_NAME; ?>/prli-links.php&action=destroy&id=<?php print $link->id; ?>"  onclick="return confirm('Are you sure you want to delete this link?');">Destroy</a></td>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Slug</th>
      <th class="manage-column">URL</th>
      <th class="manage-column">Pretty Link</th>
      <th class="manage-column">Clicks</th>
      <th class="manage-column">Destroy</th>
    </tr>
    </tfoot>
</table>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
