<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	private $perPage;
	
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
		$this->perPage = 10;
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 6);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Discussion_model');
		$this->load->model('Discussion_with_faculty_model');
		$this->load->model('Discussion_with_student_model');
		$this->load->library('ajax_pagination');
		$this->load->helper('custom_string');
	}
	
	/**************************/
	/*******START FACULTIES CHAT********/
	/**************************/
	
	public function withfaculty()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Discussion_model->count_all_discussion_with_faculties();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'discussapi/get_discussions_with_faculties';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Discussion_model->get_all_discussion_with_faculties(array('limit'=>$this->perPage));
		
		$this->load->view('discussion/withfaculty', $data);
	}
	
	public function get_discussion_with_faculties_replyes()
	{
		$discuss_id = $this->input->post('discuss_id');
		$data['discuss_id'] = $discuss_id;
		$content = $this->load->view('discussion/withfaculty/content', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
		
	}
	
	public function get_discussion_with_students_replyes()
	{
		$discuss_id = $this->input->post('discuss_id');
		$data['discuss_id'] = $discuss_id;
		$content = $this->load->view('discussion/withstudent/content', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
		
	}
	
	public function withstudent()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Discussion_model->count_all_discussion_with_students();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'discussapi/get_discussions_with_students';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Discussion_model->get_all_discussion_with_students(array('limit'=>$this->perPage));
		
		$this->load->view('discussion/withstudent', $data);
	}
	
	
	public function conversation_between_candf()
	{
		echo $this->__get_conversation_coordinator();
		exit;
	}
	
	public function __get_conversation_coordinator()
	{
		$data['chat_id'] = $this->session->userdata('selchat');
		$content = $this->load->view('discussion/faculties_chat', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_conversationby_student()
	{
		$data['teacher_id'] = $this->input->post('faculty');
		$data['dsp_conversation'] = TRUE;
		$content = $this->load->view('discussion/faculties_chat', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
