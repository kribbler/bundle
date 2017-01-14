<?php global $smof_data; ?>
						
<?php /* Only display widget area if widgets are placed in it */ 
if ( is_active_sidebar('footer-widget-area') ) { ?>
	
	<?php if ( is_page_template('page-templates/template-homepage-2.php') ) { ?>
		<div id="footer" class="footer-full">
	<?php } else { ?>
		<div id="footer">
	<?php } ?>
							
	<!-- BEGIN .content-wrapper -->
	<div class="content-wrapper clearfix">
							
<?php } else { ?>
						
	<?php if ( is_page_template('page-templates/template-homepage-2.php') ) { ?>
		<div id="footer" class="footer-full footer-no-widgets">
	<?php } else { ?>
		<div id="footer" class="footer-no-widgets">
	<?php } ?>
							
	<!-- BEGIN .content-wrapper -->
	<div class="content-wrapper clearfix">
							
<?php } ?>
					
<?php if ( is_active_sidebar('footer-widget-area') ) { ?>	
	<?php dynamic_sidebar( 'footer-widget-area' ); ?>
<?php } ?>
					
<div class="clearboth"></div>
					
<!-- BEGIN #footer-bottom -->
<div id="footer-bottom" class="clearfix">
				
	<?php if( $smof_data['footer_msg'] ) { ?>
		<p class="fl"><?php echo $smof_data['footer_msg']; ?></p>
	<?php } ?>

	<!-- Footer Navigation -->
	<?php wp_nav_menu( array(
		'theme_location' => 'footer',
		'container' =>false,
		'items_wrap' => '<ul class="fr">%3$s</ul>',
		'fallback_cb' => false,
		'echo' => true,
		'before' => '',
		'after' => '<span>/</span>',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0 )
	); ?>
				
<!-- END #footer-bottom --><div style="float: right; font-size: 11px;">Site developed by <a href="http://www.studioeleven.co.nz" target="_blank"><img src="http://www.tukitukicottages.co.nz/wp-content/uploads/2014/02/signature.png" style="margin-bottom:-1px; margin-left: 5px;"></a></div>
</div>
			
<!-- END #footer -->
</div>

<?php echo custom_css(); ?>
<?php wp_footer(); ?>

<!-- END body -->
</body>
</html>