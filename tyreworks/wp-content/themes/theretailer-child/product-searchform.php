<form role="search" class="super_search" method="get" id="searchform" action=" <?php echo esc_url( home_url( '/' ) );?> ">

<p>with your car registration number</p>
<input type="text" name="enter_your_reg" id="enter_your_reg" value="ENTER YOUR REG" default="SE08 WBX" />

<p> or by your tyre size</p>

	<div class="super_search1">
		<b>Width:</b>
		<select name="pa_width" id="pa_width">
		    <?php $catTerms = get_terms('pa_width', array('hide_empty' => 0, 'orderby' => 'ASC')); ?>
		    	<option value="">Select</option>
		        <?php foreach($catTerms as $catTerm) : ?>
		        <option value="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></option>
		    <?php endforeach; ?>                                            
		</select>
	</div>
	
	<div class="super_search1">
		<b>Rim Size:</b>
		<select name="pa_rim-size" id="pa_rim-size">
		    <?php $catTerms = get_terms('pa_rim-size', array('hide_empty' => 0, 'orderby' => 'ASC')); ?>
		    	<option value="">Select</option>
		        <?php foreach($catTerms as $catTerm) : ?>
		        <option value="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></option>
		    <?php endforeach; ?>                                            
		</select>
	</div>
	
	<div class="super_search2">
		<b>Brand:</b>
		<select name="pa_brand" id="pa_brand">
		    <?php $catTerms = get_terms('pa_brand', array('hide_empty' => 0, 'orderby' => 'ASC')); ?>
		        <option value="">Select</option>
		        <?php foreach($catTerms as $catTerm) : ?>
		        <option value="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></option>
		    <?php endforeach; ?>                                            
		</select>
	</div>
	
	<div class="clear"></div>
	<br />
	<div class="super_search1">
		<b>Profile:</b>
		<select name="pa_profile" id="pa_profile">
			<option value="">Select</option>
		    <?php $catTerms = get_terms('pa_profile', array('hide_empty' => 0, 'orderby' => 'ASC')); ?>
		        <?php foreach($catTerms as $catTerm) : ?>
		        <option value="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></option>
		    <?php endforeach; ?>                                            
		</select>
	</div>
	
	<div class="super_search1">
		<b>Speed Rating:</b>
		<select name="pa_speed" id="pa_speed">
			<option value="">Select</option>
		    <?php $catTerms = get_terms('pa_speed', array('hide_empty' => 0, 'orderby' => 'ASC')); ?>
		        <?php foreach($catTerms as $catTerm) : ?>
		        <option value="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></option>
		    <?php endforeach; ?>                                            
		</select>
	</div>
	
	<div class="super_search2 supersearch_submit">
		
		<input type="submit" id="searchsubmit" value=" <?php echo esc_attr__( 'Search', 'woocommerce' );?>" />
	</div>
	
	<input type="hidden" name="post_type" value="product" />
	<input type="hidden" name="tyres_for" id="tyres_for" />
</form>
<span id="ajax_loading"><img src="<?php echo get_stylesheet_directory_uri();?>/images/ajax_loading.gif" /></span>
<span id="tyre_service_no_results">The registration is not found in the database. Please use the drop downs above.</span>
	
<?php
/*
 * <select name="product_cat">
		    <?php $catTerms = get_terms('product_cat', array('hide_empty' => 0, 'orderby' => 'ASC', 'exclude' => '17,77')); ?>
		        <?php foreach($catTerms as $catTerm) : ?>
		        <option value="<?php echo $catTerm->slug; ?>"><?php echo $catTerm->name; ?></option>
		    <?php endforeach; ?>                                            
		</select>
 */
?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		var not_found = false;
		$('#tyre_service_no_results').hide();
		$('#ajax_loading').hide();
		$('#enter_your_reg').click(function(){
			var nr = $(this).val();
			if (nr == 'ENTER YOUR REG'){
				$(this).val("");
			}
		});
		
		$('#searchform').submit(function(){
			$('#tyre_service_no_results').hide();
			$('#ajax_loading').show();
			$.ajax({
				url: "<?php echo get_stylesheet_directory_uri(); ?>/car_plates.php?vrm=" + $('#enter_your_reg').val(),
				dataType: 'json',
				async: false,
				success: function(data){
					console.log('rim size: ' + $('#pa_rim-size').val());
					$('#tyre_service_no_results').hide();
					console.log(data);
					if (data.pa_width){
						$('#pa_width').val(data.pa_width);
					} else if ($('#pa_width').val()) {
						$('#pa_width').val($('#pa_width').val());
					}
					if (data.pa_rimsize){
						$('#pa_rim-size').val(data.pa_rimsize);
					} else if ($('#pa_rim-size').val()) {
						$('#pa_rim-size').val($('#pa_rim-size').val());
					}
					if (data.pa_profile){
						$('#pa_profile').val(data.pa_profile);
					}
					if (data.pa_speed){
						$('#pa_speed').val(data.pa_speed);
					}
					if (data.tyres_for){
						$('#tyres_for').val(data.tyres_for);
					}
					if (!data.pa_width){
						$('#ajax_loading').hide();
						not_found = false;
						//console.log(not_found);
						//return false;
					} else{
						$('#ajax_loading').hide();
						not_found = false;
					}
					//return false;
				}
			});
			/*
			$.get( "<?php echo get_stylesheet_directory_uri(); ?>/car_plates.php?vrm=" + $('#enter_your_reg').val(), function( data ) {
				console.log(data);
				if (data.pa_width){
					$('#pa_width').val('');
					$('#pa_width').val(data.pa_width);
				}
				if (data.pa_rimsize){
					$('#pa_rim-size').val(data.pa_rimsize);
				}
				if (data.pa_profile){
					$('#pa_profile').val(data.pa_profile);
				}
				if (data.pa_speed){
					$('#pa_speed').val(data.pa_speed);
				}
			}, "json" );
			*/
			//console.log($(this));
			console.log('not found = ' + not_found);
			if (not_found) {
				$('#tyre_service_no_results').fadeIn('fast');
				return false;
			} else {
				$('#tyre_service_no_results').hide();
			}
		})
	});
	
</script>
