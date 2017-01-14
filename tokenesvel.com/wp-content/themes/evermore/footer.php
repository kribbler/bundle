<?php 
/**
 * Footer template - this file content is displayed on every page after the main content.
 */
?>
</div>
<div id="footer" class="center">
	<?php if(pexeto_option('show_ca')){ 
		//PRINT THE CALL TO ACTION SECTION
		?>
	<div id="footer-cta">
		<div class="footer-cta-first"><h5><?php echo pexeto_text('ca_title'); ?></h5></div>
		<div class="footer-cta-disc"><p><?php echo pexeto_text('ca_desc'); ?></p></div>
		<?php 
		if(pexeto_option('ca_btn_link') || pexeto_option('ca_btn_text')){ ?>
		<div class="footer-cta-button">
			<a href="<?php echo pexeto_option('ca_btn_link'); ?>" class="button"><?php echo pexeto_text('ca_btn_text'); ?></a>
		</div>
		<?php  } ?>
		<div class="clear"></div>
	</div>
	<?php } 

//PRINT THE FOOTER COLUMNS
$footer_layout = pexeto_option("footer_layout");
$sidebar_numbers = array("one", "two", "three", "four");
$column_num = intval($footer_layout);
if($footer_layout!="no-footer"){ ?>
	<div class="cols-wrapper footer-widgets cols-<?php echo $column_num; ?>">
	<?php
	if($column_num>0){
		for($i=1; $i<=$column_num; $i++){
			$number = $sidebar_numbers[$i-1]; 
			$add_class = $i==$column_num ? ' nomargin':'';
			?><div class="col<?php echo $add_class; ?>"><?php
			dynamic_sidebar("footer-".$number);
			?></div><?php
		}
	}
	?>
	</div>
	<?php
}
?>
<div class="footer-bottom">
<span class="copyrights"><?php echo pexeto_text('copyright_text'); ?></span>
<div class="footer-nav">
<?php wp_nav_menu(array('theme_location' => 'pexeto_footer_menu', 'fallback_cb'=>'pexeto_no_footer_menu')); ?>
</div>

<?php locate_template( array( 'includes/social-icons.php' ), true, false ); ?>

</div>
</div> <!-- end #footer-->
</div> <!-- end #main-container -->


<!-- FOOTER ENDS -->

<?php 
echo(pexeto_option('analytics')); 
wp_footer(); 
?>
</body>
</html>