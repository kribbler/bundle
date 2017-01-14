<?php

class WonderPlugin_Carousel_Creator {

	private $parent_view, $list_table;
	
	function __construct($parent) {
		
		$this->parent_view = $parent;
	}
	
	function render( $id, $config, $thumbnailsize ) {
		
		?>
		
		<h3><?php _e( 'General Options', 'wonderplugin_carousel' ); ?></h3>
		
		<div id="wonderplugin-carousel-id" style="display:none;"><?php echo $id; ?></div>
		
		<?php 
		$config = str_replace('\\\"', '"', $config);
		$config = str_replace("\\\'", "'", $config);
		$config = str_replace("<", "&lt;", $config);
		$config = str_replace(">", "&gt;", $config);
		$config = str_replace("\\\\", "\\", $config);
		?>
		
		<div id="wonderplugin-carousel-id-config" style="display:none;"><?php echo $config; ?></div>
		<div id="wonderplugin-carousel-jsfolder" style="display:none;"><?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?></div>
		<div id="wonderplugin-carousel-wp-history-media-uploader" style="display:none;"><?php echo ( function_exists("wp_enqueue_media") ? "0" : "1"); ?></div>
		<div id="wonderplugin-carousel-thumbnailsize" style="display:none;"><?php echo $thumbnailsize; ?></div>
		
		<div style="margin:0 12px;">
		<table class="wonderplugin-form-table">
			<tr>
				<th><?php _e( 'Name', 'wonderplugin_carousel' ); ?></th>
				<td><input name="wonderplugin-carousel-name" type="text" id="wonderplugin-carousel-name" value="My Carousel" class="regular-text" /></td>
			</tr>
		</table>
		</div>
		
		<h3><?php _e( 'Designing', 'wonderplugin_carousel' ); ?></h3>
		
		<div style="margin:0 12px;">
		<ul class="wonderplugin-tab-buttons" id="wonderplugin-carousel-toolbar">
			<li class="wonderplugin-tab-button step1 wonderplugin-tab-buttons-selected"><?php _e( 'Images & Videos', 'wonderplugin_carousel' ); ?></li>
			<li class="wonderplugin-tab-button step2"><?php _e( 'Skins', 'wonderplugin_carousel' ); ?></li>
			<li class="wonderplugin-tab-button step3"><?php _e( 'Options', 'wonderplugin_carousel' ); ?></li>
			<li class="wonderplugin-tab-button step4"><?php _e( 'Preview', 'wonderplugin_carousel' ); ?></li>
			<li class="laststep"><input class="button button-primary" type="button" value="<?php _e( 'Save & Publish', 'wonderplugin_carousel' ); ?>"></input></li>
		</ul>
				
		<ul class="wonderplugin-tabs" id="wonderplugin-carousel-tabs">
			<li class="wonderplugin-tab wonderplugin-tab-selected">	
			
				<div class="wonderplugin-toolbar">	
					<input type="button" class="button" id="wonderplugin-add-image" value="<?php _e( 'Add Image', 'wonderplugin_carousel' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-video" value="<?php _e( 'Add Video', 'wonderplugin_carousel' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-youtube" value="<?php _e( 'Add YouTube', 'wonderplugin_carousel' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-vimeo" value="<?php _e( 'Add Vimeo', 'wonderplugin_carousel' ); ?>" />
				</div>
        		
        		<table class="wonderplugin-table" id="wonderplugin-carousel-media-table">
			        <thead>
			          	<tr>
			            	<th>#</th>
			            	<th><?php _e( 'Media', 'wonderplugin_carousel' ); ?></th>
			            	<th><?php _e( 'Type', 'wonderplugin_carousel' ); ?></th>
			            	<th><?php _e( 'Actions', 'wonderplugin_carousel' ); ?></th>
			          	</tr>
			        </thead>
			        <tbody>
			        </tbody>
			      </table>
      
			</li>
			<li class="wonderplugin-tab">
				<form>
					<fieldset>
						
						<?php 
						$skins = array(
								"classic" => "Classic",
								"gallery" => "Gallery",
								"highlight" => "Highlight",
								"list" => "List",
								"navigator" => "Navigator",
								"showcase" => "Showcase",
								"simplicity" => "Simplicity",
								"stylish" => "Stylish",
								"thumbnail" => "Thumbnail",
								"vertical" => "Vertical",
								"testimonial" => "Testimonial"
								);
						
						foreach ($skins as $key => $value) {
						?>
							<div class="wonderplugin-tab-skin">
							<label><input type="radio" name="wonderplugin-carousel-skin" value="<?php echo $key; ?>" selected> <?php echo $value; ?> <br /><img class="selected" style="width:300px;" src="<?php echo WONDERPLUGIN_CAROUSEL_URL; ?>images/<?php echo $key; ?>.png" /></label>
							</div>
						<?php
						}
						?>
						
					</fieldset>
				</form>
			</li>
			<li class="wonderplugin-tab">
			
				<div class="wonderplugin-carousel-options">
					<div class="wonderplugin-carousel-options-menu" id="wonderplugin-carousel-options-menu">
						<div class="wonderplugin-carousel-options-menu-item wonderplugin-carousel-options-menu-item-selected"><?php _e( 'Skin options', 'wonderplugin_carousel' ); ?></div>
						<div class="wonderplugin-carousel-options-menu-item"><?php _e( 'Responsive options', 'wonderplugin_carousel' ); ?></div>
						<div class="wonderplugin-carousel-options-menu-item"><?php _e( 'Content template', 'wonderplugin_carousel' ); ?></div>
						<div class="wonderplugin-carousel-options-menu-item"><?php _e( 'Skin CSS', 'wonderplugin_carousel' ); ?></div>
						<div class="wonderplugin-carousel-options-menu-item"><?php _e( 'Lightbox options', 'wonderplugin_carousel' ); ?></div>
						<div class="wonderplugin-carousel-options-menu-item"><?php _e( 'Advanced options', 'wonderplugin_carousel' ); ?></div>
					</div>
					
					<div class="wonderplugin-carousel-options-tabs" id="wonderplugin-carousel-options-tabs">
					
						<div class="wonderplugin-carousel-options-tab wonderplugin-carousel-options-tab-selected">
							<p class="wonderplugin-carousel-options-tab-title"><?php _e( 'Options will be restored to the default value if you switch to a new skin in the Skins tab.', 'wonderplugin_carousel' ); ?></p>
							<table class="wonderplugin-form-table-noborder">
							
								<tr>
									<th>Width / Height</th>
									<td><label><input name="wonderplugin-carousel-width" type="text" id="wonderplugin-carousel-width" value="300" class="small-text" /> / <input name="wonderplugin-carousel-height" type="text" id="wonderplugin-carousel-height" value="300" class="small-text" /></label></td>
								</tr>
								
								<tr>
									<th>Play mode</th>
									<td><label><input name='wonderplugin-carousel-autoplay' type='checkbox' id='wonderplugin-carousel-autoplay'  /> Auto play</label>
									<br /><label><input name='wonderplugin-carousel-random' type='checkbox' id='wonderplugin-carousel-random'  /> Random</label>
									</td>
								</tr>
								<tr>
									<th>Circular</th>
									<td><label><input name='wonderplugin-carousel-circular' type='checkbox' id='wonderplugin-carousel-circular'  /> Circular</label>
									</td>
								</tr>
								<tr>
									<th>Arrows</th>
									<td><label>
										<select name='wonderplugin-carousel-arrowstyle' id='wonderplugin-carousel-arrowstyle'>
										  <option value="mouseover">Show on mouseover</option>
										  <option value="always">Always show</option>
										  <option value="none">Hide</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Arrow image</th>
									<td>
										<div>
											<div style="float:left;margin-right:12px;">
											<label>
											<img id="wonderplugin-carousel-displayarrowimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="wonderplugin-carousel-arrowimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='wonderplugin-carousel-customarrowimage' type='text' class="regular-text" id='wonderplugin-carousel-customarrowimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="wonderplugin-carousel-arrowimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='wonderplugin-carousel-arrowimage' id='wonderplugin-carousel-arrowimage'>
												<?php 
													$arrowimage_list = array("arrows-28-28-0.png", 
															"arrows-32-32-0.png", "arrows-32-32-1.png", "arrows-32-32-2.png", "arrows-32-32-3.png", "arrows-32-32-4.png", 
															"arrows-36-36-0.png",
															"arrows-36-80-0.png",
															"arrows-48-48-0.png", "arrows-48-48-1.png", "arrows-48-48-2.png", "arrows-48-48-3.png",
															"arrows-72-72-0.png");
													foreach ($arrowimage_list as $arrowimage)
														echo '<option value="' . $arrowimage . '">' . $arrowimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=wonderplugin-carousel-arrowimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#wonderplugin-carousel-displayarrowimage").attr("src", jQuery('#wonderplugin-carousel-customarrowimage').val());
												else
													jQuery("#wonderplugin-carousel-displayarrowimage").attr("src", "<?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#wonderplugin-carousel-arrowimage').val());
											});

