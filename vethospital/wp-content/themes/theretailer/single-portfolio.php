<?php
/**
 * The Template for displaying all single posts.
 *
 * @package theretailer
 * @since theretailer 1.0
 */

get_header(); ?>

<div class="container_12">

    <div class="grid_4 push_8">
    
		<div class="aside_portfolio">
			
			<div class="entry-content-aside">
				<?php while ( have_posts() ) : the_post(); ?>
    
                <h1 class="entry-title portfolio_item_title"><?php the_title(); ?></h1>
                
                <div class="portfolio_details_sep"></div>
                
                <div class="portfolio_details_item_cat">
                    <span><?php _e("Category:", "theretailer"); ?></span>
                    
                    <?php 
                    echo strip_tags (
                        get_the_term_list( get_the_ID(), 'portfolio_filter', "",", " )
                    );
                    ?>
                </div>
                
                <h4 class="entry-content-aside-title"><?php _e("Description", "theretailer"); ?></h4>
				<?php the_excerpt(); ?>
    
                <?php endwhile; // end of the loop. ?>
            </div>
        </div>
        
    </div>
    
    <div class="grid_8 pull_4">

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<div class="entry-content entry-content-portfolio">
				<?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
                <?php endwhile; // end of the loop. ?>
                
                <?php 
                /*$attachments = get_posts( array(
                    'post_type' => 'attachment',
                    'posts_per_page' => -1,
                    'post_parent' => $post->ID,
                    'exclude'     => get_post_thumbnail_id()
                ) );
        
                if ( $attachments ) {
                    foreach ( $attachments as $attachment ) {
                        $thumbimg = wp_get_attachment_image($attachment->ID, 'portfolio-details');
                        echo "<div class='portfolio_detail_img_wrapper'>" . $thumbimg . "</div>";
                    }
                }*/
                ?>
            </div>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

	</div>
</div>

<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>