<?php 

    ini_set("auto_detect_line_endings", true);
    if (isset($_POST['user_locale']))
    	setlocale(LC_ALL, $_POST['user_locale']);

    $error_messages = array();

    if(isset($_POST['import_csv_url']) && strlen($_POST['import_csv_url']) > 0) {

        $file_path = $_POST['import_csv_url'];

    } elseif(isset($_FILES['import_csv']['tmp_name'])) {

        if(function_exists('wp_upload_dir')) {
            $upload_dir = wp_upload_dir();
            $upload_dir = $upload_dir['basedir'].'/csv_import';
        } else {
            $upload_dir = dirname(__FILE__).'/uploads';
        }

        if(!file_exists($upload_dir)) {
            $old_umask = umask(0);
            mkdir($upload_dir, 0755, true);
            umask($old_umask);
        }
        if(!file_exists($upload_dir)) {
            $error_messages[] = sprintf( __( 'Could not create upload directory %s.', 'wootyre-importer' ), $upload_dir );
        }

        //gets uploaded file extension for security check.
        $uploaded_file_ext = strtolower(pathinfo($_FILES['import_csv']['name'], PATHINFO_EXTENSION));

        //full path to uploaded file. slugifys the file name in case there are weird characters present.
        $uploaded_file_path = $upload_dir.'/'.sanitize_title(basename($_FILES['import_csv']['name'],'.'.$uploaded_file_ext)).'.'.$uploaded_file_ext;

        if($uploaded_file_ext != 'csv') {
            $error_messages[] = sprintf( __( 'The file extension %s is not allowed.', 'wootyre-importer' ), $uploaded_file_ext );

        } else {

            if(move_uploaded_file($_FILES['import_csv']['tmp_name'], $uploaded_file_path)) {
                $file_path = $uploaded_file_path;

            } else {
                $error_messages[] = sprintf( __( '%s returned false!', 'wootyre-importer' ), '<code>' . move_uploaded_file() . '</code>' );
            }
        }
    }

    if($file_path) {
        //now that we have the file, grab contents
        $handle = fopen($file_path, 'r' );
        $import_data = array();

        if ( $handle !== FALSE ) {
            while ( ( $line = fgetcsv($handle) ) !== FALSE ) {
                $import_data[] = $line;
            }
            fclose( $handle );

        } else {
            $error_messages[] = __( 'Could not open file.', 'wootyre-importer' );
        }

        if(intval($_POST['header_row']) == 1 && sizeof($import_data) > 0)
            $header_row = array_shift($import_data);

        $row_count = sizeof($import_data);
        if($row_count == 0)
            $error_messages[] = __( 'No data to import.', 'wootyre-importer' );

    }

    //$show_import_checkboxes = !!($row_count < 100);
	$show_import_checkboxes = true;

    //'mapping_hints' should be all lower case
    //(a strtolower is performed on header_row when checking)
    $col_mapping_options = array(
        'do_not_import' => array(
            'label' => __( 'Do Not Import', 'wootyre-importer' ),
            'mapping_hints' => array()),
        'post_title' => array(
            'label' => __( 'Name', 'wootyre-importer' ),
            'mapping_hints' => array('title', 'product name')),
        'post_status' => array(
            'label' => __( 'Status (Valid: publish/draft/trash/[more in Codex])', 'wootyre-importer' ),
            'mapping_hints' => array('status', 'product status', 'post status')),
        'post_content' => array(
            'label' => __( 'Description', 'wootyre-importer' ),
            'mapping_hints' => array('desc', 'content')),
        'post_excerpt' => array(
            'label' => __( 'Short Description', 'wootyre-importer' ),
            'mapping_hints' => array('short desc', 'excerpt')),
        '_regular_price' => array(
            'label' => __( 'Regular Price', 'wootyre-importer' ),
            'mapping_hints' => array('price', '_price', 'msrp')),
        '_sale_price' => array(
            'label' => __( 'Sale Price', 'wootyre-importer' ),
            'mapping_hints' => array()),
        '_tax_status' => array(
            'label' => __( 'Tax Status (Valid: taxable/shipping/none)', 'wootyre-importer' ),
            'mapping_hints' => array('tax status', 'taxable')),
        '_tax_class' => array(
            'label' => __( 'Tax Class', 'wootyre-importer' ),
            'mapping_hints' => array()),
        '_visibility' => array(
            'label' => __( 'Visibility (Valid: visible/catalog/search/hidden)', 'wootyre-importer' ),
            'mapping_hints' => array('visibility', 'visible')),
        '_featured' => array(
            'label' => __( 'Featured (Valid: yes/no)', 'wootyre-importer' ),
            'mapping_hints' => array('featured')),
        '_weight' => array(
            'label' => __( 'Weight', 'wootyre-importer' ),
            'mapping_hints' => array('wt')),
   		'_the_link' => array(
            'label' => __( 'Do Not Import', 'wootyre-importer' ),
            'mapping_hints' => array('_the_link')),
        '_length' => array(
            'label' => __( 'Length', 'wootyre-importer' ),
            'mapping_hints' => array('l')),
        '_width' => array(
            'label' => __( 'Width', 'wootyre-importer' ),
            'mapping_hints' => array('w')),
        '_height' => array(
            'label' => __( 'Height', 'wootyre-importer' ),
            'mapping_hints' => array('h')),
        '_sku' => array(
            'label' => __( 'SKU', 'wootyre-importer' ),
            'mapping_hints' => array()),
        '_downloadable' => array(
            'label' => __( 'Downloadable (Valid: yes/no)', 'wootyre-importer' ),
            'mapping_hints' => array('downloadable')),
        '_virtual' => array(
            'label' => __( 'Virtual (Valid: yes/no)', 'wootyre-importer' ),
            'mapping_hints' => array('virtual')),
        '_stock' => array(
            'label' => __( 'Stock', 'wootyre-importer' ),
            'mapping_hints' => array('qty', 'quantity')),
        '_stock_status' => array(
            'label' => __( 'Stock Status (Valid: instock/outofstock)', 'wootyre-importer' ),
            'mapping_hints' => array('stock status', 'in stock')),
        '_backorders' => array(
            'label' => __( 'Backorders (Valid: yes/no/notify)', 'wootyre-importer' ),
            'mapping_hints' => array('backorders')),
        '_manage_stock' => array(
            'label' => __( 'Manage Stock (Valid: yes/no)', 'wootyre-importer' ),
            'mapping_hints' => array('manage stock')),
        '_product_type' => array(
            'label' => __( 'Product Type (Valid: simple/variable/grouped/external)', 'wootyre-importer' ),
            'mapping_hints' => array('product type', 'type')),
        'product_cat_by_name' => array(
            'label' => __( 'Categories By Name (Separated by "|")', 'wootyre-importer' ),
            'mapping_hints' => array('category', 'categories', 'product category', 'product categories', 'product_cat')),
        'product_cat_by_id' => array(
            'label' => __( 'Categories By ID (Separated by "|")', 'wootyre-importer' ),
            'mapping_hints' => array()),
        'product_tag_by_name' => array(
            'label' => __( 'Tags By Name (Separated by "|")', 'wootyre-importer' ),
            'mapping_hints' => array('tag', 'tags', 'product tag', 'product tags', 'product_tag')),
        'product_tag_by_id' => array(
            'label' => __( 'Tags By ID (Separated by "|")', 'wootyre-importer' ),
            'mapping_hints' => array()),
        'custom_field' => array(
            'label' => __( 'Custom Field (Set Name Below)', 'wootyre-importer' ),
            'mapping_hints' => array('custom field', 'custom')),
        'product_image_by_url' => array(
            'label' => __( 'Images (By URL, Separated by "|")', 'wootyre-importer' ),
            'mapping_hints' => array('image', 'images', 'image url', 'image urls', 'product image url', 'product image urls')),
        'product_image_by_path' => array(
            'label' => __( 'Images (By Local File Path, Separated by "|")', 'wootyre-importer' ),
            'mapping_hints' => array('image path', 'image paths', 'product image path', 'product image paths')),
        '_button_text' => array(
            'label' => __( 'Button Text (External Product Only)', 'wootyre-importer' ),
            'mapping_hints' => array('button text')),
        '_product_url' => array(
            'label' => __( 'Product URL (External Product Only)', 'wootyre-importer' ),
            'mapping_hints' => array('product url', 'url')),
        '_file_path' => array(
            'label' => __( 'File Path (Downloadable Product Only)', 'wootyre-importer' ),
            'mapping_hints' => array('file path', 'file')),
        '_download_expiry' => array(
            'label' => __( 'Download Expiration (in Days)', 'wootyre-importer' ),
            'mapping_hints' => array('download expiration', 'download expiry')),
        '_download_limit' => array(
            'label' => __( 'Download Limit (Number of Downloads)', 'wootyre-importer' ),
            'mapping_hints' => array('download limit', 'number of downloads')),
        'post_meta' => array(
            'label' => __( 'Post Meta', 'wootyre-importer' ),
            'mapping_hints' => array('postmeta')),

    );

