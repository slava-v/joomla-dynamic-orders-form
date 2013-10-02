<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * components/com_hello/hello.php
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


$user = & JFactory::getUser();

// Before everything else, check user
$params = &JComponentHelper::getParams( 'com_orders' );
if ($user->guest && !$params->get( 'show_noauth') && $params->get( 'redirect_noauth')!= '' ){
	$msg = $params->get( 'redirect_message' );
	$url = $params->get( 'redirect_noauth' );

	if (!$url) {
		$url = 'index.php?option=com_user&view=login';
	}

	if ($params->get( 'use_return_url')){
		$url .= '&return=' . base64_encode(JFactory::getURI()->toString());
	}
	$mainframe->redirect( $url , ( preg_match('/^__/', $msg) ? JText::_(str_replace("__", "", $msg)) : $msg) );
}


// Require the base controller
JHTML::_('behavior.mootools');
$document =& JFactory::getDocument();


$document->addStyleSheet(JURI::base() . '/administrator/components/com_orders/style.css');

require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specific controller if requested
if ($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Create the controller
$classname	= 'OrdersController'.$controller;
$controller	= new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();