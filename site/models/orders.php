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
class OrdersModelOrders extends JModel
{

	function getForm($id){
		$db	=& JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__orders_forms WHERE `id`=" . $id);
		$form = $db->loadObject();

		$db->setQuery("SELECT * FROM #__orders_fields WHERE `orders_form_id`={$id} AND `enabled`=1 ORDER BY `order` ASC");
		$form->fields = $db->loadObjectList('id');

		$db->setQuery("SELECT * FROM #__orders_products WHERE `orders_form_id`={$id} AND `enabled`=1 ORDER BY `order` ASC");
		$form->products = $db->loadObjectList('id');

		$form->surround_fields = explode("|",$form->surround_fields);
		return $form;
	}

	function getForm1($id){
		$form = new stdClass();
		$fields = array(
				(object)array('after'=>false, 'order'=>1, 'displayOnly'=>true,  'validator' => '', 'validate_err' => '',  'isMandatory' => false, 'style'=> '', 'type' => 'static', 'name' => '', 'value'=> 'Please fill out the form below and click submit to sign up for a farm share', 'class'=>'inputbox', 'label'=>''),
				(object)array('after'=>false, 'order'=>2, 'displayOnly'=>true,  'validator' => '', 'validate_err' => '', 'isMandatory' => false, 'style'=> '', 'type' => 'static', 'name' => '', 'value'=> 'If you chose the delivery Option Please provide us a physical address for delivery, and any additional information needed for delivery to this address. I.e. leave at gate, ring bell, and call ahead', 'class'=>'inputbox', 'label'=>''),
				(object)array('after'=>false, 'order'=>3, 'displayOnly'=>true,  'validator' => '', 'validate_err' => '', 'isMandatory' => false, 'style'=> '', 'type' => 'static', 'name' => '', 'value'=> '*Please note that we are only able to deliver to residences in Chisinau, sorry for any inconveniences this might cause*', 'class'=>'inputbox', 'label'=>''),
				(object)array('after'=>false, 'order'=>4, 'displayOnly'=>false, 'validator' => '', 'validate_err' => '', 'isMandatory' => true, 'style'=> '', 'type' => 'text', 'name' => 'lastname', 'value'=> '', 'class'=>'inputbox', 'label'=>'Last name'),
				(object)array('after'=>false, 'order'=>5, 'displayOnly'=>false, 'validator' => '', 'validate_err' => '', 'isMandatory' => true, 'style'=> '', 'type' => 'text', 'name' => 'firstname', 'value'=> '', 'class'=>'inputbox', 'label'=>'First name'),
				(object)array('after'=>false, 'order'=>6, 'displayOnly'=>false, 'validator' => 'isEmailAddress', 'validate_err' => 'The email is not valid.', 'isMandatory' => true, 'style'=> '', 'type' => 'text', 'name' => 'email', 'value'=> '', 'class'=>'inputbox', 'label'=>'Email address'),
				(object)array('after'=>false, 'order'=>7, 'displayOnly'=>false, 'validator' => '', 'validate_err' => '', 'isMandatory' => true, 'style'=> '', 'type' => 'text', 'name' => 'phone', 'value'=> '', 'class'=>'inputbox', 'label'=>'Phone #'),
				(object)array('after'=>false, 'order'=>8, 'displayOnly'=>true,  'validator' => '', 'validate_err' => '', 'isMandatory' => false, 'style'=> 'font-size:12px;font-family:monospace, courier new;', 'type' => 'textarea', 'name' => 'terms1', 'value'=> 'By checking this box I attest that I have CAREFULLY READ Eco Valley’s farm share policies CSA is a Partnership between the Members and the Farmers At the core of CSA is the idea that members support their farmer by sharing in the inherent risks of agriculture (poor weather, drought, disease, early frost, crop failure and so on) and rewards (the bounty from a good season!).
						Therefore while farmers (Kelsey and Raia) will act in good faith to provide fresh natural produce for the 20-week season, there is no guarantee of quantities or contents of weekly shares.
						Payment for shares will be due in full upon receipt of the first share box (May 31 2012).', 'class'=>'inputbox', 'label'=>'Terms and conditions<br/>'),
				(object)array('after'=>true,  'order'=>9,  'displayOnly'=>true,  'validator' => '', 'validate_err' => '', 'isMandatory' => true, 'style'=> '', 'type' => 'checkbox', 'name' => 'terms', 'value'=> '1', 'class'=>'inputbox', 'label'=>'I agree'),
		);
		$form->products_after = 'phone';
		$form->products_fields_class = 'inputbox';
		$form->products_fields_style = '';
		$form->products_mail_template = "\t* {title} \t\t({price}{currency}) ... {count}\r\n";
		$form->products = array(
				1 => (object)Array('id'=>1, 'type' => 'quantity', 'title' => 'Vegetable Share', 'description' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident', 'picture' => 'veggies.jpg', 'price'=>3500, 'currency'=> 'lei'),
				2 => (object)Array('id'=>2, 'type' => 'quantity', 'title' => 'Egg Share', 'description' => 'Ssimilique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 'picture' => 'eggs.jpg', 'price'=>500, 'currency'=> 'lei'),
				3 => (object)Array('id'=>3, 'type' => 'yes_no', 'title' => 'Delivery Option', 'description' => 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.', 'picture' => 'delivery.jpg', 'price'=>450, 'currency'=> 'lei'),
		);

		$form->fields = array();
		foreach($fields as $f){
			$form->fields[$f->name] = $f;
		}

		$form->id = 1;

		// Fields included in order
		$form->fields_included = 'firstname,lastname,email,phone';

		//$form->fields    = $fields;

		// Who receives the order ( person that processes the email )
		$form->recipient = 'veaceslav.vasilache@gmail.com';
		$form->recipient_subject = 'Order from {firstname}';
		$form->recipient_template = '
		Order received


		Firstname ....: {firstname}
		Lastname .....: {lastname}

		Products ordered:

		{products}


		Thankyou {firstname} {lastname}.';

		// Send a copy to sender
		//@todo: add send_copy to be user choice in form of a checkbox;
		$form->sender_subject = 'Order copy for {firstname}';
		$form->sender_template = '
		You sent a order.

		Order details:

		Firstname ....: {firstname}
		Lastname .....: {lastname}

		Thankyou {firstname} {lastname}.';
		$form->send_copy = true;
		$form->thankyou_text = 'Thank you for your e-mail.';
		$form->gss_form->send = true;
		$form->gss_form->key = 'dG1QcF9JX0RLaXlHM1ljTkRRUzdCRHc6MQ';
		$form->gss_id = '0Ai-YMPkK8THcdG1QcF9JX0RLaXlHM1ljTkRRUzdCRHc';
		$form->gss_sheet_id = 1;

		// Surround fields with custom code
		$form->surround_fields = array("\n".'<p class="row">', '</p>'."\n");

		return $form;
	}


	function saveOrder($recipientEmail, $senderEmail, $fields, $products){

		$db	=& JFactory::getDBO();

		//Quote and escape field data
		$recipientEmail = $db->getEscaped($recipientEmail);
		$senderEmail    = $db->getEscaped($senderEmail);
		$products       = $db->getEscaped($products);

		$sql = "INSERT INTO #__orders_inbox (`recipient_email`, `sender_email`, `fields`, `products`) "
			." VALUES ('{$recipientEmail}','{$senderEmail}','{$fields}','{$products}')";

		//echo "<!-- ".$sql . " -->";
		$db->setQuery($sql);
		$db->query();
	}
}