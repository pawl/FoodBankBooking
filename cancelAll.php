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

SendEmails($emailList, "North Texas Food Bank Cancelation", "Due to unforseen circumstances tomorrow's volunteer event has been canceled.  Sorry for the inconvenience.", "reminder@ntfoodbank.com");
SendTexts($textList, "Due to unforseen circumstances tomorrow's volunteer event at the North Texas Food Bank has been canceled.  Sorry for the inconvenience.");

echo "Cancelations sent! Do not reload this page!";
?>