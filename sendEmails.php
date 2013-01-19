<?php

function SendEmails($emails, $subject, $message, $sender)
{
	$emails = split(",",$emails);

	foreach ($emails as $email)
	{
		$to = $email;
		$subject = $subject;
		$message = $message;
		$from = $sender;
		$headers = "From:" . $from;
		mail($to,$subject,$message,$headers);
	}
}
?>