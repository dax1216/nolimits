<?php
$display_google_map = get_option('theme_display_google_map');
if($display_google_map == 'true'){
global $post;
$property_location = get_post_meta($post->ID,'NO_LIMIT_caring_location',true);

if(!empty($property_location))
{
    $lat_lng = explode(',',$property_location);

    /* Property Map Icon Based on Property Type */
    $property_type_slug = 'single-family-home'; // Default Icon Slug
    $property_marker_icon = '';

    $type_terms = get_the_terms( $post->ID,"property-type" );
    if(!empty($type_terms)){
        foreach($type_terms as $typ_trm){
            $property_type_slug = $typ_trm->slug;
            break;
        }
    }

    if( file_exists( get_template_directory().'/images/map/'.$property_type_slug.'-map-icon.png' ) ){
        $property_marker_icon = get_template_directory_uri().'/images/map/'.$property_type_slug.'-map-icon.png';
    }else{
        $property_marker_icon = get_template_directory_uri().'/images/map/single-family-home-map-icon.png';
    }
    ?>
    <div class="map-wrap clearfix">
        <span class="map-label"><?php _e('Location Map', 'framework'); ?></span>
        <div id="property_map"></div>

        <div class="share-networks clearfix">
            <span class="share-label"><?php _e('Share this', 'framework'); ?></span>
            <span><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook fa-lg"></i><?php _e('Facebook','framework'); ?></a></span>
            <span><a target="_blank" href="https://twitter.com/share?url=<?php the_permalink(); ?>" ><i class="fa fa-twitter fa-lg"></i><?php _e('Twitter','framework'); ?></a></span>
            <span><a target="_blank" href="https://plus.google.com/share?url={<?php the_permalink(); ?>}" onclick="javascript:window.open(this.href,  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes')"><i class="fa fa-google-plus fa-lg"></i><?php _e('Google','framework'); ?></a></span>
        </div>
    </div>
    <script>
        /* Property Detail Page - Google Map for Property Location */

        function initialize_property_map(){
            var propertyLocation = new google.maps.LatLng(<?php echo $lat_lng[0]; ?>,<?php echo $lat_lng[1]; ?>);
            var propertyMapOptions = {
                center: propertyLocation,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false
            };
            var propertyMap = new google.maps.Map(document.getElementById("property_map"), propertyMapOptions);
            var propertyMarker = new google.maps.Marker({
                position: propertyLocation,
                map: propertyMap,
                icon: "<?php echo $property_marker_icon; ?>"
            });
        }

        window.onload = initialize_property_map();
    </script>
    <?php
}
}
?>