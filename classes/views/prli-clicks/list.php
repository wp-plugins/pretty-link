<div class="wrap">
  <p style="font-size: 14px; font-weight: bold; float: right; padding-top: 25px;"><a href="http://blairwilliams.com/faq" target="_blank">Get Help</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/blog" target="_blank">Blog</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/don" target="_blank">Donate</a></p>
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Hits</h2>
  <br/>
  <div id="search_pane" style="float: right;">
    <form class="form-fields" name="click_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <?php wp_nonce_field('prli-clicks'); ?>

      <input type="hidden" name="sort" id="sort" value="<?php echo $sort_str; ?>" />
      <input type="hidden" name="sdir" id="sort" value="<?php echo $sdir_str; ?>" />
      <input type="text" name="search" id="search" value="<?php echo $search_str; ?>" style="display:inline;"/>
      <div class="submit" style="display: inline;"><input type="submit" name="Submit" value="Search"/>
      <?php
      if(!empty($search_str))
      {
      ?>
      or <a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php<?php echo (isset($_GET['l'])?'&l='.$_GET['l']:''); ?>">Reset</a>
      <?php
      }
      ?>
      </div>
    </form>
  </div>
  <h3>For <?php echo $link_name; ?></h3>

<?php
  if(isset($_GET['l']))
    echo '<a href="?page='. PRLI_PLUGIN_NAME .'/prli-links.php">&laquo Back to Links</a>';

  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

<table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
      <th class="manage-column" width="5%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=btype<?php echo (($sort_str == 'btype' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Browser<?php echo (($sort_str == 'btype')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="12%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=ip<?php echo (($sort_str == 'ip' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">IP<?php echo (($sort_str == 'ip')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="12%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=vuid<?php echo (($sort_str == 'vuid' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Visitor<?php echo (($sort_str == 'vuid')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="13%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=created_at<?php echo (($sort_str == 'created_at' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Timestamp<?php echo ((empty($sort_str) or $sort_str == 'created_at')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.((empty($sort_str) or $sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="16%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=host<?php echo (($sort_str == 'host' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Host<?php echo (($sort_str == 'host')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="16%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=uri<?php echo (($sort_str == 'uri' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">URI<?php echo (($sort_str == 'uri')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="16%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=referer<?php echo (($sort_str == 'referer' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Referrer<?php echo (($sort_str == 'referer')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
      <th class="manage-column" width="13%"><a href="?page=<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php&sort=link<?php echo (($sort_str == 'link' and $sdir_str == 'asc')?'&sdir=desc':''); ?>">Link<?php echo (($sort_str == 'link')?'&nbsp;&nbsp;&nbsp;<img src="'.$prli_siteurl.'/wp-content/plugins/'.PRLI_PLUGIN_NAME.'/images/'.(($sdir_str == 'desc')?'arrow_down.png':'arrow_up.png').'"/>':'') ?></a></th>
    </tr>
    </thead>
  <?php

  if(count($clicks) <= 0)
  {
      ?>
    <tr>
      <td colspan="7">No Hits have been recorded yet</td>
    </tr>
    <?php
  }
  else
  {
    foreach($clicks as $click)
    {
      ?>
      <tr>
        <td><img src="<?php echo $prli_siteurl; ?>/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/images/browser/<?php echo prli_browser_image($click->btype); ?>" alt="<?php echo $click->btype . " v" . $click->bversion; ?>" title="<?php echo $click->btype . " v" . $click->bversion; ?>"/>&nbsp;<img src="<?php echo $prli_siteurl; ?>/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/images/os/<?php echo prli_os_image($click->os); ?>" alt="<?php echo $click->os; ?>" title="<?php echo $click->os; ?>"/></td>
        <td><?php echo $click->ip; ?></td>
        <td><?php echo $click->vuid; ?></td>
        <td><?php echo $click->created_at; ?></td>
        <td><?php echo $click->host; ?></td>
        <td><?php echo $click->uri; ?></td>
        <td><?php echo $click->referer; ?></td>
        <td><?php echo $click->link_name; ?></td>
      </tr>
      <?php
    }
  }
  ?>
    <tfoot>
    <tr>
      <th class="manage-column">Browser</th>
      <th class="manage-column">IP</th>
      <th class="manage-column">Visitor</th>
      <th class="manage-column">Timestamp</th>
      <th class="manage-column">Host</th>
      <th class="manage-column">URI</th>
      <th class="manage-column">Referrer</th>
      <th class="manage-column">Link</th>
    </tr>
    </tfoot>
</table>
<?php
  if(isset($_GET['l']))
  {
?>
    <a href="<?php echo $prli_siteurl; ?>/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php?action=csv&l=<?php echo $_GET['l']; ?>">Download CSV (<?php echo $link_name; ?>)</a>
<?php
  }
  else
  {
?>
    <a href="<?php echo $prli_siteurl; ?>/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/prli-clicks.php?action=csv">Download CSV (<?php echo $link_name; ?>)</a>
<?php
  }
  require(PRLI_VIEWS_PATH.'/shared/table-nav.php');
?>

</div>
