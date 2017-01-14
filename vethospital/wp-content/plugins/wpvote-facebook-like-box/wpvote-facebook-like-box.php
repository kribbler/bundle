<?php
/*
 * Plugin Name: WPvote Facebook Like Box
 * Version: 2.0
 * Plugin URI: http://www.wpvote.me/facebok-like-box-widget-wordpress
 * Description:WPvote Facebook Like Box widget is a social plugin that enables Facebook Page owners to attract and gain Likes from their own website. The Like Box enables users to: see how many users already like this page, and which of their friends like it too, read recent posts from the page and Like the page with one click, without needing to visit the page.
 * Author: WPvote.me
 * Author URI: http://www.wpvote.me/facebok-like-box-widget-wordpress
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
class WPvoteFacebookLikeBoxWidget extends WP_Widget {


    /** constructor  */
    function WPvoteFacebookLikeBoxWidget() {
        $widget_ops = array('classname' => 'widget_FacebookLikeBox', 'description' =>  "Facebook Like Box Widget is a social plugin that enables Facebook Page owners to attract and gain Likes from their own website." );
		$this->WP_Widget('FacebookLikeBox', 'WPvote Facebook Like Box', $widget_ops,'');
    }

    /** @see WP_Widget::widget*/
    function widget($args, $instance) {
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $FanPageURL   = empty($instance['fanpageurl']) ? 'http://www.facebook.com/platform' : $instance['fanpageurl'];
        $langlocale   = empty($instance['langlocale']) ? 'en_US' : $instance['langlocale'];
        $width        = empty($instance['width']) ? '275' : $instance['width'];
		$height       = empty($instance['height']) ? '345' : $instance['height'];
        $colorScheme  = empty($instance['colorScheme']) ? 'light' : $instance['colorScheme'];
        $showFaces    = empty($instance['showFaces']) ? 'true' : $instance['showFaces'];
        $frameBorder  = empty($instance['frameBorder']) ? 'true' : $instance['frameBorder'];
        $streams      = empty($instance['streams']) ? 'true' : $instance['streams'];
        $header       = empty($instance['header']) ? 'true' : $instance['header'];
        $credit       = empty($instance['credit']) ? 'true' : $instance['credit'];

        if ( is_home() ) {
        if ($credit=='true'){$sajat='<div style=" font-size:9px"><center><a href="http://www.wpvote.me" target="_blank">Wordpress plugins</a></center></div>';}else{$sajat='';}
        }

        $like_box_iframe = '<center><iframe src="http://www.facebook.com/plugins/likebox.php?href='.rawurlencode($FanPageURL).'&amp;width='.$width.'&amp;colorscheme='.$colorScheme.'&amp;show_faces='.$showFaces.'&amp;show_border='.$frameBorder.'&amp;stream='.$streams.'&amp;header='.$header.'&amp;height='.$height.'&amp;locale='.$langlocale.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;" allowTransparency="true"></iframe></center>';
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title;
                        echo $like_box_iframe . $sajat;
                        echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update  */
    function updaupdate($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['fanpageurl'] = strip_tags($new_instance['fanpageurl']);
        $instance['langlocale'] = strip_tags($new_instance['langlocale']);
        $instance['width'] = strip_tags(stripslashes($new_instance['width']));
        $instance['height'] = strip_tags(stripslashes($new_instance['height']));
        $instance['streams'] = strip_tags(stripslashes($new_instance['streams']));
        $instance['header'] = strip_tags(stripslashes($new_instance['header']));
        $instance['frameBorder'] = strip_tags(stripslashes($new_instance['frameBorder']));
        $instance['showFaces'] = strip_tags(stripslashes($new_instance['showFaces']));
        $instance['colorScheme'] = strip_tags(stripslashes($new_instance['colorScheme']));
        $instance['credit'] = strip_tags(stripslashes($new_instance['credit']));
        return $instance;
    }

    /** @see WP_Widget::form  */
    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array('title'=>'',  'height'=>'345', 'width'=>'275','fanpageurl'=>'http://www.facebook.com/platform','langlocale'=>'en_US','streams'=>'true','header'=>'true','frameBorder'=>'true','showFaces'=>'true','colorScheme'=>'light','credit'=>'true') );
        $title 		  = esc_attr($instance['title']);
        $pageurl	  = esc_attr($instance['fanpageurl']);
        $langlocale   = esc_attr($instance['langlocale']);
        $width        = esc_attr($instance['width']);
        $height       = esc_attr($instance['height']);
        $streams      = esc_attr($instance['streams']);
        $header       = esc_attr($instance['header']);
        $frameBorder  = esc_attr($instance['frameBorder']);
        $showFaces    = esc_attr($instance['showFaces']);
        $colorScheme  = esc_attr($instance['colorScheme']);
        $credit       = esc_attr($instance['credit']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p style="text-align:left; color:#2680AA;"><b>WPvote Like Box Setting</b></p><hr style=" border:#2680AA 1px solid;">
		<p>
          <label for="<?php echo $this->get_field_id('fanpageurl'); ?>"><?php _e('Facebook page URL'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('fanpageurl'); ?>" name="<?php echo $this->get_field_name('fanpageurl'); ?>" type="text" value="<?php echo $pageurl; ?>" />
          <br /><small>(http://facebook.com/yourpagename )</small>
        </p>

        <p>
        <?php
        echo '<p style="text-align:left;"><label for="' . $this->get_field_name('langlocale') . '">Set Language locale: <select name="' . $this->get_field_name('langlocale')  . '" id="' . $this->get_field_id('langlocale')  . '">"';
        ?>
		<option value="af_ZA" <?php if ($langlocale == 'af_ZA') echo 'selected="af_ZA"'; ?> >Afrikaans</option>
        <option value="ar_AR" <?php if ($langlocale == 'ar_AR') echo 'selected="ar_AR"'; ?> >Arabic</option>
		<option value="az_AZ" <?php if ($langlocale == 'az_AZ') echo 'selected="az_AZ"'; ?> >Azerbaijani</option>
		<option value="be_BY" <?php if ($langlocale == 'be_BY') echo 'selected="be_BY"'; ?> >Belarusian</option>
		<option value="bg_BG" <?php if ($langlocale == 'bg_BG') echo 'selected="bg_BG"'; ?> >Bulgarian</option>
		<option value="bn_IN" <?php if ($langlocale == 'bn_IN') echo 'selected="bn_IN"'; ?> >Bengali</option>
		<option value="bs_BA" <?php if ($langlocale == 'bs_BA') echo 'selected="bs_BA"'; ?> >Bosnian</option>
		<option value="ca_ES" <?php if ($langlocale == 'ca_ES') echo 'selected="ca_ES"'; ?> >Catalan</option>
		<option value="cs_CZ" <?php if ($langlocale == 'cs_CZ') echo 'selected="cs_CZ"'; ?> >Czech</option>
		<option value="cx_PH" <?php if ($langlocale == 'cx_PH') echo 'selected="cx_PH"'; ?> >Cebuano</option>
		<option value="cy_GB" <?php if ($langlocale == 'cy_GB') echo 'selected="cy_GB"'; ?> >Welsh</option>
		<option value="da_DK" <?php if ($langlocale == 'da_DK') echo 'selected="da_DK"'; ?> >Danish</option>
		<option value="de_DE" <?php if ($langlocale == 'de_DE') echo 'selected="de_DE"'; ?> >German</option>
		<option value="el_GR" <?php if ($langlocale == 'el_GR') echo 'selected="el_GR"'; ?> >Greek</option>
		<option value="en_GB" <?php if ($langlocale == 'en_GB') echo 'selected="en_GB"'; ?> >English (UK)</option>
		<option value="en_PI" <?php if ($langlocale == 'en_PI') echo 'selected="en_PI"'; ?> >English (Pirate)</option>
		<option value="en_UD" <?php if ($langlocale == 'en_UD') echo 'selected="en_UD"'; ?> >English (Upside Down)</option>
		<option value="en_US" <?php if ($langlocale == 'en_US') echo 'selected="en_US"'; ?> >English (US) </option>
		<option value="eo_EO" <?php if ($langlocale == 'eo_EO') echo 'selected="eo_EO"'; ?> >Esperanto</option>
		<option value="es_ES" <?php if ($langlocale == 'es_ES') echo 'selected="es_ES"'; ?> >Spanish (Spain)</option>
		<option value="es_LA" <?php if ($langlocale == 'es_LA') echo 'selected="es_LA"'; ?> >Spanish</option>
		<option value="et_EE" <?php if ($langlocale == 'et_EE') echo 'selected="et_EE"'; ?> >Estonian</option>
		<option value="eu_ES" <?php if ($langlocale == 'eu_ES') echo 'selected="eu_ES"'; ?> >Basque</option>
		<option value="fa_IR" <?php if ($langlocale == 'fa_IR') echo 'selected="fa_IR"'; ?> >Persian</option>
		<option value="fb_LT" <?php if ($langlocale == 'fb_LT') echo 'selected="fb_LT"'; ?> >Leet Speak</option>
        <option value="fi_FI" <?php if ($langlocale == 'fi_FI') echo 'selected="fi_FI"'; ?> >Finnish</option>
		<option value="fo_FO" <?php if ($langlocale == 'fo_FO') echo 'selected="fo_FO"'; ?> >Faroese</option>
		<option value="pl_PL" <?php if ($langlocale == 'pl_PL') echo 'selected="pl_PL"'; ?> >Polish</option>
		<option value="fr_CA" <?php if ($langlocale == 'fr_CA') echo 'selected="fr_CA"'; ?> >French (Canada)</option>
		<option value="fr_FR" <?php if ($langlocale == 'fr_FR') echo 'selected="fr_FR"'; ?> >French (France)</option>
		<option value="fy_NL" <?php if ($langlocale == 'fy_NL') echo 'selected="fy_NL"'; ?> >Frisian</option>
		<option value="ga_IE" <?php if ($langlocale == 'ga_IE') echo 'selected="ga_IE"'; ?> >Irish</option>
		<option value="gl_ES" <?php if ($langlocale == 'gl_ES') echo 'selected="gl_ES"'; ?> >Galician</option>
		<option value="gn_PY" <?php if ($langlocale == 'gn_PY') echo 'selected="gn_PY"'; ?> >Guarani</option>
		<option value="he_IL" <?php if ($langlocale == 'he_IL') echo 'selected="he_IL"'; ?> >Hebrew</option>
		<option value="hi_IN" <?php if ($langlocale == 'hi_IN') echo 'selected="hi_IN"'; ?> >Hindi</option>
		<option value="hr_HR" <?php if ($langlocale == 'hr_HR') echo 'selected="hr_HR"'; ?> >Croatian</option>
		<option value="hu_HU" <?php if ($langlocale == 'hu_HU') echo 'selected="hu_HU"'; ?> >Hungarian</option>
        <option value="hy_AM" <?php if ($langlocale == 'hy_AM') echo 'selected="hy_AM"'; ?> >Armenian</option>
		<option value="id_ID" <?php if ($langlocale == 'id_ID') echo 'selected="id_ID"'; ?> >Indonesian</option>
        <option value="is_IS" <?php if ($langlocale == 'is_IS') echo 'selected="is_IS"'; ?> >Icelandic</option>
        <option value="it_IT" <?php if ($langlocale == 'it_IT') echo 'selected="it_IT"'; ?> >Italian</option>
		<option value="ja_JP" <?php if ($langlocale == 'ja_JP') echo 'selected="ja_JP"'; ?> >Japanese</option>
		<option value="ka_GE" <?php if ($langlocale == 'ka_GE') echo 'selected="ka_GE"'; ?> >Georgian</option>
		<option value="hy_AM" <?php if ($langlocale == 'hy_AM') echo 'selected="hy_AM"'; ?> >Armenian</option>
		<option value="km_KH" <?php if ($langlocale == 'km_KH') echo 'selected="km_KH"'; ?> >Khmer</option>
		<option value="ko_KR" <?php if ($langlocale == 'ko_KR') echo 'selected="ko_KR"'; ?> >Korean</option>
		<option value="ku_TR" <?php if ($langlocale == 'ku_TR') echo 'selected="ku_TR"'; ?> >Kurdish</option>
		<option value="la_VA" <?php if ($langlocale == 'la_VA') echo 'selected="la_VA"'; ?> >Latin</option>
		<option value="lt_LT" <?php if ($langlocale == 'lt_LT') echo 'selected="lt_LT"'; ?> >Lithuanian</option>
		<option value="lv_LV" <?php if ($langlocale == 'lv_LV') echo 'selected="lv_LV"'; ?> >Latvian</option>
		<option value="mk_MK" <?php if ($langlocale == 'mk_MK') echo 'selected="mk_MK"'; ?> >Macedonian</option>
		<option value="ml_IN" <?php if ($langlocale == 'ml_IN') echo 'selected="ml_IN"'; ?> >Malayalam</option>
		<option value="ms_MY" <?php if ($langlocale == 'ms_MY') echo 'selected="ms_MY"'; ?> >Malay</option>
		<option value="nb_NO" <?php if ($langlocale == 'nb_NO') echo 'selected="nb_NO"'; ?> >Norwegian (bokmal)</option>
		<option value="ne_NP" <?php if ($langlocale == 'ne_NP') echo 'selected="ne_NP"'; ?> >Nepali</option>
		<option value="nl_NL" <?php if ($langlocale == 'nl_NL') echo 'selected="nl_NL"'; ?> >Dutch</option>
		<option value="nn_NO" <?php if ($langlocale == 'nn_NO') echo 'selected="nn_NO"'; ?> >Norwegian (nynorsk)</option>
		<option value="pa_IN" <?php if ($langlocale == 'pa_IN') echo 'selected="pa_IN"'; ?> >Punjabi</option>
		<option value="pl_PL" <?php if ($langlocale == 'pl_PL') echo 'selected="pl_PL"'; ?> >Polish</option>
		<option value="ps_AF" <?php if ($langlocale == 'ps_AF') echo 'selected="ps_AF"'; ?> >Pashto</option>
        <option value="pt_BR" <?php if ($langlocale == 'pt_BR') echo 'selected="pt_BR"'; ?> >Portuguese (Brazil)</option>
		<option value="pt_PT" <?php if ($langlocale == 'pt_PT') echo 'selected="pt_PT"'; ?> >Portuguese (Portugal)</option>
        <option value="ro_RO" <?php if ($langlocale == 'ro_RO') echo 'selected="ro_RO"'; ?> >Romanian</option>
        <option value="ru_RU" <?php if ($langlocale == 'ru_RU') echo 'selected="ru_RU"'; ?> >Russian</option>
		<option value="sk_SK" <?php if ($langlocale == 'sk_SK') echo 'selected="sk_SK"'; ?> >Slovak</option>
		<option value="sl_SI" <?php if ($langlocale == 'sl_SI') echo 'selected="sl_SI"'; ?> >Slovenian</option>
		<option value="sq_AL" <?php if ($langlocale == 'sq_AL') echo 'selected="sq_AL"'; ?> >Albanian</option>
		<option value="sr_RS" <?php if ($langlocale == 'sr_RS') echo 'selected="sr_RS"'; ?> >Serbian</option>
		<option value="sv_SE" <?php if ($langlocale == 'sv_SE') echo 'selected="sv_SE"'; ?> >Swedish</option>
		<option value="sw_KE" <?php if ($langlocale == 'sw_KE') echo 'selected="sw_KE"'; ?> >Swahili</option>
		<option value="ta_IN" <?php if ($langlocale == 'ta_IN') echo 'selected="ta_IN"'; ?> >Tamil</option>
		<option value="te_IN" <?php if ($langlocale == 'te_IN') echo 'selected="te_IN"'; ?> >Telugu</option>
		<option value="th_TH" <?php if ($langlocale == 'th_TH') echo 'selected="th_TH"'; ?> >Thai </option>
		<option value="tl_PH" <?php if ($langlocale == 'tl_PH') echo 'selected="tl_PH"'; ?> >Filipino</option>
		<option value="tr_TR" <?php if ($langlocale == 'tr_TR') echo 'selected="tr_TR"'; ?> >Turkish</option>
		<option value="uk_UA" <?php if ($langlocale == 'uk_UA') echo 'selected="uk_UA"'; ?> >Ukrainian</option>
		<option value="ur_PK" <?php if ($langlocale == 'ur_PK') echo 'selected="ur_PK"'; ?> >Urdu</option>
		<option value="vi_VN" <?php if ($langlocale == 'vi_VN') echo 'selected="vi_VN"'; ?> >Vietnamese</option>
		<option value="zh_CN" <?php if ($langlocale == 'zh_CN') echo 'selected="zh_CN"'; ?> >Simplified Chinese (China)</option>
		<option value="zh_HK" <?php if ($langlocale == 'zh_HK') echo 'selected="zh_HK"'; ?> >Traditional Chinese (Hong Kong)</option>
		<option value="zh_TW" <?php if ($langlocale == 'zh_TW') echo 'selected="zh_TW"'; ?> >Traditional Chinese (Taiwan) </option>
        </select></label><br /><small>(Select display language for your like box)</small>
        </p>
              <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Like box width:'); ?></label>
           <input class="widefat" style="width:100px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
          <br /><small>(Set like box width)</small>
        </p>
      <p>
          <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Like box height:'); ?></label>
           <input class="widefat" style="width:100px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
          <br /><small>(Set like box height)</small>
        </p>
        <p>
  <?php
        echo '<p style="text-align:left;"><label for="' . $this->get_field_name('frameBorderr') . '">Facebok like box border: <select name="' . $this->get_field_name('frameBorder')  . '" id="' . $this->get_field_id('frameBorder')  . '">"';
?>
		<option value="true" <?php if ($frameBorder == 'true') echo 'selected="true"'; ?> >Yes</option>
		<option value="false" <?php if ($frameBorder == 'false') echo 'selected="false"'; ?> >No</option>
<?php
		echo '</select></label><br /><small>(Show or hide facebook like box border.)</small></p>';
        echo '<p style="text-align:left;"><label for="' . $this->get_field_name('header') . '">Facebok header: <select name="' . $this->get_field_name('header')  . '" id="' . $this->get_field_id('header')  . '">"';
?>
		<option value="true" <?php if ($header == 'true') echo 'selected="true"'; ?> >Yes</option>
		<option value="false" <?php if ($header == 'false') echo 'selected="false"'; ?> >No</option>
<?php
		echo '</select></label><br /><small>(Show or hide facebook header.)</small></p>';

        echo '<p style="text-align:left;"><label for="' . $this->get_field_name('showFaces') . '">Show faces: <select name="' . $this->get_field_name('showFaces')  . '" id="' . $this->get_field_id('showFaces')  . '">"';
?>
		<option value="true" <?php if ($showFaces == 'true') echo 'selected="true"'; ?> >Yes</option>
		<option value="false" <?php if ($showFaces == 'false') echo 'selected="false"'; ?> >No</option>
<?php
		echo '</select></label><br /><small>(Show or hide facebook like box user faces.)</small></p>';
                echo '<p style="text-align:left;"><label for="' . $this->get_field_name('colorScheme') . '">Change theme: <select name="' . $this->get_field_name('colorScheme')  . '" id="' . $this->get_field_id('colorScheme')  . '">"';
?>
		<option value="light" <?php if ($colorScheme == 'light') echo 'selected="light"'; ?> >Light</option>
		<option value="dark" <?php if ($colorScheme == 'dark') echo 'selected="dark"'; ?> >Dark</option>
<?php
		echo '</select></label><br /><small>(Chnage color scheme, light or dark.)</small></p>';



         echo '<p style="text-align:left;"><label for="' . $this->get_field_name('streams') . '">Streams: <select name="' . $this->get_field_name('streams')  . '" id="' . $this->get_field_id('streams')  . '">"';
?>
		<option value="true" <?php if ($streams == 'true') echo 'selected="true"'; ?> >Yes</option>
		<option value="false" <?php if ($streams == 'false') echo 'selected="false"'; ?> >No</option>
<?php
		echo '</select></label><br /><small>(Show or hide streams.)</small></p><hr style=" border:#2680AA 1px solid;">';

         echo '<p style="text-align:left;"><label for="' . $this->get_field_name('streams') . '">Credit: <select name="' . $this->get_field_name('credit')  . '" id="' . $this->get_field_id('credit')  . '">"';
?>
		<option value="true" <?php if ($credit == 'true') echo 'selected="true"'; ?> >Yes</option>
		<option value="false" <?php if ($credit == 'false') echo 'selected="false"'; ?> >No</option>
<?php
		echo '</select></label><br /><small>(Show or hide credit.)</small></p>';

    }


} // end class WPvoteFacebookLikeBoxWidget
add_action('widgets_init', create_function('', 'return register_widget("WPvoteFacebookLikeBoxWidget");'));
?>
