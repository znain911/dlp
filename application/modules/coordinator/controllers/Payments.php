<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 5);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		$this->perPage = 15;
		
		$this->load->model('Payments_model');
		$this->load->library('ajax_pagination');
		$this->load->library('sendmaillib');
	}
	
	public function online()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Payments_model->count_onlinepayment_info());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Payments_model->get_onlinepayment_info(array('limit'=>$this->perPage));
        $data['get_betch'] = $this->Payments_model->getBatch();
		$this->load->view('payments/online', $data);
	}

	public function online_csv()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Payments_model->count_onlinepayment_info());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Payments_model->get_onlinepayment_info(array('limit'=>$this->perPage));
		$this->load->view('payments/online_csv', $data);
	}

	public function online_detail_csv()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Payments_model->count_onlinepayment_info());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Payments_model->get_onlinepayment_detail_info(array('limit'=>$this->perPage));
		$this->load->view('payments/online-detail_csv', $data);
	}
	public function online_detail_csvbatch($batch_id)
	{
		$data = array();
        
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Payments_model->get_onlinepayment_detail_info();
        }else{
        	$data['batchname'] = $batch_id;
        	//get the posts data
        	$data['get_items'] = $this->Payments_model->get_onlinepayment_detail_infobatch($batch_id);
        } 
		$this->load->view('payments/online-detail_csv', $data);
	}

	
	public function deposit()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Payments_model->count_depositpayment_info();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Payments_model->get_depositpayment_info(array('limit'=>$this->perPage));
        $data['get_betch'] = $this->Payments_model->getBatch();
		$this->load->view('payments/deposit', $data);
	}

	public function deposit_csv()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Payments_model->count_depositpayment_info();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Payments_model->get_depositpayment_info(array('limit'=>$this->perPage));
		$this->load->view('payments/deposit_csv', $data);
	}

	public function deposit_detail_csv()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Payments_model->count_depositpayment_info();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Payments_model->get_depositpayment_detail_info(array('limit'=>$this->perPage));
		$this->load->view('payments/deposit-detail_csv', $data);
	}

	public function deposit_detail_csvbatch($batch_id)
	{
		$data = array();
        
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Payments_model->get_depositpayment_detail_info();
        }else{
        	$data['batchname'] = $batch_id;
        	//get the posts data
        	$data['get_items'] = $this->Payments_model->get_depositpayment_detail_infobatch($batch_id);
        } 
		$this->load->view('payments/deposit-detail_csv', $data);
	}
	
	public function transaction()
	{
		$this->load->view('payments/transaction');
	}
	
	public function spaid()
	{
		$entryid = $this->input->post('sid');
		$student_id = $this->input->post('student_id');
		
		//update student table
		$this->db->where('student_entryid', $entryid);
		$this->db->update('starter_students', array('student_enrolled' => 0, 'student_payment_status' => 2));
		
		//update deposit payment table
		$this->db->where('deposit_student_entryid', $entryid);
		$this->db->update('starter_deposit_payments', array('deposit_slip_status' => 1));
		
		$get_studentinfo = $this->Payments_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('payments/email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been approved');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear '.$name.',Congratulations you have enrolled to the CCD Course. Please check your email or go to the ECCD Website and login using your username and password.';
		sendsms($phone_number, $message);
		
		$content = '<strong style="color:#0a0">Paid</strong>';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sunpaid()
	{
		$entryid = $this->input->post('sid');
		
		//update student table
		$this->db->where('student_entryid', $entryid);
		$this->db->update('starter_students', array('student_enrolled' => 0));
		
		//update deposit payment table
		$this->db->where('deposit_student_entryid', $entryid);
		$this->db->update('starter_deposit_payments', array('deposit_slip_status' => 2));
		
		$content = '<strong style="color:#F00">Unpaid</strong>';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}