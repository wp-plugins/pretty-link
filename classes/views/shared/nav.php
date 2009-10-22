<?php
  global $prli_utils;
  
  if(!$prli_utils->pro_is_installed())
  {
    $support_link =<<<SUPPORT_LINK
&nbsp;|&nbsp;<a href="http://prettylinkpro.com/user-manual">Pro Manual</a>&nbsp;|&nbsp;<a href="http://prettylinkpro.com/forum">Pro Forums</a>
SUPPORT_LINK;
  }
  else
  {
    $support_link =<<<SUPPORT_LINK
&nbsp;|&nbsp;<a href="http://prettylinkpro.com">Premium Support</a>
SUPPORT_LINK;
  }
    
?>
<p style="font-size: 14px; font-weight: bold; float: right; text-align: right; padding-top: 0px; padding-right: 10px;">Connect with Pretty Link:&nbsp;&nbsp;<a href="http://twitter.com/blairwilli"><img src="<?php echo PRLI_URL; ?>/images/twitter_32.png" style="width: 24px; height: 24px;" /></a>&nbsp;<a href="http://www.facebook.com/pages/Pretty-Link/283252860401"><img src="<?php echo PRLI_URL; ?>/images/facebook_32.png" style="width: 24px; height: 24px;" /></a><br/>Get Help:&nbsp;&nbsp;<a href="http://blairwilliams.com/category/tutorial" target="_blank">Tutorials</a><?php echo $support_link; ?>&nbsp;|&nbsp;<a href="http://blairwilliams.com/work">One on One</a></p>

