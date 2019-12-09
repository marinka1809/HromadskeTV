<?php 
	/**
	* Plugin Main Class
	*/
	class LA_Words_Rotator
	{
		
		function __construct()
		{
			add_action( "admin_menu", array($this,'post_viewer_admin_options'));
			add_action( 'admin_enqueue_scripts', array($this,'admin_enqueuing_scripts'));
			add_action('wp_ajax_la_save_words_rotator', array($this, 'save_admin_options'));
			add_shortcode( 'animated-words-rotator', array($this, 'render_words_rotator') );
		}
	

		function post_viewer_admin_options(){
			add_menu_page( 'CSS3 Rotating Words', 'CSS3 Rotating Words', 'manage_options', 'word_rotator', array($this,'post_previewer_menu_page'), 'dashicons-format-image', $position );
		}

		function admin_enqueuing_scripts($slug){
		if ($slug == 'toplevel_page_word_rotator') {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'post-viewer-admin-js', plugins_url( 'admin/admin.js' , __FILE__ ), array('jquery', 'jquery-ui-accordion', 'wp-color-picker') );
			wp_enqueue_style( 'post-viewer-admin-css', plugins_url( 'admin/style.css' , __FILE__ ));
			wp_localize_script( 'post-viewer-admin-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php' ),'path' => plugin_dir_url( __FILE__ )));
			}
		}
		function post_previewer_menu_page(){
			$savedmeta = get_option('la_words_rotator');
			?>
			<div class="wrap" id="compactviewer">
				<h1>CSS3 Rotating Words</h1>
				<hr>
				<div id="accordion">
				<?php if (isset($savedmeta['rotwords'])) {?>
					<?php foreach ($savedmeta['rotwords'] as $key => $data) {?>

					<h3 class="tab-head">CSS3 Rotating Words</h3>
					<div class="tab-content">
						<h2>General Settings</h2>
						<table class="form-table">
							<hr>

							<tr>
								<td>
									<strong><?php _e( 'Give Start Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="static-sen widefat"><?php echo $data['stat_sent']; ?></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a ending sentence.Leave empty if have no starting words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>



			  				<tr>
			  					<td> <strong> <?php _e( 'Add Words(these will be rotating)', 'la-wordsrotator' ); ?> </strong></td>
			  					<td>
			  						<textarea cols="10" rows="5" class="rotating-words widefat"><?php echo $data['rot_words']; ?></textarea> 
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Comma separated list of rotating words(maximum 6)', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
							<tr>
								<td>
									<strong><?php _e( 'Give Ending Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="end-sen widefat"><?php echo $data['end_sent']; ?></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a ending sentence.Leave empty if have no ending words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>
							<tr>
								<td>
									<strong><?php _e( 'Sentence and Words Font Size', 'la-wordsrotator' ); ?></strong>
								</td>
								<td class="get-terms">
									<input type="number" class="font widefat" value="<?php echo $data['font_size']; ?>"> 		
								</td>

								<td>
									<p class="description"><?php _e( 'Set font size for words and sentence.Default 45px' ); ?>.</p>
								</td>
							</tr>

							<tr>
			  					<td> 
			  						<strong ><?php _e( 'Sentence Color', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="my-colorpicker" value="<?php echo $data['font_color']; ?>">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for the sentence.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td> 
			  						<strong ><?php _e( 'Rotating Words Color', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="wordscolor" value="<?php echo $data['words_color']; ?>">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for rotating words.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
			  					<td>
			  						<strong ><?php _e( 'Animation Effect', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td>
			  						<select class="animate widefat">
			  							<option value="fade" <?php if ( $data['animation_effect'] == 'fade' ) echo 'selected="selected"'; ?>>Fade</option>
			  							<option value="flip" <?php if ( $data['animation_effect'] == 'flip' ) echo 'selected="selected"'; ?>>Flip</option>
			  							<option value="flipCube" <?php if ( $data['animation_effect'] == 'flipCube' ) echo 'selected="selected"'; ?>>Flip Cube</option>
			  							<option value="flipUp" <?php if ( $data['animation_effect'] == 'flipUp' ) echo 'selected="selected"'; ?>>Flip Up</option>
			  							<option value="spin" <?php if ( $data['animation_effect'] == 'flipUp' ) echo 'selected="selected"'; ?>>Spin</option>
			  						</select>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select Animation effect for words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
			  					<td>
			  						<strong ><?php _e( 'Animation Speed', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td>
			  						<input type="number" class="animate-speed" value="<?php echo $data['animation_speed']; ?>">
			  					</td>	
			  					<td>
			  						<p class="description"><?php _e( 'Select Animation Speed for words.Default 1250', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>	

						</table>

						<div class="clearfix"></div>
						<hr style="margin-bottom: 10px;">
						<button class="button btnadd"><span title="Add New" class="dashicons dashicons-plus-alt"></span><?php _e( 'Add New', 'la-wordsrotator' ); ?></button>&nbsp;
						<button class="button btndelete"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Delete', 'la-wordsrotator' ); ?></button>
						<button class="button-primary fullshortcode pull-right" id="<?php echo $data['counter']; ?>"><?php _e( 'Get Shortcode', 'la-wordsrotator' ); ?></button>
						
					</div>
						<?php } ?>
					<?php } else { ?>
						<h3 class="tab-head">CSS3 Rotating Words</h3>
					<div class="tab-content">
						<h2>General Settings</h2>
						<table class="form-table">
							<hr>

							<tr>
								<td>
									<strong><?php _e( 'Give Start Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="static-sen widefat"></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a ending sentence.Leave empty if have no starting words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>



			  				<tr>
			  					<td> <strong> <?php _e( 'Add Words(these will be rotating)', 'la-wordsrotator' ); ?> </strong></td>
			  					<td>
			  						<textarea cols="10" rows="5" class="rotating-words widefat"></textarea> 
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Comma separated list of rotating words(maximum 6)', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
								<td>
									<strong><?php _e( 'Give Ending Sentence', 'la-wordsrotator' ); ?></strong> 
								</td>
								<td class="get-terms">
									
									<textarea cols="10" rows="5" class="end-sen widefat"></textarea>		
								</td>

								<td>
									<p class="description"><?php _e( 'Write a ending sentence.Leave empty if have no ending words', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
								<td>
									<strong><?php _e( 'Sentence and Words Font Size', 'la-wordsrotator' ); ?></strong>
								</td>
								<td class="get-terms">
									<input type="number" class="font widefat" value=""> 		
								</td>

								<td>
									<p class="description"><?php _e( 'Set font size for words and sentence.Default 45px', 'la-wordsrotator' ); ?>.</p>
								</td>
							</tr>

							<tr>
			  					<td>
			  						<strong ><?php _e( 'Sentence Color', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="my-colorpicker" value="#000">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for the sentence.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td> 
			  						<strong ><?php _e( 'Rotating Words Color', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td class="insert-picker">
			  						<input type="text" class="wordscolor" value="#000">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Choose color for the rotating words.Default #000', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>

			  				<tr>
			  					<td>
			  						<strong ><?php _e( 'Animation Effect', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td>
			  						<select class="animate widefat">
			  							<option value="fade">Fade</option>
			  							<option value="flip">Fade in and “fall”</option>
			  							<option value="flipCube">Sliding</option>
			  							<option value="flipUp">Flip</option>
			  						</select>
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select Animation effect for words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>
			  				<tr>
			  					<td>
			  						<strong ><?php _e( 'Animation Speed', 'la-wordsrotator' ); ?></strong>
			  					</td>
			  					<td>
			  						<input type="number" class="animate-speed">
			  					</td>
			  					<td>
			  						<p class="description"><?php _e( 'Select Animation effect for words', 'la-wordsrotator' ); ?>.</p>
			  					</td>
			  				</tr>	

						</table>

						<div class="clearfix"></div>
						<hr style="margin-bottom: 10px;">
						<button class="button btnadd"><span title="Add New" class="dashicons dashicons-plus-alt"></span><?php _e( 'Add New', 'la-wordsrotator' ); ?></button>&nbsp;
						<button class="button btndelete"><span class="dashicons dashicons-dismiss" title="Delete"></span><?php _e( 'Delete', 'la-wordsrotator' ); ?></button>
						<button class="button-primary fullshortcode pull-right" id="1"><?php _e( 'Get Shortcode', 'la-wordsrotator' ); ?></button>
						
					</div>
					<?php } ?>
				</div>
				<hr style="margin-top: 20px;">
						<button class="button-primary save-meta" ><?php _e( 'Save Settings', 'la-wordsrotator' ); ?></button>
						<span id="la-loader"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/7.gif"></span>
						<span id="la-saved"><strong><?php _e( 'Changes Saved', 'la-wordsrotator' ); ?>!</strong></span>
				</div>
				
	<?php	
	}

	function save_admin_options(){
		if (isset($_REQUEST)) {
			// print_r($_REQUEST);
			update_option( 'la_words_rotator', $_REQUEST );
			
		}
	}
 
	function render_words_rotator($atts, $content, $the_shortcode){
		$savedmeta = get_option( 'la_words_rotator' );
		if (isset($savedmeta['rotwords'])) {
			foreach ($savedmeta['rotwords'] as $key => $data) {
				if ($atts['id']== $data['counter']) {
					wp_enqueue_script( 'modernize-js', plugins_url( 'js/jquery.simple-text-rotator.min.js', __FILE__ ),array('jquery'));
					wp_enqueue_script( 'script-js', plugins_url( 'js/script.js', __FILE__ ),array('jquery'));
					wp_enqueue_style( 'modernize-cs', plugins_url( 'js/simpletextrotator.css', __FILE__ ));
					wp_localize_script( 'script-js', 'words', array(
										'animation' => $data["animation_effect"],
										'speed' => $data['animation_speed'],
										
									));


					$rotate_words = $data['rot_words'];
					$rotate_words_arr = explode(",",$rotate_words);
					// print_r($rotate_words_arr);
					// 
					            $postContents.='<h1 class="demo" style="font-size:'.$data['font_size'].'px;color:'.$data['font_color'].';">';  
					            $postContents.=$data["stat_sent"] ;  
					            $postContents.=' <span class="rotate" style="font-size:'.$data['font_size'].'px;color:'.$data['words_color'].';">';  
					              
						           foreach ($rotate_words_arr as $key => $word) {
						             	$postContents.=$word.',';  
						             }  
					            $postContents.='</span>' .$data['end_sent'].'</h1>'; 
					return $postContents;

				}	
			}
		}
	}
}
 ?>