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
class OrdersControllerFields extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
		$this->registerTask('edit', 'add');
	}

	function display()
	{
		global $mainframe;

		$db =& JFactory::getDBO();

		parent::display();
	}


	function add(){
		JRequest::setVar('layout', 'default_form');
		$this->display();
	}

	function saveOrder(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Fields');

		$model->saveOrder(JRequest::getVar('id'), JRequest::getVar('order'));
		$this->display();
	}

	function save(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Fields');
		$fields = array(
				'name' 			=> JRequest::getVar('name'),
				'label' 		=> JRequest::getVar('label', '', 'default', 'string', JREQUEST_ALLOWHTML),
				'help_text' 	=> JRequest::getVar('help_text'),
				'validator' 	=> JRequest::getVar('validator'),
				'validate_err' 	=> JRequest::getVar('validate_err'),
				'is_mandatory'	=> (JRequest::getVar('is_mandatory') ? 1 : 0),
				'label_after' 	=> (JRequest::getVar('label_after')  ? 1 : 0),
				'display_only' 	=> (JRequest::getVar('display_only') ? 1 : 0),
				'default_value' => JRequest::getVar('default_value','','default','string', JREQUEST_ALLOWHTML),
				'class' 		=> JRequest::getVar('class'),
				'style' 		=> JRequest::getVar('style'),
				'order' 		=> JRequest::getVar('order'),
				'type' 			=> JRequest::getVar('type'),
				'orders_form_id'=> JRequest::getVar('orders_form_id'));


		$model->saveField($fields, JRequest::getVar('id'));

		$app = &JFactory::getApplication();
		$app->enqueueMessage('Saved successfully');
		$this->display();
	}

	function unpublish(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Fields');
		$model->unpublish(JRequest::getVar('id'));

		$app = &JFactory::getApplication();
		$app->enqueueMessage('Unpublished successfully');
		$this->display();
	}

	function publish(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Fields');
		$model->publish(JRequest::getVar('id'));

		$app = &JFactory::getApplication();
		$app->enqueueMessage('Published successfully');
		$this->display();
	}

	function remove(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Fields');
		$model->deleteField(JRequest::getVar('id'));
		$this->display();
	}
}
?>