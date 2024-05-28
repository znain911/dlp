<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Calendar extends CI_Controller { 
     
    function __construct() { 
        parent::__construct(); 
         
        $this->load->model('event'); 
    } 
     
    public function index(){ 
        $data = array(); 
        $data['eventCalendar'] = $this->eventCalendar(); 
        $this->load->view('calendar/index', $data); 
    } 
     
    /* 
     * Generate calendar with events 
     */ 
    public function eventCalendar($year = '', $month = ''){ 
        $data = array(); 
         
        $dateYear = ($year != '')?$year:date("Y"); 
        $dateMonth = ($month != '')?$month:date("m"); 
        $date = $dateYear.'-'.$dateMonth.'-01'; 
        $eventDate = empty($year) && empty($month)?date("Y-m-d"):$date; 
        $currentMonthFirstDay = date("N", strtotime($date)); 
        $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN, $dateMonth, $dateYear); 
        $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 1)?($totalDaysOfMonth):($totalDaysOfMonth + ($currentMonthFirstDay - 1)); 
        $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42; 
         
        $prevMonth = date("m", strtotime('-1 month', strtotime($date))); 
        $prevYear = date("Y", strtotime('-1 month', strtotime($date))); 
        $totalDaysOfMonth_Prev = cal_days_in_month(CAL_GREGORIAN, $prevMonth, $prevYear); 
         
        $con = array( 
            'where' => array( 
                'status' => 1 
            ), 
            'where_year' => $dateYear, 
            'where_month' => $dateMonth 
        ); 
        $data['events'] = $this->event->getGroupCount($con); 
         
        $data['calendar'] = array( 
            'dateYear' => $dateYear, 
            'dateMonth' => $dateMonth, 
            'date' => $date, 
            'currentMonthFirstDay' => $currentMonthFirstDay, 
            'totalDaysOfMonthDisplay' => $totalDaysOfMonthDisplay, 
            'boxDisplay' => $boxDisplay, 
            'totalDaysOfMonth_Prev' => $totalDaysOfMonth_Prev 
        ); 
         
        $data['monthOptions'] = $this->getMonths($dateMonth); 
        $data['yearOptions'] = $this->getYears($dateYear); 
        $data['eventList'] = $this->getEvents($eventDate, 'return'); 
 
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])){ 
            $this->load->view('calendar/event-cal', $data); 
        }else{ 
            return $this->load->view('calendar/event-cal', $data, true); 
        } 
    } 
     
    /* 
     * Generate months options list for select box 
     */ 
    function getMonths($selected = ''){ 
        $options = ''; 
        for($i=1;$i<=12;$i++) 
        { 
            $value = ($i < 10)?'0'.$i:$i; 
            $selectedOpt = ($value == $selected)?'selected':''; 
            $options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>'; 
        } 
        return $options; 
    } 
    
    /* 
     * Generate years options list for select box 
     */ 
    function getYears($selected = ''){ 
        $yearInit = !empty($selected)?$selected:date("Y"); 
        $yearPrev = ($yearInit - 5); 
        $yearNext = ($yearInit + 5); 
        $options = ''; 
        for($i=$yearPrev;$i<=$yearNext;$i++){ 
            $selectedOpt = ($i == $selected)?'selected':''; 
            $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>'; 
        } 
        return $options; 
    } 
    
    /* 
     * Generate events list in HTML format 
     */ 
    function getEvents($date = '', $return='view'){ 
        $date = $date?$date:date("Y-m-d"); 
         
        // Fetch events based on the specific date 
        $con = array( 
            'where' => array( 
                'date' => $date, 
                'status' => 1 
            ) 
        ); 
        $events = $this->event->getRows($con); 
         
        $eventListHTML = '<h2 class="sidebar__heading">'.date("l", strtotime($date)).'<br>'.date("F d, Y", strtotime($date)).'</h2>'; 
        if(!empty($events)){ 
            $eventListHTML .= '<ul class="sidebar__list">'; 
            $eventListHTML .= '<li class="sidebar__list-item sidebar__list-item--complete">Events</li>'; 
            $i = 0; 
            foreach($events as $row){ $i++; 
                $eventListHTML .= '<li class="sidebar__list-item"><span class="list-item__time">'.$i.'.</span>'.$row['title'].'</li>'; 
            } 
            $eventListHTML .= '</ul>'; 
        } 
         
        if($return == 'return'){ 
            return $eventListHTML; 
        }else{ 
            echo $eventListHTML;     
        } 
    } 
}