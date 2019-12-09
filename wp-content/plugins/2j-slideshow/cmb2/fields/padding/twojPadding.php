<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function twoj_padding_field( $metakey, $post_id = 0 ) {
	echo get_twoj_padding_field( $metakey, $post_id );
}

function twoj_padding_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {
	
	$level = $field->args('level')?1:0;
	$default = $field->args('default');
	if(!is_array($default))  $default = array();

	if(!isset($default['left'])) 		$default['left'] 	= 0;
	if(!isset($default['top'])) 		$default['top']		= 0;
	if(!isset($default['right'])) 		$default['right']	= 0;
	if(!isset($default['bottom'])) 		$default['bottom']	= 0;
	//if(!isset($default['enable'])) 		$default['enable']	= 0;
	
	
	$value = wp_parse_args( $value, array( 
		 'left' 	=> $default['left'], 
		 'top' 		=> $default['top'],
		 'right' 	=> $default['right'],
		 'bottom' 	=> $default['bottom'],
		 //'enable' 	=> $default['enable'],
	));

?>
<div class="form-horizontal">
	<div class="form-group">
	    <label class="col-xs-4 col-sm-2 control-label" for="<?php echo $field_type_object->_id(); ?>"><?php echo esc_html(  $field->args('name') ); ?></label>
		
	<!--	<div class="col-xs-4 col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
		<?php
				echo 
					'<input type="checkbox" data-toggle="toggle"  data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="info" ' 
					.'name="'.$field_type_object->_name( '[enable]' ).'" '
					.'id="'. $field_type_object->_id( 'enable' ).'" '
					.( $value['enable']==1 ?' checked ':'')
					.'value="1" '
					.'>';
			?> 
		</div>
	-->

	    <div class="col-xs-4 col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
	    	<div class="input-group">
      			<div class="input-group-addon"><?php twoj_slideshow_et('Left', 'twoj_slideshow'); ?></div>
			    <?php 
			    echo $field_type_object->input( array(
					'name'  		=> $field_type_object->_name('[left]' ),
					'id'    		=> $field_type_object->_id('[left]' ),
					'value' 		=> $value['left'],
					'class' 		=> 'form-control '.$field->args('class') ,
				)); 
			   ?>
			</div>
		</div>

		<div class="col-xs-4 col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
	    	<div class="input-group">
      			<div class="input-group-addon"><?php twoj_slideshow_et('Top', 'twoj_slideshow'); ?></div>
			    <?php 
			    echo $field_type_object->input( array(
					'name'  		=> $field_type_object->_name('[top]' ),
					'id'    		=> $field_type_object->_id('[top]' ),
					'value' 		=> $value['top'],
					'class' 		=> 'form-control '.$field->args('class') ,
				)); 
			   ?>
			</div>
		</div>

		<div class="col-xs-4 col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
	    	<div class="input-group">
      			<div class="input-group-addon"><?php twoj_slideshow_et('Right', 'twoj_slideshow'); ?></div>
			    <?php 
			    echo $field_type_object->input( array(
					'name'  		=> $field_type_object->_name('[right]' ),
					'id'    		=> $field_type_object->_id('[right]' ),
					'value' 		=> $value['right'],
					'class' 		=> 'form-control '.$field->args('class') ,
				)); 
			   ?>
			</div>
		</div>

		<div class="col-xs-4 col-sm-2<?php echo ($level?' twoj_disabled':'') ?>"> 
	    	<div class="input-group">
      			<div class="input-group-addon"><?php twoj_slideshow_et('Bottom', 'twoj_slideshow'); ?></div>
			    <?php 
			    echo $field_type_object->input( array(
					'name'  		=> $field_type_object->_name('[bottom]' ),
					'id'    		=> $field_type_object->_id('[bottom]' ),
					'value' 		=> $value['bottom'],
					'class' 		=> 'form-control '.$field->args('class') ,
				)); 
			   ?>
			</div>
		</div>


	    <?php if($level){ ?>
		    <div class="col-sm-2 twoj-block-premium">
		    	<?php echo TWOJ_SLIDESHOW_LABEL_PRO; ?>
		    </div>
		<?php } ?>
	</div>
</div>
	<?php
	echo $field_type_object->_desc( true );

}
add_filter( 'cmb2_render_padding', 'twoj_padding_field_callback', 10, 5 );
