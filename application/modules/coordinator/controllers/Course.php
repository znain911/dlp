<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 4);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Course_model');
	}
	
	public function phase()
	{
		if(isset($_GET['step']) && $_GET['step'] === 'A'){
			$data['phase_id'] = 1;
			$this->load->view('course/phase_a', $data);
		}elseif(isset($_GET['step']) && $_GET['step'] === 'B'){
			$data['phase_id'] = 2;
			$this->load->view('course/phase_b', $data);
		}elseif(isset($_GET['step']) && $_GET['step'] === 'C'){
			$data['phase_id'] = 3;
			$this->load->view('course/phase_c', $data);
		}
	}
	
	public function create()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$data = array(
					'module_phase_id' => $phase_id, 
					'module_name'     => html_escape($this->input->post('module_name')), 
					'module_title'    => html_escape($this->input->post('module_title')),  
				);
		$validate = array(
						array(
							'field' => 'module_name', 
							'label' => 'Module Name', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'module_title', 
							'label' => 'Book/Module Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Course_model->create_module($data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('course/modules', $data_template, true);
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function catalog_up()
	{
	  $this->load->library('upload');
	  $config['upload_path']          = 'attachments/contents/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = '0';
	  $config['remove_spaces'] = TRUE;
	  $config['encrypt_name'] = TRUE;
	  $this->upload->initialize($config);
	  if (!$this->upload->do_upload('file')){
		 $upload_error = $this->upload->display_errors();
	  }else{
		$fileData = $this->upload->data();
		$imgurl = base_url($config['upload_path'].$fileData['file_name']);
		$result = array("status" => "ok", "imgurl" => $imgurl);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	  }
	}
	
	public function module()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('course/module_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function edit()
	{
		$data['module_id'] = $this->input->post('module_id');
		$content = $this->load->view('course/module_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$module_id = $this->input->post('module_id');
		$data = array(
					'module_phase_id' => $phase_id, 
					'module_name'     => html_escape($this->input->post('module_name')), 
					'module_title'    => html_escape($this->input->post('module_title')),  
				);
		$validate = array(
						array(
							'field' => 'module_name', 
							'label' => 'Module Name', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'module_title', 
							'label' => 'Book/Module Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Course_model->update_module($module_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('course/modules', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function delmodule()
	{
		$module_id = $this->input->post('module_id');
		
		//Delete from module content
		$this->db->where('lesson_module_id', $module_id);
		$this->db->delete('starter_modules_lessons');
		
		//Delete from module table
		$this->db->where('module_id', $module_id);
		$this->db->delete('starter_modules');
		
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('course/module_create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function lesson()
	{
		$module_id = $this->input->post('module_id');
		$data['module_id'] = $module_id;
		$data['phase_id'] = $this->input->post('phase_id');
		$data['module_info'] = $this->Course_model->get_module_info($module_id);
		$content = $this->load->view('course/lessons', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function createlesson()
	{
		$this->load->library('form_validation');
		$module_id = $this->input->post('module_id');
		$data = array(
					'lesson_module_id'   => $module_id, 
					'lesson_title'       => html_escape($this->input->post('section_title')), 
					'lesson_content'     => $this->input->post('description'),  
					'lesson_created_by'  => $this->session->userdata('active_user'),  
					'lesson_create_date' => date("Y-m-d H:i:s"),  
					'lesson_position'    => html_escape($this->input->post('position')),  
					'lesson_show_practice_button'    => html_escape($this->input->post('show_practice_button')),  
				);
		$validate = array(
						array(
							'field' => 'section_title', 
							'label' => 'Section Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'description', 
							'label' => 'Description', 
							'rules' => 'trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $config['upload_path']          = 'attachments/lessons/';
	    $config['allowed_types']        = 'pdf|doc';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('uploaded_lesson')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$fileData = $this->upload->data();
			$data['lesson_attach_file'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Course_model->create_module_lesson($data);
			$data_template['display_content'] = TRUE;
			$data_template['module_id'] = $module_id;
			$data_template['module_info'] = $this->Course_model->get_module_info($module_id);
			$content = $this->load->view('course/lesson_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully created!</div>';
			$change_position = '
								<input type="text" class="form-control" value="'.$this->Course_model->lesson_position($module_id).'" disabled>
								<input type="hidden" name="position" value="'.$this->Course_model->lesson_position($module_id).'" />
							   ';
			$result = array('status' => 'ok', 'success' => $success, 'change_position' => $change_position,'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function getlessoncreate()
	{
		$module_id = $this->input->post('module_id');
		$data['display'] = TRUE;
		$data['module_id'] = $module_id;
		$data['phase_id'] = $this->input->post('phase_id');
		$data['module_info'] = $this->Course_model->get_module_info($module_id);
		$content = $this->load->view('course/lesson_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function editlesson()
	{
		$data['lesson_id'] = $this->input->post('lesson_id');
		$module_id = $this->input->post('module_id');
		$data['module_id'] = $module_id;
		$data['phase_id'] = $this->input->post('phase_id');
		$data['module_info'] = $this->Course_model->get_module_info($module_id);
		$content = $this->load->view('course/lesson_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function viewlesson()
	{
		$data['lesson_id'] = $this->input->post('lesson_id');
		$data['phase_id'] = $this->input->post('phase_id');
		$module_id = $this->input->post('module_id');
		$data['module_info'] = $this->Course_model->get_module_info($module_id);
		$content = $this->load->view('course/view_lesson', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function updatelesson()
	{
		$this->load->library('form_validation');
		$lesson_id = $this->input->post('lesson_id');
		$module_id = $this->input->post('module_id');
		$data = array(
					'lesson_title'       => html_escape($this->input->post('section_title')), 
					'lesson_content'     => $this->input->post('description'),
					'lesson_position'    => html_escape($this->input->post('position')),
					'lesson_show_practice_button'    => html_escape($this->input->post('show_practice_button')),
				);
		$validate = array(
						array(
							'field' => 'section_title', 
							'label' => 'Section Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'description', 
							'label' => 'Description', 
							'rules' => 'trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $config['upload_path']          = 'attachments/lessons/';
	    $config['allowed_types']        = 'pdf|doc';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('uploaded_lesson')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Course_model->get_lessonby_id($lesson_id);
			if(!empty($exist_image['lesson_attach_file']) && $exist_image['lesson_attach_file'] !== NULL){
				$file_name = attachment_dir("lessons/".$exist_image['lesson_attach_file']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['lesson_attach_file'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Course_model->update_module_lesson($lesson_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['module_id'] = $module_id;
			$data_template['module_info'] = $this->Course_model->get_module_info($module_id);
			$content = $this->load->view('course/lesson_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function dellesson()
	{
		$lesson_id = $this->input->post('lesson_id');
		$module_id = $this->input->post('module_id');
		$phase_id = $this->input->post('phase_id');
		//Delete from module table
		$this->db->where('lesson_id', $lesson_id);
		$this->db->delete('starter_modules_lessons');
		
		$retrive_button = '
						    <div class="generate-buttons text-right display-crtbtn">
								<button class="btn btn-purple m-b-5 return-create-lesson" data-phase="'.$phase_id.'" data-module="'.$module_id.'" type="button">Create New Lesson</button>
								<button class="btn btn-purple m-b-5 back-to-modules" data-phase="'.$phase_id.'" type="button">Back To Modules</button>
							</div>
						  ';
		$result = array("status" => "ok", "retrive_button" => $retrive_button);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function backtomodules()
	{
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('course/module_content', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	
}
