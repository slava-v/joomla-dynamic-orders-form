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


		$document =& JFactory::getDocument();
		$document->addScript(JURI::base() . '/components/com_orders/userlib/jquery-lightbox-0.5/js/jquery.js');
		$document->addScriptDeclaration(" $.noConflict();");

		$document->addScript(JURI::base() . '/components/com_orders/userlib/jquery-lightbox-0.5/js/jquery.lightbox-0.5.js');
		$document->addStyleSheet(JURI::base() . '/components/com_orders/userlib/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css');
		$document->addScriptDeclaration("$(function() {
	$('a[@rel*=lightbox_05]').lightBox(); // Select all links that contains lightbox in the attribute rel
});");

		$form_id = (JRequest::getInt('id') ? JRequest::getInt('id') : 1);
		//$poll_id = JRequest::getVar( 'id', 0, '', 'int' );


		// Types: text, textarea, list, image, static
		$model = $this->getModel();
		$form  = $model->getForm( $form_id );

		if ($form->use_captcha){
			if ($form->captcha_type == 'reCaptcha'){
				require_once(JPATH_COMPONENT . '/userlib/recaptcha-php-1.11/recaptchalib.php');
				// private key = 6Lf3Q9MSAAAAAAWjZKbIcN_S6wXXAdKyLbMqiHbe
				// public key  = 6Lf3Q9MSAAAAAAbUKJdtwJbLdRFXPU6xb7kfceyi
				$publickey = "6Lf3Q9MSAAAAAAbUKJdtwJbLdRFXPU6xb7kfceyi"; // you got this from the signup page
				$captcha = recaptcha_get_html($publickey);
			} else {
				$captcha = '';
			}

			//$captcha = '<img src="http://naturevalley.md/index.php?option=com_orders&task=captcha" />';
			$this->assignRef( 'captcha', $captcha );
		}

		$this->assignRef( 'form', $form );

		parent::display($tpl);
	}
}