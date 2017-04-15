<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hecmailing
 *
 * @copyright   Copyright (C) 2005 - 2014 HECSoft, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View to edit a user group.
 *
 * @package     com_hecmailing
 * @subpackage  -
 * @since       1.6
 */
class HecFacebookViewPanel extends JViewLegacy
{
	protected $form;

	/**
	 * The item data.
	 *
	 * @var   object
	 * @since 1.6
	 */
	protected $item;

	/**
	 * The model state.
	 *
	 * @var   JObject
	 * @since 1.6
	 */
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		//$this->state = $this->get('State');
		//HECFacebookHelper::addSubmenu('param');
		//$this->form  = $this->get('Form');
		//$model = $this->getModel();
		
		$app=JFactory::getApplication();
		
				
		$this->addToolbar();
		//$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$canDo = JHelperContent::getActions('com_hecfacebook');

		JToolbarHelper::title(JText::_('COM_HECFACEBOOK_PARAMETERS_TITLE'));

		JToolbarHelper::preferences('com_hecfacebook');
		
		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_HECMAILING_CONTACT_EDIT');
	}
}
