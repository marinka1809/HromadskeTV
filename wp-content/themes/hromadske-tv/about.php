<?php
/**
Template Name: About
 */
get_header();?>
<main>
    <?php while ( have_posts() ) : the_post();?>
        <section class="title-section" style="background: url('<?php echo get_the_post_thumbnail_url(); ?>') 50% 50% no-repeat; background-size: cover;">
            <div class="container"?>
                <h1><?php the_title();?></h1>
                <p><?php the_content(); ?> </p>
            </div>
        </section>

        <?php
        $args = array(
            'post_type' => 'employees',
        );
        $employeesPosts = new WP_Query($args);

        if ( $employeesPosts->have_posts() ) :?>
            <section class="section team-section">
                <div class="container">
                    <h1><?php the_field("title_section_team"); ?></h1>
                    <ul class="row">
                        <?php while ( $employeesPosts->have_posts() ) : $employeesPosts->the_post();?>
                            <li class="col-sm-4">
                                <?php the_post_thumbnail();?>
                                <h3><?php the_title();?></h3>
                                <?php the_excerpt(); ?>
                            </li>
                        <?php endwhile;  ?>
                    </ul>
                </div>
            <main>
        <?php endif;
        wp_reset_postdata(); ?>

       <section class="section contacts-section">
            <div class="container">
                <h1><?php the_field("title_section_contacts"); ?></h1>

                <address>
                    <ul class="row">
                        <li class="col-sm-4">
                            <span class="fa <?php the_field("address_icon"); ?>" aria-hidden="true"></span>
                            <span> <?php the_field("address_label"); ?></span>
                            <p><?php the_field("address"); ?></p>
                        </li>
                        <li class="col-sm-4">
                            <span class="fa <?php the_field("phone_icon"); ?>" aria-hidden="true"></span>
                            <span> <?php the_field("phone_label"); ?></span>
                            <a href="tel:<?php the_field("phone_"); ?>"><?php the_field("phone_"); ?></a>
                            <a href="tel:<?php the_field("mobile_phone"); ?>"><?php the_field("mobile_phone"); ?></a>
                        </li>
                        <li class="col-sm-4">
                            <span class="fa <?php the_field("email_icon"); ?>" aria-hidden="true"></span>
                            <span> <?php the_field("email_label"); ?></span>
                            <a class="" href="mailto:<?php the_field("email"); ?>"><?php the_field("email"); ?></a>
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
