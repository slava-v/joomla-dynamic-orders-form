<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $sel = ' selected="selected" '?>
<div class="products orders-form">
	<form id="adminForm" name="adminForm" action="index.php" method="post" accept-charset="utf8">
<?php if (JRequest::getVar('popup')) {?>
	<p class="top-button"><input type="submit" name="submit1" value="Submit"  /></p>
<?php } ?>
	<h1><?php echo (JRequest::getVar('new') ? "New product" : $this->product->title ); ?></h1>
	<table>
		<tr>
			<td><label for="title">Title </label></td>
			<td><input id="title" type="text" name="title" value="<?php echo $this->product->title ?>" style="width:90%;"/></td>
		</tr>
		<tr>
			<td><label for="description">Description </label></td>
			<td><textarea id="description" name="description" cols="60" rows="6"><?php echo $this->product->description ?></textarea></td>
		</tr>
		<tr>
			<td><label for="type">Type </label></td>
			<td><select id="type" name="type">
					<option value="quantity" <?php echo ($this->product->type == 'quantity' ? $sel : '' ) ?>>Quantifiable</option>
					<option value="yes_no" <?php echo ($this->product->type == 'yes_no' ? $sel : '' ) ?>>Yes/No option</option>
			</select></td>
		</tr>
		<tr>
			<td><label for="orders_form_id">Form </label></td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->forms, 'orders_form_id', null, 'id', 'title', $this->product->orders_form_id)?>
			</td>
		</tr>
		<tr>
			<td><label for="order">Order </label></td>
			<td><input id="order" type="text" name="order" value="<?php echo $this->product->order ?>" size="2"/></td>
		</tr>
		<tr>
			<td><label for="price">Price </label></td>
			<td><input id="price" type="text" name="price" value="<?php echo $this->product->price ?>" size="10"/></td>
		</tr>
		<tr>
			<td><label for="currency">Currency </label></td>
			<td><input id="currency" type="text" name="currency" value="<?php echo $this->product->currency ?>" size="3"/></td>
		</tr>
		<tr>
			<td><label for="picture">Picture </label></td>
			<td><input id="picture" type="hidden" name="picture" value="<?php echo $this->product->picture ?>" />
				<div class="pic-preview">
					<div class="no-image">No image</div>
					<img id="preview" src="<?php echo $this->product->picture ?>"/>
				</div>
<?php if ($this->product->picture ) { ?>
				<a id="picture_btn" href="javascript:;" title="Delete image" class="red" onclick="deleteImage()">Delete current image</a>
<?php }?>
<script type="text/javascript">
//<!--
    function jInsertEditorText(tag, el){
        if (tag == '') return;
    	var url = /src="(.+?)"/.exec(tag)[1];
        document.getElementById('preview').setAttribute('src', '<?php echo JURI::root() ?>' + url);
        document.getElementById('picture').value=url;
    }
    function deleteImage(){
    	document.getElementById('preview').setAttribute('src', '<?php echo JURI::root() ?>' + url);
        document.getElementById('picture').value=url;
    }

//-->
</script>
<?php JHTML::_('behavior.modal', 'a.modal-button'); ?>
				<div class="button2-left" style="float:right">
					<div class="image">
						<a class="modal-button" title="Image" href="index.php?option=com_media&view=images&layout=default&tmpl=component&folder=products" rel="{handler: 'iframe', size: {x: 570, y: 400}}">Select Image</a>
					</div>
				</div>
			</td>
		</tr>
	</table>

	<input type="hidden" name="option" value="com_orders"/>
	<input type="hidden" name="controller" value="products"/>
	<input type="hidden" name="task" value="productSave"/>
	<input type="hidden" name="view" value="products"/>
	<input type="hidden" name="id" value="<?php echo $this->product->id ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>