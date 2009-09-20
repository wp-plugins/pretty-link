=== Pretty Link ===
Contributors: supercleanse
Donate link: http://www.blairwilliams.com/pretty-link/donate/
Tags: links, link, url, urls, affiliate, affiliates, pretty, marketing, redirect, forward, plugin, twitter, tweet, rewrite, shorturl, hoplink, hop, shortlink, short, shorten, click, clicks, track, tracking, tiny, tinyurl, budurl, shrinking, domain, shrink, mask, masking, slug, slugs, admin, administration, stats, statistics, stat, statistic, cloaking, cloak, email, ajax, javascript, ui, csv, download, page, post, pro, professional, pages, posts, shortcode, seo, automation, keyword, replacement, replacements, widget, widgets, dashboard, sidebar
Requires at least: 2.7.1
Tested up to: 2.8.4
Stable tag: 1.4.24

Shrink, track and share any URL on the Internet from your WordPress website. Create short links suitable for Twitter using your own domain name!

== Description ==

Shrink, track and share any URL on the Internet from your WordPress website. You can now shorten links using your own domain name (as opposed to using tinyurl.com, bit.ly, or any other link shrinking service)! In addition to creating clean links, Pretty Link tracks each hit on your URL and provides a full, detailed report of where the hit came from, the browser, os and host. Pretty Link is a killer plugin for people who want to mask their affiliate links, track clicks from emails, their links on Twitter to come from their own domain, or generally increase the reach of their website by spreading these links on forums or comments on other blogs.

= Upgrade to Pretty Link Pro =

Pretty Link Pro is an upgrade to Pretty Link that re-sets the bar for Link Management, Automation, Sharing and Tracking! You can learn more about it here:

http://prettylinkpro.com

= Examples =

This is a link setup using Pretty Link that redirects to the Pretty Link Homepage where you can find more info about this Plugin:

http://blairwilliams.com/pl

Here's a named Pretty Link (I used the slug 'thesis') that redirects to my affiliate link for diythemes.com -- only the best theme you can get for WordPress -- in my humble opinion :) :

http://blairwilliams.com/thesis

Here's a link that Pretty Link generated a random slug for (similar to how bit.ly or tinyurl would do):

http://blairwilliams.com/w7a

Here's a Pretty Link that uses the configurable Pretty Link PrettyBar:

http://blairwilliams.com/x0z

= Features =

* Gives you the ability to create clean, simple URLs on your website that redirect to any other URL
* Generates random 2-3 character slugs for your URL or allows you to name a custom slug for your URL
* Tracks the Number of Hits per link
* Tracks the Number of Unique Hits per link
* Provides a reporting interface where you can see a configurable chart of clicks per day. This report can be filtered by the specific link clicked, date range, and/or unique clicks.
* View click details including ip address, remote host, browser (including browser version), operating system, and referring site
* Download hit details in CSV format
* Intuitive Javascript / AJAX Admin User Interface
* Pass custom parameters to your scripts through pretty link and still have full tracking ability
* Ability to rewrite these custom Parameters before forwarding to Target URL
* Setup Pretty Links as Tracking Pixels and track impressions
* Exclude IP Addresses from Stats
* Enables you to post your Pretty Links to Twitter directly from your WordPress admin
* Enables you to send your Pretty Links via Email directly from your WordPress admin
* Select Temporary (307) or Permanent (301) redirection for your Pretty Links
* Cookie based system for tracking visitor activity across hits
* Organize Links into Groups
* Create nofollow/noindex links
* Turn tracking on / off on each link
* Keep users on your site even when being redirected by using the PrettyBar which stays at the top of the page
* Ability to configure and skin the PrettyBar to mirror the look and feel of your site
* Hide the Target URL by loading it in a full-screen frame
* Pretty Link Bookmarklet

= Pro Features =
You'll get the following additional features when you purchase Pretty Link Pro:

