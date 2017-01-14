<?php
/*
Template Name: HOME Page
*/
?>

<?php get_header(); ?>

<?php echo do_shortcode( '[rev_slider home-page-slider]' );?>

<div class="container_12 home_page_container c_block_your_local">
	<div class="grid_12">
		<div class="content_wrapper entry-content">
			<?php 
			// BLOCK Your local Auckland vets with 6 North Shore & West Auckland Vet Hospitals accross the region
			if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
				echo do_shortcode('[content_block id=52 ]');
			} else {
				echo do_shortcode('[content_block id=65 ]');
			}?>
		</div>
	</div>
</div>

<div class="content_wrapper full_width blue_content">
	<div class="container_12 center_me">
		<?php 
			// BLOCK Our North Shore/West Auckland Veterinary Hospital Group Locations
			if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
				echo do_shortcode('[content_block id=66 ]');
			} else {
				echo do_shortcode('[content_block id=67 ]');
			}?>
	</div>
	<div style="clear: both"></div>
</div>

<div class="container_12 home_page_container c_our_vet_s">
	<div class="grid_12">
		<div class="content_wrapper entry-content">
			<?php 
			// BLOCK Our Veterinary Services
			if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
				echo do_shortcode('[content_block id=103 ]');
				//echo '<div class="clear"></div>';
				
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id(105) ); //service - emergency vet services
				?>
				<div class="special_block_content" style="background-image: url(<?php echo $feat_image;?>)">
					<div class="inner_bottom_special">
					<?php
					echo do_shortcode('[content_block id=100]');
					echo "</div>";
				echo "</div>";
				
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id(103) ); //service - AUCKLAND WIDE vet services
				?>
				<div class="special_block_content" style="background-image: url(<?php echo $feat_image;?>)">
					<div class="inner_bottom_special">
					<?php
					echo do_shortcode('[content_block id=78]');
					echo "</div>";
				echo "</div>";
				
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id(100) ); //service - puppy trainig
				?>
				<div class="special_block_content" style="background-image: url(<?php echo $feat_image;?>)">
					<div class="inner_bottom_special">
					<?php
					echo do_shortcode('[content_block id=105]');
					echo "</div>";
				echo "</div>";
				
			} else {
				echo do_shortcode('[content_block id=69 ]');
				//echo '<div class="clear"></div>';
				
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id(79) ); //service - emergency vet services
				?>
				<div class="special_block_content" style="background-image: url(<?php echo $feat_image;?>)">
					<div class="inner_bottom_special">
					<?php
					echo do_shortcode('[content_block id=79]');
					echo "</div>";
				echo "</div>";
				
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id(77) ); //service - AUCKLAND WIDE vet services
				?>
				<div class="special_block_content" style="background-image: url(<?php echo $feat_image;?>)">
					<div class="inner_bottom_special">
					<?php
					echo do_shortcode('[content_block id=77]');
					echo "</div>";
				echo "</div>";
				
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id(75) ); //service - puppy trainig
				?>
				<div class="special_block_content" style="background-image: url(<?php echo $feat_image;?>)">
					<div class="inner_bottom_special">
					<?php
					echo do_shortcode('[content_block id=75]');
					echo "</div>";
				echo "</div>";
			}?>
		</div>
	</div>
</div>

<div class="content_wrapper full_width blue_content testimonials1">
	<div class="container_12 center_me testimonials">
		<?php 
			// BLOCK Home Page Testimonials
			if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
				//echo do_shortcode('[content_block id=93 ]');
				echo quoteRotator();
			} else {
				echo quoteRotator();
			}?>
	</div>
	<div style="clear: both"></div>
</div>

<div class="container_12 home_page_container above_footer">
	<div class="grid_12">
		<div class="content_wrapper entry-content">
			<div class="grid_4">
				<h1>LATEST NEWS FROM YOUR LOCAL VET</h1>
				<?php $cat_news = get_category_by_slug("news");
				$cat_news_id = $cat_news->term_id;
				$news = get_posts(array('category' => $cat_news_id, 'posts_per_page' => 2));
				?>
				<ul id="footer_news">
				<?php foreach ($news as $new){
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($new->ID) );
					//echo $feat_image;
					//echo "<li><h2>" . $new->post_title . "</h2>" . $new->post_excerpt . " <a href='" . get_permalink($new->ID) ."'>MORE</a></li>";
					?>
					<li>
						<div class='grid_1'>
							<img src="<?php echo $feat_image;?>" />
						</div>
						<div class="grid_2">
							<h2><a href="<?php echo get_permalink($new->ID);?>"><?php echo $new->post_title;?></a></h2>
							<?php echo $new->post_excerpt;?>
						</div>
					</li>
					<?php 
				}
				//var_dump($news);
				?>
				</ul>
			</div>
		
			<div class="grid_4">
				<h1>SPOTLIGHT ON PET CARE</h1>
				<?php $cat_news = get_category_by_slug("pet-care");
				$cat_news_id = $cat_news->term_id;
				$news = get_posts(array('category' => $cat_news_id, 'posts_per_page' => 1));
				?>
				<ul id="footer_news2">
				<?php foreach ($news as $new){
					echo "<li>";
					echo "<img src='" . wp_get_attachment_url( get_post_thumbnail_id($new->ID)) . "' />"; 
					echo "<h2><a href='" . get_permalink($new->ID) . "'>" . $new->post_title . "</a></h2>" . $new->post_excerpt . "</li>"; 
				}
				//var_dump($news);
				?>
				</ul>
			</div>
			
			<div class="grid_4">
				<?php echo dynamic_sidebar( 'my_facebook' );?>
			</div>
			
		</div>
	</div>
</div>

<div class="container_12" style="display: none">

    <div class="grid_12">

		<?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', 'page' ); ?>

        <?php endwhile; // end of the loop. ?>
        
	</div>

</div>

<?php get_template_part("light_footer"); ?>
<?php get_template_part("dark_footer"); ?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		
		var x = 0;
		$('li').each(function(){
			if (x++ % 2 == 0){
				//$(this).addClass('clear_li');
				
				$(this).after('<li class="clear_li"></li>');
			}
		});
		
		$('.content_grid_6 ul li').toggle(function(){
			var bg = $(this).css('background-image');
			bg = bg.replace("green", "white");
			$(this).css('background-image', bg);
			$(this).children('i').fadeIn('fast');
		}, function(){
			var bg = $(this).css('background-image');
			bg = bg.replace("white", "green");
			$(this).css('background-image', bg);
			$(this).children('i').fadeOut('fast');
		});
		
		$('ul li').click(function(){
			//$(this).children('i').slideDown('fast');
		});
	});
</script>

<?php get_footer(); ?>