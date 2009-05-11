<script type="text/javascript" src="<?php echo $prli_siteurl; ?>/wp-content/plugins/<?php echo PRLI_PLUGIN_NAME; ?>/includes/jquery/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".link_actions").hide();
  $(".edit_link").hover(
    function () {
      $(this).find(".link_actions").show();
    }, 
    function () {
      $(this).find(".link_actions").hide();
    }
  );
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(".options-table").hide();
  $(".options-table-toggle > .expand-options").show();
  $(".options-table-toggle > .collapse-options").hide();
  $(".options-table-toggle").click( function () {
      $(this).find(".expand-options").toggle();
      $(this).find(".collapse-options").toggle();
      $(".expand-collapse").toggle();
      $(".options-table").toggle();
  });

  $(".toggle_pane").hide();
  $(".toggle").click( function () {
      $(this).next(".toggle_pane").toggle();
  });
  $(".expand-all").click( function () {
      $(".toggle_pane").show();
      $(".expand-all").hide();
      $(".collapse-all").show();
  });
  $(".collapse-all").click( function () {
      $(".toggle_pane").hide();
      $(".expand-all").show();
      $(".collapse-all").hide();
  });
});
</script>

<style type="text/css">

.options-table {
  width: 67%;
  margin-top: 10px;
}

.options-table td {
  padding: 10px;
  background-color: #f4f0db;
}

.options-table h3 {
  padding: 0px;
  margin: 0px;
  padding-left: 10px;
}

.expand-all, .collapse-all, .options-table-toggle {
  cursor: pointer;
}

.toggle {
  line-height: 34px;
  font-size: 12px;
  font-weight: bold;
  padding-bottom: 10px;
  cursor: pointer;
}

.pane {
  background-color: #f4f0db;
  padding-left: 10px;
}

ul.pane li {
  padding: 0px;
  margin: 0px;
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
