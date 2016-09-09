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
		$client_id   = $params->get('client_id', '');
		$client_secret   = $params->get('client_secret', '');
		$pagename   = $params->get('pagename', '');
		$feedcount   = $params->get('feed_count', '5');
		$width   = $params->get('width', '100%');
		$height   = $params->get('heigth', '');
		
		$comment_text   = $params->get('comment_text', '');
		$photo_title_text   = $params->get('photo_title_text', '');
		$video_title_text   = $params->get('video_title_text', '');
		$link_title_text   = $params->get('link_title_text', '');
		$default_title_text   = $params->get('default_title_text', '');
		
		$show_events   = ()$params->get('show_events', '0')=='1');
		
		$feeds  = array();
		$tokenresp = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=client_credentials');
		$tokenresp=explode('=',$tokenresp);
		$token=$tokenresp[1];
		$payload = file_get_contents('https://graph.facebook.com/'.$pagename.'/feed?fields=created_time,id,status_type,type,story,message,source,picture,link,name,description,icon,parent_id&limit='.$feed_count.'&locale=fr_FR&access_token='.$token);
		$data = json_decode($payload);
		$n=0;
		foreach($data->data as $e)
		{
			$n++;
			$remove=false;
			$item=new stdClass();
			$item->created_time=$e->created_time;
			$item->id=$e->id;
			if (isset($e->message)) { $item->message=$e->message ;	}	else	{ $item->message="";	}
			if (isset($e->description)) { $item->description=$e->description;	}	else	{ $item->description="";	}
			switch ($e->status_type)
			{
				case 'shared_story':
					switch($e->type)
					{
						case 'photo':
							$item->title = str_replace("{name}", $e->name, $photo_title_text );
							$item->content = "<img src='".$e->picture."' width='100%' />";
							break;
						case 'video':
							$item->title = str_replace("{name}", $e->name, $video_title_text );
							$item->content="<video id='my-video".$n."' class='video-js' controls preload='auto' width='$width' 
										data-setup='{}'>
										<source src='".$e->source."' type='video/mp4'>
										<p class='vjs-no-js'>To view this video please enable JavaScript</p>
									</video>";
							break;
						case 'link':
							$item->title = str_replace("{name}", $e->name, $link_title_text );
							$item->content = "<img src='".$e->picture."' width='100%' />";
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
		return $feeds;
	}

}
