<?php
  if( $errors != null and count($errors) > 0 )
  {
      ?>
<div class="error">
  <ul>
  <?php
    foreach( $errors as $error )
    {
        ?>
    <li><strong>ERROR</strong>: <?php print $error; ?></li>
    <?php
    }
      ?>
  </ul>
</div>
<?php
  }
?>
