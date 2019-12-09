<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function twojselectbutton_getOptions( $options, $name, $value = false ) {
	if( !isset($options) || !count($options) )  return '';
    $state_options = '';
    foreach ( $options as $abrev => $state ) {
        $state_options .= 
        '<label class="btn btn-info '.($value==$abrev?'active':'').'">'
	 		.'<input type="radio" autocomplete="off" name="'.$name.'" '
		 			.($abrev==$value?' checked ':'').' '
		 			.' value="'.$abrev.'"'
	 			.'> '.$state
		.'</label>';
    }
    return $state_options;
}

function jt_cmb2_twojselectbutton_field( $metakey, $post_id = 0 ) {
	echo jt_cmb2_get_twojselectbutton_field( $metakey, $post_id );
}

function jt_cmb2_render_twojselectbutton_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	$level = $field->args('level')?1:0;

	$value =  $value?$value:$field->args('default');
	
?>
<div class="form-horizontal">

	<div class="<?php echo $field_type_object->_id( 'optionsBlok' );?>">
		<div class="form-group">
		    <label class="col-sm-2 control-label" for="<?php echo $field_type_object->_id( ); ?>'"><?php echo esc_html($field->args('name') ); ?></label>
		    <div class="col-sm-<?php echo $level?'8 twoj_disabled':'10'; ?>">

		    	<div class="btn-group " data-toggle="buttons"> <!-- twoj_checkbox -->
				<?php
					echo twojselectbutton_getOptions( $field->args('options'),  $field_type_object->_name(),  $value );
				 ?>
				</div>
		    </div>

			 <?php if($level){ ?>
			    <div class="col-sm-<?php echo $field->args('small')?'6':'2'; ?> twoj-block-premium">
			    	<?php echo TWOJ_SLIDESHOW_LABEL_PRO; ?>
			    </div>
			<?php } ?>

		</div>
		

	 </div>
</div>
<?php
}
add_filter( 'cmb2_render_twojselectbutton', 'jt_cmb2_render_twojselectbutton_field_callback', 10, 5 );