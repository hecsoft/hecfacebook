<?php
/**
 * @package     HEC Facebook
 * @subpackage  com_hecfacebook
 *
 * @copyright   Copyright (C) 2005 - 2017 HECSOFT All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HEC Facebook master display controller.
 *
 * @package     HEC Facebook
 * @subpackage  com_hecfacebook
 * @since       1.0
 */
class HecFacebookController extends JControllerLegacy
{
	/**
	 * Checks whether a user can see this view.
	 *
	 * @param   string   $view  The view name.
	 *
	 * @return  boolean
	 * @since   1.0
	 */
	protected function canView($view)
	{
		$canDo = JHelperContent::getActions('com_hecfacebook');
		
		return true;
		
	}

	/**
	 * Method to display a view.
	 *
	 * @param   boolean      If true, the view output will be cached
	 * @param   array        An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController	 This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$view   = $this->input->get('view', '');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		$task   = $this->input->get('task','');
		
		if ($view=='' && $task!='') $view = $task;
		else if ($view=='') $view = "panel";
		
		if (!$this->canView($view))
		{
			JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));

			return;
		}

		
		
		$this->input->set('view', $view);
		$this->input->set('layout', $layout);
		return parent::display();
	}
}
