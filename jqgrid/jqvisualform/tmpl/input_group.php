<?php
require_once '../lang/info_en_GB.inc';
?>
<form id="input_form" action="">
	<table style="table-layout: auto;width:600px;">
		<tbody>
		<tr>
			<td style="width:35%;height:0px"></td>
			<td style="height:0px"></td>
			<td style="height:0px"></td>
		</tr>
		<tr>
			<td colspan="3" style="">
				<div class="ui-state-default ui-corner-all" style="padding:6px;">
					<span class="ui-icon ui-icon-triangle-1-s" id="showother" style="float:left; margin:-2px 5px 0 0;cursor:pointer;" title="Hide Form Properties"></span>
					Group  Properties
				</div>
			</td>
		</tr>

		<tr class="otherparam">
			<td style="width:35%;">
				<label for="label"> Label </label>
			</td>
			<td>
				<input type="text" id="label" style="width:98%;" maxlength="100" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $label?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="separator"> Separator </label>
			</td>
			<td>
				<input type="text" id="separator" name="separator" style="width:98%;" maxlength="100" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $separator?>"><span class='ui-icon ui-icon-info'></span></td>			
		</tr>
		<tr class="otherparam">
			<td>
				<label for="class"> Class </label>
			</td>
			<td>
				<input type="text" id="class" name="class" style="width:98%;" maxlength="400" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $class?>"><span class='ui-icon ui-icon-info'></span></td>			
		</tr>
		<tr class="otherparam">
			<td>
				<label for="style"> Style </label>
			</td>
			<td>
				<input type="text" id="style" name="style" style="width:98%;" maxlength="400" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $style?>"><span class='ui-icon ui-icon-info'></span></td>			
		</tr>
		
		</tbody>
	</table>
</form>