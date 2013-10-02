<?php
foreach($this->form->fields as $f) {
	$s = ($f->style ? ' style="'.$f->style.'"':'');
	$c = ($f->class ? ' class="'.$f->class.'"':'');
	$val = (JRequest::getVar($f->name) ? JRequest::getVar($f->name) : $f->default_value );
	echo "\n".$this->form->surround_fields[0];

	$m = ( $f->is_mandatory ? '<span class="m">*</span>' : '');

	if ($f->label && !$f->label_after) {
		printf('<label for="%s">%s %s</label><br/>',$f->name, $f->label, $m);
	}

	if ($f->help_text){
		echo '<div class="help-text">'.$f->help_text.'</div>';
	}

	if($f->type == 'checkbox' || $f->type == 'text'){
		printf('<input id="%s" type="%s" name="%1$s" %s %s value="%s"/>',$f->name,$f->type,$c,$s,$val);
	} else if( $f->type == 'textarea'){
		printf('<textarea id="%s" name="%1$s" %s %s>%s</textarea>',$f->name, $c, $s,$val);
	} else if ($f->type == 'static') {
		printf('<div class="field-static" id="%s" %s %s>%s</div>',$f->name, $c,$s,nl2br($val));
	} else if ($f->type == 'dropdown-list'){
		printf('<select id="%s" name="%1$s" %s %s>', $f->name, $c, $s);
		printf('<option value=""></option>');
		if ($f->default_value != ''){
			$values = explode("\n", trim(trim($f->default_value,"\r\n")));
			$selected = JRequest::getVar($f->name);
			foreach($values as $v){
				printf('<option value="%s"%s>%1$s</option>',$v, ($selected == trim($v) ? 'selected="selected"':''));
			}
		}
		printf('</select>');
	}

	if ($f->label && $f->label_after) {
		printf('<label for="%s">%s %s</label>',$f->name, $f->label, $m);
	}

	echo $this->form->surround_fields[1];

	if ($f->name == $this->form->products_after){
		echo $this->form->surround_fields[0];
		echo "<h3>Products</h3>";
		echo $this->loadTemplate('product');
		echo $this->form->surround_fields[1];
	}
}
?>
