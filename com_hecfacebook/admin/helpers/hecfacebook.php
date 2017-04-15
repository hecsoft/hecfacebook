<?php
/**
 * @version 1.0.0
 * @package hecfacebook
 * @copyright 2009-2013 Hecsoft.net
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 * @link http://joomla.hecsoft.net
 * @author H Cyr
 **/
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
class HecFacebookHelper
{
	/**
	 * @var    JObject  A cache for the available actions.
	 * @since  1.6
	 */
	protected static $actions;

	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		
		// Groups and Levels are restricted to core.admin
		$canDo = JHelperContent::getActions('com_hecmailing');

		/*if ($canDo->get('core.admin'))
		{
			JHtmlSidebar::addEntry(
				JText::_('COM_HECMAILING_SUBMENU_GROUPS'),
				'index.php?option=com_hecmailing&view=groups',
				$vName == 'groups'
			);
			JHtmlSidebar::addEntry(
				JText::_('COM_HECMAILING_SUBMENU_CONTACT'),
				'index.php?option=com_hecmailing&view=contacts',
				$vName == 'contacts'
			);
			JHtmlSidebar::addEntry(
			JText::_('COM_HECMAILING_SUBMENU_TEMPLATE'),
			'index.php?option=com_hecmailing&view=templates',
			$vName == 'templates'
					);
			JHtmlSidebar::addEntry(
				JText::_('COM_HECMAILING_SUBMENU_PANEL'),
				'index.php?option=com_hecmailing&view=param',
				$vName == 'param'
			);

			
		}*/
	}

	
	
}
?>