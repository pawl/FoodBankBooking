<?php
require_once '../lang/info_en_GB.inc';
?>
<form id="input_text">
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
					Submit Button  Properties
				</div>
			</td>
		</tr>
		<tr class="otherparam">
			<td style="width:35%;">
				<label for="disabled"> Disabled </label>
			</td>
			<td>
				<input type="checkbox" id="disabled" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $disabled?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="form"> Form ID </label>
			</td>
			<td>
				<input type="text" id="form"  name="form"  style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $form?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="value"> Value </label>
			</td>
			<td>
				<input type="text" id="value" name="value" style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $value?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="formaction"> Form Action </label>
			</td>
			<td>
				<input type="text" id="formaction"  name="formaction" style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $formaction?>"><span class='ui-icon ui-icon-info'></span></td>
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
				<label for="formenctype"> Form MIME Type </label>
			</td>
			<td>
				<select id="formenctype" name="formenctype" class="ui-widget-content ui-corner-all select-ui"><option value="">Select</option><option value="text/plain">text/plain</option><option value="multipart/form-data">multipart/form-data</option><option value="application/x-www-form-urlencoded">application/x-www-form-urlencoded</option></select>
			</td>
			<td class="help" title="<?php echo $formenctype?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="formmethod"> Form Method </label>
			</td>
			<td>
				<select id="formmethod" name="formmethod" class="ui-widget-content ui-corner-all select-ui"><option value="">Select</option><option value="post">POST</option><option value="get">GET</option></select>
			</td>
			<td class="help" title="<?php echo $formmethod?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="formtarget"> Form Target </label>
			</td>
			<td>
				<input type="text" id="formtarget" name="formtarget" style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $formtarget?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="formnovalidate"> Form No Validate </label>
			</td>
			<td>
				<input type="checkbox" id="formnovalidate" name="formnovalidate" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $formnovalidate?>"><span class='ui-icon ui-icon-info'></span></td>
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