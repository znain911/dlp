<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th style="font-size: 11px;" nowrap>#SL</th>
			<th style="font-size: 11px;" class="text-center">Workshop ID</th>
			<th style="font-size: 11px;" class="text-center">Created Date</th>
			<th style="font-size: 11px;" class="text-center">Schedule</th>
			<th style="font-size: 11px;" class="text-center">Location</th>
			<th style="font-size: 11px;" class="text-center">Faculty</th>
			<th style="font-size: 11px;" class="text-center">Student</th>
			<th style="font-size: 11px;" class="text-center">Material(Faculty)</th>
			<th style="font-size: 11px;" class="text-center">Material(Student)</th>
			<th style="font-size: 11px;" class="text-center">Evaluated by(Faculty)</th>
			<th style="font-size: 11px;" class="text-center">Evaluated by(Student)</th>
			<th style="font-size: 11px;" class="text-center">Marks</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($get_items) !== 0):
			$sl = $sl_no;
			foreach($get_items as $item):
			$student_info = $this->Sessions_model->get_student_personal_info($item['student_id']);
			
			$faculty_full_name = null;
			$f_eval_id = 0;
			$s_eval_id = 0;
			
			$faculty_id = $this->Sessions_model->get_faculty_id($item['booking_schedule_centerid']);
			$student_id = $item['student_id'];
			if($faculty_id !== null)
			{
				$teacher_info = $this->Sessions_model->get_teacher_personal_info($faculty_id);
				if($teacher_info['tpinfo_middle_name'])
				{
					$faculty_full_name = $teacher_info['tpinfo_first_name'].' '.$teacher_info['tpinfo_middle_name'].' '.$teacher_info['tpinfo_last_name'];
				}else
				{
					$faculty_full_name = $teacher_info['tpinfo_first_name'].' '.$teacher_info['tpinfo_last_name'];
				}
				
				$faculty_eval_info = $this->Sessions_model->get_faculty_eval_info('WORKSHOP', $faculty_id, $student_id, $item['centerschdl_id']);
				$student_eval_info = $this->Sessions_model->get_student_eval_info('WORKSHOP', $faculty_id, $student_id, $item['centerschdl_id']);
				if($faculty_eval_info == true)
				{
					$f_eval_id = $faculty_eval_info['evaluation_id'];
				}else{
					$f_eval_id = 0;
				}
				if($student_eval_info == true)
				{
					$s_eval_id = $student_eval_info['evaluation_id'];
				}else{
					$s_eval_id = 0;
				}
			}
			
			if($student_info['spinfo_middle_name'])
			{
				$student_full_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name'];
			}else
			{
				$student_full_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_last_name'];
			}
			
			if($item['endmschedule_student_resource']){
				$student_resource_download_link = attachment_url('resources/workshop/'.$item['endmschedule_student_resource']);
			}else{
				$student_resource_download_link = 'javascript:void(0)';
			}
			
			if($item['endmschedule_faculty_resource']){
				$faculty_resource_download_link = attachment_url('resources/workshop/'.$item['endmschedule_faculty_resource']);
			}else{
				$faculty_resource_download_link = 'javascript:void(0)';
			}
			
			$score = $this->Sessions_model->get_workshop_score($item['student_id'], $item['booking_id']);
		?>
		<tr>
			<td style="font-size: 12px;"><?php echo $sl; ?></td>
			<td style="font-size: 12px;"><?php echo $item['centerschdl_entryid']; ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo date("d M, Y", strtotime($item['endmschedule_create_date'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['endmschedule_create_date'])); ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo date("d M, Y", strtotime($item['centerschdl_to_date'])).' '.$item['centerschdl_to_time']; ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo $item['center_location']; ?></td>
			<td style="font-size: 12px;" class="text-center"><a href="javascript:void(0)" class="row-action-view-center-fclts" data-schedule-centerid="<?php echo $item['booking_schedule_centerid']; ?>" data-booking-type="WORKSHOP" style="background: #a00;color: #FFF;padding: 2px 4px;border-radius: 3px;text-decoration: none;">View Faculties</a></td>
			<td style="font-size: 12px;" class="text-center"><a href="javascript:void(0)" style="text-decoration:none;color:#00a" class="row-action-view-student" data-student="<?php echo $student_id; ?>"><?php echo $student_full_name; ?></a></td>
			<td style="font-size: 12px;" class="text-center"><a href="<?php echo $faculty_resource_download_link; ?>" target="_blank" class="row-action-view btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</a></td>
			<td style="font-size: 12px;" class="text-center"><a href="<?php echo $student_resource_download_link; ?>" target="_blank" class="row-action-view btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</a></td>
			<td style="font-size: 12px;" class="text-center"><button data-item="<?php echo $f_eval_id; ?>" class="row-action-view-evl-fclt btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button></td>
			<td style="font-size: 12px;" class="text-center"><button data-schedule-centerid="<?php echo $item['booking_schedule_centerid']; ?>" data-booking-type="WORKSHOP" data-student-id="<?php echo $item['student_id']; ?>" class="row-action-view-multiple-fclts btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button></td>
			<td style="font-size: 12px;" class="text-center"><?php echo ($score == true)? $score['scrboard_score'].' of '.$score['scrboard_total_score'] : null; ?></td>
		</tr>
		<?php 
			$sl++;
			endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<div class="page-contr">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>