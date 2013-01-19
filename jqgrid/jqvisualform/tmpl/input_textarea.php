<?php
require_once '../lang/info_en_GB.inc';
?>

<form id="input_text">
	<table style="table-layout: auto;width:600px;">
		<tbody>
		<tr>
			<td style="height:0px;width:35%"></td>
			<td style="height:0px"></td>
			<td style="height:0px"></td>
		</tr>
		<tr>
			<td colspan="3" style="">
				<div class="ui-state-default ui-corner-all" style="padding:6px;">
					<span class="ui-icon ui-icon-triangle-1-s" id="showother" style="float:left; margin:-2px 5px 0 0;cursor:pointer;" title="Hide Form Properties"></span>
					Input Text  Properties
				</div>
			</td>
		</tr>
		<tr class="otherparam">
			<td style="width:35%;">
				<label for="label"> Label </label>
			</td>
			<td>
				<input type="text" id="label" name="label" style="width:98%;" maxlength="100" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $label?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="autofocus"> Autofocus </label>
			</td>
			<td>
				<input type="checkbox" id="autofocus" name="autofocus" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $autofocus?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="cols"> Cols </label>
			</td>
			<td>
				<input type="text" id="cols"  name="cols" style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $cols?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="disabled"> Disabled </label>
			</td>
			<td>
				<input type="checkbox" id="disabled" name="disabled" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $disabled?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="form"> Form ID </label>
			</td>
			<td>
				<input type="text" id="form"  name="form" style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $form?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="maxlength"> Maximal length </label>
			</td>
			<td>
				<input type="text" id="maxlength" style="width:98%;" name="maxlength" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $maxlength?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="placeholder"> Placeholder </label>
			</td>
			<td>
				<input type="text" id="placeholder" style="width:98%;" name="placeholder" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $placeholder?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="readonly"> Readonly </label>
			</td>
			<td>
				<input type="checkbox" id="readonly" name="readonly" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $readonly?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="required"> Required  </label>
			</td>
			<td>
				<input type="checkbox" id="required" name="required" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $required?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>

		<tr class="otherparam">
			<td>
				<label for="rows"> Rows </label>
			</td>
			<td>
				<input type="text" id="rows" style="width:98%;" name="rows" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $rows?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="wrap"> Wrap </label>
			</td>
			<td>
				<select id="wrap" name="wrap" class="ui-widget-content ui-corner-all select-ui"><option value="">Select</option><option value="hard">Hard</option><option value="soft">Soft</option></select>
			</td>
			<td class="help" title="<?php echo $wrap?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr>
			<td colspan="3" style="">
				<div class="ui-state-default ui-corner-all" style="padding:6px;">
					<span class="ui-icon ui-icon-triangle-1-e" id="showglob" style="float:left; margin:-2px 5px 0 0;cursor:pointer;" title="Show Global Attributes"></span>
					Global Attributes
				</div>
			</td>
		</tr>
		<?php include 'global_attr.inc';?>

		</tbody>
	</table>
</form>