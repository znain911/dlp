<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 13);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Setup_model');
		$this->load->model('Coordinator_model');
		$this->load->model('Organogram_model');
		$this->load->model('Role_model');
		$this->load->model('Banks_model');
		$this->load->model('Category_model');
		$this->load->model('Specialization_model');
		$this->load->model('Center_model');
		$this->load->model('Config_model');
	}
	
	/************************************/
	/************START COORDINATOR PART***************/
	/************************************/
	public function coordinators()
	{
		$this->load->view('setup/coordinators/index');
	}
	
	public function coordinators_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'owner_role_id'      => $this->input->post('role_id'),  
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_email'        => html_escape($this->input->post('email')),  
					'owner_password'     => sha1(html_escape($this->input->post('password'))),  
					'owner_role'         => md5($this->input->post('role_id')),  
					'owner_create_date'  => Date("Y-m-d H:i:s"),  
					'owner_activate'     => $this->input->post('status'),  
					'owner_show_at_landing' => $this->input->post('show_at_landing'),  
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'role_id', 
							'label' => 'Role', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'password', 
							'label' => 'Password', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_owner.owner_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/coordinators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$fileData = $this->upload->data();
			
			$full_path = $fileData['full_path'];
			// check EXIF and autorotate if needed
			$this->load->library('image_autorotate', array('filepath' => $full_path));
			
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  FALSE,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$ins_id = $this->Coordinator_model->create($data);
			$admin_id = $this->db->insert_id($ins_id);
			
			//save manages
			$total_permissions = $this->input->post('permission');
			foreach($total_permissions as $key => $permission)
			{
				if($permission)
				{
					$perm_data = array(
									'permission_adminid' => $admin_id,
									'permission_permission_id' => $permission,
								);
					$this->Coordinator_model->save_permissions($perm_data);
				}
			}
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/coordinators/content_list', $data_template, true);
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
	
	public function coordinators_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('setup/coordinators/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function coordinators_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/coordinators/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function coordinators_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$check_email = $this->Coordinator_model->get_info($id);
		$data = array(
					'owner_role_id'      => $this->input->post('role_id'),  
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_email'        => html_escape($this->input->post('email')), 
					'owner_role'         => md5($this->input->post('role_id')),  
					'owner_activate'     => $this->input->post('status'),
					'owner_show_at_landing' => $this->input->post('show_at_landing'),
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'role_id', 
							'label' => 'Role', 
							'rules' => 'required|trim', 
						),
					);
		if($check_email == true && $check_email['owner_id'] !== $id)
		{
			$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_owner.owner_email]', array('is_unique' => 'The email is already exist!'));
		}
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/coordinators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Coordinator_model->get_info($id);
			if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
				$file_name = attachment_dir("coordinators/".$exist_image['owner_photo']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  FALSE,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//Update
			$this->Coordinator_model->update($id, $data);
			
			//delete permissions first
			$this->db->where('permission_adminid', $id);
			$this->db->delete('starter_admin_permission');
			
			//save manages
			$total_permissions = $this->input->post('permission');
			foreach($total_permissions as $key => $permission)
			{
				if($permission)
				{
					$perm_data = array(
									'permission_adminid' => $id,
									'permission_permission_id' => $permission,
								);
					$this->Coordinator_model->save_permissions($perm_data);
				}
			}
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/coordinators/content_list', $data_template, true);
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
	
	public function coordinators_delete()
	{
		$id = $this->input->post('id');
		
		//delete permission
		$this->db->where('permission_adminid', $id);
		$this->db->delete('starter_admin_permission');
		
		$exist_image = $this->Coordinator_model->get_info($id);
		if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
			$file_name = attachment_dir("coordinators/".$exist_image['owner_photo']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Delete coordinator
		$this->db->where('owner_id', $id);
		$this->db->delete('starter_owner');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/coordinators/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function coordinators_change_password()
	{
		$admin_id = $this->input->post('admin');
		$update_pass = array(
							'owner_password' => sha1(html_escape($this->input->post('password'))),
						);
		$this->db->where('owner_id', $admin_id);
		$this->db->update('starter_owner', $update_pass);
		
		$data_template['display_content'] = TRUE;
		$content = $this->load->view('setup/coordinators/content_list', $data_template, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/************END COORDINATOR PART***************/
	/************************************/
	
	
	/************************************/
	/************START COORDINATOR PART***************/
	/************************************/
	public function organograms()
	{
		$this->load->view('setup/organograms/index');
	}
	
	public function organograms_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'owner_position'     => html_escape($this->input->post('position')),  
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_designation'  => html_escape($this->input->post('designation')),   
					'owner_create_date'  => Date("Y-m-d H:i:s"),  
					'owner_activate'     => $this->input->post('status'),  
					'owner_show_at_landing' => $this->input->post('show_at_landing'),  
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						)
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/coordinators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$fileData = $this->upload->data();
			
			$full_path = $fileData['full_path'];
			// check EXIF and autorotate if needed
			$this->load->library('image_autorotate', array('filepath' => $full_path));
			
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  FALSE,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Organogram_model->create($data);
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/organograms/content_list', $data_template, true);
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
	
	public function organograms_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('setup/organograms/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function organograms_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/organograms/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function organograms_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$check_email = $this->Organogram_model->get_info($id);
		$data = array(
					'owner_position'     => html_escape($this->input->post('position')),
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_designation'  => html_escape($this->input->post('designation')),   
					'owner_activate'     => $this->input->post('status'),  
					'owner_show_at_landing' => $this->input->post('show_at_landing'),  
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						)
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/coordinators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Coordinator_model->get_info($id);
			if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
				$file_name = attachment_dir("coordinators/".$exist_image['owner_photo']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  FALSE,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//Update
			$this->Organogram_model->update($id, $data);
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/organograms/content_list', $data_template, true);
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
	
	public function organograms_delete()
	{
		$id = $this->input->post('id');
		$exist_image = $this->Organogram_model->get_info($id);
		if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
			$file_name = attachment_dir("coordinators/".$exist_image['owner_photo']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Delete coordinator
		$this->db->where('owner_id', $id);
		$this->db->delete('starter_organogram');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/organograms/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	
	/***********************************/
	/***********End Organogram Part*********/
	/***********************************/
	
	
	/************************************/
	/************START ROLES PART***************/
	/************************************/
	
	public function roles()
	{
		$this->load->view('setup/roles/index');
	}
	
	public function roles_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'role_title'       => html_escape($this->input->post('title')),  
					'role_create_date' => Date("Y-m-d H:i:s"),  
					'role_action'      => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Role Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Role_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/roles/content_list', $data_template, true);
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
	
	public function roles_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('setup/roles/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function roles_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/roles/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function roles_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'role_title'       => html_escape($this->input->post('title')),
					'role_action'      => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Role Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Role_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/roles/content_list', $data_template, true);
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
	
	public function roles_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('role_id', $id);
		$this->db->delete('starter_admin_role');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/roles/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/************END ROLES PART***************/
	/************************************/
	
	/************************************/
	/************START BANK DETAILS PART***************/
	/************************************/
	
	public function banks()
	{
		$this->load->view('setup/banks/index');
	}
	
	public function banks_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'bank_name'           => html_escape($this->input->post('bank_name')),  
					'bank_branch_name'    => html_escape($this->input->post('bank_branch_name')),  
					'bank_account_name'   => html_escape($this->input->post('bank_account_name')),  
					'bank_account_number' => html_escape($this->input->post('bank_account_number')),    
					'bank_create_date'    => Date("Y-m-d H:i:s"),  
					'bank_status'         => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'bank_name', 
							'label' => 'Bank Name', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/banks/';
		$config['allowed_types']        = 'jpg|png|jpeg';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('bank_icon')){
			 $upload_error = $this->upload->display_errors();
		}else{
			$fileData = $this->upload->data();
			$data['bank_photo_icon'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Banks_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/banks/content_list', $data_template, true);
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
	
	public function banks_create_item()
	{
		$data['display'] = TRUE;
		$content = $this->load->view('setup/banks/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function banks_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/banks/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function banks_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'bank_name'           => html_escape($this->input->post('bank_name')),  
					'bank_branch_name'    => html_escape($this->input->post('bank_branch_name')),  
					'bank_account_name'   => html_escape($this->input->post('bank_account_name')),  
					'bank_account_number' => html_escape($this->input->post('bank_account_number')),     
					'bank_status'         => $this->input->post('status'), 
				);
		$validate = array(
						array(
							'field' => 'bank_name', 
							'label' => 'Bank Name', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/banks/';
		$config['allowed_types']        = 'jpg|png|jpeg';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('bank_icon')){
			 $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Banks_model->check_thumbnail($id);
			if(!empty($exist_image['bank_photo_icon']) && $exist_image['bank_photo_icon'] !== NULL){
				$file_name = $_SERVER['DOCUMENT_ROOT'].'/attachments/banks/'.$exist_image['bank_photo_icon'];
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['bank_photo_icon'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Banks_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/banks/content_list', $data_template, true);
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
	
	public function banks_delete()
	{
		$id = $this->input->post('id');
		
		$exist_image = $this->Banks_model->check_thumbnail($id);
		if(!empty($exist_image['bank_photo_icon']) && $exist_image['bank_photo_icon'] !== NULL){
			$file_name = $_SERVER['DOCUMENT_ROOT'].'/attachments/banks/'.$exist_image['bank_photo_icon'];
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Delete coordinator
		$this->db->where('bank_id', $id);
		$this->db->delete('starter_config_bank_details');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/banks/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/************END ROLES PART***************/
	/************************************/
	
	
	/************************************/
	/************START SPECIALIZATION PART***************/
	/************************************/
	
	public function specialization()
	{
		$this->load->view('setup/specializations/index');
	}
	
	public function specializations_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'specialize_name'          => html_escape($this->input->post('title')), 
					'specialize_create_date'   => Date("Y-m-d H:i:s"), 
					'specialize_status'        => html_escape($this->input->post('status')), 
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Specialization title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Specialization_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/specializations/content_list', $data_template, true);
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
	
	public function specializations_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('setup/specializations/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function specializations_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/specializations/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function specializations_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'specialize_name'   => html_escape($this->input->post('title')), 
					'specialize_status' => html_escape($this->input->post('status')), 
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Specialization title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Specialization_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/specializations/content_list', $data_template, true);
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
	
	public function specializations_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('specialize_id', $id);
		$this->db->delete('starter_specialization');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/specializations/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/************END SPECIALIZATION PART***************/
	/************************************/
	
	
	/************************************/
	/************START CATEGORIES PART***************/
	/************************************/
	
	public function categories()
	{
		$this->load->view('setup/categories/index');
	}
	
	public function categories_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'category_name'        => $this->input->post('title'),  
					'category_status'      => $this->input->post('status'),  
					'category_create_date' => Date("Y-m-d H:i:s"),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Category Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Category_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/categories/content_list', $data_template, true);
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
	
	public function categories_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('setup/categories/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function categories_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/categories/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function categories_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'category_name'        => $this->input->post('title'),  
					'category_status'      => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Category Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Category_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/categories/content_list', $data_template, true);
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
	
	public function categories_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('category_id', $id);
		$this->db->delete('starter_dlp_categories');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/categories/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/************END CATEGORIES PART***************/
	/************************************/
	
	
	/************************************/
	/************START CENTERS PART***************/
	/************************************/
	
	public function centers()
	{
		$this->load->view('setup/centers/index');
	}
	
	public function centers_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'center_location'    => $this->input->post('location'),  
					'center_create_date' => Date("Y-m-d H:i:s"),  
					'center_status'      => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'location', 
							'label' => 'Center location', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Center_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/centers/content_list', $data_template, true);
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
	
	public function centers_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('setup/centers/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function centers_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('setup/centers/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function centers_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'center_location'    => $this->input->post('location'),  
					'center_create_date' => Date("Y-m-d H:i:s"),  
					'center_status'      => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'location', 
							'label' => 'Center location', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Center_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('setup/centers/content_list', $data_template, true);
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
	
	public function centers_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('center_id', $id);
		$this->db->delete('starter_centers');
		
		$data['id'] = $id;
		$content = $this->load->view('setup/centers/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/************END CENTERS PART***************/
	/************************************/
	
	
	public function smsconfig()
	{
		$this->load->view('setup/config/smsconfig');
	}
	
	public function update_smsconfig()
	{
		$data = array(
					'sms_username' => $this->input->post('sms_username'),
					'sms_password' => $this->input->post('sms_password'),
					'sms_sid'      => $this->input->post('sms_sid'),
				);
		$this->Setup_model->update_smsconfig($data);
		
		$success = '<div class="alert alert-success">Successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function emailconfig()
	{
		$this->load->view('setup/config/emailconfig');
	}
	
	public function update_emailconfig()
	{
		
	}
	
	public function paymentconfig()
	{
		$this->load->view('setup/config/paymentconfig');
	}
	
	public function update_paymentconfig()
	{
		$data = array(
					'pconfig_course_fee'      => $this->input->post('course_fee'),
					'pconfig_ece_retakefee'   => $this->input->post('ece_retake_fee'),
				);
		$this->Setup_model->update_paymentconfig($data);
		
		$success = '<div class="alert alert-success">Successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	
	public function marksconfig()
	{
		$this->load->view('setup/config/marksconfig');
	}
	
	public function update_marksconfig()
	{
		$data = array(
					'mrkconfig_exam_time'=> html_escape($this->input->post('exam_time')),
					'mrkconfig_exam_date'=> html_escape($this->input->post('exam_date')),
					'mrkconfig_exam_totalquestion' => html_escape($this->input->post('exam_question_total')),
					'mrkconfig_question_mark' => html_escape($this->input->post('question_mark')),
					'mrkconfig_exmtotal_mark'  => html_escape($this->input->post('exmtotal_mark')),
					'mrkconfig_exmpass_mark'  => html_escape($this->input->post('exmpass_mark')),
					'mrkconfig_question_type' => json_encode($this->input->post('question_type')),
					'mrkconfig_pcatwo_exam_time'=> html_escape($this->input->post('pcatwo_exam_time')),
					'mrkconfig_pcatwo_exam_date'=> html_escape($this->input->post('pcatwo_exam_date')),
					'mrkconfig_pcatwo_exam_totalquestion' => html_escape($this->input->post('pcatwo_exam_question_total')),
					'mrkconfig_pcatwo_question_mark' => html_escape($this->input->post('pcatwo_question_mark')),
					'mrkconfig_pcatwo_exmtotal_mark'  => html_escape($this->input->post('pcatwo_exmtotal_mark')),
					'mrkconfig_pcatwo_exmpass_mark'  => html_escape($this->input->post('pcatwo_exmpass_mark')),
					'mrkconfig_pcatwo_question_type' => json_encode($this->input->post('pcatwo_question_type')),
					'mrkconfig_pcathree_exam_time'=> html_escape($this->input->post('pcathree_exam_time')),
					'mrkconfig_pcathree_exam_date'=> html_escape($this->input->post('pcathree_exam_date')),
					'mrkconfig_pcathree_exam_totalquestion' => html_escape($this->input->post('pcathree_exam_question_total')),
					'mrkconfig_pcathree_question_mark' => html_escape($this->input->post('pcathree_question_mark')),
					'mrkconfig_pcathree_exmtotal_mark'  => html_escape($this->input->post('pcathree_exmtotal_mark')),
					'mrkconfig_pcathree_exmpass_mark'  => html_escape($this->input->post('pcathree_exmpass_mark')),
					'mrkconfig_pcathree_question_type' => json_encode($this->input->post('pcathree_question_type')),
					'mrkconfig_practice_exam_time'=> html_escape($this->input->post('practice_exam_time')),
					'mrkconfig_practice_exam_totalquestion' => html_escape($this->input->post('practice_exam_question_total')),
					'mrkconfig_practice_question_mark' => html_escape($this->input->post('practice_question_mark')),
					'mrkconfig_practice_exmtotal_mark'  => html_escape($this->input->post('practice_exmtotal_mark')),
					'mrkconfig_practice_exmpass_mark'  => html_escape($this->input->post('practice_exmpass_mark')),
					'mrkconfig_practice_question_type' => json_encode($this->input->post('practice_question_type')),
				);
		$this->Setup_model->update_marksconfig($data);
		
		$success = '<div class="alert alert-success">Successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function contactinfo()
	{
		$this->load->view('setup/config/contactinfo');
	}
	
	public function update_contactinfo()
	{
		//check data is exists
		$contactinfo = $this->Setup_model->get_contactinfo();
		if($contactinfo == true)
		{
			$data = array(
						'config_email'=> html_escape($this->input->post('email')),
						'config_phone' => html_escape($this->input->post('phone')),
						'config_address' => html_escape($this->input->post('address')),
						'config_google_map'  => $this->input->post('google_map'),
					);
			$this->Setup_model->update_contactinfo($data);
			
			$success = '<div class="alert alert-success">Successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else{
			$data = array(
						'config_key'        => 'One_Time',
						'config_email'      => html_escape($this->input->post('email')),
						'config_phone'      => html_escape($this->input->post('phone')),
						'config_address'    => html_escape($this->input->post('address')),
						'config_google_map' => $this->input->post('google_map'),
					);
			$this->Setup_model->save_contactinfo($data);
			
			$success = '<div class="alert alert-success">Successfully Created!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	/****************************/
	/********Manage Evaluations**********/
	/****************************/
	public function evaluations()
	{
		if(isset($_GET['type']) && $_GET['type'] == 'students')
		{
			$this->load->view('setup/config/evaluations');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'faculties'){
			$this->load->view('setup/config/faculties_evaluations');
		}else
		{
			$this->load->view('setup/config/evaluations');
		}
	}
	
	public function update_evaluations()
	{
		$this->Setup_model->delete_evaluations();
		
		$labels = $this->input->post('rownumber');
		foreach($labels as $label)
		{
			$get_label = $this->input->post('marks_label_'.$label);
			
			$get_rating_type_one   = $this->input->post('marks_rating_type_1_'.$label);
			$get_rating_type_two   = $this->input->post('marks_rating_type_2_'.$label);
			$get_rating_type_three = $this->input->post('marks_rating_type_3_'.$label);
			$get_rating_type_four  = $this->input->post('marks_rating_type_4_'.$label);
			$get_rating_type_five  = $this->input->post('marks_rating_type_5_'.$label);
			
			$get_rating_one   = $this->input->post('marks_rating_1_'.$label);
			$get_rating_two   = $this->input->post('marks_rating_2_'.$label);
			$get_rating_three = $this->input->post('marks_rating_3_'.$label);
			$get_rating_four  = $this->input->post('marks_rating_4_'.$label);
			$get_rating_five  = $this->input->post('marks_rating_5_'.$label);
			
			if($get_label && $get_rating_type_one && $get_rating_type_two && $get_rating_type_three && $get_rating_type_four && $get_rating_type_five)
			{
				
				$data = array(
							'eval_label'=> $get_label,
							'eval_rating_type_one'   => $get_rating_type_one,
							'eval_rating_type_two'   => $get_rating_type_two,
							'eval_rating_type_three' => $get_rating_type_three,
							'eval_rating_type_four'  => $get_rating_type_four,
							'eval_rating_type_five'  => $get_rating_type_five,
							'eval_rating_one'   => $get_rating_one,
							'eval_rating_two'   => $get_rating_two,
							'eval_rating_three' => $get_rating_three,
							'eval_rating_four'  => $get_rating_four,
							'eval_rating_five'  => $get_rating_five,
						);
				$this->Setup_model->insert_evaluations($data);
			}
		}
		
		$success = '<div class="alert alert-success">Successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function update_faculties_evaluations()
	{
		$this->Setup_model->delete_faculties_evaluations();
		
		$labels = $this->input->post('rownumber');
		foreach($labels as $label)
		{
			$get_label = $this->input->post('marks_label_'.$label);
			
			$get_rating_type_one   = $this->input->post('marks_rating_type_1_'.$label);
			$get_rating_type_two   = $this->input->post('marks_rating_type_2_'.$label);
			$get_rating_type_three = $this->input->post('marks_rating_type_3_'.$label);
			$get_rating_type_four  = $this->input->post('marks_rating_type_4_'.$label);
			$get_rating_type_five  = $this->input->post('marks_rating_type_5_'.$label);
			
			$get_rating_one   = $this->input->post('marks_rating_1_'.$label);
			$get_rating_two   = $this->input->post('marks_rating_2_'.$label);
			$get_rating_three = $this->input->post('marks_rating_3_'.$label);
			$get_rating_four  = $this->input->post('marks_rating_4_'.$label);
			$get_rating_five  = $this->input->post('marks_rating_5_'.$label);
			
			if($get_label && $get_rating_type_one && $get_rating_type_two && $get_rating_type_three && $get_rating_type_four && $get_rating_type_five)
			{
				
				$data = array(
							'eval_label'=> $get_label,
							'eval_rating_type_one'   => $get_rating_type_one,
							'eval_rating_type_two'   => $get_rating_type_two,
							'eval_rating_type_three' => $get_rating_type_three,
							'eval_rating_type_four'  => $get_rating_type_four,
							'eval_rating_type_five'  => $get_rating_type_five,
							'eval_rating_one'   => $get_rating_one,
							'eval_rating_two'   => $get_rating_two,
							'eval_rating_three' => $get_rating_three,
							'eval_rating_four'  => $get_rating_four,
							'eval_rating_five'  => $get_rating_five,
						);
				$this->Setup_model->insert_faculties_evaluations($data);
			}
		}
		
		$success = '<div class="alert alert-success">Successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/****************************/
	/********Manage Options**********/
	/****************************/
	
	public function optionals()
	{
		$this->load->view('setup/config/optionals');
	}
	
	public function update_options()
	{
		$data = array();
		$this->load->library('upload');
		
		//Upload Banner One
	    $config['upload_path']          = 'attachments/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_section_one')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Setup_model->get_option_panel('option_one');
			if(!empty($exist_image['option_one']) && $exist_image['option_one'] !== NULL){
				$file_name = attachment_dir($exist_image['option_one']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['option_one'] = $fileData['file_name'];
		}
		
		//Upload Banner Two
	    $config['upload_path']          = 'attachments/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_section_two')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Setup_model->get_option_panel('option_two');
			if(!empty($exist_image['banner_section_two']) && $exist_image['banner_section_two'] !== NULL){
				$file_name = attachment_dir($exist_image['banner_section_two']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['option_two'] = $fileData['file_name'];
		}
		
		//Upload Banner Three
	    $config['upload_path']          = 'attachments/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_section_three')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Setup_model->get_option_panel('option_three');
			if(!empty($exist_image['banner_section_three']) && $exist_image['banner_section_three'] !== NULL){
				$file_name = attachment_dir($exist_image['banner_section_three']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['option_three'] = $fileData['file_name'];
		}
		
		//Upload Banner Four
	    $config['upload_path']          = 'attachments/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_section_four')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Setup_model->get_option_panel('option_four');
			if(!empty($exist_image['banner_section_four']) && $exist_image['banner_section_four'] !== NULL){
				$file_name = attachment_dir($exist_image['banner_section_four']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['option_four'] = $fileData['file_name'];
		}
		
		//Upload Banner Five
	    $config['upload_path']          = 'attachments/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_section_five')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Setup_model->get_option_panel('option_five');
			if(!empty($exist_image['banner_section_five']) && $exist_image['banner_section_five'] !== NULL){
				$file_name = attachment_dir($exist_image['banner_section_five']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['option_five'] = $fileData['file_name'];
		}
		
		//Upload Banner Six
	    $config['upload_path']          = 'attachments/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_section_six')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Setup_model->get_option_panel('option_six');
			if(!empty($exist_image['banner_section_six']) && $exist_image['banner_section_six'] !== NULL){
				$file_name = attachment_dir($exist_image['banner_section_six']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['option_six'] = $fileData['file_name'];
		}
		
		
		$this->Setup_model->update_options($data);
		$success = '<div class="alert alert-success">Successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success, 'content' => $data);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
