<div class="wrap">
<?php
  require(PRLI_VIEWS_PATH.'/shared/nav.php');
?>
  <h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: Tools</h2>
  <h3>Bookmarklet: </h3>
  <p><strong><a href="javascript:location.href='<?php echo PRLI_URL; ?>/prli-bookmarklet.php?k=<?php echo $prli_options->bookmarklet_auth; ?>&target_url='+location.href;">Get PrettyLink</a></strong><br/>
  <span class="description">Just drag this "Get PrettyLink" link to your toolbar to install the bookmarklet. As you browse the web, you can just click this bookmarklet to create a pretty link from the current url you're looking at.&nbsp;&nbsp;<a href="http://blairwilliams.com/pretty-link-bookmarklet/">(more help)</a></span>
</div>
