<?php
/* This file tracks clicks */

require_once(dirname(__FILE__) . '/../../../wp-config.php');

if( $_GET['s'] != null and $_GET['s'] != '' )
{
    $slug = $_GET['s'];

    $click_table = $wpdb->prefix . "prli_clicks";
    $pretty_links_table = $wpdb->prefix . "prli_links";

    $query = "SELECT id,url FROM $pretty_links_table WHERE slug='$slug' LIMIT 1";
    $pretty_link = $wpdb->get_row($query);

    $first_click = false;

    $click_ip = $_SERVER['REMOTE_ADDR'];
    $click_browser = $_SERVER['HTTP_USER_AGENT'];

    //Set Cookie if it doesn't exist
    $cookie_name = 'prli_click_' . $pretty_link->id;
    $cookie_expire_time = time()+60*60*24*30; // Expire in 30 days

    if($_COOKIE[$cookie_name] == null)
    {
        setcookie($cookie_name,$slug,$cookie_expire_time);
        $first_click = true;
    }

    //Record Click in DB
    $insert = "INSERT INTO $click_table (link_id,ip,browser,first_click,created_at) VALUES ($pretty_link->id,'$click_ip','$click_browser','$first_click',NOW())";

    $results = $wpdb->query( $insert );

    //Redirect to Product URL
    header("Location: $pretty_link->url");
}
?>
