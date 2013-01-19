<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class jqEventLocalization {

//fullcalender translations
// these locale setting use javascript convensions for date forrmating
/*
 * !!!!!!!!! NOTE dateFormat in fullcalender differ from datepicker 
 * Configure both in appropriate way
 */

public $dateFormat = "dd/MM/yyyy";

public $fullcalendar = array(
	'isRTL'=> false,
	'firstDay' => 1,
	'monthNames'=>array('January','February','March','April','May','June','July','August','September','October','November','December'),
	'monthNamesShort'=>array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
	'dayNames'=> array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
	'dayNamesShort'=>array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),
	'buttonText'=>array (
		'prev'=> '&nbsp;&#9668;&nbsp;',
		'next'=> '&nbsp;&#9658;&nbsp;',
		'prevYear'=> '&nbsp;&lt;&lt;&nbsp;',
		'nextYear'=> '&nbsp;&gt;&gt;&nbsp;',
		'today' =>'today',
		'month' =>'month',
		'week' =>'week',
		'day'=> 'day',
		'year'=> 'year',
		'search'=>'search'
	),
	'allDayText'=> 'all-day',
	'axisFormat'=> 'h(:mm)tt',
	'timeFormat'=>array(
		'agenda'=> 'h:mm{ - h:mm}'
	)
);

//Time picker
// slotMinutes: 30 - this is get from calender options
// the corresponding options is timeInterval
public $timepicker = array(
	"minutes"=>"mins",
	"onehour"=>"1 hr",
	"hours"=>"hrs"
);
// Timepicker search dialog
public $timepicker_lang = array(
	'timeOnlyTitle' =>'Choose Time',
	'timeText'=>'Time',
	'hourText'=> 'Hour',
	'minuteText'=> 'Minute',
	'secondText'=> 'Second',
	'currentText'=> 'Now',
	'closeText'=> 'Done',
	'ampm'=> false
);

function __construct() {
	if($this->use_datepicker_lang === false)
	{
		$this->setDatepickerLang();
	}
}

// Datepicker translations.
// We do this here since we can not determine the current datepicker pranslation
public $use_datepicker_lang = false;

public $datepicker_lang = array();
public function setDatepickerLang( )
{
	$this->datepicker_lang= array(
		'closeText'=>'Done',
		'prevText'=>'Prev',
		'nextText'=>'Next',
		'currentText'=>'Today',
		'showMonthAfterYear'=> false,
		'yearSuffix'=> '',
		'dayNamesMin' => array('Su','Mo','Tu','We','Th','Fr','Sa'),
		'weekHeader'=> 'Wk',
		'dateFormat'=> 'dd/mm/yy', // THE MOST IMPORTANT DIFFERENCE FROM full calender.
		// Do not translate these - do it in fullcalender
		'monthNames' => $this->fullcalendar['monthNames'],
		'monthNamesShort'=> $this->fullcalendar['monthNamesShort'],
		'dayNames'=> $this->fullcalendar['dayNames'],
		'dayNamesShort'=> $this->fullcalendar['dayNamesShort'],
		'firstDay'=> $this->fullcalendar['firstDay'],
		'isRTL'=> $this->fullcalendar['isRTL']
	);
}
	
//  buttons left
public $button_search = "Search";
public $button_user = "Calendar";
public $button_export = "Export";
public $button_print = "Print";

public $captionchangeusr = "Change Calendar";
public $currentcalendar ="Current Calendar(s)";

// Search 
public $find = 'Find';
public $close = 'Close';
public $captionsearch = "Advanced Search";
public $found_events = "Found";
public $header_search = "Search Events";
// do not tuch the order
public $searchopers = array(
	'equal',
	'not equal',
	'less',
	'less or equal',
	'greater',
	'greater or equal',
	'begins with',
	'does not begin with',
	'in',
	'not in',
	'ends with',
	'does not end with',
	'contains',
	'does not contain',
	'is null',
	'is not null'
);

// Form Fields
public $form_title = "Title";
public $form_description = "Description";
public $form_start = "Start";
public $form_end = "End";
public $form_location = "Location";
public $form_categories= "Category";
public $form_access = "Access";
public $form_all_day = "All Day Event";
public $form_user_id = "Calendar";

// Form Buttons
public $add = "Add";
public $save = "Save";
public $remove = "Remove";
public $change = "Change";
public $cancel = "Cancel";
//Form Titles
public $captionedit = "Edit Event";
public $captionadd = "New Event";
public $captionlist = "List Event(s)";


// options categories.
// translate the value and not the keys.
public $option_categories = array(
	"personal"=>"Personal",
	"work"=>"Work",
	"family"=>"Family",
	"holiday"=>"Holiday"
);
// if you add or delete in option category change the array bellow accordandly
public $categories_css = array(
	'personal' => '#c0c0c0', 
    'work' => '#ff0000',
    'family' => '#00ff00',
    'holiday' => '#ff6600'
);

public $option_access = array(
	"public"=>"Public",
	"private"=>"Private"
);

//Swich user form
public $label_user = "Select Calendar";
public $title_user = "Change calendar user";

}
?>
