<script type="text/javascript">var switchTo5x=true;</script>
<script language="JavaScript">
jQuery(document).ready(function() {
jQuery('#upload_image_button').click(function() {
formfield = jQuery('#upload_image').attr('name');
tb_show('', 'media-upload.php?type=image&TB_iframe=true');
return false;
});

window.send_to_editor = function(html) {
imgurl = jQuery('img',html).attr('src');
jQuery('#upload_image').val(imgurl);
tb_remove();
}
});

function post_chk(){
document.bbb.submit();
}
</script>
<style type="text/css">
.slider-table{
width:95%;
margin:20px 0 40px 0;
border:1px solid grey;
padding:5px;
border-collapse:collapse;
}

.slider-table th{
background:#eee;
}

.slider-table input[type="text"], .slider-table input[type="password"]{
width:300px;
padding:5px;
}

.slider-table td,.slider-table th{
padding:5px;
text-align:center;
border-bottom:1px solid grey;
border-right:1px solid grey;
text-transform:capitalize;
}

.slider-table a{
text-decoration:none;
}

.zlogo{
display: block;
float: right;
margin: 20px 60px 20px 20px;
}

.zlogo img{
border:0;
width:250px;
}

.media-s{
text-align:right;
margin: 20px 60px 20px 20px;
}

.extra-op{
padding-right:20px;
}

.media-s li{
display:inline-block;
list-style:none;
}

