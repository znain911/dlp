<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model {
	
	function get_pending_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id ";
		$query .= "WHERE student_reg_has_completed='YES' AND student_status='0' ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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

    public function getTotalPending(){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_reg_has_completed','YES');
		$this -> db -> where('student_status',0);
		$query = $this->db->get();
		return $query->result();
    }
	
	function get_enrolled_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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

    function get_approve_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_payment_status != 1 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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
	
	public function getTotalApproved(){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_status',1);
		$this -> db -> where('student_payment_status != 1');
		$query = $this->db->get();
		return $query->result();
    }

    function get_placement_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_payment_status = 1 AND student_enrolled = 0 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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
	
	function get_placement_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_payment_status = 1 AND student_enrolled = 0 ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_placement_students_csvbybatch($batch){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_payment_status = 1 AND student_enrolled = 0 AND starter_students.student_batch = '$batch' ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_declinedpayment_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_payment_status = 0 AND DATEDIFF(NOW(),student_approve_date) > 4 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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
	
	 public function getDeclinedPaymentCnt(){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_status',1);
		$this -> db -> where('student_payment_status = 0');
		$this -> db -> where('DATEDIFF(NOW(),student_approve_date) > 4');
		$query = $this->db->get();
		return $query->result();
    }
	
	function get_changed_phone_numbers($params = array()){
		
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
		/*$query .= "ORDER BY student_id DESC LIMIT 15";
		$result = $this->db->query($query);
		return $result->result_array();*/
		$query .= "ORDER BY student_id DESC ";
		
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
	function get_changed_phone_numbers_total(){
		
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
		return $result->result_array();
    }
	
	public function get_student_info($student_id)
	{
		$query = $this->db->query("SELECT *
								   FROM starter_students
								   LEFT JOIN starter_students_academicinfo ON
								   starter_students_academicinfo.sacinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_countries ON
								   starter_countries.country_id=starter_students_personalinfo.spinfo_nationality
								   WHERE starter_students.student_id='$student_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function update_sms_info($student_id)
	{
		$query = $this->db->query("update starter_students
								   set  student_approve_sms = 1
								   WHERE starter_students.student_id='$student_id'
								   LIMIT 1
								  ");
	}
	
	public function update_approve_sms($student_id,$update)
	{
		$query = $this->db->query("update starter_students
								   set  approve_sms = '$update'
								   WHERE starter_students.student_id='$student_id'
								   LIMIT 1
								  ");
	}
	
	public function get_student_username($student_id)
	{
		$query = $this->db->query("SELECT student_username FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_username'];
	}
	
	public function get_student_contactinfo($student_id)
	{
		$query = $this->db->query("SELECT * FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_student_entryid($student_id)
	{
		$query = $this->db->query("SELECT student_entryid FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_entryid'];
	}
	
	public function get_specializations($student_id)
	{
		$query = $this->db->query("SELECT
								  *
								  FROM starter_students_specializations
								  WHERE starter_students_specializations.ss_student_id='$student_id'
								  ORDER BY starter_students_specializations.ss_id ASC
								  "); 
		return $query->result_array();
	}
	
	public function get_specialization_name($specialize_id)
	{
		$query = $this->db->query("SELECT specialize_name FROM starter_specialization WHERE starter_specialization.specialize_id='$specialize_id' LIMIT 1");
		$result = $query->row_array();
		return $result['specialize_name'];
	}
	
	public function get_dlp_categories($student_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_students_dlpcategories
								   LEFT JOIN starter_dlp_categories ON
								   starter_dlp_categories.category_id=starter_students_dlpcategories.sdc_category_id
								   WHERE starter_students_dlpcategories.sdc_student_id='$student_id'
								   ORDER BY starter_students_dlpcategories.sdc_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_academicinformation($student_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_students_academicinfo
								   WHERE starter_students_academicinfo.sacinfo_student_id='$student_id'
								   ORDER BY starter_students_academicinfo.sacinfo_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_active_module($phase=1)
	{
		$query = $this->db->query("SELECT MIN(module_id) AS active_module FROM starter_modules WHERE starter_modules.module_phase_id='$phase' LIMIT 1");
		$result = $query->row_array();
		return $result['active_module'];
	}
	
	public function get_onlinepayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_online_payments WHERE starter_online_payments.onpay_student_entryid='$student_entryid' ORDER BY onpay_id ASC");
		return $query->result_array();
	}
	
	public function get_depositpayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_deposit_payments WHERE starter_deposit_payments.deposit_student_entryid='$student_entryid' ORDER BY deposit_id ASC");
		return $query->result_array();
	}
	
	function get_pending_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=0 AND starter_students.student_reg_has_completed = 'YES' ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_pending_students_csvbybatch($batch){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=0 AND starter_students.student_reg_has_completed = 'YES' AND starter_students.student_batch = '$batch' ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

     public function getStudentSpe($id)
	{
		$this -> db -> select('t2.specialize_name');
		$this -> db -> from('starter_students_specializations t1');
		$this -> db -> join('starter_specialization t2','t2.specialize_id = t1.ss_specilzation_id');
		$this -> db -> where('t1.ss_student_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

    public function getStudentAcademy($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_students_academicinfo');
		$this -> db -> where('sacinfo_student_id', $id);
		$this -> db -> order_by('sacinfo_year', 'ASC');
		$this -> db -> limit(3);
		$query = $this->db->get();
		return $query->result();
	}

	public function getStudentAcademyList($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_students_academicinfo');
		$this -> db -> where('sacinfo_student_id', $id);
		$this -> db -> order_by('sacinfo_year', 'ASC');
		$this -> db -> limit(2);
		$query = $this->db->get();
		return $query->result();
	}
	
	 function get_reject_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id				  
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=5 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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

    function get_reject_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=5 ";
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	public function getTotalRejectStdnt(){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_status',5);
		$query = $this->db->get();
		return $query->result();
    }
	
	public function get_betch()
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('status', 1);
		$this -> db -> order_by('batch_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotalBatchStdnt($id){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_rtc',$id);
		$query = $this->db->get();
		return $query->result();
    }
    public function get_betch_dtl($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('batch_id', $id);
		$query = $this->db->get();
		return $query->first_row();
	}
	
	public function getTotalEnrlStdnt(){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_enrolled',1);
		$query = $this->db->get();
		return $query->result();
    }

	function get_enrolled_students_batch($id){
		$this -> db -> select('t1.*,t2.spinfo_first_name, t2.spinfo_middle_name, t2.spinfo_last_name, t2.spinfo_photo, t2.spinfo_personal_phone');
		$this -> db -> join('starter_students_personalinfo t2','t2.spinfo_student_id = t1.student_id', 'LEFT');
		$this -> db -> from('starter_students t1');
		$this -> db -> where('t1.student_enrolled',1);
		$this -> db -> where('t1.student_status',1);
		$this -> db -> where('t1.student_rtc',$id);
		$query = $this->db->get();
		return $query->result();
        
    }
	
	function get_rtc_change_students(){
		$this -> db -> select('t1.*, t2.*, t3.spinfo_first_name,t3.spinfo_middle_name, t3.spinfo_last_name, t3.spinfo_personal_phone, t4.batch_name');
		$this -> db -> join('starter_students t2','t2.student_id=t1.shift_student_id');
		$this -> db -> join('starter_students_personalinfo t3','t3.spinfo_student_id=t1.shift_student_id');
		$this -> db -> join('starter_batch t4','t4.batch_id=t1.current_rtc');
		$this -> db -> from('starter_rtc_shift t1');
		/*$this -> db -> where('t1.student_enrolled',1);
		$this -> db -> where('t1.student_status',1);
		$this -> db -> where('t1.student_rtc',$id);*/
		$query = $this->db->get();
		return $query->result();
        
    }

    function get_enrolled_students_batch_csv($id){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_personalinfo.spinfo_fmorspouse_name,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_enrolled=1 AND starter_students.student_rtc = $id ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	function get_enrolled_csvbybatch($id){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_personalinfo.spinfo_fmorspouse_name,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_batch.batch_name
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_batch ON starter_batch.batch_id=starter_students.student_rtc
				  ";
		$query .= "WHERE starter_students.student_enrolled=1 AND starter_students.student_batch = $id ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();        
    }
	public function getTotalEnrolled(){
    	$this -> db -> select('COUNT(student_id) as enrolltotal');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_enrolled',1);
		$query = $this->db->get();
		$result = $query->row_array();
		if($result['enrolltotal'])
		{
			$max_val = $result['enrolltotal'] + 1;
		}else{
			$max_val = 1;
		}
		return $max_val;
    }
	
	 public function get_teacher_batch($id) { /*get teacher list*/
        $this -> db -> select('t1.*, t2.tpinfo_first_name,t2.tpinfo_middle_name,t2.tpinfo_last_name');
        $this -> db -> join('starter_teachers_personalinfo t2','t2.tpinfo_teacher_id=t1.teacher_id', 'left');
		$this -> db -> from('starter_batch_teacher t1');
		$this -> db -> where('t1.batch_id', $id);
		$query = $this->db->get();
		return $query->first_row();
    } // End of function

    public function transfet_history_insert($data) {
		$this->db->trans_start();
		$this->db->insert('starter_rtc_transfer_history', $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    } // End of function
	
	 public function dropout_history_insert($data) {
		$this->db->trans_start();
		$this->db->insert('starter_dropout_history', $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    } // End of function

    public function blocked_history_insert($data) {
		$this->db->trans_start();
		$this->db->insert('starter_block_history', $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    } // End of function

     function get_rtcenrolled_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_enrolled=1 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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

    function get_enrolled_students_all(){
		$this -> db -> select('t1.*,t2.spinfo_first_name, t2.spinfo_middle_name, t2.spinfo_last_name, t2.spinfo_photo, t2.spinfo_personal_phone, t3.batch_name,t1.student_email');
		$this -> db -> join('starter_students_personalinfo t2','t2.spinfo_student_id = t1.student_id');
		$this -> db -> join('starter_batch t3','t3.batch_id = t1.student_rtc');
		$this -> db -> from('starter_students t1');
		$this -> db -> where('t1.student_enrolled',1);
		$this -> db -> order_by("t1.student_id", "desc");
		$query = $this->db->get();
		return $query->result();        
    }
	
	 function update_pass($id){
		      $query = $this->db->query("update starter_students set student_password = '7c4a8d09ca3762af61e59520943dc26494f8941b' where student_id = $id ");
			  if ($this->db->affected_rows() > 0)
				{
				  return TRUE;
				}
				else
				{
				  return FALSE;
				}
    }
	
	function update_email($id , $newEmail){
		      $query = $this->db->query("update starter_students set student_email = '$newEmail' where student_id = $id ");
			  if ($this->db->affected_rows() > 0)
				{
					$this->db->query("update starter_students_personalinfo set spinfo_email = '$newEmail' where spinfo_student_id = $id ");
				  return TRUE;
				}
				else
				{
				  return FALSE;
				}
    }
	
	function update_phone($id , $phone){
		      $query = $this->db->query("update starter_students_personalinfo set spinfo_personal_phone = '$phone' where spinfo_student_id = $id ");
			  if ($this->db->affected_rows() > 0)
				{
					
				  return TRUE;
				}
				else
				{
				  return FALSE;
				}
    }
	
    function get_enrolled_students_dropout(){
		$this -> db -> select('t1.*,t2.spinfo_first_name, t2.spinfo_middle_name, t2.spinfo_last_name, t2.spinfo_photo, t2.spinfo_personal_phone, t3.batch_name');
		$this -> db -> join('starter_students_personalinfo t2','t2.spinfo_student_id = t1.student_id');
		$this -> db -> join('starter_batch t3','t3.batch_id = t1.student_rtc');
		$this -> db -> from('starter_students t1');
		$this -> db -> where('t1.student_enrolled',1);
		$this -> db -> where('t1.student_status',3);
		$query = $this->db->get();
		return $query->result();        
    }
    function get_enrolled_students_blocked(){
		$this -> db -> select('t1.*,t2.spinfo_first_name, t2.spinfo_middle_name, t2.spinfo_last_name, t2.spinfo_photo, t2.spinfo_personal_phone, t3.batch_name');
		$this -> db -> join('starter_students_personalinfo t2','t2.spinfo_student_id = t1.student_id');
		$this -> db -> join('starter_batch t3','t3.batch_id = t1.student_rtc');
		$this -> db -> from('starter_students t1');
		$this -> db -> where('t1.student_enrolled',1);
		$this -> db -> where('t1.student_status',2);
		$query = $this->db->get();
		return $query->result();        
    }
	
	function get_approved_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_personalinfo.spinfo_national_id,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_professionalinfo.badas_non
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=1 AND starter_students.student_enrolled = 0 ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_approved_students_csvbybatch($batch){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_personalinfo.spinfo_national_id,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_professionalinfo.badas_non
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=1 AND starter_students.student_enrolled = 0 AND starter_students.student_batch = '$batch' ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	public function get_phase1mdlopn($id, $mdl)
	{
		$this -> db -> select('DISTINCT(t1.lessread_module_id)');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lessread_module_id', 'LEFT');
		$this -> db -> from('starter_lesson_reading_completed t1');
		$this -> db -> where('t1.lessread_user_id', $id);
		$this -> db -> where('t2.module_phase_id', $mdl);
		/*$this -> db -> group_by('t1.lessread_module_id');*/
		$query = $this->db->get();			
		/*if ($query->num_rows() > 0) {
        	return $query->result();
		}
		return 0;*/
		if($query == '1') {
               $results = $query->result();
               return  $results;
            }
            else{
                 return false;
            }
		/*return $query->result();*/
	}

	public function get_totalmodul($id)
	{
		$this -> db -> select('module_id,module_name');
		$this -> db -> from('starter_modules');
		$this -> db -> where('module_phase_id', $id);
		$this -> db -> order_by('module_name', 'ASC');		
		$query = $this->db->get();
		return $query->result();
	}

	public function get_totallesson($phid,$mdl)
	{
		$this -> db -> select('t1.lesson_id');
		$this -> db -> from('starter_modules_lessons t1');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lesson_module_id', 'LEFT');
		$this -> db -> where('t1.lesson_module_id', $mdl);
		$this -> db -> where('t2.module_phase_id', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_readedlessonbymodule($id,$phid,$mdl)
	{
		$this -> db -> select('t1.lessread_id');
		$this -> db -> join('starter_modules t2', 't2.module_id = t1.lessread_module_id', 'LEFT');
		$this -> db -> from('starter_lesson_reading_completed t1');
		$this -> db -> where('t1.lessread_user_id', $id);
		$this -> db -> where('t1.lessread_module_id', $mdl);
		$this -> db -> where('t2.module_phase_id', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_lessonexam($phid,$stid)
	{
		$this -> db -> select('t1.examcnt_id');
		$this -> db -> from('starter_practiceexam_counter t1');
		$this -> db -> where('t1.examcnt_student_id', $stid);
		$this -> db -> where('t1.examcnt_phase_level', $phid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_pcaexam($phid,$stid)
	{
		$this -> db -> select('t1.*');
		$this -> db -> from('starter_module_progress t1');
		$this -> db -> where('t1.cmreport_student_id', $stid);
		$this -> db -> where('t1.cmreport_phase_id', $phid);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getBatch()
	{
		$this -> db -> select('*');
		$this -> db -> from('ccd_batch');
		$this -> db -> order_by('btc_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_wantdelete_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id ";
		$query .= "WHERE date(student_regdate) < '2021-08-31' AND student_enrolled = 0 
AND student_reg_has_completed = 'NO' AND student_payment_status = 0 AND student_status = 0 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		$query .= "ORDER BY student_id DESC ";
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

    public function getTotalDlt(){
    	$this -> db -> select('*');
		$this -> db -> from('starter_students');
		$this -> db -> where('date(student_regdate) <','2021-05-20');
		$this -> db -> where('student_reg_has_completed','NO');
		$this -> db -> where('student_status',0);
		$this -> db -> where('student_enrolled',0);
		$this -> db -> where('student_payment_status',0);
		$query = $this->db->get();
		return $query->result();
    }
	
	public function getExam2($stid, $lid){
		$this -> db -> select('t1.*, t2.lesson_title');
		$this -> db -> from('starter_practiceexam_counter t1');
		$this -> db -> join('starter_modules_lessons t2', 't1.examcnt_lesson_id = t2.lesson_id', 'LEFT');
		$this -> db -> where('t1.examcnt_student_id', $stid);
		$this -> db -> where('t1.examcnt_phase_level', $lid);
		$this -> db -> order_by('t1.examcnt_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_lesson_right_answers($practice_exam_id)
	{
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_practice_exmanswer
								   WHERE starter_practice_exmanswer.answer_exam_id='$practice_exam_id'
								   AND starter_practice_exmanswer.answer_status=1
								  ");
		$result = $query->num_rows();
		return $result;
	}

	public function get_marksconfig()
	{
		$query = $this->db->query("SELECT * FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	
	
}
