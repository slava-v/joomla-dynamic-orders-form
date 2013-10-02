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
class OrdersControllerProducts extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
		$this->registerTask('edit', 'add');
		$this->registerTask('save', 'productSave');
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
		$model = &$this->getModel('Products');

		$model->saveOrder(JRequest::getVar('id'), JRequest::getVar('order'));
		$this->display();
	}
	
	function productSave(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Products');
		$fields = array(
				'title' => JRequest::getVar('title'),
				'type' => JRequest::getVar('type'),
				'order' => JRequest::getVar('order'),
				'description' => JRequest::getVar('description'),
				'price' => JRequest::getVar('price'),
				'currency' => JRequest::getVar('currency'),
				'picture' => JRequest::getVar('picture') ,
				'orders_form_id' => JRequest::getVar('orders_form_id'));
		
		if ($fields['picture'] && $fields['picture'][0] != '/' ) {
			$fields['picture'] = '/' . $fields['picture'];
		}
		
		$model->saveProduct($fields, JRequest::getVar('id'));
		$this->display();
	}
	
	function unpublish(){ 
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Products');
		$model->unpublish(JRequest::getVar('id'));
		$this->display();
	}
	
	function publish(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Products');
		$model->publish(JRequest::getVar('id'));
		$this->display();
	}
	
	function remove(){
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$model = &$this->getModel('Products');
		$model->deleteProduct(JRequest::getVar('id'));
		$this->display();
	}
}
?>