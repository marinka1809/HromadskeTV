<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

?>
<div class="wrap">
	<h1><?php twoj_slideshow_et('2J Slideshow Detailed Report', 'rbs_gallery'); ?></h1>
<?php 
$today = date("Y_j_n"); 

$countPosts = wp_count_posts(TWOJ_SLIDESHOW_TYPE_POST);
//print_r($countPosts);
$args = array(
	'post_type'  => TWOJ_SLIDESHOW_TYPE_POST,
	'meta_key'   => 'views',
	'posts_per_page' =>-1,
);
$views = 0;
$loop = new WP_Query($args);

if ( $loop->have_posts() ){
	for ($i=0; $i <count($loop->posts) ; $i++) { 
		$views += (int) get_post_meta( $loop->posts[$i]->ID, 'views', true);
	}
}
	?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label ><?php twoj_slideshow_et('Slideshow Views', 'twoj_slideshow'); ?></label></th>
				<td><p><?php echo $views ; ?></p></td>
			</tr>
			<tr>
				<th scope="row"><label ><?php twoj_slideshow_et('Slideshows Amount', 'twoj_slideshow'); ?></label></th>
				<td>
	
						<?php $total =  
							$countPosts->publish + 
							$countPosts->future + 
							$countPosts->draft + 
							$countPosts->pending + 
							$countPosts->private + 
							$countPosts->trash + 
							$countPosts->inherit;
						?> 

					<p>
						<?php echo 
							$countPosts->publish.' '.twoj_slideshow_t('Published', 'twoj_slideshow').' + '.
							$countPosts->future.' '.twoj_slideshow_t('Future', 'twoj_slideshow') .' + '.
							$countPosts->pending.' '.twoj_slideshow_t('Pending', 'twoj_slideshow') .' + '.
							$countPosts->private.' '.twoj_slideshow_t('Private', 'twoj_slideshow') .' + '.
							$countPosts->draft.' '.twoj_slideshow_t('Draft', 'twoj_slideshow') .' + '.
							$countPosts->trash.' '.twoj_slideshow_t('Trash', 'twoj_slideshow') .' = '.
							'<strong> '.$total.' '.twoj_slideshow_t('In Total', 'twoj_slideshow').'</strong>'
							;
						?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?php 