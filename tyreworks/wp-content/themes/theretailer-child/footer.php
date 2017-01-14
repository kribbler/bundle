<?php
global $theretailer_theme_options;
?>

	<div class="gbtr_footer_wrapper">
        
        <div class="container_12">
            <div class="grid_12 bottom_wrapper">
                <div class="gbtr_footer_widget_copyrights"><?php echo $theretailer_theme_options['copyright_text']; ?></div>
                <div class="gbtr_footer_widget_credit_cards">
                	<?php dynamic_sidebar('footer_links');?>
                </div>
                
                <div class="clr"></div>
            </div>
        </div>
        
    </div>
    
    </div><!-- /global_wrapper -->

    <!-- ******************************************************************** -->
    <!-- *********************** Custom Javascript ************************** -->
    <!-- ******************************************************************** -->
    
    <?php echo $theretailer_theme_options['custom_js_footer']; ?>
    
    <!-- ******************************************************************** -->
    <!-- ************************ WP Footer() ******************************* -->
    <!-- ******************************************************************** -->
	
<?php wp_footer(); ?>
</body>
</html>