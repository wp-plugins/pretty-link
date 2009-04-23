<div class="wrap">
  <p style="font-size: 14px; font-weight: bold; float: right; padding-top: 25px;"><a href="http://blairwilliams.com/faq" target="_blank">Get Help</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/blog" target="_blank">Blog</a>&nbsp;|&nbsp;<a href="http://blairwilliams.com/don" target="_blank">Donate</a></p>
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Reports</h2>
  <a href="#" class="filter_toggle">Customize Report</a>
<div class="filter_pane">
  <form class="form-fields" name="form2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <?php wp_nonce_field('prli-reports'); ?>
    <span>Link:</span>&nbsp;
    <select id="link" name="link" style="display: inline;">
      <option value="all"<?php print ((!isset($_POST['link']) or $_POST['link'] == "all")?" selected=\"true\"":""); ?>>All&nbsp;</option>
      <?php
        foreach($prli_link->getAll() as $link)
        {
            ?>
          <option value="<?php print $link->id; ?>"<?php print (($_POST['link'] == $link->id)?" selected=\"true\"":""); ?>><?php print $link->slug; ?>&nbsp;</option>
          <?php
        }
      ?>
    </select>&nbsp;
    <span>Type:</span>&nbsp;
    <select id="type" name="type" style="display: inline;">
      <option value="all"<?php print ((!isset($_POST['type']) or $_POST['type'] == "all")?" selected=\"true\"":""); ?>>All Hits&nbsp;</option>
      <option value="unique"<?php print (($_POST['type'] == "unique")?" selected=\"true\"":""); ?>>Unique Hits&nbsp;</option>
    </select>
    <br/>
    <br/>
    <span>Date Range:</span>
    <div id="dateselectors" style="display: inline;">
      <input type="text" name="sdate" id="sdate" value="<?php echo $_POST['sdate']; ?>" style="display:inline;"/>&nbsp;to&nbsp;<input type="text" name="edate" id="edate" value="<?php echo $_POST['edate']; ?>" style="display:inline;"/>
    </div>
    <br/>
    <br/>
    <div class="submit" style="display: inline;"><input type="submit" name="Submit" value="Customize"/> or <a href="#" class="filter_toggle">Cancel</a></div>
  </form>
</div>
  <br/>
  <div id="my_chart"></div>
</div>
