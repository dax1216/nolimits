<?php

function wp_days_ago_v3 ($stopUsingAjaxAfter = 0, $showDateAfter = -1, $showDateFormat = null) {
	$post_id = get_the_ID();
	$the_time = get_post_time("U", true, $post_id);
	if(gmmktime() - $the_time > $stopUsingAjaxAfter) {
		echo wp_days_ago_internal_v3($the_time, $post_id, $showDateAfter, $showDateFormat);
	} else {
		echo "<script type=\"text/javascript\"><!--\n";
		echo "jQuery(document).ready(function(){";
		echo "get_wp_days_ago_v3(" . $post_id . ", '" . $showDateAfter . "', '" . $showDateFormat . "');";
		echo "})\n";
		echo "--></script>\n";
		echo "<span class=\"wp_days_ago\" id=\"wp_days_ago-" . $post_id . "\">" . get_post_time("H:i", false, $post_id) . " cet</span>";
	}
}

function wp_days_ago_ajax_handler_v3 () {
	$showDateFormat = $_POST["showDateFormat"];
	if($showDateFormat == 'null' || $showDateFormat == '') {
		$showDateFormat = null;
	}
	die(wp_days_ago_internal_v3(get_post_time("U", true, $_POST["postId"]), $_POST["postId"], $_POST["showDateAfter"], $showDateFormat));
}

function wp_days_ago_internal_v3 ($the_time, $postId, $showDateAfter = -1, $showDateFormat = null) {
		
	$gmt_offset = get_option("gmt_offset");
	$gmmktime = gmmktime();
	if($gmt_offset != null && $gmt_offset != "") {
		$the_time = $the_time + (3600 * $gmt_offset);
		$gmmktime = $gmmktime + (3600 * $gmt_offset); 
	}
			
	$output = "";

	if($showDateAfter > 0 && ($gmmktime - $the_time > $showDateAfter)) {
		if($showDateFormat == null) {
			$showDateFormat = get_option('date_format') . " " . get_option('time_format');
		}
		$output .= get_the_time($showDateFormat, $postId);
	} else {
		$output .= timespanToString(calculateTimespan($the_time, $gmmktime));
	}

	return $output;
}

function timespanToString($t) {

	$foundSomething = $foundYear = $foundMonth = $singular = false;
	$s = "";

	// Year.
	if($t[0] >= 1) {
		$foundSomething = true;
		$foundYear = true;
		$s .= $t[0];
		if($t[0] == 1) {
			$s .= " " . __("year", "wp-days-ago"); // YEAR
		} else {
			$s .= " " . __("years", "wp-days-ago"); // YEARS
		}
	}
	
	// Month.
	if($t[1] >= 1) {
		$foundSomething = true;
		$foundMonth = true;
		if(strlen($s) > 0) {
			$s .= ", ";
		}
		$s .= $t[1];
		if($t[1] == 1) {
			$s .= " " . __("month", "wp-days-ago"); // MONTH
		} else {
			$s .= " " . __("months", "wp-days-ago"); // MONTHS
		}
	}
	
	// Day.
	if($t[2] >= 1 && (($foundYear && !$foundMonth) || (!$foundYear && $foundMonth) || (!$foundYear && !$foundMonth))) {
		$foundSomething = true;
		if(strlen($s) > 0) {
			$s .= ", ";
		}
		if($t[2] == 1) {
			if($foundYear || $foundMonth) {
				$s .= $t[2] . " " . __("day", "wp-days-ago"); // DAY
			} else {
				$s .= " " . __("1 day ago", "wp-days-ago"); // YESTERDAY
				$singular = true;
			}
		} else if($t[2] == 7 && !$foundYear && !$foundMonth) {
			$s .= " " . __("One week", "wp-days-ago"); // ONE WEEK
		} else {
			$s .= $t[2] . " " . __("days", "wp-days-ago"); // DAYS
		}
	}
	
	// Hour.
	if($t[3] >= 1 && !$foundSomething) {
		$foundSomething = true;
		if(strlen($s) > 0) {
			$s .= ", ";
		}
		$s .= $t[3];
		if($t[3] == 1) {
			$s .= " " . __("hour", "wp-days-ago"); // HOUR
		} else {
			$s .= " " . __("hours", "wp-days-ago"); // HOURS
		}
	}
	
	// Minute.
	if($t[4] >= 1 && !$foundSomething) {
		$foundSomething = true;
		if(strlen($s) > 0) {
			$s .= ", ";
		}
		$s .= $t[4];
		if($t[4] == 1) {
			$s .= " " . __("minute", "wp-days-ago"); // MINUTE
		} else {
			$s .= " " . __("minutes", "wp-days-ago"); // MINUTES
		}
	}
	
	//Second.
	if($t[5] >= 1 && !$foundSomething) {
		$foundSomething = true;
		$singular = true;
		$s .= __("Just now", "wp-days-ago"); // JUST NOW
	}
	
	$prepender = __("prepender", "wp-days-ago");
	if($prepender == "prepender") {
		$prepender = "";
	}
	
	return ($singular ? "" : " " . $prepender) . " " . $s . ($singular ? "" : " " . __("ago", "wp-days-ago")); // AGO
}

function calculateTimespan($older, $newer) { 

	if(($newer - $older > 86400) || (date("j", $newer) != date("j", $older) && $newer - $older < 86400)) {
		$newer = mktime(0, 0, 0, date("n", $newer), date("j", $newer), date("Y", $newer));
		$older = mktime(0, 0, 0, date("n", $older), date("j", $older), date("Y", $older));
	}

	$Y1 = date('Y', $older); 
	$Y2 = date('Y', $newer); 
	$Y = $Y2 - $Y1; 

	$m1 = date('m', $older); 
	$m2 = date('m', $newer); 
	$m = $m2 - $m1; 

	$d1 = date('d', $older); 
	$d2 = date('d', $newer); 
	$d = $d2 - $d1; 

	$H1 = date('H', $older); 
	$H2 = date('H', $newer); 
	$H = $H2 - $H1; 

	$i1 = date('i', $older); 
	$i2 = date('i', $newer); 
	$i = $i2 - $i1; 

	$s1 = date('s', $older); 
	$s2 = date('s', $newer); 
	$s = $s2 - $s1; 

	if($s < 0) { 
		$i = $i -1; 
		$s = $s + 60; 
	} 
	if($i < 0) { 
		$H = $H - 1; 
		$i = $i + 60; 
	} 
	if($H < 0) { 
		$d = $d - 1; 
		$H = $H + 24; 
	} 
	if($d < 0) { 
		$m = $m - 1; 
		$d = $d + date('t', mktime(0, 0, 0, $m1, 1, $Y1));
	} 
	if($m < 0) { 
		$Y = $Y - 1; 
		$m = $m + 12; 
	} 
  
	return array($Y, $m, $d, $H, $i, $s);
} 
?>