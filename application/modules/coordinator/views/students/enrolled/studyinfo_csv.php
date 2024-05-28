<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename= $batchdtl->batch_name study_details.xls");
?>

<table border="1">
	<thead>
		<tr>
			<th>SL</th>
				        <th>ID</th>
				        <th>Name</th>
				        <th>Phone</th>
				        <th>Phase 1 Module opened</th>
				        <th style="width:230px !important">Phase 1 Lesson Opened</th>
				        <th>Phase 1 End-Lesson_Exam status</th>
				        <th>Phase 1 End-Lesson_Exam Result</th>
						<th>PCA-1 Status</th>
						<th>Phase 2 Module opened</th>
				        <th>Phase 2 Lesson Opened</th>
				        <th>Phase 2 End-Lesson_Exam status</th>
				        <th>Phase 2 End-Lesson_Exam Result</th>
						<th>PCA-2 Status</th>
						<th>Phase 3 Module opened</th>
				        <th>Phase 3 Lesson Opened</th>
				        <th>Phase 3 End-Lesson_Exam status</th>
				        <th>Phase 3 End-Lesson_Exam Result</th>
						<th>PCA-3 Status</th>




		</tr>										
	</thead>
	<tbody>
		<?php $i=1; foreach ($get_items as $stlist) {?>
				    	
				      <tr>
				        <td><?php echo $i;?></td>
				        <td><?php echo $stlist->student_finalid;?></td>
				        <td><?php echo $stlist->spinfo_first_name.' '.$stlist->spinfo_middle_name.' '.$stlist->spinfo_last_name;?></td>
				        <td><?php echo $stlist->spinfo_personal_phone;?></td>
				        <td>
				        	<?php $mdlread = $this->Students_model->get_phase1mdlopn($stlist->student_id, 1);
				        		$ttlph1mdl = $this->Students_model->get_totalmodul(1);
				        		if (empty($mdlread)) {
				        			echo '0 Out of '.count($ttlph1mdl);
				        		}else{
				        			echo count($mdlread).' Out of '.count($ttlph1mdl);
				        		}
				        		
				        	?>
				        </td>
				        <td>
				        	<?php 
				        		foreach ($ttlph1mdl as $ph1mdl) {
				        			$str = $ph1mdl->module_name;
									$str = preg_replace('/\D/', '', $str);
									/*echo $str;*/
				        			echo 'M'.$str.' - '.count($this->Students_model->get_readedlessonbymodule($stlist->student_id,1,$ph1mdl->module_id)).' Out of '.count($this->Students_model->get_totallesson(1,$ph1mdl->module_id)).',<br>';
				        		}
				        	?>
				        	
				        </td>
				        <td><?php echo count($this->Students_model->get_lessonexam(1,$stlist->student_id)).' times';?></td>
				        <td>
				        	<?php /* $stexam = $this->Students_model->getExam2($stlist->student_id, 1);
				        	if(!empty($stexam)){
					        	foreach ($stexam as $elist) {
					        		echo $elist->examcnt_date.' - '.$elist->lesson_title;
					        		echo '<br>';
					        		$total_right_answers = $this->Students_model->get_lesson_right_answers($elist->examcnt_id);
					        		$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
					        		echo 'Geting Score: '.$total_score;
					        		echo '<br>';
					        	}
					        }else{
					        	echo 'N/A';
					        } */
				        	?>				        		
				        </td>
				        
				        <td>
				        	<?php $ph1status = $this->Students_model->get_pcaexam(1,$stlist->student_id);
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
				        <td>
				        	<?php $mdlread2 = $this->Students_model->get_phase1mdlopn($stlist->student_id, 2);
				        		$ttlph2mdl = $this->Students_model->get_totalmodul(2);
				        		if (empty($mdlread2)) {
						        			echo '0 Out of '.count($ttlph2mdl);
						        		}else{
					        		echo count($mdlread2).' Out of '.count($ttlph2mdl);
					        	}
				        	?>				        		
				        </td>
				        <td>
				        	<?php 
				        		foreach ($ttlph2mdl as $ph2mdl) {
				        			$str2 = $ph2mdl->module_name;
									$str2 = preg_replace('/\D/', '', $str);
				        			echo 'M'.$str2.' - '.count($this->Students_model->get_readedlessonbymodule($stlist->student_id,2,$ph2mdl->module_id)).' Out of '.count($this->Students_model->get_totallesson(2,$ph2mdl->module_id)).',<br>';
				        		}
				        	?>
				        </td>
				        <td><?php echo count($this->Students_model->get_lessonexam(2,$stlist->student_id)).' times';?></td>
				        <td>
				        	<?php /* $stexam = $this->Students_model->getExam2($stlist->student_id, 2);
				        	if(!empty($stexam)){
					        	foreach ($stexam as $elist) {
					        		echo $elist->examcnt_date.' - '.$elist->lesson_title;
					        		echo '<br>';
					        		$total_right_answers = $this->Students_model->get_lesson_right_answers($elist->examcnt_id);
					        		$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
					        		echo 'Geting Score: '.$total_score;
					        		echo '<br>';
					        	}
					        }else{
					        	echo 'N/A';
					        } */
				        	?>				        		
				        </td>
				        <td>
				        	<?php $ph2status = $this->Students_model->get_pcaexam(2,$stlist->student_id);
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
				        <td>
				        	<?php $mdlread3 = $this->Students_model->get_phase1mdlopn($stlist->student_id, 3);
				        		$ttlph3mdl = $this->Students_model->get_totalmodul(3);
				        		if (empty($mdlread3)) {
				        			echo '0 Out of '.count($ttlph3mdl);
				        		}else{
				        			echo count($mdlread3).' Out of '.count($ttlph3mdl);
				        		}
				        		
				        	?>				        		
				        </td>
				        <td>
				        	<?php 
				        		foreach ($ttlph3mdl as $ph3mdl) {
				        			$str3 = $ph3mdl->module_name;
									$str3 = preg_replace('/\D/', '', $str);
				        			echo 'M'.$str3.' - '.count($this->Students_model->get_readedlessonbymodule($stlist->student_id,3,$ph3mdl->module_id)).' Out of '.count($this->Students_model->get_totallesson(3,$ph3mdl->module_id)).',<br>';
				        		}
				        	?>
				        </td>
				        <td><?php echo count($this->Students_model->get_lessonexam(3,$stlist->student_id)).' times';?></td>
				        <td>
				        	<?php /* $stexam = $this->Students_model->getExam2($stlist->student_id, 3);
				        	if(!empty($stexam)){
					        	foreach ($stexam as $elist) {
					        		echo $elist->examcnt_date.' - '.$elist->lesson_title;
					        		echo '<br>';
					        		$total_right_answers = $this->Students_model->get_lesson_right_answers($elist->examcnt_id);
					        		$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
					        		echo 'Geting Score: '.$total_score;
					        		echo '<br>';
					        	}
					        }else{
					        	echo 'N/A';
					        } */
				        	?>				        		
				        </td>
				        <td>
				        	<?php $ph3status = $this->Students_model->get_pcaexam(3,$stlist->student_id);
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
				  <?php $i++; }?>
	</tbody>
</table>