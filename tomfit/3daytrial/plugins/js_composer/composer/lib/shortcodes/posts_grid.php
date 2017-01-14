<?php

class WPBakeryShortCode_VC_Posts_Grid extends WPBakeryShortCode {
    protected $filter_categories = array();
    protected $query = false;
    protected $loop_args = array();
    protected $taxonomies = false;
    protected $partial_paths = array();
    protected static $pretty_photo_loaded = false;
    protected static $meta_data_name = 'vc_teaser';
    protected $teaser_data = false;
    protected $block_template_dir_name = 'post_block';
    protected $block_template_filename = '_item.php';

    function __construct($settings) {
        parent::__construct($settings);
        $this->addAction( 'admin_init', 'jsComposerEditPage', 6 );
    }
    public function jsComposerEditPage() {

        $vc = visual_composer();
        $pt_array = $vc->getPostTypes();
        foreach ($pt_array as $pt) {
            add_meta_box( 'vc_teaser', __('VC: Custom Teaser', "js_composer"), Array(&$this, 'outputTeaser'), $pt, 'side');
        }
        add_action('save_post', array(&$this, 'saveTeaserMetaBox'));
    }
    public function getTeaserData($name, $id = false) {
        if($id === false) $id = get_the_ID();
        $this->teaser_data = get_post_meta($id, self::$meta_data_name, true);
        return isset($this->teaser_data[$name]) ? $this->teaser_data[$name] : '';
    }
    public function outputTeaser() {
        wp_enqueue_script('wpb_jscomposer_teaser_js');
        wp_localize_script( 'wpb_jscomposer_teaser_js', 'i18nVcTeaser', array(
            'empty_title' => __('Empty title', "js_composer"),
            'text_label' => __('Text', "js_composer"),
            'image_label' => __('Image', "js_composer"),
            'title_label' => __('Title', "js_composer"),
            'link_label' => __('Link', "js_composer"),
            'text_text' => __('Text', "js_composer"),
            'text_excerpt' => __('Excerpt', "js_composer"),
            'text_custom' => __('Custom', "js_composer"),
            'image_featured' => __('Featered', "js_composer"),
            'image_custom' => __('Custom', "js_composer"),
            'link_label_text' => __('Link text', "js_composer"),
            'no_link' => __('No link', "js_composer"),
            'link_post' => __('Link to post', "js_composer"),
            'link_big_image' => __('Link to big image', "js_composer"),
            'add_custom_image' => __('Add custom image', "js_composer")
        ));
        $output = '<div class="vc-teaser-switch"><label><input type="checkbox" name="'.self::$meta_data_name.'[enable]" value="1" id="vc-teaser-checkbox"'.($this->getTeaserData('enable') === '1' ? ' checked="true"' : '').'> '.__('Enable custom teaser', "js_composer").'</label></div>';
        $output .= '<input type="hidden" name="'.self::$meta_data_name.'[data]" class="vc-teaser-data-field" value="'.htmlspecialchars($this->getTeaserData('data')).'">';
        $output .= '<div class="vc-teaser-constructor-hint">';
        $output .= '<p>'.__('Here you can customize teaser block design. It will be used instead of default settings in "Posts Grid" or "Carousel" content elements.', 'js_composer').'</p>';
        $output .= '</div>';
        $output .= '<div class="vc-teaser-constructor">';
        $output .= '<div class="vc-toolbar"></div>';
        $output .= '<div class="clear vc-teaser-list"></div>';
        $output .= '<div class="vc_teaser_loading_block" style="display: none;">';
        $output .= '<img src="'.get_site_url().'/wp-admin/images/wpspin_light.gif" /></div>';
        $output .= '<div class="vc-teaser-footer"><label>Background color</label><br/><input type="text" name="'.self::$meta_data_name.'[bgcolor]" value="'.htmlspecialchars($this->getTeaserData('bgcolor')).'" class="vc-teaser-bgcolor"></div>';
        $output .= '</div>';
        require_once WPBakeryVisualComposer::config('COMPOSER').'templates/teaser.html.php';
        echo $output;
    }
    public function saveTeaserMetaBox($post_id) {
        if (isset($_POST[self::$meta_data_name])) {
            $options = isset($_POST[self::$meta_data_name]) ? $_POST[self::$meta_data_name] : '';
            update_post_meta((int)$post_id, self::$meta_data_name, $options);
        }
    }
    protected function getCategoriesCss($post_id) {
        $categories_css = '';
        $post_categories = wp_get_object_terms($post_id, $this->getTaxonomies());
        foreach($post_categories as $cat) {
            if(!in_array($cat->term_id, $this->filter_categories)) {
                $this->filter_categories[] = $cat->term_id;
            }
            $categories_css .= ' grid-cat-'.$cat->term_id;
        }
        return $categories_css;
    }
    protected function getTaxonomies() {
        if($this->taxonomies === false) {
            $this->taxonomies = get_object_taxonomies(!empty($this->loop_args['post_type']) ? $this->loop_args['post_type'] : get_post_types(array('public' => false, 'name' => 'attachment'), 'names', 'NOT'));
        }
        return $this->taxonomies;
    }
    protected function getLoop($loop) {

        list($this->loop_args, $this->query)  = vc_build_loop_query($loop, get_the_ID());
    }
    protected function spanClass($grid_columns_count) {
        $teaser_width = '';
        switch ($grid_columns_count) {
            case '1' :
                $teaser_width = 'vc_span12';
                break;
            case '2' :
                $teaser_width = 'vc_span6';
                break;
            case '3' :
                $teaser_width = 'vc_span4';
                break;
            case '4' :
                $teaser_width = 'vc_span3';
                break;
            case '5':
                $teaser_width = 'vc_span10';
                break;
            case '6' :
                $teaser_width = 'vc_span2';
                break;
        }
        //return $teaser_width;
        $custom = get_custom_column_class($teaser_width);
        return $custom ? $custom : $teaser_width;
    }
    protected function getMainCssClass($filter) {
        return 'wpb_'.($filter==='yes' ? 'filtered_' : '').'grid';
    }
    protected function getFilterCategories() {
        return get_terms($this->getTaxonomies(), array(
        'orderby' => 'name',
        'include' => implode(',', $this->filter_categories)
        ));
    }
    protected function getPostThumbnail($post_id, $grid_thumb_size) {
        return  wpb_getImageBySize(array( 'post_id' => $post_id, 'thumb_size' => $grid_thumb_size ));
    }
    protected function getPostContent() {
        $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
        return wpautop($content);
    }
    protected function getPostExcerpt() {
        $content = apply_filters('the_excerpt', get_the_excerpt());
        return wpautop($content);
    }
    protected function getLinked($post, $content, $type, $css_class) {
        $output = '';
        if($type === 'link_post') {
            $url = get_permalink($post->id);
            $title =  sprintf( esc_attr__( 'Permalink to %s', "js_composer" ), $post->title_attribute);
            $output .= '<a href="'.$url.'" class="'.$css_class.'"'.$this->link_target.' title="'.$title.'">'.$content.'</a>';
        } elseif($type === 'link_image' && isset($post->image_link) && !empty($post->image_link)) {
            $this->loadPrettyPhoto();
            $output .= '<a href="'.$post->image_link.'" class="'.$css_class.' prettyphoto"'.$this->link_target.' title="'.$post->title_attribute.'">'.$content.'</a>';
        } else {
            $output .= $content;
        }
        return $output;
    }
    protected function loadPrettyPhoto() {
        if(self::$pretty_photo_loaded!==true) {
            wp_enqueue_script( 'prettyphoto' );
            wp_enqueue_style( 'prettyphoto' );
            self::$pretty_photo_loaded = true;
        }
    }
    protected function setLinkTarget($grid_link_target = '') {
        $this->link_target = $grid_link_target=='_blank' ? ' target="_blank"' : '';
    }
    protected function findBlockTemplate() {
        $template_path = $this->block_template_dir_name.'/'.$this->block_template_filename;
        // Check template path in shortcode's mapping settings
        if(!empty($this->settings['html_template']) && is_file($this->settings('html_template').$template_path)) {
            return $this->settings['html_template'].$template_path;
        }
        // Check template in theme directory
        $user_template = WPBakeryVisualComposer::getUserTemplate($template_path);

        if(is_file($user_template)) {
            return $user_template;
        }
        // Check default place
        $default_dir = WPBakeryVisualComposer::defaultTemplatesDIR();
        if(is_file($default_dir.$template_path)) {
            return $default_dir.$template_path;
        }
        return $template_path;
    }
    protected function getBlockTemplate() {
        if(!isset($this->block_template_path)) {
            $this->block_template_path = $this->findBlockTemplate();
        }
        return $this->block_template_path;
    }
}