	<script type="text/javascript">

		function ct(){
			var t = 0;
			var pp = document.getElementsByName('product_price[]');
			var pq = document.getElementsByName('product_quantity[]');
			for(var i=0;i<pp.length;i++){
				if (isNaN(parseInt(pq[i].value))){
					pq[i].value = 0;
				}
				if (pq[i].type == 'text'){
					t += parseInt(pp[i].value)*parseInt(pq[i].value);
				} else if (pq[i].type == 'checkbox' && pq[i].checked) {
					t += parseInt(pp[i].value)*parseInt(pq[i].value);
				}
			}
			document.getElementById('total').value = t;
		}

		function inc(i){
			var e = document.getElementById('q'+i);
			e.value = parseInt(e.value)+1;
		}
		function dec(i){
			var e = document.getElementById('q'+i);
			if (parseInt(e.value)>0) e.value = parseInt(e.value)-1;
		}

		function kp(evt,i){
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode==38)inc(i);
			if (charCode==40)dec(i);
			if (charCode==38||charCode==40) ct();
	            //alert ("The Unicode character code is: " + chCode);
		}
	</script>
	<ul class="products">
<?php
	$i=0;
	$pq=JRequest::getVar('product_quantity');
 	foreach($this->form->products as $p){
$class = ($this->form->products_fields_class ? ' class="'.$this->form->products_fields_class.'"' : '');
$style = ($this->form->products_fields_style ? ' style="'.$this->form->products_fields_style.'"' : '');
	?>
		<li><span class="title"><?= $p->title ?></span>

			<div class="picture"><span class="no-image">No image</span><a href="<?= $p->picture ?>" rel="lightbox_05"><img src="<?= $p->picture ?>" /></a></div>

			<div class="description"><?= $p->description ?>
				<div class="price"><b>Price:</b> <?= $p->price ?> <?= $p->currency ?>
					<input type="hidden" name="product_price[]" value="<?= $p->price ?>" />
					<input type="hidden" name="product_id[]" value="<?= $p->id ?>" />
				</div>
<?php if ($p->type == 'quantity') {?>
				<div class="quantity"><label for="q<?= $i ?>">Quantity:</label>
					<input id="q<?= $i ?>" <?= $class ?> <?= $style ?> type="text" name="product_quantity[]" value="<?= $pq[$i] ?>" onchange="ct()" size="2" readonly="readonly" onkeypress="kp(event,<?= $i ?>);"/>
				</div>
				<div class="icons">
					<a href="javascript:;" onclick="inc(<?= $i ?>);ct();"><img src="<?php JURI::base() ?>/images/up-icon.gif"/></a><br/>
					<a href="javascript:;" onclick="dec(<?= $i ?>);ct();"><img src="<?php JURI::base() ?>/images/down-icon.gif"/></a>
				</div>
<?php } else if ($p->type == 'yes_no') {?>
				<div class="quantity"><label for="q<?= $i ?>">Yes</label>
					<input id="q<?= $i ?>" <?= $class ?> <?= $style ?> type="checkbox" name="product_quantity[]" value="1" onchange="ct();" />
				</div>
<?php }?>
			</div>
		</li>
<?php $i++;	} ?>
		<div style="clear:both;"></div>
		<p>
			<label for="total">Totals:</label><input <?= $class ?> <?= $style ?> id="total" type="text" name="total" value="0" readonly="readonly" size="5"/>
		</p>
	</ul>
		<script type="text/javascript">setTimeout(ct, 1000);</script>