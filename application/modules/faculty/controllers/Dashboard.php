<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_teacher = $this->session->userdata('active_teacher');
		$teacherLogin = $this->session->userdata('teacherLogin');
		if($active_teacher === NULL && $teacherLogin !== TRUE)
		{
			redirect('faculty/login', 'refresh', true);
		}
		
		$this->load->library('ajax_pagination');
		$this->load->model('Dashboard_model');
		$this->load->model('event');
		$this->load->model('Lesson_model');
		$this->load->model('Examquestion_model');
		$this->load->helper('download');
		$this->load->library('t_cpdf');
	}
	
	public function index()
	{
		$prefs = array(
				'start_day'      => 'sunday',
				'month_type'     => 'long',
				'day_type'       => 'short',
				'show_next_prev' => TRUE,
				'next_prev_url'  => base_url('faculty/dashboard/index'),
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
		$fid = $this->session->userdata('active_teacher');
		$data['getrtc'] = $this->Dashboard_model->rtc_details($fid);
		$data['batch'] = $this->Dashboard_model->get_teacher_batch($fid);
		
		/* if(empty($data['getrtc'])){
			$rtcid = 0;
		}else{
			$rtcid = $data['getrtc']->batch_id;
		}
		$data['getstdnts'] = $this->Dashboard_model->get_students($rtcid); */
		/*print_r($data['getrtc']);exit;*/
		$this->load->library('calendar', $prefs);
        $data['eventCalendar'] = $this->eventCalendar();
		$this->load->view('new_dashboard',$data);
	}

	function lessons_download($id)
	 {
	 	ini_set('memory_limit', '-1');
	  $fldrname = 'Phase_'.$id;
	  $certificate = $this->Dashboard_model->get_lessonsby_file($id);
	   $this->load->library('zip');
	   foreach($certificate as $image)
	   {
	   	$imgurl = 'attachments/lessons/'.$image['lesson_attach_file'];
	    $this->zip->read_file($imgurl);
	   }
	   $this->zip->download(''.$fldrname.'.zip');
	  
	 }
	 
	public function student_details()
	{
		$student_id = $this->input->post('student_id');
		$data['studentid'] = $this->input->post('student_id');
		$data['mdlread'] = $this->Dashboard_model->get_phase1mdlopn($student_id, 1);
		$data['ttlph1mdl'] = $this->Dashboard_model->get_totalmodul(1);

		$data['mdlread2'] = $this->Dashboard_model->get_phase1mdlopn($student_id, 2);
		$data['ttlph2mdl'] = $this->Dashboard_model->get_totalmodul(2);

		$data['mdlread3'] = $this->Dashboard_model->get_phase1mdlopn($student_id, 3);
		$data['ttlph3mdl'] = $this->Dashboard_model->get_totalmodul(3);
		$data['stdinfo'] = $this->Dashboard_model->get_students_info($student_id);
		/*print_r($data['item']);exit;*/
		$content = $this->load->view('student_details', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
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
	
	public function sthistry($id){
    	if(isset($_GET['rdr']) && $_GET['rdr'] == 'Course' && isset($_GET['phase']) && $_GET['phase'] == 'PCA-1' && isset($_GET['return']) && $_GET['return'] == 'true'){
    	$data['stid'] = $id;
    	$data['stdinfo'] = $this->Dashboard_model->get_students_info($id);
    	$phase = $this->Dashboard_model->check_step($id);
			
				$data['phase_lavel'] = 1;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $phase['student_active_module'];
				}
				/*$data['active_module'] = $phase['student_active_module'];*/
				
				$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
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
				
				$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				$data['student_id'] = $id;
    	$this->load->view('student_course',$data);
	    }else{
	    	$data['stid'] = $id;
	    	$data['stdinfo'] = $this->Dashboard_model->get_students_info($id);
	    	$phase = $this->Dashboard_model->check_step($id);
				
					$data['phase_lavel'] = 1;
					
					$this->perPage = 6;
					
					$data['active_module'] = $phase['student_active_module'];
					
					$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
					
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
					
					$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
					$data['student_id'] = $id;
	    	$this->load->view('student_course',$data);
	    }
    }

    public function sthistry_b($id){
    	if(isset($_GET['rdr']) && $_GET['rdr'] == 'Course' && isset($_GET['phase']) && $_GET['phase'] == 'PCA-2' && isset($_GET['return']) && $_GET['return'] == 'true'){
    	$data['stid'] = $id;
    	$data['stdinfo'] = $this->Dashboard_model->get_students_info($id);
    	$phase = $this->Dashboard_model->check_step($id);
			
				$data['phase_lavel'] = 2;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $phase['student_active_module'];
				}
				/*$data['active_module'] = $phase['student_active_module'];*/
				
				$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
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
				
				$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				$data['student_id'] = $id;
				
    	$this->load->view('course_phase_b',$data);
	    }else{
	    	$data['stid'] = $id;
	    	$data['stdinfo'] = $this->Dashboard_model->get_students_info($id);
	    	$phase = $this->Dashboard_model->check_step($id);
				
					$data['phase_lavel'] = 2;
					
					$this->perPage = 6;
					
					$data['active_module'] = $phase['student_active_module'];
					
					$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
					
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
					
					$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
					$data['student_id'] = $id;
	    	$this->load->view('course_phase_b',$data);
	    }
    }

    public function sthistry_c($id){
    	if(isset($_GET['rdr']) && $_GET['rdr'] == 'Course' && isset($_GET['phase']) && $_GET['phase'] == 'PCA-3' && isset($_GET['return']) && $_GET['return'] == 'true'){
    	$data['stid'] = $id;
    	$data['stdinfo'] = $this->Dashboard_model->get_students_info($id);
    	$phase = $this->Dashboard_model->check_step($id);
			
				$data['phase_lavel'] = 3;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $phase['student_active_module'];
				}
				/*$data['active_module'] = $phase['student_active_module'];*/
				
				$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
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
				
				$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				$data['student_id'] = $id;
    	$this->load->view('course_phase_c',$data);
	    }else{
	    	$data['stid'] = $id;
	    	$data['stdinfo'] = $this->Dashboard_model->get_students_info($id);
	    	$phase = $this->Dashboard_model->check_step($id);
				
					$data['phase_lavel'] = 3;
					
					$this->perPage = 6;
					
					$data['active_module'] = $phase['student_active_module'];
					
					$totalRec = count($this->Dashboard_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
					
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
					
					$data['items'] = $this->Dashboard_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
					$data['student_id'] = $id;
	    	$this->load->view('course_phase_c',$data);
	    }
    }


    public function get_less_content()
	{
		$lession_id = $this->input->post('lesson');
		$stids = $this->input->post('stid');
		$module_id = $this->input->post('data_module');
		$phase_level = $this->input->post('phase');
		$get_lesson_info = $this->Lesson_model->get_lessonby_id($lession_id);
		/*if($get_lesson_info == true)
		{
			$ins_read = array(
							'lessread_module_id' => $module_id,
							'lessread_lesson_id' => $lession_id,
							'lessread_user_id' => $this->session->userdata('active_student'),
						);
			$this->db->insert('starter_lesson_reading_completed', $ins_read);
		}*/
		
		$has_completed = completed_module($module_id);
		/*if($has_completed == true)
		{
			$active_phase = $this->Lesson_model->get_active_phase($this->session->userdata('active_student'));
			$max_mdl = $this->Lesson_model->get_max_mdl($module_id, $active_phase);
			$this->db->where('student_id', $this->session->userdata('active_student'));
			$this->db->update('starter_students', array('student_active_module' => $max_mdl));
			$sess['active_module'] = $max_mdl;
			$this->session->set_userdata($sess);
			$part_has_completed = 1;
		}elseif($has_completed == false)
		{
			$part_has_completed = 0;
		}else
		{
			$part_has_completed = 0;
		}*/
		if($phase_level == '1'){
			$exm_phase = 'Phase-A';
		}elseif($phase_level == '2'){
			$exm_phase = 'Phase-B';
		}elseif($phase_level == '3'){
			$exm_phase = 'Phase-C';
		}else
		{
			$exm_phase = 'Phase-A';
		}
		
		if($get_lesson_info['lesson_show_practice_button'] == 'YES')
		{
			$has_practice_button = '<div class="lesson-exam-lnk"><a target="_blank" href="'.base_url('faculty/dashboard/examquestion/'.$exm_phase.'/'.$module_id.'/'.$get_lesson_info['lesson_id']).'/'.$stids.'">Practice based study Questions & Answer</a></div>';
			/*$has_practice_button = '<div class="lesson-exam-lnk"><a target="_blank" href="'.base_url('faculty/dashboard/prcstart/End-Lesson/'.$exm_phase.'/START?module='.$module_id.'&lesson='.$get_lesson_info['lesson_id'].'&type=practice').'">Practice based study Questions</a></div>';*/

		}else{
			$has_practice_button = '';
		}
		
		$content = '<div class="cnt-body">
					<div class="lesson-title-header">'.$get_lesson_info['lesson_title'].'</div>
					<div class="lesson-body-content">'.$get_lesson_info['lesson_content'].'</div>
					<div class="lesson-downld-exam-links">
						<!--<div class="lesson-download-lnk downld-btn-ext" data-target="#sendOtp" data-toggle="modal" data-lesson="'.$get_lesson_info['lesson_id'].'"><i class="fa fa-download"></i> Download</div>-->
						'.$has_practice_button.'
					</div>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content, /*'part_has_completed' => $part_has_completed*/);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function sendotp()
	{
		
		$lesson_id = $this->input->post('lesson');
		
		$otp = rand(132949,999999);
		
		//store at session
		$sess['lessotp'] = $otp;
		$sess['active_lesson'] = $lesson_id;
		$this->session->set_userdata($sess);
		/*sendsms($number, $message);*/
		
		$result = array('status' => 'ok', 'lesson' => $lesson_id);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

    public function check_otp()
	{
		$otp = html_escape($this->input->post('otp'));
		$lesson = html_escape($this->input->post('lesson'));
		$otp_number = $this->session->userdata('lessotp');
		$active_lesson = $this->session->userdata('active_lesson');

		$sess['lesson_orogin'] = $active_lesson;
			$this->session->set_userdata($sess);
			
			//check has attached
			$lesson_info = $this->Lesson_model->get_lessonby_id($active_lesson);
			if($lesson_info['lesson_attach_file'])
			{
				$attach = 'Yes';
			}else
			{
				$attach = 'No';
			}
			
			$result = array('status' => 'ok', 'attach' => $attach);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		
		
	}
	
	public function create_pdf()
	{
		$lesson_id = $this->session->userdata('lesson_orogin');
		$get_lesson_info = $this->Dashboard_model->get_lessonby_id($lesson_id);
		
		//inclusions
		$module_name = str_replace(' ', '_', $get_lesson_info['module_name']);
		
		
        $data['lesson_info'] = $get_lesson_info;
        $html = $this->load->view('lesson_to_pdf', $data, true); 
        $pdfFilePath = $module_name.'_lesson_'.$get_lesson_info['lesson_position'].'_'.date("d-m-Y-H:i:s").'.pdf';
        $pdf = $this->t_cpdf->load();
		
		// set margins
		$pdf->SetMargins(10, 10, 10);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		
        $pdf->AddPage();        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}
	
	public function download()
	{
		$lesson_id = $this->session->userdata('lesson_orogin');
		$lesson_info = $this->Dashboard_model->get_lessonby_id($lesson_id);
		$module_name = str_replace(' ', '_', $lesson_info['module_name']);
		$file_name = $module_name.'_lesson_'.$lesson_info['lesson_position'].date("d-m-Y-H:i:s").'.pdf';
		$file_content = file_get_contents('attachments/lessons/'.$lesson_info['lesson_attach_file']);
		force_download($file_name, $file_content, NULL);
	}

	public function examquestion($pid,$mid,$lid,$stid){
		if ($pid === 'Phase-A') {
			$content_data['phase_level'] = 1;
		}elseif ($pid === 'Phase-B') {
			$content_data['phase_level'] = 2;
		}elseif ($pid === 'Phase-C') {
			$content_data['phase_level'] = 3;
		}
		$content_data['module_id'] = $mid;
		$content_data['lesson_id'] = $lid;
		$get_marksconfig = $this->Examquestion_model->get_marksconfig();
		$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_practice_question_type'], true);
		$content_data['limit'] = $get_marksconfig['mrkconfig_practice_exam_totalquestion'];
		$content_data['exam_time'] = $get_marksconfig['mrkconfig_practice_exam_time'];
		$content_data['stexam'] = $this->Examquestion_model->getExam($stid, $lid);

		$content_data['get_marksconfig'] = $get_marksconfig;
		$this->load->view('practice_exam_new',$content_data);
	}
	
	
	
}