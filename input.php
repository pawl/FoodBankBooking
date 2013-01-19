<html>
<head>
	<meta charset="UTF-8" />
	<title>Form Submission</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
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
		<div id="content">
			<center>
	        <div class="success-msg">
				<?php
                  require "include.php";                   
                  
                  
                    $fName = $_POST["fName"];
                    $lName = $_POST["lName"];
                    $phone_number = $_POST["phoneNumber"];
					$email = $_POST["email"];
					$number_of_people = $_POST["numberOfPeople"];
					$contactPreference = $_POST["ContactPreference"];
					
					$t_preferred = 0;
					$c_preferred = 0;
					$e_preferred = 0;
					if(isset($_POST['textMsg'])) {
						$t_preferred = 1;
					}
					if(isset($_POST['call'])) {
						$c_preferred = 1;
					}
					if(isset($_POST['emailCB'])) {
						$e_preferred = 1;
					}
					
                    $is_verified = 0;
					
                    $date = $_POST["date"];
					$zone = $_POST["Zone"];
					if($zone == 'Zone1') {
						$time_start = $date . '  09:00:00';
						$time_end = $date . '  11:30:00';;
					}
					else {
						$time_start = $date . '  13:00:00';
						$time_end = $date . '  14:30:00';;				
					}
					
					$query = "INSERT INTO VOLUNTEER_LIST values ('$fName', '$lName', '$phone_number', '$email','$number_of_people', '$t_preferred', '$c_preferred', '$e_preferred','$is_verified', '$time_start', '$time_end', 0)";
                    //echo $query;
                    if(!mysql_query($query)) {
                          die(mysql_error());		
                    }
                    echo "Your request has been successfully entered, you will receive a confirmation shortly.";	
                ?>
            </div>
			</center>
			<div>
			<script>
			function fbs_click() {
				u='http://web.ntfb.org/';
				t=document.title;
				window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
				return false;
			}
			</script>
			<script>
			function google_click() {
				u='http://web.ntfb.org/';
				window.open('https://plus.google.com/share?url='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');
				return false;
			}
			</script><style> html .fb_share_link { padding:2px 0 0 20px; height:16px; background:url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top left; }</style>
			</script><style> html .g_share_link { padding:2px 0 0 55px; background:url(https://ssl.gstatic.com/s2/oz/images/stars/po/Publisher/sprite4-a67f741843ffc4220554c34bd01bb0bb.png) no-repeat top left; }</style>
			<center><br>
			Invite Your Friends:
			<a rel="nofollow" href="http://www.facebook.com/share.php?u=<;url>" onclick="return fbs_click()" target="_blank" class="fb_share_link"></a>
			<a href="https://plus.google.com/share?url" onclick="return google_click()" class="g_share_link"></a>
			</center>
	        </div>
		</div>		
		<div id="footer">
		</div>	
	</div>
</body>
</html>