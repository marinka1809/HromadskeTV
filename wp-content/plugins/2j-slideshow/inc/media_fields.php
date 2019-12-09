<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function twoj_hide_attachment_field() {
	echo "<style>"
	.".compat-attachment-fields tr.compat-field-twojs_gallery_line,"
	.".compat-attachment-fields tr.compat-field-twojs_gallery_link_options,"
	.".compat-attachment-fields tr.compat-field-twojs_gallery_type_link,"
	.".compat-attachment-fields tr.compat-field-twojs_style,"
	.".compat-attachment-fields tr.compat-field-twojs_opacity,"
	.".compat-attachment-fields tr.compat-field-twojs_padding,"
	.".compat-attachment-fields tr.compat-field-twojs_position,"
	.".compat-attachment-fields tr.compat-field-twojs_size,"
	.".compat-attachment-fields tr.compat-field-twojs_gallery_link{display:none; }</style>";
}
add_action('admin_head', 'twoj_hide_attachment_field');
 	
if( !function_exists('twojGetMediaOptions') ){
	function twojGetMediaOptions( $listSelect, $selectOption = ''){
		$optionsHtml = '';
		if(count($listSelect))
			foreach($listSelect as $key => $value) $optionsHtml .= '<option value="'.$key.'" '.selected($selectOption, $key, 0).'>'.$value.'</option>';
		return $optionsHtml;
	}
}

