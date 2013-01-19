<html>
<head>
	<meta charset="UTF-8" />
	<title>Approve Prospective Volunteers</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
    
    <link rel="stylesheet" type="text/css" href="jqgrid/themes/redmond/jquery-ui-custom.css" />
	<link rel="stylesheet" type="text/css" href="jqgrid/themes/ui.jqgrid.css" />
    <script src="jqgrid/js/jquery.js" type="text/javascript"></script>
	<script src="jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
	
	
    
    <script src="jqgrid/jq-config.php" type="text/javascript"></script>  
    <script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
    <script src="jqgrid/js/jquery-ui-custom.min.js" type="text/javascript"></script> 
</head>
<body>
	<div id="page">
	  <div id="header">
			<div id="section">
				<div>                        
					<a href="index.php"><img src="logo.png" alt="Logo" /></a>           
				</div>
				
			</div>
		</div>
		<div id="content" style="padding: 30px; width: 80%; height: 650px">
			<div><?php include("approvalGrid.php"); ?></div>
			<table align="right" style="padding: 20px">
				<tr>
							<td>				
								<label class="ss-q-title" for="idApproval">ID To Approve</label>
							</td>
							<td>   					
								<input type="text" name="idApproval" value="" class="form-element" id="idApproval"/>
							</td>
				</tr>
				<tr>
					<td>
						<input id="remindButton" type="submit" name="remindButton" value="Approve Selected" class="submit-btn"/>
					</td>
					<td>
					</td>
				</tr>
			</table>
			<script>
			$('#remindButton').click(function() {
				var data = $("#idApproval").val();
			  $.ajax({
				  type: 'POST',
				  url: "approvalQuery.php",
				  data: {data: data},
				  success: function(){
						alert('success');
					  },
				  dataType: "json"
				});
			});
			</script>
			
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
