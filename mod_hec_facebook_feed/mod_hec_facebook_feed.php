<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the random image functions only once
require_once __DIR__ . '/helper.php';

$width   = $params->get('width','100%');
$height   = $params->get('height','');
$use_videojs   = ($params->get('use_videojs','0')=='1');

$videowidth   = $params->get('videowidth', '');
if ($videowidth!='') $videowidth=" width='$videowidth'";
$videoheight   = $params->get('videoheight', '');
if ($videoheight!='') $videoheight=" height='$videoheight'";

$comment_text   = $params->get('comment_text', '');
if ($comment_text=='') $comment_text=JText::_("MOD_HEC_FACEBOOK_FEED_TEMPLATE_COMMENT");
$photo_title_text   = $params->get('photo_title_text', '');
if ($photo_title_text=='') $photo_title_text=JText::_("MOD_HEC_FACEBOOK_FEED_TEMPLATE_PICTURE");
$video_title_text   = $params->get('video_title_text', '');
if ($video_title_text=='') $video_title_text=JText::_("MOD_HEC_FACEBOOK_FEED_TEMPLATE_VIDEO");
$link_title_text   = $params->get('link_title_text', '');
if ($link_title_text=='') $link_title_text=JText::_("MOD_HEC_FACEBOOK_FEED_TEMPLATE_LINK");
$default_title_text   = $params->get('default_title_text', '');
if ($default_title_text=='') $default_title_text=JText::_("MOD_HEC_FACEBOOK_FEED_TEMPLATE_DEFAULT");

$show_events   = ($params->get('show_events', '0')=='1');

$feed_options = [ 'videowidth: "'.$videowidth.'"', 'videoheight: "'.$videoheight.'"', 'comment_text: "'.$comment_text.'"',
		'photo_title_text: "'.$photo_title_text.'"','video_title_text: "'.$video_title_text.'"','link_title_text: "'.$link_title_text.'"',
		'default_title_text: "'.$default_title_text.'"','show_events: "'.$show_events.'"' ];
$feed_options = [ "videowidth: '".$videowidth."'", "videoheight: '".$videoheight."'", "comment_text: '".$comment_text."'",
		"photo_title_text: '".$photo_title_text."'","video_title_text: '".$video_title_text."'","link_title_text: '".$link_title_text."'",
		"default_title_text: '".$default_title_text."'","show_events: '".$show_events."'" ];

$postdata= implode(',', $feed_options);


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_hec_facebook_feed', $params->get('layout', 'default'));
