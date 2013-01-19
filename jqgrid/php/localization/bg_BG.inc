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

// do not change this - it is changed at runtime automatically
public $dateFormat = "dd/MM/yyyy";

public $fullcalendar = array(
	'isRTL'=> false,
	'firstDay' => 1,
	'monthNames'=>array('Януари','Февруари','Март','Април','Май','Юни','Юли','Август','Септември','Октомври','Ноември','Декември'),
	'monthNamesShort'=>array('Яну','Фев','Мар','Апр','Май','Юни','Юли','Авг','Сеп','Окт','Ное','Дек'),
	'dayNames'=> array('Неделя','Понеделник','Вторник','Сряда','Четвъртък','Петък','Събота'),
	'dayNamesShort'=>array('Нед','Пон','Вто','Сря','Чет','Пет','Съб'),
	'buttonText'=>array (
		'prev'=> '&nbsp;&#9668;&nbsp;',
		'next'=> '&nbsp;&#9658;&nbsp;',
		'prevYear'=> '&nbsp;&lt;&lt;&nbsp;',
		'nextYear'=> '&nbsp;&gt;&gt;&nbsp;',
		'today' =>'днес',
		'month' =>'месец',
		'week' =>'седмица',
		'day'=> 'ден',
		'search'=>'търси'
	),
	'allDayText'=> 'цял ден',
	'axisFormat'=> 'hh(:mm)',
	'timeFormat'=>array(
		'agenda'=> 'h:mm{ - h:mm}'
	)
);

//Time picker
// slotMinutes: 30 - this is get from calender options
// the corresponding options is timeInterval
public $timepicker = array(
	"minutes"=>"мин.",
	"onehour"=>"1 час",
	"hours"=>"часа"
);
// Timepicker search dialog
public $timepicker_lang = array(
	'timeOnlyTitle' =>'Избор Време',
	'timeText'=>'Време',
	'hourText'=> 'Час',
	'minuteText'=> 'Минути',
	'secondText'=> 'Секунди',
	'currentText'=> 'Сега',
	'closeText'=> 'Готово',
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
		'closeText'=>'Готово',
		'prevText'=>'Пред.',
		'nextText'=>'Следв.',
		'currentText'=>'Днес',
		'showMonthAfterYear'=> false,
		'yearSuffix'=> '',
		'dayNamesMin' => array('Нд','По','Вт','Ср','Че','Пе','Съ'),
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
public $button_search = "Търси";
public $button_user = "Календар";
public $button_export = "Експорт";
public $button_print = "Печат";

public $captionchangeusr = "Смяна Календар";
public $currentcalendar ="Текущ(и) Календар(и)";

// Search 
public $find = 'Намери';
public $close = 'Затвори';
public $captionsearch = "Разширено Търсене";
public $found_events = "Намерени";
public $header_search = "Търсене на Събития";
// do not tuch the order
public $searchopers = array(
	'равно',
	'различно',
	'по-малко',
	'по-малко или равно',
	'по-голямо',
	'по-голямо или равно',
	'зпочва с',
	'не започва с',
	'е в',
	'не е в',
	'звършва',
	'не завършва',
	'съдържа',
	'не съдържа',
	'е null',
	'не е null'
);

// Form Fields
public $form_title = "Заглавие";
public $form_description = "Описание";
public $form_start = "Начало";
public $form_end = "Край";
public $form_location = "Къде";
public $form_categories= "Категория";
public $form_access = "Достъп";
public $form_all_day = "Целодневно Събитие";
public $form_user_id = "Календар";
// Form Buttons
public $add = "Добави";
public $save = "Съхрани";
public $remove = "Премахни";
public $change = "Промени";
public $cancel = "Отказ";
//Form Titles
public $captionedit = "Редакция Събитие";
public $captionadd = "Ново Събитие";
public $captionlist = "Списък Събития";

// options categories.
// translate the value and not the keys.
public $option_categories = array(
	"personal"=>"Лично",
	"work"=>"Работа",
	"family"=>"Семейство",
	"holiday"=>"Почивка"
);
// if you add or delete in option category change the array bellow accordandly
public $categories_css = array(
	'personal' => '#c0c0c0', 
    'work' => '#ff0000',
    'family' => '#00ff00',
    'holiday' => '#ff6600'
);

public $option_access = array(
	"public"=>"Обществен",
	"private"=>"Личен"
);

//Swich user form
public $label_user = "Избор на Календар";
public $title_user = "Промяна Потребител Календар";
}
?>
