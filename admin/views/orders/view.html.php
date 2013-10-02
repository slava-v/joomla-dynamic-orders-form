<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */

class OrdersViewOrders extends JView
{
	function display($tpl = null)
	{
		//$model = $this->getModel();
		//$products=$mode->getProducts();
		
		parent::display($tpl);
	}
}
?>