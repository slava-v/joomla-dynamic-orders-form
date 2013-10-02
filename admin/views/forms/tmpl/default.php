<h2>Forms list</h2>
<form action="index.php?option=com_orders" method="post" name="adminForm">
<table class="adminlist">
	<thead>
		<tr>
			<th nowrap="nowrap" width="10">Id</th>
			<th width="10" class="title">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->forms); ?>);" />
			</th>
			<th nowrap="nowrap">Title</th>
		</tr>
	</thead>
	<tbody>
<?php
$i=0;
foreach($this->forms as $f){

	$checked = JHTML::_('grid.id', $i, $f->id, false, 'id' );
	$url = JRoute::_('index.php?option=com_orders&view=forms&layout=default_form&id='.$f->id);

?>
	<tr>
		<td><?php echo $f->id ?></td>
		<td><?php echo $checked ?></td>
		<td><a title="Edit form" href="<?php echo $url; ?>"><?php echo $f->title?></a></td>
	</tr>
<?php $i++; }?>
	</tbody>
</table>
<input type="hidden" name="option" value="com_orders" />
<input type="hidden" name="controller" value="forms" />
<input type="hidden" name="view" value="forms" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="chosen" value="" />
<input type="hidden" name="act" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>