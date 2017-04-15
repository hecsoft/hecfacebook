<?php
/**
 * @version     1.0.0
 * @package     com_hec_facebook
 * @copyright   Copyright (C) 2013 HEC Soft. Tous droits réservés.
 * @license     GNU General Public License version 2 ou version ultérieure ; Voir LICENSE.txt
 * @author      Hervé CYR <support@hecsoft.net> - http://joomla.hecsoft.net
 */

// No direct access.
defined('_JEXEC') or die;
jimport('joomla.application.component.helper');
require_once JPATH_COMPONENT.'/controller.php';
require_once JPATH_COMPONENT.'/helpers/facebook.php';
/**
 * Courses list controller class.
 */
class HecFacebookControllerFacebook extends HecFacebookController
{

	
	function checkWebServiceOrigine()
	{
		return true;
		$user = JFactory::getUser();
		$user->guest==0 or die("|NOT ALLOWED|");
		if (isset($_SERVER['HTTP_REFERER']))
			$ref = $_SERVER['HTTP_REFERER'];
		else 
			$ref="";
		$uri = $_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		$ref_tab = explode('/', $ref);
		$ser_tab = explode('/', $uri);
		$uri_serveur='';
		$j=2;
		$ok=true;

		for ($i=0;$i<count($ser_tab)-4;$i++)
		{
			if ($ref_tab[$j]!=$ser_tab[$i])
			{
				$ok=false;
				break;
			}
			$j++;
		}
		return $ok;
	}
	
	public function feeds()
	{
		$app = JFactory::getApplication();
		$params = JComponentHelper::getParams('com_hec_facebook');
		
		
		$feeds = HECFacebookHelper::getFeeds($params);
	}
}