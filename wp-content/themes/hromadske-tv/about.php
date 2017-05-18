<?php
/**
Template Name: About
 */
get_header();?>
<main class="about-page">
    <?php while ( have_posts() ) : the_post();?>
        <section class="title-section" style="background: url('<?php echo get_the_post_thumbnail_url(); ?>') 50% 50% no-repeat; background-size: cover;">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h1><?php the_title();?></h1>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
        $args = array(
            'post_type' => 'employees',
            'posts_per_page' => 9999,
        );
        $employeesPosts = new WP_Query($args);

        if ( $employeesPosts->have_posts() ) :?>
            <section class="team-section">
                <div class="container">
                    <h1><?php the_field("title_section_team"); ?></h1>
                    <ul class="row">
                        <?php while ( $employeesPosts->have_posts() ) : $employeesPosts->the_post();?>
                            <li class="col-sm-4">
                                <article>
                                    <?php the_post_thumbnail('thumbnails');?>
                                    <h3><?php the_title();?></h3>
                                    <?php the_excerpt(); ?>
                                </article>
                            </li>
                        <?php endwhile;  ?>
                    </ul>
                </div>
            </section>
        <?php endif;
        wp_reset_postdata(); ?>

       <section class="contacts-section">
            <div class="container">
                <h1><?php the_field("title_section_contacts"); ?></h1>

                <address>
                    <ul class="row">
                        <li class="col-sm-4">
                            <span class="icomoon <?php the_field("address_icon"); ?>"></span>
                            <span class="label-name"> <?php the_field("address_label"); ?></span>
                            <p><?php the_field("address"); ?></p>
                        </li>
                        <li class="col-sm-4 center-li">
                            <span class="icomoon <?php the_field("phone_icon"); ?>"></span>
                            <span class="label-name"> <?php the_field("phone_label"); ?></span>
                            <p>
                                <a href="tel:<?php the_field("phone_"); ?>"><?php the_field("phone_"); ?></a>,
                                <a href="tel:<?php the_field("mobile_phone"); ?>"><?php the_field("mobile_phone"); ?></a>
                            </p>
                        </li>
                        <li class="col-sm-4">
                            <span class="icomoon <?php the_field("email_icon"); ?>"></span>
                            <span class="label-name"> <?php the_field("email_label"); ?></span>
                            <p>
                                <a class="link-mail" href="mailto:<?php the_field("email"); ?>"><?php the_field("email"); ?></a>
                            </p>
                        </li>
                    </ul>
                </address>

                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWpDHIRvBTDtPcZj6mUk2575_Bj3kIXC0"></script>
                <script type="text/javascript">
                    (function($) {

                        /*
                         *  render_map
                         *
                         *  This function will render a Google Map onto the selected jQuery element
                         *
                         *  @type    function
                         *  @date    8/11/2013
                         *  @since    4.3.0
                         *
                         *  @param    $el (jQuery element)
                         *  @return    n/a
                         */

                        function render_map( $el ) {

                            // var
                            var $markers = $el.find('.marker');

                            // vars
                            var args = {
                                zoom        : 16,
                                center        : new google.maps.LatLng(0, 0),
                                mapTypeId    : google.maps.MapTypeId.ROADMAP
                            };

                            // create map
                            var map = new google.maps.Map( $el[0], args);

                            // add a markers reference
                            map.markers = [];

                            // add markers
                            $markers.each(function(){

                                add_marker( $(this), map );

                            });

                            // center map
                            center_map( map );

                        }

                        /*
                         *  add_marker
                         *
                         *  This function will add a marker to the selected Google Map
                         *
                         *  @type    function
                         *  @date    8/11/2013
                         *  @since    4.3.0
                         *
                         *  @param    $marker (jQuery element)
                         *  @param    map (Google Map object)
                         *  @return    n/a
                         */

                        function add_marker( $marker, map ) {

                            // var
                            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

                            // create marker
                            var marker = new google.maps.Marker({
                                position    : latlng,
                                map            : map,
                                icon: '<?php the_field('image_for_marker'); ?>'
                            });

                            // add to array
                            map.markers.push( marker );

                            // if marker contains HTML, add it to an infoWindow
                            if( $marker.html() )
                            {
                                // create info window
                                var infowindow = new google.maps.InfoWindow({
                                    content        : $marker.html()
                                });

                                // show info window when marker is clicked
                                google.maps.event.addListener(marker, 'click', function() {

                                    infowindow.open( map, marker );

                                });
                            }

                        }

                        /*
                         *  center_map
                         *
                         *  This function will center the map, showing all markers attached to this map
                         *
                         *  @type    function
                         *  @date    8/11/2013
                         *  @since    4.3.0
                         *
                         *  @param    map (Google Map object)
                         *  @return    n/a
                         */

                        function center_map( map ) {

                            // vars
                            var bounds = new google.maps.LatLngBounds();

                            // loop through all markers and create bounds
                            $.each( map.markers, function( i, marker ){

                                var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

                                bounds.extend( latlng );

                            });

                            // only 1 marker?
                            if( map.markers.length == 1 )
                            {
                                // set center of map
                                map.setCenter( bounds.getCenter() );
                                map.setZoom( 16 );
                            }
                            else
                            {
                                // fit to bounds
                                map.fitBounds( bounds );
                            }

                        }

                        /*
                         *  document ready
                         *
                         *  This function will render each map when the document is ready (page has loaded)
                         *
                         *  @type    function
                         *  @date    8/11/2013
                         *  @since    5.0.0
                         *
                         *  @param    n/a
                         *  @return    n/a
                         */

                        $(document).ready(function(){

                            $('.acf-map').each(function(){

                                render_map( $(this) );

                            });

                        });

                    })(jQuery);
                </script>

                <?php

                $location = get_field('google_map');

                if( !empty($location) ):
                    ?>
                    <div class="acf-map">
                        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
                    </div>
                <?php endif; ?>

       </section>
    <?php endwhile; ?>
</main>

<?php
get_footer();
