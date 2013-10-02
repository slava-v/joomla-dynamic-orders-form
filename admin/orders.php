<?php
/**
* @package		Orders
* @subpackage	ADMINISTRATION
* @author: Veaceslav Vasilache <veaceslav.vasilache@gmail.com>
*
* last-modified: Jun 25, 2012 12:21:54 AM
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$doc = &JFactory::getDocument();
$doc->addStylesheet(JURI::base() . '/components/com_orders/style.css');



require_once( JPATH_COMPONENT.DS.'controller.php' );
$view = $controller = JRequest::getWord('view');

if (!$view) {
	$view = 'products';
	JRequest::setVar('view', $view);
}

// Require specific controller if requested
if ($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = 'products';
		JRequest::setVar('view', 'products');
	}
}

JToolBarHelper::preferences('com_orders', '550');
//JSubMenuHelper::addEntry(JText::_('Parameters'), 'index.php?option=com_orders&view=products', ($view == 'products'));

JSubMenuHelper::addEntry(JText::_('Products'), 'index.php?option=com_orders&view=products', ($view == 'products'));
JSubMenuHelper::addEntry(JText::_('Forms'), 'index.php?option=com_orders&view=forms', ($view == 'forms'));
JSubMenuHelper::addEntry(JText::_('Fields'), 'index.php?option=com_orders&view=fields', ($view == 'fields'));
JSubMenuHelper::addEntry(JText::_('Help'), 'index.php?option=com_orders&task=help', (JRequest::getWord('task') == 'help'));

// Create the controller
$classname	= 'OrdersController'.ucfirst($controller);
$controller	= new $classname();

$controller->execute( JRequest::getCmd( 'task' ) );
$controller->redirect();