<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$app= JFactory::getApplication();
$module_path=JUri::base(true).'/modules/mod_hec_facebook_feed';

if ($use_videojs) {
?>
 <link href="<?php echo $module_path; ?>/video-js/video-js.css" rel="stylesheet">
 <script src="<?php echo $module_path; ?>/video-js/ie8/videojs-ie8.min.js"></script>
 <script src="<?php echo $module_path; ?>/video-js/video.js"></script>
<style>
/*
  Player Skin Designer for Video.js
  http://videojs.com

  To customize the player skin edit 
  the CSS below. Click "details" 
  below to add comments or questions.
  This file uses some SCSS. Learn more  
  at http://sass-lang.com/guide)

  This designer can be linked to at:
  http://codepen.io/heff/pen/EarCt/left/?editors=010
*/

// The following are SCSS variables to automate some of the values.
// But don't feel limited by them. Change/replace whatever you want. 

// The color of icons, text, and the big play button border.
// Try changing to #0f0
$primary-foreground-color: #fff; // #fff default

// The default color of control backgrounds is mostly black but with a little
// bit of blue so it can still be seen on all-black video frames, which are common.
// Try changing to #900
$primary-background-color: #2B333F;  // #2B333F default

// Try changing to true
$center-big-play-button: false; // true default

.video-js {
  /* The base font size controls the size of everything, not just text.
     All dimensions use em-based sizes so that the scale along with the font size.
     Try increasing it to 15px and see what happens. */
  font-size: 10px;

  /* The main font color changes the ICON COLORS as well as the text */
  color: $primary-foreground-color;
  
  width: <?php echo $width; ?> !important;
  height: auto !important;
}

/* The "Big Play Button" is the play button that shows before the video plays.
   To center it set the align values to center and middle. The typical location
   of the button is the center, but there is trend towards moving it to a corner
   where it gets out of the way of valuable content in the poster image.*/
.vjs-default-skin .vjs-big-play-button {
  /* The font size is what makes the big play button...big. 
     All width/height values use ems, which are a multiple of the font size.
     If the .video-js font-size is 10px, then 3em equals 30px.*/
  font-size: 3em;

  /* We're using SCSS vars here because the values are used in multiple places.
     Now that font size is set, the following em values will be a multiple of the
     new font size. If the font-size is 3em (30px), then setting any of
     the following values to 3em would equal 30px. 3 * font-size. */
  $big-play-width: 3em; 
  /* 1.5em = 45px default */
  $big-play-height: 1.5em;

  line-height: $big-play-height;
  height: $big-play-height;
  width: $big-play-width;

  /* 0.06666em = 2px default */
  border: 0.06666em solid $primary-foreground-color;
  /* 0.3em = 9px default */
  border-radius: 0.3em;

  @if $center-big-play-button {
    /* Align center */
    left: 50%;
    top: 50%;
    margin-left: -($big-play-width / 2);
    margin-top: -($big-play-height / 2);   
  } @else {
    /* Align top left. 0.5em = 15px default */
    left: 0.5em;
    top: 0.5em;
  }
}

/* The default color of control backgrounds is mostly black but with a little
   bit of blue so it can still be seen on all-black video frames, which are common. */
.video-js .vjs-control-bar,
.video-js .vjs-big-play-button,
.video-js .vjs-menu-button .vjs-menu-content {
  /* IE8 - has no alpha support */
  background-color: $primary-background-color;
  /* Opacity: 1.0 = 100%, 0.0 = 0% */
  background-color: rgba($primary-background-color, 0.7);
}

// Make a slightly lighter version of the main background
// for the slider background.
$slider-bg-color: lighten($primary-background-color, 33%);

/* Slider - used for Volume bar and Progress bar */
.video-js .vjs-slider {
  background-color: $slider-bg-color;
  background-color: rgba($slider-bg-color, 0.5);
}

/* The slider bar color is used for the progress bar and the volume bar
   (the first two can be removed after a fix that's coming) */
.video-js .vjs-volume-level,
.video-js .vjs-play-progress,
.video-js .vjs-slider-bar {
  background: $primary-foreground-color;
}

/* The main progress bar also has a bar that shows how much has been loaded. */
.video-js .vjs-load-progress {
  /* For IE8 we'll lighten the color */
  background: ligthen($slider-bg-color, 25%);
  /* Otherwise we'll rely on stacked opacities */
  background: rgba($slider-bg-color, 0.5);
}

/* The load progress bar also has internal divs that represent
   smaller disconnected loaded time ranges */
.video-js .vjs-load-progress div {
  /* For IE8 we'll lighten the color */
  background: ligthen($slider-bg-color, 50%);
  /* Otherwise we'll rely on stacked opacities */
  background: rgba($slider-bg-color, 0.75);
}

</style>
<script>
jQuery(function(){
  var $refreshButton = jQuery('#refresh');
  var $results = jQuery('#css_result');
  
  function refresh(){
    var css = jQuery('style.cp-pen-styles').text();
    $results.html(css);
  }

  refresh();
  $refreshButton.click(refresh);
  
  // Select all the contents when clicked
  $results.click(function(){
    $(this).select();
  });
});

</script>
<?php } ?>
<style>

#hec-facebook-feed {
<?php if ($height!='') { ?> 
	overflow-y:scroll; height:<?php echo $height; ?>px;  
<?php } ?>
<?php if ($width!='') { ?> 
	width:<?php echo $width; ?>px;  
<?php } ?>
}
#hec-facebook-feed ul { margin:0px; }
.link-image {float:left;max-width:95%; margin-right:5px;}
.photo-image { width:100%;}
</style>
<!-- Load Facebook SDK for JavaScript -->
	
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.7&appId=575949582507212";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<!-- Your like button code -->
	<div class="fb-like" data-href="https://www.facebook.com/mach78rc" data-width="200px" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
<!-- <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo "https://www.facebook.com/mach78rc/"; ?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light&locale=fr_FR" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px;"></iframe> -->
<div id="hec-facebook-feed" class="hec-facebook-feed<?php echo $moduleclass_sfx ?>">
<ul>
<?php
if ($feeds){
foreach($feeds as $feed)
{
	
	echo "<li class='feed'><div style='overflow:auto; width:$width;' >
			<h3 class='title'><a href='".$feed->link."' target='_blank'>".$feed->title."</a></h3>";
	echo "<i class='created_time'>".ModHECFacebookFeedHelper::formatDate($feed->created_time)."</i>";
	echo $feed->content;
	echo "<p class='description'>".$feed->description."</p><i class='message'>".$feed->message."</i>";
	echo "</div></li>";
}}
else { ?>
	<i class="error">Erreur</i>
<?php } ?>
</ul>
</div>
