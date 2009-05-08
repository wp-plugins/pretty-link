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
  $(".options_toggle").click( function () {
      $(".cloaking_pane").slideDown("fast");
      $(".tracking_pane").slideDown("fast");
      $(".seo_pane").slideDown("fast");
      $(".group_pane").slideDown("fast");
      $(".param_forwarding_pane").slideDown("fast");
  });

  $(".cloaking_pane").hide();
  $(".cloaking_toggle").click( function () {
      $(".cloaking_pane").slideToggle("fast");
  });

  $(".tracking_pane").hide();
  $(".tracking_toggle").click( function () {
      $(".tracking_pane").slideToggle("fast");
  });

  $(".seo_pane").hide();
  $(".seo_toggle").click( function () {
      $(".seo_pane").slideToggle("fast");
  });

  $(".group_pane").hide();
  $(".group_toggle").click( function () {
      $(".group_pane").slideToggle("fast");
  });

  $(".param_forwarding_pane").hide();
  $(".param_forwarding_toggle").click( function () {
      $(".param_forwarding_pane").slideToggle("fast");
  });
});
</script>

<style type="text/css">

.options-table {
  width: 67%;
}

.options-table td {
  margin-left: 5px;
  margin-right: 5px;
  background-color: #f4f0db;
}

.options-table h3 {
  padding: 0px;
  margin: 0px;
  padding-left: 10px;
}

.toggle {
  line-height: 34px;
  font-size: 12px;
  font-weight: bold;
  padding-bottom: 10px;
}

.pane {
  background-color: #f4f0db;
  padding: 10px;
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
