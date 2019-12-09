<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function twoj_border_get_state_options( $value = false ) {
    $state_list = array( 
    	'none'=>'none',
    	'dotted'=>'dotted',
    	'dashed'=>'dashed',
    	'solid'=>'solid',
    	'double'=>'double',
    	'groove'=>'groove',
    	'ridge'=>'ridge',
    	'inset'=>'inset',
    	'outset'=>'outset',
    	'hidden'=>'hidden'
    );

    $state_options = '';
    foreach ( $state_list as $abrev => $state ) {
        $state_options .= '<option value="'. $abrev .'" '. selected( $value, $abrev, false ) .'>'. $state .'</option>';
    }

    return $state_options;
}

function jt_cmb2_border_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_border_field( $metakey, $post_id );
}

function twoj_border_render_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	$value = wp_parse_args( $value, array(
		'color' => 'rgb(229, 64, 40)',
		'style' => 'solid',
		'width' => '5'
	) );

	?>
<div class="form-horizontal">

	<div class="form-group">
	    <label class="col-sm-2 control-label" for="<?php echo $field_type_object->_id( '_width' ); ?>'"><?php twoj_slideshow_et( 'Width', 'twoj_slideshow' ); ?></label>
	    <div class="col-sm-10">
	    <?php echo $field_type_object->input( array(
						'name'  => $field_type_object->_name( '[width]' ),
						'id'    => $field_type_object->_id( '_width' ),
						'value' => (int) $value['width'],
						'data-slider-value' => (int) $value['width'],
						'type'  => 'text',
						'class' => 'small-text twoj_slider',
						'data-slider-min'=>0,
						'data-slider-max'=>50,
						'data-slider-step'=>1
					) ); 
			?>   px
	    </div>
	</div>

	<div class="form-group">
    	<label class="col-sm-2 control-label" for="<?php echo $field_type_object->_id( '_style' ); ?>'"><?php twoj_slideshow_et( 'Style', 'twoj_slideshow' ); ?></label>
	    <div class="col-sm-10">
	      <?php echo $field_type_object->select( array(
					'name'  => $field_type_object->_name( '[style]' ),
					'id'    => $field_type_object->_id( '_style' ),
					'class'   => 'cmb2_select',
					'options' => twoj_border_get_state_options( $value['style'] ),
					'desc'    => $field_type_object->_desc( true )
				) );
			?> 
	    </div>
  	</div>

  	<div class="form-group">
  		<label class="col-sm-2 control-label" for="<?php echo $field_type_object->_id( '_color' ); ?>'"><?php twoj_slideshow_et( 'Color', 'twoj_slideshow' ); ?></label>
	    <div class="col-sm-4">
	      <?php 
			echo  $field_type_object->input( array(
				'name'  			=> $field_type_object->_name( '[color]' ),
				'id'    			=> $field_type_object->_id( '_color' ),
				'class'             => 'form-control twoj_color',
				'data-default' 		=>  $value['color']  ,
				'data-alpha'        => 'true',
				'value' 			=> $value['color'] 
			)); 
		?> 
	    </div>
  	</div>

</div>
<?php
}
add_filter( 'cmb2_render_border', 'twoj_border_render_field_callback', 10, 5 );