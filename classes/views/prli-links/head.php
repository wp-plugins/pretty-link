<script type="text/javascript" src="<?php echo $prli_siteurl; ?>/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/jquery/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".link_actions").hide();
  $(".edit_link").hover(
    function () {
      $(this).find(".link_actions").fadeIn(500);
    }, 
    function () {
      $(this).find(".link_actions").fadeOut(300);
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

.edit_link {
  height: 50px;
}
.slug_name {
  font-size: 12px;
  font-weight: bold;
}
.link_actions {
  padding-top: 5px;
}
</style>