* Replace keywords throughout your blog with Pretty Links
* Replace URLs throughout your blog with Pretty Links
* Rotate up to 5 URLs from one Pretty Link
* Split Test these URL rotations for a Pretty Link
* Setup Conversion Reports
* Setup your own link shortening service
* Create an alternate URL for your pretty links to be created on
* Import / Export Pretty Links
* Automatically create Pretty Links for each Post / Page
* Automatically Tweet each Post / Page when it is Published
* Display a Tweet Badge on Pages and / or Posts that contains the number of tweets that this page has received
* Display a Re-Tweet button on every Page and / or Post that incorporates your twitter handle & Pretty Link into the ReTweet
* Display a row of social networking buttons on each Page and / or Post
* Lifetime Updates

== Installation ==

1. Upload 'pretty-link.zip' to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Make sure you have changed your permalink Common Settings in Settings -> Permalinks away from "Default" to something else. I prefer using custom and then "/%postname%/" for the simplest possible URL slugs.

= Release Notes =
[Pretty Link Change Log](http://blairwilliams.com/pretty-link/change-log "Pretty link Change Log")

== Frequently Asked Questions ==
[Pretty Link FAQ](http://blairwilliams.com/pretty-link/pretty-link-faq "Pretty link FAQ")

= Developers =
[Pretty Link API](http://blairwilliams.com/pretty-link/api/ "Pretty link API")

== Changelog ==

= 1.4.23/24 =
* Fixed an installation issue for PHP4 users

= 1.4.22 =
* Added known robot and unidentified browser filtering to Pretty Link stats 
* Added IP Address range definition to the Excluded IP address field 
* Fixed html formatting issue on the bookmarklet success page 
* Added the ability for Pro users to remove or alter the attribution link on the Pretty Bar 
* Added new shortcodes for Pro users to display the title, target url and social networking buttons for a newly created public pretty link 
* Enhanced the default success page for public link creation for pro users 
* Fixed the redirect-type not being set bug for pro users allowing public link creation 
* Fixed another php short-code bug affecting Pro users (thanks to Clay Loveless of KillerSoft for helping me with that one)

= 1.4.21 =
* Fixed UTF-8 issues
* Enabled UTF-8 Pretty Link slugs
* Enabled UTF-8 tweets for Pro users
* Fixed several issues for users hosted on Windows
* Added padding configuration to space the buttons on the social bar for Pro users
* Fixed the html validation issues with the tweet badge and social buttons bar for Pro users

= 1.4.20 =
* Added IPv6 support for IP Address Exclusions
* Added Twitter Comments post widget for Pro users
* Added RSS feed support for the tweet badge for Pro users

= 1.4.19 =
* Fixed https image loading / path issue
* Fixed bookmarklet javascript encoding issue
* Fixed import / export issue for pro users
* Added Hyves.nl and Sphinn to the social buttons bar
* Added more placement options for the social buttons bar
* Added a social buttons bar shortcode & template tag

= 1.4.18 =
* Added the Social Network Button Bar for Pro Users

= 1.4.17 =
* Fixed the php strict tags issue affecting some users
* Fixed the click record issue affecting some IIS users
* Added DOCTYPE line to Pretty Bar HTML
* Elimitated Pro upgrade messages for Pro users

= 1.4.16 =
* Fixed PrliUrlUtils not found error affecting some users
* Added instructions for installing the Pretty Link bookmarklet on the iPhone
* Added a URL Alias feature to Pro to allow tweet counts to be aggregated and hence, more accurate

= 1.4.15 =
* Fixed the nested slug cookie issue.

= 1.4.14 =
* Fixed bookmarklet/fopen issue affecting some users
* Fixed XML-RPC auto-tweeting of Posts
* Fixed Scheduled auto-tweeting & link creation of Posts issue
* Fixed bulk auto link creation issue
* Added slug choice for your post
* Added a twitter message formatting textarea on the post edit screen

= 1.4.13 =
* Fixed the option reset issue

= 1.4.12 =
* Added title detection
* Added enhancements to the Pretty Link Bookmarklet
* Added better support for IIS by redefining the fnmatch function if it isn't present
* Changed the keyword replacement algorithm in Pro to replace links throughout the post when thresholds are set (instead of only linking to the top x keywords)
* Fixed some issues surrounding keyword content caching in Pro

== Screenshots ==
[Pretty Link Screenshots](http://blairwilliams.com/pretty-link "Pretty link Screenshots")

[Pretty Link Pro Screenshots](http://prettylinkpro.com "Pretty link Pro Screenshots")
