<?php

global $menu, $submenu, $parent_file;
$menu = array();
add_thickbox();
wp_enqueue_media( array( 'post' => $this->post_id ) );
require_once( $this->adminFile('admin-header.php') );
?>
<div class="wpb-edit-form" id="vc-inline-shortcode-edit-form">
    <div class="vc_row-fluid wpb-edit-form-inner">
        <div class="vc_span12 wpb_edit_form_elements">
            <?php echo $this->buildEditForm(); ?>
            <?php WpbakeryShortcodeParams::enqueueScripts(); ?>
            </div>
    </div>
</div>
<script type="text/html" id="vc-settings-image-block">
    <li class="added">
        <div class="inner" style="width: 75px; height: 75px; overflow: hidden;text-align: center;">
            <img rel="<%= id %>" src="<%= url %>" />
        </div>
        <a href="#" class="icon-remove"></a>
    </li>
</script>

<?php require_once( $this->adminFile('admin-footer.php') ); ?>

