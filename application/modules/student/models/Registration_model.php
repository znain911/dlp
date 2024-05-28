<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model{
	
	public function check_student_email($email)
	{
		$query = $this->db->query("SELECT student_email FROM starter_students WHERE student_email='$email'");
		return $query->row_array();
	}
	public function check_faculty_email($email)
	{
		$query = $this->db->query("SELECT teacher_email FROM starter_teachers WHERE teacher_email='$email'");
		return $query->row_array();
	}
	
	public function check_student_phone_number($phone)
	{
		$query = $this->db->query("SELECT spinfo_personal_phone FROM starter_students_personalinfo WHERE spinfo_personal_phone='$phone'");
		return $query->row_array();
	}
	public function check_faculty_phone_number($phone)
	{
		$query = $this->db->query("SELECT tpinfo_personal_phone FROM starter_teachers_personalinfo WHERE tpinfo_personal_phone='$phone'");
		return $query->row_array();
	}
	
	public function get_all_countries()
	{
		$query = $this->db->query("SELECT country_id, country_name FROM starter_countries WHERE starter_countries.country_status=1 ORDER BY starter_countries.country_id ASC");
		return $query->result_array();
	}
	
	public function save_account($data)
	{
		$this->db->insert('starter_students', $data);
	}
	
	public function student_insert($data) {        
		//Transfering data to Model
		$this->db->trans_start();
		$this->db->insert('starter_students', $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;			
   	} // End of function
	
	public function update_account($student_id, $data)
	{
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
	}
	
	public function total_students()
	{
		$query = $this->db->query("SELECT MAX(student_id) AS maxval FROM starter_students");
		$result = $query->row_array();
		if($result['maxval'])
		{
			$max_val = $result['maxval'] + 1;
		}else{
			$max_val = 1;
		}
		return $max_val;
	}

	public function total_students_batch($bid)
	{
		$query = $this->db->query("SELECT COUNT(student_id) AS maxval FROM starter_students WHERE student_batch = '$bid' ");
		$result = $query->row_array();
		if($result['maxval'])
		{
			$max_val = $result['maxval'] + 1;
		}else{
			$max_val = 1;
		}
		return $max_val;
	}
	
	public function save_personal_info($data)
	{
		$this->db->insert('starter_students_personalinfo', $data);
	}
	
	public function update_personal_info($student_id, $data)
	{
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->update('starter_students_personalinfo', $data);
	}
	public function update_applicant_type($value,$st_id)
	{
		$query = $this->db->query("update dlp.starter_students
		set student_application_type = '$value'
		where student_id  = '$st_id'");
	}
	
	public function get_all_specializations()
	{
		$query = $this->db->query("SELECT specialize_id, specialize_name FROM starter_specialization ORDER BY starter_specialization.specialize_id ASC");
		return $query->result_array();
	}
	
	public function get_dlp_categories()
	{
		$query = $this->db->query("SELECT category_id, category_name FROM starter_dlp_categories ORDER BY starter_dlp_categories.category_order ASC");
		return $query->result_array();
	}
	
	public function save_professional_info($data)
	{
		$this->db->insert('starter_students_professionalinfo', $data);
	}
	public function save_specialization_info($data)
	{
		$this->db->insert('starter_students_specializations', $data);
	}
	public function save_academic_info($data)
	{
		$this->db->insert('starter_students_academicinfo', $data);
	}
	public function save_categories_info($data)
	{
		$this->db->insert('starter_students_dlpcategories', $data);
	}
	
	public function get_student_info($student_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE spinfo_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function student_basic_info($student_portid)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_portid='$student_portid' LIMIT 1");
		return $query->row_array();
	}
	
	public function paidstudentonln($sid){
		$query = $this->db->query("SELECT * FROM starter_online_payments WHERE starter_online_payments.onpay_student_entryid='$sid' ");
		return $query->row_array();
	}

	public function paidstudentdpst($sid){
		$query = $this->db->query("SELECT * FROM starter_deposit_payments WHERE starter_deposit_payments.deposit_student_entryid='$sid' ");
		return $query->row_array();
	}
	
	public function get_account_info($student_id)
	{
		$query = $this->db->query("SELECT * FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_students WHERE starter_students.student_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_mobile($mobile)
	{
		$query = $this->db->query("SELECT * FROM starter_students_personalinfo WHERE starter_students_personalinfo.spinfo_personal_phone='$mobile' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_teacher_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers WHERE starter_teachers.teacher_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_teacher_mobile($mobile)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers_personalinfo WHERE starter_teachers_personalinfo.tpinfo_personal_phone='$mobile' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_username($username)
	{
		$query = $this->db->query("SELECT * FROM starter_students WHERE starter_students.student_username='$username' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_personal_info($student_id)
	{
		$query = $this->db->query("SELECT * FROM starter_students_personalinfo WHERE starter_students_personalinfo.spinfo_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_payment_config()
	{
		$query = $this->db->query("SELECT pconfig_course_fee FROM starter_payment_config WHERE starter_payment_config.pconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function save_deposit_info($data)
	{
		$this->db->insert('starter_deposit_payments', $data);
	}
	
	public function get_banks_details()
	{
		$query = $this->db->query("SELECT * FROM starter_config_bank_details 
								   WHERE bank_status='1'
								   ORDER BY starter_config_bank_details.bank_id DESC");
		return $query->result_array();
	}
	
}