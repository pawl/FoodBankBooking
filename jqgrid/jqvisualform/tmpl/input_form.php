<?php
require_once '../lang/info_en_GB.inc';
?>
<form id="input_form" action="">
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
					Form  Properties
				</div>
			</td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="accept-charset"> Accept charset </label>
			</td>
			<td>
				<input type="text" id="accept-charset" name="accept-charset" maxlength="300" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
			</td>
			<td class="help" title="<?php echo $acccept_charset?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>

		<tr class="otherparam">
			<td style="">
				<label for="action"> Action </label>
			</td>
			<td>
				<input type="text" id="action" name="action" maxlength="300" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
			</td>
			<td class="help" title="<?php echo $action?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="autocomplete"> Autocomplete </label>
			</td>
			<td>
				<select id="autocomplete" name="autocomplete" class="ui-widget-content ui-corner-all select-ui">
					<option value="">Select</option>
					<option value="on">On</option>
					<option value="off">Off</option>
				</select>
			</td>
			<td class="help" title="<?php echo $autocomplete?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="enctype"> Enctype </label>
			</td>
			<td>
				<select id="enctype" name="enctype" class="ui-widget-content ui-corner-all select-ui">
					<option value="">Select</option>
					<option value="text/plain">text/plain</option>
					<option value="multipart/form-data">multipart/form-data</option>
					<option value="application/x-www-form-urlencoded">application/x-www-form-urlencoded</option>
				</select>
			</td>
			<td class="help" title="<?php echo $enctype?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="method"> Method </label>
			</td>
			<td>
				<select id="method" name="method" class="ui-widget-content ui-corner-all select-ui"><option  selected value="post">POST</option><option value="get">GET</option></select>
			</td>
			<td class="help" title="<?php echo $method?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="novalidate"> No Validate </label>
			</td>
			<td>
				<input type="checkbox" id="novalidate" name="novalidate" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $novalidate?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="target"> Target </label>
			</td>
			<td>
				<select id="target" name="target" class="ui-widget-content ui-corner-all select-ui"><option  selected value="">Select</option><option value="_blank">Blank</option><option value="_self">Self</option><option value="_parent">Parent</option><option value="_top">Top</option></select>
			</td>
			<td class="help" title="<?php echo $target?>"><span class='ui-icon ui-icon-info'></span></td>
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