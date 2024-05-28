<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_model extends CI_Model {
	
	public function get_all_evaluation($user_type)
	{
		$query = $this->db->query("SELECT * FROM starter_user_evaluations WHERE starter_user_evaluations.evaluation_user_type='$user_type' ORDER BY starter_user_evaluations.evaluation_id DESC");
		return $query->result_array();
	}
	
	public function get_student_infos($student_id)
	{
		$query = $this->db->query("SELECT 
								  starter_students.student_entryid,
								  starter_students.student_username,
								  starter_students_personalinfo.spinfo_first_name,
								  starter_students_personalinfo.spinfo_middle_name,
								  starter_students_personalinfo.spinfo_last_name,
								  starter_students_personalinfo.spinfo_photo
								  FROM starter_students 
								  LEFT JOIN starter_students_personalinfo ON
								  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								  WHERE starter_students.student_id='$student_id'
								  LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_teacher_infos($teacher_id)
	{
		$query = $this->db->query("SELECT 
								  starter_teachers.teacher_entryid,
								  starter_teachers.teacher_username,
								  starter_teachers_personalinfo.tpinfo_first_name,
								  starter_teachers_personalinfo.tpinfo_middle_name,
								  starter_teachers_personalinfo.tpinfo_last_name,
								  starter_teachers_personalinfo.tpinfo_photo
								  FROM starter_teachers
								  LEFT JOIN starter_teachers_personalinfo ON
								  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								  WHERE starter_teachers.teacher_id='$teacher_id'
								  LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_evaluationby_id($evaluation_id)
	{
		$query = $this->db->query("SELECT * FROM starter_user_evaluations WHERE starter_user_evaluations.evaluation_id='$evaluation_id'");
		return $query->row_array();
	}
	
	public function get_ratingsby_evaluation($evaluation_id)
	{
		$query = $this->db->query("SELECT * FROM starter_evaluation_ratings WHERE starter_evaluation_ratings.rating_evaluation_id='$evaluation_id' ORDER BY starter_evaluation_ratings.rating_id ASC");
		return $query->result_array();
	}
	
	public function count_evaluations_by_studentid()
	{
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_students");
		return $query->num_rows();
	}
	
	public function get_evaluations_by_studentid($params=array())
	{
		if(!empty($params['limit']))
		{
			$limit = $params['limit'];
		}else
		{
			$limit = 10;
		}
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_students.evaluation_by
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_students.evaluation_by
								   ORDER BY evaluation_id ASC LIMIT $limit");
		return $query->result_array();
	}
	
	public function count_evaluations_by_faculties()
	{
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_faculties");
		return $query->num_rows();
	}
	
	public function get_evaluations_by_faculties($params=array())
	{
		if(!empty($params['limit']))
		{
			$limit = $params['limit'];
		}else
		{
			$limit = 10;
		}
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_faculties 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_faculties.evaluation_by
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_faculties.evaluation_by
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id 
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id
								   ORDER BY evaluation_id ASC LIMIT $limit");
		return $query->result_array();
	}
	
	public function get_evaluations_by_facultiesrtc($rtc)
	{
		/*if(!empty($params['limit']))
		{
			$limit = $params['limit'];
		}else
		{
			$limit = 10;
		}*/
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_faculties 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_faculties.evaluation_by
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_faculties.evaluation_by
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id 
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id
								   WHERE starter_students.student_rtc = '$rtc' 
								   ORDER BY evaluation_id DESC LIMIT 10");
		return $query->result_array();
	}
	
	public function get_faculty_evaluations_by_id($evl_id)
	{
		$query = $this->db->query("SELECT starter_evaluations_by_faculties.*, starter_students_personalinfo.spinfo_first_name, starter_students_personalinfo.spinfo_middle_name, starter_students_personalinfo.spinfo_last_name, starter_students.student_entryid, starter_students.student_finalid FROM starter_evaluations_by_faculties 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id
								   WHERE evaluation_id='$evl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_faculties_ratingsby_evaluationid($evaluation_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students_evaluation_ratings
								   LEFT JOIN starter_faculties_evaluations ON
								   starter_faculties_evaluations.eval_id=starter_students_evaluation_ratings.rating_eval_id
								   WHERE rating_evaluation_id='$evaluation_id'
								   ORDER BY rating_id ASC");
		return $query->result_array();
	}
	
	public function get_evaluations_by_id($evl_id)
	{
		$query = $this->db->query("SELECT starter_evaluations_by_students.*, starter_teachers_personalinfo.tpinfo_first_name, starter_teachers_personalinfo.tpinfo_middle_name, starter_teachers_personalinfo.tpinfo_last_name FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   WHERE evaluation_id='$evl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_ratingsby_evaluationid($evaluation_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_faculties_evaluation_ratings
								   LEFT JOIN starter_evaluations ON
								   starter_evaluations.eval_id=starter_faculties_evaluation_ratings.rating_eval_id
								   WHERE rating_evaluation_id='$evaluation_id'
								   ORDER BY rating_id ASC");
		return $query->result_array();
	}
	
	public function get_sdt_booking_center_faculties($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT booking_user_id, teacher_id, teacher_entryid, tpinfo_first_name, tpinfo_middle_name, tpinfo_last_name, programme_status 
								   FROM starter_sdt_booking
								   
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_sdt_booking.booking_user_id
								   
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_sdt_booking.booking_user_id
								   
								   LEFT JOIN starter_sdt_programme ON
								   starter_sdt_programme.programme_bookingid=starter_sdt_booking.booking_id
								   
								   WHERE booking_schedule_centerid='$booking_schedule_centerid'
								   AND booking_user_type='Faculty'
								   AND programme_status='1'");
		return $query->result_array();
	}
	
	public function get_workshop_booking_center_faculties($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT booking_user_id, teacher_id, teacher_entryid, tpinfo_first_name, tpinfo_middle_name, tpinfo_last_name, programme_status
								   FROM starter_workshop_booking
								   
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_workshop_booking.booking_user_id
								   
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_workshop_booking.booking_user_id
								   
								   LEFT JOIN starter_workshop_programme ON
								   starter_workshop_programme.programme_bookingid=starter_workshop_booking.booking_id
								   
								   WHERE booking_schedule_centerid='$booking_schedule_centerid'
								   AND booking_user_type='Faculty'
								   AND programme_status='1'");
		return $query->result_array();
	}
	
	public function get_student_eval_info($session_type, $faculty_id, $student_id, $c_schedule_id)
	{
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_students
								   WHERE evaluation_session_type='$session_type'
								   AND evaluation_session_cntrschedle_id='$c_schedule_id'
								   AND evaluation_faculty_id='$faculty_id'
								   AND evaluation_by='$student_id'");
		return $query->row_array();
	}
	
	public function get_betch()
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('status', 1);
		$this -> db -> order_by('batch_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	 public function get_betch_dtl($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('batch_id', $id);
		$query = $this->db->get();
		return $query->first_row();
	}

	public function get_evaluations_by_rtc($rtc)
	{
		$limit = 10;
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_students.evaluation_by
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_students.evaluation_by
								   WHERE starter_students.student_rtc = '$rtc'
								   ORDER BY evaluation_id DESC LIMIT $limit");
		return $query->result_array();
	}

	public function count_evaluations_by_rtc($rtc)
	{
		
		$query = $this->db->query("SELECT starter_evaluations_by_students.evaluation_id 
								   FROM starter_evaluations_by_students 
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_students.evaluation_by
								   WHERE starter_students.student_rtc = '$rtc'");
		return $query->num_rows();
	}
	
	public function get_evaluations_by_rtc_csv($rtc)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_students.evaluation_by
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_students.evaluation_by
								   WHERE starter_students.student_rtc = '$rtc'
								   ORDER BY evaluation_id DESC");
		return $query->result_array();
	}

	public function get_ratingsby_evaluationid_csv($evaluation_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_faculties_evaluation_ratings
								   WHERE rating_evaluation_id='$evaluation_id'
								   ORDER BY rating_id ASC");
		return $query->result_array();
	}
	
	public function get_ratingsby_heading()
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations
								   ORDER BY eval_id ASC");
		return $query->result_array();
	}
	
}
