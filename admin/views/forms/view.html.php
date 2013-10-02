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


class OrdersViewForms extends JView
{
	function display($tpl = null){
		$id = JRequest::getVar('id');
		if (is_array($id)) $id = $id[0];

		JToolBarHelper::title( JText::_( 'Orders Form Manager' ), 'generic.png' );



		$model = &$this->getModel();

		if ($this->getLayout() == 'default_form'){
			JToolBarHelper::save();
			JToolBarHelper::cancel('cancel', 'Close');

			$form = $model->getForm($id);
			$fields = $model->getFields();
			//@todo: add fields list here
			$this->assignRef('fields', $fields);
			$this->assignRef('form', $form);
		} else {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::editList();
			JToolBarHelper::addNewX();
			JToolBarHelper::deleteList();

			$forms = $model->getForms();
			$this->assignRef('forms', $forms);
		}

		parent::display($tpl);
	}
}
?>