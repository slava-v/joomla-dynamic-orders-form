<?php defined('_JEXEC') or die('Restricted access'); ?>
<h1><?php echo $this->form->title; ?></h1>
<div class="display-orders-form">
	<form action="index.php" method="post" accept-charset_="utf8">
	<?php echo $this->loadTemplate('fields');?>
	<?php if ($this->form->use_captcha){?>
		<h3>Captcha</h3>
	<?php if ($this->form->captcha_type == 'simple') {?>
	<div style="width:100px;heigth:38px;background-color:gray;display:block;float:left;margin-right:10px;">
		<img id="captcha" src="<?php echo JURI::base() ?>index.php?option=com_orders&task=captcha" />
	</div>
	<input type="text" name="captcha" class="inputbox" />
	<div style="clear:both;"></div>
	<a href="javascript:;" onclick="var c=document.getElementById('captcha'); c.src=c.src;">Reload</a>
	<?php } else { echo $this->captcha;  }}?>
	<div class="buttons">
		<input type="submit" name="submit" value="Submit" />
	</div>
	<input type="hidden" name="option" value="com_orders"/>
	<input type="hidden" name="task" value="save_order"/>
	<input type="hidden" name="view" value="orders"/>
	<input type="hidden" name="form-id" value="<?= $this->form->id ?>"/>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
