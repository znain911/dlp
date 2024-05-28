<table border="1">
	<thead>
		<tr>
			<th style="font-size: 11px;" nowrap>#SL</th>
			<th style="font-size: 11px;" class="text-center">SDT ID</th>
			<th style="font-size: 11px;" class="text-center">Created Date</th>
			<th style="font-size: 11px;" class="text-center">Schedule</th>
			<th style="font-size: 11px;" class="text-center">Location</th>
			<th style="font-size: 11px;" class="text-center">Faculty</th>
			<th style="font-size: 11px;" class="text-center">Student</th>
			<th style="font-size: 11px;" class="text-center">Marks</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($get_items) !== 0):
			$sl = 1;
			foreach($get_items as $item):
			$student_info = $this->Sessions_model->get_student_personal_info($item['student_id']);
			$student_id = $item['student_id'];
			
			$faculties = $this->Sessions_model->get_sdt_booking_center_faculties($item['booking_schedule_centerid']);
			$faculty_list = '';
			if(is_array($faculties) && count($faculties) !== 0)
			{
				foreach($faculties as $faculty):
					
					if($faculty['tpinfo_middle_name'])
					{
						$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
					}else
					{
						$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_last_name'];
					}
					$faculty_list .= $full_name.', ';
				endforeach;
			}else{
				$faculty_list .= null;
			}
			
			
			if($student_info['spinfo_middle_name'])
			{
				$student_full_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name'];
			}else
			{
				$student_full_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_last_name'];
			}
			
			$score = $this->Sessions_model->get_sdt_score($item['student_id'], $item['booking_id']);
			
		?>
		<tr>
			<td style="font-size: 12px;"><?php echo $sl; ?></td>
			<td style="font-size: 12px;"><?php echo $item['centerschdl_entryid']; ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo date("d M, Y", strtotime($item['endmschedule_create_date'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['endmschedule_create_date'])); ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo date("d M, Y", strtotime($item['centerschdl_to_date'])).' '.$item['centerschdl_to_time']; ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo $item['center_location']; ?></td>
			<td style="font-size: 12px;" class="text-center"><?php echo substr($faculty_list, 0, -2); ?></td>
			<td style="font-size: 12px;" class="text-center"><a href="javascript:void(0)" style="text-decoration:none;color:#00a" class="row-action-view-student" data-student="<?php echo $student_id; ?>"><?php echo $student_full_name; ?></a></td>
			<td style="font-size: 12px;" class="text-center"><?php echo ($score == true)? $score['scrboard_score'].' of '.$score['scrboard_total_score'] : null; ?></td>
		</tr>
		<?php 
			$sl++;
			endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="8"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>