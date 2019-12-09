<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function jt_cmb2_multisize_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_multisize_field( $metakey, $post_id );
}

function jt_cmb2_render_multisize_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {
	//print_r($value);
	// make sure we specify each part of the value we need.
	$level = $field->args('level')?1:0;

	$default = $field->args('default');
	if(!is_array($default))  $default = array();

	if(!isset($default['width'])) 		$default['width'] 		= '100';
	if(!isset($default['widthType']))	$default['widthType'] 	= '1';
	if(!isset($default['height'])) 		$default['height']		= '300';
	if(!isset($default['heightType']))	$default['heightType'] 	= '0';
	
	$value = wp_parse_args( $value, array( 
		 'width' 		=> $default['width'], 
		 'widthType' 	=> $default['widthType'],
		 
		 'height' 		=> $default['height'], 
		 'heightType' 	=> $default['heightType'],
	));

	?>

<div class="form-horizontal">
	<div class="form-group">
	    <label class="col-xs-4 col-sm-2 control-label" for="<?php echo $field_type_object->_id(); ?>"><?php echo esc_html(  $field->args('name') ); ?></label>

	    <div class="col-xs-4 col-sm-3<?php echo ($level?' twoj_disabled':'') ?>"> 
	    	<div class="input-group">
      			<div class="input-group-addon"><?php twoj_slideshow_et('Width', 'twoj_slideshow'); ?></div>
			    <?php 
			    echo $field_type_object->input( array(
					'name'  		=> $field_type_object->_name('[width]' ),
					'id'    		=> $field_type_object->_id('[width]' ),
					'value' 		=> $value['width'],
					'class' 		=> 'form-control '.$field->args('class') ,
				)); 
			   ?>
			</div>
		</div>
		<div class="col-xs-4 col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
		<?php
				echo 
					'<input type="checkbox" data-toggle="toggle"  data-on="%" data-off="px" data-onstyle="success" data-offstyle="info" ' 
					.'name="'.$field_type_object->_name( '[widthType]' ).'" '
					.'id="'. $field_type_object->_id( 'widthType' ).'" '
					.( $value['widthType']==1 ?' checked ':'')
					.'value="1" '
					.'>';
			?> 
		</div>

		 <div class="col-xs-4  col-sm-3 col-xs-offset-4 col-sm-offset-0 <?php echo ($level?' twoj_disabled':'') ?>"> 
	    	<div class="input-group">
      			<div class="input-group-addon"><?php twoj_slideshow_et('Height', 'twoj_slideshow'); ?></div>
			    <?php 
			    echo $field_type_object->input( array(
					'name'  		=> $field_type_object->_name('[height]' ),
					'id'    		=> $field_type_object->_id('[height]' ),
					'value' 		=> $value['height'],
					'class' 		=> 'form-control '.$field->args('class') ,
				)); 
			   ?>
			</div>
		</div>
		<div class="col-xs-4  col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
		<?php
			echo 
				'<input type="checkbox" data-toggle="toggle"  data-on="%" data-off="px" data-onstyle="success" data-offstyle="info" ' 
				.'name="'.$field_type_object->_name( '[heightType]' ).'" '
				.'id="'. $field_type_object->_id( 'heightType' ).'" '
				.( $value['heightType']==1?' checked ':'')
				.'value="1" '
				.'>';
			?> 
		</div>

	    <?php if($level){ ?>
		    <div class="col-sm-<?php echo $field->args('small')?'6':'2'; ?> twoj-block-premium">
		    	<?php echo TWOJ_SLIDESHOW_LABEL_PRO; ?>
		    </div>
		<?php } ?>
	</div>
</div>
	<?php
	echo $field_type_object->_desc( true );

}
add_filter( 'cmb2_render_multisize', 'jt_cmb2_render_multisize_field_callback', 10, 5 );
