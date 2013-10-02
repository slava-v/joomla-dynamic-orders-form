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


class OrdersViewFields extends JView
{
	function display($tpl = null){
		$id = JRequest::getVar('id');
		if (is_array($id)) $id = $id[0];

		JToolBarHelper::title( JText::_( 'Orders Fields Manager' ), 'generic.png' );

		$model = &$this->getModel();

		if ($this->getLayout() == 'default_form'){
			JToolBarHelper::save();
			JToolBarHelper::cancel('cancel', 'Close');

			$field = $model->getField($id);
			$forms = $model->getForms();

			$fieldTypes = array(
				array('value'=> 'static',   'text'=> 'Static', 'helptext'=>''),
				array('value'=> 'text',     'text'=> 'text', 'helptext'=>''),
				array('value'=> 'checkbox', 'text'=> 'checkbox', 'helptext'=>''),
				array('value'=> 'textarea', 'text'=> 'textarea', 'helptext'=>''),
				array('value'=> 'dropdown-list', 'text'=>'Dropdown list', 
				'helptext'=>'Enter new line separated list of values for dropdown list. Each line will be a dropdown list item'));

			$validators = array(
					array('', 'None'),
					array('isEmailAddress', 'Check field as mail')
					);

			$this->assignRef('forms', $forms);
			$this->assignRef('fieldTypes', $fieldTypes);
			$this->assignRef('validators', $validators);
			$this->assignRef('field', $field);
		} else {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::editList();

			$bar = & JToolBar::getInstance('toolbar');
			//
			// small hack

			$bar->appendButton( 'Popup', 'new', 'Add', JRoute::_('index.php?option=com_orders&view=fields&layout=default_form&tmpl=component&new=1&popup=1') );
			JToolBarHelper::deleteList();

			$fields = $model->getFields();
			$this->assignRef('fields', $fields);
		}

		parent::display($tpl);
	}
}
?>
