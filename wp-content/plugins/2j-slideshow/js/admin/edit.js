/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

jQuery(function(){

	var twoj_init = 1;
	jQuery(document).on('change', '.twoj_action_element',  function(){
		var el = jQuery(this);
		var depends = el.data('depends');
		if(depends){
			if(el.is(':checked')){
				jQuery(depends).show(twoj_init?0:'fast');
			} else {
				jQuery(depends).hide(twoj_init?0:'fast');	
			} 
		}
	});

	jQuery(document).on('change', '.twoj_action_element_select',  function(){
		var el = jQuery(this);
		if(el.data('depends')){
			var param 	= window[el.attr('id')+"_depends"];
			jQuery.each(param, function(index, valItem) {
				jQuery(valItem).hide(twoj_init?0:'fast');
			});
			jQuery(param[el.val()]).show(twoj_init?0:'fast');
		}
	});

	jQuery('.twoj_checkbox label.btn').on('change',  function(){
		var el = jQuery(this);
		el.parent().find('label.btn').removeClass('btn-info').addClass('btn-default');
		el.removeClass('btn-default').addClass('btn-info');
	});

	jQuery('.twoj_action_element').change();
	jQuery('.twoj_action_element_select').change();


	if(!TWOJ_SLIDESHOW_PRO){
		jQuery("#twojs_hover").change( function () {
			var el = jQuery(this);
			if(el.val()==2){
				window['twojSlideshowDialog'].dialog("open");
				el.selectpicker('val', 1);
			} 
		});
	}
	var twoj_init= 0;

  	//jQuery(".twoj_slider").bootstrapSlider({ });

	jQuery(".twoj_font_slider").on("slide slideStop", function(slideEvt) {
		var divObj = jQuery(this).data('font-demoid');
		jQuery('#'+divObj).css('font-size', slideEvt.value+'px');
	});

	var twojBlockId = { 
		"block1": jQuery('#twojs_lightbox_metabox'), 
		"block2":jQuery('#twojs_size_metabox'), 
		"block3":jQuery('#twojs_view_metabox'), 
		"block4":jQuery('#twojs_hover_metabox'), 
		"block5":jQuery('#twojs_button_metabox'),
		"block6":jQuery('#twojs_loading_metabox'),
		"block7":jQuery('#twojs_polaroid_metabox'),
	},
	twojAllBlockClass = function (type){
		jQuery.each( twojBlockId, function(index, el) {
			if(type!=0){
				el.find('.inside').addClass('twoj_disabled_block');
				if( el.find('.hndle.ui-sortable-handle > .twoj_info_clone_text').length==0  ){
					el.find('.hndle.ui-sortable-handle > span').after('<span class="twoj_info_clone_text"> <span class="dashicons dashicons-info"></span> ['+twoj_slideshow_trans.twoj_info_clone_text+']</span>');
				}
			} else {
				el.find('.inside').removeClass('twoj_disabled_block');	
				el.find('.hndle.ui-sortable-handle > .twoj_info_clone_text').remove();
			} 
		});
	};

	jQuery('#twojs_options').on("change", function(){
		//alert(twoj_slideshow_trans.twoj_info_clone_text)
		twojAllBlockClass( jQuery(this).val() );
	}).change();

	//jQuery('.twoj_hover_bg_color').val();
});