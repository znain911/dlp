<?php
$phase_lavel = $this->session->userdata('active_phase');
$get_booking_details = $this->Booking_model->get_sdt_already_booked_details($phase_lavel, $sdt_type);
$details_content = '';
foreach($get_booking_details as $booking):

if($booking['endmschedule_student_resource']){
	$resource_download_link = attachment_url('resources/sdt/'.$booking['endmschedule_student_resource']);
}else{
	$resource_download_link = 'javascript:void(0)';
}
$details_content .= '<tr>
						<td class="text-center">'.$booking['endmschedule_title'].'</td>
						<td class="text-center">'.$booking['center_location'].'</td>
						<td class="text-center">'.date("d F, Y", strtotime($booking['centerschdl_to_date'])).' '.$booking['centerschdl_to_time'].'</td>
						<td class="text-center">'.date("d F, Y", strtotime($booking['booking_date'])).'</td>
						<td class="text-center"><a target="_blank" style="background: pink;color: #333;font-size: 12px;display: inline-block;padding: 3px 5px;text-decoration: none;" href="'.$resource_download_link.'">Download</a></td>
						<td class="text-center"><a class="press-to-evalutae" style="background: black;color: #FFF;font-size: 12px;display: inline-block;padding: 3px 5px;text-decoration: none;" booking-schedule-id="'.$booking['booking_schedule_id'].'" booking-schedule-centerid="'.$booking['booking_schedule_centerid'].'" booking-type="SDT" data-target="#evaluateToFaculty" data-toggle="modal" href="javascript:void(0);">Evaluate</a></td>
						<td class="text-center"><a style="background: green;color: #FFF;font-size: 12px;display: inline-block;padding: 3px 5px;text-decoration: none;" href="'.base_url('student/results').'">Result</a></td>
					</tr>
				   ';
endforeach;

echo $details_content;