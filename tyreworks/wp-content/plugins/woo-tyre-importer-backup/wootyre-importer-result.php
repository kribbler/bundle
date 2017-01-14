<?php 
//var_dump($_POST);die();
?>
<script type="text/javascript">
    jQuery(document).ready(function($){

        $("#show_debug").click(function(){
            $("#debug").show();
            $(this).hide();
        });

        doAjaxImport(<?php echo intval($_POST['limit']); ?>, 0);

        function doAjaxImport(limit, offset) {
            var data = {
                "action": "wootyre-importer-ajax",
                "uploaded_file_path": <?php echo json_encode($_POST['uploaded_file_path']); ?>,
                "header_row": <?php echo json_encode($_POST['header_row']); ?>,
                "limit": limit,
                "offset": offset,
                "import_row": '<?php echo isset($_POST['import_row']) ? serialize($_POST['import_row']) : ""; ?>',
                "map_to": '<?php echo (serialize($_POST['map_to'])); ?>',
                "custom_field_name": '<?php echo (serialize($_POST['custom_field_name'])); ?>',
                "custom_field_visible": '<?php echo (serialize($_POST['custom_field_visible'])); ?>',
                "product_image_set_featured": '<?php echo (serialize($_POST['product_image_set_featured'])); ?>',
                "product_image_skip_duplicates": '<?php echo (serialize($_POST['product_image_skip_duplicates'])); ?>',
                "post_meta_key": '<?php echo (serialize($_POST['post_meta_key'])); ?>',
                "user_locale": '<?php echo (serialize($_POST['user_locale'])); ?>',
                "post_status" : '<?php echo (serialize($_POST['post_status']));?>'
            };

            //ajaxurl is defined by WordPress
            $.post(ajaxurl, data, ajaxImportCallback);
        }

        function ajaxImportCallback(response_text) {

            $("#debug").append($(document.createElement("p")).text(response_text));

            var response = jQuery.parseJSON(response_text);

            $("#insert_count").text(response.insert_count + " (" + response.insert_percent +"%)");
            $("#remaining_count").text(response.remaining_count);
            $("#row_count").text(response.row_count);

            //show inserted rows
            for(var row_num in response.inserted_rows) {
                var tr = $(document.createElement("tr"));

                if(response.inserted_rows[row_num]['success'] == true) {
                    if(response.inserted_rows[row_num]['has_errors'] == true) {
                        tr.addClass("error");
                    } else {
                        tr.addClass("success");
                    }
                } else {
                    tr.addClass("fail");
                }

                var post_link = $(document.createElement("a"));
                post_link.attr("target", "_blank");
                post_link.attr("href", "<?php echo get_admin_url(); ?>post.php?post=" + response.inserted_rows[row_num]['post_id'] + "&action=edit");
                post_link.text(response.inserted_rows[row_num]['post_id']);

                tr.append($(document.createElement("td")).append($(document.createElement("span")).addClass("icon")));
                tr.append($(document.createElement("td")).text(response.inserted_rows[row_num]['row_id']));
                tr.append($(document.createElement("td")).append(post_link));
                tr.append($(document.createElement("td")).text(response.inserted_rows[row_num]['name']));
                tr.append($(document.createElement("td")).text(response.inserted_rows[row_num]['sku']));
                tr.append($(document.createElement("td")).text(response.inserted_rows[row_num]['price']));

                var result_messages = "";
                if(response.inserted_rows[row_num]['has_messages'] == true) {
                    result_messages += response.inserted_rows[row_num]['messages'].join("\n") + "\n";
                }
                if(response.inserted_rows[row_num]['has_errors'] == true) {
                    result_messages += response.inserted_rows[row_num]['errors'].join("\n") + "\n";
                } else {
                    result_messages += "No errors.";
                }
                tr.append($(document.createElement("td")).text(result_messages));

                tr.appendTo("#inserted_rows tbody");
            }

            //show error messages
            for(var message in response.error_messages) {
                $(document.createElement("li")).text(response.error_messages[message]).appendTo(".import_error_messages");
            }

            //move on to the next set!
            if(parseInt(response.remaining_count) > 0) {
                doAjaxImport(response.limit, response.new_offset);
            } else {
                $("#import_status").addClass("complete");
            }
        }
    });
</script>

<div class="woo_product_importer_wrapper wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e( 'WooTyre Product Importer &raquo; Results', 'wootyre-importer' ); ?></h2>

    <ul class="import_error_messages">
    </ul>

    <div id="import_status">
        <div id="import_in_progress">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>img/ajax-loader.gif"
                alt="<?php _( 'Importing. Please do not close this window or click your browser\'s stop button.', 'wootyre-importer' ); ?>"
                title="<?php _e( 'Importing. Please do not close this window or click your browser\'s stop button.', 'wootyre-importer' ); ?>">

            <strong><?php _e( 'Importing. Please do not close this window or click your browser\'s stop button.', 'wootyre-importer' ); ?></strong>
        </div>
        <div id="import_complete">
            <img src="<?php echo plugin_dir_url(__FILE__); ?>img/complete.png"
                alt="<?php _e( 'Import complete!', 'wootyre-importer' ); ?>"
                title="<?php _e( 'Import complete!', 'wootyre-importer' ); ?>">
            <strong><?php _e( 'Import Complete! Results below.', 'wootyre-importer' ); ?></strong>
        </div>

        <table>
            <tbody>
                <tr>
                    <th><?php _e( 'Processed', 'wootyre-importer' ); ?></th>
                    <td id="insert_count">0</td>
                </tr>
                <tr>
                    <th><?php _e( 'Remainin', 'wootyre-importer' ); ?>g</th>
                    <td id="remaining_count"><?php echo $_POST['row_count']; ?></td>
                </tr>
                <tr>
                    <th><?php _e( 'Total', 'wootyre-importer' ); ?></th>
                    <td id="row_count"><?php echo $_POST['row_count']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <table id="inserted_rows" class="wp-list-table widefat fixed pages" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 30px;"></th>
                <th style="width: 80px;"><?php _e( 'CSV Row', 'wootyre-importer' ); ?></th>
                <th style="width: 80px;"><?php _e( 'New Post ID', 'wootyre-importer' ); ?></th>
                <th><?php _e( 'Name', 'wootyre-importer' ); ?></th>
                <th><?php _e( 'SKU', 'wootyre-importer' ); ?></th>
                <th style="width: 120px;"><?php _e( 'Price', 'wootyre-importer' ); ?></th>
                <th><?php _e( 'Result', 'wootyre-importer' ); ?></th>
            </tr>
        </thead>
        <tbody><!-- rows inserted via AJAX --></tbody>
    </table>

    <p><a id="show_debug" href="#" class="button"><?php _e( 'Show Raw AJAX Responses', 'wootyre-importer' ); ?></a></p>
    <div id="debug"><!-- server responses get logged here --></div>

</div>