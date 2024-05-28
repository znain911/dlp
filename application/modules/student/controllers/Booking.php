<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Booking_model');
		$this->load->model('Course_model');
	}
	
	public function ftwof()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_application_id'         => $this->input->post('applicant_ID'),
					'booking_user_id'                => $this->session->userdata('active_student'),
					'booking_user_type'              => 'Student',
					'booking_phase_level'            => $this->input->post('phase_level'),
					'booking_schedule_id'            => $this->input->post('schedule'),
					'booking_schedule_centerid'      => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$this->Booking_model->save_ftwofschedule_booking($data);
		
		//update center maximum sit
		$center_maximum_sit = $this->Booking_model->get_ftwofcentermaximum_sit($center_scheduleid);
		$minus_sit = $center_maximum_sit['centerschdl_maximum_sit'] - 1;
		$cnt_data = array(
						'centerschdl_maximum_sit' => $minus_sit,
					);
		$this->Booking_model->update_ftwofmaximum_sit($center_scheduleid, $cnt_data);
		
		//get instant center schedule details
		
		$content_session['display'] = true;
		$all_sessions = $this->load->view('session/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('session/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_user_id'                => $this->session->userdata('active_student'),
					'booking_user_type'              => 'Student',
					'booking_phase_level'            => $this->input->post('phase_level'),
					'booking_schedule_id'            => $this->input->post('schedule'),
					'booking_schedule_centerid'      => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$insid = $this->Booking_model->save_sdtschedule_booking($data);
		$sdtbooking_id = $this->db->insert_id($insid);
		
		//update booking application ID
		$applicant_ID = date("Ym").$sdtbooking_id;
		$cnt_data = array(
						'booking_application_id' => $applicant_ID,
					);
		$this->Booking_model->update_sdtbooking_id($sdtbooking_id, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$content_session['sdt_type'] = $this->input->post('sdt_type');
		$all_sessions = $this->load->view('sdt/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$content_booking['sdt_type'] = $this->input->post('sdt_type');
		$all_bookings = $this->load->view('sdt/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
						'booking_user_id'                => $this->session->userdata('active_student'),
						'booking_user_type'              => 'Student',
						'booking_phase_level'            => $this->input->post('phase_level'),
						'booking_schedule_id'            => $this->input->post('schedule'),
						'booking_schedule_centerid'      => $center_scheduleid,
						'booking_date'                   => date("Y-m-d H:i:s"),
						'booking_status'                 => 1,
					);
		$insid = $this->Booking_model->save_workshopschedule_booking($data);
		$workshop_id = $this->db->insert_id($insid);
		
		//update center maximum sit
		$applicant_ID = date("Ym").$workshop_id;
		$cnt_data = array(
						'booking_application_id' => $applicant_ID,
					);
		$this->Booking_model->update_workshop_booking($workshop_id, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$all_sessions = $this->load->view('workshop/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('workshop/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function eceexam()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
						'booking_user_id'                => $this->session->userdata('active_student'),
						'booking_user_type'              => 'Student',
						'booking_schedule_id'            => $this->input->post('schedule'),
						'booking_schedule_centerid'      => $center_scheduleid,
						'booking_date'                   => date("Y-m-d H:i:s"),
						'booking_status'                 => 1,
					);
		$insid = $this->Booking_model->save_eceschedule_booking($data);
		$ece_booking_id = $this->db->insert_id($insid);
		
		//update center maximum sit
		$applicant_ID = date("Ym").$ece_booking_id;
		$cnt_data = array(
						'booking_application_id' => $applicant_ID,
					);
		$this->Booking_model->update_ece_booking($ece_booking_id, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$all_sessions = $this->load->view('ece/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('ece/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('session/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function cntrsdl_details()
	{
		$centersdl_id = $this->input->post('cntr_id');
		echo $this->__get_centersdl_details($centersdl_id);
	}
	
	public function __get_centersdl_details($centersdl_id)
	{
		$center_schedule_info = $this->Course_model->get_center_schedule_info($centersdl_id);
		$content = '<div class="cntr-dt-bx">
						<h5>Center Details</h5>
						<table style="font-size: 12px; width: 100%;">
							<tr>
								<td class="text-left"><strong>Date : </strong></td>
								<td class="text-left">'.date("d F, Y", strtotime($center_schedule_info['centerschdl_to_date'])).'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Time : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_to_time'].'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Available Sit : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_maximum_sit'].'</td>
							</tr>
						</table>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
	}
	
	public function workshop_cntrsdl_details()
	{
		$centersdl_id = $this->input->post('cntr_id');
		echo $this->__get_workshop_centersdl_details($centersdl_id);
	}
	
	public function __get_workshop_centersdl_details($centersdl_id)
	{
		$center_schedule_info = $this->Course_model->get_workshop_center_schedule_info($centersdl_id);
		$content = '<div class="cntr-dt-bx">
						<h5>Center Details</h5>
						<table style="font-size: 12px; width: 100%;">
							<tr>
								<td class="text-left"><strong>Date : </strong></td>
								<td class="text-left">'.date("d F, Y", strtotime($center_schedule_info['centerschdl_to_date'])).'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Time : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_to_time'].'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Available Sit : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_maximum_sit'].'</td>
							</tr>
						</table>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
	}
	
	public function ece_cntrsdl_details()
	{
		$centersdl_id = $this->input->post('cntr_id');
		echo $this->__get_ece_centersdl_details($centersdl_id);
	}
	
	public function __get_ece_centersdl_details($centersdl_id)
	{
		$center_schedule_info = $this->Course_model->get_ece_center_schedule_info($centersdl_id);
		$content = '<div class="cntr-dt-bx">
						<h5>Center Details</h5>
						<table style="font-size: 12px; width: 100%;">
							<tr>
								<td class="text-left"><strong>Date : </strong></td>
								<td class="text-left">'.date("d F, Y", strtotime($center_schedule_info['centerschdl_to_date'])).'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Time : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_to_time'].'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Available Sit : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_maximum_sit'].'</td>
							</tr>
						</table>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
	}
	
	public function ece_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$content = $this->load->view('ece/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_frmsubmission()
	{
		$data['sdt_type'] = $this->input->post('get_sdt_type');
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('sdt/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('workshop/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_faculties_to_evaluate()
	{
		$booking_schedule_id       = $this->input->post('booking_schedule_id');
		$booking_schedule_centerid = $this->input->post('booking_schedule_centerid');
		$booking_type              = $this->input->post('booking_type');
		
		if($booking_type == 'SDT')
		{
			$faculties = $this->Booking_model->get_sdt_booking_center_faculties($booking_schedule_centerid);
			$faculty_list = '';
			if(is_array($faculties) && count($faculties) !== 0)
			{
				$sl = 1;
				foreach($faculties as $faculty):
					$faculty_entryid = $faculty['teacher_entryid'];
					$query_string = '(type=SDT&to='.$booking_schedule_id.'&rdr=apply)';
					$href = base_url('student/evaluation?centerscheduleID='.$booking_schedule_centerid.'&faculty='.$faculty_entryid.'&RDR=SDT&RETURN='.$query_string);
					
					if($faculty['tpinfo_middle_name'])
					{
						$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
					}else
					{
						$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_last_name'];
					}
					$faculty_list .= '<tr>
										<td>'.$sl.'</td>
										<td>'.$full_name.'</td>
										<td><a href="'.$href.'" style="background: black;color: #FFF;font-size: 12px;display: inline-block;padding: 3px 5px;text-decoration: none;">Evaluate</a></td>
									</tr>';
					$sl++;
				endforeach;
			}else{
				$faculty_list .= '<tr>
									<td colspan="3" class="text-center">No Faculty has been selected!</td>
								</tr>';
			}
			
			$content = '<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<td style="width:20%">SL. NO</td>
								<td>Faculty Name</td>
								<td>Evaluate</td>
							</tr>
						</thead>
						<tbody>
							'.$faculty_list.'
						</tbody>
					</table>';
					
			$result = array('status' => 'ok', 'content' => $content);
			echo json_encode($result);
			exit;
		}elseif($booking_type == 'WORKSHOP'){
			$faculties = $this->Booking_model->get_workshop_booking_center_faculties($booking_schedule_centerid);
			$faculty_list = '';
			if(is_array($faculties) && count($faculties) !== 0)
			{
				$sl = 1;
				foreach($faculties as $faculty):
					$faculty_entryid = $faculty['teacher_entryid'];
					$query_string = '(type=WORKSHOP&to='.$booking_schedule_id.'&rdr=apply)';
					$href = base_url('student/evaluation?centerscheduleID='.$booking_schedule_centerid.'&faculty='.$faculty_entryid.'&RDR=WORKSHOP&RETURN='.$query_string);
					
					if($faculty['tpinfo_middle_name'])
					{
						$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
					}else
					{
						$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_last_name'];
					}
					$faculty_list .= '<tr>
										<td>'.$sl.'</td>
										<td>'.$full_name.'</td>
										<td><a href="'.$href.'" style="background: black;color: #FFF;font-size: 12px;display: inline-block;padding: 3px 5px;text-decoration: none;">Evaluate</a></td>
									</tr>';
					$sl++;
				endforeach;
			}else{
				$faculty_list .= '<tr>
									<td colspan="3" class="text-center">No Faculty has been selected!</td>
								</tr>';
			}
			
			$content = '<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<td style="width:20%">SL. NO</td>
								<td>Faculty Name</td>
								<td>Evaluate</td>
							</tr>
						</thead>
						<tbody>
							'.$faculty_list.'
						</tbody>
					</table>';
					
			$result = array('status' => 'ok', 'content' => $content);
			echo json_encode($result);
			exit;
		}
	}
	
}