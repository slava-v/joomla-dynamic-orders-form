<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Hello World Component Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class OrdersController extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access    public
	 */
	function display(){
		//$view = &$this->getView('Orders','html');
		//$error = $this->getError();
		//$view->assign('error', $this->getError());
		//$view->display();
		parent::display();
	}

	/**
	 * Function iteratest through all form fields and validates them if a proper
	 * validator is set for field
	 *
	 * @param (object) $form
	 * @return boolean
	 */
	function validate_fields($form){
		$errors = array();

		if ($form->use_captcha){
			if ($form->captcha_type =='reCaptcha'){
				require_once(JPATH_COMPONENT . '/userlib/recaptcha-php-1.11/recaptchalib.php');

				$privatekey = "6Lf3Q9MSAAAAAAWjZKbIcN_S6wXXAdKyLbMqiHbe"; // you got this from the signup page
				$resp = recaptcha_check_answer($privatekey,
						$_SERVER["REMOTE_ADDR"],
						JRequest::getVar("recaptcha_challenge_field"),
						JRequest::getVar("recaptcha_response_field"));

				if (!$resp->is_valid) {
					// What happens when the CAPTCHA was entered incorrectly
					$errors[]="The reCAPTCHA wasn't entered correctly. Go back and try it again." .
							"(reCAPTCHA said: " . $resp->error . ")";
					return $errors;
				}
			} else {
				if ($_SESSION['captcha'] != md5(JRequest::getVar("captcha"))){
					$errors[]="The Captcha wasn't entered correctly. Go back and try it again.";
					return $errors;
				}
			}
		}

		foreach($form->fields as $f){
			if ($f->display_only && !$f->is_mandatory) continue;
			// If user inputs a value
			if ($f->is_mandatory && !JRequest::getVar($f->name)) {
				$errors[$f->name] = 'Field \''.$f->label . '\' is mandatory, cannot be left blank.';
				continue;
			}
			// If value of field is empty or no validator set, then continue to
			// next variable
			if (!JRequest::getVar($f->name) || !$f->validator ) continue;

			// Process validators
			switch($f->validator){
				case 'isEmailAddress':
					jimport('joomla.mail.helper');
					if (JMailHelper::isEmailAddress(JRequest::getVar($f->name)) == false){
						$errors[$f->name] = ( $f->validate_err ?  $f->validate_err : 'Validation error for field: ' . $f->label );
					}
			}
		}
		return $errors;
	}


	function save_order(){
		$app =& JFactory::getApplication();
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model = &$this->getModel();
		$form  = $model->getForm(JRequest::getInt('form-id'));



		/*
		 * If there is no valid email address or message body then we throw an
		* error and return false.
		*/
		$errors = $this->validate_fields($form);
		if (count($errors) > 0)
		{
			//$this->setError(implode('<br/>', $errors));
			$app->enqueueMessage(implode('<br/>', $errors), 'warning');
			$this->display();
			return false;
		} else {
			$session =& JFactory::getSession();
			$session->get('application.queue', null);
		}

		$match = array();
		$replace = array();

		if (count($form->products) > 0){
			$products = '';
			$match = array_keys((array)reset($form->products));
			foreach($match as $k => $v) {
				$match[$k] = '/\{'.$v.'\}/is';
			}
			$match[] = '/\{count\}/is';

			$quantities = JRequest::getVar('product_quantity');
			$ids = JRequest::getVar('product_id');
			foreach($quantities as $k=>$q){
				if ($q > 0){
					$replace = array_values((array)$form->products[$ids[$k]]);
					if ($form->products[$ids[$k]]->type == 'quantity'){
						$replace[] = $q;
					} else if ($form->products[$ids[$k]]->type == 'yes_no'){
						$replace[] = 'YES';
					}
					$products .= preg_replace($match, $replace, $form->products_mail_template) . "\n";

				}
			}
		}

		$match = array();
		$replace = array();
		$body = "Order details:\r\n\r\n\r\n";

		preg_match_all('/\{(\w+?)\}/i', $form->recipient_template . " " . $form->recipient_subject . " " . $form->sender_template . " " . $form->sender_subject, $arr, PREG_PATTERN_ORDER);

		foreach(array_unique($arr[1]) as $fi){
			if (JRequest::getVar($fi)){
				$match[] = "/\{". $fi . "\}/i";
				$replace[] = JRequest::getVar($fi);
			}
		}

		$fields_bak = array();
		foreach($form->fields as $f){
			if (JRequest::getVar($f->name)){
				$fields_bak[$f->name] = JRequest::getVar($f->name);
			}
		}

		$match[] = "/\{products\}/is";
		$replace[] = $products;


		$body    = preg_replace($match, $replace, $form->recipient_template);
		$subject = preg_replace($match, $replace, $form->recipient_subject);

		$sender_body    = preg_replace($match, $replace, $form->sender_template);
		$sender_subject = preg_replace($match, $replace, $form->sender_subject);

		//echo nl2br($body); return;

		$this->sendOrderToMail($form, $body, $subject, $sender_body, $sender_subject);

		if ($form->gss_form_send){
			$this->SendAsForm($form, $products, JRequest::getVar('total'));
		}

		// Backup sent order
		$model->saveOrder($body, $sender_body, base64_encode(json_encode($fields_bak)), $products);


		JFactory::getApplication()->enqueueMessage($form->thankyou_text);

		//$link = JRoute::_('index.php?option=com_orders&Itemid=26&view=orders', false);
		//$this->setRedirect($link, $form->thankyou_text);
		$this->display();
	}

	function get($url, $params = '', $options = array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		if ($params){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		foreach($options as $k => $v){
			curl_setopt($ch, $k, $v);
		}
		$str = curl_exec($ch);
		curl_close($ch);

		return $str;
	}

	function post($url, $params, $options = array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		foreach($options as $k => $v){
			curl_setopt($ch, $k, $v);
		}
		$str = curl_exec($ch);
        curl_close($ch);

        return $str;
	}

	/**
	 * Send the data to google spreadsheet through a it's form, a form in that spreadsheet is needed.
	 * And because the fields in that form are not named, and referenced through an index. The fields
	 * must be in same order
	 * @param unknown_type $form
	 */
	function SendAsForm($form=false, $products = '', $products_totals = 0){
		$field_names = array();


		//
		// Parse google form and get field labels + form field names
		//
		if($form->gss_form_version==1){
			$url = 'https://docs.google.com/spreadsheet/viewform?formkey='.$form->gss_form_key.'#gid=0';
		} else {
			$url = 'https://docs.google.com/forms/d/'.$form->gss_form_key.'/viewform';
		}
		$frm_text = $this->get($url);

		if (preg_match_all('/class="ss-q-title".*?>(.+?)<.*?name="(.+?)"/ism', $frm_text, $arr, PREG_SET_ORDER) > 0){
			//var_dump($arr);
			foreach($arr as $a){
				$field_names[strtolower(trim($a[1]))] = trim($a[2]);
			}
		}

		if ($form->gss_form_version==1){
			$url = 'https://docs.google.com/spreadsheet/formResponse?formkey='.$form->gss_form_key.'&ifq';
		} else {
			$url='https://docs.google.com/forms/d/'.$form->gss_form_key.'/formResponse';
		}

		// Build post parameters
		$data = array(
				'pageNumber'=>0,
				'backupCache' => '',
				'submit'=>'Submit');

		foreach($form->fields as $f){
			$fn = strtolower($f->name);
			$fl = strtolower($f->label);
			if (isset($field_names[$fn])) {
				$data[$field_names[$fn]] = JRequest::getVar($f->name); //1
			} else if (isset($field_names[$fl])) {
				$data[$field_names[$fl]] = JRequest::getVar($f->name); //1
			}
		}

		if (isset($field_names['products']))
			$data[$field_names['products']] = $products;

		if (isset($field_names['totals']))
			$data[$field_names['totals']] = $products_totals;

		$out = $this->post($url, $data);
		echo "<!--\n\n" . $out ;
		var_dump($data);
		echo "\n\n-->";
	}

	/**
	 * Function sends the data to spreadsheet as XML feed
	 * @todo: To send an entry there is needed an authorizatoin even if the spreadsheet is public
	 *
	 * @param unknown_type $form
	 */
	function SendAsXML($form = false){
		if (!$form){
			$model = $this->getModel();
			$form  = $model->getForm(1);
		}

		//$url = "https://spreadsheets.google.com/feeds/cells/{$form->gss_id}/{$form->gss_sheet_id}/private/full";
		$url = "https://spreadsheets.google.com/feeds/list/{$form->gss_id}/{$form->gss_sheet_id}/private/full";

		$post_data = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:gsx="http://schemas.google.com/spreadsheets/2006/extended">
		<gsx:timestamp>6/24/2012 13:22:25</gsx:timestamp>
		<gsx:firstname>333</gsx:firstname>
		<gsx:lastname>333</gsx:lastname>
		<gsx:email>asdf@mail.com</gsx:email>
		<gsx:phone>1234123123441234</gsx:phone>
	</entry>';
		$options = array(
			CURLOPT_HTTPHEADER => array('Content-type: application/atom+xml')
		);
		$out = $this->post($url, array($post_data), $options);
		echo $out;
	}


	function sendOrderToMail($form, $body, $subject, $sender_body, $sender_subject){
		global $mainframe;


		/*
		 * If there is no valid email address or message body then we throw an
		* error and return false.
		*/
		jimport('joomla.mail.helper');

		// Contact plugins
		$MailFrom 	= $mainframe->getCfg('mailfrom');
		$FromName 	= $mainframe->getCfg('fromname');
		$SiteName	= $mainframe->getCfg('sitename');

		// Prepare email body

		$mail = JFactory::getMailer();

		$mail->addRecipient( $form->recipient );
		$mail->setSender( array( $MailFrom, $FromName ) );
		$mail->setSubject( $subject );
		$mail->setBody( $body );

		$sent = $mail->Send();

		/*
		 * If we are supposed to copy the admin, do so.
		*/
		// check whether email copy function activated
		if ( $form->send_copy && ($form->sender_field_name && JRequest::getVar($form->sender_field_name)))
		{
			$mail = JFactory::getMailer();

			$mail->addRecipient( JRequest::getVar($form->sender_field_name) );
			$mail->setSender( array( $MailFrom, $FromName ) );
			$mail->setSubject( $sender_subject );
			$mail->setBody( $sender_body );

			$sent = $mail->Send();
		}


	}

	function captcha(){
		session_start();
		$doc = &JFactory::getDocument();
		$docRaw = &JDocument::getInstance('raw');
		$doc = $docRaw;
		$doc->setMimeEncoding('image/gif');

		// generate random number and store in session
		//$randomnr = rand(1000, 9999);
		$randomnr ='';
		//$letters = array_merge(range('a','z'), range(0,9));
		$letters = range(0,9);
		for($i=0;$i<6;$i++){
			$randomnr .= $letters[rand(0,count($letters)-1)];
		}

		$_SESSION['captcha']= md5($randomnr);
		//generate image
		$im = imagecreatetruecolor(100, 38);
		//colors:
		$white = imagecolorallocate($im, 255, 255, 255);
		$grey = imagecolorallocate($im, 128, 128, 128);
		$sky_blue = imagecolorallocate($im, hexdec("DF"), hexdec("E3"), hexdec("F0"));

		$black = imagecolorallocate($im, 110, 110, 110);
		imagefilledrectangle($im, 0, 0, 200, 38, $white);

		// -------------      your fontname    -------------
		//  example font http://www.webpagepublicity.com/free-fonts/a/Anklepants.ttf
		$font = dirname(__FILE__) . '/userlib/Medrano.ttf';
		//draw text:
		imagettftext($im, 20, 0, 5, 24, $grey, $font, $randomnr);
		//imagettftext($im, 20, 0, 10, 23, $black, $font, $randomnr);
		//imagettftext($im, 20, 0, 7, 26, $white, $font, $randomnr);
		#7D89B0
		for($i=0; $i<3;$i++){
			$col = imagecolorallocate($im, rand(1,255), rand(1,255), rand(1,255));
			imageline($im, rand(1,200), rand(1,35), rand(1,200), rand(1,35), $col);
		}

		// prevent client side  caching
		//header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
		//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		//header("Cache-Control: no-store, no-cache, must-revаlidate");
		//header("Cache-Control: post-check=0, pre-check=0", false);
		//header("Pragma: no-cache");

		//send image to browser
		//header ("Content-type: image/gif");
		imagegif($im);
		imagedestroy($im);
	}
}
