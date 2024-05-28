<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	private $perPage;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->load->library('ajax_pagination');
		$this->load->model('Dashboard_model');
		$this->load->model('event');
	}
	
	public function index()
	{
		$prefs = array(
				'start_day'      => 'sunday',
				'month_type'     => 'long',
				'day_type'       => 'short',
				'show_next_prev' => TRUE,
				'next_prev_url'  => base_url('student/dashboard/index'),
		);
		$prefs['template'] = '
								{table_open}<table border="1" cellpadding="5" cellspacing="0">{/table_open}

								{heading_row_start}<tr>{/heading_row_start}

								{heading_previous_cell}<th><a href="{previous_url}"><i class="ion-ios-arrow-back"></i></a></th>{/heading_previous_cell}
								{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
								{heading_next_cell}<th><a href="{next_url}"><i class="ion-ios-arrow-forward"></i></a></th>{/heading_next_cell}

								{heading_row_end}</tr>{/heading_row_end}

								{week_row_start}<tr>{/week_row_start}
								{week_day_cell}<td>{week_day}</td>{/week_day_cell}
								{week_row_end}</tr>{/week_row_end}

								{cal_row_start}<tr>{/cal_row_start}
								{cal_cell_start}<td class="day"><span>{/cal_cell_start}
								{cal_cell_start_today}<td class="today"><span>{/cal_cell_start_today}
								{cal_cell_start_other}<td class="other-month"><span>{/cal_cell_start_other}

								{cal_cell_content}{content}{day}</span>{/cal_cell_content}
								{cal_cell_content_today}<span class="highlight">{day}</span>{/cal_cell_content_today}

								{cal_cell_no_content}<span>{day}</span>{/cal_cell_no_content}
								{cal_cell_no_content_today}<span class="highlight">{day}</span>{/cal_cell_no_content_today}

								{cal_cell_blank}<span>&nbsp;</span>{/cal_cell_blank}

								{cal_cell_other}<span>{day}</span>{/cal_cel_other}

								{cal_cell_end}</span></td>{/cal_cell_end}
								{cal_cell_end_today}</span></td>{/cal_cell_end_today}
								{cal_cell_end_other}</span></td>{/cal_cell_end_other}
								{cal_row_end}</tr>{/cal_row_end}

								{table_close}</table>{/table_close}
						';
		$this->load->library('calendar', $prefs);
		/*$this->load->view('dashboard_temp');*/
		$data = array(); 
        $data['eventCalendar'] = $this->eventCalendar();
		$this->load->view('dashboard', $data);
	}
	
	
	public function pb_result()
	{
		
		$this->perPage = 6;
		$id = $this->session->userdata('active_student');
		$student = $this->Dashboard_model->get_student_information();
		
		$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $student['student_active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
		
		$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $student['student_active_module']));
		$data['id'] = $id;
		$data['student'] = $student;
		$this->load->view('practice_base_result',$data);
	}
	
	public function module()
	{
		$phase = $this->input->post('phase');
		$content = null;
		$get_modules = $this->Dashboard_model->get_modulesby_phase($phase);
		$student = $this->Dashboard_model->get_student_information();
		$module_x = 1;
		foreach($get_modules as $module){
			$has_completed = completed_module($module['module_id']);
			if($has_completed == true)
			{
				$progress_class = 'completed';
			}elseif($has_completed == false && $student['student_active_module'] == $module['module_id'])
			{
				$progress_class = 'active';
			}else
			{
				$progress_class = null;
			}
			if(count($get_modules) > 3){
				$class = 'col-lg-3';
			}else{
				$class = 'col-lg-3';
			}
			$content .= '<div class="'.$class.'">';
			$content .= '<input type="hidden" id="activeModule" value="'.$student['student_active_module'].'"/>';
			$content .= ' <div style="cursor:pointer;" class="module-number-stp '.$progress_class.'" data = "'.$module['module_id'].'">'.$module['module_name'];
			$content .= '</div></div>';
			
			$module_x++;
		}
		
		$result = array('status' => 'ok', 'content' => $content);
		
		echo json_encode($result);
		exit;
	}
	
	public function lesson()
	{
		$module = $this->input->post('module');
		$this->perPage = 6;
		
		
		$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $module)));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
		$items = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $module));
		$data['items'] = $items;
		$content = $this->load->view('lesson_picker', $data, true);
		
		$result = array('status' => 'ok', 'content' => $content , 'module' => $module);
		
		echo json_encode($result);
		exit;
	}
	
	public function pexam()
	{
		$id = $this->session->userdata('active_student');
		$lesson = $this->input->post('lesson');
		$content = null;
		$items = $this->Dashboard_model->getLessonExam($id,$lesson);
		$get_marksconfig = $this->Dashboard_model->get_marksconfig();
		
		if(count($items) !== 0){
			foreach ($items as $elist) {
				$total_right_answers = $this->Dashboard_model->get_lesson_right_answers($elist->examcnt_id);
													$total_wrong_answers = $this->Dashboard_model->get_lesson_wrong_answers($elist->examcnt_id);
															
													$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
													$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
													if($total_score >= $total_passing_score){
														$content .= '<p>Congratulations! You have passed in your practice examination.</p>';
													}
				$content .= '<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="heading90">
								 <h4 class="panel-title">';
									$content .= '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$elist->examcnt_id.'" aria-expanded="true" aria-controls="collapse'.$elist->examcnt_id.'" style="display: block; color: #000000">
													<i class="more-less glyphicon glyphicon-plus"></i>'.$elist->examcnt_date;
									$content .= ' </a>';
									$content .= '    </h4>
				                 </div>';
								 
								 
						$content .= '<div id="collapse'.$elist->examcnt_id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$elist->examcnt_id.'>
				                            <div class="panel-body" style = "padding: 1rem;" >
				                                  <div class="result-ar-box" style = "    border: 5px solid #03a9f4;    padding: 20px;">
													<h2 style = "font-size: 21px;font-weight: bold;text-align: center;">Practice Examination Result</h2>';
													
													$total_right_answers = $this->Dashboard_model->get_lesson_right_answers($elist->examcnt_id);
													$total_wrong_answers = $this->Dashboard_model->get_lesson_wrong_answers($elist->examcnt_id);
															
													$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
													$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
													if($total_score >= $total_passing_score){
														$content .= '<p>Congratulations! You have passed in your practice examination.</p>';
													}
										$content .= '<div class="details-ofright" style = "    border-top: 3px solid #0a0;margin-top: 10px; padding: 10px 0px">';
											$content .= '<p><strong>Total Questions :'.$get_marksconfig['mrkconfig_practice_exam_totalquestion'].'</strong></p>';
											$content .= '<p><strong>Total Right Answer :'.$total_right_answers.'</strong></p>';
											$content .= '<p><strong>Total Wrong Answer :'.$total_wrong_answers.'</strong></p>';
										$content .= '</div>';
										
										$wrong_answers = $this->Dashboard_model->get_wrong_answer($elist->examcnt_id);
														if(count($wrong_answers) !== 0){
														$w_sl = 1;
														
															foreach($wrong_answers as $answer){
																if($answer['question_type'] == 'JUSTIFY')
																	{
																		
																		$right_answer = $answer['question_justify_answer'];
																		
																	}elseif($answer['question_type'] == 'MCQ'){
															
																		$right_ans_ids = $this->Dashboard_model->get_right_answersids($answer['question_id']);
																		$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
																		$right_answer_string = str_replace(']', '', $right_answer_string);
																		$right_answer_string = explode(',', $right_answer_string);
																		$answer_array = $right_answer_string;
																		$r_answer = '';
																		foreach($answer_array as $answer_id)
																		{
																			$get_answer_title = $this->Dashboard_model->get_answer_titleby_id($answer_id);
																			$r_answer .= $get_answer_title['answer_title'].', ';
																			
																		}
																		$right_answer = $r_answer;
																	}elseif($answer['question_type'] == 'BLANK'){
																		$right_ans_ids = $this->Dashboard_model->get_right_answersids($answer['question_id']);
																		$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
																		$right_answer_string = str_replace(']', '', $right_answer_string);
																		$right_answer_string = explode(',', $right_answer_string);
																		$answer_array = $right_answer_string;
																		$r_answer = '';
																		foreach($answer_array as $answer_id)
																		{
																			$get_answer_title = $this->Dashboard_model->get_answer_titleby_id($answer_id);
																			$r_answer .= $get_answer_title['answer_title'].', ';
																			
																		}
																		$right_answer = $r_answer;
																	}elseif($answer['question_type'] == 'MULTIPLE_JUSTIFY'){
																		$right_ans_ids = $this->Dashboard_model->get_right_answersids($answer['question_id']);
																		$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
																		$r_answer = '';
																		foreach($answer_array as $answer_id => $jusitfy_answer)
																		{
																			$get_answer_title = $this->Dashboard_model->get_answer_titleby_id($answer_id);
																			if($jusitfy_answer == '1')
																			{
																				$ans_justify = '<span style="color:#0A0">TRUE</span>';
																			}elseif($jusitfy_answer == '0')
																			{
																				$ans_justify = '<span style="color:#F00">FALSE</span>';
																			}else
																			{
																				$ans_justify = '';
																			}
																			$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong>';
																		}
																		$right_answer = $r_answer;
																	}
																	
																	$content .= '<div class="details-ofright" style = "    border-top: 3px solid #0a0;margin-top: 10px; padding: 10px 0px">
																					<div class="single-question">
																						<strong class="question-li"><span style="color:#f00">'.$w_sl.'.'.$answer['question_title'].'</strong> <br />';
																	$content .= 		'<p class="text-left" style="padding-left: 15px;font-size: 13px;"><strong style="color:#F00">Right Answer : </strong>'.$right_answer.'</p>';
																	$content .= 	'</div>
																				</div>';
															}
														}
														
														if($total_score < $total_passing_score)
															{
																$result_shw = '<span class="result-shw-failed">Failed</span>';
															}else
															{
																$result_shw = '<span class="result-shw-pass">Passed</span>';
															}
															$content .= '<div class="details-ofresult">
																			<p><strong>Your Score :'.$total_score.'</strong></p>';
																$content .= '<p><strong>Passing Score :'.$total_passing_score.'</strong></p>';
																$content .= '<p><strong>Result :'.$result_shw.'</strong></p>
																		</div>';
													
						$content .= '       </div>
								     </div>';
													
				$content .= '</div>';
			}
			$result = array('status' => 'ok', 'content' => $content);
		}else{
			$content = '<h2 style = "font-size: 21px;font-weight: bold;text-align: center;">No Exam Result Found</h2>';
			$result = array('status' => 'No Result', 'content' => $content);
		}
		
		
		echo json_encode($result);
		exit;
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
        /* $data['events'] = $this->event->getGroupCount($con); */
		$stdata = $this->event->st_info();
        if ($stdata->student_rtc == 125) {
                $data['events'] = $this->event->getGroupCount32($con);
             }else{
                
                $data['events'] = $this->event->getGroupCount($con);
             }
         
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
        /* $events = $this->event->getRows($con);  */
        $stdata = $this->event->st_info();
        if ($stdata->student_rtc == 125) {
                $events = $this->event->getRows2($con);                
             }else{
                
                $events = $this->event->getRows($con);
             }
        $eventListHTML = '<h2 class="sidebar__heading">'.date("l", strtotime($date)).'<br>'.date("F d, Y", strtotime($date)).'</h2>'; 
        if(!empty($events)){ 
            $eventListHTML .= '<ul class="sidebar__list">'; 
            $eventListHTML .= '<li class="sidebar__list-item sidebar__list-item--complete">Events</li>'; 
            $i = 0; 
            foreach($events as $row){ $i++; 
                $eventListHTML .= '<li class="sidebar__list-item"><span class="list-item__time">'.$i.'.</span>'.$row['title'].' - <span class="sidebar__list-item sidebar__list-item--complete">'.$row['details'].'</span></li>'; 
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