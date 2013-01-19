<?php
include "sendEmails.php";
include "sendText.php";

require "include.php";  
				  
$sql = "SELECT CONCAT( First_Name,  ' ', Last_Name ) As Name, Number_Of_People, Phone_Number, Email, Time_Start Start_Time, Email_Preferred, Text_Preferred, Call_Preferred FROM VOLUNTEER_LIST WHERE Time_Start > '" . $tomorrow . ' AND TIME_END < "' . $dayAfter . "'";
$result = mysql_query($sql);

$emailList = "";
$firstEmail = true;
$textList = "";
$firstText = true;
$callList = "";
$firstCall = true;

while ($row = mysql_fetch_assoc($result))
{
	if ($row['Email_Preferred'] == 1)
	{
		if (!$firstEmail)
			$emailList .= ",";
		$emailList .= $row["Email"];
		$firstEmail = false;
	}
	if ($row['Text_Preferred'] == 1)
	{
		if (!$firstText)
			$textList .= ",";
		$textList .= $row["Phone_Number"];
		$firstText = false;
	}
	if ($row['Call_Preferred'] == 1)
	{
		if (!$firstCall)
			$callList .= ",";
		$callList .= $row["Phone_Number"];
		$firstCall = false;
	}
}

SendEmails($emailList, "North Texas Food Bank Notification", "This is a reminder that you are scheduled to volunteer tomorrow!", "reminder@ntfoodbank.com");
SendTexts($textList, "This is a reminder that you are scheduled to volunteer tomorrow at the North Texas Food Bank!");

echo "Notifications sent! Do not reload this page!";
?>