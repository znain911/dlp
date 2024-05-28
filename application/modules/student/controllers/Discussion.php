<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion extends CI_Controller{
	
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
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->load->model('Discussion_model');
		$this->load->model('Student_model');
	}
	
	public function index()
	{
		$this->load->view('discussion_with_faculty');	
	}
	
	public function send()
	{
		$student_id = $this->session->userdata('active_student');
		$faculty_id = $this->input->post('gt_fac');
		$message = $this->input->post('message');
		
		//Check previous discuss info
		$discuss_info = $this->Discussion_model->check_previous_discuss($student_id, $faculty_id);
		
		if($discuss_info == true)
		{
			$discuss_id = $discuss_info['discuss_id'];
		}else
		{
			$discuss_slentry_number = $this->Discussion_model->get_discuss_serial_no();
			$discussion_data = array(
									'discuss_slentry_number' => $discuss_slentry_number,
									'discuss_by'           => $student_id,
									'discuss_to'           => $faculty_id,
									'discuss_by_user_type' => 'STUDENT',
									'discuss_to_user_type' => 'FACULTY',
									'discuss_created_date' => date("Y-m-d H:i:s"),
								);
			$get_insert_id = $this->Discussion_model->save_discussion_data($discussion_data);
			$discuss_id = $this->db->insert_id($get_insert_id);
		}
							
		//Save message reply
		$message_data = array(
							'reply_discuss_id'   => $discuss_id,
							'reply_answered_by'  => $student_id,
							'reply_user_type'    => 'STUDENT',
							'reply_content'      => $message,
							'reply_created_date' => date("Y-m-d H:i:s"),
						);
		$get_reply_insert_id = $this->Discussion_model->save_messge_reply($message_data);
		$reply_id = $this->db->insert_id($get_reply_insert_id);
		
		//Save notification




		$notification_data = array(
								'notify_discuss_id'    => $discuss_id,
								'notify_user_id'       => $student_id,
								'notify_user_type'     => 'STUDENT',
								'notify_user_reply_id' => $reply_id,
							);
		$this->Discussion_model->save_discussion_notification($notification_data);
		
		$this->__messages($discuss_id);
	}
	
	public function get_messages()
	{
		$student_id = $this->session->userdata('active_student');
		$faculty_id = $this->input->post('theFclty');
		//Check previous discuss info
		$discuss_info = $this->Discussion_model->check_previous_discuss($student_id, $faculty_id);
		
		if($discuss_info == true)
		{
			//Refresh notifications
			$this->Discussion_model->refresh_discuss_notifications($faculty_id, 'FACULTY');
			
			$discuss_id = $discuss_info['discuss_id'];
			$data['teacher_id'] = $faculty_id;
			$content = $this->load->view('discussions/chat_header', $data, true);
			$this->__messages($discuss_id, $content);
		}else
		{
			$data['teacher_id'] = $faculty_id;
			$chat_header = $this->load->view('discussions/chat_header', $data, true);
			$result = array('status' => 'ok', 'chat_header' => $chat_header);
			echo json_encode($result);
			exit;
		}
	}
	
	private function __messages($discuss_id, $chat_header=null)
	{
		$data['discuss_id'] = $discuss_id;
		$content = $this->load->view('discussions/content', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'chat_header' => $chat_header);
		echo json_encode($result);
		exit;
	}
	
	public function get_faculties()
	{
		$data['show_users'] = TRUE;
		$q = $this->input->post('q');
		$data['faculties'] = $this->Discussion_model->get_faculties_by_search($q);
		$content = $this->load->view('discussions/chat_users', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
}