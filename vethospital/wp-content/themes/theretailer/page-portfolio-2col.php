<?php
/*
Template Name: Portfolio 2 columns
*/
?>

<?php get_header(); ?>

<div class="container_12">

    <div class="grid_12">
    
    	<h1 class="entry-title"><?php the_title(); ?></h1>
  
        <div class="content-area portfolio_section">
        	<div class="content_wrapper">				
				
                <?php
				$temp = $wp_query;
				$wp_query = null;
				//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$post_counter = 0;
				$wp_query = new WP_Query(array(
					'post_type' => 'portfolio',
					'posts_per_page' => 6,
					'orderby'=> 'menu_order',
					'paged'=>$paged
				));
				//$wp_query->query('posts_per_page=5'.'&paged='.$paged);				
				while ($wp_query->have_posts()) : $wp_query->the_post();
					$post_counter++;
					$related_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'portfolio_2_col' );
				?>

					<div class="portfolio_2_col_item_wrapper">
                        <div class="portfolio_item">
                            <div class="portfolio_item_img_container"><a href="<?php echo get_permalink(get_the_ID()); ?>"><img src="<?php echo $related_thumb[0]; ?>" alt="" /></a></div>
                            <a href="<?php echo get_permalink(get_the_ID()); ?>"><h3><?php the_title(); ?></h3></a>
                            <div class="portfolio_sep"></div>
                            <div class="portfolio_item_cat">
    
                            <?php 
                            echo strip_tags (
                                get_the_term_list( get_the_ID(), 'portfolio_filter', "",", " )
                            );
                            ?>
                            
                            </div>
                        </div>
                    </div>
				
				<?php endwhile; // end of the loop. ?>
            
				<?php 
				if (function_exists("emm_paginate")) {
                    emm_paginate();
                }				
				?>
                
                <?php $wp_query = null; $wp_query = $temp;?>
                
                <div class="clr"></div>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
        
        <?php theretailer_content_nav( 'nav-below' ); ?>
        
	</div>

</div>

<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>