<?php
/**
 * @author: Veaceslav Vasilache <veaceslav.vasilache@gmail.com>
 * @lastModified: Jun 23, 2012 5:49:54 PM
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

/**
 * @package		Joomla
 * @subpackage	Banners
 */
class OrdersControllerForms extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )	{
		parent::__construct( $config );
		// Register Extra tasks
		$this->registerTask( 'edit',	'add' );
	}

	function display(){

		global $mainframe;

		$db =& JFactory::getDBO();
		parent::display();
	}

	function add(){
		JRequest::setVar('layout', 'default_form');
		$this->display();
	}

	function save(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Forms');
		$fields = array(
				'title' 				=> JRequest::getVar('title'),
				'fields_included' 		=> ( is_array(JRequest::getVar('fields_included'))
											? implode(',',JRequest::getVar('fields_included'))
											: JRequest::getVar('fields_included') ),
				'surround_fields' 		=> JRequest::getVar('surround_fields', '', 'default', 'string', JREQUEST_ALLOWHTML),
				'send_copy' 			=> (JRequest::getVar('send_copy') ? 1 : 0),
				'use_captcha' 			=> (JRequest::getVar('use_captcha') ? 1 : 0) ,
				'captcha_type' 			=> JRequest::getVar('captcha_type')  ,
				'thankyou_text' 		=> JRequest::getVar('thankyou_text'),
				'recipient' 			=> JRequest::getVar('recipient'),
				'recipient_subject' 	=> JRequest::getVar('recipient_subject'),
				'recipient_template'	=> JRequest::getVar('recipient_template'),
				'sender_field_name'		=> JRequest::getVar('sender_field_name'),
				'sender_subject' 		=> JRequest::getVar('sender_subject'),
				'sender_template' 		=> JRequest::getVar('sender_template'),
				'gss_form_send' 		=> (JRequest::getVar('gss_form_send') ? 1 : 0),
				'gss_form_key' 			=> JRequest::getVar('gss_form_key'),
				'gss_form_version' 		=> JRequest::getVar('gss_form_version'),
				'products_after' 		=> JRequest::getVar('products_after'),
				'products_fields_class' => JRequest::getVar('products_fields_class'),
				'products_fields_style' => JRequest::getVar('products_fields_style'),
				'products_mail_template'=> JRequest::getVar('products_mail_template'),);

		$model->saveForm($fields, JRequest::getVar('id'));

		$this->message('Form saved successfully');

		$this->display();
	}

	function remove(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Forms');
		$model->deleteForm(JRequest::getVar('id'));

		$this->message('Successfully deleted');
		$this->display();
	}

	function message($msg){
		$app = &JFactory::getApplication();
		$app->enqueueMessage($msg);
	}
}
?>