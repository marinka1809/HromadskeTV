<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

class twoj_widget extends WP_Widget {

  function __construct(){
    parent::__construct(
      'twoj_widget', 
      twoj_slideshow_t( '2J Slideshow Widget' , '2j-slideshow' ),
      array( 'description' => twoj_slideshow_t( "Publish slideshow on your website.", '2j-slideshow' ), ) 
    );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $slideshowId = $instance['slideshowId'];

    echo $args['before_widget'];
    if( ! empty( $title ) )     echo $args['before_title'] . $title . $args['after_title'];
    
    if( TWOJ_SLIDESHOW_PRO ){
    	twojSlideshowWidget($slideshowId);
    }
    
    if(!TWOJ_SLIDESHOW_PRO) echo twoj_slideshow_et( 'This widget available in Premium version','2j-slideshow');
    echo $args['after_widget'];
  }


  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = twoj_slideshow_t( 'New Slideshow', '2j-slideshow' );
    }
    
    if ( isset( $instance[ 'slideshowId' ] ) ) {
        $slideshowId = (int) $instance[ 'slideshowId' ];
    }
    else {
        $slideshowId = 0;
    }
    $args = array(
      'child_of'     => 0,
      'sort_order'   => 'ASC',
      'sort_column'  => 'post_title',
      'hierarchical' => 1,
      'selected'     => $slideshowId,
      'name'         => $this->get_field_name( 'slideshowId' ),
      'id'           => $this->get_field_id( 'slideshowId' ),
      'echo'    => 1,
      'post_type' => 'twoj_slideshow_post'
    );
    ?>
	<?php 
	if(!TWOJ_SLIDESHOW_PRO){ ?>
    	<p><a href="http://2joomla.net/wordpress/open.php?product=2jslideshow&task=gopro" target="_blank"> <?php twoj_slideshow_et( 'This widget available in Premium version','2j-slideshow');?> </a></p>     
	<?php } ?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">
	 		<?php twoj_slideshow_et( 'Title', '2j-slideshow' ); ?>:
		</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'slideshowId' ); ?>"><?php twoj_slideshow_et( 'Slideshow' ); ?>:</label> 
		<?php wp_dropdown_pages( $args ); ?>
	</p>
	<p><?php twoj_slideshow_et( 'Configure it in','2j-slideshow');?> 
		<a href="edit.php?post_type=twoj_slideshow_post">
			<?php twoj_slideshow_et( '2J Slideshow plugin','2j-slideshow');?>
		</a>
	</p>
	<script type="text/javascript">jQuery(function(){ jQuery('#<?php echo $this->get_field_id( 'slideshowId' ); ?>').addClass('widefat'); });</script>
    <?php 
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['slideshowId'] = ( ! empty( $new_instance['slideshowId'] ) ) ? (int) $new_instance['slideshowId'] : 0;
    return $instance;
  }
}


function twoj_load_widget() {
  register_widget( 'twoj_widget' );
}

add_action( 'widgets_init', 'twoj_load_widget' );