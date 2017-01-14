<div class="footer-widget-wrap">
	<section class="footer-widget container">
		<div class="row">
			<div class="span6 widget-news">
				<?php if( ! dynamic_sidebar('footer-1_2') ): ?>
				<?php endif; ?>
			</div>
			<div class="span3 widget-tweets">
				<?php if( ! dynamic_sidebar('footer-3') ): ?>
				<?php endif; ?>
			</div>
			<div class="span3 widget-flickr">
				<?php if( ! dynamic_sidebar('footer-4') ): ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</div>