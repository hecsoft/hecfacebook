<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="hec-facebook-feed<?php echo $moduleclass_sfx ?>">
<ul>
foreach($feeds as $feed)
{
	$n++;
	echo "<li class='feed'><div style='overflow:auto; width:$width;' >
			<h3 class='title'><a href='".$e->link."' target='_blank'>".$item->title."</a></h3>";
	echo $item->content;
	echo "<p class='description'>".$feed->description."</p><i class='message'>".$item->message."</i>";
	echo "</div></li>";"
}
</ul>
</div>
