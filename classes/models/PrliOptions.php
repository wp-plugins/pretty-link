<?php
class PrliOptions
{
  var $prli_exclude_ips;
  var $prettybar_image_url;
  var $prettybar_background_image_url;
  var $prettybar_color;
  var $prettybar_text_color;
  var $prettybar_link_color;
  var $prettybar_hover_color;
  var $prettybar_visited_color;
  var $prettybar_show_title;
  var $prettybar_show_description;
  var $prettybar_show_share_links;
  var $prettybar_show_target_url_link;
  var $prettybar_title_limit;
  var $prettybar_desc_limit;
  var $prettybar_link_limit;

  var $link_redirect_type;
  var $link_track_me;
  var $link_nofollow;

  function PrliOptions()
  {
    $this->set_default_options();
  }

  function set_default_options()
  {
    // Must account for the Legacy Options
    $prettybar_show_title            = 'prli_prettybar_show_title';
    $prettybar_show_description      = 'prli_prettybar_show_description';
    $prettybar_show_share_links      = 'prli_prettybar_show_share_links';
    $prettybar_show_target_url_link  = 'prli_prettybar_show_target_url_link';
    $link_show_prettybar             = 'prli_link_show_prettybar';
    $link_ultra_cloak                = 'prli_link_ultra_cloak';
    $link_track_me                   = 'prli_link_track_me';
    $link_track_as_pixel             = 'prli_link_track_as_pixel';
    $link_nofollow                   = 'prli_link_nofollow';
    $link_redirect_type              = 'prli_link_redirect_type';

    if(!isset($this->prettybar_show_title)) {
      if($var = get_option( $prettybar_show_title )) {
        $this->prettybar_show_title = $var;
        delete_option( $prettybar_show_title );
      }
      else
        $this->prettybar_show_title = '1';
    }

    if(!isset($this->prettybar_show_description)) {
      if($var = get_option( $prettybar_show_description )) {
        $this->prettybar_show_description = $var;
        delete_option( $prettybar_show_description );
      }
      else
        $this->prettybar_show_description = '1';
    }

    if(!isset($this->prettybar_show_share_links)) {
      if($var = get_option( $prettybar_show_share_links )) {
        $this->prettybar_show_share_links = $var;
        delete_option( $prettybar_show_share_links );
      }
      else
        $this->prettybar_show_share_links = '1';
    }

    if(!isset($this->prettybar_show_target_url_link)) {
      if($var = get_option( $prettybar_show_target_url_link )) {
        $this->prettybar_show_target_url_link = $var;
        delete_option( $prettybar_show_target_url_link );
      }
      else
        $this->prettybar_show_target_url_link = '1';
    }

    if(!isset($this->link_track_me)) {
      if($var = get_option( $link_track_me )) {
        $this->link_track_me = $var;
        delete_option( $link_track_me );
      }
      else
        $this->link_track_me = '1';
    }

    if(!isset($this->link_nofollow)) {
      if($var = get_option( $link_nofollow )) {
        $this->link_nofollow = $var;
        delete_option( $link_nofollow );
      }
      else
        $this->link_nofollow = '0';
    }

    if(!isset($this->link_redirect_type)) {
      if($var = get_option( $link_track_as_pixel )) {
        $this->link_redirect_type = 'pixel';
        delete_option( $link_show_prettybar );
        delete_option( $link_ultra_cloak );
        delete_option( $link_track_as_pixel );
        delete_option( $link_redirect_type );
      }
      if($var = get_option( $link_show_prettybar )) {
        $this->link_redirect_type = 'prettybar';
        delete_option( $link_show_prettybar );
        delete_option( $link_ultra_cloak );
        delete_option( $link_track_as_pixel );
        delete_option( $link_redirect_type );
      }
      if($var = get_option( $link_ultra_cloak )) {
        $this->link_redirect_type = 'cloak';
        delete_option( $link_show_prettybar );
        delete_option( $link_ultra_cloak );
        delete_option( $link_track_as_pixel );
        delete_option( $link_redirect_type );
      }
      if($var = get_option( $link_redirect_type )) {
        $this->link_redirect_type = $var;
        delete_option( $link_show_prettybar );
        delete_option( $link_ultra_cloak );
        delete_option( $link_track_as_pixel );
        delete_option( $link_redirect_type );
      }
      else
        $this->link_redirect_type = '307';
    }

    if(!isset($this->prli_exclude_ips))
      $this->prli_exclude_ips = '';

    if(!isset($this->prettybar_image_url))
      $this->prettybar_image_url = PRLI_URL . '/images/pretty-link-48x48.png';

    if(!isset($this->prettybar_background_image_url))
      $this->prettybar_background_image_url = PRLI_URL . '/images/bar_background.png';

    if(!isset($this->prettybar_color))
      $this->prettybar_color = '';

    if(!isset($this->prettybar_text_color))
      $this->prettybar_text_color = '000000';

    if(!isset($this->prettybar_link_color))
      $this->prettybar_link_color = '0000ee';

    if(!isset($this->prettybar_hover_color))
      $this->prettybar_hover_color = 'ababab';

    if(!isset($this->prettybar_visited_color))
      $this->prettybar_visited_color = '551a8b';

    if(!isset($this->prettybar_title_limit))
      $this->prettybar_title_limit = '25';

    if(!isset($this->prettybar_desc_limit))
      $this->prettybar_desc_limit = '30';

    if(!isset($this->prettybar_link_limit))
      $this->prettybar_link_limit = '30';
  }
}
?>
