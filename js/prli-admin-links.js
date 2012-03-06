function prli_toggle_link_options() {
  if(jQuery('#redirect_type').val() == 'metarefresh' || jQuery('#redirect_type').val() == 'javascript') {
    jQuery('#prli_time_delay').show();
  }
  else {
    jQuery('#prli_time_delay').hide();
  }
  
  if(jQuery('#redirect_type').val() != '307' && jQuery('#redirect_type').val() != '301' && jQuery('#redirect_type').val() != 'pixel') {
    jQuery('#prli_google_analytics').show();
  }
  else {
    jQuery('#prli_google_analytics').hide();
  }

  if(jQuery('#redirect_type').val() == 'pixel') {
	  jQuery('#prli_target_url').hide();
  }
  else {
	  jQuery('#prli_target_url').show();
  }
  
  if(jQuery('.prlipro-enable-split-test').prop('checked')) {
    jQuery('.prlipro-split-test-goal-link').show();
  }
  else {
    jQuery('.prlipro-split-test-goal-link').hide();
  }
}

jQuery(document).ready(function() {
  
  prli_toggle_link_options();

  jQuery('#redirect_type').change(function() {
    prli_toggle_link_options();
  });

  jQuery('#param_forwarding').click(function() {
    prli_toggle_link_options();
  });
  
  jQuery('.prlipro-enable-split-test').click(function() {
    prli_toggle_link_options();
  });
  
  // tab swapping
  jQuery('.nav-tab').click(function() {

    // tab is already active. don't do anything
    if( jQuery(this).hasClass( 'nav-tab-active' ) )
      return false;
    
    jQuery('.nav-tab-active').removeClass( 'nav-tab-active' );
    jQuery(this).addClass( 'nav-tab-active' );
    
    if( jQuery(this).attr( 'href' ) == '#options-table' ) {
      jQuery('#options-table').show();
	  jQuery('#pro-options-table').hide();
    } else {
      jQuery('#options-table').hide();
	  jQuery('#pro-options-table').show();
    }
    
    return false;
  });

  jQuery("#add_group_textbox").keypress(function(e) {
    // Apparently 13 is the enter key
    if(e.which == 13) {
	    e.preventDefault();
	    
	    var add_new_group_data = {
    		action: 'add_new_prli_group',
    		new_group_name: jQuery('#add_group_textbox').val(),
    		_prli_nonce: jQuery('#add_group_textbox').attr('prli_nonce')
    	};
      
    	jQuery.post(ajaxurl, add_new_group_data, function(data) {
        if(data['status']=='success') {
          jQuery('#group_dropdown').append(data['group_option']);
          jQuery('#group_dropdown').val(data['group_id']);
          jQuery('#add_group_textbox').val('');
          jQuery("#add_group_textbox").blur();
          jQuery("#add_group_message").addClass('updated');
          jQuery("#add_group_message").text(data['message']);
          jQuery("#add_group_message").show();
          
          jQuery("#add_group_message").fadeOut(5000, function(e) {
            jQuery("#add_group_message").removeClass('updated');
          });
        }
        else {
          jQuery("#add_group_message").addClass('error');
          jQuery("#add_group_message").text(data['message']);
          
          jQuery("#add_group_message").fadeOut(5000, function(e) {
            jQuery("#add_group_message").removeClass('error');
          });
        }
    	});
    }
  });

  jQuery(".defaultText").focus(function(srcc)
  {
    if (jQuery(this).val() == jQuery(this)[0].title)
    {
      jQuery(this).removeClass("defaultTextActive");
      jQuery(this).val("");
    }
  });
  
  jQuery(".defaultText").blur(function()
  {
    if (jQuery(this).val() == "")
    {
      jQuery(this).addClass("defaultTextActive");
      jQuery(this).val(jQuery(this)[0].title);
    }
  });
  
  jQuery(".defaultText").blur();
  
  jQuery(".link_row").hover( function() {
    jQuery(this).find(".link_actions").show();
  },
  function() {
    jQuery(this).find(".link_actions").hide();
  });

});