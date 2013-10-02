<?php
/**
 * @package    Orders
 * @subpackage Administration
 * @author: Veaceslav Vasilache <veaceslav.vasilache@gmail.com>
 @last-modified: Jun 25, 2012 12:58:20 AM
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class OrdersViewProducts extends JView {

	
	function display($tpl = null) 	{
		$id = JRequest::getVar('id');
		if (is_array($id)) $id = $id[0];
		
		JToolBarHelper::title( JText::_( 'Orders Form Manager' ), 'generic.png' );
		

		
		$model = &$this->getModel();
		
		if ($this->getLayout() == 'default_form'){
			JToolBarHelper::save();
			JToolBarHelper::cancel('cancel', 'Close');
			
			$product = $model->getProduct($id);
			$forms = $model->getForms();
			$this->assignRef('product', $product);
			$this->assignRef('forms', $forms);
		} else {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::editList();
			
			$bar = & JToolBar::getInstance('toolbar');
			// 
			// small hack

			$bar->appendButton( 'Popup', 'new', 'Add', JRoute::_('index.php?option=com_orders&view=products&layout=default_form&tmpl=component&new=1&popup=1') );
			JToolBarHelper::deleteList();
			
			$products = $model->getProducts();
			$this->assignRef('products', $products);
		}
		
		// View form layout
		//$tpl='form';
		//JRequest::setVar('layout', 'default_form' );
		parent::display($tpl);
	}
}
?>