.media-s li a{
text-decoration:none;
height:32px;
width:32px;
background-repeat:no-repeat;
background-position:center center;
display:block;
}
</style>
<?php if(isset($_GET['images'])){

if(isset($_POST['heading'])){

$title=htmlentities($_POST['heading']);
$bg=$_POST['upload_image'];

mysql_query("INSERT INTO `wp_roundabout` (`id`, `title`, `content`, `cat`, `image`, `order`) 
VALUES (NULL, '$title', '$_POST[content]', '$_GET[images]', '$bg', '$_POST[image_order]')");

}

$sql="SELECT * FROM `wp_roundabout` WHERE `cat`='$_GET[images]' order by `order` ASC";
$res=mysql_query($sql);
$num=mysql_num_rows($res);
$i=0;
?>

<br /><br />
<?php
if(isset($_GET['del'])){
mysql_query("DELETE FROM `wp_roundabout` WHERE `id`='$_GET[del]'");
echo'<div class="update-nag">Slide Deleted. Redirecting . . .</div>
<script>document.location.href=\'options-general.php?page=settings.php&images='.$_GET[images].'\';</script>';
}
 ?>
 
<a href="options-general.php?page=settings.php"><input type="button" name="publishg" id="publishg" class="button-primary" value="Back to Sliders Panel"></a>
 
<form action="" method="post" name="newimage">
<table class="slider-table">
<tr><th colspan="2">Create New Slide</th></tr>
<tr><td>Slide Title</td><td style="text-align:center;"><input type="text" name="heading" /></td></tr>

<tr><td valign="top"><br /><br />Slide Caption</td><td>
<?php the_editor($content, $id = 'content', $prev_id = 'title', $media_buttons = true, $tab_index = 2); ?>
</td></tr>

<tr><td>Background</td><td>
<input id="upload_image" type="text" size="36" name="upload_image" value="" />
<input id="upload_image_button" type="button" value="upload Image" />
</td></tr>

<tr><td style="text-align:center;">Order</td><td>
<input id="image_order" type="text" size="36" name="image_order" value="" />
</td></tr>

<tr><td colspan="2" align="center"><input type="submit" value="Publish Slide" class="button-primary" id="publishg" name="publishg"> <input type="reset" value="Clear Form" class="button-primary" id="publishd" name="publishd"></td></tr>
</form>
<?php

if($num==0){
echo'<br /><br /><b>No images found. Please add some images to show in this slider.</b><br /><br />';
} else {
echo'<br /><br /><hr /><table  class="slider-table"><tr><th style="width:80px;">ORDER</th><th>TITLE</th><th style="width:100px;">PREVIEW</th><th width="180">OPTIONS</th></tr>';
while($i<$num){
$id=mysql_result($res, $i, 'id');
$name=mysql_result($res, $i, 'title');
$img=mysql_result($res, $i, 'image');
$order=mysql_result($res, $i, 'order');
echo'<tr><td>'.$order.'</td><td>'.$name.'</td><td><img src="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/timthumb.php?src='.$img.'&w=100&h=60" /></td><td>
<a href="options-general.php?page=settings.php&images='.$_GET[images].'&del='.$id.'"><input type="button" value="Delete" class="button-secondary action" /></a>
<a href="options-general.php?page=settings.php&image_edit='.$_GET[images].'&img='.$id.'"><input type="button" value="Edit Image" class="button-secondary action" /></a>
</td></tr>';
++$i;
}
echo'</table>';
}

} elseif(isset($_GET['setoptions'])){

if($_POST[formwidth]){
mysql_query("UPDATE `wp_roundabout_settings` SET `width` = '$_POST[formwidth]',
`height` = '$_POST[textfield2]',
`bgcolor` = '$_POST[textfield3]',
`title_color` = '$_POST[textfield4]',
`title_font` = '$_POST[textfield6]',
`title_font_size` = '$_POST[textfield5]',
`title_bg` = '$_POST[textfield7]',
`para_color` = '$_POST[textfield8]',
`para_font` = '$_POST[textfield10]',
`para_font_size` = '$_POST[textfield9]',
`para_bg` = '$_POST[textfield11]',
`opacity` = '$_POST[opacity]',
`credit` = '$_POST[credits]' WHERE `slider_id` ='$_GET[setoptions]'");
}

$opdata=mysql_fetch_assoc(mysql_query("SELECT * FROM `wp_roundabout_settings` WHERE `slider_id`='$_GET[setoptions]'"));
echo'<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/picker.js"></script>
<link href="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/picker.css" rel="stylesheet" />
';
?>

<br /><br />
<a href="options-general.php?page=settings.php"><input type="button" name="publishg" id="publishg" class="button-primary" value="Back to Sliders Panel"></a>

<h1>Options for slider at id=<?php echo $_GET['setoptions']; ?></h1>
<form name="formset" method="post" action="">
  <table style="width:500px" class="slider-table">
    <tr>
      <th colspan="2" align="center">Settings</th>
    </tr>
    <tr>
      <td width="130">Width</td>
      <td><label for="textfield"></label>
      <input type="text" name="formwidth" id="formwidth" value="<?php echo $opdata[width]; ?>"></td>
    </tr>
    <tr>
      <td>Height</td>
      <td><label for="textfield2"></label>
      <input type="text" name="textfield2" id="textfield2" value="<?php echo $opdata[height]; ?>"></td>
    </tr>
    <tr>
      <td>Slide Background</td>
      <td><label for="textfield3"></label>
      <input type="text" onclick="openPicker(this.id)" name="textfield3" id="textfield3" value="<?php echo $opdata[bgcolor]; ?>"></td>
    </tr>
    <tr>
      <td>title color</td>
      <td><label for="textfield4"></label>
      <input type="text" onclick="openPicker(this.id)" name="textfield4" id="textfield4" value="<?php echo $opdata[title_color]; ?>"><div id="color_picker_color2"></div></td>
    </tr>
    <tr>
      <td>title font size</td>
      <td><label for="textfield5"></label>
      <input type="text" name="textfield5" id="textfield5" value="<?php echo $opdata[title_font_size]; ?>"></td>
    </tr>
    <tr>
      <td>title font</td>
      <td><label for="textfield6"></label>
      <input type="text" name="textfield6" id="textfield6" value="<?php echo $opdata[title_font]; ?>"></td>
    </tr>
    <tr>
      <td>title background</td>
      <td><label for="textfield7"></label>
      <input onclick="openPicker(this.id)" type="text" name="textfield7" id="textfield7" value="<?php echo $opdata[title_bg]; ?>"><div id="color_picker_color3"></div></td>
    </tr>
    <tr>
      <td>content font color</td>
      <td><label for="textfield8"></label>
      <input onclick="openPicker(this.id)" type="text" name="textfield8" id="textfield8" value="<?php echo $opdata[para_color]; ?>"><div id="color_picker_color4"></div></td>
    </tr>
    <tr>
      <td>content font size</td>
      <td><input type="text" name="textfield9" id="textfield9" value="<?php echo $opdata[para_font]; ?>"></td>
    </tr>
    <tr>
      <td>content font</td>
      <td><input type="text" name="textfield10" id="textfield10" value="<?php echo $opdata[para_font_size]; ?>"></td>
    </tr>
    <tr>
      <td>content background</td>
      <td><input onclick="openPicker(this.id)" type="text" name="textfield11" id="textfield12" value="<?php echo $opdata[para_bg]; ?>"><div id="color_picker_color5"></div></td>
    </tr>
    <tr>
      <td>image opacity</td>
      <td><input type="text" name="opacity" id="opacity" value="<?php echo $opdata[opacity]; ?>"><div id="color_picker_color5"></div></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Submit"> 
      <input type="reset" name="button2" id="button2" value="Reset"></td>
    </tr>
  </table>
</form>

<?php
} elseif(isset($_GET['image_edit'])){

if(isset($_POST[textfield])){
mysql_query("UPDATE `wp_roundabout` SET `title` = '$_POST[textfield]', `content` = '$_POST[content]', `image` = '$_POST[upload_image]', `order` = '$_POST[image_order]' WHERE `id` ='$_GET[img]'");
}

$dataxx=mysql_fetch_assoc(mysql_query("SELECT * FROM `wp_roundabout` WHERE `id`='$_GET[img]'"));

?>
<br /><br />
<a href="options-general.php?page=settings.php"><input type="button" name="publishg" id="publishg" class="button-primary" value="Back to Sliders Panel"></a>
<a href="options-general.php?page=settings.php&images=<?php echo $GET[image_edit]; ?>"><input type="button" name="publishg" id="publishg" class="button-primary" value="Back to Images"></a>

<form name="form1" method="post" action="">
  <table  class="slider-table">
    <tr>
      <th colspan="2" align="center">Slide Properties</th>
    </tr>
    <tr>
      <td>Title</td>
      <td><label for="textfield"></label>
      <input type="text" value="<?php echo $dataxx['title']; ?>" name="textfield" id="textfield"></td>
    </tr>
    <tr>
      <td valign="top">Content</td>
      <td><label for="textfield2"></label>
        <label for="textarea"></label>
<?php the_editor($dataxx['content'], $id = 'content', $prev_id = 'title', $media_buttons = true, $tab_index = 2); ?></td>
    </tr>
    <tr>
      <td>Image</td>
      <td><label for="textfield2"></label>
      <input type="text" name="upload_image" value="<?php echo $dataxx['image']; ?>" id="upload_image">
      <input type="button" name="button" id="upload_image_button" value="Select Image"></td>
    </tr>
    <tr>
      <td>Order</td>
      <td><input type="text" name="image_order" id="image_order" value="<?php echo $dataxx['order']; ?>"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Save Changes"> 
      <input type="reset" name="button2" id="button2" value="Reset Changes"></td>
    </tr>
  </table>
</form>
<?php } else { ?>
<a class="zlogo" target="_blank" href="http://www.digitechwebdesignaustin.com/"><img src="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/roundabout-jquery-slider/logo.blue.png"><h4 align="center">Powered by digITech Web Design</h4></a>
<h1>Roundabout Plugin Options</h1>

<?php
if(isset($_GET['delete'])){
mysql_query("DELETE FROM `wp_roundabout_cats` WHERE `id`='$_GET[delete]'");
mysql_query("DELETE FROM `wp_roundabout` WHERE `cat`='$_GET[delete]'");
echo'<div class="update-nag">Slider Deleted. Redirecting . . .</div>
<script>document.location.href=\'options-general.php?page=settings.php\';</script>';
}
 ?>
<br /><div class="usage">
1) Click Create to make a new Roundabout slider.<br />
2) Add Images to the slider by selecting manage images.<br />
3) Configure single image size, and other options in the manage options area.<br />
4) Insert the shortcode for the corresponding slider into a page or post.<br />
5) If your theme does not support shortcodes, or you have difficulties with the shortcode, use the php snippet which is inserted into your theme template file. To easily insert this php code directly in the wordpress editor, install the "Grimp PHP" plugin, activate and insert the code below directly into the wp editor where you want the slider to appear.

