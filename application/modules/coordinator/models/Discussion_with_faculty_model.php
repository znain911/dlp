<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_with_faculty_model extends CI_Model {
	
	public function get_discuss_serial_no()
	{
		$date = date("Y-m-d");
		$query = $this->db->query("SELECT discuss_id FROM starter_discussions WHERE discuss_created_date LIKE '%$date%'");
		$the_num = $query->num_rows()+1;
		return date("Ymd").str_pad($the_num, 5, '0', STR_PAD_LEFT);
	}
	
	public function get_faculties()
	{
		$query = $this->db->query("SELECT * FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   ORDER BY teacher_id ASC");
		return $query->result_array();
	}
	
	public function get_faculty_info_by_id($faculty_id)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE teacher_id='$faculty_id' LIMIT 1");
		return $query->row_array();
	}
	
	
	public function get_total_messages_by_faculty($faculty_id)
	{
		$query = $this->db->query("SELECT discuss_id FROM starter_discussions 
								   WHERE discuss_by='$faculty_id'
								   AND discuss_to_user_type='FACULTY'");
		return $query->num_rows();
	}
	
	public function get_discussions_by_faculty($faculty_id)
	{
		$student_id = $this->session->userdata('active_student');
		
		//Check who has sent at first
		$query_1 = $this->db->query("SELECT * FROM starter_discussions
								   WHERE discuss_by='$faculty_id' 
								   AND discuss_to='$student_id' 
								   AND discuss_by_user_type='FACULTY' 
								   AND discuss_to_user_type='STUDENT' 
								   LIMIT 1");
		$result_1 = $query_1->row_array();
		
		$query_2 = $this->db->query("SELECT * FROM starter_discussions
								   WHERE discuss_by='$student_id' 
								   AND discuss_to='$faculty_id' 
								   AND discuss_by_user_type='STUDENT' 
								   AND discuss_to_user_type='FACULTY' 
								   LIMIT 1");
		$result_2 = $query_2->row_array();
		
		if($result_1 == true)
		{
			$discuss_id = $result_1['discuss_id'];
			$query = $this->db->query("SELECT * FROM starter_discussions_reply
									   WHERE reply_discuss_id='$discuss_id'
									   ORDER BY reply_id ASC");
			$results = $query->result_array();
			return $results;
		}elseif($result_2 == true){
			$discuss_id = $result_2['discuss_id'];
			$query = $this->db->query("SELECT * FROM starter_discussions_reply
									   WHERE reply_discuss_id='$discuss_id'
									   ORDER BY reply_id ASC");
			$results = $query->result_array();
			return $results;
		}else
		{
			return array();
		}
	}
	
	public function get_reply_by_discussion($discuss_id)
	{
		$query = $this->db->query("SELECT * FROM starter_discussions_reply
								   WHERE reply_discuss_id='$discuss_id'
								   ORDER BY reply_id ASC");
		$results = $query->result_array();
		return $results;
	}
	
	public function get_student_photo($student_id)
	{
		$query = $this->db->query("SELECT spinfo_photo, student_entryid FROM starter_students_personalinfo 
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_students_personalinfo.spinfo_student_id
								   WHERE spinfo_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_teacher_photo($teacher_id)
	{
		$query = $this->db->query("SELECT tpinfo_photo, teacher_entryid FROM starter_teachers_personalinfo 
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_teachers_personalinfo.tpinfo_teacher_id
								   WHERE tpinfo_teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function save_discussion_data($data)
	{
		$this->db->insert("starter_discussions", $data);
	}
	
	public function save_messge_reply($data)
	{
		$this->db->insert("starter_discussions_reply", $data);
	}
	
	public function check_previous_discuss($student_id, $faculty_id)
	{
		//Check who has sent at first
		$query_1 = $this->db->query("SELECT * FROM starter_discussions
								   WHERE discuss_by='$faculty_id' 
								   AND discuss_to='$student_id' 
								   AND discuss_by_user_type='FACULTY' 
								   AND discuss_to_user_type='STUDENT' 
								   LIMIT 1");
		$result_1 = $query_1->row_array();
		
		$query_2 = $this->db->query("SELECT * FROM starter_discussions
								   WHERE discuss_by='$student_id' 
								   AND discuss_to='$faculty_id' 
								   AND discuss_by_user_type='STUDENT' 
								   AND discuss_to_user_type='FACULTY' 
								   LIMIT 1");
		$result_2 = $query_2->row_array();
		
		if($result_1 == true)
		{
			return $result_1;
		}elseif($result_2 == true){
			return $result_2;
		}else
		{
			return array();
		}
	}
	
	public function save_discussion_notification($data)
	{
		$this->db->insert('starter_discussions_notifications', $data);
	}
	public function refresh_discuss_notifications($user_id, $user_type)
	{
		$this->db->where('notify_user_id', $user_id);
		$this->db->where('notify_user_type', $user_type);
		$this->db->delete('starter_discussions_notifications');
	}
	public function get_total_new_messages($user_id, $user_type)
	{
		$query = $this->db->query("SELECT notify_id FROM starter_discussions_notifications WHERE notify_user_id='$user_id' AND notify_user_type='$user_type'");
		return $query->num_rows();
	}
	
	
}