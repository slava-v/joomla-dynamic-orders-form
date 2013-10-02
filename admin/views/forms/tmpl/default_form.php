<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip');?>
<div class="forms orders-form">
	<form id="adminForm" name="adminForm" action="index.php" method="post" accept-charset="utf8">
<?php if (JRequest::getVar('popup')) {?>
	<p class="top-button"><input type="submit" name="submit1" value="Submit"  /></p>
<?php } ?>
	<h1>Edit: <?php echo (JRequest::getVar('new') ? "New Form" :  '['.$this->form->title .'] form' ); ?></h1>

	<p class="group">General settings</p>

	<label for="title">Title </label>
	<input id="title" type="text" name="title" value="<?php echo $this->form->title ?>"/>
<!--
	<label for="fields_included" class="hasTip" title="Fields included::Enter comma separated field name list of fields wanted to be included in order mail">Fields included in email </label>
	<?php echo JHTML::_('select.genericlist', $this->fields, 'fields_included[]', array('size'=>10, 'multiple'=>'multiple'), 'name', 'name', explode(',' , $this->form->fields_included))?>
 -->
<br/>
	<label for="surround_fields">HTML code to surround fields with ( the pipe <b>|</b> is where the field code will be inserted )</label>
	<input id="surround_fields" type="text" name="surround_fields" value="<?php echo htmlentities($this->form->surround_fields) ?>"/>


	<input id="use_captcha" type="checkbox" name="use_captcha" onclick="var e=document.getElementById('captcha_type'); if(this.checked){ e.removeAttribute('disabled'); } else { e.setAttribute('disabled','disabled')}" value="1" <?php echo ($this->form->use_captcha ? ' checked="checked" ':'') ?>/>
	<label for="use_captcha" class="hasTip" title="Use captcha::If is checked, the form will be additionally secured with reCapthca image">Use captcha to secure form</label>
	<br/>
	<br/>
	<label for="captcha_type" class="hasTip" title="Captcha::Choose one">Captcha type</label>
	<select id="captcha_type" name="captcha_type" <?= (!$this->form->use_captcha ? ' disabled="disabled" ':'') ?>>
		<option value="reCaptcha" <?= ($this->form->captcha_type == 'reCaptcha' ? 'selected="selected"':'')?>>reCaptcha (more complex)</option>
		<option value="simple" <?= ($this->form->captcha_type == 'simple' ? 'selected="selected"':'')?>>simple</option>
	</select>



	<br/>
	<label for="thankyou_text" >Thank you text (displayed on page, after user has completed and submited the form)</label>
	<textarea id="thankyou_text" name="thankyou_text" cols="60" rows="6"><?php echo $this->form->thankyou_text ?></textarea>

	<p class="group">Recipient Email</p>

	<label for="recipient">Email address</label>
	<input id="recipient" type="text" name="recipient" value="<?php echo $this->form->recipient ?>"/>

	<label for="recipient_subject">Email Subject</label>
	<input id="recipient_subject" type="text" name="recipient_subject" value="<?php echo $this->form->recipient_subject ?>"/>

	<label for="recipient_template" class="hasTip" title="Email template::In email template can be used field names enclosed in {} and {products} for products list position">Email template</label>
	<textarea id="recipient_template" name="recipient_template" cols="60" rows="6"><?php echo $this->form->recipient_template ?></textarea>

	<p class="group">Sender Email</p>

	<input id="send_copy" type="checkbox" name="send_copy" value="1" <?php echo ($this->form->send_copy ? ' checked="checked" ':'') ?>/>
	<label for="send_copy" class="hasTip" title="Send a copy::If is checked, the user that places a order receives a order copy on his email address specified on form.">Send order to client</label>
	<br/>

	<label for="sender_field_name">What field will be used as sender email address?</label>
	<?php echo JHTML::_('select.genericlist', $this->fields, 'sender_field_name', null, 'name', 'name', $this->form->sender_field_name)?>

	<label for="sender_subject">Email Subject</label>
	<input id="sender_subject" type="text" name="sender_subject" value="<?php echo $this->form->sender_subject ?>"/>

	<label for="sender_template" class="hasTip" title="Email template::In email template can be used field names enclosed in {} and {products} for products list position">Email template.</label>
	<textarea id="sender_template" name="sender_template" cols="60" rows="6"><?php echo $this->form->sender_template ?></textarea>

	<p class="group">Google Spreadsheet Settings</p>
	<input id="gss_form_send" type="checkbox" name="gss_form_send" value="1" <?php echo ($this->form->gss_form_send ? ' checked="checked" ':'') ?>/>
	<label for="gss_form_send" class="hasTip" title="Send data to google spreadsheet::If checked, the form data is sent to a google form (spreadsheet) separately prepared. &lt;br&gt;Additional instructions in help file supplied.">Activate</label>

	<br/>
	Is this a new version of google forms ?
	<input id="gss_form_version1" type="radio" name="gss_form_version" value="1" <?php echo ($this->form->gss_form_version == 1? 'checked="checked"':'')?>/><label for="gss_form_version1">No</label>
	<input id="gss_form_version2" type="radio" name="gss_form_version" value="2" <?php echo ($this->form->gss_form_version == 2? 'checked="checked"':'')?>/><label for="gss_form_version2">Yes</label>

	<br/><br/>
	<label for="gss_form_key" class="hasTip" title="Google spreadsheet form key::The form key can be found in address of a live form page. The value of &lt;b&gt;formkey=&lt;/b&gt; url parameter.">Form key</label>
	<input id="gss_form_key" type="text" name="gss_form_key" value="<?php echo $this->form->gss_form_key ?>"/>

	<p class="group">Product Display settings</p>
	<label for="products_after">Field name after witch the products will be printed</label>
	<?php echo JHTML::_('select.genericlist', $this->fields, 'products_after', null, 'name', 'name', $this->form->products_after)?>

	<label for="products_fields_class" class="hasTip" title="Class Name::Class name applied to product html tag. Class has to be declared first in template.css or another joomla stylesheet file.">Class name for product fields</label>
	<input id="products_fields_class" type="text" name="products_fields_class" value="<?php echo $this->form->products_fields_class ?>"/>

	<label for="products_fields_style" class="hasTip" title="Styles::Inline styles applied to products">Styles applied to fields</label>
	<input id="products_fields_style" type="text" name="products_fields_style" value="<?php echo $this->form->products_fields_style ?>"/>

	<label for="products_mail_template" class="hasTip" title="Products email template::This is for one product, and it will be used subsequently for all selected products. Available self explanatory placeholders {title},{price},{currency},{count},{description}">Product item email template.</label><br/>
	<textarea id="products_mail_template" name="products_mail_template" cols="60" rows="6"><?php echo $this->form->products_mail_template ?></textarea>

	<input type="hidden" name="option" value="com_orders"/>
	<input type="hidden" name="controller" value="forms"/>
	<input type="hidden" name="task" value="save"/>
	<input type="hidden" name="view" value="forms"/>
	<input type="hidden" name="id" value="<?php echo $this->form->id ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>