<p>Example PHP Snippet:  &lt;?php echo show_roundabout_slider(5); ?&gt;</p>

Replace the number 5 in the above string with your slider "ID" number from the corresponding slider you would like to use below.<br />
6) Enjoy your new slider!<br /><br />

 

<b>Note:</b> If you do not wish to have a slider title or caption for the corresponding slide, simply leave the title or caption area blank.</div>


<br /><div class="create-form">
<form action="" method="post" name="new">
Create New Slider <input type="text" name="newslider" value="mySlider" /> <input type="submit" value="Create" class="button-primary" name="publish"> <i>[No spaces or special characters, only numbers, underscores and letters]</i>
</form>
</div><br />
<?php

if(isset($_POST['newslider']) && trim($_POST['newslider'])!=''){
$newslider = htmlentities(trim($_POST['newslider']));
mysql_query("INSERT INTO `wp_roundabout_cats` (`id`, `name`) VALUES (NULL, '$newslider')");
echo "INSERT INTO `wp_roundabout_cats` (`id`, `name`) VALUES (NULL, '$newslider')";
$rid=mysql_insert_id();
var_dump($rid);die();
mysql_query("INSERT INTO `wp_roundabout_settings` (`id`, `slider_id`, `width`, `height`, `bgcolor`, `title_color`, `title_font`, `title_font_size`, `title_bg`, `para_color`, `para_font`, `para_font_size`, `para_bg`, `credit`) 
VALUES (NULL, '$rid', '400', '300', 'grey', '#ffffff', 'Arial', '18', '#eeeeee', '#000000', 'Tahoma', '11', '#eeeeee', 'on')");
}



$sql="SELECT * FROM `wp_roundabout_cats`";
$res=mysql_query($sql);
$num=mysql_num_rows($res);

$i=0;

if($num==0){
echo'<b>No Sliders Detected. Please create a new slider to get started.</b>';
} else {
echo'<table  class="slider-table"><tr><th>ID</th><th>NAME</th><th width="150">SHORTCODE</th><th width="330">OPTIONS</th></tr>';
while($i<$num){
$id=mysql_result($res, $i, 'id');
$name=mysql_result($res, $i, 'name');

echo'<tr><td>'.$id.'</td><td>'.$name.'</td><td>[roundabout slider_id="'.$id.'"]</td><td>
<a href="options-general.php?page=settings.php&delete='.$id.'"><input type="button" value="Delete" class="button-secondary action" /></a>
<a href="options-general.php?page=settings.php&images='.$id.'"><input type="button" value="Manage Images" class="button-secondary action" /></a>
<a href="options-general.php?page=settings.php&setoptions='.$id.'"><input type="button" value="Manage Options" class="button-secondary action" /></a>
</td></tr>';
++$i;
}
echo'</table>';

if(isset($_POST['kkk'])){
if(isset($_POST['credits'])){ $crd='on'; } else { $crd='off'; }
mysql_query("UPDATE `wp_roundabout_settings` SET `credit`='$crd'");
}


$dataset=mysql_fetch_assoc(mysql_query("SELECT * FROM `wp_roundabout_settings` limit 1"));

if($dataset[credit]=='on'){
$xattr=' checked="checked" ';
} else { $xattr=''; }

echo'<form name="bbb" method="post" action=""><div class="extra-op">Open source under the BSD <a target="_blank" href="'.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/licence.txt">License</a></div></form>
 <div class="media-s">
 <li><a style="background-image:url('.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/facebook.png)" href="http://www.facebook.com/digitechwebdesign">&nbsp;</a></li>
 <li><a style="background-image:url('.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/google.png)" href="https://plus.google.com/116551361455964621178/">&nbsp;</a></li>
  <li><a style="background-image:url('.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/linkedin.png)" href="http://www.linkedin.com/in/digitechwebdesign">&nbsp;</a></li>
   <li><a style="background-image:url('.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/twitter.png)" href="https://twitter.com/#!/digitechcs">&nbsp;</a></li>
    <li><a style="background-image:url('.get_bloginfo('url').'/wp-content/plugins/roundabout-jquery-slider/vimeo.png)" href="http://vimeo.com/digitechwebdesign">&nbsp;</a></li>
 </div>';
}


} /* --- End general Tab --- */
?>

