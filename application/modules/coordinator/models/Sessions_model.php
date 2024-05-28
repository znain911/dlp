<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_model extends CI_Model {
	
	public function get_sdt_schedules($sdt_type)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule
								   
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_sdt_schedule.endmschedule_phase_id
								   
								   WHERE endmschedule_sdt_type='$sdt_type' ORDER BY endmschedule_id DESC");
		return $query->result_array();
	}
	
	public function get_workshop_schedules()
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule
								   
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_workshop_schedule.endmschedule_phase_id
								   
								   ORDER BY endmschedule_id DESC");
		return $query->result_array();
	}
	
	public function get_sdt_center_schedules($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_centerschdl
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   WHERE centerschdl_parentschdl_id='$schedule_id' ORDER BY centerschdl_id DESC");
		return $query->result_array();
	}
	
	public function get_workshop_center_schedules($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_centerschdl
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   
								   WHERE centerschdl_parentschdl_id='$schedule_id' ORDER BY centerschdl_id DESC");
		return $query->result_array();
	}
	
	public function count_total_sdt_sessions($sdt_type)
	{
		$query = $this->db->query("SELECT booking_id, endmschedule_sdt_type FROM starter_sdt_booking 
							       
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   WHERE booking_user_type='Student'
								   AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type'");
		return $query->num_rows();
	}
	
	public function get_total_sdt_sessions($sdt_type)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_booking 
								   
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_sdt_booking.booking_user_id
								   
								   WHERE booking_user_type='Student' 
								   AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type' 
								   ORDER BY booking_id DESC LIMIT 15");
		return $query->result_array();
	}
	
	public function get_sdt_excel_items($data)
	{
		$sdt_type = $data['sdt_type'];
		$schedule_id = $data['schedule_id'];
		if($data['type'] == 'RANGE'){
			$from_date = $data['from_date'];
			$stop_date = $data['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			
			if(isset($data['schedule_center_id']))
			{
				$schedule_center_id = $data['schedule_center_id'];
				$with_center = "AND centerschdl_center_id='$schedule_center_id' ";
			}else{
				$with_center = null;
			}
			
			$query = $this->db->query("SELECT * FROM starter_sdt_booking 
								   
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_sdt_booking.booking_user_id
								   
								   WHERE booking_user_type='Student' 
								   AND centerschdl_parentschdl_id='$schedule_id' $with_center 
								   AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type'
								   AND centerschdl_to_date BETWEEN '$from_date' AND '$to_date' ORDER BY booking_id ASC");
			return $query->result_array();
		}elseif($data['type'] == 'MONTHLY'){
			$date = $data['date'];
			if(isset($data['schedule_center_id']))
			{
				$schedule_center_id = $data['schedule_center_id'];
				$with_center = "AND centerschdl_center_id='$schedule_center_id' ";
			}else{
				$with_center = null;
			}
			$query = $this->db->query("SELECT * FROM starter_sdt_booking 
								   
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_sdt_booking.booking_user_id
								   
								   WHERE booking_user_type='Student'
								   AND centerschdl_parentschdl_id='$schedule_id' $with_center
								   AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type'
								   AND centerschdl_to_date LIKE '%$date%' ORDER BY booking_id ASC");
			return $query->result_array();
		}elseif($data['type'] == 'YEARLY'){
			$date = $data['date'];
			if(isset($data['schedule_center_id']))
			{
				$schedule_center_id = $data['schedule_center_id'];
				$with_center = "AND centerschdl_center_id='$schedule_center_id' ";
			}else{
				$with_center = null;
			}
			$query = $this->db->query("SELECT * FROM starter_sdt_booking 
								   
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_sdt_booking.booking_user_id
								   
								   WHERE booking_user_type='Student'
								   AND centerschdl_parentschdl_id='$schedule_id' $with_center
								   AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type'
								   AND centerschdl_to_date LIKE '%$date%' ORDER BY booking_id ASC");
			return $query->result_array();
		}						   
	}
	
	public function count_total_workshop_sessions()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_workshop_booking WHERE booking_user_type='Student'");
		return $query->num_rows();
	}
	
	public function get_total_workshop_sessions()
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_booking 
								   
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_workshop_booking.booking_user_id
								   
								   WHERE booking_user_type='Student' ORDER BY booking_id DESC LIMIT 15");
		return $query->result_array();
	}
	
	public function get_workshop_excel_items($data)
	{
		$schedule_id = $data['schedule_id'];
		if($data['type'] == 'RANGE'){
			$from_date = $data['from_date'];
			$stop_date = $data['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			if(isset($data['schedule_center_id']))
			{
				$schedule_center_id = $data['schedule_center_id'];
				$with_center = "AND centerschdl_center_id='$schedule_center_id' ";
			}else{
				$with_center = null;
			}
			$query = $this->db->query("SELECT * FROM starter_workshop_booking 
								   
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_workshop_booking.booking_user_id
								   
								   WHERE booking_user_type='Student' 
								   AND centerschdl_parentschdl_id='$schedule_id' $with_center
								   AND centerschdl_to_date BETWEEN '$from_date' AND '$to_date' ORDER BY booking_id ASC");
			return $query->result_array();
		}elseif($data['type'] == 'MONTHLY'){
			$date = $data['date'];
			if(isset($data['schedule_center_id']))
			{
				$schedule_center_id = $data['schedule_center_id'];
				$with_center = "AND centerschdl_center_id='$schedule_center_id' ";
			}else{
				$with_center = null;
			}
			$query = $this->db->query("SELECT * FROM starter_workshop_booking 
								   
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_workshop_booking.booking_user_id
								   
								   WHERE booking_user_type='Student' 
								   AND centerschdl_parentschdl_id='$schedule_id' $with_center
								   AND centerschdl_to_date LIKE '%$date%' ORDER BY booking_id ASC");
			return $query->result_array();
		}elseif($data['type'] == 'YEARLY'){
			$date = $data['date'];
			if(isset($data['schedule_center_id']))
			{
				$schedule_center_id = $data['schedule_center_id'];
				$with_center = "AND centerschdl_center_id='$schedule_center_id' ";
			}else{
				$with_center = null;
			}
			$query = $this->db->query("SELECT * FROM starter_workshop_booking 
								   
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_workshop_booking.booking_user_id
								   
								   WHERE booking_user_type='Student' 
								   AND centerschdl_parentschdl_id='$schedule_id' $with_center
								   AND centerschdl_to_date LIKE '%$date%' ORDER BY booking_id ASC");
			return $query->result_array();
		}
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
}
