<?php
/**
 * @package		Orders
 * @subpackage		ADMINISTRATION
 * @author: 		Veaceslav Vasilache <veaceslav.vasilache@gmail.com>
 *
 * last-modified: Jun 25, 2012 12:21:54 AM
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class OrdersController extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access    public
	 */
	function display(){
		parent::display();
	}

	function help(){
		JToolBarHelper::title('Orders Help', 'help_header.png');
		echo file_get_contents(JPATH_COMPONENT .'/help.html');
	}
}

?>