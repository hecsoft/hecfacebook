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

$link   = $params->get('link');
$feeds = ModHECFacebookFeedHelper::getFeeds($params);


if (!count($feeds))
{
	echo JText::_('MOD_HEC_FACEBOOK_FEED_NO_FEED');

	return;
}


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_hec_facebook_feed', $params->get('layout', 'default'));
