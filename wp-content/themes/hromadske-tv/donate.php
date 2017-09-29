<?php
/**
Template Name: Donate
 */
get_header();?>
    <main class="donate-content">
        <?php while ( have_posts() ) : the_post();?>
            <div class="container">
                <div class="row">
                    <header class="col-md-8 col-md-offset-2">
                        <h1><?php the_title();?></h1>
                        <?php the_content(); ?>
                    </header>
                </div>
                <div class="row flex-block">
                    <div class="col-sm-6 col-md-5 col-md-offset-1 bank-details">
                        <div class="block">
                            <h2><?php echo get_post_meta($post->ID, 'title-bank_details', 1); ?></h2>
                            <?php $ban_details = get_post_meta($post->ID, 'bank_details', 1);
                            $pieces = explode("\n", $ban_details);
                            ?>
                            <ul>
                                <?php foreach ($pieces as $value) {?>
                                    <li> <?php echo $value ?> </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5 online-payment">
                        <div class="block">
                            <h2><?php echo get_post_meta($post->ID, 'title-online_payment', 1); ?></h2>
                            <form>
                                <input id='price' type="text" placeholder="<?php echo get_post_meta($post->ID, 'placeholder-sum', 1); ?>">
                                <label for="check1" class="price-label">грн</label>
                                <button type="button" class="payment"><?php echo get_post_meta($post->ID, 'label-submit', 1); ?></button>
                            </form>
                            <span id='form_responce' style='display:none;'></span>
                            <script>
                                var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
                                var post = '<?php echo $post->ID ?>';
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </main>

<?php
get_footer();
