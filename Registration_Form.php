<html>
<head>
	<meta charset="UTF-8" />
	<title>Register to Volunteer</title>
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
			<form id="ss-form" action="input.php" method="post">
				<table style="width:450px;" cellpadding="5px">
					<tbody>
						<tr>
							<td>         	
								<label class="ss-q-title" for="fName">First Name</label>
							</td>
							<td>                	
								<input type="text" name="fName" value="" class="form-element" id="fName"/>
							</td>
						</tr>
						<tr>
							<td>                	
								<label class="ss-q-title" for="lName">Last Name</label>
							</td>
							<td>					
								<input type="text" name="lName" value="" class="form-element" id="lName"/>
							</td>
						</tr>
						<tr>
							<td>				
								<label class="ss-q-title" for="phoneNumber">Phone Number</label>
							</td>
							<td>   					
								<input type="text" name="phoneNumber" value="" class="form-element" id="phoneNumber"/>
							</td>
						</tr>
						<tr>
							<td>				
								<label class="ss-q-title" for="phoneNumber">Email</label>
							</td>
							<td>   					
								<input type="text" name="email" value="" class="form-element" id="email"/>
							</td>
						</tr>
						<tr>
							<td>                	
								<label class="ss-q-title" for="numberOfPeople">Number of People</label>
							</td>
							<td>   					
								<input type="text" name="numberOfPeople" value="" class="form-element" id="numberOfPeople"/>
							</td>
						</tr>
						<tr>
							<td valign="top">                	
								<label class="ss-q-title" for="Texts">Contact Preference</label>
							</td>
							<td>
								<div>
									<label class="ss-choice-label">
										<input type="checkbox" name="textMsg" value="textMsg" id="textMsg" checked="checked"/>
										Text Message
									 </label>
								 </div>
								 <div>
									<label class="ss-choice-label">
										<input type="checkbox" name="call" value="call" id="call"/>
										Call
									 </label>
								 </div>
								 <div>
									<label class="ss-choice-label">
										<input type="checkbox" name="emailCB" value="email" id="emailCB"/>
										Email
									 </label>
								 </div>
							</td>
						</tr>
						<tr>
							<td>                	
								<label class="ss-q-title" for="date">Date</label>
							</td>
							<td>                	
								<?php
									$date = $_GET['date'];
									if($date) {
										//$date = new DateTime($date);
										//$date = date_format($date, 'Y-m-d');
										echo '<input type="date" name="date" class="form-element" id="date" value="' . $date . '"/>';
									}
									else {
										echo '<input type="date" name="date" class="form-element" id="date"/>';										
									}									
								?>
								
							</td>
						</tr>
						
						<tr>
							<td valign="top">                	
								<label class="ss-q-title" for="Zone1">Time Range</label>
							</td>
							<td>
								<div>
									<label class="ss-choice-label">
										<input type="radio" name="Zone" value="Zone1" id="Zone2" checked="checked"/>
										9:00 am to 11:30 am
									 </label>
								 </div>
								 <div>
									<label class="ss-choice-label">
										<input type="radio" name="Zone" value="Zone2" id="Zone2"/>
										1:00 pm to 3:30 pm
									 </label>
								 </div>
							</td>
						</tr>
						<tr>
							<td>                	
							</td><td>
								<input type="submit" name="submitButton" value="Request To Volunteer" class="submit-btn"/>
							</td>
						</tr>
					 </tbody>
				 </table>
			</form>
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
