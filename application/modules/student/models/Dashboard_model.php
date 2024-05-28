<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
	
	public function get_student_information()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_students.student_phaselevel_id
								   WHERE starter_students.student_id='$student_id'
								   ");
		return $query->row_array();
	}
	
	public function get_modulesby_phase($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_modules WHERE starter_modules.module_phase_id='$phase_id' ORDER BY starter_modules.module_id ASC");
		return $query->result_array();
	}
	
	public function get_lessonsby_module($params=array())
	{
		$module_id = $params['module_id'];
		$query = "SELECT * FROM starter_modules_lessons 
				  WHERE starter_modules_lessons.lesson_module_id='$module_id' 
				  ORDER BY starter_modules_lessons.lesson_position ASC ";
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function get_wrong_answer($exam_id)
	{
		$query = $this->db->query("SELECT * FROM starter_practice_exmanswer 
							       LEFT JOIN starter_exam_questions ON
								   starter_exam_questions.question_id=starter_practice_exmanswer.answer_question_id 
								   WHERE answer_exam_id='$exam_id' AND answer_status='0' ORDER BY answer_id ASC");
		return $query->result_array();
	}
	
	public function get_right_answersids($question_id)
	{
		$query = $this->db->query("SELECT question_right_answerid FROM starter_exam_questions WHERE starter_exam_questions.question_id='$question_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_answer_titleby_id($answer_id)
	{
		$query = $this->db->query("SELECT answer_title FROM starter_questions_answers WHERE answer_id='$answer_id'");
		return $query->row_array();
	}
	
	public function getLessonExam($stid, $lid){
		$this -> db -> select('*');
		$this -> db -> from('starter_practiceexam_counter');
		$this -> db -> where('examcnt_student_id', $stid);
		$this -> db -> where('examcnt_lesson_id', $lid);
		$this -> db -> order_by('examcnt_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_lesson_right_answers($practice_exam_id)
	{
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_practice_exmanswer
								   WHERE starter_practice_exmanswer.answer_exam_id='$practice_exam_id'
								   AND starter_practice_exmanswer.answer_status=1
								  ");
		$result = $query->num_rows();
		return $result;
	}
	
	public function get_lesson_wrong_answers($practice_exam_id)
	{
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_practice_exmanswer
								   WHERE starter_practice_exmanswer.answer_exam_id='$practice_exam_id'
								   AND starter_practice_exmanswer.answer_status=0
								  ");
		$result = $query->num_rows();
		return $result;
	}
	
	public function get_marksconfig()
	{
		$query = $this->db->query("SELECT * FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_lesson_has_read($module_id, $lesson_id, $user_id)
	{
		$query = $this->db->query("SELECT lessread_id FROM starter_lesson_reading_completed 
								   WHERE starter_lesson_reading_completed.lessread_module_id='$module_id'
								   AND starter_lesson_reading_completed.lessread_lesson_id='$lesson_id'
								   AND starter_lesson_reading_completed.lessread_user_id='$user_id'");
		return $query->row_array();
	}
	
	public function get_dahboard_notifications()
	{
		$student_id = $this->session->userdata('active_student');
		$get_student = $this->db->query("SELECT student_phaselevel_id, student_ece_status, student_regdate FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$std_result = $get_student->row_array();
		
		$regdate = date("Y-m-d", strtotime($std_result['student_regdate']));
		
		$phase_id = $std_result['student_phaselevel_id'];
		$ece_status = $std_result['student_ece_status'];
		if($phase_id !== '0' && $ece_status == '0')
		{
			$query = $this->db->query("SELECT * FROM starter_schedule_notification WHERE starter_schedule_notification.notif_phase_level='$phase_id' AND notif_create_date >= '$regdate' ORDER BY notif_id DESC");
		}elseif($phase_id == '0' && $ece_status == '1'){
			$query = $this->db->query("SELECT * FROM starter_schedule_notification WHERE starter_schedule_notification.notif_ece_students='$ece_status' AND notif_create_date >= '$regdate' ORDER BY notif_id DESC");
		}
		
		return $query->result_array();
	}
	
	public function get_sdt_schedule_dates()
	{
		$active_phase = $this->session->userdata('active_phase');
		$reg_date = $this->session->userdata('student_reg_date');
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date 
								   FROM starter_sdt_schedule 
								   WHERE starter_sdt_schedule.endmschedule_status=1 
								   AND starter_sdt_schedule.endmschedule_phase_id='$active_phase'
								   AND endmschedule_create_date >= '$reg_date'
								   ");
		return $query->result_array();
	}
	
	public function get_workshop_schedule_dates()
	{
		$active_phase = $this->session->userdata('active_phase');
		$reg_date = $this->session->userdata('student_reg_date');
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date 
								   FROM starter_workshop_schedule 
								   WHERE starter_workshop_schedule.endmschedule_status=1 
								   AND starter_workshop_schedule.endmschedule_phase_id='$active_phase'
								   AND endmschedule_create_date >= '$reg_date'
								   ");
		return $query->result_array();
	}
	
	public function get_ece_schedule_dates()
	{
		$active_phase = $this->session->userdata('active_phase');
		$reg_date = $this->session->userdata('student_reg_date');
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date 
								   FROM starter_ece_exschedule 
								   WHERE starter_ece_exschedule.endmschedule_status=1 
								   AND starter_ece_exschedule.endmschedule_phase_id=''
								   AND endmschedule_create_date >= '$reg_date'
								   ");
		return $query->result_array();
	}
	
	public function get_pcastid()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM sht_student 
								   WHERE sht_student.st_code='$student_id'
								");
		return $query->first_row();
	}

	public function getExamReport($id) {
        $this -> db -> select('*');
		$this -> db -> from('sht_student_exam t1');
		$this -> db -> where('t1.student_id', $id);
		$this -> db -> order_by('t1.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
    } // End of function
	
	public function get_zoomlink($rtc) { /*get zoom list*/
    	$cdate = date("Y-m-d");
        $this -> db -> select('*');
		$this -> db -> from('starter_zoom_link');
		$this -> db -> where('zoom_rtl', $rtc);
		$this -> db -> where('DATE(zoom_date) >=', $cdate);
		$this -> db -> where('status', 1);
		$this -> db -> order_by('zoom_date', 'ASC');
		$query = $this->db->get();
		return $query->result();
    } // End of function
	
	public function get_carryzoomlink() { /*get carry zoom list*/
    	$cdate = date("Y-m-d");
        $this -> db -> select('*');
		$this -> db -> from('starter_zoom_link');
		$this -> db -> where('class_type', 1);
		$this -> db -> where('DATE(zoom_date) >=', $cdate);
		$this -> db -> where('status', 1);
		$this -> db -> order_by('zoom_date', 'ASC');
		$query = $this->db->get();
		return $query->result();
    } // End of function
	
}