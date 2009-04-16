<?php
  if(is_user_logged_in() and $current_user->user_level >= 8)
  {
    $filename = date("ymdHis",time()) . '_' . $link_name . '_pretty_link_clicks.csv';
    header("Content-Type: text/x-csv");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    
    echo '"Browser","Browser Version","Platform","IP","Timestamp","Referrer","Host","Link"' . "\n";
    foreach($clicks as $click)
    {
      $link = $prli_link->getOne($click->link_id);
     
      echo "\"$click->btype\",\"$click->bversion\",\"$click->os\",\"$click->ip\",\"$click->created_at\",\"$click->referer\",\"$click->host\",\"" . ((empty($link->name))?$link->slug:$link->name) . "\"\n";
    }
  }
  else
    header("Location: " . get_option("siteurl"));
?>
