<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="result-crtft-cgp-panel">
						<h4 class="rslt-cgp-title">Exam Result</h4>
						<div class="row">
							<div class="col-lg-9">
								<div class="name-cgp-date">
									<div class="name-crse-title">
										<strong><?php echo $this->session->userdata('full_name'); ?></strong>
										<span>(Certificate course on diabetology)</span>
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="download-crtft-button">
									<strong>Download <br /> Certificate</strong>
								</div>
							</div>
						</div>
					</div>
					<?php $get_stid = $this->Result_model->get_pcastid();
						if(!empty($get_stid)){
					?>
					<div class="result-table">
						<p><strong>PCA 1 Results</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
                                    <th>Total Question</th>
                                    <th>Total Marks</th>
                                    <th>Pass Marks</th>
                                    <th>Questions Attempted</th>
                                    <th>Correct Answer</th>
                                    <th>Wrong Answer</th>
                                    <th>Marks Obtained</th>
                                    <th>Attempt</th>
                                    <th>Status</th>                                
                                </tr>
							</thead>
							<tbody>
								<?php
								
								$get_itemstest = $this->Result_model->getExamReport($get_stid->st_id);
/*echo $get_stid->st_name;*/
								/*print_r($get_itemstest);*/
									$i = 1;
								foreach($get_itemstest as $pca1){
									$rightans = (int)$pca1->total_marks / (int)1;
									$wrongans = (float)$pca1->negative_marks / (float)0.5;?>
								<tr>
									<td class="text-center">40</td>
									<td class="text-center">40</td>
									<td class="text-center">20</td>
									<td class="text-center"><?php echo $rightans + $wrongans;?></td>
									<td class="text-center"><?php echo $rightans; ?></td>
									<td class="text-center"><?php echo $wrongans;?></td>
									<td class="text-center"><?php echo $pca1->geting_marks; ?></td>
									<td class="text-center">Attempt <?php echo $i;?></td>
									<td class="text-center"><?php echo $pca1->result; ?></td>
									
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div>
						<?php } ?>
					<div class="result-table">
						<p><strong>PCA Results</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
									<th class="text-center">Examination</th>
									<th class="text-center">Your Score</th>
									<th class="text-center">Passing Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Result</th>
									<th class="text-center">Retake</th>
									<th class="text-center">Published Date</th>
								</tr>
							</thead>
							<!--<tbody>
								<?php
									$get_items = $this->Result_model->get_module_results();
									foreach($get_items as $item):
									$phase_array = array('1' => 'PCA - 1', '2' => 'PCA - 2', '3' => 'PCA - 3');
									$retake_times = $this->Result_model->count_retaketimes_pca($item['phase_id']);
								?>
								<tr>
									<td class="text-center"><?php echo $phase_array[$item['phase_id']]; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_number']; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_passing_number']; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_total_marks']; ?></td>
									<td class="text-center">
										<?php if($item['cmreport_status'] === '1'): ?>
										<strong style="color:#0a0">Passed</strong>
										<?php else: ?>
										<strong style="color:#F00">Failed</strong>
										<?php endif; ?>
									</td>
									<td class="text-center"><?php echo ($retake_times !== 0)? $retake_times : 'N/A'; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['cmreport_create_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>-->
						</table>
					</div>
					
					<br />
					
					<div class="result-table">
						<p><strong>SDT & WORKSHOP Result</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
									<th class="text-center">Examination</th>
									<th class="text-center">Your Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Published Date</th>
								</tr>
							</thead>
							<!--<tbody>
								<?php
									$get_sdt_items = $this->Result_model->get_sdt_scores();
									foreach($get_sdt_items as $item):
								?>
								<tr>
									<td class="text-center"><?php echo $item['endmschedule_title']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_score']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_total_score']; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['scrboard_published_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
								
								<?php
									$get_workshop_items = $this->Result_model->get_workshop_scores();
									foreach($get_workshop_items as $item):
								?>
								<tr>
									<td class="text-center"><?php echo $item['endmschedule_title']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_score']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_total_score']; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['scrboard_published_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>-->
						</table>
					</div>
					
					<br />
					
					<?php
						$ece_result = $this->Result_model->get_ece_result();
					?>
					<div class="result-table">
						<p><strong>ECE Result</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
									<th class="text-center">Examination</th>
									<th class="text-center">Result</th>
									<th class="text-center">Retake</th>
									<th class="text-center">Published Date</th>
								</tr>
							</thead>
							<tbody>
								<?php if($ece_result == true): ?>
								<tr>
									<td class="text-center">ECE</td>
									<td class="text-center">
										<?php if($ece_result['cpreport_exam_status'] === '1'): ?>
										<strong style="color:#0a0">Passed</strong>
										<?php else: ?>
										<strong style="color:#F00">Failed</strong>
										<?php endif; ?>
									</td>
									<td class="text-center"><?php echo ($ece_result['cpreport_has_retake'] !== '0')? $ece_result['cpreport_has_retake'] : 'N/A'; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($ece_result['cpreport_create_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
						<?php if($ece_result == true): ?>
						<div class="ece-label-marks">
							<table>
								<?php 
									$label_marks = $this->Result_model->get_label_marks($ece_result['cpreport_id']);
									foreach($label_marks as $mark):
								?>
								<tr>
									<td><strong><?php echo $mark['pmark_label']; ?> : </strong></td>
									<td>&nbsp; <?php echo $mark['pmark_number']; ?></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php endif; ?>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>