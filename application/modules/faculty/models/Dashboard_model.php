<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
	
	public function get_teacher_information()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_id='$teacher_id'
								   ");
		return $query->row_array();
	}
	
	public function get_dahboard_notifications()
	{
		$query = $this->db->query("SELECT * FROM starter_schedule_notification ORDER BY notif_id DESC");
		return $query->result_array();
	}
	
	public function get_sdt_schedule_dates()
	{
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date FROM starter_sdt_schedule WHERE starter_sdt_schedule.endmschedule_status=1");
		return $query->result_array();
	}
	
	public function get_workshop_schedule_dates()
	{
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date FROM starter_workshop_schedule WHERE starter_workshop_schedule.endmschedule_status=1");
		return $query->result_array();
	}
	
	public function get_ece_schedule_dates()
	{
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date FROM starter_ece_exschedule WHERE starter_ece_exschedule.endmschedule_status=1");
		return $query->result_array();
	}

	public function get_lessonsby_file($module_id)
	{
		$query = $this->db->query("SELECT 
								   starter_modules_lessons.*,
								   starter_modules.module_id,
								   starter_modules.module_title,
								   starter_modules.module_phase_id
								   FROM starter_modules_lessons
								   LEFT JOIN starter_modules ON
								   starter_modules.module_id=starter_modules_lessons.lesson_module_id
								   WHERE starter_modules.module_phase_id='$module_id' AND starter_modules_lessons.lesson_attach_file IS NOT NULL 
								   ORDER BY starter_modules_lessons.lesson_position ASC
								   ");
		return $query->result_array();
	}
	public function rtc_details($id)
	{
		$this -> db -> select('t1.*,t2.batch_name, t2.batch_sessions');
		$this -> db -> join('starter_batch t2', 't2.batch_id = t1.batch_id', 'LEFT');
		$this -> db -> from('starter_batch_teacher t1');
		$this -> db -> where('t1.teacher_id', $id);
		$this -> db -> where('t2.status', 1);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_teacher_batch($id) { /*get teacher list*/
        $query = $this->db->query("SELECT starter_batch.batch FROM `starter_batch_teacher` left join starter_batch on starter_batch.batch_id = starter_batch_teacher.batch_id where teacher_id = $id;");
		
		return $query->first_row();
    }
	
	public function get_teacher_phase($batch) { /*get teacher list*/
        $query = $this->db->query("SELECT * FROM `starter_students`
			where student_batch = '$batch'");
		
		return $query->first_row();
    }

	public function get_students($id)
	{
		$this -> db -> select('t1.*, t2.spinfo_first_name, t2.spinfo_middle_name, t2.spinfo_last_name, t2.spinfo_personal_phone');
		$this -> db -> join('starter_students_personalinfo t2', 't2.spinfo_student_id = t1.student_id', 'LEFT');
		$this -> db -> from('starter_students t1');
		$this -> db -> where('t1.student_rtc', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_readedlesson($id)
	{
		$this -> db -> select('t1.lessread_id');
		$this -> db -> from('starter_lesson_reading_completed t1');
		$this -> db -> where('t1.lessread_user_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_phase1readedlesson($id)
	{
		$this -> db -> select('t1.lessread_id');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lessread_module_id', 'LEFT');
		$this -> db -> from('starter_lesson_reading_completed t1');
		$this -> db -> where('t1.lessread_user_id', $id);
		$this -> db -> where('t2.module_phase_id', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_phase1mdlopn($id, $mdl)
	{
		$this -> db -> select('t1.lessread_id');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lessread_module_id', 'LEFT');
		$this -> db -> from('starter_lesson_reading_completed t1');
		$this -> db -> where('t1.lessread_user_id', $id);
		$this -> db -> where('t2.module_phase_id', $mdl);
		$this -> db -> group_by('t1.lessread_module_id');
		$query = $this->db->get();
		/*$query = $this->db->get();*/			
		/*if ($query->num_rows() > 0) {
        	return $query->result();
		}
		return 0;*/
		if($query == 1) {
               $results = $query->result();
               return  $results;
            }
            else{
                 return false;
            }
		/*return $query->result();*/
	}

	public function get_totalmodul($id)
	{
		$this -> db -> select('module_id,module_name');
		$this -> db -> from('starter_modules');
		$this -> db -> where('module_phase_id', $id);
		$this -> db -> order_by('module_name', 'ASC');		
		$query = $this->db->get();
		return $query->result();
	}

	public function get_totallesson($phid,$mdl)
	{
		$this -> db -> select('t1.lesson_id');
		$this -> db -> from('starter_modules_lessons t1');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lesson_module_id', 'LEFT');
		$this -> db -> where('t1.lesson_module_id', $mdl);
		$this -> db -> where('t2.module_phase_id', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_readedlessonbymodule($id,$phid,$mdl)
	{
		$this -> db -> select('t1.lessread_id');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lessread_module_id', 'LEFT');
		$this -> db -> from('starter_lesson_reading_completed t1');
		$this -> db -> where('t1.lessread_user_id', $id);
		$this -> db -> where('t1.lessread_module_id', $mdl);
		$this -> db -> where('t2.module_phase_id', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_lessonexam($phid,$stid)
	{
		$this -> db -> select('t1.examcnt_id');
		$this -> db -> from('starter_practiceexam_counter t1');
		$this -> db -> where('t1.examcnt_student_id', $stid);
		$this -> db -> where('t1.examcnt_phase_level', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_pcaexam($phid,$stid)
	{
		$this -> db -> select('t1.*');
		$this -> db -> from('starter_module_progress t1');
		$this -> db -> where('t1.cmreport_student_id', $stid);
		$this -> db -> where('t1.cmreport_phase_id', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function check_step($student_id)
	{
		/*$student_id = $this->session->userdata('active_student');*/
		$query = $this->db->query("SELECT student_phaselevel_id, student_active_module FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
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

	public function get_modulesby_phase($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_modules WHERE starter_modules.module_phase_id='$phase_id' ORDER BY starter_modules.module_id ASC");
		return $query->result_array();
	}
	public function check_lesson_has_read($module_id, $lesson_id, $user_id)
	{
		$query = $this->db->query("SELECT lessread_id FROM starter_lesson_reading_completed 
								   WHERE starter_lesson_reading_completed.lessread_module_id='$module_id'
								   AND starter_lesson_reading_completed.lessread_lesson_id='$lesson_id'
								   AND starter_lesson_reading_completed.lessread_user_id='$user_id'");
		return $query->row_array();
	}

	public function get_lessonby_id($lesson_id)
	{
		$query = $this->db->query("SELECT * FROM starter_modules_lessons 
								   LEFT JOIN starter_modules ON
								   starter_modules.module_id=starter_modules_lessons.lesson_module_id
								   WHERE starter_modules_lessons.lesson_id='$lesson_id' 
								   LIMIT 1");
		return $query->row_array();
	}

	public function get_students_info($id)
	{
		$this -> db -> select('t1.*, t2.spinfo_first_name, t2.spinfo_middle_name, t2.spinfo_last_name,t2.spinfo_personal_phone');
		$this -> db -> join('starter_students_personalinfo t2', 't2.spinfo_student_id = t1.student_id', 'LEFT');
		$this -> db -> from('starter_students t1');
		$this -> db -> where('t1.student_id', $id);
		$query = $this->db->get();
		return $query->first_row();
	}


	
}