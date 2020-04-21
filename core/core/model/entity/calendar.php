<?php
class calendar extends baseEntity{
	
	public $config;
	public $viewOptions;
	public $viewOptionsColors;
	public $mode; //used to set view to day/week/month
	public $calendar_time;
	public $calendar_view_start;
	public $calendar_view_end;
	public $calendar_entities;
	
	
	
	public function __construct(){
		$this->isLoggedIn = FALSE;	
		
		//NOT IMPLEMENTED
		//Config Property used for indicating this property should be unique in the database
		//id is always unique, it doesn't need to be included here
		$this->config['uniqueProperties'] = array('name');
		
		
		//only see thiers set as true or false allows users to only entities in collections
		//that belong to them. Usful example might include, media object and orders where
		//we would only want a user to see the entites that belong to them
		//Note: the "see all entities" overrides this option
		$this->config['onlySeeTheirs'] = true;
		
		//Config Property used for heading Lists, Search Results, and more ... it's always visible
		$this->config['primaryIDProperty'] = 'name';
		
		//Config Propery used for extending the primaryIDProperty, may be more than one existing property name
		$this->config['primaryViewProperties'] = array("name");
		
		//NEW CONFIG property used for created internal map of objects
		$this->config['associations']['belongsTo'] = array('user','company');
		$this->config['associations']['has'] = array();
		
		//Set the calendar time to be now, by default
		$this->SetCalendarTime(time());
		
		$this->mode = 'Month';
		
		//Must always be last in the base contructor method
		parent::__construct();
	}
	
	public function init(){
		global $hooks;
		//Add Hook Actions in init()
		//For hooks functionality see /core/utility/php-hooks-master/src/voku/helper/hooks.php
		//For hook actions see /core/TODO.php
		
		//$hooks->add_action('calendar_main_toolbar', array($this, 'calendarViewButton'));
		//$hooks->add_action('calendar_table_viewport', array($this, 'calendarView'));
		$hooks->add_action('calendar_tile_viewport', array($this, 'calendarView'));
		$hooks->add_action('calendar_modal_viewport', array($this, 'calendarView'));
		
		
		//$hooks->add_action('calendar_viewport', array($this, 'calendarView'));
		$hooks->add_action('calendar_actions', array($this, 'calendarOptions'));
		
		//$hooks->add_action('calendar_actions', array($this, 'calendarActionToolbar'));
		$hooks->add_action('calendar_header', array($this, 'calendarActionToolbar'));
	}
	
	public function calendarOptions(){
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/user_modules/calendar/calendar_options.php");
	}
	
	public function calendarActionToolbar($entity){
		
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/user_modules/calendar/calendar_actions_toolbar.php");
	}
	
	public function calendarView($entity){
		global $global_objects , $hooks;
		
		//import the global objects
		foreach($global_objects as $o){
			if(is_object($o)){
				$o_name = get_class($o);
				$$o_name = $o;
			}
		}
		
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/user_modules/calendar/dataview_calendar.php");
	}
	
	public function calendarViewButton($entities){
		
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/user_modules/calendar/calendar_toolbar.php");
	}
	
	
	public static function getDBIgnoreList(){
		$array = parent::getDBIgnoreList();
		array_push($array,'calendar_entities');
		return $array;
	}
	
	public static function getFormIgnoreList(){
		$array = parent::getFormIgnoreList();
		$ignore = array('viewOptions','viewOptionsColors','mode','calendar_time','calendar_view_start','calendar_view_end','calendar_entities');
		array_push($array,$ignore);
		return $array;
		
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		
		
	}
	
