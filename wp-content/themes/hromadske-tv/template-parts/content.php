<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>

	<div class="single-content">

		<?php
			the_content( );

		$tag_block ='';
		if( has_term('', 'post_tag', $post->ID) ):
			$tag_block = '<div class="tags-list">'  . get_the_term_list( $post->ID, 'post_tag', '', '', '' ) .'</div>';
		elseif ( has_term('', 'stories-tags', $post->ID) ):
			$tag_block.= '<div class="tags-list">';
			$tag_block.= get_the_term_list( $post->ID, 'stories-tags', '', '', '' );
			$tag_block.= '</div>';
		elseif ( has_term('', 'episodes-tags', $post->ID) ):
			$tag_block = '<div class="tags-list">' . get_the_term_list( $post->ID, 'episodes-tags', '', '', '' ) .'</div>';
		elseif ( has_term('', 'production-tags', $post->ID) ):
			$tag_block.= '<div class="tags-list">';
			$tag_block.= get_the_term_list( $post->ID, 'production-tags', '', '', '' );
			$tag_block.= '</div>';
		endif;

		echo $tag_block;
		?>
		<!-- Go to www.addthis.com/dashboard to customize your tools -->
		<div class="addthis_inline_share_toolbox_dyx4"></div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
