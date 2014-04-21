<?php
include("wp_days_ago-core.php");
include("wp_days_ago-core-old.php");

/*
Plugin Name: wp-days-ago
Version: 3.0.3
Plugin URI: http://wordpress.org/extend/plugins/wp-days-ago/
Author: Vegard Skjefstad
Author URI: http://www.vegard.net/
Description: Displays the number of years, days, hours and minutes since a post or a page was published in the same format as Facebook, Twitter etc.

Copyright 2008-2014 Vegard Skjefstad vegard@vegard.net

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function init_wp_days_ago() {
	load_plugin_textdomain("wp-days-ago", false, dirname(plugin_basename( __FILE__ )) . "/languages/" );
}

function wp_days_ago_enqueue_scripts() {
	wp_enqueue_script( "wp_days_ago", plugin_dir_url( __FILE__ ) . "/wp_days_ago.js", array( "jquery" ), "3.0.0");
	wp_localize_script( "wp_days_ago", "wp_days_ago_script", array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );	
}
add_action("init", "init_wp_days_ago");
add_action("wp_enqueue_scripts", "wp_days_ago_enqueue_scripts");
add_action("wp_ajax_nopriv_wp_days_ago_ajax", "wp_days_ago_ajax_handler");
add_action("wp_ajax_wp_days_ago_ajax", "wp_days_ago_ajax_handler");
add_action("wp_ajax_nopriv_wp_days_ago_ajax_v3", "wp_days_ago_ajax_handler_v3");
add_action("wp_ajax_wp_days_ago_ajax_v3", "wp_days_ago_ajax_handler_v3");
?>