<h2>Product list</h2>
<form action="index.php?option=com_orders" method="post" name="adminForm">
<table class="adminlist">
	<thead>
		<tr>
			<th nowrap="nowrap" width="10">Id</th>
			<th width="10" class="title">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->products); ?>);" />
			</th>
			<th nowrap="nowrap" width="40">Type</th>
			<th nowrap="nowrap" width="10">Form id</th>
			<th nowrap="nowrap" width="10">Order <?php echo JHTML::_('grid.order', $this->products)?></th>
			<th nowrap="nowrap" width="20">Published</th>
			<th nowrap="nowrap" width="100">Title</th>
			<th>Description</th>
			<th width="200">Picture</th>
			<th nowrap="nowrap" width="30">Price</th>
		</tr>
	</thead>
	<tbody>
<?php
$i=0;
JHTML::_('behavior.modal', 'a.modal-button');
foreach($this->products as $p){

	$checked = JHTML::_('grid.id', $i, $p->id, false, 'id' );
	$url = JRoute::_('index.php?option=com_orders&view=products&layout=default_form&popup=1&tmpl=component&id='.$p->id);

?>
	<tr>
		<td><?php echo $p->id ?></td>
		<td><?php echo $checked ?></td>
		<td><?php echo $p->type ?></td>
		<td><?php echo $p->orders_form_id?></td>
		<td><input type="text" name="order[]" value="<?php echo $p->order?>" size="2" maxlength="2"/></td>
		<td>
			<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $p->enabled ? 'unpublish' : 'publish' ?>')">
			<img src="images/<?php echo  ($p->enabled ? 'tick.png' : 'publish_x.png') ?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
		</td>
		<td>
			<a class="modal-button" title="Edit product" href="<?php echo $url; ?>" rel="{handler: 'iframe', size: {x: 570, y: 450}}"><?php echo $p->title?></a>
		</td>
		<td><?php echo $p->description?></td>
		<td><?php if($p->picture ){ ?>
		<div style="height:150px;width:150px;overflow:hidden;">
		<img src="<?php echo $p->picture?>" style="width:150px;"/>
		</div>
		<?php } else { echo "No picture";}?>
		</td>
		<td nowrap="nowrap"><?php echo $p->price?> <?php echo $p->currency?></td>
	</tr>
<?php $i++; }?>
	</tbody>
</table>
<input type="hidden" name="option" value="com_orders" />
<input type="hidden" name="view" value="products" />
<input type="hidden" name="controller" value="products" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="chosen" value="" />
<input type="hidden" name="act" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>