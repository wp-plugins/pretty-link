<div class="wrap">
<?php
  require(PRLI_VIEWS_PATH.'/shared/nav.php');
?>

<h2><img src="<?php echo PRLI_URL.'/images/pretty-link-med.png'; ?>"/>&nbsp;Pretty Link: CSV Downloads</h2>
<span style="font-size: 14px; font-weight: bold;">For <?php echo stripslashes($link_name); ?>: </span>

<h3>Hit Reports:</h3>
<span class="description">All hits on <?php echo stripslashes($link_name); ?></span> 
<br/>
<ul>
<?php
for($i=$hit_page_count; $i>0; $i--)
{
  $hit_min = 0;

  if($i)
    $hit_min = ($i - 1) * $max_rows_per_file;

  if($i==$hit_page_count)
    $hit_max = $hit_record_count;
  else
    $hit_max = ($i * $max_rows_per_file) - 1;

  $hit_count = $hit_max - $hit_min + 1;
  $report_label = "Hits {$hit_min}-{$hit_max} ({$hit_count} Records)";
  $hit_param_delim = (preg_match('#\?#',$hit_report_url)?'&':'?');
?>
<li><a href="<?php echo $hit_report_url . $hit_param_delim; ?>prli_page=<?php echo $i; ?>"><?php echo $report_label; ?></a></li>
<?php
}
?>
</ul>
<br/>
<h3>IP History Reports:</h3>
<span class="description">Shows all of the pretty links that visitors in <?php echo stripslashes($link_name); ?> have visited identified by IP address and sorted in descending order by date.</span> 
<br/>
<ul>
<?php
for($i=$history_page_count; $i>0; $i--)
{
  $history_min = 0;

  if($i)
    $history_min = ($i - 1) * $max_rows_per_file;

  if($i==$history_page_count)
    $history_max = $history_record_count;
  else
    $history_max = ($i * $max_rows_per_file) - 1;

  $history_count = $history_max - $history_min + 1;
  $report_label = "Hits {$history_min}-{$history_max} ({$history_count} Records)";
  $history_param_delim = (preg_match('#\?#',$history_report_url)?'&':'?');
?>
<li><a href="<?php echo $history_report_url . $history_param_delim; ?>prli_page=<?php echo $i; ?>"><?php echo $report_label; ?></a></li>
<?php
}
?>
</ul>
<br/>
<h3>IP Origin Reports:</h3>
<span class="description">Shows the first the pretty link that visitors in <?php echo stripslashes($link_name); ?> have visited identified by IP address and the hit(s) that got these visitors listed in <?php echo stripslashes($link_name); ?>.</span> 
<br/>
<ul>
<?php
for($i=$origin_page_count; $i>0; $i--)
{
  $origin_min = 0;

  if($i)
    $origin_min = ($i - 1) * $max_rows_per_file;

  if($i==$origin_page_count)
    $origin_max = $origin_record_count;
  else
    $origin_max = ($i * $max_rows_per_file) - 1;

  $origin_count = $origin_max - $origin_min + 1;
  $report_label = "Hits {$origin_min}-{$origin_max} ({$origin_count} Records)";
  $origin_param_delim = (preg_match('#\?#',$origin_report_url)?'&':'?');
?>
<li><a href="<?php echo $origin_report_url . $origin_param_delim; ?>prli_page=<?php echo $i; ?>"><?php echo $report_label; ?></a></li>
<?php
}
?>
</ul>
</div>
