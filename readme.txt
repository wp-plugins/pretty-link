=== Pretty Link ===
Contributors: supercleanse
Donate link: http://www.blairwilliams.com/pretty-link/donate/
Tags: links, link, url, urls, affiliate, affiliates, pretty, marketing, redirect, forward, plugin, rewrite, shortlink, short, shorten, click, clicks, track, tracking, tiny, tinyurl, budurl, shrinking, domain, shrink, mask, masking, slug, slugs, admin, stats, statistics, stat, statistic, cloaking, cloak, twitter, email, ajax, javascript, ui, csv, download
Requires at least: 2.7.1
Tested up to: 2.7.1
Stable tag: 1.3.5

Shrink,track and share any URL on the Internet from your WordPress website. Unlike other link shrinking services like tinyurl, budurl, and bit.ly, this plugin allows you to create shortlinks coming from your own domain! Pretty Link tracks each hit on your URL and provides a full, detailed report of where the hit came from, the browser, os and host. Pretty Link is a killer plugin for people who want to mask their affiliate links, track clicks from emails, increase the reach of their website by spreading these links via Twitter, forums or comments on other blogs.

== Description ==

Shrink,track and share any URL on the Internet from your WordPress website. Unlike other link shrinking services like tinyurl, budurl, and bit.ly, this plugin allows you to create shortlinks coming from your own domain! Pretty Link tracks each hit on your URL and provides a full, detailed report of where the hit came from, the browser, os and host. Pretty Link is a killer plugin for people who want to mask their affiliate links, track clicks from emails, increase the reach of their website by spreading these links via Twitter, forums or comments on other blogs.

= Examples =

This is a link setup using Pretty Link that redirects to the Pretty Link Homepage where you can find more info about this Plugin:

http://blairwilliams.com/pl

Here's a named Pretty Link (I used the slug 'aweber') that redirects to aweber.com:

http://blairwilliams.com/aweber

Here's a link that Pretty Link generated a random slug for (similar to how bit.ly or tinyurl would do):

http://blairwilliams.com/w7a

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

== Installation ==

1. Upload 'pretty-link.zip' to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Make sure you have changed your permalink Common Settings in Settings -> Permalinks away from "Default" to something else. I prefer using custom and then "/%postname%/" for the simplest possible URL slugs.

= Release Notes =

1.3.5 - Added fixes to include better javascript degredation

1.3.4 - Fixed some issues some users were having while running wordpress in a subdirectory of their document roots

1.3.3 - Bug Fixes

1.3.2 - Added the ability to exclude IP Addresses from the Clicks / Stats. These hits are still recorded in the database but are just excluded from the reports. You can find the text field where you can enter these IP addresses in the Pretty Link Options panel.

1.3.1 - Added rewriting for Parameter Forwarding. Now you can specify the format of the parameters you want to send to your Target URL.

1.3.0 - Added a search bar on the links list.

1.2.9 - Added a Title & Description to the Links. Added sorting to the list of links. Added the Creation date of the link to the list of links.

1.2.8 - In this release I altered the way the url rewriting worked. Instead of using Apache's mod_rewrite, I now use WordPress's internal mechanism. If you still want to use Apache mod_rewrite, just go ahead and select it in the Options page (under Settings).

= Note =
If you are upgrading from a previous version to 1.2.4 or above, the activation process may take a minute or two.

== Frequently Asked Questions ==
[Pretty Link FAQ](http://blairwilliams.com/pretty-link/pretty-link-faq "Pretty link FAQ")

== Screenshots ==
[Pretty Link Screenshots](http://blairwilliams.com/pretty-link "Pretty link Screenshots")
