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
class OrdersModelFields extends JModel
{
	var $db = null;

	function __construct(){
		parent::__construct();

		$this->db = &JFactory::getDBO();
	}


	function getField($id){
		$this->db->setQuery("SELECT * FROM #__orders_fields WHERE `id`={$id} LIMIT 1");
		return $this->db->loadObject('id');
	}

	function getFields(){

		$this->db->setQuery("SELECT * FROM #__orders_fields ORDER BY `order` ASC");
		return $this->db->loadObjectList('id');
	}

	function getForms(){
		$model = &JModel::getInstance('forms', 'OrdersModel');
		return $model->getForms();
	}

	function saveOrder($ids, $order){
		foreach($ids as $k => $id){
			$this->db->setQuery("UPDATE #__orders_fields SET `order`={$order[$k]} WHERE `id`={$id} LIMIT 1");
			$this->db->query();
		}
	}

	private function changePublishState($id, $state){
		$sql = "UPDATE #__orders_fields SET `enabled`={$state} WHERE `id` ";
		if (is_array($id)){
			$sql .= "IN (" . implode(",", $id) . ")";
		} else {
			$sql .= "={$id} LIMIT 1";
		}
		$this->db->setQuery($sql);
		$this->db->query();
	}

	function publish($id){
		$this->changePublishState($id,1);
	}

	function unpublish($id){
		$this->changePublishState($id,0);
	}

	function saveField($fields, $id=null){
		$sql = array();
		if ($id){

			foreach($fields as $k=>$v){
				$sql[] .= " `{$k}` = '{$v}' ";
			}
			$sql = "UPDATE #__orders_fields SET "
				. implode(", ", $sql)
				. " WHERE `id`={$id} LIMIT 1";

		} else {
			$sql = "INSERT INTO #__orders_fields (`"
				. implode("`, `", array_keys($fields))
				. "`) VALUES ('"
				. implode("', '", array_values($fields))
				. "')";
		}

		$this->db->setQuery($sql);
		$this->db->query();
	}



	function deleteField($id){
		$sql = "DELETE FROM #__orders_fields WHERE `id` ";
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