<h2>Fields list</h2>
<script type="text/javascript">
function queueReload(){ setTimeout(window.location.reload, 500); }
</script>
<form action="index.php?option=com_orders" method="post" name="adminForm">
<table class="adminlist">
	<thead>
		<tr>
			<th nowrap="nowrap" width="10">Id</th>
			<th width="10" class="title">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->fields); ?>);" />
			</th>
			<th nowrap="nowrap" width="40">Type</th>
			<th nowrap="nowrap" width="10">Form id</th>
			<th nowrap="nowrap" width="10">Order <?php echo JHTML::_('grid.order', $this->fields)?></th>
			<th nowrap="nowrap" width="20">Published</th>
			<th nowrap="nowrap" width="100">Name</th>
			<th width="100">Label</th>
			<th>Default value</th>
			<th nowrap="nowrap" width="30">Mandatory</th>
			<th nowrap="nowrap" width="30">View only</th>
		</tr>
	</thead>
	<tbody>
<?php
$i=0;
JHTML::_('behavior.modal', 'a.modal-button');
foreach($this->fields as $f){

	$checked = JHTML::_('grid.id', $i, $f->id, false, 'id' );
	$url = JRoute::_('index.php?option=com_orders&view=fields&layout=default_form&tmpl=component&popup=1&id='.$f->id);

?>
	<tr>
		<td><?php echo $f->id ?></td>
		<td><?php echo $checked ?></td>
		<td><?php echo $f->type ?></td>
		<td><?php echo $f->orders_form_id?></td>
		<td><input type="text" name="order[]" value="<?php echo $f->order?>" size="2" maxlength="2"/></td>
		<td align="center">
			<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $f->enabled ? 'unpublish' : 'publish' ?>')">
			<img src="images/<?php echo  ($f->enabled ? 'tick.png' : 'publish_x.png') ?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
		</td>
		<td>
			<a class="modal-button" title="Edit field" href="<?php echo $url; ?>" rel="{handler: 'iframe', size: {x: 570, y: 450}, onClose: function(){ parent.queueReload();}}"><?php echo $f->name?></a>
		</td>
		<td><?php echo $f->label?></td>
		<td><?php echo nl2br($f->default_value) ?></td>
		<td nowrap="nowrap" align="center"><?php echo $f->is_mandatory ? 'Yes' : ''?></td>
		<td nowrap="nowrap" align="center"><?php echo $f->display_only ? 'Yes' : ''?></td>
	</tr>
<?php $i++; }?>
	</tbody>
</table>
<input type="hidden" name="option" value="com_orders" />
<input type="hidden" name="view" value="fields" />
<input type="hidden" name="controller" value="fields" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="chosen" value="" />
<input type="hidden" name="act" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>