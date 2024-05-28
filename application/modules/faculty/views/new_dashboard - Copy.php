<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div style="height: 50px; clear: both;"></div>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/1');?>" class="btn btn-lg bg-success">Phase 1<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/2');?>" class="btn btn-lg bg-primary">Phase 2<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/3');?>" class="btn btn-lg bg-info">Phase 3<br>Download Course Material</a>

				<h1><?php //echo $getrtc->batch_name; ?></h1>
				<div style="width: 100%; overflow: scroll;">
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>SL</th>
				        <th>ID</th>
				        <th>Name</th>
						<th>Phone</th>
				        <th>Phase 1 Module opened</th>
				        <th style="width:230px !important">Phase 1 Lesson Opened</th>
				        <th>Phase 1 End-Lesson_Exam status</th>
						<th>PCA-1 Status</th>
						<th>Phase 2 Module opened</th>
				        <th>Phase 2 Lesson Opened</th>
				        <th>Phase 2 End-Lesson_Exam status</th>
						<th>PCA-2 Status</th>
						<th>Phase 3 Module opened</th>
				        <th>Phase 3 Lesson Opened</th>
				        <th>Phase 3 End-Lesson_Exam status</th>
						<th>PCA-3 Status</th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php $i=1; foreach ($getstdnts as $stlist) {?>
				    	
				      <tr>
				        <td><?php echo $i;?></td>
				        <td><?php echo $stlist->student_finalid;?></td>
				        <td><?php echo $stlist->spinfo_first_name.' '.$stlist->spinfo_middle_name.' '.$stlist->spinfo_last_name;?></td>
						<td><?php echo $stlist->spinfo_personal_phone;?></td>
				        <td>
				        	<?php /*$mdlread = $this->Dashboard_model->get_phase1mdlopn($stlist->student_id, '1');
				        		$ttlph1mdl = $this->Dashboard_model->get_totalmodul('1');
								if(!empty($mdlread)){
									echo count($mdlread).' Out of '.count($ttlph1mdl);
								}else{
									echo '0 Out of '.count($ttlph1mdl);
								}*/
				        	?>
				        </td>
				        <td>
				        	<?php 
				        		/*foreach ($ttlph1mdl as $ph1mdl) {
				        			$str = $ph1mdl->module_name;
									$str = preg_replace('/\D/', '', $str);
									
				        			echo 'M'.$str.' - '.count($this->Dashboard_model->get_readedlessonbymodule($stlist->student_id,1,$ph1mdl->module_id)).' Out of '.count($this->Dashboard_model->get_totallesson(1,$ph1mdl->module_id)).',<br>';
				        		}*/
				        	?>
				        	
				        </td>
				        <td><?php /*echo count($this->Dashboard_model->get_lessonexam(1,$stlist->student_id)).' times';*/?></td>
				        <td>
				        	<?php /*$ph1status = $this->Dashboard_model->get_pcaexam(1,$stlist->student_id);
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
								}*/
				        	?>				        	
				        </td>
				        <td>
				        	<?php /*$mdlread2 = $this->Dashboard_model->get_phase1mdlopn($stlist->student_id, 2);
				        		$ttlph2mdl = $this->Dashboard_model->get_totalmodul(2);
								if(!empty($mdlread2)){
									echo count($mdlread2).' Out of '.count($ttlph2mdl);
								}else{
									echo '0 Out of '.count($ttlph2mdl);
								}*/
				        		/*echo count($mdlread2).' Out of '.count($ttlph2mdl);*/
				        	?>				        		
				        </td>
				        <td>
				        	<?php 
				        		/*foreach ($ttlph2mdl as $ph2mdl) {
				        			$str2 = $ph2mdl->module_name;
									$str2 = preg_replace('/\D/', '', $str);
				        			echo 'M'.$str2.' - '.count($this->Dashboard_model->get_readedlessonbymodule($stlist->student_id,2,$ph2mdl->module_id)).' Out of '.count($this->Dashboard_model->get_totallesson(2,$ph2mdl->module_id)).',<br>';
				        		}*/
				        	?>
				        </td>
				        <td><?php /*echo count($this->Dashboard_model->get_lessonexam(2,$stlist->student_id)).' times';*/?></td>
				        <td>
				        	<?php /*$ph2status = $this->Dashboard_model->get_pcaexam(2,$stlist->student_id);
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
								}*/
				        	?>
				        </td>
				        <td>
				        	<?php /*$mdlread3 = $this->Dashboard_model->get_phase1mdlopn($stlist->student_id, 3);
				        		$ttlph3mdl = $this->Dashboard_model->get_totalmodul(3);
								if(!empty($mdlread3)){
									echo count($mdlread3).' Out of '.count($ttlph3mdl);
								}else{
									echo '0 Out of '.count($ttlph3mdl);
								}*/
				        	?>				        		
				        </td>
				        <td>
				        	<?php 
				        		/*foreach ($ttlph3mdl as $ph3mdl) {
				        			$str3 = $ph3mdl->module_name;
									$str3 = preg_replace('/\D/', '', $str);
				        			echo 'M'.$str3.' - '.count($this->Dashboard_model->get_readedlessonbymodule($stlist->student_id,3,$ph3mdl->module_id)).' Out of '.count($this->Dashboard_model->get_totallesson(3,$ph3mdl->module_id)).',<br>';
				        		}*/
				        	?>
				        </td>
				        <td><?php /*echo count($this->Dashboard_model->get_lessonexam(3,$stlist->student_id)).' times';*/?></td>
				        <td>
				        	<?php /*$ph3status = $this->Dashboard_model->get_pcaexam(3,$stlist->student_id);
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
								}*/
				        	?>
				        </td>
				      </tr>	
				  <?php $i++; }?>
				    </tbody>
				  </table>
				</div>
				
				
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>