<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perm_model extends CI_Model{
	
	public function check_permissionby_admin($admin_id, $permission_id)
	{
		$query = $this->db->query("SELECT permission_id FROM starter_admin_permission 
		                           WHERE starter_admin_permission.permission_adminid='$admin_id' 
		                           AND starter_admin_permission.permission_permission_id='$permission_id' 
								   ");
		return $query->row_array();
	}
	
	public function get_sdt_schedules($phase_id, $type)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule 
								   
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_sdt_schedule.endmschedule_phase_id
								   
								   WHERE endmschedule_phase_id='$phase_id'
								   AND endmschedule_sdt_type='$type'
								   ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function get_sdt_booked($type)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   starter_sdt_booking.*, 
								   starter_phases.phase_name, 
								   starter_sdt_schedule.endmschedule_title
								   FROM starter_sdt_booking
								   
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_sdt_booking.booking_phase_level
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   WHERE starter_sdt_booking.booking_user_id='$student_id'
								   AND starter_sdt_schedule.endmschedule_sdt_type='$type'
								   AND starter_sdt_booking.booking_user_type='Student'
								 ");
		return $query->result_array();
	}
	
	public function get_workshop_booked()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   starter_workshop_booking.*, 
								   starter_phases.phase_name, 
								   starter_workshop_schedule.endmschedule_title
								   FROM starter_workshop_booking
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_workshop_booking.booking_phase_level
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   WHERE starter_workshop_booking.booking_user_id='$student_id'
								   AND starter_workshop_booking.booking_user_type='Student'
								 ");
		return $query->result_array();
	}
	
	public function get_workshop_schedules($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule 
								   
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_workshop_schedule.endmschedule_phase_id
								   
								   WHERE starter_workshop_schedule.endmschedule_phase_id='$phase_id' ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function get_ece_schedules()
	{
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function check_student_ece_status()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students 
								   WHERE starter_students.student_phaselevel_id='0' 
								   AND starter_students.student_ece_status=1 
								   AND starter_students.student_id='$student_id' 
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function check_ece_schedule()
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule WHERE endmschedule_from_date > '$current_date'");
		return $query->row_array();
	}
	
	/* public function total_phone_change_request()
	{
		$query = $this->db->query("SELECT spinfo_id FROM starter_students_personalinfo WHERE starter_students_personalinfo.spinfo_personal_phone_updaterqst='YES'");
		return $query->num_rows();
	} */
	
	function total_phone_change_request(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_personal_phone_updaterqst,
				  starter_students_personalinfo.spinfo_personal_phone_updated
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id ";
		$query .= "WHERE student_status=1 AND starter_students_personalinfo.spinfo_personal_phone_updaterqst='YES' ";
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->num_rows();
    }
	
	
}
