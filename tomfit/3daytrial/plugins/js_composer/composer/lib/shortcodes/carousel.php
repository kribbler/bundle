<?php

class WPBakeryShortCode_Vc_Carousel extends WPBakeryShortCode_VC_Posts_Grid {
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
        return self::$carousel_index++;
    }

}