<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_random_image
 *
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 * @since       1.5
 */
class ModHECFacebookFeedHelper
{
	public static $lastError = "";

	/**
	 * Retrieves images from a specific folder
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module params
	 * @param   string                     $folder   folder to get the images from
	 *
	 * @return array
	 */
	public static function getFeeds(&$params)
	{
		self::$lastError="";
		$client_id   = $params->get('client_id', '');
		$client_secret   = $params->get('client_secret', '');
		$pagename   = $params->get('pagename', '');
		$feedcount   = $params->get('feed_count', '5');
		$width   = $params->get('width', '100%');
		$height   = $params->get('height', '');
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
		
		$user = JFactory::getUser();
		$language = $user->getParam('language', 'fr_FR');
		$feeds  = array();
		$url = 'https://graph.facebook.com/oauth/access_token?client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=client_credentials';
		//$url = 'https://graph.facebook.com/'.$pagename.'/accounts?client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=client_credentials';
		$tokenresp = file_get_contents($url);
		if ($tokenresp)
		{
			$tokendata=json_decode($tokenresp);
			$token = $tokendata->access_token;
			//$tokenresp=explode('=',$tokenresp);
			//$token=$tokenresp[1];
			// Photos : https://graph.facebook.com/mach78rc/photos?fields=created_time,id,status_type,type,story,message,source,picture,link,name,description,icon,parent_id&access_token=1407222099294113|CmpdVxUxfZTgx4b9Ne9aTtIMrPg
			$url='https://graph.facebook.com/'.$pagename.'/feed?fields=created_time,id,status_type,type,story,message,source,picture,link,name,description,icon,parent_id,attachments&limit='.$feedcount.'&locale=$language&access_token='.$token;
			$payload = file_get_contents($url);
			if (!$payload) 
			{
				self::$lastError = "Bad feed answer";
				return false;
			}
			$data = json_decode($payload);
			$n=0;
			foreach($data->data as $e)
			{
				$n++;
				$remove=false;
				$item=new stdClass();
				$item->content ="";
				$item->created_time= DateTime::createFromFormat('Y-m-d\TH:i:s+O', $e->created_time);
				$item->id=$e->id;
				$item->link=$e->link;
				if (isset($e->message)) { $item->message=ModHECFacebookFeedHelper::addA($e->message) ;	}	else	{ $item->message="";	}
				if (isset($e->description)) { $item->description=ModHECFacebookFeedHelper::addA($e->description);	}	else	{ $item->description="";	}
				switch ($e->status_type)
				{
					case 'shared_story':
						switch($e->type)
						{
							case 'photo':
								$photourl=$e->picture;
								if (isset($e->attachments))
								{
									$media=$e->attachments->data[0]->media;
									if ($media)
										$photourl=$media->image->src;
									
								
								}
								$item->title = str_replace("{name}", $e->name, $photo_title_text );
								$item->content = "<img src='".$photourl."' class='photo-image' />";
								break;
							case 'video':
								$item->title = str_replace("{name}", $e->name, $video_title_text );
								$item->content="<video id='my-video-".$n."' class='video-js' controls preload='none'   $videoheight $videowidth
											data-setup='{\"language\":\"fr\"}' poster='".$e->picture."'>
											<source src='".$e->source."' type='video/mp4'>
											<p class='vjs-no-js'>To view this video please enable JavaScript</p>
										</video>";
								break;
							case 'link':
								$item->title = str_replace("{name}", $e->name, $link_title_text );
								$item->content = "<img src='".$e->picture."' class='link-image' />";
								break;
							default:
								$item->title = str_replace("{name}", $e->name, $default_title_text );
								$item->content ="";
								break;
						}
						break;
					case 'added_photos':
					case 'created_event':
						$remove=true;
						break;
					default:
						$item->title = $e->story;
						$item->content ="";
						break;
				}
				if ($e->type=='event' && !$show_events) $remove=true;
				
				
				if (!$remove)
					$feeds[]=$item;
			}
			self::$lastError = "OK : ".count($feeds)." feeds";
			return $feeds;
		}
		else 
		{
			self::$lastError = "Error Token";
			return false;
		}
	}
	
	public static function addA($string)
	{
		$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
		$string = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $string);
		return $string;
	}
	public static function formatDate($date)
	{
		$maintenant = time();
		if ($date->format('Ymd')== date('Ymd', $maintenant))
			return JText::sprintf("MOD_HEC_FACEBOOK_FEED_DATE_TODAY", $date->format('H:i'));
		//hier = aujourd'hui mais avec 60 x 60 x 24 secondes en moins.
		$hier = $maintenant - (60*60*24);
		if ($date->format('Ymd')== date('Ymd', $hier))
			return JText::sprintf("MOD_HEC_FACEBOOK_FEED_DATE_YESTERDAY", $date->format('H:i'));
		if ($date->format('Y')==date('Y', $maintenant))
			return  $date->format('j').' '.JText::_("MOD_HEC_FACEBOOK_FEED_DATE_MOIS_COURT_".$date->format('n'));
		else 
			return  $date->format('j').' '.JText::_("MOD_HEC_FACEBOOK_FEED_DATE_MOIS_COURT_".$date->format('n')).' '.$date->format('Y');
	}
}