											jQuery("#wonderplugin-carousel-arrowimage").change(function(){
												if (jQuery("input:radio[name=wonderplugin-carousel-arrowimagemode]:checked").val() == 'defined')
													jQuery("#wonderplugin-carousel-displayarrowimage").attr("src", "<?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#wonderplugin-carousel-arrowwidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#wonderplugin-carousel-arrowheight").val(arrowsize[2]);
												}
													
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='wonderplugin-carousel-arrowwidth' type='text' size="10" id='wonderplugin-carousel-arrowwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='wonderplugin-carousel-arrowheight' type='text' size="10" id='wonderplugin-carousel-arrowheight' value='32' /></label><br />										
									</td>
								</tr>
								
								<tr>
									<th>Navigation</th>
									<td><label>
										<select name='wonderplugin-carousel-navstyle' id='wonderplugin-carousel-navstyle'>
										  <option value="bullets">Bullets</option>
										  <option value="none">None</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Bullet image</th>
									<td>
										<div>
											<div style="float:left;margin-right:12px;margin-top:4px;">
											<label>
											<img id="wonderplugin-carousel-displaynavimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="wonderplugin-carousel-navimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='wonderplugin-carousel-customnavimage' type='text' class="regular-text" id='wonderplugin-carousel-customnavimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="wonderplugin-carousel-navimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='wonderplugin-carousel-navimage' id='wonderplugin-carousel-navimage'>
												<?php 
													$navimage_list = array("bullet-12-12-0.png", "bullet-12-12-1.png", 
															"bullet-16-16-0.png", "bullet-16-16-1.png", "bullet-16-16-2.png", "bullet-16-16-3.png", 
															"bullet-20-20-0.png", "bullet-20-20-1.png", 
															"bullet-24-24-0.png", "bullet-24-24-1.png", "bullet-24-24-2.png", "bullet-24-24-3.png", "bullet-24-24-4.png", "bullet-24-24-5.png", "bullet-24-24-6.png");
													foreach ($navimage_list as $navimage)
														echo '<option value="' . $navimage . '">' . $navimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=wonderplugin-carousel-navimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#wonderplugin-carousel-displaynavimage").attr("src", jQuery('#wonderplugin-carousel-customnavimage').val());
												else
													jQuery("#wonderplugin-carousel-displaynavimage").attr("src", "<?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#wonderplugin-carousel-navimage').val());
											});

