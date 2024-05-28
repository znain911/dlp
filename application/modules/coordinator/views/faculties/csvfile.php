<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename= faculties.xls");
?>

<table border="1">
	<thead>
		<tr>
			<th nowrap>#ID</th>
			<th class="text-center">Photo</th>
			<th class="text-center">Full Name</th>
			<th class="text-center">Phone</th>
			<th class="text-center">RTC</th>
			<th class="text-center">Register Date</th>
			
		</tr>										
	</thead>
	<tbody>
		<?php foreach($get_items as $item){
			$photo = base_url('attachments/faculties/'.$item['teacher_entryid'].'/'.$item['tpinfo_photo']);
											if($item['tpinfo_middle_name'])
											{
												$full_name = $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name'];
											}else
											{
												$full_name = $item['tpinfo_first_name'].' '.$item['tpinfo_last_name'];
											}
			?>
		<tr>
			<td><?php echo $item['teacher_entryid']; ?></td>
			<?php if($item['tpinfo_photo']): ?>
											<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
											<?php else: ?>
											<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
											<?php endif; ?>
			<td><?php echo $full_name; ?></td>
			<td><?php echo $item['tpinfo_personal_phone']; ?></td>
			<td>
				<?php $tcrrtc = $this->Faculties_model->teacherrtc($item['teacher_id']);
				echo $tcrrtc->batch_name;
			?></td>
			<td><?php echo date("d M, Y", strtotime($item['teacher_regdate'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['teacher_regdate'])); ?></td>
			
		</tr>
	<?php }?>

		
										
	</tbody>
</table>