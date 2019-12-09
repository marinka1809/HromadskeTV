<form class="twoj_slideshow_setup twoj_slideshow_setup-deactivation-feedback no-confirmation-message">
	<div class="twoj_slideshow_setup-dialog">
		
		<div class="twoj_slideshow_setup-header">
			<h4><?php _e('Quick feedback','2j-slideshow'); ?></h4>
		</div>
		
		<div class="twoj_slideshow_setup-body">
			<div class="twoj_slideshow_setup-panel" data-panel-id="confirm"><p></p></div>
			
			<div class="twoj_slideshow_setup-panel active" data-panel-id="reasons">
				<h3><strong><?php _e('If you have a moment, please let us know why you are deactivating:','2j-slideshow'); ?></strong></h3>
				
				<ul id="reasons-list">
				
					<li class="reason has-input" data-input-type="textarea">
						<label>
							<span>
								<input name="check" value="1" type="radio">
							</span>
							<span><?php _e('The plugin suddenly stopped working','2j-slideshow'); ?></span>
						</label>
						<div class="internal-message"></div>
					</li>
					
					<li class="reason has-input" data-input-type="textfield">
						<label>
							<span>
								<input name="check" value="2" type="radio">
							</span>
							<span><?php _e('I found a better plugin','2j-slideshow'); ?></span>
						</label>
						<div class="internal-message"><input type="text" name="twoj_slideshow_setup-msg-better-plugin" placeholder="<?php _e('What\'s the plugin\'s name?','2j-slideshow'); ?>" /></div>
					</li>
					
					<li class="reason has-input" data-input-type="textarea">
						<label>
							<span>
								<input name="check" value="3" type="radio">
							</span>
							<span><?php _e('I only needed the plugin for a short period','2j-slideshow'); ?></span>
						</label>
						<div class="internal-message"></div>
					</li>
					
					<li class="reason has-input" data-input-type="textarea">
						<label>
							<span>
								<input name="check" value="4" type="radio">
							</span>
							<span><?php _e('The plugin broke my site','2j-slideshow'); ?></span>
						</label>
						<div class="internal-message"></div>
					</li>
					
					<li class="reason" data-input-type="">
						<label>
							<span>
								<input name="check" value="5" type="radio">
							</span>
							<span><?php _e('I no longer need the plugin','2j-slideshow'); ?></span>
						</label>
						<div class="internal-message"></div>
					</li>
					
					<li class="reason has-input" data-input-type="textarea">
						<label>
							<span>
								<input name="check" value="6" type="radio">
							</span>
							<span><?php _e('It\'s a temporary deactivation. I\'am just debugging an issue.','2j-slideshow'); ?></span>
						</label>
						<div class="internal-message"></div>
					</li>

					<li class="reason has-input" data-input-type="textfield">
						<label>
							<span>
								<input name="check" value="7" type="radio">
							</span>
							<span><?php _e('Other'); ?></span>
						</label>
						<div class="internal-message"><input type="text" name="twoj_slideshow_setup-msg-other" /></div>
					</li>
				
				</ul>
				
			</div>
		</div>
		
		<div class="twoj_slideshow_setup-footer">
			<button type="button" class="button button-secondary button-deactivate allow-deactivate"><?php _e('Skip & Deactivate'); ?></button>
			<button type="button" class="button button-primary button-close"><?php _e('Cancel'); ?></button>
		</div>
		
	</div>
</form>