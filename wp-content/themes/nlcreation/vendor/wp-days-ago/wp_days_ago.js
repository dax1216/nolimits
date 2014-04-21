function get_wp_days_ago (postId, mode, prepend, append, showDateAfter, showDateFormat) {
	jQuery.ajax({
        type: 'POST',
        url: wp_days_ago_script.ajaxurl,
        data: {
            action: 'wp_days_ago_ajax',
            postId: postId,
			mode: mode,
			prepend: prepend,
			append: append,
			showDateAfter: showDateAfter,
			showDateFormat: showDateFormat
        },
        success: function(data, textStatus, XMLHttpRequest) {
			jQuery("#wp_days_ago-" + postId).html(data);
        }
    });
}

function get_wp_days_ago_v3 (postId, showDateAfter, showDateFormat) {
	jQuery.ajax({
        type: 'POST',
        url: wp_days_ago_script.ajaxurl,
        data: {
            action: 'wp_days_ago_ajax_v3',
            postId: postId,
			showDateAfter: showDateAfter,
			showDateFormat: showDateFormat
        },
        success: function(data, textStatus, XMLHttpRequest) {
			jQuery("#wp_days_ago-" + postId).html(data);
        }
    });
}