<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_model extends CI_Model {
	
	public function count_total_sdt_sessions($params = array()){
		$sdt_type = $params['search']['sdt_type'];
		$query = "SELECT booking_id, endmschedule_sdt_type FROM starter_sdt_booking
				  
				  LEFT JOIN starter_sdt_schedule ON
				  starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
				  
				  WHERE booking_user_type='Student' AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND booking_date>='$from_date' AND booking_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (booking_application_id LIKE '%$search_term%') ";
        }
		
		$result = $this->db->query($query);
		return $result->num_rows();
        
    }
	
	public function get_total_sdt_sessions($params = array()){
		$sdt_type = $params['search']['sdt_type'];
		
		$query = "SELECT * FROM starter_sdt_booking 
								   
				   LEFT JOIN starter_sdt_centerschdl ON
				   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
				   
				   LEFT JOIN starter_sdt_schedule ON
				   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
				   
				   LEFT JOIN starter_centers ON
				   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
				   
				   LEFT JOIN starter_students ON
				   starter_students.student_id=starter_sdt_booking.booking_user_id
				   
				   WHERE booking_user_type='Student' AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND booking_date>='$from_date' AND booking_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (booking_application_id LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY booking_id $sortby ";
		}else
		{
			$query .= "ORDER BY booking_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	public function count_total_workshop_sessions($params = array()){
		
		$query = "SELECT booking_id FROM starter_workshop_booking WHERE booking_user_type='Student' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND booking_date>='$from_date' AND booking_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (booking_application_id LIKE '%$search_term%') ";
        }
		
		$result = $this->db->query($query);
		return $result->num_rows();
        
    }
	
	public function get_total_workshop_sessions($params = array()){
		
		$query = "SELECT * FROM starter_workshop_booking 
								   
				   LEFT JOIN starter_workshop_centerschdl ON
				   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
				   
				   LEFT JOIN starter_workshop_schedule ON
				   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
				   
				   LEFT JOIN starter_centers ON
				   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
				   
				   LEFT JOIN starter_students ON
				   starter_students.student_id=starter_workshop_booking.booking_user_id
				   
				   WHERE booking_user_type='Student' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND booking_date>='$from_date' AND booking_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND booking_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (booking_application_id LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY booking_id $sortby ";
		}else
		{
			$query .= "ORDER BY booking_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	public function get_student_personal_info($student_id)
	{
		$query = $this->db->query("SELECT spinfo_first_name, spinfo_middle_name, spinfo_last_name FROM starter_students_personalinfo WHERE spinfo_student_id='$student_id'");
		return $query->row_array();
	}
	
	public function get_teacher_personal_info($faculty_id)
	{
		$query = $this->db->query("SELECT tpinfo_first_name, tpinfo_middle_name, tpinfo_last_name FROM starter_teachers_personalinfo WHERE tpinfo_teacher_id='$faculty_id'");
		return $query->row_array();
	}
	
	public function get_faculty_eval_info($session_type, $faculty_id, $student_id, $c_schedule_id)
	{
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_faculties
								   WHERE evaluation_session_type='$session_type'
								   AND evaluation_session_cntrschedle_id='$c_schedule_id'
								   AND evaluation_student_id='$student_id'
								   AND evaluation_by='$faculty_id'");
		return $query->row_array();
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
	
	public function get_faculty_id($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT teacher_id FROM starter_sdt_booking
									
									LEFT JOIN starter_teachers ON
									starter_teachers.teacher_id=starter_sdt_booking.booking_user_id
									
								  WHERE booking_schedule_centerid='$booking_schedule_centerid'
								  AND booking_user_type='Faculty'
								  AND booking_status='1'");
		$result = $query->row_array();
		if($result['teacher_id'])
		{
			return $result['teacher_id'];
		}else{
			return null;
		}
	}
	
	public function get_sdt_score($student_id, $booking_id)
	{
		$query = $this->db->query("SELECT scrboard_score, scrboard_total_score FROM starter_sdt_scoreboard 
								   WHERE scrboard_booking_id='$booking_id'
								   AND scrboard_student_id='$student_id'");
		return $query->row_array();
	}
	
	public function get_workshop_score($student_id, $booking_id)
	{
		$query = $this->db->query("SELECT scrboard_score, scrboard_total_score FROM starter_workshop_scoreboard 
								   WHERE scrboard_booking_id='$booking_id'
								   AND scrboard_student_id='$student_id'");
		return $query->row_array();
	}
}
