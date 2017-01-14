<?php
/*
Template Name: Page with Sidebar
*/
?>

<?php get_header(); ?>

<div class="container_12 with_sidebar">

    <div class="grid_8">

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
        
	</div>

	<div class="grid_4">
    
		<div class="gbtr_aside_column">
			<?php 
			get_sidebar();
			?>
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
				
			}?>
	</div>
	<div style="clear: both"></div>
</div>

<div class="container_12 home_page_container>
	<div class="grid_12">
		<div class="content_wrapper entry-content">
			
			later..
		</div>
	</div>
</div>

<?php get_template_part("light_footer"); ?>
<?php get_template_part("dark_footer"); ?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		
		var x = 1; var k = 1;
		$('ul#team_members li').each(function(){
			$(this).attr('id', 'id___' + x);
			if (x++ % 4 == 0){	
				
				$(this).after('<li class="gray_li_wide" id="grrr_' + k++ + '"></li>');
			}
			var a = x-1;
			$(this).append('<span id="k'+a+'"></span>')
		});
		
		
		$('ul li img').hover(
			function(){
				
		        var fadeDiv = $(this).find('.description');
		        if ($(this).hasClass('pinned')){
		            return false;
		        }
		        else {
		            var src = this.src;
					src = src.replace("_b.png", "_c.png");
					$(this).attr("src", src);
					
		        }
		    },
		    function(){
		    	
		    	
				
				
		        var fadeDiv = $(this).find('.description');
		        if ($(this).hasClass('pinned')){
		            return false;
		        }
		        else {
		            var src = this.src;
				src = src.replace("_c.png", "_b.png");
				$(this).attr("src", src);
		        }
		    }).click(
		    function(){
		    	
		    	var id = $(this).parent().attr('id');
		    	id = id.split("___");
		    	id = id[1];
		    	console.log(id);
		    	
		    	var the_content = $(this).nextUntil('li');
		    	//var next_gray = $(this).
		    	
		    	var final_content = "";
		    	$.each(the_content, function(key, value){
		    		final_content += value.outerHTML;
		    		
		    	});
		    	console.log(final_content);
		    	
		    	var grr = 0;
		    	if (id >0 && id < 5){
		    		grr = 1;
		    	}
		    	if (id >4 && id < 9){
		    		grr = 2;
		    	}
		    	if (id >8 && id < 13){
		    		grr = 3;
		    	}
		    	console.log(grr);
		    	$('#grrr_' + 1).addClass('some_hide').text("");
		    	$('#grrr_' + 2).addClass('some_hide').text("");
		    	$('#grrr_' + 3).addClass('some_hide').text("");
		    	
		    	
		    	$('#grrr_' + grr).html(final_content);
		    	$('#grrr_' + grr).removeClass('some_hide');
		    	$('#grrr_' + grr).show();
		    	$('#grrr_' + grr + ' h4').css('display', 'block');
		    	$('#grrr_' + grr + ' p').css('display', 'block');
		    	//next = $(this).find(".gray_li_wide");
		    	//next.html('aasdvsgffg');
		    	//console.log(next);
		    	
		    	
		    	
		    	
		    	
		        $('#team_members li img').each(function(){
		        	$(this).removeClass('pinned');
		        	var src = this.src;
				src = src.replace("_c.png", "_b.png");
				$(this).attr("src", src);
		        });
		        $(this).addClass('pinned');
		        var src = this.src;
					src = src.replace("_b.png", "_c.png");
					$(this).attr("src", src);
					
		    });
	});
</script>

<?php get_footer(); ?>