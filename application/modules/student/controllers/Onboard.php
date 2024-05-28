<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onboard extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Registration_model');
		$this->load->library('sendmaillib');
	}
	
	public function index()
	{
		redirect(base_url('student/onboard/account'), 'refresh', true);
	}
	
	public function account()
	{
		if($this->session->userdata('account_completed') === TRUE)
		{
			redirect('student/onboard/personal', 'refresh', true);
		}else{
			$data['template'] = 'account';
			$this->load->view('registration', $data);
		}
	}
	
	public function personal()
	{
		if($this->session->userdata('account_completed') === TRUE)
		{
			if($this->session->userdata('personal_completed') === TRUE)
			{
				redirect('student/onboard/academic', 'refresh', true);
			}else
			{
				$data['template'] = 'personal';
				$this->load->view('registration', $data);
			}
		}else
		{
			redirect('student/onboard/account', 'refresh', true);
		}
	}
	
	public function academic()
	{
		if($this->session->userdata('personal_completed') === TRUE)
		{
			if($this->session->userdata('academic_completed') === TRUE)
			{
				redirect('student/onboard/approval', 'refresh', true);
			}else{
				$data['template'] = 'academic';
				$this->load->view('registration', $data);
			}
		}else
		{
			redirect('student/onboard/personal', 'refresh', true);
		}
	}
	
	public function approval()
	{
		if($this->session->userdata('academic_completed') === TRUE)
		{
			//unset session data
			$this->session->unset_userdata('wizard_username');
			$this->session->unset_userdata('wizard_student_id');
			$this->session->unset_userdata('account_completed');
			$this->session->unset_userdata('personal_completed');
			$this->session->unset_userdata('academic_completed');
			
			$data['template'] = 'approval';
			$this->load->view('registration', $data);
		}else
		{
			redirect('student/onboard/academic', 'refresh', true);
		}
	}
	
	public function payment()
	{
		if(isset($_GET['PORT']) && $_GET['PORT'] !== '' && isset($_GET['SID']) && $_GET['SID'] !== '')
		{
			$data['template'] = 'payment';
			$this->load->view('registration', $data);
		}else
		{
			redirect('not-found');
		}
	}
	public function applicant_type()
	{
		
	  $value = $this->input->post('value');
	  $st_id = $this->input->post('st_id');
	  $this->Registration_model->update_applicant_type($value,$st_id);
	$result = array('status' => $value);
		
		echo json_encode($result);
		exit;
	}
	
	public function cancel()
	{
		$data['template'] = 'payment_cancel';
		$this->load->view('registration', $data);
	}
	
	public function success()
	{
		if(isset($_GET['type']) && $_GET['type'] == 'deposit' && isset($_GET['SID']) && $_GET['SID'] !== '')
		{
			//$student_id = $this->session->userdata('p_user');
			$student_portid = html_escape($_GET['SID']);
			$get_studentinfo = $this->Registration_model->student_basic_info($student_portid);
			$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
			//Send email
			$email_data['get_studentinfo'] = $get_studentinfo;
			$email_data['full_name'] = $name;
			$body = $this->load->view('regflow/email_deposit', $email_data, true);
			
			$this->sendmaillib->from('info@dldchc-badas.org.bd');
			$this->sendmaillib->to($get_studentinfo['student_email']);
			$this->sendmaillib->subject('Payment successful');
			$this->sendmaillib->content($body);
			$this->sendmaillib->send();
			
			$phone_number = $get_studentinfo['spinfo_personal_phone'];
			$message ='Dear '.$name.',Thanks for uploading your deposit slip. The deposit slip is now under review. We will contact you shortly';
			sendsms($phone_number, $message);
			
			
			$data['template'] = 'payment_success';
			$this->load->view('registration', $data);
		}elseif(isset($_GET['type']) && $_GET['type'] == 'online' && isset($_GET['SID']) && $_GET['SID'] !== ''){
			//$student_id = $this->session->userdata('p_user');
			$student_portid = html_escape($_GET['SID']);
			$get_studentinfo = $this->Registration_model->student_basic_info($student_portid);
			$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
			//Send email
			$email_data['get_studentinfo'] = $get_studentinfo;
			$email_data['full_name'] = $name;
			$body = $this->load->view('regflow/email', $email_data, true);
			
			$this->sendmaillib->from('info@dldchc-badas.org.bd');
			$this->sendmaillib->to($get_studentinfo['student_email']);
			$this->sendmaillib->subject('Payment successful');
			$this->sendmaillib->content($body);
			$this->sendmaillib->send();
			
			$phone_number = $get_studentinfo['spinfo_personal_phone'];
			$message ='Dear '.$name.',Congratulations. Your Payment has been successful. You will be notified after assigning you to a RTC.';
			sendsms($phone_number, $message);
			
			
			$data['template'] = 'payment_success';
			$this->load->view('registration', $data);	
		}else
		{
			redirect('not-found');
		}
	}
	
}