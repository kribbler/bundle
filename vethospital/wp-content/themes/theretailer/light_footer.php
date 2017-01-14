<?php
global $theretailer_theme_options;
?>

<?php if ( (!$theretailer_theme_options['light_footer_all_site']) || ($theretailer_theme_options['light_footer_all_site'] == 0) ) { ?>

	<?php if ( is_active_sidebar( 'widgets_light_footer' ) ) : ?>
        
        <div class="gbtr_light_footer_wrapper">        
            <div class="container_12">
                <?php dynamic_sidebar('widgets_light_footer'); ?>
            </div>             
        </div>
    
    <?php else : ?>
    
        <div class="gbtr_light_footer_no_widgets">
            <div class="container_12">
                <div class="grid_12">
                    <h3><strong>Light Footer</strong> - Widgetized Area. <a href="<?php echo site_url(); ?>/wp-admin/widgets.php"><strong>Start Adding Widgets</strong></a>.</h3>
                </div>
                <div class="grid_3"><div class="widget_placeholder"></div></div>        
                <div class="grid_3"><div class="widget_placeholder"></div></div>        
                <div class="grid_3"><div class="widget_placeholder"></div></div>        
                <div class="grid_3"><div class="widget_placeholder"></div></div>
            </div>
        </div>
    
    <?php endif; ?>

<?php } ?>