	public function getEntitiesWithTime(){
		global $global_objects , $hooks;
		
		$return_array = array();
		
		//import the global objects
		foreach($global_objects as $o){
				
			if (is_object($o)){
				
				
				if ($this->hasSpecialProperty('Date',$o)){
					$return_array[get_class($o)] = $this->getSpecialProperties('Date', $o );
				}
				
			}
		}
		return $return_array;	
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function openCalendarEntities(){
			
		//unset the current entity collection
		$this->closeCalenderEntities();
		
		if (!is_array($this->viewOptions)){return;}
		
		foreach ($this->viewOptions as $option){
			
			//echo $option;
			$optionPart = explode("-",$option);
			
			$table_type = inflector::pluralize($optionPart[0]);
			$table = new $table_type();
			$table->setCalendarSTMTSql($optionPart[1],$this->calendar_view_start,$this->calendar_view_end);
			$table->openCalendarEntities();
			
			//push the entites collected
			foreach($table->calendar_entities as $entity){
				array_push($this->calendar_entities,$entity);
			}
			
			unset($table);
		}
		
		//remove any duplicates 
		$this->calendar_entities = array_unique($this->calendar_entities, SORT_REGULAR);
		
		
	}
//++++++++++++++++++++++++++++++++++++++++
	//checks if an viewOption (entity-propery_name) formatted array element has a matching end type
	// else returns false
	public function getOptionHasEndRange($option){
		
		$optionPart = explode("-",$option);
		
		$opt = explode(" ", html_helper::cleanText($optionPart[1]));
		
		$cnt = count($opt);
		
		if ($opt[($cnt - 2)] == 'Start' || $opt[($cnt - 2)] == 'start'){
			
			//get the prefix of the option
			$p = array_slice($opt, 1, ($cnt - 3) );
			
			$prefix = "";
			//reasseble the options, exchanging Start with end
			foreach ($p as $segment){
				$prefix .= $segment;
			}
			
			$endOptionNameUpper = $prefix.'End'.$opt[($cnt - 1)];
			$endOptionNameLower = $prefix.'end'.$opt[($cnt - 1)];
			
			if (in_array($optionPart[0] . '-' . $endOptionNameUpper,$this->viewOptions)){
				return $endOptionNameUpper;
			}
			
			elseif (in_array($optionPart[0] . '-' . $endOptionNameLower,$this->viewOptions)){
			
				return $endOptionNameLower;
			
			} else {return false;}
			
			
		}	
			
	}
//+++++++++++++++++++++++++++++++++++++++++++
	public function closeCalenderEntities(){
		unset($this->calendar_entities);
		$this->calendar_entities = array();
	}
//+++++++++++++++++++++++++++++++++++++++++++
	public function calendarReset(){
		$this->SetCalendarTime(time());
		
	}
	
		
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Set the current calendar time
	 */
	public function SetCalendarTime($time){
		$this->calendar_time = $time;
		$this->SetCalendarView();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * 
	 *  Sets the calendar time to next day 
	 */
	public function SetCalendarTimeNextDay(){
		$this->calendar_time = calendar::getOneDay() + $this->calendar_time ;
		$this->SetCalendarView();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * 
	 *  Sets the calendar time to Last day 
	 */
	public function SetCalendarTimeLastDay(){
		$this->calendar_time = $this->calendar_time - calendar::getOneDay() ;
		$this->SetCalendarView();
	}	
	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * 
	 *  Sets the calendar time to next week 
	 */
	public function SetCalendarTimeNextWeek(){
		$this->calendar_time = calendar::getOneWeek() + $this->calendar_time ;
		$this->SetCalendarView();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	/*
	 * 
	 *  Sets the calendar time to Last week 
	 */
	public function SetCalendarTimeLastWeek(){
		$this->calendar_time = $this->calendar_time - calendar::getOneWeek() ;
		$this->SetCalendarView();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Set the current calendar time to beginning of the next month
	 */
	public function SetCalendarTimeNextMonth(){
		$this->calendar_time = calendar::getNextMonth($this->calendar_time);
		$this->SetCalendarView();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Set the current calendar time to beginning of last month
	 */
	public function SetCalendarTimeLastMonth(){
		$this->calendar_time = calendar::getLastMonth($this->calendar_time);
		$this->SetCalendarView();
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * Set the current calendar start and end times depending on mode
	 */
	public function SetCalendarView(){
		
		//Make "month" the default
		if (!isset($this->mode) || $this->mode == null){
			$this->mode = 'Month';
		}
		//Sets the view for a month 
		if ($this->mode == 'Month'){
			//Translate timestamps to dates.....
			$this->calendar_view_start = date(DATE_FORMAT,calendar::getViewStart($this->calendar_time));
			$this->calendar_view_end = date(DATE_FORMAT,calendar::getViewEnd($this->calendar_time));
		}
		//Set the view for a week
		if ($this->mode == 'Week'){
			//Translate timestamps to dates.....
			$this->calendar_view_start = date(DATE_FORMAT,calendar::getFirstDayOfWeek($this->calendar_time));
			$this->calendar_view_end = date(DATE_FORMAT,calendar::getLastDayOfWeek($this->calendar_time));
		}
		
		//Set the view for a week
		if ($this->mode == 'Day'){
			$this->calendar_view_start = date(DATE_FORMAT,calendar::getStartOfToday($this->calendar_time));
			$this->calendar_view_end = date(DATE_FORMAT,calendar::getEndOfToday($this->calendar_time));
		}
	}
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Sets the calendars mode to day/week/month
	public function SetCalendarMode($mode){
		
		$modes = array("Month","Week","Day");
		
		if (!in_array($mode,$modes)){
			$mode = "Month";
		}
		$this->mode = $mode;
		$this->SetCalendarView();
	}	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	public function getMonths(){
		$months = array(
		'01'=>'January',
		'02'=>'Febuary',
		'03'=>'March',
		'04'=>'April',
		'05'=>'May',
		'06'=>'June',
		'07'=>'July',
		'08'=>'August',
		'09'=>'September',
		'10'=>'October',
		'11'=>'November',
		'12'=>'December'		
		);
		return $months;
	}
	
	//Returns the first day for a calendar view
	public static function getViewStart($timestamp){
		//get the first and last day of the month
		$first_day_of_month = strtotime("midnight first day of this month",$timestamp);
		
		$this_day = date('w',$first_day_of_month);
		
		//represents the time of the begining of view, including any trailing days of previous month
		return strtotime('-'.$this_day.' days',$first_day_of_month);
	}
	
	//Returns the last day for a calendar view
	public static function getViewEnd($timestamp){
		//get the first and last day of the month
		$first_day_of_month = strtotime("midnight first day of this month",$timestamp);
		$last_day_of_month = strtotime("midnight last day of this month",$timestamp);
		
		$this_day = date('w',$last_day_of_month);
		
		//represents the time of the end of the month view, including any leading days from the next month
		return strtotime('+'.(6-$this_day).' days',$last_day_of_month);
	}
	
	//
	public function getYearsFromNow($range){
		$years = range(date("Y"), date("Y")+$range); 
		return $years;
	}
	
	//Returns last second of this month
	public static function getEndOfMonth($timestamp){
		return strtotime("midnight last day of this month",$timestamp) + calendar::getOneDay() - 1;
	}
	
	//Return first second of this month
	public static function getBeginingOfMonth($timestamp){
		return strtotime("midnight first day of this month",$timestamp);}
	
	//returns the first second of next month
	public static function getNextMonth($timestamp){
		return strtotime("midnight first day next month",$timestamp);
	}
	
	//returs the first second of last month
	public static function getLastMonth($timestamp){
		return strtotime("midnight first day last month",$timestamp);
	}
	
	//returns the last second of the last day this week
	public static function getLastDayOfWeek($timestamp){
		$day = date('w',$timestamp);
		return strtotime('+'.(6-$day).' days',$timestamp);
	}
	
	//returns first second of this week
	public static function getFirstDayOfWeek($timestamp){
		$day = date('w',$timestamp);
		$time = strtotime('-'.$day.' days',$timestamp);
		return $time;
	}
	
	
	//Returns midnight of today
	public static function getStartOfToday($timestamp){return strtotime("today",$timestamp);}
	
	//Returns the last second of today
	public static function getEndofToday($timestamp){return calendar::getStartOfToday($timestamp) + calendar::getOneDay() - 1;}
	
	//returns amount of seconds in a day
	public static function getOneDay(){return 86400;}
	
	//returns amount of sends in one week
	public static function getOneWeek(){return calendar::getOneDay() * 7;}
	
	//returns amount of secondds in one hour
	public static function getOneHour(){
		return calendar::getOneDay()/24;
	}
	
	public static function getFifteenMinutes(){
		return calendar::getOneHour()/4;
	}
	
	//returns true if a given time is within the range of a given date, both given as timestamps
	public static function isToday($time,$today){
			
		if ($time >= calendar::getStartOfToday($today) && $time <= calendar::getEndofToday($today)){
			return true;
		} else {return false;}
	}
	
	//returns true if a given time is within the range of a given date, both given as timestamps
	public static function isInQuarterHour($time,$today){
			
		if ($time >= $today && $time < ($today + calendar::getFifteenMinutes())){
			return true;
		} else {return false;}
	}
	
	//returns true if a given time is with the range of a given date, both given as timestamps
	public static function isInWeek($time,$today){
		
		if ($time >= calendar::getFirstDayOfWeek($today) && $time <= calendar::getLastDayOfWeek($today)){
			return true;
		} else {return false;}
		
	}
	
	
	
	//returns true if a given time is in the range of a day
	public static function isInDay($time,$today){
		
		if ($time >= calendar::getStartOfToday($today) && $time <= calendar::getEndofToday($today)){
			return true;
		} else {return false;}
		
	}
	
	//returns a timestamp from a dateTime 
	public static function getTimestamp($dateTime){
		$date = new DateTime($dateTime);
		return $date->format("U");
	}
	
	
	//returns the number of days from a given range. 
	public static function getDaysFromRange($timeStart,$timeEnd){
		return ceil(($timeEnd - $timeStart)/(calendar::getOneDay()-1));
		
	}
	
	//returns the number of days from a given range. 
	public static function getQuarterHoursFromRange($timeStart,$timeEnd){
		$quarters = ceil(($timeEnd - $timeStart)/(calendar::getFifteenMinutes()-1) );
		
		
		if($quarters > 96){
			$quarters = 96;
		}
		if($quarters < 1){
			$quarters = 1;
		}
		return $quarters;
	}

 
}
?>