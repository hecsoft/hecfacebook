<?php
/**
 * @package    	HEC Facebook
 * @subpackage  com_hec_facebook
 *
 * @copyright   Copyright (C) 2005 - 2017 HECSOFT All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for pkg_hecfacebook
 *
 * @package     HEC Facebook
 * @subpackage  com_hec_facebook
 * @since       0.1
 */
class HECFacebookHelper
{
	public static $lastError = "";

	public function getParam($params, $name, $default, $type='str')
	{
		if (!isset($params[$name]))
			$value=$default;
		else
		{
			switch($type)
			{
				case 'str':
					$value   = $params[$name];
					break;
				case 'int':
					$value   = intval($params[$name]);
					break;
			}
		}
		return $value;
	}
	
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
		$client_id   = HECFacebookHelper::getParam($params,'client_id','');
		$client_secret   = HECFacebookHelper::getParam($params,'client_secret','');
		$pagename   = HECFacebookHelper::getParam($params,'pagename','');
		$feedcount=HECFacebookHelper::getParam($params,'feed_count',5,'int');
		$show_events   = (HECFacebookHelper::getParam($params,'show_events',0,'int')==1);
		$photo_title_text=HECFacebookHelper::getParam($params,'photo_title_text','{name}');
		$video_title_text=HECFacebookHelper::getParam($params,'video_title_text','{name}');
		$link_title_text=HECFacebookHelper::getParam($params,'link_title_text','{name}');
		$default_title_text=HECFacebookHelper::getParam($params,'default_title_text','{name}');
		$videoheight =HECFacebookHelper::getParam($params,'videoheight','');
		$videowidth=HECFacebookHelper::getParam($params,'videowidth','');
		
		
		$user = JFactory::getUser();
		$language = $user->getParam('language', 'fr_FR');
		
		$feeds  = array();
		$url = 'https://graph.facebook.com/oauth/access_token?client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=client_credentials';
		
		$tokenresp = file_get_contents($url);
		if ($tokenresp)
		{
			$tokendata=json_decode($tokenresp);
			$token = $tokendata->access_token;
			// Photos : https://graph.facebook.com/mach78rc/photos?fields=created_time,id,status_type,type,story,message,source,picture,link,name,description,icon,parent_id&access_token=1407222099294113|CmpdVxUxfZTgx4b9Ne9aTtIMrPg
			$url='https://graph.facebook.com/'.$pagename.'/feed?fields=created_time,id,status_type,type,story,message,source,picture,link,name,description,icon,parent_id,attachments&limit='.$feedcount.'&locale=$language&access_token='.$token;
			$payload = file_get_contents($url);
			if (!$payload) 
			{
				self::$lastError = JText::_('COM_HEC_FACEBOOK_ERROR_BADANSWER');
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
											<p class='vjs-no-js'>".JText::_("COM_HEC_FACEBOOK_MESSAGE_ENABLLEJS")."</p>
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
			self::$lastError = JText::sprintf("COM_HEC_FACEBOOK_ERROR_OK", count($feeds));
			return $feeds;
		}
		else 
		{
			self::$lastError = JText::_("COM_HEC_FACEBOOK_ERROR_TOKEN");
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
			return JText::sprintf("COM_HEC_FACEBOOK_DATE_TODAY", $date->format('H:i'));
		//hier = aujourd'hui mais avec 60 x 60 x 24 secondes en moins.
		$hier = $maintenant - (60*60*24);
		if ($date->format('Ymd')== date('Ymd', $hier))
			return JText::sprintf("COM_HEC_FACEBOOK_DATE_YESTERDAY", $date->format('H:i'));
		if ($date->format('Y')==date('Y', $maintenant))
			return  $date->format('j').' '.JText::_("COM_HEC_FACEBOOK_DATE_MOIS_COURT_".$date->format('n'));
		else 
			return  $date->format('j').' '.JText::_("COM_HEC_FACEBOOK_DATE_MOIS_COURT_".$date->format('n')).' '.$date->format('Y');
	}
}
