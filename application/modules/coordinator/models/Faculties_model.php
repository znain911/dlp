<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculties_model extends CI_Model {
	
	function get_pending_teachers($params = array()){
		
		$query = "SELECT 
				  starter_teachers.*,
				  starter_teachers_personalinfo.tpinfo_first_name,
				  starter_teachers_personalinfo.tpinfo_middle_name,
				  starter_teachers_personalinfo.tpinfo_last_name,
				  starter_teachers_personalinfo.tpinfo_photo,
				  starter_teachers_personalinfo.tpinfo_personal_phone
				  FROM starter_teachers 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id ";
		$query .= "WHERE teacher_reg_has_completed='YES' AND teacher_status='0' ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (teacher_entryid LIKE '%$search_term%' ";
			$query .= "OR teacher_username LIKE '%$search_term%' ";
			$query .= "OR teacher_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY teacher_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_enrolled_teachers($params = array()){
		
		$query = "SELECT 
				  starter_teachers.*,
				  starter_teachers_personalinfo.tpinfo_first_name,
				  starter_teachers_personalinfo.tpinfo_middle_name,
				  starter_teachers_personalinfo.tpinfo_last_name,
				  starter_teachers_personalinfo.tpinfo_photo,
				  starter_teachers_personalinfo.tpinfo_personal_phone
				  FROM starter_teachers 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
				  ";
		$query .= "WHERE teacher_status=1 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (teacher_entryid LIKE '%$search_term%' ";
			$query .= "OR teacher_username LIKE '%$search_term%' ";
			$query .= "OR teacher_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY teacher_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_enrolled_teachers_csv($params = array()){
		
		$query = "SELECT 
				  starter_teachers.*,
				  starter_teachers_personalinfo.tpinfo_first_name,
				  starter_teachers_personalinfo.tpinfo_middle_name,
				  starter_teachers_personalinfo.tpinfo_last_name,
				  starter_teachers_personalinfo.tpinfo_photo,
				  starter_teachers_personalinfo.tpinfo_personal_phone
				  FROM starter_teachers 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
				  ";
		$query .= "WHERE teacher_status=1 ";
		$query .= "ORDER BY teacher_id DESC ";
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function teacherrtc($user_id){
		$this -> db -> select('t1.*, t2.batch_name');
		$this->db->join('starter_batch t2', 't2.batch_id = t1.batch_id', 'left');
		$this -> db -> from('starter_batch_teacher t1');
		$this -> db -> where('t1.teacher_id = ' . "'" . $user_id . "'");
		//$this -> db -> where('st_status = ' . "'1'"); 
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		return $query->first_row();
	}// end of function
	
	public function get_teacher_info($teacher_id)
	{
		$query = $this->db->query("SELECT *
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_academicinfo ON
								   starter_teachers_academicinfo.tacinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_teachers_professionalinfo ON
								   starter_teachers_professionalinfo.tpsinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_countries ON
								   starter_countries.country_id=starter_teachers_personalinfo.tpinfo_nationality
								   WHERE starter_teachers.teacher_id='$teacher_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_teacher_username($teacher_id)
	{
		$query = $this->db->query("SELECT teacher_username FROM starter_teachers WHERE starter_teachers.teacher_id='$teacher_id' LIMIT 1");
		$result = $query->row_array();
		return $result['teacher_username'];
	}
	
	public function get_teacher_entryid($teacher_id)
	{
		$query = $this->db->query("SELECT teacher_entryid FROM starter_teachers WHERE starter_teachers.teacher_id='$teacher_id' LIMIT 1");
		$result = $query->row_array();
		return $result['teacher_entryid'];
	}
	
	public function get_specializations($teacher_id)
	{
		$query = $this->db->query("SELECT
								  *
								  FROM starter_teachers_specializations
								  WHERE starter_teachers_specializations.ts_teacher_id='$teacher_id'
								  ORDER BY starter_teachers_specializations.ts_id ASC
								  "); 
		return $query->result_array();
	}
	
	public function get_specialization_name($specialize_id)
	{
		$query = $this->db->query("SELECT specialize_name FROM starter_specialization WHERE starter_specialization.specialize_id='$specialize_id' LIMIT 1");
		$result = $query->row_array();
		return $result['specialize_name'];
	}
	
	public function get_dlp_categories($teacher_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_teachers_dlpcategories
								   LEFT JOIN starter_dlp_categories ON
								   starter_dlp_categories.category_id=starter_teachers_dlpcategories.tdc_category_id
								   WHERE starter_teachers_dlpcategories.tdc_teacher_id='$teacher_id'
								   ORDER BY starter_teachers_dlpcategories.tdc_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_academicinformation($teacher_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_teachers_academicinfo
								   WHERE starter_teachers_academicinfo.tacinfo_teacher_id='$teacher_id'
								   ORDER BY starter_teachers_academicinfo.tacinfo_id ASC
								  ");
		return $query->result_array();
	}
	
}