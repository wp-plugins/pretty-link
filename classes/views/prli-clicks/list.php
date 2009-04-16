<div class="wrap">
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Clicks</h2>
  <h3>For <?php echo $link_name; ?></h3>

<?php
  if(isset($_GET['l']))
    echo '<a href="?page='. PRLI_PLUGIN_NAME .'/prli-links.php">&laquo Back to Links</a>';

  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

<table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
      <th class="manage-column" width="5%">Browser</th>
      <th class="manage-column" width="15%">IP</th>
      <th class="manage-column" width="10%">Timestamp</th>
      <th class="manage-column" width="30%">Referrer</th>
      <th class="manage-column" width="30%">Host</th>
      <th class="manage-column" width="10%">Link</th>
    </tr>
    </thead>
  <?php

  if(count($clicks) <= 0)
  {
      ?>
    <tr>
      <td colspan="5">No Clicks have been recorded yet</td>
    </tr>
    <?php
  }
  else
  {
    foreach($clicks as $click)
    {
      $link = $prli_link->getOne($click->link_id);
     
      ?>
      <tr>
        <td><img src="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/images/browser/<?php echo prli_browser_image($click->btype); ?>" alt="<?php echo $click->btype . " v" . $click->bversion; ?>" title="<?php echo $click->btype . " v" . $click->bversion; ?>"/>&nbsp;<img src="/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/images/os/<?php echo prli_os_image($click->os); ?>" alt="<?php echo $click->os; ?>" title="<?php echo $click->os; ?>"/></td>
        <td><?php echo $click->ip; ?></td>
        <td><?php echo $click->created_at; ?></td>
        <td><?php echo $click->referer; ?></td>
        <td><?php echo $click->host; ?></td>
        <td><?php echo ((empty($link->name))?$link->slug:$link->name); ?></td>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Browser</th>
      <th class="manage-column">IP</th>
      <th class="manage-column">Timestamp</th>
      <th class="manage-column">Referrer</th>
      <th class="manage-column">Host</th>
      <th class="manage-column">Link</th>
    </tr>
    </tfoot>
</table>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
