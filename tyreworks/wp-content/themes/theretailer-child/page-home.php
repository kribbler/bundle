<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>

<div class="container_12 home_page">

    <div class="grid_12">

		<?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', 'page' ); ?>

        <?php endwhile; // end of the loop. ?>
        
	</div>

</div>

<div class="container_12  content_about">
	<div class="grid_12">
		<!--About-->
		<?php if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
			echo do_shortcode('[content_block id=66 ]');
		} else { 
	    	echo do_shortcode('[content_block id=20 ]');
	    }?>
	</div>
</div>

<div class="container_12 content_about">
	<div class="grid_12">
    <!--What people think-->
    <?php if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
    	echo do_shortcode('[content_block id=71 ]');
	} else {
		echo do_shortcode('[content_block id=23 ]');
	}
    ?>
	</div>
</div>


<?php //get_template_part("light_footer"); ?>
<?php //get_template_part("dark_footer"); ?>

<?php get_footer(); ?>