<?php
/**
 * @package     HEC Facebook
 * @subpackage  com_hecfacebook
 *
 * @copyright   Copyright (C) 2005 - 2017 Hecsoft. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Panel model.
 *
 * @package     HEC Facebook
 * @subpackage  com_hecfacebook
 * @since       1.0
 */
class HecFacebookModelPanel extends JModelAdmin
{
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type	The table type to instantiate
	 * @param   string	A prefix for the table class name. Optional.
	 * @param   array  Configuration array for model. Optional.
	 * @return  JTable	A database object
	 * @since   1.6
	*/
	public function getTable($type = 'Contact', $prefix = 'JTable', $config = array())
	{
		return null;
	}

	
	
	public function getItem ($pk=null)
	{
		return null;
	}
	
	
	/**
	 * Method to get the record form.
	 *
	 * @param   array  $data		An optional array of data for the form to interogate.
	 * @param   boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return  JForm	A JForm object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		return false;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		return parent::loadFormData();
	}

	
	
	/**
	 * Override preprocessForm to load the user plugin group instead of content.
	 *
	 * @param   object	A form object.
	 * @param   mixed	The data expected for the form.
	 * @throws	Exception if there is an error in the form event.
	 * @since   1.6
	 */
	protected function preprocessForm(JForm $form, $data, $groups = '')
	{
		parent::preprocessForm($form, $data, 'hecfacebook');
	}


	
	
	
}
