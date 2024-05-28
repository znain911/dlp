<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller {
	
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
		$this->perPage = 15;
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 16);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Sessions_model');
		$this->load->library('ajax_pagination');
		$this->load->helper('custom_string');
	}
	
	public function sdt()
	{
		if(isset($_GET['type']) && is_numeric($_GET['type']))
		{
			$data = array();
			$data['sdt_type'] = $_GET['type'];
			//total rows count
			$totalRec = $this->Sessions_model->count_total_sdt_sessions($data['sdt_type']);
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'sessionfilter/get_sdt_sessions';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['get_items'] = $this->Sessions_model->get_total_sdt_sessions($data['sdt_type']);
			$this->load->view('sessions/sdt', $data);
		}else{
			redirect('coordinator');
		}
	}
	
	public function workshop()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Sessions_model->count_total_workshop_sessions();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'sessionfilter/get_workshop_sessions';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Sessions_model->get_total_workshop_sessions(array('limit'=>$this->perPage));
		
		$this->load->view('sessions/workshop', $data);
	}
	
	public function export()
	{
		$this->load->view('sessions/export');
	}
	
	public function excel()
	{
		$session_type       = $this->input->post('session_type');
		$schedule_id        = $this->input->post('schedule_id');
		$schedule_center_id = $this->input->post('schedule_center_id');
		if($session_type == 'SDT 1'){
			$dates = array();
			$dates['sdt_type'] = 1;
			$export_by = $this->input->post('export_by');
			if($export_by == 'DATE-TO-DATE'){
				$from_date = html_escape($this->input->post('from_date'));
				$to_date = html_escape($this->input->post('to_date'));
				
				$dates['from_date'] = $from_date;
				$dates['to_date'] = $to_date;
				$dates['type'] = 'RANGE';
			}elseif($export_by == 'MONTHLY'){
				$month = $this->input->post('month');
				$year = $this->input->post('year');
				$dates['date'] = $year.'-'.$month.'-';
				$dates['type'] = 'MONTHLY';
			}elseif($export_by == 'YEARLY'){
				$year = $this->input->post('year');
				$dates['date'] = $year.'-';
				$dates['type'] = 'YEARLY';
			}
			
			if($schedule_center_id == 'All')
			{
				$dates['schedule_id'] = $schedule_id;
			}else{
				$dates['schedule_id'] = $schedule_id;
				$dates['schedule_center_id'] = $schedule_center_id;
			}
			
			$date = date('d-m-Y');
			$file = 'SDT_Sessions_1_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['get_items'] = $this->Sessions_model->get_sdt_excel_items($dates);      
			$this->load->view('sessions/sdt_report_to_excel', $data);
		}elseif($session_type == 'SDT 2'){
			$dates = array();
			$dates['sdt_type'] = 2;
			$export_by = $this->input->post('export_by');
			if($export_by == 'DATE-TO-DATE'){
				$from_date = html_escape($this->input->post('from_date'));
				$to_date = html_escape($this->input->post('to_date'));
				
				$dates['from_date'] = $from_date;
				$dates['to_date'] = $to_date;
				$dates['type'] = 'RANGE';
			}elseif($export_by == 'MONTHLY'){
				$month = $this->input->post('month');
				$year = $this->input->post('year');
				$dates['date'] = $year.'-'.$month.'-';
				$dates['type'] = 'MONTHLY';
			}elseif($export_by == 'YEARLY'){
				$year = $this->input->post('year');
				$dates['date'] = $year.'-';
				$dates['type'] = 'YEARLY';
			}
			
			if($schedule_center_id == 'All')
			{
				$dates['schedule_id'] = $schedule_id;
			}else{
				$dates['schedule_id'] = $schedule_id;
				$dates['schedule_center_id'] = $schedule_center_id;
			}
			
			$date = date('d-m-Y');
			$file = 'SDT_Sessions_2_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['get_items'] = $this->Sessions_model->get_sdt_excel_items($dates);      
			$this->load->view('sessions/sdt_report_to_excel', $data);
		}elseif($session_type == 'WORKSHOP'){
			$dates = array();
			$export_by = $this->input->post('export_by');
			if($export_by == 'DATE-TO-DATE'){
				$from_date = html_escape($this->input->post('from_date'));
				$to_date = html_escape($this->input->post('to_date'));
				
				$dates['from_date'] = $from_date;
				$dates['to_date'] = $to_date;
				$dates['type'] = 'RANGE';
			}elseif($export_by == 'MONTHLY'){
				$month = $this->input->post('month');
				$year = $this->input->post('year');
				$dates['date'] = $year.'-'.$month.'-';
				$dates['type'] = 'MONTHLY';
			}elseif($export_by == 'YEARLY'){
				$year = $this->input->post('year');
				$dates['date'] = $year.'-';
				$dates['type'] = 'YEARLY';
			}
			
			if($schedule_center_id == 'All')
			{
				$dates['schedule_id'] = $schedule_id;
			}else{
				$dates['schedule_id'] = $schedule_id;
				$dates['schedule_center_id'] = $schedule_center_id;
			}
			
			$date = date('d-m-Y');
			$file = 'WORKSHOP_Sessions_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['get_items'] = $this->Sessions_model->get_workshop_excel_items($dates);      
			$this->load->view('sessions/workshop_report_to_excel', $data);
		}else{
			exit;
		}
	}
	
	public function get_schedules()
	{
		$session_type = $this->input->post('session_type');
		if($session_type == 'SDT 1'){
			$sdt_type = 1;
			$sdt_schedules = $this->Sessions_model->get_sdt_schedules($sdt_type);
			$list = '';
			foreach($sdt_schedules as $schedule)
			{
				$list .= '<option value="'.$schedule['endmschedule_id'].'">'.$schedule['endmschedule_title'].' ('.$schedule['phase_name'].') ('.date("d F, Y", strtotime($schedule['endmschedule_from_date'])).'  To   '.date("d F, Y", strtotime($schedule['endmschedule_to_date'])).')</option>';
			}
			$content = '<div class="form-group">
							<label class="col-md-8 control-label">Select SDT '.$sdt_type.' Schedule</label>
							<div class="col-md-4">
								<select name="schedule_id" data-session-type="SDT" id="onchnageScheduleId" class="form-control">
									<option value="">Select Schedule</option>
									'.$list.'
								</select>
							</div>
						</div>';
		}elseif($session_type == 'SDT 2'){
			$sdt_type = 2;
			$sdt_schedules = $this->Sessions_model->get_sdt_schedules($sdt_type);
			$list = '';
			foreach($sdt_schedules as $schedule)
			{
				$list .= '<option value="'.$schedule['endmschedule_id'].'">'.$schedule['endmschedule_title'].' ('.$schedule['phase_name'].') ('.date("d F, Y", strtotime($schedule['endmschedule_from_date'])).'  To   '.date("d F, Y", strtotime($schedule['endmschedule_to_date'])).')</option>';
			}
			$content = '<div class="form-group">
							<label class="col-md-8 control-label">Select SDT '.$sdt_type.' Schedule</label>
							<div class="col-md-4">
								<select name="schedule_id" data-session-type="SDT" id="onchnageScheduleId" class="form-control">
									<option value="">Select Schedule</option>
									'.$list.'
								</select>
							</div>
						</div>';
		}elseif($session_type == 'WORKSHOP'){
			$workshop_schedules = $this->Sessions_model->get_workshop_schedules();
			$list = '';
			foreach($workshop_schedules as $schedule)
			{
				$list .= '<option value="'.$schedule['endmschedule_id'].'">'.$schedule['endmschedule_title'].' ('.$schedule['phase_name'].') ('.date("d F, Y", strtotime($schedule['endmschedule_from_date'])).'  To   '.date("d F, Y", strtotime($schedule['endmschedule_to_date'])).')</option>';
			}
			$content = '<div class="form-group">
							<label class="col-md-8 control-label">Select Workshop Schedule</label>
							<div class="col-md-4">
								<select name="schedule_id" data-session-type="WORKSHOP" id="onchnageScheduleId" class="form-control">
									<option value="">Select Schedule</option>
									'.$list.'
								</select>
							</div>
						</div>';
		}
		
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_center_schedule_ids()
	{
		$schedule_id = $this->input->post('schedule_id');
		$session_type = $this->input->post('session_type');
		
		if($session_type == 'SDT'){
			$sdt_schedules = $this->Sessions_model->get_sdt_center_schedules($schedule_id);
			$list = '';
			foreach($sdt_schedules as $schedule)
			{
				$list .= '<option value="'.$schedule['centerschdl_id'].'">'.$schedule['centerschdl_entryid'].' ('.$schedule['center_location'].')</option>';
			}
			$content = '<div class="form-group">
						<label class="col-md-8 control-label">Select Center ID</label>
						<div class="col-md-4">
							<select name="schedule_center_id" class="form-control">
								<option value="All">All</option>
								'.$list.'
							</select>
						</div>
					</div>';
		}elseif($session_type == 'WORKSHOP'){
			$workshop_schedules = $this->Sessions_model->get_workshop_center_schedules($schedule_id);
			$list = '';
			foreach($workshop_schedules as $schedule)
			{
				$list .= '<option value="'.$schedule['centerschdl_id'].'">'.$schedule['centerschdl_entryid'].' ('.$schedule['center_location'].')</option>';
			}
			$content = '<div class="form-group">
						<label class="col-md-8 control-label">Select Center ID</label>
						<div class="col-md-4">
							<select name="schedule_center_id" class="form-control">
								<option value="All">All</option>
								'.$list.'
							</select>
						</div>
					</div>';
		}
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	
}
