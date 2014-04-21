=== wp-days-ago ===
Contributors: vskjefst
Tags: facebook, twitter, posts, pages, date, day, days, hours, minutes, relative date, years ago, months ago, days ago, hours ago, minutes ago
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=28LC77UW3XFBY&lc=NO&item_name=www%2evegard%2enet&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Requires at least: 2.1
Tested up to: 3.8.1
Stable tag: trunk

Displays the number of years, days, hours and minutes since a post or a page was published in the same format as Facebook, Twitter etc.

== Description ==

This plugin displays the number of years, months, days, hours and minutes since a post or a page was published in the same format as Facebook, Twitter etc. Examples are "Just now" (less than a minute ago), "47 minutes ago" (less than an hour ago), "3 hours ago" (less than a day ago), "Yesterday", "3 days ago", "One week ago", "3 months ago", "3 months, 4 days ago", "2 years, 13 days ago" and so on. It's also possible to configure wp-days-ago to fall back to displaying the actual date and time when a post or page was published when a certain number of seconds after publishing time has been reached.

Cache plugins, like W3 Total Cache and WP Super Cache, are supported through the use of AJAX. This means that the plugin will show correct information even if the page is cached. Please see the installation instructions, and the stopUsingAjaxAfter parameter in particular, for details.

= Available translations =
* Dutch (thanks to Marjolein Boer, [Pixelein](http://www.pixelein.nl/))
* English
* Norwegian (bokmål)
* Norwegian (nynorsk)
* Russian (thanks to Yuri from [www.coinside.ru](http://www.coinside.ru/))
* Spanish (thanks to Andrew Kurtis, [WebHostingHub](http://www.webhostinghub.com/))
* Swedish
* Turkish

== Installation ==

1. [Download](http://downloads.wordpress.org/plugin/wp-days-ago.zip) the plugin.
2. Unzip the contents of the downloaded file to the /wp-content/plugins/ directory of your WordPress installation.
3. Log in to your WordPress dashboard and activate the wp_days_ago plugin that should now be visible in the list.
4. You can now insert &lt;? wp_days_ago_v3(); ?&gt; anywhere in [The Loop](http://codex.wordpress.org/The_Loop) in your WordPress theme.

= Usage =

&lt;?php wp_days_ago_v3 ($stopUsingAjaxAfter, $showDateAfter, $showDateFormat) ?&gt;

$stopUsingAjaxAfter
 (int) (optional) The number of seconds since a post or page was published before the plugin should stop using AJAX to display information. The default value is 0, which means the feature is turned off and AJAX is never used. If you have a cached site and the cache update interval is a day or less, 86400 (one day) is a good value for the plugin. The reason for this is that one day after a post or page was published, the plugin will start to show information in daily intervals ("yesterday", "2 days ago", "3 days ago", etc). If the post or page was published less than a day ago, the plugin will update in smaller intervals ("10 minutes ago", "3 hours ago", "4 hours ago", etc) and AJAX is needed to ensure that this is displayed correctly on a cached site. The minimum value should be the cache update interval.

$showDateAfter
 (int) (optional) The number of seconds since a post or page was published before the plugin falls back to showing the actual date and time the post or page was published, instead of in its usual "X days ago" format. The default is -1 seconds, i.e. the feature is turned off by default.
 
$showDateFormat
 (string) (optional) The format the plugin should use to display the date and time a post or page was published if the number of seconds configured in the showDateAfter parameter has been reached. The default behaviour is to use the date and time formats configured in Wordpress, but if this parameter is set, the date and time format it defines will be used instead of the format you have configured in WordPress. See [Formatting Date and Time](http://codex.wordpress.org/Formatting_Date_and_Time) for other time and date formats if you want to override the configured formats.

= Information for translators =
 
There's a POT file in the languages folder if you want to translate the plugin into another language. If you do that, I'd really appreciate it if you could provide me with the PO/POT and MO file so it can be included in future versions of the plugin. You will of course be credited for your work. 

In the POT file, there's a string called "prepender". This is for languages that need to prepend a word before the number in the string. An example is Norwegian, which will prepend the word "for" before the number: "For 2 dager siden". "For" is the prepender. Some languages doesn't use the prepender, English being a natural example. The Norwegian example is "2 days ago" in English. If your language doesn't need to use a prepender, simply leave the string untranslated.
 
== Upgrade notice ==
Version 3.0.0 is a complete rewrite of the plugin. Functions from version 2.x are still available to ensure backwards compatibility and will continue to work as they used to, but bugs will not be fixed. It's highly recommended that you start to use the _v3 methods described in the installation instructions if you upgade from version 2 or an even earlier version.

== Changelog ==

= 3.0.3 =
* Added Dutch translation (thanks to Marjolein Boer, [Pixelein](http://www.pixelein.nl/)).

= 3.0.2 =
* Added Russian translation (thanks to Yuri from [www.coinside.ru](http://www.coinside.ru/)).

= 3.0.1 =
* Added Spanish (thanks to Andrew Kurtis, [WebHostingHub](http://www.webhostinghub.com/)), Turkish, Swedish and Norwegian (nynorsk) translations.

= 3.0.0 =
* Bugfix: Fixed some edge case bugs.
* Change: Version 3.0.0 is a complete rewrite of the plugin. Functions from version 2.x are still available to ensure backwards compatibility and will continue to work as they used to, but bugs will not be fixed. It's highly recommended that you start to use the _v3 methods described in the installation instructions if you upgade from version 2 or an even earlier version.
* Change: Now supports translations, see included POT file if you want to translate the plugin into your language.

= 2.6.1 =
* Change: When calculating days, the plugin will now ignore the publishing time and only use the actual date.
* Change: When calculating years, the plugin will now take into account leap years.

Both changes should lead to a more accurate output from the plugin.

= 2.6 =
* New feature: Support for falling back to showing the date and time a post or page is published instead of "X days ago" and similar a configured number of seconds after the post or page is published. The feature is turned off by default, so if you are upgrading from a previous version of wp-days-ago, there is no need for you to change anything unless you want to use this new feature.

= 2.5.2 =
* Bugfix: Fixed a major bug that happened when using the wp_days_ago method. Thanks to user heinnge for reporting this.

= 2.5.1 =
* New feature: Added a threshold parameter to control when AJAX should be used and when the plugin should automatically fall back to the old way of displaying information. After a day, the plugin doesn't display any detailed information anyway so there is no need to strain the server with a lot of AJAX calls. The information displayed by wp-days-ago will of course be updated when your cache plugin invalidates the content and rebuilds it. The value of the wp_days_ago_ajax method threshold paramterer should match the configured invalidation threshold of your cache plugin.
* Change: Optimized date calculation and database access code.

= 2.5 =
* New feature: Cached sites are now supported through the use of the wp_days_ago_ajax function. See above for details.
* Change: Minimum required version of WordPress is now 2.1.

= 2.0.2 =
* New feature: Added text "Some time in the future" for scheduled posts (visible in preview mode only).

= 2.0.1 =
* Change: Removed some debug code that had made its way into the release.

= 2.0 =
* New feature: The plugin now by default displays minutes and hours since a post or page was created.
* Change: The $offset parameter from the 1.x version is now replaced with a $mode parameter that enables you to prevent the plugin from displaying the minutes and hours since a post or page was published and instead fall back to "Today" for everything published lest than 24 hours ago.

= 1.7.1 =
* Changed some of the default texts so that they start with a capital letter.

= 1.7 =
* Backwards compatible all the way back to Wordpress 1.5.
* The plugin now uses the internal Wordpress timezone settings.
* Added optional parameters that allows configuration of appended text, prepended text and the texts displayed by the plugin.

= 1.0 =
* Initial version.