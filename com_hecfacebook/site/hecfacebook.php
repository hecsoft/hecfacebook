<?php
/**
 * @version     1.0.0
 * @package     com_hecfacebook
 * @copyright   Copyright (C) 2013 HEC Soft. Tous droits réservés.
 * @license     GNU General Public License version 2 ou version ultérieure ; Voir LICENSE.txt
 * @author      Hervé CYR <support@hecsoft.net> - http://joomla.hecsoft.net
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('HecFacebook');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
