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
                            <span class="fa <?php the_field("address_icon"); ?>" aria-hidden="true"></span>
                            <span class="label-name"> <?php the_field("address_label"); ?></span>
                            <p><?php the_field("address"); ?></p>
                        </li>
                        <li class="col-sm-4 center-li">
                            <span class="fa <?php the_field("phone_icon"); ?>" aria-hidden="true"></span>
                            <span class="label-name"> <?php the_field("phone_label"); ?></span>
                            <p>
                                <a href="tel:<?php the_field("phone_"); ?>"><?php the_field("phone_"); ?></a>,
                                <a href="tel:<?php the_field("mobile_phone"); ?>"><?php the_field("mobile_phone"); ?></a>
                            </p>
                        </li>
                        <li class="col-sm-4">
                            <span class="fa <?php the_field("email_icon"); ?>" aria-hidden="true"></span>
                            <span class="label-name"> <?php the_field("email_label"); ?></span>
                            <p>
                                <a class="link-mail" href="mailto:<?php the_field("email"); ?>"><?php the_field("email"); ?></a>
                            </p>
                        </li>
                    </ul>
                </address>
                <?php $image = get_field("map"); ?>
                <img src="<?php echo $image['url'];?>" alt="<?php echo $image['alt']; ?>"/>
            </div>
       </section>
    <?php endwhile; ?>
</main>

<?php
get_footer();
