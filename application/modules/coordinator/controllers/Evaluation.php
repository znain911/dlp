<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_user = $this->session->userdata('active_user');
		$userLogin = $this->session->userdata('userLogin');
		if($active_user === NULL && $userLogin !== TRUE)
		{
			redirect('coordinator/login', 'refresh', true);
		}
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 14);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Evaluation_model');
		$this->load->helper('custom_string');
		$this->perPage = 10;
		$this->load->library('ajax_pagination');
	}
	
	public function index()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'Students'){
			
			$data = array();
        
			//total rows count
			$totalRec = $this->Evaluation_model->count_evaluations_by_faculties();
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'evalapi/get_coordinator_evaluations_by_students';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			$data['betchlist'] = $this->Evaluation_model->get_betch();
			//get the posts data
			$data['get_items'] = $this->Evaluation_model->get_evaluations_by_faculties(array('limit'=>$this->perPage));
			$this->load->view('evaluation/evaluation_students', $data);
			
		}elseif(isset($_GET['type']) && $_GET['type'] === 'Faculties'){
		
			$data = array();
        
			//total rows count
			$totalRec = $this->Evaluation_model->count_evaluations_by_studentid();
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'evalapi/get_coordinator_evaluations_by_students';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			$data['betchlist'] = $this->Evaluation_model->get_betch();
			//get the posts data
			$data['get_items'] = $this->Evaluation_model->get_evaluations_by_studentid(array('limit'=>$this->perPage));
			$this->load->view('evaluation/evaluation_faculties', $data);
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function rtcwiseevaluation($rtc)
	{
		$data = array();
        
			//total rows count
			$totalRec = $this->Evaluation_model->count_evaluations_by_rtc($rtc);
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'evalapi/get_coordinator_evaluations_by_rtc';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);

			$data['betchlist'] = $this->Evaluation_model->get_betch();
			$data['batchdtl'] = $this->Evaluation_model->get_betch_dtl($rtc);
			//get the posts data
			$data['get_items'] = $this->Evaluation_model->get_evaluations_by_rtc($rtc);
			$this->load->view('evaluation/evaluation_faculties_rtc', $data);
	}
	
	public function rtcwiseevaluationstdnt($rtc)
	{
		$data = array();
        
			//total rows count
			$totalRec = $this->Evaluation_model->count_evaluations_by_faculties();
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'evalapi/get_coordinator_evaluations_by_students';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			$data['betchlist'] = $this->Evaluation_model->get_betch();
			$data['batchdtl'] = $this->Evaluation_model->get_betch_dtl($rtc);
			//get the posts data
			$data['get_items'] = $this->Evaluation_model->get_evaluations_by_facultiesrtc($rtc);
			$this->load->view('evaluation/evaluation_students_rtc', $data);
	}
	
	public function view()
	{
		$data['evaluation_id'] = $this->input->post('evaluation');
		$content = $this->load->view('evaluation/view_evaluation', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function view_center_faculties()
	{
		$data['booking_schedule_centerid'] = $this->input->post('centerschdl_id');
		$data['booking_type']              = $this->input->post('booking_type');
		$content = $this->load->view('evaluation/view_center_faculties', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function view_multiple_faculties()
	{
		$data['booking_schedule_centerid'] = $this->input->post('centerschdl_id');
		$data['booking_type']              = $this->input->post('booking_type');
		$data['student_id']                = $this->input->post('student_id');
		$content = $this->load->view('evaluation/view_multiple_faculties', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function facultyview()
	{
		$data['evaluation_id'] = $this->input->post('evaluation');
		$content = $this->load->view('evaluation/view_evaluation_faculties', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function del_evaluation()
	{
		$evaluation_id = $this->input->post('evaluation');
		
		//delete ratings
		$this->db->where('rating_evaluation_id', $evaluation_id);
		$this->db->delete('starter_evaluation_ratings');
		
		//delete evaluation
		$this->db->where('evaluation_id', $evaluation_id);
		$this->db->delete('starter_user_evaluations');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function eval_csv($rtc)
	{
        $data = array();
        $data['betchlist'] = $this->Evaluation_model->get_betch();
		$data['batchdtl'] = $this->Evaluation_model->get_betch_dtl($rtc);
		$data['rtcid'] = $rtc;
		//get the posts data
		$data['get_items'] = $this->Evaluation_model->get_evaluations_by_rtc_csv($rtc);
		$this->load->view('evaluation/faculty_csv', $data);
	}
	
	
}
