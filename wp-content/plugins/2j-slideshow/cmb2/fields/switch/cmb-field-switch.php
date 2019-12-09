<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function jt_cmb2_switch_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_switch_field( $metakey, $post_id );
}

function jt_cmb2_render_switch_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {
	if( empty($value) ) $value = $field->args('default');
	$level = $field->args('level') ? 1 : 0 ;
?>
<div class="form-horizontal">
	<div class="form-group">
	    <label class="col-sm-2 control-label" for="<?php echo $field_type_object->_id(); ?>'"><?php echo $field->args('name'); ?></label>
	    <div class="col-sm-<?php echo $level?'8 twoj_disabled':'10'; ?>">
	<?php 
			 echo
				'<input type="checkbox" data-toggle="toggle" data-onstyle="info" '
				.($field->args('depends')?'class="twoj_action_element" ':'')
				.'name="'.$field_type_object->_name(  ).'" '
				.'id="'. $field_type_object->_id( ).'" '
				.($field->args('depends')?'data-depends="'.$field->args('depends').'" ':'')
				.( $value==1 ?'checked="checked" ':'')
				.'value="1">';
			?>
 		</div>
 		<?php if($level){ ?>
			<div class="col-sm-2 twoj-block-premium"><?php echo TWOJ_SLIDESHOW_LABEL_PRO; ?></div>
		<?php } ?>
	</div>
</div>
<?php
}
add_filter( 'cmb2_render_switch', 'jt_cmb2_render_switch_field_callback', 10, 5 );