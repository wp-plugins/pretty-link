<script type="text/javascript" src="<?php echo PRLI_URL; ?>/includes/jquery/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".group_actions").hide();
  $(".edit_group").hover(
    function () {
      $(this).find(".group_actions").fadeIn(500);
    }, 
    function () {
      $(this).find(".group_actions").fadeOut(300);
    }
  );
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(".advanced_pane").hide();
  $(".advanced_toggle").click( function () {
      $(".advanced_pane").slideToggle("slow");
  });
});
</script>

<style type="text/css">

.advanced_toggle {
  line-height: 34px;
  font-size: 12px;
  font-weight: bold;
  padding-bottom: 10px;
}

.edit_group {
  height: 50px;
}
.group_name {
  font-size: 12px;
  font-weight: bold;
}
.group_actions {
  padding-top: 5px;
}
</style>
