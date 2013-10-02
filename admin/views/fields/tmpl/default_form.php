<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip');?>
<div class="fields orders-form">
	<form id="adminForm" name="adminForm" action="index.php" method="post" accept-charset="utf8" <?php echo ( JRequest::getVar('popup') ? 'onsubmit="window.parent.document.getElementById(\'sbox-window\').close();"' : ''); ?>>
<?php if (JRequest::getVar('popup')) {?>
	<p class="top-button"><input type="submit" name="submit1" value="Submit"  /></p>
<?php } ?>
	<h1>Edit: <?php echo (JRequest::getVar('new') ? "New Field" :  '[ '.$this->field->name .'] field' ); ?></h1>

	<p class="group">General settings</p>

	<label for="name">Name </label>
	<input id="name" type="text" name="name" value="<?php echo $this->field->name ?>"/>

	<label for="label">Label </label>
	<input id="label" name="label" type="text" value="<?php echo $this->field->label ?>" />

	<label for="help_text">Help text</label>
	<input id="help_text" name="help_text" type="text" value="<?php echo $this->field->help_text ?>" />

	<label for="Type">Type</label>
	<?php echo JHTML::_('select.genericlist', $this->fieldTypes, 'type', array('onchange' => 'show_help(this.value);'), 'value', 'text', $this->field->type) ?>
	<script type="text/javascript">
	function show_help(val){
		switch(val){
<?php foreach($this->fieldTypes as $a){ if (FALSE === isset($a['helptext']) || trim($a['helptext']) == '') continue; ?>
			case '<?= $a['value'] ?>': document.getElementById('helptext').innerHTML = '<?= preg_replace("/\'/", "''", $a['helptext'] ); ?>'; break;
<?php } ?>
			default: return 1;
		}
	}
	</script>

	<input id="is_mandatory" type="checkbox" name="is_mandatory" value="1" <?php echo ($this->field->is_mandatory ? ' checked="checked" ':'') ?>/>
	<label for="is_mandatory" class="hasTip" title="Display only::If is checked, the field will be checked to be filled with value before submitting the form">Is required field</label>
	<br/>
	<label for="default_value" >Default value</label>
	<div id="helptext" style="color: green;float:right;font-weight:bold;"></div>
	<textarea id="default_value" name="default_value" cols="60" rows="6"><?php echo $this->field->default_value ?></textarea>

	<label for="orders_form_id" class="hasTip">Form where to include</label>
	<?php echo JHTML::_('select.genericlist', $this->forms, 'orders_form_id', null, 'id', 'title', $this->field->orders_form_id)?>


	<p class="group">Validation settings</p>
	<label for="validator">Validator function</label>
	<?php echo JHTML::_('select.genericlist', $this->validators, 'validator', null, 0, 1, $this->field->validator) ?>

	<label for="validate_err">Validate error message</label>
	<input id="validate_err" type="text" name="validate_err" value="<?php echo $this->field->validate_err ?>"/>

	<p class="group">Display settings</p>

	<label for="class">Style class name</label>
	<input id="class" type="text" name="class" value="<?php echo $this->field->class ?>"/>

	<label for="style">Field inline style </label>
	<input id="style" type="text" name="style" value="<?php echo $this->field->style ?>"/>

	<input id="label_after" type="checkbox" name="label_after" value="1" <?php echo ($this->field->label_after ? ' checked="checked" ':'') ?>/>
	<label for="label_after" class="hasTip" title="Label after::If is checked, the label will be placed after input box">Place label after input field</label>
	<br/>
	<input id="display_only" type="checkbox" name="display_only" value="1" <?php echo ($this->field->display_only ? ' checked="checked" ':'') ?>/>
	<label for="display_only" class="hasTip" title="Display only::If is checked, the field will be used as display only. It will not be checked or used to be printed anywhere in email">Use for view only</label>
	<br/>

	<label for="order">Order</label>
	<input id="order" type="text" name="order" value="<?php echo $this->field->order ?>"/>

	<input type="hidden" name="option" value="com_orders"/>
	<input type="hidden" name="controller" value="fields"/>
	<input type="hidden" name="task" value="save"/>
	<input type="hidden" name="view" value="fields"/>
	<input type="hidden" name="redirect" value="index.php?option=com_orders&view=fields" />
	<input type="hidden" name="id" value="<?php echo $this->field->id ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<br/>
<br/>