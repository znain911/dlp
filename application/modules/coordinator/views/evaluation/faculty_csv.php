<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=faculty_evaluation_by_student_".$batchdtl->batch_name.".xls");
?>
<table border="1">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Faculty</th>
			<th>Evaluated By</th>
			<th class="text-center">Date</th>
			<th>Title</th>
			<th>Description</th>
			<?php $rhead = $this->Evaluation_model->get_ratingsby_heading();
			foreach($rhead as $head){?>
				<th><?php echo $head['eval_label']; ?></th>
			<?php } ?>
		</tr>										
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
			$inc = 1;
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['evaluation_id']; ?>">
		<td class="text-left"><?php echo $inc; ?></td>
		<td class="text-left"><?php echo $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name']; ?> (<?php echo $item['teacher_entryid']; ?>)</td>		
		<td class="text-left"><?php echo $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name']; ?> (<?php echo $item['student_finalid']; ?>)</td>
		<td class="text-center">
			<?php
				$time = strtotime($item['evaluation_create_date']);
				$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
				echo $myFormatForView;
			?>
		</td>
		<td class="text-left"><?php echo $item['evaluation_title']; ?></td>
		<td><?php echo $item['evaluation_description']; ?></td>
		<?php $ratings = $this->Evaluation_model->get_ratingsby_evaluationid($item['evaluation_id']);
		foreach($ratings as $rating){?>
			<th><?php echo $rating['rating_eval_rating']; ?></th>
		<?php } ?>
		</tr>
		<?php 
			$inc++;
			endforeach; 
		?>
	</tbody>
</table>