<!DOCTYPE html>
<?php
include_once("lang/info_en_GB.inc");
try {
	include_once 'form_conf.inc.php';
} catch (Exception $e) {
	$demo = false;
	$projectdir = "";
}
if(!isset ($demo)) {
	$demo = false;
}
if(!isset ($projectdir)) {
	$projectdir = "";
}

?>
<html lang="en" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HTML5 jqForm PHP builder</title>
<link rel="stylesheet" type="text/css" media="screen" href="themes/redmond/jquery-ui-custom.css"/>
<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css"/>
<link rel="stylesheet" type="text/css" media="screen" href="themes/jqueryFileTree.css"/>
<link rel="stylesheet" type="text/css" media="screen" href="js/codemirror/lib/codemirror.css">

<style type="text/css">
    body {margin: 0px;padding:0px;width: 100%;height:100%; font: 70% Verdana, ariel, sans-serif;}
    .aptabs ul {width:auto;font-size:0.95em;}
	.ui-layout-pane { padding: 1px; overflow: auto;	} 
    .ui-tabs-nav li {position: relative;}
    .ui-tabs-selected a span {padding-right: 10px;}
    .ui-tabs-close {display: none;position: absolute;top: 3px;right: 0px;z-index: 800;width: 16px;height: 14px;font-size: 10px; font-style: normal;cursor: pointer;}
    .ui-tabs-selected .ui-tabs-close {display: block;}
    .ui-layout-north { overflow: hidden;}
    .ui-layout-toggler-north span {position: absolute;top: 50%; margin: -10px 0 0 0;}
    .ui-layout-toggler-south span {position: absolute;top: 50%; margin: -10px 0 0 0;}
    .ui-layout-toggler-east span {position: absolute;left: 50%; margin: 0 0 0 -9px;}
    .ui-layout-north {border-bottom: 0px none;}
    .ui-datepicker {z-index:1200;}
    .ui-layout-center .ui-jqgrid {font-size: 1em;border: 0px none;}
    .ui-layout-center .ui-jqgrid tr.jqgrow td  { border-bottom: 0px none;}
	.hidden { position:absolute; top:0; left:-9999px; width:1px; height:1px; overflow:hidden; }

	.input-ui  {padding :4px;}
	.select-ui  {padding : 3px;}
	.textarea-ui {padding: 3px;}
	.globalparam {display:none;}
	.ui-input  {padding :4px;}
	.ui-select  {padding : 3px;}
	.ui-textarea {padding: 3px;}
	.ui-event-cell {padding: 5px;height:25px;white-space: nowrap; overflow:  hidden;}
	.ui-grid-footer { background-image: none; font-weight: normal; text-align: left;}
	.CodeMirror { font-size: 1.3em;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui-custom.min.js"></script>
<script type="text/javascript" src="js/jquery.layout.js"></script>
<script type="text/javascript" src="js/grid.locale-en.js"></script>
<script type="text/javascript" src="js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="js/jquery.jqForm.js"></script>
<script type="text/javascript" src="js/jqueryFileTree.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/codemirror/lib/codemirror.js"></script>
<script type="text/javascript" src="js/codemirror/mode/xml/xml.js"></script>
<script type="text/javascript" src="js/codemirror/mode/javascript/javascript.js"></script>
<script type="text/javascript" src="js/codemirror/mode/css/css.js"></script>
<script type="text/javascript" src="js/codemirror/mode/clike/clike.js"></script>
<script type="text/javascript" src="js/codemirror/mode/php/php.js"></script>
<script type="text/javascript" src="js/modernizr.js"></script>

<script type="text/javascript">
// searchdb translation
$.jgrid.useJSON = true;
var uiLayout, selected=null, filename='';
var workingdir = '<?php echo $projectdir?>';
var demo = '<?php echo $demo?>';
if(demo == 1) {
	demo = true;
} else {
	demo = false;
}
jQuery(document).ready(function(){
//menus
	jQuery(window).unload(function(){
		$("body > *").unbind().remove();
	});
	// init the editor and hide the dialog
	var editor, jseditor, bseditor, sbeditor, suceditor, bphpeditor, rphpeditor;
	//editor = ace.edit("editor");
	//var JavaScriptMode = require("ace/mode/javascript").Mode;
	//editor.getSession().setMode(new JavaScriptMode());
	editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
		mode: "javascript",
		lineNumbers: true,
		matchBrackets: true
	});		
	$("#dialogeventcode").hide();
	jseditor = CodeMirror.fromTextArea(document.getElementById("jseditor"), {
		mode: "javascript",
		lineNumbers: true,
		matchBrackets: true
	});		
	$("#dialogjavascript").hide();
	bphpeditor = CodeMirror.fromTextArea(document.getElementById("bphpeditor"), {
		mode : "text/x-php",
		lineNumbers: true,
		matchBrackets: true,
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift"
	});		
	rphpeditor = CodeMirror.fromTextArea(document.getElementById("rphpeditor"), {
		mode: "text/x-php",
		lineNumbers: true,
		matchBrackets: true,
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift"		
	});		
	$("#dialogphpscript").hide();
	
	uiLayout = $('body').layout({
		togglerLength_open:		35,			// WIDTH of toggler on north/south edges - HEIGHT on east/west edges
		togglerLength_closed:	35,			// "100%" OR -1 = full height
		hideTogglerOnSlide:		true,		// hide the toggler when pane is 'slid open'
		togglerTip_open:		'Close Pane',
		togglerTip_closed:		'Open Pane',
		resizerTip:				'Resize Pane',
		sliderTip:				'Slide Open',
		//east__initClosed: true,
		south__initClosed: false,
		resizerClass: 'ui-state-default',
		north__resizable:false,
		north__size: 33,
		east__size : '80%',
		west__resizable:true,
		west__size : 35,
		west__spacing_closed:			21,			// wider space when closed
		west__togglerLength_closed:	21,			// make toggler 'square' - 21x21
		west__togglerAlign_closed:	"top",		// align to top of resizer
		west__togglerLength_open:		0,			// NONE - using custom togglers INSIDE west-pane
		west__togglerTip_open:		'Close Pane',
		west__togglerTip_closed:	'Open Pane',
		west__resizerTip_open:		'Resize Pane',
		west__slideTrigger_open:		"click", 	// default
        //west__onclose : function () {$(".ui-state-default-west").removeClass("ui-state-disabled");},
        center__onresize: function (pane, $Pane) {
            jQuery("#west-grid").setGridWidth($Pane.innerWidth()-2);
        }
	});
	$(".ui-layout-toggler-north").append("<span class='ui-icon ui-icon-grip-dotted-horizontal'></span>");
	$(".ui-layout-toggler-south").append("<span class='ui-icon ui-icon-grip-dotted-horizontal'></span>");
	$(".ui-layout-toggler-east").append("<span class='ui-icon ui-icon-grip-dotted-vertical'></span>");
	// save selector strings to vars so we don't have to repeat it
	// must prefix paneClass with "body > " to target ONLY the outerLayout panes
	
	var maintab =jQuery('#tabs','.ui-layout-east').tabs({
        spinner: 'Loading',
		select : function (event , ui) {
			if(ui.index == 2) {
				$.ajax({
					url: "includes/createcode.php",
					data: {fname:filename, act:'code'},
					dataType: "html",
					type: "POST",
					success: function (res, err){
						$(ui.panel).html(res)
					}
				});
				//$(ui.panel).load("includes/createcode.php",{fname:filename});
			}
			if(ui.index == 3) {
				var pda = {fname:filename, act:'execute'},
				ud = jQuery("#west-grid").jqGrid('getGridParam','userData'),
				pn = ud.prmnames !== undefined ? ud.prmnames.split(",") : [],
				pd = ud.prmdefs !== undefined ? ud.prmdefs.split(",") : [];
				if(pn.length) {
					for(var j in pn) {
						if( pn.hasOwnProperty(j))
						pda[pn[j]] = pd[j];
					}
				}
				$.ajax({
					url: "includes/createcode.php",
					data: pda,
					dataType: "html",
					type: "POST",
					success: function (res, err){
						$(ui.panel).html(res)
					}
				});
				//$(ui.panel).load("includes/createcode.php",{fname:filename});
			}
			//console.log(ui);
		}
    });    
    function hoverbutton () {
        $(this).toggleClass("ui-state-hover");
    }

    jQuery("#west-grid").jqGrid({
        url: "includes/readform.php",
        datatype: "local",
        height: "auto",
		mtype: "POST",
        pager: false,
        colNames: ["id","Form","Type", "Properties","Events"],
        colModel: [
            {name: "id",width:1,hidden:true, key:true},
            {name: "fldname", width:150, resizable: false, sortable:false},
			{name: "type",width:1,hidden:true},
            {name: "prop",width:1,hidden:true},
			{name: "events",width:1,hidden:true}
        ],
        treeGrid: true,
		treeGridModel : 'adjacency',
        ExpandColumn: "fldname",
		sortname: "id",
        autowidth: true,
        loadui: "disable",
        ExpandColClick: true,
        gridview: false,
        rowNum: -1,
		//toolbar :[true, 'top'],
		toppager : true,
        xmlReader : {repeatitems:false},
        treeIcons: {leaf:'ui-icon-document-b'},
        onSelectRow: function(rowid) {
			//if(selected != rowid ) {
				if(selected) {
					jQuery.jqform.saveTreeCell(selected);
					jQuery.jqform.saveEvents(selected);
					jQuery.jqform.saveParams();
				}
				var treedata = $("#west-grid").getRowData(rowid);
				$.ajax({
					url:"tmpl/input_"+treedata.type+".php",
					dataType: "html",
					type: "POST",
					success : function(res) {
						$("#fcontent","#fprop").empty().append(res);
						$("#type","#common_data").val(treedata.type);
						$("#name","#common_data").val(treedata.fldname);
						$("#treeid","#common_data").val(treedata.id);
						//$("#label","#fprop").val();
						jQuery.jqform.restoreCell(treedata.prop, treedata.events);
						selected = rowid;
						$(".help").tooltip();
						if(treedata.type == 'form' || treedata.type =='group') {
							$("#type","#common_data").attr("disabled","disabled");
						}  else {
							$("#type","#common_data").removeAttr("disabled");
						}
					}
				});
			//}
        }
        //loadError: false
    });
	jQuery.jqform.newForm( false );
	jQuery("#west-grid").jqGrid('navGrid','#west-grid_toppager',{add:false, edit:false, search:false,refresh:false, del:false});
	
	
	$("#type","#common_data").change(function(){
		var tv = $(this).val();
		if(tv == "form" || tv =="group") { return ;}
		var ico = $("#e"+tv+" span:first").attr('class');
		ico = ico.replace("ui-button-icon-primary","");
		ico = $.trim(ico.replace("ui-icon",""));
		
		jQuery("#west-grid").jqGrid('setRowData', selected,{'type':$(this).val(),'icon':ico});
		var ind =jQuery("#west-grid").jqGrid('getInd',selected);
		var excol = jQuery("#west-grid").jqGrid('getGridParam','expColInd');
		$("td:eq("+excol+")", "#"+selected).empty().html( $("#name","#common_data").val());
		jQuery("#west-grid").jqGrid('setTreeNode',ind, ind+1);
		jQuery("#west-grid").jqGrid('setSelection', selected);
	});
	
	jQuery("#west-grid").jqGrid('navButtonAdd', '#west-grid_toppager',{
		title:"Move element up",
		buttonicon : 'ui-icon-arrowthick-1-n', 
		caption: '',
		onClickButton : function (e) {
			var sr = $(this).jqGrid('getGridParam','selrow');
			if(sr && sr != "1") {
				var ind = this.p._index[sr];
				var sd = this.p.data[ind];
				var pr = sd.parent, prev=null;
				if(pr > '1') {
					prev = $("#"+sr).prev();
					if(prev && prev[0] && prev[0].id) {
						var ind2 = this.p._index[prev[0].id];
						var sd2 = this.p.data[ind2];
						if(sd2.parent == pr) {
							$("#"+sr).insertBefore(prev);
							this.p.data[ind2] = this.p.data[ind];
							this.p.data[ind] = sd2;
							this.refreshIndex();
						}
					}
				} else if(pr == '1'){
					var childmain = $(this).jqGrid('getNodeChildren',sd);
					prev = $("#"+sr).prev();
					if(prev && prev[0] && prev[0].id) {
						if (prev[0].id != '1') {
							childmain.splice(0,0,sd);
							var ind2 = this.p._index[prev[0].id];
							var sd2 = this.p.data[ind2];
							var par = $(this).jqGrid('getNodeParent',sd2), childs;
							if(par.parent === null || par.parent == '__EMPTY_STRING_' || par.parent == '' || par.parent.toLowerCase() == 'null') {
								childs =[];
							} else {
								childs = $(this).jqGrid('getNodeChildren',par);
							}
							if(childs.length) {
								//var iti = childs[childs.length-1];
								prev = $("#"+par.id);
								ind2 = this.p._index[par.id];
								sd2 = this.p.data[ind2];
							}
							var cln = childmain.length;
							for(var i=0; i<cln; i++) {
								$("#"+childmain[i].id).insertBefore(prev);
								//$("#"+childmain[i].id).insertAfter(next);
							}						
							var testme = this.p.data.splice(ind,cln);
							for (i=0; i<cln; i++) {
								this.p.data.splice(ind2,0,testme[cln-1-i]);
							}
							this.refreshIndex();
						}
					}					
				}
				
			}
		}
	});
	jQuery("#west-grid").jqGrid('navButtonAdd', '#west-grid_toppager',{
		title:"Move element down",
		buttonicon : 'ui-icon-arrowthick-1-s', 
		caption: '',
		onClickButton : function (e) {
			var sr = $(this).jqGrid('getGridParam','selrow');
			if(sr && sr != "1") {
				var ind = this.p._index[sr];
				var sd = this.p.data[ind];
				var pr = sd.parent, next=null;
				if(pr > '1') {
					next = $("#"+sr).next();
					if(next && next[0] && next[0].id) {
						var ind2 = this.p._index[next[0].id];
						var sd2 = this.p.data[ind2];
						if(sd2.parent == pr) {
							$("#"+sr).insertAfter(next);
							this.p.data[ind2] = this.p.data[ind];
							this.p.data[ind] = sd2;
							this.refreshIndex();
						}
					}
				} else if(pr == '1') {
					var childmain = $(this).jqGrid('getNodeChildren',sd);
					var sr1=null;
					if(childmain.length) {
						sr1 = childmain[childmain.length-1].id;
					}
					if(sr1) {
						next = $("#"+sr1).next();
					} else {
						next = $("#"+sr).next();
					}
					childmain.splice(0,0,sd);
					if(next && next[0] && next[0].id) {
						var ind2 = this.p._index[next[0].id];
						var sd2 = this.p.data[ind2];
						var childs = $(this).jqGrid('getNodeChildren',sd2);
						if(childs.length) {
							var iti = childs[childs.length-1];
							next = $("#"+iti.id);
							ind2 = this.p._index[iti.id];
							sd2 = this.p.data[ind2];
						}
						var cln = childmain.length;
						for(var i=cln-1; i>=0; i--) {
							
							$("#"+childmain[i].id).insertAfter(next);
						}						
						var testme = this.p.data.splice(ind,cln);
						for (i=cln-1; i>=0; i--)
							this.p.data.splice(ind2-(cln-1),0,testme[i]);
						this.refreshIndex();
					}
				}
			}
		}
	});
	jQuery("#west-grid").jqGrid('navSeparatorAdd', '#west-grid_toppager');
	jQuery("#west-grid").jqGrid('navButtonAdd', '#west-grid_toppager',{
		title:"Delete element",
		buttonicon : 'ui-icon-trash', 
		caption: '',
		onClickButton : function (e) {
			sr = $(this).jqGrid('getGridParam','selrow');
			if(sr && sr != "1") {
				$("#deldialog").dialog({
						height: 150,
						width: 250,
						modal: true,
						close : function () {
							$(this).dialog( 'destroy' );
						},
						buttons: [
							{
								text : "Ok",
								click : function () {
									if(sr && sr != "1") {
										jQuery("#west-grid").jqGrid("delTreeNode", sr);
										$( this ).dialog( "close" );
									}
								}
							}, {
								text : "Cancel",
								click : function () { $( this ).dialog( "close" ); }
							}
						]
				});
			}
		}
	});

	$( "#etext" ).button({
		icons: { primary: "ui-icon-newwin" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("text", "ui-icon-newwin");
	});
	$( "#epassword" ).button({
		icons: { primary: "ui-icon-locked" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("password", "ui-icon-locked");
	});

	$( "#echeckbox" ).button({
		icons: { primary: "ui-icon-check" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("checkbox", "ui-icon-check");
	});
	$( "#eradio" ).button({
		icons: { primary: "ui-icon-radio-on" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("radio", "ui-icon-radio-on");
	});
	$( "#eselect" ).button({
		icons: { primary: "ui-icon-circle-triangle-s" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("select", "ui-icon-circle-triangle-s");
	});
	$( "#etextarea" ).button({
		icons: { primary: "ui-icon-gripsmall-diagonal-se" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("textarea", "ui-icon-gripsmall-diagonal-se");
	});
	$( "#ebutton" ).button({
		icons: { primary: "ui-icon-battery-0" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("button", "ui-icon-battery-0");
	});
	$( "#esubmit" ).button({
		icons: { primary: "ui-icon-play" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("submit", "ui-icon-play");
	});
	$( "#ereset" ).button({
		icons: { primary: "ui-icon-stop" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("reset", "ui-icon-stop");
	});
	$( "#efile" ).button({
		icons: { primary: "ui-icon-document-b" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("file", "ui-icon-document-b");
	});
	$( "#ehidden" ).button({
		icons: { primary: "ui-icon-clipboard" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("hidden", "ui-icon-clipboard");
	});
	$( "#eimage" ).button({
		icons: { primary: "ui-icon-image" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("image", "ui-icon-image");
	});
	$( "#edate" ).button({
		icons: { primary: "ui-icon-calendar" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("date", "ui-icon-calendar");
	});
	$( "#enumber" ).button({
		icons: { primary: "ui-icon-calculator" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("number", "ui-icon-calculator");
	});
	$( "#erange" ).button({
		icons: { primary: "ui-icon-arrow-2-e-w" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("range", "ui-icon-arrow-2-e-w");
	});
	$( "#eemail" ).button({
		icons: { primary: "ui-icon-mail-closed" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("email", "ui-icon-mail-closed");
	});
	$( "#eurl" ).button({
		icons: { primary: "ui-icon-link" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("url", "ui-icon-link");
	});
	$( "#esearch" ).button({
		icons: { primary: "ui-icon-search" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("search", "ui-icon-search");
	});
	$( "#etel" ).button({
		icons: { primary: "ui-icon-volume-off" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("tel", "ui-icon-volume-off");
	});
	$( "#ecolor" ).button({
		icons: { primary: "ui-icon-bookmark" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("color", "ui-icon-bookmark");
	});
	$( "#egroup" ).button({
		icons: { primary: "ui-icon-carat-2-e-w" },
		text : false
	}).click(function(){
		$.jqform.addTreeElement("group", "ui-icon-carat-2-e-w");
	});

	$("#showglob").live('click',function() {

		if ( $( this ).hasClass("ui-icon-triangle-1-e")) {
			$(".globalparam").show();
			$(this).attr("title","Hide Global Attributes")
			.removeClass("ui-icon-triangle-1-e")
			.addClass("ui-icon-triangle-1-s")

		} else {
			$(".globalparam").hide();
			$(this).attr("title","Show Global Attributes")
			.removeClass("ui-icon-triangle-1-s")
			.addClass("ui-icon-triangle-1-e")
		}
		//$( this ).button( "option", options );
		return false;
	});
	$("#showother").live('click',function() {

		if ( $( this ).hasClass("ui-icon-triangle-1-e")) {
			$(".otherparam").show();
			$(this).attr("title","Hide Form Attributes")
			.removeClass("ui-icon-triangle-1-e")
			.addClass("ui-icon-triangle-1-s")

		} else {
			$(".otherparam").hide();
			$(this).attr("title","Show Form  Attributes")
			.removeClass("ui-icon-triangle-1-s")
			.addClass("ui-icon-triangle-1-e")
		}
		//$( this ).button( "option", options );
		return false;
	});
	var trevent=null;
	$(".editcode").live('click',function(e){
			trevent = $(this).parent("td").parent("tr")[0];
			$( "#dialogeventcode" ).dialog( "option", "title", "Edit Event");
			$( "#dialogeventcode" ).dialog( "open" );
	});
	$(".delcode").live('click',function(e){
		trevent = $(this).parent("td").parent("tr");
		$("#deldialog").dialog({
				height: 150,
				width: 250,
				modal: true,
				close : function () {
					$(this).dialog( 'destroy' );
					trevent = null;
				},
				buttons: [
					{
						text : "Ok",
						click : function () {
							$(trevent).remove();
							$( this ).dialog( "close" );
						}
					}, {
						text : "Cancel",
						click : function () { $( this ).dialog( "close" ); }
					}
				]
		});
	});

	$( "#dialogeventcode" ).dialog({
		autoOpen : false,
		height: 'auto',
		width: 600,
		modal: false,
		open: function(event, ui) {
			// get the data and set it in the editor
			if(trevent !== null) {
				$("#event_name").val( "" );
				$.jqform.editorSetValue( " ", editor );
				//editor.getSession().setValue( "");
				var e_n = $(".eventname", trevent).text();
				var e_c = $(".eventcode", trevent).text();
				e_c = $.jgrid.htmlDecode( e_c );
				//e_c = e_c.replace(new RegExp( "&#010;", "g" ), "\n");
				$.jqform.editorSetValue( e_c, editor );
				//editor.getSession().setValue(e_c);
				$("#event_name").val( e_n );
				
			} else {
				//  new event
				$("#event_name").val( "" );
				$.jqform.editorSetValue( "function(event) \n{\n}", editor );
				//editor.getSession().setValue( "function(event) \n{\n    \n}");
			}
		},
		close : function() {
			trevent = null;
			//$(this).dialog('destroy');
		},
		buttons: [
			{
				text : "Save",
				click : function () {
					var i, n;
					if(trevent === null) {
						var trtins="";
						i = $("#event_name").val( );
						if( $.trim(i) == "" ) {
							alert("Please enter a event name!");
							return;
						}
						//n = editor.getSession().getValue();
						n = $.jqform.editorGetValue( editor );
						n = $.jgrid.htmlEncode( n );
						//n = n.replace(new RegExp( "\n", "g" ), "&#010;");
						trtins += "<tr><td class='ui-event-cell eventname'>"+i+"</td>";
						trtins += "<td class='ui-event-cell eventcode'>"+ n +"</td>";
						trtins += "<td class='ui-event-cell eventactions' style='text-align: right;'> <button class='editcode'>Edit Event</button> <button class='delcode'>Delete Event</button></td>";
						trtins += "</tr>";
						$(".eventtable tbody").append(trtins);
						trevent = $("tr:last",".eventtable")[0];
						$( ".editcode", trevent ).button({
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
					} else {
						i = $("#event_name").val( );
						//n = editor.getSession().getValue();
						n = $.jqform.editorGetValue( editor );
						n = $.jgrid.htmlEncode( n );
						//n = n.replace(new RegExp( "\n", "g" ), "&#010;");
						$(".eventcode", trevent).html( n );
						$(".eventname", trevent).html( i );
					}
				}
			},				
			{
				text: "Exit",
				click : function () { $( this ).dialog( "close" ); }
			}
		]
	});

	$( "#dialogjavascript" ).dialog({
		autoOpen : false,
		height: 'auto',
		width: 630,
		modal: true,
		open: function(event, ui) {
			// get the data and set it in the editor
			var jsc = jQuery("#west-grid").jqGrid('getGridParam','userData');
			jsc = jsc['javascript'];
			jsc = $.jgrid.htmlDecode( jsc );
			if(jsc === undefined) {
				jsc ="";
			}
			$.jqform.editorSetValue( jsc, jseditor );
			
		},
		close : function() {
			//$(this).dialog('destroy');
		},
		buttons: [
			{
				text : "Save",
				click : function () {
					var n;
					n = $.jqform.editorGetValue( jseditor );
					n = $.jgrid.htmlEncode( n );
					if(n === undefined) {
						n = "";
					}
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{"javascript": n}});					
				}
			},				
			{
				text: "Exit",
				click : function () { $( this ).dialog( "close" ); }
			}
		]
	});
	$( "#dialogphpscript" ).dialog({
		autoOpen : false,
		height: 450,
		width: 630,
		modal: true,
		open: function(event, ui) {
			// get the data and set it in the editor
			var jsc = jQuery("#west-grid").jqGrid('getGridParam','userData');
			jsc = jsc['bphpscript'];
			jsc = $.jgrid.htmlDecode( jsc );
			if(jsc === undefined) {
				jsc ="";
			}
			$.jqform.editorSetValue( jsc, bphpeditor );
			
			var jsc1 = jQuery("#west-grid").jqGrid('getGridParam','userData');
			jsc1 = jsc1['rphpscript'];
			jsc1 = $.jgrid.htmlDecode( jsc1 );
			if(jsc1 === undefined) {
				jsc1 ="";
			}
			$.jqform.editorSetValue( jsc1, rphpeditor );
			
		},
		close : function() {
			//$(this).dialog('destroy');
		},
		buttons: [
			{
				text : "Save",
				click : function () {
					var n, n1;
					n = $.jqform.editorGetValue( bphpeditor );
					n = $.jgrid.htmlEncode( n );
					if(n === undefined) {
						n = "";
					}
					n1 = $.jqform.editorGetValue( rphpeditor );
					n1 = $.jgrid.htmlEncode( n1 );
					if(n1 === undefined) {
						n1 = "";
					}
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{"bphpscript": n, "rphpscript": n1}});
				}
			},				
			{
				text: "Exit",
				click : function () { $( this ).dialog( "close" ); }
			}
		]
	});

	$( "#dialogajax" ).dialog({
		autoOpen : false,
		height: '450',
		width: 630,
		modal: true,
		open: function(event, ui) {
			if(!bseditor) {
				bseditor = CodeMirror.fromTextArea(document.getElementById("beforeSerialize"), {
					mode: "javascript",
					lineNumbers: true,
					matchBrackets: true
				});		
			}
			if(!suceditor) {
				suceditor = CodeMirror.fromTextArea(document.getElementById("success"), {
					mode: "javascript",
					lineNumbers: true,
					matchBrackets: true
				});
			}
			if(!sbeditor) {
				sbeditor = CodeMirror.fromTextArea(document.getElementById("beforeSubmit"), {
					mode: "javascript",
					lineNumbers: true,
					matchBrackets: true
				});
			}
			// get the data and set it in the editor
			var ajaxdata = jQuery("#west-grid").jqGrid('getGridParam','userData'), ajval;
			ajval = ajaxdata.ajax_data ? ajaxdata.ajax_data : "" ;
			$("#data", this).val( $.jgrid.htmlDecode(ajval) );

			ajval = ajaxdata.ajax_dataType ? ajaxdata.ajax_dataType : "" ;
			$("#dataType", this).val(ajval);
			
			ajval =  ajaxdata.ajax_beforeSerialize ? ajaxdata.ajax_beforeSerialize : "" ;
			$.jqform.editorSetValue($.jgrid.htmlDecode(ajval), bseditor);
			
			ajval =  ajaxdata.ajax_beforeSubmit ? ajaxdata.ajax_beforeSubmit : "" ;
			//$("#beforeSubmit", this).val(ajval);
			$.jqform.editorSetValue($.jgrid.htmlDecode(ajval), sbeditor);

			ajval =  ajaxdata.ajax_success ? ajaxdata.ajax_success : "" ;
			//$("#success", this).val(ajval);
			$.jqform.editorSetValue($.jgrid.htmlDecode(ajval), suceditor);

			ajval =  ajaxdata.ajax_resetForm ? ajaxdata.ajax_resetForm : "" ;
			$("#resetForm", this).val(ajval);
			ajval =  ajaxdata.ajax_clearForm ? ajaxdata.ajax_clearForm : "" ;
			$("#clearForm", this).val(ajval);
			ajval =  ajaxdata.ajax_iframe ? ajaxdata.ajax_iframe : "" ;
			$("#iframe", this).val(ajval);
			ajval =  ajaxdata.ajax_iframeSrc ? ajaxdata.ajax_iframeSrc : "" ;
			$("#iframeSrc", this).val(ajval);
			ajval =  ajaxdata.ajax_forceSync ? ajaxdata.ajax_forceSync : "" ;
			$("#forceSync", this).val(ajval);
		},
		close : function() {
			//$(this).dialog('destroy');
		},
		buttons: [
			{
				text : "Save",
				click : function () {
					var data = {};
					$("input, select", "#aform").each(function(){
						data["ajax_"+this.id] =  $.jgrid.htmlEncode( this.value );
					});
					var n = $.jqform.editorGetValue( bseditor );
					data["ajax_beforeSerialize"] =  $.jgrid.htmlEncode( n );
					//var str = xmlJsonClass.toJson(data, '', '', false);					
					n = $.jqform.editorGetValue( sbeditor );
					data["ajax_beforeSubmit"] =  $.jgrid.htmlEncode( n );

					var n = $.jqform.editorGetValue( suceditor );
					data["ajax_success"] =  $.jgrid.htmlEncode( n );
					jQuery("#west-grid").jqGrid('setGridParam',{userData: data});
				}
			},				
			{
				text: "Exit",
				click : function () { $( this ).dialog( "close" ); }
			}
		]
	});

	
	$( "#addeventcode" ).button({
		icons: {
			primary: "ui-icon-plus"
		}
	}).click(function(){
		trevent = null;
		$( "#dialogeventcode" ).dialog( "option", "title", "New Event");
		$( "#dialogeventcode" ).dialog( "open" );
	});
	


	$( "#bsave" ).button({
		icons: {
			primary: "ui-icon-disk"
		}
	}).click(function(){
		if( filename == '') {
			$("#dialogsave").dialog( "open");
		} else {
			if( selected ) {
				jQuery.jqform.saveTreeCell(selected);
				jQuery.jqform.saveEvents(selected);
				jQuery.jqform.saveParams();
			}
			jQuery.jqform.saveToServer( filename) ;
		}
	});
	$( "#bopen" ).button({
		icons: {
			primary: "ui-icon-folder-open"
		}
	}).click(function(){
		$( "#dialoglist" ).dialog( "open" );
	});
	/*
	$( "#bpower" ).button({
		icons: {
			primary: "ui-icon-power"
		},
		text : false
	});
	*/
	$( "#bnew" ).button({
		icons: {
			primary: "ui-icon-document-b"
		}
	}).click(function(){
		jQuery.jqform.newForm( true );
		filename = '';
	});

	$("#name","#common_data").change(function(){
		var trid = $("#treeid","#common_data").val();
		if(trid) {
			jQuery("#west-grid").jqGrid('setCell',trid,'fldname',$(this).val());
		}
	});
    $('#filelist').fileTree({root: workingdir, "script":"includes/jqueryFileTree.php" }, function(file, filetype) {
		if(filetype=='file') {
			filename = file;
			$( "#dialoglist" ).dialog( "close" );
			selected = null;
			if(demo) {
				jQuery("#selname").html( filename.replace(workingdir,"") );
			} else {
				jQuery("#selname").html(filename);
			}
			jQuery("#west-grid").jqGrid('clearGridData');
			jQuery("#grid_params").jqGrid('clearGridData');
			jQuery("#west-grid").jqGrid('setGridParam',{treedatatype:'xml', postData:{fname:filename}});
			jQuery("#west-grid").trigger('reloadGrid');
			setTimeout(function(){
				jQuery("#west-grid").jqGrid('setSelection', 1);
				var userdata = jQuery("#west-grid").jqGrid('getGridParam', 'userData');
				if(userdata.formheader) {
					$("#formheader").val(userdata.formheader);
				}
				if(userdata.formicon) {
					$("#formicon").val(userdata.formicon);
				}
				if(userdata.formfooter) {
					$("#formfooter").val(userdata.formfooter);
				}
				if(userdata.tablestyle) {
					$("#tablestyle").val(userdata.tablestyle);
				}
				if(userdata.labelstyle) {
					$("#labelstyle").val(userdata.labelstyle);
				}
				if(userdata.datastyle) {
					$("#datastyle").val(userdata.datastyle);
				}
				if(userdata.dbtype) {
					$("#dbtype").val(userdata.dbtype);
				}
				if(userdata.conname) {
					$("#conname").val(userdata.conname);
				}
				if(userdata.connstring) {
					$("#connstring").val(userdata.connstring);
				}
//
				if(userdata.sqlstring) {
					$("#sqlstring").val(userdata.sqlstring);
				}
				if(userdata.table) {
					$("#table").val(userdata.table);
				}
				if(userdata.tblkeys) {
					$("#tblkeys").val(userdata.tblkeys);
				}
				if(userdata.prmnames) {
					var pnm = userdata.prmnames.split(",");
					var ptp = userdata.prmtypes.split(",");
					var pdf = userdata.prmdefs.split(",");
					for(var i in pnm) {
						jQuery("#grid_params").jqGrid('addRowData',undefined, {prm_name:pnm[i],prm_type:ptp[i], prm_def:pdf[i]}, 'last');
					}
				}
				if(userdata.createconn) {
					$("#createconn").val(userdata.createconn);
				}				
				if(userdata.serialkey) {
					if(userdata.serialkey == "yes") {
						$("#serialkey")[!!($.fn.prop) ? 'prop' : 'attr']("checked", true);
					}
				}				

			},300);
		}
    });	

	$("#dialoglist").dialog({
			autoOpen: false,
			height: 300,
			width: 450,
			modal: true,
			open : function(ui, ev) {
				$("#filelist").empty();
				$("#filelist")[0].showTree ( $("#filelist"), escape(workingdir));
			},
			buttons: {
				Cancel : function () { $( this ).dialog( "close" ); }
			}
	});
	var saveallowed = false;
	$("#dialogsave").dialog({
			autoOpen: false,
			height: 350,
			width: 450,
			modal: true,
			buttons: {
				Save : function (){
					if(saveallowed ) {
						filename = $("#dir_name_tosave").val();
					} else {
						var fnts = $.trim($("#f_name_tosave").val());
						if( fnts ) {
							if( fnts.toLowerCase().indexOf(".xml") === -1) { 
								fnts += ".xml";
							}
							filename = $("#dir_name_tosave").val()+fnts;
							if(selected) {
								jQuery.jqform.saveTreeCell(selected);
								jQuery.jqform.saveEvents(selected);
								jQuery.jqform.saveParams();
							}
							jQuery.jqform.saveToServer( filename );
							if( demo ) {
								jQuery("#selname").html(fnts);
							} else {
								jQuery("#selname").html(filename);
							}
							$( this ).dialog( "close" );
						} else {
							alert("please enter file")
						}
					}
				},
				Cancel : function () { $( this ).dialog( "close" ); }
			}
	});
	setTimeout(function(){
		$('<table "style=width:90%;table-layout:auto;"><tr id="fr_dir"><td style="padding-left:8px">Dir</td><td style="width:94%;"><input id="dir_name_tosave" value="'+workingdir+'" readonly style="width:95%;"/></td></tr><tr><td style="padding-left:8px">File</td><td style="width:94%;"><input id="f_name_tosave" value="" style="width:95%;" /></td></tr></table>').insertBefore("#dialogsave");//'<input id="f_name_tosave" value="" style="width:100%;"/><br/>');
		if(demo) {
			$("#fr_dir").hide();
		}
	},200);
	
    $('#savelist').fileTree({root: workingdir, "script":"includes/jqueryFileTree.php" }, function(file, filetype) {
		if(filetype=='file') {
			$("#dir_name_tosave").val(file);
			saveallowed = true;
		} else {
			saveallowed = false;
			$("#dir_name_tosave").val(file);
		}
    });	
	$( "#bsetting" ).button({
		icons: {
			primary: "ui-icon-gear"
		}
	}).click(function(){
		$("#dialogset").dialog(  "open" );
	});
	
	$( "#bdbase" ).button({
		icons: {
			primary: "ui-icon-pencil"
		}
	}).click(function(){
		$("#dialogconn").dialog("open");
	});
	$( "#bdbsource" ).button({
		icons: {
			primary: "ui-icon-contact"
		}
	}).click(function(){
		$("#dialogsource").dialog("open");
	});
	$( "#bajax" ).button({
		icons: {
			primary: "ui-icon-refresh"
		}
	}).click(function(){
		$("#dialogajax").dialog("open");
	});
	$( "#bjavascript" ).button({
		icons: {
			primary: "ui-icon-comment"
		}
	}).click(function(){
		$( "#dialogjavascript" ).dialog( "open");
	});
	$( "#bphpscript" ).button({
		icons: {
			primary: "ui-icon-note"
		}
	}).click(function(){
		$( "#dialogphpscript" ).dialog( "open");
	});
	
	$( "#bparams" ).button({
		icons: {
			primary: "ui-icon-transferthick-e-w"
		}
	}).click(function(){
		$( "#dialogparams" ).dialog( "open");
	});
	$( "#prm_add" ).button({
		icons: {	primary: "ui-icon-plus"	},
		text: false
	}).height(20).click(function(){
		var fdata = $("#newparam").serializeArray();
		var submitarr = true;
		$(fdata).each(function(){
			if(this.name == "prm_name" && !this.value) {
				submitarr = false; return false;
			}
		});
		if( submitarr ) {
			$( "#grid_params" ).jqGrid( "FormToGrid", undefined, "#newparam", "add", "last"); 
			$(":input","#newparam").val("");
		}
		return false;
		
	});


	$("#dialogset").dialog({
		autoOpen: false,
		height: 'auto',
		width: 550,
		modal: true,
		buttons: [
			{
				text : "Ok",
				click : function()
				{
					var u0 = $("#formlayout").val();
					var u1 = $("#formheader").val();
					var u2 = $("#formicon").val();
					var u3 = $("#formfooter").val();
					var u4 = $("#tablestyle").val();
					var u5 = $("#labelstyle").val();
					var u6 = $("#datastyle").val();
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{formlayout:u0, formheader:u1, formicon:u2, formfooter:u3, tablestyle:u4, labelstyle:u5, datastyle:u6}});
					$( this ).dialog( "close" );
				}
			},
			{
				text : "Cancel",
				click : function () { 
					$( this ).dialog( "close" ); 
				}
			}
		]
	});

	$("#dialogconn").dialog({
		autoOpen: false,
		height: 'auto',
		width: 470,
		modal: true,
		buttons: [
			{
				text : "Test",
				click : function(){
					var c1 = $("#dbtype").val();
					var c2 = $("#conname").val();
					var c3 = $("#connstring").val();
					var c4 = $("#createconn").val();
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{dbtype:c1, conname:c2, connstring:c3, createconn:c4}});
					$.ajax({
						url : "includes/testcon.php",
						data : {conn:c3, dbtype:c1, action:'test'},
						type: "POST",
						dataType: "html",
						success : function (res){
							alert(res)
						}
					})
					
				}
			},
			{
				text : "Ok",
				click : function()
				{
					var c1 = $("#dbtype").val();
					var c2 = $("#conname").val();
					var c3 = $("#connstring").val();
					var c4 = $("#createconn").val();
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{dbtype:c1, conname:c2, connstring:c3, createconn:c4}});
					$( this ).dialog( "close" );
				}
			},
			{
				text : "Cancel",
				click : function () { 
					$( this ).dialog( "close" ); 
				}
			}
		]
	});

// Data source

	$("#dialogsource").dialog({
		autoOpen: false,
		height: 'auto',
		width: 550,
		modal: true,
		buttons: [
			{
				text : "Generate",
				click : function(){
					var c1 = $("#dbtype").val();
					var c3 = $("#connstring").val();
					var s1 = $("#sqlstring").val();
					var s2 = $("#table").val();
					var s3 = $("#tblkeys").val();
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{dbtype:c1, connstring:c3, sqlstring: s1, table:s2, tblkeys:s3}});
					$.ajax({
						url : "includes/testcon.php",
						data : {conn:c3, dbtype:c1, sqlstring: s1, action:'genform'},
						type: "POST",
						dataType: "json",
						success : function (res){
							if(res.msg == "success") {
								jQuery.jqform.generateFromSQL( res.rows );
							} else {
								alert(res.msg);
							}
						}
					})

				}
			},
			{
				text : "Ok",
				click : function()
				{
					var c1 = $("#dbtype").val();
					var c3 = $("#connstring").val();
					var s1 = $("#sqlstring").val();
					var s2 = $("#table").val();
					var s3 = $("#tblkeys").val();
					var s4 = $("#createconn").val();
					var s5 = $("#serialkey").is(":checked") ? "yes" : "no";
					jQuery("#west-grid").jqGrid('setGridParam',{userData:{dbtype:c1, connstring:c3, sqlstring: s1, table:s2, tblkeys:s3, createconn:s4, serialkey:s5}});
					$( this ).dialog( "close" );
				}
			},
			{
				text : "Cancel",
				click : function () {
					$( this ).dialog( "close" );
				}
			}
		]
	});
    jQuery("#grid_params").jqGrid({
        datatype: "local",
        height: "100",
		mtype: "POST",
		rownumbers :  true,
        pager: "#pgrid_params",
        colNames: ["id","Name","Type", "Default", "Action"],
        colModel: [
            {name: "id",width:1,hidden:true, key:true},
            {name: "prm_name", width:140, resizable: false, sortable:false, editable: true},
			{name: "prm_type",width:80, formatter:'select', resizable: false, sortable:false, editable: true, edittype:"select", editoptions: { value:"string:string;int:integer;numeric:numeric;bool:boolean"}},
			{name: "prm_def",width:80, resizable: false, sortable:false, editable: true},
			{name: "prm_act",width:50, formatter:"actions", formatoptions:{url:'clientArray', delOptions : {useDataProxy : true, closeOnEscape: true } },  editable: false, resizable: false, sortable:false}
        ],
		dataProxy : function (o, module) {
			if(module == "del_"+this.p.id) {
				$(this).jqGrid('delRowData',o.data.id);
			}
		},
		sortname: "id",
        width: 500,
		viewrecords : true,
		pginput : false
	});
	$("#dialogparams").dialog({
		autoOpen: false,
		height: '300',
		width: 550,
		modal: true,
		buttons: [
			{
				text : "Close",
				click : function () {
					$( this ).dialog( "close" );
				}
			}
		]
	});


});
</script>
</head>
<body>
    <div class="ui-layout-north ui-helper-reset ui-helper-clearfix ui-widget" >
		<div class="ui-widget-header ui-corner-all" style="margin-left:2px;margin-right: 2px;">
		<!-- <button  id="bpower" style="width:31px;">Power</button> -->
		<button  id="bnew">New</button>
		<button  id="bopen">Open</button>
		<button  id="bsave">Save</button>
		<button  id="bsetting">Settings</button>
		<button  id="bajax">Ajax</button>
		<button  id="bjavascript">Java Script</button>
		<button  id="bphpscript">PHP Script</button>
		<button  id="bdbase">Connection</button>
		<button  id="bdbsource">Data Source</button>
		<button  id="bparams">Parameters</button>
		</div>
    </div>
    <div class="ui-layout-south ui-widget ui-widget-content">
		File Name: <span id="selname"></span>
	</div>
    <div class="ui-layout-east ui-widget ui-widget-content">
		<div id="tabs" class="aptabs">
			<ul>
				<li><a href="#fprop">Properties</a></li>
				<li><a href="#fevents">Events</a></li>
				<li><a href="#fcode">Code</a></li>
				<li><a href="#fpreview">Preview</a></li>
			</ul>
			<div id="fprop">
				<div>
				<form id="common_data" action="">
					<table style="table-layout: auto;width:606px;">
						<tbody>
							<tr>
								<td style="width:35%">
									<label for="type"> Type </label>
								</td>
								<td>
									<select id="type" name="type" class="ui-widget-content ui-corner-all select-ui" style="width:100%;">
										<option disabled ="disabled" value="form">form</option>
										<option value="text">text</option>
										<option value="password">password</option>
										<option value="checkbox">checkbox</option>
										<option value="radio">radio</option>
										<option value="select">select</option>
										<option value="textarea">textarea</option>
										<option value="button">button</option>
										<option value="submit">submit</option>
										<option value="reset">reset</option>
										<option value="file">file</option>
										<option value="hidden">hidden</option>
										<option value="image">image</option>
										<option value="date">date</option>
										<option value="datetime">datetime</option>
										<option value="number">number</option>
										<option value="range">range</option>
										<option value="email">email</option>
										<option value="url">url</option>
										<option value="search">search</option>
										<option value="tel">tel</option>
										<option value="color">color</option>										
										<option disabled="disabled" value="group">group</option>
								</select>
									
									<!-- <input type="text" id="type" style="width:97%;" disabled="disabled" class="ui-widget-content ui-corner-all input-ui ui-state-disabled"/> -->
								</td>
								<td class="help" title="Shows the type of the element in the DOM"><span class='ui-icon ui-icon-info'></span></td>
							</tr>
							<tr>
								<td>
									<label for="name"> Name </label>
								</td>
								<td>
									<input type="hidden" id="treeid" />
									<input type="text" id="name" name="name" style="width:97%;" autofocus = "autofocus" class="ui-widget-content ui-corner-all input-ui"/>
								</td>
								<td class="help" title="The name attribute specifies the name of a form/input element.<br/>The name attribute of the form/input element provides a way to reference the form/input in a script."><span class='ui-icon ui-icon-info'></span></td>
							</tr>
						</tbody>
					</table>		
				</form>
				</div>
				<div id="fcontent"></div>
			</div>
			<div id="fevents" style="padding-top: 20px">
				<div style="width:600px;max-height: 400px;overflow-y: auto;" class="">
					<table class="eventtable" style="width:100%; table-layout: fixed;border: 0px none; padding: 0px;border-collapse: collapse;border-spacing: 0">
						<thead>
							<tr>
								<th class="ui-state-default ui-corner-tl" style="width:20%;height:27px;">Event</th>
								<th class="ui-state-default" style="width:65%;height:27px;">Code</th>
								<th class="ui-state-default ui-corner-tr" style="width:15%;height:27px;">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					</div>
				<div class="ui-grid-footer ui-state-default ui-corner-bottom ui-helper-clearfix" style="width:598px;">
					<button id="addeventcode" style="height:25px;border: 0px none;">Add new event</button>
				</div>					
			</div>
			<div id="fcode">
				code
			</div>
			<div id="fpreview">
				preview
			</div>
		</div>
		<div id="dialoglist" title="Open File">
			<div id="filelist" class="ui-widget"></div>
		</div>
		<div id="dialogsave" title="Save As...">
			<div id="savelist" class="ui-widget"></div>
		</div>
		<div id="deldialog" title="Delete element" style="display:none">
			<p>Are you sure to delete a element?</p>
		</div>
		<div id="dialogset" title="Form Settings">
			<table style="width:100%;table-layout: fixed;"> 
				<tbody>	
				<tr>
					<td style="width:25%">
						<label for="formlayout"> Form layout</label>
					</td>
					<td>
						<select name="formlayout" id="formlayout" class="ui-widget-content ui-corner-all select-ui">
							<option value="twocolumn">Two Column</option>
							<option value="onecolumn">One Column</option>
						</select>
					</td>
					<td style="width:5%" class="help" title="<?php echo $formlayout?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>					
				<tr>
					<td>
						<label for="formheader"> Form Header:</label>
					</td>
					<td>
						<input name="formheader" id="formheader" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $formheader?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="formicon"> Form Header Icon:</label>
					</td>
					<td>
						<input type="text" name="formicon" value="" id="formicon" maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $formicon?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="tablestyle"> Table Form style</label>
					</td>
					<td>
						<input type="text" name="tablestyle" value="" id="tablestyle"  maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $tablestyle?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="labelstyle"> Label Column style</label>
					</td>
					<td>
						<input type="text" name="labelstyle" value="" id="labelstyle"  maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $labelstyle?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="datastyle"> Data Column style</label>
					</td>
					<td>
						<input type="text" name="datastyle" value="" id="datastyle" maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $datastyle?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td style="vertical-align:top;">
						<label for="formfooter"> Form Footer:</label>
					</td>
					<td>
						<input type ="text" name="formfooter" id="formfooter" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $formfooter?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				</tbody>
			</table>
		</div>
		<div id="dialogconn" title="Connection">
			<table style="width:100%;table-layout: fixed;">
				<tbody>	
				<tr>
					<td style="width:20%">
						<label for="dbtype"> Type:</label>
					</td>
					<td>
						<select name="dbtype" id="dbtype" class="ui-widget-content ui-corner-all select-ui">
							<option value="mysql">PDO MySQL</option>
							<option value="pgsql">PDO PostgreSQL</option>
							<option value="sqlite">PDO SQLite</option>
							<option value="mysqli">MySQLi</option>
							<option value="sqlsrv">SQL Server</option>
							<option value="oci8">Oracle</option>
							<option value="db2">DB2</option>
						</select>
					</td>
					<td style="width:5%" class="help" title="<?php echo $dbtype?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="conname"> Name:</label>
					</td>
					<td>
						<input type="text" name="conname" value="" id="conname" maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $conname?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td style="vertical-align:top">
						<label for="connstring"> Connection String</label>
					</td>
					<td>
						<textarea cols="40" rows="3" name="connstring" id="connstring" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"></textarea>
					</td>
					<td class="help" title="<?php echo $connstring?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="createconn"> Create Connection:</label>
					</td>
					<td>
						<select name="createconn" id="createconn" class="ui-widget-content ui-corner-all select-ui">
							<option value="no">No</option>
							<option value="yes">Yes</option>							
						</select>
					</td>
					<td class="help" title="<?php echo $createconn?>"><span class='ui-icon ui-icon-info'></span></td>				</tr>
				</tbody>
			</table>
		</div>
		<div id="dialogsource" title="Data Source">
			<table style="width:100%;table-layout: fixed;">
				<tbody>
				<tr>
					<td style="vertical-align:top; width:20%;">
						<label for="sqlstring"> SQL Query</label>
					</td>
					<td>
						<textarea cols="40" rows="3" name="sqlstring" id="sqlstring" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"></textarea>
					</td>
					<td class="help" title="<?php echo $sqlstring?>" style="vertical-align:text-top;width:5%;"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="table"> Table Name:</label>
					</td>
					<td>
						<input type="text" name="table" value="" id="table" maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $table?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="tblkeys"> Table Key(s):</label>
					</td>
					<td>
						<input type="text" name="tblkeys" value="" id="tblkeys" maxlength="200" class="ui-widget-content ui-corner-all input-ui" style="width:98%;"/>
					</td>
					<td class="help" title="<?php echo $tblkeys?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td>
						<label for="serialkey"> Serial Key:</label>
					</td>
					<td>
						<input type="checkbox" id="serialkey" name="serialkey" class="ui-widget-content ui-corner-all input-ui"/>
					</td>
					<td class="help" title="<?php echo $serialkey?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- events dialogue -->
	<div id="dialogeventcode">
		<div>
			<label for="event_name">
				Event:
			</label>
		</div>			
		<input id="event_name" value="" class="ui-widget-content ui-corner-all input-ui" style="width:545px;"/>
		<span class="help" title ="<?php echo $jsevent?>" style="float:right;" ><span class='ui-icon ui-icon-info'></span></span>
		<div style="margin-top: 5px;">
			<label for="editor" class="help" title ="<?php echo $jseventcode?>">
				Code: <span class='ui-icon ui-icon-info' style="float:right;"></span>
			</label>
		</div>
		<textarea id="editor" style="height: 250px; width: 550px;"></textarea>
	</div>
	<div id="dialogjavascript" title="Java Script Code Editor">
		<div style="margin-top: 5px;">
			<label for="jseditor" class="help" title ="<?php echo $jscode?>">
				Code: <span class='ui-icon ui-icon-info' style="float:right;"></span>
			</label>
		</div>
		<textarea id="jseditor" style="height: 250px; width: 599px;"></textarea>
	</div>
	<div id="dialogphpscript" title="PHP Script Code Editor">
		<div style="margin-top: 5px;">
			<label for="bphpeditor" class="help" title ="<?php echo $phpcode_b?>">
				Before Create : <span class='ui-icon ui-icon-info' style="float:right;"></span>
			</label>
		</div>
		<textarea id="bphpeditor" style="height: 150px; width: 599px;"></textarea>
		<div style="margin-top: 5px;">
			<label for="rphpeditor" class="help" title ="<?php echo $phpcode_r?>">
				After Create: <span class='ui-icon ui-icon-info' style="float:right;"></span>
			</label>
		</div>
		<textarea id="rphpeditor" style="height: 150px; width: 599px;"></textarea>
	</div>
	<div id="dialogajax" title="Ajax Form Options">
		<form action="" id="aform">
		<table style="width:100%;table-layout: fixed;">
			<tbody>
				<tr>
					<td style="width:15%"> 
						<label for="data">data:</label>
					</td>
					<td> 
						<input id="data" name="data" class="ui-widget-content ui-corner-all input-ui" style="width:98%" />
					</td>
					<td style="width:5%" class="help" title="<?php echo $data?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td> 
						<label for="dataType">dataType:</label>
					</td>
					<td> 
						<select name="dataType" id="dataType" class="ui-widget-content ui-corner-all select-ui" style="">
							<option value="null">null</option>
							<option value="xml">xml</option>
							<option value="json">json</option>
							<option value="script">script</option>
							<option value="text">text</option>
							<option value="html">html</option>
						</select>
					</td>
					<td class="help" title="<?php echo $datType?>"><span class='ui-icon ui-icon-info'></span></td></tr>
				<tr>
					<td> 
						<label for="resetForm">resetForm</label>
					</td>
					<td> 
						<select id="resetForm" name="resetForm" class="ui-widget-content ui-corner-all select-ui" style="">
							<option value="null">Select</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</td>
					<td class="help" title="<?php echo $resetForm?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td> 
						<label for="clearForm">clearForm</label>
					</td>
					<td> 
						<select name="clearForm" id="clearForm" class="ui-widget-content ui-corner-all select-ui" style="">
							<option value="null">Select</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</td>
					<td class="help" title="<?php echo $clearForm?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td> 
						<label for="iframe">iframe</label>
					</td>
					<td> 
						<select id="iframe" name="iframe" class="ui-widget-content ui-corner-all select-ui" style="">
							<option value="false">No</option>
							<option value="true">Yes</option>
						</select>
					</td>
					<td class="help" title="<?php echo $iframe?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td> 
						<label for="iframeSrc">iframeSrc</label>
					</td>
					<td> 
						<input name="iframeSrc" id="iframeSrc" class="ui-widget-content ui-corner-all input-ui" style="width:98%" />
					</td>
					<td class="help" title="<?php echo $iframeSrc?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td> 
						<label for="forceSync">forceSync</label>
					</td>
					<td> 
						<select id="forceSync" name="forceSync" class="ui-widget-content ui-corner-all select-ui" style="">
							<option value="false">No</option>
							<option value="true">Yes</option>
						</select>
					</td>
					<td class="help" title="<?php echo $forceSync?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td style="vertical-align: top"> 
						<label for="beforeSerialize">beforeSerialize:</label>
					</td>
					<td>
						<font  color="blue">function(form, options) {</font>
						<textarea id="beforeSerialize" name="beforeSerialize" style="width:98%;height:80px;"></textarea>
						<font  color="blue">}</font>
					</td>
					<td class="help" style="vertical-align: top" title="<?php echo $beforeSerialize?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td style="vertical-align: top"> 
						<label for="beforeSubmit">beforeSubmit</label>
					</td>
					<td> 
						<font  color="blue">function(arr, form, options) {</font>
						<textarea name="beforeSubmit" id="beforeSubmit" class="ui-widget-content ui-corner-all input-ui" style="width:98%;height:80px;"></textarea>
						<font  color="blue">}</font>
					</td>
					<td class="help" style="vertical-align: top" title="<?php echo $beforeSubmit?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
				<tr>
					<td style="vertical-align: top"> 
						<label for="success">success</label>
					</td>
					<td> 
						<font  color="blue">function(response, status, xhr) {</font>
						<textarea name="success" id="success" class="ui-widget-content ui-corner-all input-ui" style="width:98%;height:80px;"></textarea>
					</td>
					<td class="help" style="vertical-align: top" title="<?php echo $success?>"><span class='ui-icon ui-icon-info'></span></td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
	<div id="dialogparams" title="Form Parameters">
		<form id="newparam" name="newparam" action="#" style="width:505">
			<table style="width:500px;table-layout: fixed;">
				<tbody>
					<tr>
						<td style="width:203px"> <input style="width:197px" type="text" name="prm_name" /></td>
						<td style="width:100px"> 
							<select  style="width:97px" name="prm_type">
								<option value="string">string</option>
								<option value="int">integer</option>
								<option value="numeric">numeric</option>
								<option value="bool">boolean</option>
							</select>
						</td>
						<td style="width:100px"> <input style="width:97px" type="text" name="prm_def" /></td>
						<td style="text-align:center;"> <button id="prm_add"> Add Parameter</button> </td>
					</tr>
				</tbody>
			</table>
		</form>
		<table id="grid_params">
			<tr>
				<td></td>
			</tr>
		</table>
		<div id="pgrid_params"></div>
	</div>
    <div class="ui-layout-center ui-helper-reset ui-helper-clearfix ui-widget-content">
		<table id="west-grid"></table>
    </div>
    <div class="ui-layout-west ui-widget ui-widget-content">
		<button  id="etext" style="width:31px;">Add text element</button>
		<button  id="epassword" style="width:31px;">Add password element</button><br/>
		<button  id="echeckbox" style="width:31px;">Add checkbox element</button><br/>
		<button  id="eradio" style="width:31px;">Add radio button element</button><br/>
		<button  id="eselect" style="width:31px;">Add select element</button><br/>
		<button  id="etextarea" style="width:31px;">Add textarea element</button><br/>
		<button  id="ebutton" style="width:31px;">Add button element</button><br/>
		<button  id="esubmit" style="width:31px;">Add submit button</button><br/>
		<button  id="ereset" style="width:31px;">Add reset button</button><br/>
		<button  id="efile" style="width:31px;">Add file element</button><br/>
		<button  id="ehidden" style="width:31px;">Add hidden element</button><br/>
		<button  id="eimage" style="width:31px;">Add image element</button><br/>
		<button  id="edate" style="width:31px;">Add date element</button><br/>
		<button  id="enumber" style="width:31px;">Add number element</button><br/>
		<button  id="erange" style="width:31px;">Add range element</button><br/>
		<button  id="eemail" style="width:31px;">Add email element</button><br/>
		<button  id="eurl" style="width:31px;">Add url element</button><br/>
		<button  id="esearch" style="width:31px;">Add search element</button><br/>
		<button  id="etel" style="width:31px;">Add telephone element</button><br/>
		<button  id="ecolor" style="width:31px;">Add color element</button><br/>
		<button  id="egroup" style="width:31px;">Add Group</button>
    </div>
</body>
</html>

