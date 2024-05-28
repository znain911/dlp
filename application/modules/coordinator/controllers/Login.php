<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_user = $this->session->userdata('active_user');
		$userLogin = $this->session->userdata('userLogin');
		if($active_user !== NULL && $userLogin === TRUE)
		{
			redirect('coordinator/dashboard', 'refresh', true);
		}
		
		$this->load->model('Login_model');
		$this->load->library('sendmaillib');
	}
	
	public function index()
	{
		$this->load->view('login');
		/*$this->load->view('maintenance');*/
	}
	
	public function forget()
	{
		$this->load->view('login_forget');
	}
	
	//check user's login credentials
	public function checkadmin()
	{	
		//load form validation library
		$this->load->library('form_validation');
		
		$email = html_escape($this->input->post('email'));
		$password = sha1(html_escape($this->input->post('password')));
		$validate = array(
						array(
							'field' => 'email',
							'label' => 'Email',
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
			$isExitEmail = $this->Login_model->check_credential($email, $password);
			if($isExitEmail == true)
			{
				//Check user status (active OR deactive)
				if($isExitEmail->owner_activate !== '1')
				{
					$warning_alert = '<div class="alert alert-warning" role="alert">Account has blocked!</div>';
					$result = array("status" => "warning", "warning" => $warning_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
					echo json_encode($result);
					exit;
				}else
				{
					$show_last['admllg'] = $isExitEmail->owner_last_login;
					$this->session->set_userdata($show_last);
					$logg['owner_login_ip'] = $this->input->ip_address();
					$logg['owner_last_login'] = date("Y-m-d H:i:s", strtotime("+6 hours"));
					$this->Login_model->update_admin($isExitEmail->owner_id, $logg);
					$activate['full_name'] = $isExitEmail->owner_name;
					$activate['active_user'] = $isExitEmail->owner_id;
					$activate['admin_photo'] = $isExitEmail->owner_photo;
					$activate['role'] = $isExitEmail->owner_role_id;
					$activate['userLogin'] = TRUE;
					$this->session->set_userdata($activate);
					$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
					$result = array("status" => "ok", "success" => $success_alert);
					echo json_encode($result);
					exit;
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
			$data['owner_passwrd_resetcd'] = sha1($resetdigit);
			$message_subject = "Your Password Reset Code";
			$rest['subject'] = $message_subject;
			$rest['reset_code'] = 'Your password reset code is - '.$resetdigit;
			$body = $this->load->view('preset_email', $rest, true);
			$this->Login_model->update_reset_code($check_email->owner_id, $data);
			
			$this->sendmaillib->from('info@dldchc-badas.org.bd');
			$this->sendmaillib->to($check_email->owner_email);
			$this->sendmaillib->subject($message_subject);
			$this->sendmaillib->content($body);
			$this->sendmaillib->send();
			
			$sess['reset_success'] = TRUE;
			$sess['gt_wnr'] = $check_email->owner_id;
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
			redirect('smartadmin/recover');
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
			$data['owner_passwrd_resetcd'] = null;
			$this->Login_model->update_reset_code($result->owner_id, $data);
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
			redirect('smartadmin/resetform');
		}else
		{
			$this->load->view('reset_form');
		}
	}
	
	//update password
	public function update_password()
	{
		$data['owner_password'] = sha1(html_escape($this->input->post('newpass')));
		$owner_id = $this->session->userdata('gt_wnr');
		$this->Login_model->update_password($owner_id, $data);
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
	
	
	public function api_wix_registration()
	{
		$status = 'Not Inserted';
		
		$student_batch = $_POST["batch"];
		$student_email = $_POST["email"];
		$student_entryid = $_POST["id"];
		//$student_password = '7c4a8d09ca3762af61e59520943dc26494f8941b';
		$student_portid = sha1($student_entryid);
		$regdate1 = $_POST["reg_date"];
		$venue = $_POST["venue"];
		$student_shift_choice = $_POST["shift_choice"];
		$student_application_type = $_POST["app_type"];
		
		$check_student = $this->Login_model->check_data($student_entryid);
		
		if($check_student){
			$Response[]=array("status" => "student Exist" );
			echo json_encode($Response);
		}else{
		
				if(substr_count( $regdate1," ") === 3){
				list($month, $date1,$year,$time) = explode(' ', $regdate1);
				$month = date('m', strtotime($month));
				$student_regdate = $year.'-'.$month.'-'.$date1.' '.$time;
				}else{
					date_default_timezone_set("Asia/Dhaka");
					$student_regdate = date("Y-m-d h:i:s");
				}
				
				if($student_shift_choice == "Evening"){
					$shift = "7";
				}else{
					$shift = "6";
				}
				
				$basic_data = array(
								'student_entryid'             	=> $student_entryid,
								'student_batch'                 => $student_batch,
								'student_email'            		=> $student_email,
								'student_password'       		=> '7c4a8d09ca3762af61e59520943dc26494f8941b',
								'student_status'       		=> '1',
								'student_portid'          		=> $student_portid,
								'student_regdate'          		=> $student_regdate,
								'student_reg_has_completed'     => 'YES',
								'student_shift_choice'          => $shift,
								'student_application_type'      => $student_application_type,
								'venue'      					=> $venue,
								
							  );
							  
				$ins_id = $this->Login_model->save_student($basic_data);
				$student_id = $this->db->insert_id($ins_id);
				
				
				$name = $_POST["name"];
				$dob = $_POST["dob"];
				$gender = $_POST["gender"];
				$spinfo_fmorspouse_name = $_POST["spouse"];
				$spouse_type = $_POST["spouse_type"];
				$spinfo_national_id = $_POST["nid"];
				$spinfo_email = $student_email;
				$spinfo_personal_phone = '0'.$_POST["phone"];
				$spinfo_office_phone = '0'.$_POST["whatsapp"];
				$spinfo_home_phone = '0'.$_POST["emergency"];
				$spinfo_current_address = '0'.$_POST["address"];
				
				if($gender == 'Male'){
					$spinfo_gender = '0';
				}else{
					$spinfo_gender = '1';
				}
				
				$personal_data = array(
								'spinfo_student_id'        => $student_id,
								'spinfo_first_name'        => $name,
								'spinfo_birth_date'        => $dob,
								'spinfo_gender'            => $spinfo_gender,
								'spinfo_nationality'       => '18',
								'spouse_type'   		   => $spouse_type,
								'spinfo_fmorspouse_name'   => $spinfo_fmorspouse_name,
								'spinfo_national_id'       => $spinfo_national_id,
								'spinfo_email'             => $spinfo_email,
								'spinfo_personal_phone'    => $spinfo_personal_phone,
								'spinfo_office_phone'      => $spinfo_office_phone,
								'spinfo_home_phone'        => $spinfo_home_phone,
								'spinfo_current_address'   => $spinfo_current_address,
								
								
							  );

				$this->Login_model->save_student_personal($personal_data);
				
				
				$spsinfo_designation = $_POST["designation"];
				$spsinfo_organization = $_POST["org_name"];
				$spsinfo_organization_address = $_POST["org_address"];
				$employee_id = $_POST["employee_id"];
				$org_type = $_POST["org_type"];
				$badas_non = $_POST["badas_non"];
				$badas_affiliated = $_POST["badas_affiliated"];
				$spsinfo_bmanddc_number = $_POST["bmdc_no"];
				$spsinfo_sinceyear_mbbs = $_POST["mbbs_year"];
				$ssc_pass_year = $_POST["ssc_year"];
				$nid_front = $_POST["nid_front"];
				$nid_back = $_POST["nid_back"];
				$bmdc_certificate = $_POST["bmdc_certificate"];
				$mbbs_certificate = $_POST["mbbs_certificate"];
				$ssc_certificate = $_POST["ssc_certificate"];
				
				$professional_data = array(
								'spsinfo_student_id'             => $student_id,
								'spsinfo_designation'             => $spsinfo_designation,
								'spsinfo_organization'                 => $spsinfo_organization,
								'spsinfo_organization_address'            => $spsinfo_organization_address,
								'employee_id'            => $employee_id,
								'org_type'            => $org_type,
								'badas_non'            => $badas_non,
								'badas_affiliated'            => $badas_affiliated,
								'nid_front'            => $nid_front,
								'nid_back'            => $nid_back,
								'bmdc_certificate'            => $bmdc_certificate,
								'mbbs_certificate'            => $mbbs_certificate,
								'ssc_certificate'            => $ssc_certificate,
								'spsinfo_bmanddc_number'            => $spsinfo_bmanddc_number,
								'spsinfo_sinceyear_mbbs'            => $spsinfo_sinceyear_mbbs,
								'ssc_pass_year'            => $ssc_pass_year,
								
								
								
							  );
							  
			  $this->Login_model->save_student_professional($professional_data);
			  
			  if($student_id){
				  $status = 'Inserted';
			  }
			
				$Response[]=array("status" => $status , "id" => $student_id);
				echo json_encode($Response);
		
		}
	}
}
