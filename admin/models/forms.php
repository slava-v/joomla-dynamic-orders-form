<?php
/**
 * @author: Veaceslav Vasilache <veaceslav.vasilache@gmail.com>
 * @lastModified: Jun 23, 2012 5:49:54 PM
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * @package		Joomla
 * @subpackage	Contact
 */
class OrdersModelForms extends JModel
{
	var $db = null;

	function __construct(){
		parent::__construct();

		$this->db = &JFactory::getDBO();
	}


	function getForm($id){
		$this->db->setQuery("SELECT * FROM #__orders_forms WHERE `id`={$id} LIMIT 1");
		return $this->db->loadObject('id');
	}

	function getForms(){

		$this->db->setQuery("SELECT * FROM #__orders_forms");
		return $this->db->loadObjectList('id');
	}

	function saveForm($fields, $id=null){
		$sql = array();
		if ($id){

			foreach($fields as $k=>$v){
				$sql[] .= " `{$k}` = '{$v}' ";
			}
			$sql = "UPDATE #__orders_forms SET "
				. implode(", ", $sql)
				. " WHERE `id`={$id} LIMIT 1";

		} else {
			$sql = "INSERT INTO #__orders_forms (`"
				. implode("`, `", array_keys($fields))
				. "`) VALUES ('"
				. implode("', '", array_values($fields))
				. "')";
		}

		$this->db->setQuery($sql);
		$this->db->query();
	}

	function getFields(){
		$model = &JModel::getInstance('fields', 'OrdersModel');
		return $model->getFields();
	}

	function deleteForm($id){
		$sql = "DELETE FROM #__orders_forms WHERE `id` ";
		if (is_array($id)){
			$sql .= "IN (" . implode(",", $id) . ")";
		} else {
			$sql .= "={$id} LIMIT 1";
		}
		$this->db->setQuery($sql);
		$this->db->query();
	}

}

?>