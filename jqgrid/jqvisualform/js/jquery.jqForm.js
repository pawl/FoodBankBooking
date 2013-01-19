/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * jqForm
 * Tony Tomov tony@trirand.com
 * http://trirand.net 
**/

(function($){
$.jqform = 
{
	addTreeElement : function( etype, icon) {
		var fid = jQuery("#west-grid").jqGrid('getGridParam', 'userData').id;
		fid++;
		var dsp = "new"+etype.charAt(0).toUpperCase() + etype.slice(1);
		// check to see if we are using group element
		var root = "1";
		var sr = jQuery("#west-grid").jqGrid('getGridParam', 'selrow');
		if( sr ) {
			var data = jQuery("#west-grid").jqGrid('getRowData', sr);
 			if(data.type == 'group') {
				root = sr;
			}
		}
		jQuery("#west-grid").jqGrid('addChildNode', fid, root, {id:fid, fldname:dsp, type:etype, "icon": icon });
		jQuery("#west-grid").jqGrid('setGridParam', {"userData": {id:fid}} );
		jQuery("#west-grid").jqGrid('setSelection', fid);
	},
	saveTreeCell : function(id) {
		var data = {};
		$("input, select, textarea","#fcontent form").each(function(){
			if(this.type == 'checkbox') {
				if($(this).attr("checked"))
					data[this.id] = 1;
			} else 	if(this.value) {
				data[this.id] = this.value;
			}
		});
		var res = xmlJsonClass.toJson(data, '', '', false);
		//console.log(data);
		jQuery("#west-grid").jqGrid('setCell', id,'prop',res);
	},
	restoreCell : function ( prop, events ) {
		var data = $.jgrid.parse(prop);
		$("#fcontent form").each (function(){
				this.reset();
		});
		$.each(data, function(i, n) {
			var elm = $("#"+i,"#fcontent form")[0];
			if(elm) {
				if( elm.type=="checkbox") {
					if (n) $(elm).attr("checked","checked")
				} else {
					elm.value = n;
				}
			}
			//console.log(n);
		});
		if(events == '__EMPTY_STRING_') {
			events = "";
		}
		var tr = "";
		if(events) {
			events = events.replace(new RegExp( "\n", "g" ), "&#010;");
			var evndata = $.jgrid.parse(events);
		
			$.each(evndata, function (i, n) {
				tr += "<tr><td class='ui-event-cell eventname'>"+i+"</td>";
				tr += "<td class='ui-event-cell eventcode'>"+ n +"</td>";
				tr += "<td class='ui-event-cell eventactions' style='text-align: right;'> <button class='editcode'>Edit Event</button> <button class='delcode'>Delete Event</button></td>";
				tr += "</tr>";
			});
		}
		$(".eventtable tbody")
		.empty()
		.append( tr );
		$( ".editcode" ).button({
			icons: {
				primary: "ui-icon-pencil"
			},
			text : false
		});
		$( ".delcode" ).button({
			icons: {
				primary: "ui-icon-trash"
			},
			text : false
		});
	},
	saveEvents : function ( id ) {
		var data ={};
		$(".eventtable tbody tr").each(function() {
			var name = $(".eventname", this).html();
			data[name] = $(".eventcode", this).text();
		});
		var res = xmlJsonClass.toJson(data, '', '', false);
		//console.log(data);
		jQuery("#west-grid").jqGrid('setCell', id,'events',res);
		
	},
	saveParams : function() {
		var prmnames ="", prmtypes="", prmdefs ="", i, dm,
		params = jQuery("#grid_params").jqGrid('getGridParam','data');
		if(params && params.length) {
			for(i in params) {
				dm = params[i];
				if( i != 0) {
					prmnames += ","+dm.prm_name;
					prmtypes += ","+dm.prm_type;
					prmdefs += ","+dm.prm_def;
				} else {
					prmnames += dm.prm_name;
					prmtypes += dm.prm_type;
					prmdefs += dm.prm_def;					
				}
			}
		}
		jQuery("#west-grid").jqGrid('setGridParam', { "userData": {"prmnames": prmnames, "prmtypes":prmtypes, "prmdefs":prmdefs} } );
	},
	saveToString : function () {
		// save current cell
		var cid = jQuery("#west-grid").jqGrid('getGridParam','selrow');
		jQuery.jqform.saveTreeCell(cid);
		var griddata = jQuery("#west-grid").jqGrid('getGridParam','data');
		var xmlstr="\n<rows>\n";
		jQuery.each(griddata, function(i){
			//this.prop = "<![CDATA["+this.prop+"]]>";
			var d = $.extend({},this);
			d.prop = "<![CDATA["+d.prop+"]]>";
			d.events = "<![CDATA["+d.events+"]]>";
			xmlstr += "\t<row>\n\t\t"+xmlJsonClass.json2xml(d," ")+"\n\t</row>\n";
		});
		xmlstr += "</rows>\n";
		//griddata.prop = "<![CDATA["+griddata.prop+"]]>";
		var userdata = jQuery("#west-grid").jqGrid('getGridParam','userData');
		for(var key in userdata) {
			if( userdata.hasOwnProperty(key) ) 
				{
					if( userdata[key] === undefined ) {
						userdata[key] = "";
					}
					if(key=="javascript" || key=="bphpscript" || key=="rphpscript") {
							xmlstr += "<userdata name=\""+key+"\"><![CDATA["+ userdata[key]+"]]></userdata>\n";
					} else {
						xmlstr += "<userdata name=\""+key+"\">"+ userdata[key]+"</userdata>\n";
					}
				}
		}		
		return xmlstr;
	},
	newForm : function( cleargrid )
	{
		if(cleargrid === true) {
			jQuery("#west-grid").jqGrid('clearGridData');
			jQuery("input",".ui-dialog").each(function(){
				$(this).val("");
			});
			jQuery("#grid_params").jqGrid('clearGridData');
			jQuery("#west-grid").jqGrid('setGridParam',{ "userData": null});
		}
		var ud = {"id" :1, "sqlstring": "", "table":"", "tblkeys":"", "dbtype":"", "conname":"", "connstring":"","formlayout":"twocolumn","formheader":"","formicon":"","tablestyle":"","labelstyle":"","datastyle":"","formfooter":"", "createconn":"", "prmnames":"", "prmtypes":"", "prmdefs":"" };	
		jQuery("#west-grid").jqGrid('addChildNode', '', '', {id:"1", fldname:"newForm", type :"form" });
		jQuery("#west-grid").jqGrid('setGridParam',{ "userData": ud});
		jQuery("#west-grid").jqGrid('setSelection', 1);
		jQuery("#selname").html(" New File");
	},
	saveToServer : function( file_name) {
		var datastr = jQuery.jqform.saveToString();
		jQuery.ajax({
			url : 'includes/saveform.php',
			dataType: 'html',
			type: 'POST',
			data : {fcnt: datastr, fname: file_name},
			success : function (req) {
				if(req !== "success") {
					alert("Error:" + req);
				}
			}
		});
		
	},
	generateFromSQL : function( rows )
	{
		if(rows && rows.length) {
			// delete rows
			var gr = jQuery("#west-grid").jqGrid('getDataIDs');
			if(gr.length) {
				for(var i=0; i<gr.length;i++) {
					if(gr[i] != "1") {
						jQuery("#west-grid").jqGrid('delRowData', gr[i]);
					}
				}
			}
			var row, fid=1, etype, icon, prop;
			jQuery("#west-grid").jqGrid('setGridParam', {"userData": { id: rows.length + 1 /* Form element*/  }} );
			for(i=0;i<rows.length;i++) {
				prop = {};
				row = rows[i];
				fid++;
				switch (row.type)
				{
					case 'int':
					case 'numeric':
						etype= 'number';
						icon = "ui-icon-calculator";
						break;
					case 'boolean':
						etype = 'checkbox';
						icon = "ui-icon-check";
						break;
					case 'string':
					case 'blob':
						etype = 'text';
						icon = "ui-icon-newwin";
						break
					case 'date':
						etype = 'date';
						icon = "ui-icon-calendar";
						break;
					case 'datetime':
						etype = 'datetime';
						icon = "ui-icon-calendar";
						break;
				}
				prop.label = row.name;
				if(row.len) { prop.maxlength = row.len; }
				var res = xmlJsonClass.toJson(prop, '', '', false);
				jQuery("#west-grid").jqGrid('addChildNode', '', '1', {id:fid, fldname:row.name, type:etype, "icon": icon, prop:res, events: "" });
			}
		}
	},
	editorSetValue : function ( val, editor ) {
		editor.setValue( val );
	},
	editorGetValue : function ( editor  ) {
		var ret = editor.getValue();
		return ret
	}
};
})(jQuery);