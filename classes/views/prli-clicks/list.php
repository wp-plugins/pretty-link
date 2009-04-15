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
      <th class="manage-column" width="10%">Link</th>
      <th class="manage-column" width="10%">IP</th>
      <th class="manage-column" width="35%">Referrer</th>
      <th class="manage-column" width="10%">Timestamp</th>
      <th class="manage-column" width="5%">Browser</th>
      <th class="manage-column" width="5%">OS</th>
      <th class="manage-column" width="25%">Host</th>
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
      $link = $wpdb->get_row("SELECT * from " . $wpdb->prefix . "prli_links WHERE id=" . $click->link_id);
      ?>
      <tr>
        <td><?php echo ((empty($link->name))?$link->slug:$link->name); ?></td>
        <td><?php echo $click->ip; ?></td>
        <td><?php echo $click->referer; ?></td>
        <td><?php echo $click->created_at; ?></td>
        <td><?php echo $click->btype; ?></td>
        <td><?php echo $click->os; ?></td>
        <td><?php echo $click->host; ?></td>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Link</th>
      <th class="manage-column">IP</th>
      <th class="manage-column">Referer</th>
      <th class="manage-column">Timestamp</th>
      <th class="manage-column">Browser</th>
      <th class="manage-column">OS</th>
      <th class="manage-column">Host</th>
    </tr>
    </tfoot>
</table>
<?php
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
