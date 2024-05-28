<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussapi_model extends CI_Model{
	
	public function get_discussion_with_faculty($params=array())
	{
		$query = "SELECT * FROM starter_discussions			   
			   LEFT JOIN starter_teachers_personalinfo ON
			   starter_teachers_personalinfo.tpinfo_teacher_id=starter_discussions.discuss_to
			   
			   LEFT JOIN starter_teachers ON
			   starter_teachers.teacher_id=starter_discussions.discuss_to
			   
			   LEFT JOIN starter_students_personalinfo ON
			   starter_students_personalinfo.spinfo_student_id=starter_discussions.discuss_by
			   
			   LEFT JOIN starter_students ON
			   starter_students.student_id=starter_discussions.discuss_by ";
		$query .= "WHERE discuss_to_user_type='FACULTY' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND discuss_created_date>='$from_date' AND discuss_created_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND discuss_created_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND discuss_created_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND discuss_created_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (discuss_slentry_number LIKE '%$search_term%' OR starter_teachers_personalinfo.tpinfo_first_name LIKE '%$search_term%' OR starter_students_personalinfo.spinfo_first_name LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY discuss_id $sortby ";
		}else
		{
			$query .= "ORDER BY discuss_id DESC ";
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
	
	public function get_discussion_with_student($params=array())
	{
		$query = "SELECT * FROM starter_discussions
		
			   LEFT JOIN starter_teachers_personalinfo ON
			   starter_teachers_personalinfo.tpinfo_teacher_id=starter_discussions.discuss_by
			   
			   LEFT JOIN starter_teachers ON
			   starter_teachers.teacher_id=starter_discussions.discuss_by
			   
			   LEFT JOIN starter_students_personalinfo ON
			   starter_students_personalinfo.spinfo_student_id=starter_discussions.discuss_to
			   
			   LEFT JOIN starter_students ON
			   starter_students.student_id=starter_discussions.discuss_to ";
		$query .= "WHERE discuss_to_user_type='STUDENT' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND discuss_created_date>='$from_date' AND discuss_created_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND discuss_created_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND discuss_created_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND discuss_created_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (discuss_slentry_number LIKE '%$search_term%' OR starter_teachers_personalinfo.tpinfo_first_name LIKE '%$search_term%' OR starter_students_personalinfo.spinfo_first_name LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY discuss_id $sortby ";
		}else
		{
			$query .= "ORDER BY discuss_id DESC ";
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
	
}