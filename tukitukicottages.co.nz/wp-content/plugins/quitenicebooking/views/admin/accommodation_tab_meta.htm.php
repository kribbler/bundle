<div id="quitenicebooking_tabs" class="clearfix">
	<ul class="qns-tabs">
		<?php for ($n = 1; $n <= 5; $n ++) { ?>
			<li><a href="#quitenicebooking_tab_<?php echo $n; ?>"><?php printf(__('Tab %d', 'quitenicebooking'), $n); ?></a></li>
		<?php } ?>
	</ul>
	
	<?php for ($n = 1; $n <= 5; $n ++) { ?>
		<div class="tab-panel" id="quitenicebooking_tab_<?php echo $n; ?>">
			
			<div class="clearfix">
				<div class="one-sixth">
					<label for="quitenicebooking_tab_<?php echo $n; ?>_title"><?php _e('Title', 'quitenicebooking'); ?></label>
				</div>
			
				<div class="five-sixths last">
					<input type="text" class="full-width" name="quitenicebooking_tab_<?php echo $n; ?>_title" id="quitenicebooking_tab_<?php echo $n; ?>_title" value="<?php echo isset(${'quitenicebooking_tab_'.$n.'_title'}) ? ${'quitenicebooking_tab_'.$n.'_title'} : ''; ?>">
				</div>
				
			</div>
			
			<hr class="space2" />
			
			<div class="clearfix">
				<div class="one-sixth">
					
					<label for="quitenicebooking_tab_<?php echo $n; ?>_content"><?php _e('Content', 'quitenicebooking'); ?></label>
					
				</div>
				
				<div class="five-sixths last">
					<textarea class="full-width" name="quitenicebooking_tab_<?php echo $n; ?>_content" id="quitenicebooking_tab_<?php echo $n; ?>_content" rows="10"><?php echo isset(${'quitenicebooking_tab_'.$n.'_content'}) ? ${'quitenicebooking_tab_'.$n.'_content'} : ''; ?></textarea>
				</div>
			
			</div>
			
		</div><!-- END .section -->
	<?php } ?>
</div>
