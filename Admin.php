<html>
<head>
	<meta charset="UTF-8" />
	<title>Register to Volunteer</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
    
    <link rel="stylesheet" type="text/css" href="jqgrid/themes/redmond/jquery-ui-custom.css" />
	<link rel="stylesheet" type="text/css" href="jqgrid/themes/ui.jqgrid.css" />
    <script src="jqgrid/js/jquery.js" type="text/javascript"></script>
	<script src="jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
	
	
    
    <script src="jqgrid/jq-config.php" type="text/javascript"></script>  
    <script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
    <script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
	
	<script type="text/javascript" src="WCGapi.js"></script>
		<script type="text/javascript">

			var CallerList;
			var CurrentCaller;
			var SoundFile;
		
			function StartCallList(soundFile, recipientList)
			{
				document.getElementById("callbtn").value = "Calling...";
				CallerList = recipientList.split(",");
				CurrentCaller = 0;
				SoundFile = soundFile;
				StartCall("sip:" + CallerList[CurrentCaller] + "@vims1.com");
				CurrentCaller ++;
			}
		
			function RegisterCaller(login, password)
			{
				// Media service
				service = new MediaServices(document.getElementById("url"), login, password, "audio");
				service.turnConfig = "STUN 10.97.33.50:4242";
				service.onclose = serviceOnClose;
				service.onerror = serviceOnError;
				service.oninvite = serviceOnInvite;
				service.onready = serviceOnReady;
				service.onstatechange = serviceOnStateChange;
			}
			
			function StartCall(recipient)
			{
				call = service.createCall(recipient, {video:false,audio:true});
				call.onaddstream = callOnAddStream;
				call.onbegin = callOnBegin;
				call.onend = callOnEnd;
				call.onerror = callOnError;
				call.onremovestream = callOnRemoveStream;
				call.onstatechange = callOnStateChange;
				call.ring();
			}
			
			function playSound(soundfile) 
			{
				 document.getElementById("dummy").innerHTML="<embed src=\""+soundfile+"\" hidden=\"true\" autostart=\"true\" loop=\"false\" />";
			}

			/************************************************************************
			 * Service handlers below												*
			 ***********************************************************************/
			
			function serviceOnClose(event) {
				console.log("[MediaServices] Closed");

			};
			
			function serviceOnClose2(event) {
				console.log("[MediaServices] Closed");

			};
			
			
			function serviceOnError(event) {
				console.log("[MediaServices] Error: " + event.type + " " + event.reason + " " + event.target);
			};
			
			function serviceOnInvite(event) {
				if (event.call) {
					console.log("[MediaServices] Received call invite");
					
					endCall.onclick = function() {
						event.call.end();

					};
				}

			};
			
			function serviceOnReady(event) {
				console.log("[MediaServices] Ready");
				document.getElementById("callbtn").value = "Call to Remind";
			};
			
			function serviceOnReady2(event) {
				console.log("[MediaServices] Ready");

			};
			
			
			function serviceOnStateChange(event) {
				console.log("[MediaServices] State changed: " + event.type + " " + event.state);
			};
			
			/************************************************************************
			 * Call handlers below													*
			 ***********************************************************************/
			
			function callOnAddStream(event) {
				if (event.call.localStreams) {
					console.log("[Call] Local stream added");
					var url = webkitURL.createObjectURL(event.call.localStreams[0]);

					localStream = event.call.localStreams[0];
				}
				if (event.call.remoteStreams) {
					console.log("[Call] Remote stream added");
					var url = webkitURL.createObjectURL(event.call.remoteStreams[0]);

					remoteStream = event.call.remoteStreams[0];
				}
			};
			
			function callOnBegin(event) {
				console.log("[Call] Call has started");
				playSound(SoundFile);
			};
			
			function callOnEnd(event) {
				console.log("[Call] Call has ended");
				document.getElementById("dummy").innerHTML="";
				
				document.getElementById("callbtn").value = "Calls Finished";
				
				if (CallerList.length > CurrentCaller)
				{
					StartCall("sip:" + CallerList[CurrentCaller] + "@vims1.com");
					CurrentCaller ++;
				}
			};
			
			function callOnError(event) {
				console.log("[Call] Error: " + event.type + " " + event.reason + " " + event.target);
			};
			
			function callOnRemoveStream(event) {
				console.log("[Call] Stream removed");
				localStream.stop();
				remoteStream.stop(); 
				// Do stuff with event.call.remoteStreams
			};
			
			function callOnStateChange(event) {
				console.log("[Call] State changed: " + call.state);
			};

		</script>
</head>
<body onload="RegisterCaller('sip:16509992364@vims1.com','EECpa$$w0rd')">
	<div id="page">
	  <div id="header">
			<div id="section">
				<div>                        
					<a href="index.php"><img src="logo.png" alt="Logo" /></a>           
				</div>
				
			</div>
		</div>
		<div id="content" style="padding: 30px; width: 1050px; height: 500px">
			<div><?php include("grid.php"); ?></div>
			<table align="right" style="padding: 20px">
				<tr>
					<td>
					<input id="callbtn" type="submit" name="callButton" value="Registering to Call..." class="submit-btn" onclick="StartCallList('reminder.wav', '18177398992')"/>
						</td>
					<td>
						<FORM METHOD="LINK" ACTION="notifyAll.php">
						<input type="submit" name="remindButton" value="Remind Everyone" class="submit-btn"/>
						</FORM>
					</td>
					<td>
						<FORM METHOD="LINK" ACTION="cancelAll.php">
						<input type="submit" name="cancelButton" value="Cancel Tomorrows Event" class="submit-btn"/>
						</FORM>
					</td>
				</tr>
			</table>
		</div>
		<div id="footer">
		</div>
	</div>
	
	<span id="dummy"></span>
</body>
</html>
