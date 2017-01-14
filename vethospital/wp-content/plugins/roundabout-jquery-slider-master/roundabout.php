<?php 
/* Plugin Name: RoundAbout JQuery Slider
Plugin URI: http://www.digitechwebdesignaustin.com/roundabout-jquery-slider-wordpress-plugin/
Description: This plugin allows you to insert a standard version of the Roundabout jQuery rotating slider into any page or post using a shortcode. <a href="http://www.digitechwebdesignaustin.com/roundabout-jquery-slider-wordpress-plugin/">Installation Instructions</a>
Author: Darryl Stevens
Version: 2.1
Author URI: http://www.digitechwebdesignaustin.com/about-us/
*/

error_reporting(0);

add_action('admin_init', 'editor_admin_initxx');
add_action('admin_head', 'editor_admin_headxx');
function my_scripts_methodbb() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_methodbb');

function editor_admin_initxx() {
wp_enqueue_script('word-count');
wp_enqueue_script('post');
wp_enqueue_script('editor');
wp_enqueue_script('media-upload');
}

function delete_round_about() {
mysql_query("DROP TABLE `wp_roundabout`");
mysql_query("DROP TABLE `wp_roundabout_cats`");
mysql_query("DROP TABLE `wp_roundabout_settings`");
}

register_deactivation_hook(__FILE__, 'delete_round_about');
global $wpdb;
 $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_roundabout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(5000) DEFAULT NULL,
  `content` varchar(5000) DEFAULT NULL,
  `cat` varchar(5000) DEFAULT NULL,
  `image` varchar(5000) DEFAULT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11");

 $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_roundabout_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5");

 $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_roundabout_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` varchar(5000) DEFAULT NULL,
  `width` varchar(5000) DEFAULT NULL,
  `height` varchar(5000) DEFAULT NULL,
  `bgcolor` varchar(5000) DEFAULT NULL,
  `title_color` varchar(5000) DEFAULT NULL,
  `title_font` varchar(5000) DEFAULT NULL,
  `title_font_size` varchar(50) NOT NULL,
  `title_bg` varchar(5000) DEFAULT NULL,
  `para_color` varchar(5000) DEFAULT NULL,
  `para_font` varchar(5000) DEFAULT NULL,
  `para_font_size` varchar(50) DEFAULT NULL,
  `para_bg` varchar(5000) DEFAULT NULL,
  `opacity` varchar(5000) DEFAULT '0.5',
   `credit` varchar(5000) DEFAULT 'on',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3");

 $wpdb->query("ALTER TABLE `wp_roundabout` ADD `order` INT NOT NULL");

 $wpdb->query("ALTER TABLE `wp_roundabout_settings` ADD `opacity` varchar(5000) DEFAULT '0.5'");

function editor_admin_headxx() {
wp_tiny_mce();
}
wp_register_script( 'roundabout2', plugins_url( '/jquery.roundabout2.js', __FILE__ ), array( 'jquery' ) );
wp_enqueue_script('roundabout2');  
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
function include_setting_page(){
include('settings.php');
}

function roundabout_admin_actions() {  
//add_options_page("Roundabout Settings", "Roundabout Settings", 1, "settings.php", "include_setting_page");  
add_menu_page('WP RoundAbout', 'WP RoundAbout',4,'settings.php', 'include_setting_page',get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/icon.png ',400); 
}  
  
function roundabout_code($atts) {
extract(shortcode_atts(array(
"slider_id" => 'slider_id'
), $atts));

$settings=mysql_fetch_assoc(mysql_query("SELECT * FROM `wp_roundabout_settings` WHERE `slider_id`='$slider_id'"));

$width=$settings[width];
$height=$settings[height];

$lessw=$width-30;
$lessh=$height-30;
$maxw=$width+250;
$printer = '';
$sql="SELECT * FROM `wp_roundabout` WHERE `cat`='$slider_id' order by `order` ASC";
$res=mysql_query($sql);
$num=mysql_num_rows($res);
$time=date("l-h-i-s");
$printer=$printer.'
<link href="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/demos.css" rel="stylesheet" />
<style>
#'.$time.'{
list-style: none;
padding: 0;
margin: 0 auto;
width: 42em;
height: 24em;
width: '.$maxw.'px !important;
height: '.$height.'px !important;
}

#'.$time.' li {
width: '.$width.'px;
height: '.$height.'px;
background-color: #ccc;
background-color: '.$settings[bgcolor].' !important;
text-align: center;
cursor: pointer;
background-size:100%;
margin:0 !important;
padding:0 !important;
opacity: 1 !important;
}

#'.$time.' li h2{
background:'.$settings[title_bg].';
color:'.$settings[title_color].';
font-family:'.$settings[title_font].';
font-size:'.$settings[title_font_size].'px;
margin:0;
position: absolute;
width: 100%;
opacity:0.7;
padding:4px 0;
-moz-transition:opacity 0.5s linear;
}

#'.$time.' li img{
width: 100%;
height: 100%;
opacity: '.$settings[opacity].';
-moz-transition:opacity 0.5s linear;
}

#'.$time.' li span{
background:'.$settings[para_bg].';
color:'.$settings[para_color].';
font-family:'.$settings[para_font].';
font-size:'.$settings[para_font_size].'px;
display:block;
position: absolute;
width: 100%;
bottom:0;
opacity:0.7;
padding:4px 0;
-moz-transition:opacity 0.5s linear;
-webkit-transition:opacity 0.5s linear;
-ms-transition:opacity 0.5s linear;
-o-transition:opacity 0.5s linear;
-khtml-transition:opacity 0.5s linear;
}

#'.$time.' li.roundabout-in-focus {
cursor: default;
}

#'.$time.' .roundabout-in-focus img{
opacity:1 !important;
}

.authcredits{
    font: 11px Verdana;
    padding: 10px;
    position: absolute;
    left: -100px;
    z-index: 1000;
}

</style>
<ul id="'.$time.'">';
$i=0;

while($i<$num){
$image=mysql_result($res, $i, 'image');
$title=mysql_result($res, $i, 'title');
$descr=mysql_result($res, $i, 'content');
if($title==''){$ttext='';} else {$ttext='<h2>'.$title.'</h2>';}
if($descr==''){$stext='';} else {$stext='<span>'.$descr.'</span>';}
$printer=$printer.'<li>'.$ttext.''.$stext.'<img src="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/timthumb.php?src='.$image.'&w='.$width.'&h='.$height.'&zc=1&q=100"></li>';

++$i;
}

$printer=$printer.'</ul>
<script>
jQuery(document).ready(function() {
jQuery(\'#'.$time.'\').roundabout();';



$printer=$printer.'});
</script>
';

return $printer;
}


function show_roundabout_slider($slider_id) {

$settings=mysql_fetch_assoc(mysql_query("SELECT * FROM `wp_roundabout_settings` WHERE `slider_id`='$slider_id'"));

$width=$settings[width];
$height=$settings[height];

$lessw=$width-30;
$lessh=$height-30;
$maxw=$width+250;
$printer = '';
$sql="SELECT * FROM `wp_roundabout` WHERE `cat`='$slider_id' order by `order` ASC";
$res=mysql_query($sql);
$num=mysql_num_rows($res);
$time=date("l-h-i-s");
$printer=$printer.'
<link href="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/demos.css" rel="stylesheet" />
<style>
#'.$time.'{
list-style: none;
padding: 0;
margin: 0 auto;
width: 42em;
height: 24em;
width: '.$maxw.'px !important;
height: '.$height.'px !important;
}

#'.$time.' li {
width: '.$width.'px;
height: '.$height.'px;
background-color: #ccc;
background-color: '.$settings[bgcolor].' !important;
text-align: center;
cursor: pointer;
background-size:100%;
margin:0 !important;
padding:0 !important;
opacity: 1 !important;
}

#'.$time.' li h2{
background:'.$settings[title_bg].';
color:'.$settings[title_color].';
font-family:'.$settings[title_font].';
font-size:'.$settings[title_font_size].'px;
margin:0;
position: absolute;
width: 100%;
opacity:0.7;
padding:4px 0;
-moz-transition:opacity 0.5s linear;
}

#'.$time.' li img{
width: 100%;
height: 100%;
opacity: '.$settings[opacity].';
-moz-transition:opacity 0.5s linear;
}

#'.$time.' li span{
background:'.$settings[para_bg].';
color:'.$settings[para_color].';
font-family:'.$settings[para_font].';
font-size:'.$settings[para_font_size].'px;
display:block;
position: absolute;
width: 100%;
bottom:0;
opacity:0.7;
padding:4px 0;
-moz-transition:opacity 0.5s linear;
-webkit-transition:opacity 0.5s linear;
-ms-transition:opacity 0.5s linear;
-o-transition:opacity 0.5s linear;
-khtml-transition:opacity 0.5s linear;
}

#'.$time.' li.roundabout-in-focus {
cursor: default;
}

#'.$time.' .roundabout-in-focus img{
opacity:1 !important;
}

.authcredits{
    font: 11px Verdana;
    padding: 10px;
    position: absolute;
    left: -100px;
    z-index: 1000;
}

</style>
<ul id="'.$time.'">';
$i=0;

while($i<$num){
$image=mysql_result($res, $i, 'image');
$title=mysql_result($res, $i, 'title');
$descr=mysql_result($res, $i, 'content');
if($title==''){$ttext='';} else {$ttext='<h2>'.$title.'</h2>';}
if($descr==''){$stext='';} else {$stext='<span>'.$descr.'</span>';}
$printer=$printer.'<li>'.$ttext.''.$stext.'<img src="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/timthumb.php?src='.$image.'&w='.$width.'&h='.$height.'&zc=1&q=100"></li>';

++$i;
}

$printer=$printer.'</ul>
<script>
jQuery(document).ready(function() {
jQuery(\'#'.$time.'\').roundabout();';



$printer=$printer.'});
</script>
';

return $printer;
}


function footer_linking_data(){

$settingsxx=mysql_fetch_assoc(mysql_query("SELECT * FROM `wp_roundabout_settings`limit 1"));

//echo '<p>This is inserted at the bottom</p>';
}


add_action('wp_footer', 'footer_linking_data',1);

add_action('admin_menu', 'roundabout_admin_actions');

add_shortcode("roundabout", "roundabout_code");
?>