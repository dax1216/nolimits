<?php
function wp_days_ago_ajax($mode = 0, $prepend = "", $append = "", $threshold = 86400, $showDateAfter = -1, $showDateFormat = null) {
	
	$post_id = get_the_ID();
	$the_time = get_the_time("U", $post_id);
	if(gmmktime() + (get_option('gmt_offset') * 3600) - $the_time > $threshold) {
		echo wp_days_ago_internal($the_time, $post_id, $mode, $prepend, $append, null, $showDateAfter, $showDateFormat);
	} else {
		echo "<script type=\"text/javascript\"><!--\n";
		echo "jQuery(document).ready(function(){";
		echo "get_wp_days_ago(" . $post_id . ", " . $mode . ", '" . $prepend . "', '" . $append . "', '" . $showDateAfter . "', '" . $showDateFormat . "');";
		echo "})\n";
		echo "--></script>\n";
		echo "<span class=\"wp_days_ago\" id=\"wp_days_ago-" . $post_id . "\"></span>";
	}
}

function wp_days_ago_ajax_handler () {
	$showDateFormat = $_POST["showDateFormat"];
	if($showDateFormat == 'null' || $showDateFormat == '') {
		$showDateFormat = null;
	}
	die(wp_days_ago_internal(get_the_time("U", $_POST["postId"]), $_POST["postId"], $_POST["mode"], $_POST["prepend"], $_POST["append"], null, $_POST["showDateAfter"], $showDateFormat));
}

function wp_days_ago ($mode = 0, $prepend = "", $append = "", $texts = null, $showDateAfter = -1, $showDateFormat = null) {
	$postId = get_the_ID();
	echo wp_days_ago_internal(get_the_time("U", $postId), $postId, $mode, $prepend, $append, $texts, $showDateAfter, $showDateFormat);
}

function wp_days_ago_internal ($the_time, $postId, $mode = 0, $prepend = "", $append = "", $texts = null, 
		$showDateAfter = -1, $showDateFormat = null) {
		
	if($texts == null) {
		$texts = array("Today", "Yesterday", "One week ago", "days ago", "year",
		"years", "ago", "day ago", "days ago", "Just now", "One minute ago", "minutes ago", "1 hour ago", "hours ago", "Some time in the future");
	}
			
	$gmt_offset = get_option('gmt_offset');

	$output = $prepend;

	if($showDateAfter > 0 && (gmmktime() + ($gmt_offset * 3600) - $the_time > $showDateAfter)) {
		if($showDateFormat == null) {
			$showDateFormat = get_option('date_format') . " " . get_option('time_format');
		}
		$output .= get_the_time($showDateFormat, $postId);
	} else {
		$minutes = round((gmmktime() + ($gmt_offset * 3600) - $the_time) / 60);
	
		if($minutes < 0) {
			$output .= $texts[14];
		} else if($mode == 0 && $minutes < 1440) {
			if($minutes == 0) {
				$output .= $texts[9];
			} else if($minutes == 1) {
				$output .= $texts[10];
			} else if($minutes < 60) {
				$output .= $minutes . " " . $texts[11];
			} else if($minutes < 120) {
				$output .= $texts[12];
			} else {
				$output .= floor($minutes / 60) . " " . $texts[13];
			}
		} else {
			$now = strtotime(date("Y-m-d", (gmmktime() + ($gmt_offset * 3600))));
			$published = strtotime(date("Y-m-d", $the_time));
			$days = floor(($now - $published) / 86400);
			
			if($days == 0)
				$output = $output . $texts[0];
			else if($days == 1)
				$output = $output . $texts[1];
			else if($days == 7)
				$output = $output . $texts[2];
			else {
				$startYear = date("Y", $published);
				$endYear = date("Y", $now);
				$completeYears = 0;
				$daysLeft = $days;
				for($i = $startYear; $i < $endYear; $i++) {
					$numberOfDays = date("z", mktime(0,0,0,12,31,$i)) + 1;
					if($daysLeft - $numberOfDays >= 0) {
						$daysLeft -= $numberOfDays;
						$completeYears++;
					}
				}
				
				if($completeYears > 0) {
					if($completeYears == 1)
						$yearappend = $texts[4];
					else 
						$yearappend = $texts[5];
						
					$days = $daysLeft;
					if($days == 0)
						$output = $output . $completeYears . " " . $yearappend . " " . $texts[6];
					else if($days == 1)
						$output = $output . $completeYears . " " . $yearappend . ", " . $days . " " . $texts[7];
					else
						$output = $output . $completeYears . " " . $yearappend . ", " . $days . " " . $texts[8];
				} else {
					$output = $output . $days . " " . $texts[3];
				}
			}
		}
	}

	return $output . $append;
}
?>