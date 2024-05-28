<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 3);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		$this->perPage = 15;
		
		$this->load->model('Students_model');
		$this->load->library('ajax_pagination');
		$this->load->library('sendmaillib');
		$this->load->helper('custom_string');
	}
	
	public function pending()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_pending_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_pending_students(array('limit'=>$this->perPage));
        $data['get_total'] = $this->Students_model->getTotalPending();
		$data['get_betch'] = $this->Students_model->getBatch();
		
		$this->load->view('students/pending', $data);
	}
	
	public function pending_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_pending_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_pending_students_csvbybatch($batch_id);
        }        		
		$this->load->view('students/panding_csv', $data);
	}

	public function approved_list()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_approve_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_approved_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
         $data['get_total'] = $this->Students_model->getTotalApproved();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_approve_students(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
		
		$this->load->view('students/approved_list', $data);
	}
	
	public function approved_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_approved_students_csv();		
		$this->load->view('students/approved_csv', $data);
	}
	public function approved_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_approved_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_approved_students_csvbybatch($batch_id);
        }        		
		$this->load->view('students/approved_csv', $data);
	}
	
	public function declinepayments_list()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_declinedpayment_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_paymentdeclined_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['get_total'] = $this->Students_model->getDeclinedPaymentCnt();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_declinedpayment_students(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
        /*print_r($data['get_items']);exit;*/
		
		$this->load->view('students/declinepayments', $data);
	}

	public function placement_list()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_placement_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_placement_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_placement_students(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/placement_list', $data);
	}
	
	public function placement_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_placement_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_placement_students_csvbybatch($batch_id);
        }        		
		$this->load->view('students/placement_csv', $data);
	}
	
	public function enrolled()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_enrolled_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_enrolled_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_enrolled_students(array('limit'=>$this->perPage));
		
		$this->load->view('students/enrolled', $data);
	}
	
	public function pchanged()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_changed_phone_numbers());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_changed_phone_numbers';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['get_total'] = count($this->Students_model->get_changed_phone_numbers_total());
        //get the posts data
        $data['get_items'] = $this->Students_model->get_changed_phone_numbers(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/pchanged/enrolled', $data);
	}
	
	public function approve()
	{
		$student_id = $this->input->post('student_id');
		$active_module = $this->Students_model->get_active_module();
		$apprvdate = date("Y-m-d H:i:s");
		$data = array(
					'student_active_module' => $active_module,
					'student_approve_date' => $apprvdate,
					'student_status' => 1,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been approved');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',We are pleased to inform you that your application for admission into CCD Batch-37 of DLP has been approved. We would like to request you to complete the deposit of our course fee (Taka 25,000/-) via the link below :link : '.base_url('student/onboard/payment?SID='.sha1($get_studentinfo['student_entryid']).'&PORT='.sha1($get_studentinfo['student_id']).'&httpRdr=Online&status=pay').' Payment needs to be made by 20th September 2023.';
		$sms = sendsms($phone_number, $message);		
		if( strpos($sms, 'SMS SUBMITTED') !== false ) {
		 $this->Students_model->update_sms_info($student_id);
		}
		$result = array('status' => 'ok' );
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function approve_restored()
	{
		$student_id = $this->input->post('student_id');
		$active_module = $this->Students_model->get_active_module();
		$apprvdate = date("Y-m-d H:i:s");
		$data = array(
					'student_active_module' => $active_module,
					'student_approve_date' => $apprvdate,
					'student_status' => 1,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/email_approverestore', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been approved');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear '.$name.', We are pleased to inform you that, you can complete the deposit of your course fee via the link below. link : '.base_url('student/onboard/payment?SID='.sha1($get_studentinfo['student_entryid']).'&PORT='.sha1($get_studentinfo['student_id']).'&httpRdr=Online&status=pay').' Payment needs to be made by 25th April 2023.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function restored()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/email_restore', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been restored.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear '.$name.', Your id has been restored. Please wait for coordinator to allow you to make payment for the course.';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 0,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function approve_phone_number()
	{
		$student_id = $this->input->post('student_id');
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$data = array(
					'spinfo_personal_phone' => $get_studentinfo['spinfo_personal_phone_updated'],
					'spinfo_personal_phone_updaterqst' => 'NO',
					'spinfo_personal_phone_updated' => null,
				);
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->update('starter_students_personalinfo', $data);
		
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/phone_approved_email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your phone number change request has been approved.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
We are pleased to inform you that your phone number change request has been approved.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function declined()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/declined/email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been declined.');
		$this->sendmaillib->content($body);
		//$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear Candidate, we regret to inform you that your application has been declined.';
		//sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 0,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function payment_verified()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/email_paymentverified', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your payment has been verified');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear Candidate, we are delighted to inform you that your payment has been verified. Please wait to be assigned to batch';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_payment_status' => 1,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function declined_phone_number()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$data = array(
					'spinfo_personal_phone_updaterqst' => 'CANCEL',
					'spinfo_personal_phone_updated' => null,
				);
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->update('starter_students_personalinfo', $data);
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/declined/email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your phone number change request has not been approved.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear Candidate,
We are really sorry to inform you that your phone number change request has been declined.';
		sendsms($phone_number, $message);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public static function delete_dir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
	
	public function delete()
	{
		$student_id = $this->input->post('student_id');
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		/* $body = $this->load->view('students/reject/email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has not been approved.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send(); */
		
		/* $phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear Candidate, we regret to inform you that your application has been rejected.';
		sendsms($phone_number, $message); */
		
		$student_entryid = $this->Students_model->get_student_entryid($student_id);
		
		//delete from academic information
		$this->db->where('sacinfo_student_id', $student_id);
		$this->db->delete('starter_students_academicinfo');
		
		//delete from dlp categories
		$this->db->where('sdc_student_id', $student_id);
		$this->db->delete('starter_students_dlpcategories');
		
		//delete from personal information
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->delete('starter_students_personalinfo');
		
		//delete from professional information
		$this->db->where('spsinfo_student_id', $student_id);
		$this->db->delete('starter_students_professionalinfo');
		
		//delete from specializations
		$this->db->where('ss_student_id', $student_id);
		$this->db->delete('starter_students_specializations');
		
		//delete from lesson has read
		$this->db->where('lessread_user_id', $student_id);
		$this->db->delete('starter_lesson_reading_completed');
		
		//delete from deposit slip
		$this->db->where('deposit_student_entryid', $student_entryid);
		$this->db->delete('starter_deposit_payments');
		
		//delete student directory
		$dir = $_SERVER['DOCUMENT_ROOT'].'/attachments/students/'.$student_entryid;
		if(file_exists($dir))
		{
			$this->delete_dir($dir);
		}
		
		//delete from student table
		$this->db->where('student_id', $student_id);
		$this->db->delete('starter_students');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function rjct_list()
	{
		$student_id = $this->input->post('student_id');
		$note = $this->input->post('note');
		$data = array(					
					'student_status' => 5,
					'student_note' => $note,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/reject/email', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been rejected.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear '.$name.', Your application has been rejected. '.$note;
		sendsms($phone_number, $message);	
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function rejectlist()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_reject_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_reject_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_reject_students(array('limit'=>$this->perPage));
		$data['gettotal'] = $this->Students_model->getTotalRejectStdnt();
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/rejectlist', $data);
	}

	public function rejectlist_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_reject_students_csv();
		
		$this->load->view('students/rejectlist_csv', $data);
	}
	
	public function view()
	{
		$student_id = $this->input->post('student_id');
		$data['item'] = $this->Students_model->get_student_info($student_id);
		$content = $this->load->view('students/view_details', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function approve_sms()
	{
		$student_id = $this->input->post('student_id');
		$info = $this->Students_model->get_student_info($student_id);
		$message = null ;
		$response = null;
		$sms_submit= "SMS not Submitted";
		
		if($info){
		$message = "Dear ".$info['spinfo_first_name'].", your application for CCD Batch-".$info['student_batch']." has been approved. You will get a link within 5 days to deposit course fee. CCD-DLP";
		$response = sendsms($info['spinfo_personal_phone'], $message);
		}
		
		if(strpos($response, "SMS SUBMITTED") !== false){
			$sms_submit= "SMS Submitted";
			$this->Students_model->update_approve_sms($student_id,'0');
		}
		$result = array('status' => 'ok', 'content' => $response, 'submit' => $sms_submit);
		
		echo json_encode($result);
		exit;
	}
	
	public function payment_link()
	{
		$student_id = $this->input->post('student_id');
		$info = $this->Students_model->get_student_info($student_id);
		$message = null ;
		$response = null;
		$sms_submit= "SMS not Submitted";
		
		if($info){
			$message ='Dear '.$info['spinfo_first_name'].', please complete the deposit of CCD course fee (Taka 25,000/-) through the link : '.base_url('student/onboard/payment?SID='.sha1($info['student_entryid']).'&PORT='.sha1($info['student_id']).'&httpRdr=Online&status=pay').' Payment needs to be made by 24 hours. CCD-DLP.';
			$response = sendsms($info['spinfo_personal_phone'], $message);
		}
		
		if(strpos($response, "SMS SUBMITTED") !== false){
			$sms_submit= "SMS Submitted";
			$this->Students_model->update_approve_sms($student_id,'1');
		}
		
		$result = array('status' => 'ok', 'content' => $student_id, 'submit' => $sms_submit);
		
		echo json_encode($result);
		exit;
	}
	
	public function reset_pass()
	{
		$student_id = $this->input->post('student_id');
		$data = $this->Students_model->update_pass($student_id);
		if($data === true){
		$result = array('status' => 'ok', 'content' => $data);
		}else{
			$result = array('status' => 'Network Error, Please Check Your Connection or student password 123456 exist');
		}
		
		echo json_encode($result);
		exit;
	}
	
	public function reset_email()
	{
		$student_id = $this->input->post('student_id');
		$newEmail = $this->input->post('newEmail');
		$data = $this->Students_model->update_email($student_id , $newEmail);
		if($data === true){
		$result = array('status' => 'ok', 'content' => $newEmail);
		}else{
			$result = array('status' => 'Network Error, Please Check Your Connection or student already have '.$newEmail);
		}
		
		echo json_encode($result);
		exit;
	}
	
	public function reset_phone()
	{
		$student_id = $this->input->post('student_id');
		$phone = $this->input->post('phone');
		
		$data = $this->Students_model->update_phone($student_id , $phone);
		if($data === true){
			$result = array('status' => 'ok', 'content' => $phone);
		}else{
			$result = array('status' => 'Network Error, Please Check Your Connection');
		}
		
		echo json_encode($result);
		exit;
	}
	
	public function batch_assing_view()
	{
		$student_id = $this->input->post('student_id');
		$data['item'] = $this->Students_model->get_student_info($student_id);
		$data['betchlist'] = $this->Students_model->get_betch();
		/*print_r($data['item']);exit;*/
		$content = $this->load->view('students/batchassing_view', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function batch_enrolled()
	{
		$student_id = $this->input->post('student_id');
		$batchid = $this->input->post('batchid');

		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		if($get_studentinfo['spinfo_nationality'] == '18')
			{
				$get_format_prefix = 'eCCDBD';
			}else
			{
				$get_format_prefix = 'eK';
			}

		$student_serial_no = $this->Students_model->getTotalEnrolled();
		$counter_digit_stid = str_pad($student_serial_no, 7, '0', STR_PAD_LEFT);
		$student_fnlid = $get_format_prefix.'38'.date('Y').$counter_digit_stid;		

		$data = array(
					'student_rtc' => $batchid,
					'student_enrolled' => 1,
					'student_finalid' => $student_fnlid,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		$batchdtl = $this->Students_model->get_betch_dtl($batchid);
		
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['stid'] = $student_fnlid;
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		/*$data['userid'] = $get_studentinfo['student_entryid'];*/
		$data['userid'] = $get_studentinfo['student_email'];
		$data['pword'] = $get_studentinfo['student_gtp'];
		$data['batchname'] = $batchdtl->batch_name;
		$body = $this->load->view('students/email_batch_assing', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Batch Enrollment');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		/*$message ='Dear '.$name.',You have successfully enrolled into the Online CCD Program in RTC No.'.$batchdtl->batch_name.'.Your student ID: '.$student_fnlid.'. Your login credentials are: Login ID : '.$get_studentinfo['student_email'].' Login Password : '.$get_studentinfo['student_gtp'].' link : '.base_url('student/login').'';*/
		//$message ='Welcome to '.$batchdtl->batch_name.'. Please login to student dashboard from www.dlpbadas-bd.org using the email ID & Password, used during registration. You can start your self-study after logging in.';
		$message ='Welcome to '.$batchdtl->batch_name.' of CCD Batch-38. Please login to student dashboard from www.dlpbadas-bd.org -> Login -> Student using the Email (used during registration) & Password-123456. You can start your self-study after logging in.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function payment_details()
	{
		$student_id = $this->input->post('sid');
		echo $this->__p_details($student_id);
	}
	
	public function __p_details($student_id)
	{
		$online_payments = $this->Students_model->get_onlinepayment_info($student_id);
		$deposit_payments = $this->Students_model->get_depositpayment_info($student_id);
		
		$content = '
			<div class="tab-pane active" id="tab_default_1">
				<div class="near_by_hotel_wrapper">
					<div class="near_by_hotel_container">
					  <table class="table no-border custom_table dataTable no-footer dtr-inline">
						<colgroup>
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="20%">
							<col width="10%">
						</colgroup>
						<thead>
						  <tr>
							<th>Payment</th>
							<th class="text-center">Transaction ID</th>
							<th class="text-center">Transaction Date</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Status</th>
						  </tr>
						</thead>
						<tbody>
						';
						foreach($online_payments as $online):
							$content .= '<tr>';
								$content .= '<td>'.$online['onpay_account'].'</td>';
								$content .= '<td class="text-center">'.$online['onpay_transaction_id'].'</td>';
								$content .= '<td class="text-center">'.date("d F, Y", strtotime($online['onpay_transaction_date'])).'</td>';
								$content .= '<td class="text-center">BDT '.$online['onpay_transaction_amount'].'</td>';
								$content .= '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
							$content .= '</tr>';
						endforeach;
						  
		$content .= '
						</tbody>
					  </table>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab_default_2">
				<div class="near_by_hotel_wrapper">
					<div class="near_by_hotel_container">
					  <table class="table no-border custom_table dataTable no-footer dtr-inline">
						<colgroup>
							<col width="10%">
							<col width="10%">
							<col width="20%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="20%">
						</colgroup>
						<thead>
						  <tr>
							<th>Payment</th>
							<th>Amount</th>
							<th>Bank</th>
							<th class="text-center">Branch</th>
							<th class="text-center">Account Number</th>
							<th class="text-center">Status</th>
							<th class="text-center">Deposit Slip</th>
						  </tr>
						</thead>
						<tbody>
						';
						foreach($deposit_payments as $deposit):
							$content .= '<tr>';
								$content .= '<td style="font-size:16px;">'.$deposit['deposit_payment'].'</td>';
								$content .= '<td style="font-size:16px;">BDT '.$deposit['deposit_amount'].'</td>';
								$content .= '<td style="font-size:16px;">'.$deposit['deposit_bank'].'</td>';
								$content .= '<td class="text-center" style="font-size:16px;">'.$deposit['deposit_branch'].'</td>';
								$content .= '<td class="text-center" style="font-size:16px;">'.$deposit['deposit_account_number'].'</td>';
								if($deposit['deposit_slip_status'] === '0')
								{
									$content .= '<td class="text-center" style="font-size:16px;"><strong style="color:#0aa">Under Review</strong></td>';
								}elseif($deposit['deposit_slip_status'] === '1')
								{
									$content .= '<td class="text-center" style="font-size:16px;"><strong style="color:#0a0">Paid</strong></td>';
								}elseif($deposit['deposit_slip_status'] === '2')
								{
									$content .= '<td class="text-center" style="font-size:16px;"><strong style="color:#F00">Unpaid</strong></td>';
								}
								$content .= '<td class="text-center" style="font-size:16px;"><a href="'.attachment_url('students/'.$student_id.'/'.$deposit['deposit_slip_file']).'" target="_blank"><i class="fa fa-eye"></i> View</a></td>';
							$content .= '</tr>';
						endforeach;
			$content .= '
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		';
		
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
		
	}
	
	public function pending_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_pending_students_csv();
		
		$this->load->view('students/panding_csv', $data);
	}
	
	public function enrolled_batch()
	{
		
		$data = array();
		$data['betchlist'] = $this->Students_model->get_betch();
		$data['get_total'] = $this->Students_model->getTotalEnrlStdnt();
		$data['get_items'] = $this->Students_model->get_enrolled_students_all();
		$this->load->view('students/enrolled/enrolled_index', $data);
	}

	public function enrolled_student_bybatch($id)
	{
		$data = array();
		$data['betchlist'] = $this->Students_model->get_betch();
        $data['batchdtl'] = $this->Students_model->get_betch_dtl($id);
		$data['get_items'] = $this->Students_model->get_enrolled_students_batch($id);
		$data['get_faculty'] = $this->Students_model->get_teacher_batch($id);
		$this->load->view('students/enrolled/index', $data);
	}
	
	public function rtcchange_list()
	{
		
        $data = array();
		$data['betchlist'] = $this->Students_model->get_betch();
        /*$data['batchdtl'] = $this->Students_model->get_betch_dtl($id);*/
		$data['get_items'] = $this->Students_model->get_rtc_change_students();
		/*$data['get_faculty'] = $this->Students_model->get_teacher_batch($id);*/
		
		$this->load->view('students/enrolled/change_index', $data);
	}
	
	public function update_pass_and_gmail()
	{
		
        $data = array();
		//$data['betchlist'] = $this->Students_model->get_betch();
		$data['get_total'] = $this->Students_model->getTotalEnrlStdnt();
		$data['get_items'] = $this->Students_model->get_enrolled_students_all();
		$this->load->view('students/enrolled/update_pass_and_email', $data);
	}
	public function rtcchange_csv()
	{
        $data = array();
		$data['betchlist'] = $this->Students_model->get_betch();
		$data['get_items'] = $this->Students_model->get_rtc_change_students();
		$this->load->view('students/enrolled/rtc_change_csv', $data);
	}

	public function stdntbybatch_csv($id)
	{
		$data = array();
        //get the posts data
        $data['batchdtl'] = $this->Students_model->get_betch_dtl($id);
		$data['get_items'] = $this->Students_model->get_enrolled_students_batch_csv($id);
		$this->load->view('students/enrolled/enrolled_csv', $data);
	}
	
	public function stdnt_csvbybatch($id)/* batch wise csv */
	{
		$data = array();
        //get the posts data
        $data['batchdtl'] = $id;
		$data['get_items'] = $this->Students_model->get_enrolled_csvbybatch($id);
		$this->load->view('students/enrolled/batchwisestudent_csv', $data);
	}
	
	public function study_details_csv($id)
	{
		$data = array();
        //get the posts data
        $data['batchdtl'] = $this->Students_model->get_betch_dtl($id);
		$data['get_items'] = $this->Students_model->get_enrolled_students_batch($id);
		$data['get_marksconfig'] = $this->Students_model->get_marksconfig();
		$this->load->view('students/enrolled/studyinfo_csv', $data);
	}
	
	public function rtc_transfer_view()
	{
		$student_id = $this->input->post('student_id');
		$data['item'] = $this->Students_model->get_student_info($student_id);
		$data['betchlist'] = $this->Students_model->get_betch();
		/*print_r($data['item']);exit;*/
		$content = $this->load->view('students/enrolled/rtc_transfer_view', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function rtc_transfer_view_std()
	{
		$student_id = $this->input->post('student_id');
		$data['item'] = $this->Students_model->get_student_info($student_id);
		$data['betchlist'] = $this->Students_model->get_betch();
		$data['shiftid'] = $this->input->post('shift_id');
		/*print_r($data['item']);exit;*/
		$content = $this->load->view('students/enrolled/trc_transfer_view_std', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function rtc_transferred()
	{
		$student_id = $this->input->post('student_id');
		$batchid = $this->input->post('batchid');

		$get_studentinfo = $this->Students_model->get_student_info($student_id);

		$olddata = array( 
			'student_id' => $student_id,
			'old_rtc' => $get_studentinfo['student_rtc'],
			'transferred_rtc' => $batchid,
		 );

		$this->Students_model->transfet_history_insert($olddata);

		$data = array(
					'student_rtc' => $batchid
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		$batchdtl = $this->Students_model->get_betch_dtl($batchid);
		
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['stid'] = $student_fnlid;
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		/*$data['userid'] = $get_studentinfo['student_entryid'];*/
		$data['userid'] = $get_studentinfo['student_email'];
		$data['pword'] = $get_studentinfo['student_gtp'];
		$data['batchname'] = $batchdtl->batch_name;
		/* $body = $this->load->view('students/enrolled/email_rtc_transfer', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('RTC Transferred');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send(); */
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		/* $message ='Dear '.$name.',Your RTC was transferred. Current RTC No.'.$batchdtl->batch_name;
		sendsms($phone_number, $message);	 */	
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function rtc_transferredby_student()
	{
		$student_id = $this->input->post('student_id');
		$batchid = $this->input->post('batchid');
		$shiftid = $this->input->post('sift_id');

		$get_studentinfo = $this->Students_model->get_student_info($student_id);

		$olddata = array( 
			'student_id' => $student_id,
			'old_rtc' => $get_studentinfo['student_rtc'],
			'transferred_rtc' => $batchid,

		 );

		$this->Students_model->transfet_history_insert($olddata);

		$data = array(
					'student_rtc' => $batchid
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		$batchdtl = $this->Students_model->get_betch_dtl($batchid);

		$shiftdata = array(
					'shift_stutus' => 1,
					'shifted_rtc' => $batchid
				);
		$this->db->where('shift_id', $shiftid);
		$this->db->update('starter_rtc_shift', $shiftdata);
		
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['stid'] = $student_fnlid;
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		/*$data['userid'] = $get_studentinfo['student_entryid'];*/
		$data['userid'] = $get_studentinfo['student_email'];
		$data['pword'] = $get_studentinfo['student_gtp'];
		$data['batchname'] = $batchdtl->batch_name;
		/* $body = $this->load->view('students/enrolled/email_rtc_transfer', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('RTC Transferred');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send(); */
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		/* $message ='Dear '.$name.',Your RTC was transferred. Current RTC No.'.$batchdtl->batch_name;
		sendsms($phone_number, $message); */		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function student_blocked()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/enrolled/email_blocked', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been blocked.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Please be advised that you have been temporarily  blocked from the course. Please contact course administration or wait for course administration to unblock the course.';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 2,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);

		$olddata = array( 
			'student_id' => $student_id,
		 );

		$this->Students_model->blocked_history_insert($olddata);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function student_dropout()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/enrolled/email_blocked', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been Dropout.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Please be advised that your course progress has been disabled as you have opted to drop-out from the batch. If you wish to progress please contact course administration';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 3,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);

		$olddata = array( 
			'student_id' => $student_id,
		 );

		$this->Students_model->dropout_history_insert($olddata);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function student_unblocked()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/enrolled/email_unblocked', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been Unblocked.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Your application has been Unblocked.';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 1,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	public function student_undropout()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/enrolled/email_unblocked', $data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been Undroped.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Your application has been Undroped.';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 1,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function enrolled_dropout()
	{
		
		$data = array();
		$data['betchlist'] = $this->Students_model->get_betch();
		$data['get_total'] = $this->Students_model->get_enrolled_students_dropout();
		$data['get_items'] = $this->Students_model->get_enrolled_students_dropout();
		$this->load->view('students/enrolled/dropout_index', $data);
	}

	public function enrolled_blocked()
	{
		
		$data = array();
		$data['betchlist'] = $this->Students_model->get_betch();
		$data['get_total'] = $this->Students_model->get_enrolled_students_blocked();
		$data['get_items'] = $this->Students_model->get_enrolled_students_blocked();
		$this->load->view('students/enrolled/dropout_index', $data);
	}
	
	public function study_details()
	{
		$student_id = $this->input->post('student_id');
		$data['studentid'] = $this->input->post('student_id');
		$data['mdlread'] = $this->Students_model->get_phase1mdlopn($student_id, 1);
		$data['ttlph1mdl'] = $this->Students_model->get_totalmodul(1);

		$data['mdlread2'] = $this->Students_model->get_phase1mdlopn($student_id, 2);
		$data['ttlph2mdl'] = $this->Students_model->get_totalmodul(2);

		$data['mdlread3'] = $this->Students_model->get_phase1mdlopn($student_id, 3);
		$data['ttlph3mdl'] = $this->Students_model->get_totalmodul(3);

		/*print_r($data['item']);exit;*/
		$content = $this->load->view('students/enrolled/student_details', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function needdelete()
	{
		$data = array();        
        //total rows count
        $totalRec = count($this->Students_model->get_wantdelete_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_wantdelete_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_wantdelete_students(array('limit'=>$this->perPage));
        $data['get_total'] = $this->Students_model->getTotalDlt();
        $data['get_betch'] = $this->Students_model->getBatch();
		
		$this->load->view('students/delete_list', $data);
	}
	
	function certificate_download($id,$code,$fid)
	 {
	  $this->load->library('zip');
	  $item = $this->Students_model->get_student_info($id);
	  $pimg = 'attachments/students/'.$code.'/'.$item['spinfo_photo'];
	  $nid = 'attachments/students/'.$code.'/'.$item['spinfo_national_photo'];
	  $bmdc = 'attachments/students/'.$code.'/'.$item['spsinfo_bmanddc_certificate'];
	  $certificate = $this->Students_model->get_academicinformation($id);	   
	   foreach($certificate as $image)
	   {
	   	$imgurl = 'attachments/students/'.$code.'/'.$image['sacinfo_certificate'];
	    $this->zip->read_file($imgurl);
	   }
	   $this->zip->read_file($nid);
	   $this->zip->read_file($pimg);
	   $this->zip->read_file($bmdc);
	   /* $path = 'attachments/students/'.$code.'/';
		$this->zip->read_dir($path, FALSE); */
	   $this->zip->download(''.$fid.'.zip');
	  
	 }
	
}