<?php

require "include.php"; 
						
$getEventsSQL = mysql_query("SELECT * FROM CALENDAR_DATA");

$events = array();
while ($row = mysql_fetch_array($getEventsSQL)) {
    $start = $row['Time_Start']; // date and time of event - start
    $end = $row['Time_End']; // date and time of event - end 
	$titleTime = split(" ", $row['Time_Start']); // time in the title
	$titleTime = split(":", $titleTime[1]); 
	if ($titleTime[0] > 12) {
		$titleTime = "1pm";
	}
	else {
		$titleTime = "9am";
	}
	
    //$title = $row['task']; // how many people are coming
    //$eventsArray['id'] =  '1';
    $eventsArray['title'] = $titleTime . ' (' . $row['Number'] . ' out of 10)';
    $eventsArray['start'] = $start;
    $eventsArray['end'] = $end;
	
	if ($row['Number'] < 10) {
		$eventsArray['color'] = "green";
	}
	else {
		$eventsArray['color'] = "red";
		}
    //$eventsArray['url'] = "#todolist";
    $events[] = $eventsArray;
}


echo json_encode($events);

?>