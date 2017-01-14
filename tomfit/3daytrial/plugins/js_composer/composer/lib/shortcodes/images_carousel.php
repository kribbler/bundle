<?php
class WPBakeryShortCode_VC_images_carousel extends WPBakeryShortCode_VC_gallery {
    protected static $carousel_index = 1;
    public function __construct($settings) {
        parent::__construct($settings);
        $this->addAction('wp_enqueue_scripts', 'jsCssScripts');
    }

    public function jsCssScripts() {
        // wp_register_script('vc_bxslider', WPBakeryVisualComposer::getInstance()->assetURL('lib/bxslider-4/jquery.bxslider.min.js'));
        // wp_register_style('vc_bxslider_css', WPBakeryVisualComposer::getInstance()->assetURL('lib/bxslider-4/jquery.bxslider.css'));
        // wp_register_script('vc_swiper', WPBakeryVisualComposer::getInstance()->assetURL('lib/swiper/dist/idangerous.swiper-2.2.js'), array(), time());
        // wp_register_style('vc_swiper_css', WPBakeryVisualComposer::getInstance()->assetURL('lib/swiper/dist/idangerous.swiper.css'));
        wp_register_script('vc_transition_bootstrap_js', WPBakeryVisualComposer::getInstance()->assetURL('lib/vc_carousel/js/transition.js'), array(), time());
        wp_register_script('vc_carousel_js', WPBakeryVisualComposer::getInstance()->assetURL('lib/vc_carousel/js/vc_carousel.js'), array('vc_transition_bootstrap_js'), time());
        wp_register_style('vc_carousel_css', WPBakeryVisualComposer::getInstance()->assetURL('lib/vc_carousel/css/vc_carousel.css'));
        // try bootstap http://jsfiddle.net/HHsxc/2/
    }
    public static function getCarouselIndex(){
        return self::$carousel_index++.'-'.time();
    }
    protected function getSliderWidth($size) {
        global  $_wp_additional_image_sizes;
        $width = '100%';
        if(in_array($size, get_intermediate_image_sizes())) {
            if( in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ){
                $width = get_option( $size . '_size_w' ).'px';
            } else {
                if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $size ] ) )
                    $width = $_wp_additional_image_sizes[ $size ]['width'].'px';
            }
        } else {
            preg_match_all('/\d+/', $size, $matches);
            if(count($matches[0]) > 1) {
                $width = $matches[0][0].'px';
            }
        }
        return $width;
    }
}