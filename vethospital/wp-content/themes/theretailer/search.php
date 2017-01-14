<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package theretailer
 * @since theretailer 1.0
 */

get_header(); ?>
<div class="container_12">

    <div class="grid_8">

		<section id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'theretailer' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php theretailer_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>

				<?php theretailer_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'search' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

	</div>
    
    <div class="grid_4">
    
		<div class="gbtr_aside_column">
			<?php 
			get_sidebar();
			?>
        </div>
        
    </div>
    
</div>

<?php get_template_part("light_footer"); ?>
<?php get_template_part("dark_footer"); ?>

<?php get_footer(); ?>