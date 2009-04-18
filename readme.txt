=== Pretty Link ===
Contributors: supercleanse
Donate link: http://www.blairwilliams.com/pretty-link/donate/
Tags: links, link, url, urls, affiliate, affiliates, pretty, marketing, redirect, forward, plugin, rewrite, short, shorten, click, clicks, track, tracking, tiny, tinyurl, budurl, shrinking, domain, shrink, mask, masking, slug, slugs, admin, stats, statistics, stat, statistic, cloaking, cloak, twitter, email, ajax, javascript, ui, csv, download
Requires at least: 2.7.1
Tested up to: 2.7.1
Stable tag: 1.2.7

Create clean, simple, trackable links on your website that forward to other URLs and then analyze the number of clicks and unique clicks they get per day using Pretty Link. For instance you could create this URL: http://www.yourdomain.com/cnn that could redirect to http://www.cnn.com. This type of trackable redirection is EXTREMELY useful for masking Affiliate Links. Pretty Link is a superior alternative to using TinyURL, BudURL or other link shrinking service because the URLs are coming from your website's domain name. When these links are used, pretty link not only redirects but also keeps track of their clicks, unique clicks and other data about them which can be analyzed immediately.

== Description ==

Create clean, simple, trackable links on your website that forward to other URLs and then analyze the number of clicks and unique clicks they get per day using Pretty Link. For instance you could create this URL: http://www.yourdomain.com/cnn that could redirect to http://www.cnn.com. This type of trackable redirection is EXTREMELY useful for masking Affiliate Links. Pretty Link is a superior alternative to using TinyURL, BudURL or other link shrinking service because the URLs are coming from your website's domain name. When these links are used, pretty link not only redirects but also keeps track of their clicks, unique clicks and other data about them which can be analyzed immediately.

= Features =

* Gives you the ability to create clean, simple URLs on your website that redirect to any other URL
* Generates random 2-3 character slugs for your URL or allows you to name a custom slug for your URL
* Enables you to post your Pretty Links to Twitter directly from your WordPress admin
* Enables you to send your Pretty Links via Email directly from your WordPress admin
* Tracks the Number of Clicks per link
* Tracks the Number of Unique Clicks per link
* Provides a reporting interface where you can see a configurable chart of clicks per day. This report can be filtered by the specific link clicked, date range, and/or unique clicks.
* View click details including ip address, remote host, browser (including browser version), operating system, and referring site
* Download click details in CSV format
* Track impressions by loading images through pretty link (experimental)
* Pass custom parameters to your scripts through pretty link and still have full tracking ability (experimental)
* Intuitive Javascript / AJAX Admin User Interface

== Installation ==

1. Upload 'pretty-link.zip' to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Make sure you have changed your permalink Common Settings in Settings -> Permalinks away from "Default" to something else. I prefer using custom and then "/%postname%/" for the simplest possible URL slugs.

= Note =
If you are upgrading from a previous version to 1.2.4 or above, the activation process may take a minute or two.

== Frequently Asked Questions ==

* This plugin is extremely simple. All you have to do is to find the pretty link admin menu (bottom left of your admin page) and start by clicking "Add a Pretty Link."

* Make sure you haven't blocked access to the /wp-content/plugins/pretty-link/prli.php file in your WordPress install. Pretty Link needs this file to be publicly accessible in order to work. If access to this file is blocked then you'll recieve 404 errors for all your pretty links.

= SYSTEM REQUIREMENTS: =

1. WordPress 2.7.1
2. PHP
3. Mysql 5.0+
4. Apache (hasn't been tested on IIS)
5. Mod Rewrite must be installed and functioning
6. Your WordPress install must have write privileges for your .htaccess file
7. Unix based web host (hasn't been tested on Windows)

= NOTE: =

You must have pretty permalinks and rewrite working in your Wordpress/PHP/Apache install before pretty links will work (this is already done in most cases but if you can't get anything but Default permalinks working then you may need to contact your system administrator). Pretty links utlilzes Wordpress's URL rewriting capabilities (via Apache's mod_rewrite) which are only turned on when you change the settings in "Settings -> Permalinks" from "Default" to something else. If you want your blog to have any kind of decent SEO then you really should do this anyway.

== Screenshots ==

1. Analyze Click Data
2. Link Management Screen
3. Add a Link Screen
4. Edit a Link Screen
