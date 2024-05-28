<div class="form-cntnt lesson-form-number">
	<h2 class="frm-title-ms"><strong>Selected Faculties</strong></h2>
	<div class="lesson-information-content">
		<div class="less-content evaluation-content">
			<div class="reviews">
			  <div class="row blockquote review-item">
					<?php 
						if($booking_type == 'SDT')
						{
							$faculties = $this->Evaluation_model->get_sdt_booking_center_faculties($booking_schedule_centerid);
							$faculty_list = '';
							if(is_array($faculties) && count($faculties) !== 0)
							{
								$sl = 1;
								foreach($faculties as $faculty):
									
									if($faculty['tpinfo_middle_name'])
									{
										$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
									}else
									{
										$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_last_name'];
									}
									$student_eval_info = $this->Evaluation_model->get_student_eval_info($booking_type, $faculty['teacher_id'], $student_id, $booking_schedule_centerid);
									if($student_eval_info == true)
									{
										$s_eval_id = $student_eval_info['evaluation_id'];
									}else{
										$s_eval_id = 0;
									}
									$faculty_list .= '<tr>
														<td style="background: #F9F9F9;padding: 5px 10px;text-align: center;">'.$sl.'</td>
														<td style="padding: 5px 10px;background: #F0F0F0;">'.$full_name.'</td>
														<td style="padding: 5px 10px;background: #F0F0F0;"><span class="row-action-view-evl" data-item="'.$s_eval_id.'" style="background: #451;color: #FFF;font-size: 13px;padding: 3px 5px 4px 5px;border-radius: 3px;cursor: pointer;">View Evaluation</span></td>
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
												<td style="width:16%;background: #333;color: #FFF;">SL. NO</td>
												<td style="padding: 10px;background: #333;color: #FFF;">Faculty Name</td>
												<td style="padding: 10px;background: #333;color: #FFF;">Evaluation</td>
											</tr>
										</thead>
										<tbody>
											'.$faculty_list.'
										</tbody>
									</table>';
									
							echo $content;
						}elseif($booking_type == 'WORKSHOP'){
							$faculties = $this->Evaluation_model->get_workshop_booking_center_faculties($booking_schedule_centerid);
							$faculty_list = '';
							if(is_array($faculties) && count($faculties) !== 0)
							{
								$sl = 1;
								foreach($faculties as $faculty):
									
									if($faculty['tpinfo_middle_name'])
									{
										$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
									}else
									{
										$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_last_name'];
									}
									$student_eval_info = $this->Evaluation_model->get_student_eval_info($booking_type, $faculty['teacher_id'], $student_id, $booking_schedule_centerid);
									if($student_eval_info == true)
									{
										$s_eval_id = $student_eval_info['evaluation_id'];
									}else{
										$s_eval_id = 0;
									}
									$faculty_list .= '<tr>
														<td style="background: #F9F9F9;padding: 5px 10px;text-align: center;">'.$sl.'</td>
														<td style="padding: 5px 10px;background: #F0F0F0;">'.$full_name.'</td>
														<td style="padding: 5px 10px;background: #F0F0F0;"><span class="row-action-view-evl" data-item="'.$s_eval_id.'" style="background: #451;color: #FFF;font-size: 13px;padding: 3px 5px 4px 5px;border-radius: 3px;cursor: pointer;">View Evaluation</span></td>
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
												<td style="width:16%;background: #333;color: #FFF;">SL. NO</td>
												<td style="padding: 10px;background: #333;color: #FFF;">Faculty Name</td>
												<td style="padding: 10px;background: #333;color: #FFF;">Evaluation</td>
											</tr>
										</thead>
										<tbody>
											'.$faculty_list.'
										</tbody>
									</table>';
									
							echo $content;
						}
					?>
			  </div>  
			</div>
		</div>
	</div>
</div>