?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("select.map_to").change(function(){

            if($(this).val() == 'custom_field') {
                $(this).closest('th').find('.custom_field_settings').show(400);
            } else {
                $(this).closest('th').find('.custom_field_settings').hide(400);
            }

            if($(this).val() == 'product_image_by_url' || $(this).val() == 'product_image_by_path') {
                $(this).closest('th').find('.product_image_settings').show(400);
            } else {
                $(this).closest('th').find('.product_image_settings').hide(400);
            }

            if($(this).val() == 'post_meta') {
                $(this).closest('th').find('.post_meta_settings').show(400);
            } else {
                $(this).closest('th').find('.post_meta_settings').hide(400);
            }
        });

        //to show the appropriate settings boxes.
        $("select.map_to").trigger('change');

        $(window).resize(function(){
            $("#import_data_preview").addClass("fixed").removeClass("super_wide");
            $("#import_data_preview").css("width", "100%");

            var cell_width = $("#import_data_preview tbody tr:first td:last").width();
            if(cell_width < 60) {
                $("#import_data_preview").removeClass("fixed").addClass("super_wide");
                $("#import_data_preview").css("width", "auto");
            }
        });

        //set table layout
        $(window).trigger('resize');
    });
</script>

<div class="woo_product_importer_wrapper wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e( 'WooTyre Product Importer &raquo; Preview', 'wootyre-importer' ); ?></h2>

    <?php if(sizeof($error_messages) > 0): ?>
        <ul class="import_error_messages">
            <?php foreach($error_messages as $message):?>
                <li><?php echo $message; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if($row_count > 0): ?>
        <form enctype="multipart/form-data" method="post" action="<?php echo get_admin_url().'tools.php?page=wootyre-importer&action=result'; ?>">
            <input type="hidden" name="uploaded_file_path" value="<?php echo htmlspecialchars($file_path); ?>">
            <input type="hidden" name="header_row" value="<?php echo $_POST['header_row']; ?>">
            <input type="hidden" name="user_locale" value="<?php echo (isset($_POST['user_locale'])) ? htmlspecialchars($_POST['user_locale']) : ""; ?>">
            <input type="hidden" name="row_count" id="row_count" value="<?php echo $row_count; ?>">
            <input type="hidden" name="limit" value="10">
			
            <p>
                <button class="button-primary" id="submit_form" type="submit"><?php _e( 'Import', 'wootyre-importer' ); ?></button>
            </p>

            <table id="import_data_preview" class="wp-list-table widefat fixed pages" cellspacing="0">
                <thead>
                    <?php if(intval($_POST['header_row']) == 1): ?>
                        <tr class="header_row">
                            <th colspan="<?php echo ($show_import_checkboxes) ? sizeof($header_row) + 2 : sizeof($header_row) + 1; ?>">
                            	<?php _e( 'CSV Header Row', 'wootyre-importer' ); ?><br />
                            	<a id="check_for_duplicates" href="javascript:void(0)">Check for duplicates</a>&nbsp;|&nbsp;<a href="javascript:void(0);" id="select_all">Deselect All</a>
                            	&nbsp;|&nbsp;Status of products:&nbsp;
                            	<select name="post_status">
                            		<option>Select</option>
                            		<option value=publish>Published</option>
                            		<option value=pending>Pending Review</option>
                            	</select>
                            </th>
                        </tr>
                        <tr class="header_row">
							<th></th>
                            <?php if($show_import_checkboxes): ?>
                                <th></th>
                            <?php endif; ?>
                            <?php foreach($header_row as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <?php if($show_import_checkboxes): ?>
							<th>Duplicate</th>
                            <th class="narrow"><?php _e( 'Import?', 'wootyre-importer' ); ?></th>
                        <?php endif; ?>
                        <?php
                            reset($import_data);
                            $first_row = current($import_data);
                            foreach($first_row as $key => $col):
                        ?>
                            <th>
                                <div class="map_to_settings">
                                	<?php foreach($col_mapping_options as $value => $meta):
                                		if(intval($_POST['header_row']) == 1) {
                                			$header_value = strtolower($header_row[$key]); break;
                                		}
                                	endforeach;?>
                                    <?php _e( 'Map to:', 'wootyre-importer' ); ?> <select id="s_<?php echo $header_value?>" name="map_to[<?php echo $key; ?>]" class="map_to">
                                        <?php foreach($col_mapping_options as $value => $meta): ?>
                                            <option value="<?php echo $value; ?>" <?php
                                                if(intval($_POST['header_row']) == 1) {
                                                    //pre-select this value if the header_row
                                                    //matches the label, value, or any of the hints.
                                                    $header_value = strtolower($header_row[$key]);
                                                    if( $header_value == strtolower($value) ||
                                                        $header_value == strtolower($meta['label']) ||
                                                        in_array($header_value, $meta['mapping_hints']) ) {

                                                        echo 'selected="selected"';
                                                    }
                                                }
                                            ?>><?php echo $meta['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="custom_field_settings field_settings">
                                    <h4><?php _e( 'Custom Field Settings', 'wootyre-importer' ); ?></h4>
                                    <p>
                                        <label for="custom_field_name_<?php echo $key; ?>"><?php _e( 'Name', 'wootyre-importer' ); ?></label>
                                        <input type="text" name="custom_field_name[<?php echo $key; ?>]" id="custom_field_name_<?php echo $key; ?>" value="<?php echo $header_row[$key]; ?>" />
                                    </p>
                                    <p>
                                        <input type="checkbox" name="custom_field_visible[<?php echo $key; ?>]" id="custom_field_visible_<?php echo $key; ?>" value="1" checked="checked" />
                                        <label for="custom_field_visible_<?php echo $key; ?>"><?php _e( 'Visible?', 'wootyre-importer' ); ?></label>
                                    </p>
                                </div>
                                <div class="product_image_settings field_settings">
                                    <h4><?php _e( 'Image Settings', 'wootyre-importer' ); ?></h4>
                                    <p>
                                        <input type="checkbox" name="product_image_set_featured[<?php echo $key; ?>]" id="product_image_set_featured_<?php echo $key; ?>" value="1" checked="checked" />
                                        <label for="product_image_set_featured_<?php echo $key; ?>"><?php _e( 'Set First Image as Featured', 'wootyre-importer' ); ?></label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="product_image_skip_duplicates[<?php echo $key; ?>]" id="product_image_skip_duplicates_<?php echo $key; ?>" value="1" checked="checked" />
                                        <label for="product_image_skip_duplicates_<?php echo $key; ?>"><?php _e( 'Skip Duplicate Images', 'wootyre-importer' ); ?></label>
                                    </p>
                                </div>
                                <div class="post_meta_settings field_settings">
                                    <h4><?php _e( 'Post Meta Settings', 'wootyre-importer' ); ?></h4>
                                    <p>
                                        <label for="post_meta_key_<?php echo $key; ?>"><?php _e( 'Meta Key', 'wootyre-importer' ); ?></label>
                                        <input type="text" name="post_meta_key[<?php echo $key; ?>]" id="post_meta_key_<?php echo $key; ?>" value="<?php echo $header_row[$key]; ?>" />
                                    </p>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($import_data as $row_id => $row): ?>
                        <tr>
							<th><img style="display:none" id="img_l_dup_<?php echo $row[16]; ?>" src="<?php echo plugin_dir_url(__FILE__); ?>img/ajax-loader1.gif" /><div class="check_duplicate" id="dup_<?php echo $row[16]?>">Not checked</div></th>
                            <?php if($show_import_checkboxes): ?>
                                <td class="narrow"><input class="check_item" id="item_<?php echo $row_id; ?>" type="checkbox" name="import_row[<?php echo $row_id; ?>]" value="1" checked="checked" /></td>
                            <?php endif; ?>
                            <?php foreach($row as $col): ?>
                                <td><?php echo htmlspecialchars($col); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php endif; ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	var selected = true;
	var select_i = 0;
	$('#select_all').click(function(){
		if (selected){
			$('.check_item').each(function(){
				var id = $(this).attr('id');
				$('#' + id).attr('checked', false);
			});
			$(this).html("Select All");
			select_i = 0;
			selected = false;
		} else {
			$('.check_item').each(function(){
				var id = $(this).attr('id');
				$('#' + id).attr('checked', true);
			});
			$(this).html("Deselect All");
			selected = true;
		}
	});

	$('.map_to').each(function(){
		var id = $(this).attr('id');
		var chang = id.search("pa_");
		if (chang > 0){
			$(this).val("custom_field");
			$(this).trigger('change');
		}
	});

	$('#check_for_duplicates').click(function(){
		$('.check_duplicate').each(function(){
			var id = $(this).attr('id');
			var sku = id.split("dup_");
			sku = sku[1];
			$('#' + id).html('');
			$('#img_l_' + $(this).attr('id')).show();
			$.ajax({
				url: 		ajaxurl,
				data:		{
					'action': 'wootyre-importer-check-duplicate',
					'sku': sku
				},
				type:		'POST',
				success:	function(response){
					$('#img_l_' + id).hide();
					$('#' + id).html(response);
					if ($.trim(response) == 'New'){
						$('#' + id).parent().parent().css('background', '#dafbe5');
					} else {
						$('#' + id).parent().parent().css('background', '#fbdada');
					}
				}
			})
		})
	});

	$('#submit_form').click(function(){
		var total = 0;
		$('.check_item').each(function(){
			if ($(this).attr('checked')) total++;
		});
		
		$('#row_count').val(total);
		return true;
	});
});
</script>