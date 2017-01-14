<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package theretailer
 * @since theretailer 1.0
 */

get_header(); ?>

<div class="container_12">

    <div class="grid_12">
    	
        <div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

                <div class="entry-content page_404">
                
                    <div class="img_404"></div>
                    
                    	<h3><?php _e( 'The page you are looking for does not exist. <br />Return to the', 'theretailer' ); ?> <a href="<?php echo home_url(); ?>"><?php _e( 'home page', 'theretailer' ); ?></a>.</h3>
                    
                    </div>
        
        	</div>
		</div>			
    
    </div>
    
</div>

<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>