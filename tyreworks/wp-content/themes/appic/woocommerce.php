<?php
/*
 * Template Name: Woocommerce Page
 */
get_header();
?>

<div class="white-wrap container">
	<section class="project-descript-wrap">
		<?php if (!is_product()) { ?>
		<div class="row">
			<div class="span8">
			<?php if (is_product_category()) : ?>
				<div class="category-head">
					<span class="category-img"></span>
				</div>
			<?php endif; ?>
				<?php if (have_posts()): ?>
					<?php woocommerce_content(); ?>
				<?php else : ?>
				<?php
					$isSearchQuery = !empty($_GET['s']);
					$isPriceFilter = isset($_GET['min_price']) || isset($_GET['max_price']);
					if ($isSearchQuery || $isPriceFilter) {
						echo'<h2 class="section-title templ-wrap">' . __('There are no products matching your criteria.','appic') . '</h2>';
					} else {
						get_template_part('404');
					}
				?>
				<?php endif; ?>
			</div>
			<aside class="span4">
				<div class="aside-wrap">
					<?php dynamic_sidebar('Woocommerce Sidebar'); ?>
				</div>
			</aside>
		</div>
		<?php } else { ?>
			<?php if (have_posts()): ?>
				<?php woocommerce_content(); ?>
			<?php else : ?>
				<?php get_template_part('404'); ?>
			<?php endif; ?>
		<?php } ?>
	</section>
</div>

<?php get_footer(); ?>