function twoj_slideshow_attachment_field_credit( $form_fields, $post ) {
	
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'gallery_line'] = array(
		'label' => '',
		'input' => 'html',
		'html' 	=> '<h4>'.__('2J SlideShow', '2j-slideshow').'</h4>'
	);
	
	
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'gallery_link'] = array(
		'label' => twoj_slideshow_t('Link\Video\JavaScript'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'gallery_link', true ),
	);

	$value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'gallery_link_options', true );
	$old_value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'gallery_type_link', true );
	$selectBox = 
	"<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."gallery_link_options]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."gallery_link_options]'>
		<option value='0' ".($value=='0' || !$value 		?'selected':'').">".__( 'Link', '2j-slideshow' )."</option>
		<option value='1' ".($value=='1' ||$old_value=='6'	?'selected':'').">".__( 'Link on new window', '2j-slideshow' )."</option>
		<option value='2' ".($value=='2'					?'selected':'').">".__( 'Javascript', '2j-slideshow' )."</option>
	</select>"; 

	$form_fields[TWOJ_SLIDESHOW_PREFIX.'gallery_link_options'] = array(
		'label' 	=> twoj_slideshow_t('Type Link', '2j-slideshow'),
		'input' 	=> 'html',
		'default' 	=> '0',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);

	$value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'gallery_type_link', true );
	$selectBox = 
		"<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."gallery_type_link]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."gallery_type_link]'>
			<option value='0' ".($value=='0' || !$value ?'selected':'').">".__( 'Image' , '2j-slideshow' )."</option>
			
			<option value='1' ".($value=='1'?'selected':'').">".__( 'Video' , '2j-slideshow' )."</option>
			<option value='2' ".($value=='2'?'selected':'').">".twoj_slideshow_t( 'Video + splash images' , '2j-slideshow' )."</option>
			
			<option value='3' ".($value=='3'?'selected':'').">".twoj_slideshow_t( 'Description text' , '2j-slideshow' )."</option>
			<option value='4' ".($value=='4'?'selected':'').">".twoj_slideshow_t( 'Image + Description text' , '2j-slideshow' )."</option>
		</select>";	


	$form_fields[TWOJ_SLIDESHOW_PREFIX.'gallery_type_link'] = array(
		'label' 	=> twoj_slideshow_t('Type Slide'),
		'input' 	=> 'html',
		'default' 	=> 'link',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);


	$value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'style', true );
	$listSelect = array(
		 'light' 	=> twoj_slideshow_t( 'light' , 			'2j-slideshow' ),
		 'dark'	 	=> twoj_slideshow_t( 'dark' , 			'2j-slideshow' ),
		 'purple' 	=> twoj_slideshow_t( 'purple' , 			'2j-slideshow' ),
		 'blue' 	=> twoj_slideshow_t( 'blue' , 			'2j-slideshow' ),
		 'darkblue'	=> twoj_slideshow_t( 'dark blue' ,		'2j-slideshow' ),
		 'red'		=> twoj_slideshow_t( 'red' , 				'2j-slideshow' ),
		 'yellow'	=> twoj_slideshow_t( 'yellow' , 			'2j-slideshow' ),
		 'green'	=> twoj_slideshow_t( 'green' , 			'2j-slideshow' ),
		 'orange'	=> twoj_slideshow_t( 'orange' , 			'2j-slideshow' ),
		 'violet'	=> twoj_slideshow_t( 'violet' , 			'2j-slideshow' ),
		 'pink'		=> twoj_slideshow_t( 'pink' , 			'2j-slideshow' ),
		 'brown'	=> twoj_slideshow_t( 'brown' , 			'2j-slideshow' ),
		 'coral'	=> twoj_slideshow_t( 'coral' , 			'2j-slideshow' ),
		 'redviolet'=> twoj_slideshow_t( 'redviolet' ,		'2j-slideshow' ),
		 'salmon'	=> twoj_slideshow_t( 'salmon' , 			'2j-slideshow' ),
		 'rosepink'	=> twoj_slideshow_t( 'rosepink' , 		'2j-slideshow' ),
		 'redorange'	=> twoj_slideshow_t( 'redorange' , 	'2j-slideshow'),
		 'carmine'	=> twoj_slideshow_t( 'carmine' , 			'2j-slideshow' ),
		 'maroon'	=> twoj_slideshow_t( 'maroon' , 			'2j-slideshow' ),
		 'fuchia'	=> twoj_slideshow_t( 'fuchia' , 			'2j-slideshow' ),
		 'seashell'	=> twoj_slideshow_t( 'seashell' , 		'2j-slideshow' ),
		 'yellowgreen'	=> twoj_slideshow_t( 'yellowgreen' , 	'2j-slideshow' ), 
	);

	$selectBox = "<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."style]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."style]'>";
	$selectBox .= twojGetMediaOptions( $listSelect, $value );
	$selectBox .= '</select>';
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'style'] = array(
		'label' 	=> twoj_slideshow_t('Style', '2j-slideshow' ),
		'input' 	=> 'html',
		'default' 	=> 'light',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);


	$value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'opacity', true );
	$listSelect = array(
		 '' 	=> twoj_slideshow_t( 'off', '2j-slideshow' ),
		 '10'	 	=> '10%',
		 '20'	 	=> '20%',
		 '30'	 	=> '30%',
		 '40'	 	=> '40%',
		 '50'	 	=> '50%',
		 '60'	 	=> '60%',
		 '70'	 	=> '70%',
		 '80'	 	=> '80%',
		 '90'	 	=> '90%',		 
	);

	$selectBox = "<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."opacity]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."opacity]'>";
	$selectBox .= twojGetMediaOptions( $listSelect, $value );
	$selectBox .= '</select>';
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'opacity'] = array(
		'label' 	=> twoj_slideshow_t('Opacity', '2j-slideshow'),
		'input' 	=> 'html',
		'default' 	=> '70%',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);
	
	/*  padding 10 20 30 40 50 60 70 80 90 1p 2p 3p 5p 7p 10p 20p */
	$value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'padding', true );
	$listSelect = array(
		'' 			=> twoj_slideshow_t( 'off', '2j-slideshow' ),
		'10'	 	=> '10',
		'20'	 	=> '20',
		'30'	 	=> '30',
		'40'	 	=> '40',
		'50'	 	=> '50',
		'60'	 	=> '60',
		'70'	 	=> '70',
		'80'	 	=> '80',
		'90'	 	=> '90',		 
		'1p'	 	=> '1%',		 
		'2p'	 	=> '2%',		 
		'3p'	 	=> '3%',		 
		'5p'	 	=> '5%',		 
		'7p'	 	=> '7%',		 
		'10p'	 	=> '10%',		 
		'20p'	 	=> '20%',		 
		
	);
	$selectBox = "<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."padding]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."padding]'>";
	$selectBox .= twojGetMediaOptions( $listSelect, $value );
	$selectBox .= '</select>';
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'padding'] = array(
		'label' 	=> twoj_slideshow_t('Padding', '2j-slideshow'),
		'input' 	=> 'html',
		'default' 	=> '20',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);

	 /* left bottom right top | 30 40 50 60 70 100  */
	 $value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'position', true );
	$listSelect = array(
		'left' 		=> twoj_slideshow_t( 'left' , '2j-slideshow' ),
		'bottom'	=> twoj_slideshow_t( 'bottom' , '2j-slideshow' ),
		'right'	 	=> twoj_slideshow_t( 'right' , '2j-slideshow' ),
		'top'	 	=> twoj_slideshow_t( 'top' , '2j-slideshow' ),
	);
	$selectBox = "<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."position]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."position]'>";
	$selectBox .= twojGetMediaOptions( $listSelect, $value );
	$selectBox .= '</select>';
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'position'] = array(
		'label' 	=> twoj_slideshow_t('Position', '2j-slideshow'),
		'input' 	=> 'html',
		'default' 	=> 'bottom',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);

	/* left bottom right top | 30 40 50 60 70 100  */
	 $value = get_post_meta( $post->ID, TWOJ_SLIDESHOW_PREFIX.'size', true );
	$listSelect = array(
		'5'	 	=> '5%',
		'10'	 	=> '10%',
		'15'	 	=> '15%',
		'20'	 	=> '20%',
		'30'	 	=> '30%',
		'40'	 	=> '40%',
		'50'	 	=> '50%',
		'60'	 	=> '60%',
		'70'	 	=> '70%',
		'100'	 	=> '100%',	
	);
	$selectBox = "<select name='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."size]' id='attachments[{$post->ID}][".TWOJ_SLIDESHOW_PREFIX."size]'>";
	$selectBox .= twojGetMediaOptions( $listSelect, $value );
	$selectBox .= '</select>';
	$form_fields[TWOJ_SLIDESHOW_PREFIX.'size'] = array(
		'label' 	=> twoj_slideshow_t('Size', '2j-slideshow'),
		'input' 	=> 'html',
		'default' 	=> '40',
		'value' 	=> $value,
		'html' 		=> $selectBox 
	);

	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'twoj_slideshow_attachment_field_credit', 10, 2 );

function twoj_slideshow_attachment_field_credit_save( $post, $attachment ) {
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_video_link'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'gallery_video_link', esc_url( $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_video_link'] ) );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_link'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'gallery_link',  $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_link'] );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_link_options'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'gallery_link_options', $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_link_options'] );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_type_link'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'gallery_type_link',  $attachment[TWOJ_SLIDESHOW_PREFIX.'gallery_type_link'] );
	

	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'style'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'style', $attachment[TWOJ_SLIDESHOW_PREFIX.'style'] );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'opacity'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'opacity', $attachment[TWOJ_SLIDESHOW_PREFIX.'opacity'] );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'padding'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'padding', $attachment[TWOJ_SLIDESHOW_PREFIX.'padding'] );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'position'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'position', $attachment[TWOJ_SLIDESHOW_PREFIX.'position'] );
	
	if( isset( $attachment[TWOJ_SLIDESHOW_PREFIX.'size'] ) )
		update_post_meta( $post['ID'], TWOJ_SLIDESHOW_PREFIX.'size', $attachment[TWOJ_SLIDESHOW_PREFIX.'size'] );
	
	
	return $post;
}
add_filter( 'attachment_fields_to_save', 'twoj_slideshow_attachment_field_credit_save', 10, 2 );