
	<div class="details-view-contnr">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-purple">
					
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center" width="40%">Title</th>
									<th class="text-center">Data</th>
								</tr>
							</thead> 
							<tbody>								
								<tr>
									<td class="text-right">Phase A Module opened</td>
									<td class="text-center">
										<?php 
						        		if(!empty($mdlread)){
											echo count($mdlread).' Out of '.count($ttlph1mdl);
										}else{
											echo '0 Out of '.count($ttlph1mdl);
										} ?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">Phase A Lesson Opened</td>
									<td class="text-center">
										<?php 
						        		foreach ($ttlph1mdl as $ph1mdl) {
						        			$str = $ph1mdl->module_name;
											$str = preg_replace('/\D/', '', $str);
											/*echo $str;*/
						        			echo 'M'.$str.' - '.count($this->Students_model->get_readedlessonbymodule($studentid,1,$ph1mdl->module_id)).' Out of '.count($this->Students_model->get_totallesson(1,$ph1mdl->module_id)).',<br>';
						        		}
						        		?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">Phase A End-Lesson_Exam status</td>
									<td class="text-center">
										<?php echo count($this->Students_model->get_lessonexam(1,$studentid)).' times';?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">PCA-A Status</td>
									<td class="text-center">
										<?php $ph1status = $this->Students_model->get_pcaexam(1,$studentid);
										if(empty($ph1status)){
											echo 'N/A';
										}else{
											foreach ($ph1status as $examdata) {
												if ($examdata->cmreport_status==1) {
													echo 'Passed<br>';
												}else{
													echo 'Failed<br>';
												}
											}
										}
						        	?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">Phase B Module opened</td>
									<td class="text-center">
										<?php 
						        		if (empty($mdlread2)) {
						        			echo '0 Out of '.count($ttlph2mdl);
						        		}else{
						        			echo count($mdlread2).' Out of '.count($ttlph2mdl);
						        		} ?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">Phase B Lesson Opened</td>
									<td class="text-center">
										<?php 
							        		foreach ($ttlph2mdl as $ph2mdl) {
							        			/*echo $ph2mdl->module_name;*/
							        			$str2 = $ph2mdl->module_name;
												$str2 = preg_replace('/\D/', '', $str2);
							        			echo 'M'.$str2.' - '.count($this->Students_model->get_readedlessonbymodule($studentid,2,$ph2mdl->module_id)).' Out of '.count($this->Students_model->get_totallesson(2,$ph2mdl->module_id)).',<br>';
							        		}
							        	?>
									</td>									
								</tr>

								<tr>
									<td class="text-right">Phase B End-Lesson_Exam status</td>
									<td class="text-center">
										<?php echo count($this->Students_model->get_lessonexam(2,$studentid)).' times';?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">PCA-B Status</td>
									<td class="text-center">
										<?php $ph2status = $this->Students_model->get_pcaexam(2,$studentid);
										if(empty($ph2status)){
											echo 'N/A';
										}else{
											foreach ($ph2status as $examdata2) {
												if ($examdata2->cmreport_status==1) {
													echo 'Passed<br>';
												}else{
													echo 'Failed<br>';
												}
											}
										}
						        	?>
									</td>									
								</tr>
								<tr>
									<td class="text-right">Phase C Module opened</td>
									<td class="text-center">
										<?php 
						        		if (empty($mdlread3)) {
						        			echo '0 Out of '.count($ttlph3mdl);
						        		}else{
						        			echo count($mdlread3).' Out of '.count($ttlph3mdl);
						        		} ?>
									</td>									
								</tr>

								<tr>
									<td class="text-right">Phase C Lesson Opened</td>
									<td class="text-center">
										<?php 
							        		foreach ($ttlph3mdl as $ph3mdl) {
							        			$str3 = $ph3mdl->module_name;
												$str3 = preg_replace('/\D/', '', $str3);
							        			echo 'M'.$str3.' - '.count($this->Students_model->get_readedlessonbymodule($studentid,3,$ph3mdl->module_id)).' Out of '.count($this->Students_model->get_totallesson(3,$ph3mdl->module_id)).',<br>';
							        		}
							        	?>
									</td>
								</tr>

								<tr>
									<td class="text-right">Phase C End-Lesson_Exam status</td>
									<td class="text-center">
										<?php echo count($this->Students_model->get_lessonexam(3,$studentid)).' times';?>
									</td>
								</tr>
								<tr>
									<td class="text-right">PCA-C Status</td>
									<td class="text-center">
										<?php $ph3status = $this->Students_model->get_pcaexam(3,$studentid);
										if(empty($ph3status)){
									echo 'N/A';
								}else{
									foreach ($ph3status as $examdata3) {
										if ($examdata3->cmreport_status==1) {
											echo 'Passed<br>';
										}else{
											echo 'Failed<br>';
										}
									}
								}
						        	?>
									</td>									
								</tr>


							
							</tbody>
						</table>
						
						

					</div>
				</div>
			</div>
			
		</div>
	</div>
