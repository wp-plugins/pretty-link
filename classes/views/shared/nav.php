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
<p style="font-size: 14px; font-weight: bold; float: right; text-align: right; padding-top: 5px;">Become a <a href="http://www.facebook.com/pages/Pretty-Link/283252860401">Fan of Pretty Link</a> on Facebook.<br/>Get Help:&nbsp;&nbsp;<a href="http://blairwilliams.com/category/tutorial" target="_blank">Tutorials</a>&nbsp;|&nbsp;<a href="http://twitter.com/blairwilli" target="_blank">Twitter</a><?php echo $support_link; ?></p>