											jQuery("#wonderplugin-carousel-navimage").change(function(){
												if (jQuery("input:radio[name=wonderplugin-carousel-navimagemode]:checked").val() == 'defined')
													jQuery("#wonderplugin-carousel-displaynavimage").attr("src", "<?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
												var navsize = jQuery(this).val().split("-");
												if (navsize.length > 2)
												{
													if (!isNaN(navsize[1]))
														jQuery("#wonderplugin-carousel-navwidth").val(navsize[1]);
													if (!isNaN(navsize[2]))
														jQuery("#wonderplugin-carousel-navheight").val(navsize[2]);
												}
													
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='wonderplugin-carousel-navwidth' type='text' size="10" id='wonderplugin-carousel-navwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='wonderplugin-carousel-navheight' type='text' size="10" id='wonderplugin-carousel-navheight' value='32' /></label><br />										
										<label><span style="display:inline-block;min-width:100px;">Spacing:</span> <input name='wonderplugin-carousel-navspacing' type='text' size="10" id='wonderplugin-carousel-navspacing' value='32' /></label>										
										</td>
								</tr>
								
								<tr>
									<th>Hover overlay</th>
									<td>
										<div>
											<div>
											<label><input name='wonderplugin-carousel-showhoveroverlay' type='checkbox' id='wonderplugin-carousel-showhoveroverlay'  /> Show hover overlay image</label>
											</div>
											<div style="float:left;margin-right:12px;">
											<label>
											<img id="wonderplugin-carousel-displayhoveroverlayimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="wonderplugin-carousel-hoveroverlayimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='wonderplugin-carousel-customhoveroverlayimage' type='text' class="regular-text" id='wonderplugin-carousel-customhoveroverlayimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="wonderplugin-carousel-hoveroverlayimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='wonderplugin-carousel-hoveroverlayimage' id='wonderplugin-carousel-hoveroverlayimage'>
												<?php 
													$hoveroverlayimage_list = array("hoveroverlay-64-64-0.png", "hoveroverlay-64-64-1.png", "hoveroverlay-64-64-2.png", "hoveroverlay-64-64-3.png", "hoveroverlay-64-64-4.png", "hoveroverlay-64-64-5.png", "hoveroverlay-64-64-6.png", "hoveroverlay-64-64-7.png");
													foreach ($hoveroverlayimage_list as $hoveroverlayimage)
														echo '<option value="' . $hoveroverlayimage . '">' . $hoveroverlayimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=wonderplugin-carousel-hoveroverlayimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#wonderplugin-carousel-displayhoveroverlayimage").attr("src", jQuery('#wonderplugin-carousel-customhoveroverlayimage').val());
												else
													jQuery("#wonderplugin-carousel-displayhoveroverlayimage").attr("src", "<?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#wonderplugin-carousel-hoveroverlayimage').val());
											});
											jQuery("#wonderplugin-carousel-hoveroverlayimage").change(function(){
												if (jQuery("input:radio[name=wonderplugin-carousel-hoveroverlayimagemode]:checked").val() == 'defined')
													jQuery("#wonderplugin-carousel-displayhoveroverlayimage").attr("src", "<?php echo WONDERPLUGIN_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='wonderplugin-carousel-arrowwidth' type='text' size="10" id='wonderplugin-carousel-arrowwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='wonderplugin-carousel-arrowheight' type='text' size="10" id='wonderplugin-carousel-arrowheight' value='32' /></label><br />	
										<label><input name='wonderplugin-carousel-showhoveroverlayalways' type='checkbox' id='wonderplugin-carousel-showhoveroverlayalways'  /> Show hover image for both Lightbox and weblink</label>									
									</td>
								</tr>
								
							</table>
						</div>
						
						<div class="wonderplugin-carousel-options-tab">
							<table class="wonderplugin-form-table-noborder">

								<tr>
									<th>Visible items</th>
									<td><label><input name='wonderplugin-carousel-visibleitems' type='text' size="10" id='wonderplugin-carousel-visibleitems' value='3' /></label></td>
								</tr>
								
								<tr>
									<th>Responsive</th>
									<td><label><input name='wonderplugin-carousel-responsive' type='checkbox' id='wonderplugin-carousel-responsive'  /> Responsive</label>
									</td>
								</tr>
								
								<tr>
									<th>Responsive mode</th>
									<td>
										<label>
											<input type="radio" name="wonderplugin-carousel-usescreenquery" value="fixedsize">
											Change the number of visible items according to the container size, keep item size unchanged
										</label>
										<br /><br />
										<label>
											<input type="radio" name="wonderplugin-carousel-usescreenquery" value="screensize">
											Change the number of visible items according to the screen size, adjust item size accordingly:
										</label>
										<textarea style="margin-left:16px;" name='wonderplugin-carousel-screenquery' id='wonderplugin-carousel-screenquery' value='' class='large-text' rows="10"></textarea>
									</td>
								</tr>
											
							</table>
						</div>
						
						<div class="wonderplugin-carousel-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Skin template</th>
									<td><textarea name='wonderplugin-carousel-skintemplate' id='wonderplugin-carousel-skintemplate' value='' class='large-text' rows="20"></textarea></td>
								</tr>
							</table>
						</div>
						
						<div class="wonderplugin-carousel-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Skin CSS</th>
									<td><textarea name='wonderplugin-carousel-skincss' id='wonderplugin-carousel-skincss' value='' class='large-text' rows="20"></textarea></td>
								</tr>
							</table>
						</div>
						
						<div class="wonderplugin-carousel-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Thumbnails</th>
									<td><label><input name='wonderplugin-carousel-lightboxshownavigation' type='checkbox' id='wonderplugin-carousel-lightboxshownavigation'  /> Show thumbnails</label>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><label>Size: <input name="wonderplugin-carousel-lightboxthumbwidth" type="text" id="wonderplugin-carousel-lightboxthumbwidth" value="96" class="small-text" /> x <input name="wonderplugin-carousel-lightboxthumbheight" type="text" id="wonderplugin-carousel-lightboxthumbheight" value="72" class="small-text" /></label> 
									<label>Top margin: <input name="wonderplugin-carousel-lightboxthumbtopmargin" type="text" id="wonderplugin-carousel-lightboxthumbtopmargin" value="12" class="small-text" /> Bottom margin: <input name="wonderplugin-carousel-lightboxthumbbottommargin" type="text" id="wonderplugin-carousel-lightboxthumbbottommargin" value="12" class="small-text" /></label>
									</td>
								</tr>
								<tr>
									<th>Maximum text bar height</th>
									<td><label><input name="wonderplugin-carousel-lightboxbarheight" type="text" id="wonderplugin-carousel-lightboxbarheight" value="64" class="small-text" /></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Title</th>
									<td><label><input name="wonderplugin-carousel-lightboxshowtitle" type="checkbox" id="wonderplugin-carousel-lightboxshowtitle" /> Show title</label></td>
								</tr>
								
								<tr>
									<th>Title CSS</th>
									<td><label><textarea name="wonderplugin-carousel-lightboxtitlebottomcss" id="wonderplugin-carousel-lightboxtitlebottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Description</th>
									<td><label><input name="wonderplugin-carousel-lightboxshowdescription" type="checkbox" id="wonderplugin-carousel-lightboxshowdescription" /> Show description</label></td>
								</tr>
								
								<tr>
									<th>Description CSS</th>
									<td><label><textarea name="wonderplugin-carousel-lightboxdescriptionbottomcss" id="wonderplugin-carousel-lightboxdescriptionbottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
							</table>
						</div>
						
						<div class="wonderplugin-carousel-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Custom CSS</th>
									<td><textarea name='wonderplugin-carousel-custom-css' id='wonderplugin-carousel-custom-css' value='' class='large-text' rows="10"></textarea></td>
								</tr>
								<tr>
									<th>Advanced Options</th>
									<td><textarea name='wonderplugin-carousel-data-options' id='wonderplugin-carousel-data-options' value='' class='large-text' rows="10"></textarea></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				
			</li>
			<li class="wonderplugin-tab">
				<div id="wonderplugin-carousel-preview-tab">
					<div id="wonderplugin-carousel-preview-container">
					</div>
				</div>
			</li>
			<li class="wonderplugin-tab">
				<div id="wonderplugin-carousel-publish-loading"></div>
				<div id="wonderplugin-carousel-publish-information"></div>
			</li>
		</ul>
		</div>
		
		<?php
	}
	
	function get_list_data() {
		return array();
	}
}