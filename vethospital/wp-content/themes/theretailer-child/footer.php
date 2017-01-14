<?php
global $theretailer_theme_options;
?>

<div class="gbtr_dark_footer_no_widgets">
	
	<div class="container_12 footer_down">
		<div class="grid_6">
			<?php dynamic_sidebar('bellow_footer_left');?>
		</div>
		<div class="grid_6 right_me">
			<?php dynamic_sidebar('bellow_footer_right');?>
		</div>
	</div>
</div>

	<div class="gbtr_footer_wrapper">
        
        <div class="container_12">
            <div class="grid_12 bottom_wrapper">
                <div class="gbtr_footer_widget_credit_cards">
                <img src="<?php if ( !$theretailer_theme_options['footer_logos'] ) { ?><?php echo get_template_directory_uri(); ?>/images/payment_cards.png
                <?php } else echo $theretailer_theme_options['footer_logos']; ?>" alt="" />
                </div>
                <div class="gbtr_footer_widget_copyrights"><?php echo $theretailer_theme_options['copyright_text']; ?></div>
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