<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {
	
	public function count_all_discussion_with_faculties()
	{
		$query = $this->db->query("SELECT discuss_id FROM starter_discussions WHERE discuss_to_user_type='FACULTY'");
		return $query->num_rows();
	}
	
	public function get_all_discussion_with_faculties($params=array())
	{
		$query = $this->db->query("SELECT * FROM starter_discussions
								   
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_discussions.discuss_to
								   
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_discussions.discuss_to
								   
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_discussions.discuss_by
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_discussions.discuss_by
								   
								   WHERE discuss_to_user_type='FACULTY'");
		return $query->result_array();
	}
	
	//For Students
	public function count_all_discussion_with_students()
	{
		$query = $this->db->query("SELECT discuss_id FROM starter_discussions WHERE discuss_to_user_type='STUDENT'");
		return $query->num_rows();
	}
	
	public function get_all_discussion_with_students($params=array())
	{
		$query = $this->db->query("SELECT * FROM starter_discussions
								   
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_discussions.discuss_by
								   
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_discussions.discuss_by
								   
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_discussions.discuss_to
								   
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_discussions.discuss_to
								   
								   WHERE discuss_to_user_type='STUDENT'");
		return $query->result_array();
	}
	
}
