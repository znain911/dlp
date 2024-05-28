<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student !== NULL && $studentLogin === TRUE)
		{
			redirect('student/dashboard', 'refresh', true);
		}
		
		$this->load->model('Login_model');
		$this->load->library('sendmaillib');
	}
	
	public function index()
	{
		$this->load->view('login');
	}
	
	public function forget()
	{
		$this->load->view('forget_password');
	}
	
	//check user's login credentials
	public function checkuser()
	{	
		//load form validation library
		$this->load->library('form_validation');
		
		$email_or_id = html_escape($this->input->post('email_or_id'));
		if(is_numeric($email_or_id))
		{
			$student_entryid = $email_or_id;
			$password = sha1(html_escape($this->input->post('password')));
			$validate = array(
							array(
								'field' => 'email_or_id',
								'label' => 'Email Or ID',
								'rules' => 'required|trim'
							),
							array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim'
							),
						);
			$this->form_validation->set_rules($validate);
			if($this->form_validation->run() == true)
			{
				$isExitEmail = $this->Login_model->check_id_credential($student_entryid, $password);
				if($isExitEmail == true)
				{
					$isRtcActive = $this->Login_model->get_activertc($isExitEmail->student_rtc);
					if ($isRtcActive == true) {
						$warning_alert = '<div class="alert alert-warning" role="alert">Dear Student, you have completed CCD Batch 32. As of today, 26th August 2021, you will not be able to login to the CCD Course Management Software. We wish you a successful journey in your life and profession. Please continue checking the DLP website https://www.dlpbadas-bd.org/ for ECE Result and future course updates.</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else{
					//Check user status (active OR deactive, Blocked or Dropout or Rejected)
					if($isExitEmail->student_status == '0')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '2')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Please be advised that you have been temporarily  blocked from the course. Please contact course administration or wait for course administration to unblock the course.</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '3')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Please be advised that your course progress has been disabled as you have opted to drop-out from the batch. If you wish to progress please contact course administration</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '5')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is  rejected</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '1' && $isExitEmail->student_enrolled == '0' && $isExitEmail->student_payment_status == '0'){
						$warning_alert = '<div class="alert alert-warning" role="alert">Please at first pay your course fee! <a href="'.base_url('student/onboard/payment?SID='.sha1($isExitEmail->student_entryid).'&PORT='.sha1($isExitEmail->student_id).'&httpRdr=Online&status=pay').'" style="color:#F00"><strong>Click here pay now</strong></a></div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '1' && $isExitEmail->student_enrolled == '0' && $isExitEmail->student_payment_status == '2'){
						$warning_alert = '<div class="alert alert-warning" role="alert">Please wait for your payment varificationt</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '1' && $isExitEmail->student_enrolled == '0' && $isExitEmail->student_payment_status == '1'){
						$warning_alert = '<div class="alert alert-warning" role="alert">Your payment is Verified. Please for Enrollment</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else{
						$show_last['last_login_time'] = $isExitEmail->student_last_login;
						$this->session->set_userdata($show_last);
						$logg['student_login_ip'] = $this->input->ip_address();
						$logg['student_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_student($isExitEmail->student_id, $logg);
						if($isExitEmail->spinfo_middle_name)
						{
							$full_name = $isExitEmail->spinfo_first_name.' '.$isExitEmail->spinfo_middle_name.' '.$isExitEmail->spinfo_last_name;
						}else
						{
							$full_name = $isExitEmail->spinfo_first_name.' '.$isExitEmail->spinfo_last_name;
						}
						$activate['full_name'] = $full_name;
						$activate['active_student'] = $isExitEmail->student_id;
						$activate['active_module'] = $isExitEmail->student_active_module;
						$activate['active_phase'] = $isExitEmail->student_phaselevel_id;
						$activate['student_reg_date'] = $isExitEmail->student_regdate;
						$activate['studentLogin'] = TRUE;
						$this->session->set_userdata($activate);
						$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
						$result = array("status" => "ok", "success" => $success_alert);
						echo json_encode($result);
						exit;
					}
					}
				}else
				{
					$error_alert = '<div class="alert alert-danger" role="alert">Email Or Password incorrect!</div>';
					$result = array("status" => "failed_error", "error" => $error_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
					echo json_encode($result);
					exit;
				}
			}else
			{
				$error_alert = '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
				$result = array("status" => "valid_error", "validation_error" => $error_alert);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}else
		{
			$student_email = $email_or_id;
			$password = sha1(html_escape($this->input->post('password')));
			$validate = array(
							array(
								'field' => 'email_or_id',
								'label' => 'Email Or ID',
								'rules' => 'required|trim|valid_email'
							),
							array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim'
							),
						);
			$this->form_validation->set_rules($validate);
			if($this->form_validation->run() == true)
			{
				$isExitEmail = $this->Login_model->check_credential($student_email, $password);
				if($isExitEmail == true)
				{
					$isRtcActive = $this->Login_model->get_activertc($isExitEmail->student_rtc);
					if ($isRtcActive == true) {
						$warning_alert = '<div class="alert alert-warning" role="alert">Dear Student, you have completed CCD Batch 32. As of today, 26th August 2021, you will not be able to login to the CCD Course Management Software. We wish you a successful journey in your life and profession. Please continue checking the DLP website https://www.dlpbadas-bd.org/ for ECE Result and future course updates.</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else{
					//Check user status (active OR deactive, Blocked or Dropout or Rejected)
					if($isExitEmail->student_status == '0')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '2')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Please be advised that you have been temporarily  blocked from the course. Please contact course administration or wait for course administration to unblock the course.</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '3')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Please be advised that your course progress has been disabled as you have opted to drop-out from the batch. If you wish to progress please contact course administration</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '5')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is  rejected</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '1' && $isExitEmail->student_enrolled == '0' && $isExitEmail->student_payment_status == '0'){
						$warning_alert = '<div class="alert alert-warning" role="alert">Please at first pay your course fee! <a href="'.base_url('student/onboard/payment?SID='.sha1($isExitEmail->student_entryid).'&PORT='.sha1($isExitEmail->student_id).'&httpRdr=Online&status=pay').'" style="color:#F00"><strong>Click here pay now</strong></a></div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '1' && $isExitEmail->student_enrolled == '0' && $isExitEmail->student_payment_status == '2'){
						$warning_alert = '<div class="alert alert-warning" role="alert">Please wait for your payment varificationt</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}elseif($isExitEmail->student_status == '1' && $isExitEmail->student_enrolled == '0' && $isExitEmail->student_payment_status == '1'){
						$warning_alert = '<div class="alert alert-warning" role="alert">Your payment is Verified. Please wait for Enrollment</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else{
						$show_last['last_login_time'] = $isExitEmail->student_last_login;
						$this->session->set_userdata($show_last);
						$logg['student_login_ip'] = $this->input->ip_address();
						$logg['student_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_student($isExitEmail->student_id, $logg);
						if($isExitEmail->spinfo_middle_name)
						{
							$full_name = $isExitEmail->spinfo_first_name.' '.$isExitEmail->spinfo_middle_name.' '.$isExitEmail->spinfo_last_name;
						}else
						{
							$full_name = $isExitEmail->spinfo_first_name.' '.$isExitEmail->spinfo_last_name;
						}
						$activate['full_name'] = $full_name;
						$activate['active_student'] = $isExitEmail->student_id;
						$activate['active_module'] = $isExitEmail->student_active_module;
						$activate['active_phase'] = $isExitEmail->student_phaselevel_id;
						$activate['student_reg_date'] = $isExitEmail->student_regdate;
						$activate['studentLogin'] = TRUE;
						$this->session->set_userdata($activate);
						$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
						$result = array("status" => "ok", "success" => $success_alert);
						echo json_encode($result);
						exit;
					}
					}
				}else
				{
					$error_alert = '<div class="alert alert-danger" role="alert">Email Or Password incorrect!</div>';
					$result = array("status" => "failed_error", "error" => $error_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
					echo json_encode($result);
					exit;
				}
			}else
			{
				$error_alert = '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
				$result = array("status" => "valid_error", "validation_error" => $error_alert);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
	}
	
	//recover lost password
	public function recover()
	{
		$this->load->view('recover');
	}
	
	//Send email with reset code
	public function checkemail()
	{
		$email = html_escape($this->input->post('email'));
		$check_email = $this->Login_model->check_exist_email($email);
		if($check_email == true){
			
			$resetdigit = rand(132949,999999);
			$data['student_password_resetcde'] = sha1($resetdigit);
			$message_subject = "Your Password Reset Code";
			$rest['subject'] = $message_subject;
			$rest['student_info'] = $check_email;
			$rest['reset_code'] = 'Your password reset code is - '.$resetdigit;
			$body = $this->load->view('preset_email', $rest, true);
			$this->Login_model->update_reset_code($check_email->student_id, $data);
			
			$this->sendmaillib->from('info@dldchc-badas.org.bd');
			$this->sendmaillib->to($check_email->student_email);
			$this->sendmaillib->subject($message_subject);
			$this->sendmaillib->content($body);
			$this->sendmaillib->send();
			
			$sess['reset_success'] = TRUE;
			$sess['gt_wnr'] = $check_email->student_id;
			$this->session->set_userdata($sess);
			$result = array("status" => "ok");
			echo json_encode($result);
			exit;
			
		}else
		{
			$error_message = '<div class="alert alert-danger">Email is incorrect!</div>';
			$result = array("status" => "error", "error_message" => $error_message);
			echo json_encode($result);
			exit;
		}
	}
	
	//load reset form
	public function resetform()
	{
		if($this->session->userdata('reset_success') !== TRUE)
		{
			redirect('student/login/forget');
		}else
		{
			$this->load->view('reset_code');
		}
	}
	
	//check reset code
	public function checkcode()
	{
		$reset_code = sha1(html_escape($this->input->post('resetcd')));
		$user_id = $this->session->userdata('gt_wnr');
		$result = $this->Login_model->check_resetcode($reset_code, $user_id);
		if($result == true)
		{
			$data['student_password_resetcde'] = null;
			$this->Login_model->update_reset_code($result->student_id, $data);
			$sess['code_success'] = TRUE;
			$this->session->set_userdata($sess);
			$jsresult = array("status" => "ok");
			echo json_encode($jsresult);
			exit;
		}else
		{
			$error_alert = '<div class="alert alert-danger" role="alert">Sorry! The reset code is wrong.</div>';
			$jsresult = array("status" => "notok", "error" => $error_alert);
			echo json_encode($jsresult);
			exit;
		}
	}
	
	//load new password form
	public function newpassword()
	{
		if($this->session->userdata('code_success') !== TRUE)
		{
			redirect('student/login/resetform');
		}else
		{
			$this->load->view('resetform');
		}
	}
	
	//update password
	public function update_password()
	{
		$data['student_password'] = sha1(html_escape($this->input->post('password')));
		$student_id = $this->session->userdata('gt_wnr');
		$this->Login_model->update_password($student_id, $data);
		$sess['updt_scss'] = TRUE;
		$this->session->set_userdata($sess);
		$result = array("status" => "ok");
		echo json_encode($result);
		exit;
	}
	
	// password reset success.
	public function success()
	{
		if($this->session->userdata('updt_scss') !== TRUE)
		{
			redirect('smartadmin/newpassword');
		}else
		{
			$this->session->unset_userdata('reset_success');
			$this->session->unset_userdata('gt_wnr');
			$this->session->unset_userdata('code_success');
			$this->session->unset_userdata('updt_scss');
			$this->load->view('success');
		}
	}
	
	
}