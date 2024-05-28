<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model{
	
	public function get_pages($location)
	{
		$query = $this->db->query("SELECT * FROM starter_pages WHERE starter_pages.page_action=1 AND starter_pages.page_location='$location' ORDER BY starter_pages.page_id ASC");
		return $query->result_array();
	}
	
	public function short_descby_slug($slug)
	{
		$query = $this->db->query("SELECT page_short_description FROM starter_pages WHERE starter_pages.page_slug='$slug'");
		$result = $query->row_array();
		return $result['page_short_description'];
	}
	
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
	
	public function get_coordinator()
	{
		$query = $this->db->query("SELECT owner_name, owner_photo
							       FROM starter_owner
								   WHERE starter_owner.owner_show_at_landing='1'
								   ORDER BY starter_owner.owner_id DESC");
		return $query->result_array();
	}
	
	public function get_option_banners()
	{
		$query = $this->db->query("SELECT * FROM starter_options_panel WHERE option_key='BANNERS'");
		return $query->row_array();
	}
	
	public function rtc_faculty_info($id)
	{
		$this -> db -> select('t1.*,t2.batch_name, t3.tpinfo_first_name, t3.tpinfo_middle_name, t3.tpinfo_last_name');
		$this -> db -> from('starter_batch_teacher t1');
		$this -> db -> join('starter_batch t2', 't2.batch_id = t1.batch_id', 'LEFT');
		$this -> db -> join('starter_teachers_personalinfo t3', 't3.tpinfo_teacher_id = t1.teacher_id', 'LEFT');
		$this -> db -> where('t1.batch_id', $id);
		$query = $this->db->get();
		return $query->first_row();
	}
	
}
