<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {
	
	public function update_workshop_booking($booking_id, $data)
	{
		$this->db->where('booking_id', $booking_id);
		$this->db->update('starter_workshop_booking', $data);
	}
	
	public function update_ece_booking($booking_id, $data)
	{
		$this->db->where('booking_id', $booking_id);
		$this->db->update('starter_eceexam_booking', $data);
	}
	
	public function update_sdtbooking_id($booking_id, $data)
	{
		$this->db->where('booking_id', $booking_id);
		$this->db->update('starter_sdt_booking', $data);
	}
	
	public function get_sdt_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   WHERE starter_sdt_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_sdt_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_sdt_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_ece_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ece_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ece_centerschdl.centerschdl_center_id
								   WHERE starter_ece_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_ece_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_ece_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	/*****************/
	/******START PHASE EXAM BOOKING*****/
	/*****************/
	
	public function save_phaseschedule_booking($data)
	{
		$this->db->insert('starter_phaseexam_booking', $data);
	}
	
	public function save_sdtschedule_booking($data)
	{
		$this->db->insert('starter_sdt_booking', $data);
	}
	
	public function get_centermaximum_sit($centerschdl_id)
	{
		$query = $this->db->query("SELECT centerschdl_maximum_sit FROM starter_phase_centerschdl WHERE starter_phase_centerschdl.centerschdl_id='$centerschdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_sdtcentermaximum_sit($centerschdl_id)
	{
		$query = $this->db->query("SELECT centerschdl_maximum_sit FROM starter_sdt_centerschdl WHERE starter_sdt_centerschdl.centerschdl_id='$centerschdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_maximum_sit($centerschdl_id, $data)
	{
		$this->db->where('centerschdl_id', $centerschdl_id);
		$this->db->update('starter_phase_centerschdl', $data);
	}
	
	public function update_sdtmaximum_sit($centerschdl_id, $data)
	{
		$this->db->where('centerschdl_id', $centerschdl_id);
		$this->db->update('starter_sdt_centerschdl', $data);
	}
	
	public function phaseexam_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_phase_exschedule 
								   WHERE starter_phase_exschedule.endmschedule_phase_id='$phase_id' 
								   AND starter_phase_exschedule.endmschedule_status=1 
								   ORDER BY starter_phase_exschedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function sdt_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule 
								   WHERE starter_sdt_schedule.endmschedule_phase_id='$phase_id' 
								   AND starter_sdt_schedule.endmschedule_status=1 
								   ORDER BY starter_sdt_schedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function check_phase_alrbooked($from_date, $to_date, $phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_phaseexam_booking
								   WHERE starter_phaseexam_booking.booking_user_id='$student_id'
								   AND starter_phaseexam_booking.booking_user_type='Student'
								   AND starter_phaseexam_booking.booking_phase_level='$phase_id'
								   AND starter_phaseexam_booking.booking_date <= '$to_date'
								   AND starter_phaseexam_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function check_sdt_alrbooked($from_date, $to_date, $phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_sdt_booking
								   WHERE starter_sdt_booking.booking_user_id='$student_id'
								   AND starter_sdt_booking.booking_user_type='Student'
								   AND starter_sdt_booking.booking_phase_level='$phase_id'
								   AND starter_sdt_booking.booking_date <= '$to_date'
								   AND starter_sdt_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_sdtcenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_sdt_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_sdt_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
									WHERE starter_sdt_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_center_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_phase_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_phase_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_phase_centerschdl.centerschdl_center_id
									WHERE starter_phase_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	/*****************/
	/******END PHASE EXAM BOOKING*****/
	/*****************/
	
	
	/*****************/
	/******END ECE EXAM BOOKING*****/
	/*****************/
	public function save_eceschedule_booking($data)
	{
		$this->db->insert('starter_eceexam_booking', $data);
	}
	
	public function check_ece_alrbooked($from_date, $to_date)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_eceexam_booking
								   WHERE starter_eceexam_booking.booking_user_id='$student_id'
								   AND starter_eceexam_booking.booking_user_type='Student'
								   AND starter_eceexam_booking.booking_date <= '$to_date'
								   AND starter_eceexam_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_ececentermaximum_sit($centerschdl_id)
	{
		$query = $this->db->query("SELECT centerschdl_maximum_sit FROM starter_ece_centerschdl WHERE starter_ece_centerschdl.centerschdl_id='$centerschdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_ecemaximum_sit($centerschdl_id, $data)
	{
		$this->db->where('centerschdl_id', $centerschdl_id);
		$this->db->update('starter_ece_centerschdl', $data);
	}
	
	public function get_ececenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_ece_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_ece_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_ece_centerschdl.centerschdl_center_id
									WHERE starter_ece_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function ece_available_schedule()
	{
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule  
								   WHERE starter_ece_exschedule.endmschedule_status=1 
								   ORDER BY starter_ece_exschedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	
	/****************/
	/*****START WORKSHOP SCHEDULE******/
	/****************/
	public function save_workshopschedule_booking($data)
	{
		$this->db->insert('starter_workshop_booking', $data);
	}
	
	public function workshop_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule 
								   WHERE starter_workshop_schedule.endmschedule_phase_id='$phase_id' 
								   AND starter_workshop_schedule.endmschedule_status=1 
								   ORDER BY starter_workshop_schedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function get_workshop_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   WHERE starter_workshop_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_workshop_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_workshop_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_total_workshopapplications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_workshop_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function check_workshop_alrbooked($from_date, $to_date, $phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_workshop_booking
								   WHERE starter_workshop_booking.booking_user_id='$student_id'
								   AND starter_workshop_booking.booking_user_type='Student'
								   AND starter_workshop_booking.booking_phase_level='$phase_id'
								   AND starter_workshop_booking.booking_date <= '$to_date'
								   AND starter_workshop_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_workshopcenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_workshop_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_workshop_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
									WHERE starter_workshop_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function update_workshopmaximum_sit($centerschdl_id, $data)
	{
		$this->db->where('centerschdl_id', $centerschdl_id);
		$this->db->update('starter_workshop_centerschdl', $data);
	}
	
	public function get_workshopcentermaximum_sit($centerschdl_id)
	{
		$query = $this->db->query("SELECT centerschdl_maximum_sit FROM starter_workshop_centerschdl WHERE starter_workshop_centerschdl.centerschdl_id='$centerschdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	/****************/
	/*****START WORKSHOP SCHEDULE******/
	/****************/
	
	
	/****************/
	/*****START WORKSHOP SCHEDULE******/
	/****************/
	public function save_ftwofschedule_booking($data)
	{
		$this->db->insert('starter_ftwof_booking', $data);
	}
	
	public function ftwof_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ftwof_schedule 
								   WHERE starter_ftwof_schedule.endmschedule_phase_id='$phase_id' 
								   AND starter_ftwof_schedule.endmschedule_status=1 
								   ORDER BY starter_ftwof_schedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function get_ftwof_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ftwo_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ftwo_centerschdl.centerschdl_center_id
								   WHERE starter_ftwo_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_ftwo_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_ftwo_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_total_ftwofapplications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_ftwof_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function check_ftwof_alrbooked($from_date, $to_date, $phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_ftwof_booking
								   WHERE starter_ftwof_booking.booking_user_id='$student_id'
								   AND starter_ftwof_booking.booking_user_type='Student'
								   AND starter_ftwof_booking.booking_phase_level='$phase_id'
								   AND starter_ftwof_booking.booking_date <= '$to_date'
								   AND starter_ftwof_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_ftwofcenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_ftwo_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_ftwo_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_ftwo_centerschdl.centerschdl_center_id
									WHERE starter_ftwo_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function update_ftwofmaximum_sit($centerschdl_id, $data)
	{
		$this->db->where('centerschdl_id', $centerschdl_id);
		$this->db->update('starter_ftwo_centerschdl', $data);
	}
	
	public function get_ftwofcentermaximum_sit($centerschdl_id)
	{
		$query = $this->db->query("SELECT centerschdl_maximum_sit FROM starter_ftwo_centerschdl WHERE starter_ftwo_centerschdl.centerschdl_id='$centerschdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	/****************/
	/*****START WORKSHOP SCHEDULE******/
	/****************/
	
	public function get_sdt_already_booked_details($phase_id, $sdt_type)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_sdt_booking
								   
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   WHERE starter_sdt_booking.booking_user_id='$student_id' 
								   AND starter_sdt_schedule.endmschedule_sdt_type='$sdt_type'
								   AND starter_sdt_booking.booking_phase_level='$phase_id' 
								   AND starter_sdt_booking.booking_user_type='Student' 
								   ORDER BY booking_id ASC");
		return $query->result_array();
	}
	
	public function get_faculty_entryid($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT teacher_entryid FROM starter_sdt_booking
									
									LEFT JOIN starter_teachers ON
									starter_teachers.teacher_id=starter_sdt_booking.booking_user_id
									
								  WHERE booking_schedule_centerid='$booking_schedule_centerid'
								  AND booking_user_type='Faculty'
								  AND booking_status='1'");
		$result = $query->row_array();
		if($result['teacher_entryid'])
		{
			return $result['teacher_entryid'];
		}else{
			return null;
		}
	}
	
	public function get_workshop_faculty_entryid($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT teacher_entryid FROM starter_workshop_booking
									
									LEFT JOIN starter_teachers ON
									starter_teachers.teacher_id=starter_workshop_booking.booking_user_id
									
								  WHERE booking_schedule_centerid='$booking_schedule_centerid'
								  AND booking_user_type='Faculty'
								  AND booking_status='1'");
		$result = $query->row_array();
		if($result['teacher_entryid'])
		{
			return $result['teacher_entryid'];
		}else{
			return null;
		}
	}
	
	public function get_ece_faculty_entryid($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT teacher_entryid FROM starter_eceexam_booking
									
									LEFT JOIN starter_teachers ON
									starter_teachers.teacher_id=starter_eceexam_booking.booking_user_id
									
								  WHERE booking_schedule_centerid='$booking_schedule_centerid'
								  AND booking_user_type='Faculty'
								  AND booking_status='1'");
		$result = $query->row_array();
		if($result['teacher_entryid'])
		{
			return $result['teacher_entryid'];
		}else{
			return null;
		}
	}
	
	public function get_workshop_already_booked_details($phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_workshop_booking
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   WHERE starter_workshop_booking.booking_user_id='$student_id' 
								   AND starter_workshop_booking.booking_phase_level='$phase_id' 
								   AND starter_workshop_booking.booking_user_type='Student' 
								   ORDER BY booking_id ASC");
		return $query->result_array();
	}
	
	public function get_ece_already_booked_details()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_eceexam_booking
								   LEFT JOIN starter_ece_centerschdl ON
								   starter_ece_centerschdl.centerschdl_id=starter_eceexam_booking.booking_schedule_centerid
								   LEFT JOIN starter_ece_exschedule ON
								   starter_ece_exschedule.endmschedule_id=starter_eceexam_booking.booking_schedule_id
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ece_centerschdl.centerschdl_center_id
								   WHERE starter_eceexam_booking.booking_user_id='$student_id'  
								   AND starter_eceexam_booking.booking_user_type='Student' 
								   ORDER BY booking_id ASC");
		return $query->result_array();
	}
	
	public function check_students_booking($phase, $schedule_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT booking_id FROM starter_sdt_booking
								   WHERE starter_sdt_booking.booking_phase_level='$phase'
								   AND starter_sdt_booking.booking_schedule_id='$schedule_id'
								   AND starter_sdt_booking.booking_user_id='$student_id'
								   AND starter_sdt_booking.booking_user_type='Student'
								   ");
		return $query->row_array();
	}
	
	public function check_workshop_students_booking($phase, $schedule_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT booking_id FROM starter_workshop_booking
								   WHERE starter_workshop_booking.booking_phase_level='$phase'
								   AND starter_workshop_booking.booking_schedule_id='$schedule_id'
								   AND starter_workshop_booking.booking_user_id='$student_id'
								   AND starter_workshop_booking.booking_user_type='Student'
								   ");
		return $query->row_array();
	}
	
	public function check_ece_students_booking($schedule_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT booking_id FROM starter_eceexam_booking
								   WHERE starter_eceexam_booking.booking_schedule_id='$schedule_id'
								   AND starter_eceexam_booking.booking_user_id='$student_id'
								   AND starter_eceexam_booking.booking_user_type='Student'
								   ");
		return $query->row_array();
	}
	
	public function get_sdt_booking_center_faculties($booking_schedule_centerid)
	{
		$query = $this->db->query("SELECT booking_user_id, teacher_entryid, tpinfo_first_name, tpinfo_middle_name, tpinfo_last_name, programme_status 
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
		$query = $this->db->query("SELECT booking_user_id, teacher_entryid, tpinfo_first_name, tpinfo_middle_name, tpinfo_last_name, programme_status
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
