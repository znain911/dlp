<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th nowrap>#ID</th>
			<th nowrap>Temp ID</th>
			<th class="text-center">Photo</th>
			<th class="text-center">Full Name</th>
			<th class="text-center">Class Shift Choice</th>
			<th class="text-center">Enrolled ID</th>
			<th class="text-center">Phone Number</th>
			<th class="text-center">Register Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($get_items) !== 0):
			foreach($get_items as $item):
			$photo = base_url('attachments/students/'.$item['student_entryid'].'/'.$item['spinfo_photo']);
			if($item['spinfo_middle_name'])
			{
				$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
			}else
			{
				$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
			}
			if ($item['student_shift_choice']==1) {
												$shift = 'I can study in Any Shift.';
											}elseif($item['student_shift_choice']==2){
												$shift = 'I prefer Morning Shift but I shall be able to attend Evening Shift if needed.';
											}elseif($item['student_shift_choice']==3){
												$shift = 'I prefer Evening Shift but I shall be able to attend Morning  Shift if needed.';
											}elseif($item['student_shift_choice']==4){
												$shift = 'I need Morning Shift and I shall not be able to join the course in Evening shift.';
											}elseif($item['student_shift_choice']==5){
												$shift = 'I need Evening Shift and I shall not be able to join the course in Morning shift.';
											}else{
												$shift = 'N/A';
											}
		?>
		<tr class="items-row-<?php echo $item['student_id']; ?>">
			<td><?php echo $item['student_entryid']; ?></td>
			<td><?php echo $item['student_tempid']; ?></td>
			<?php if($item['spinfo_photo']): ?>
			<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
			<?php else: ?>
			<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
			<?php endif; ?>
			<td class="text-center"><?php echo $full_name; ?></td>
			<td class="text-center"><?php echo $shift; ?></td>
			<td class="text-center"><?php echo $item['student_finalid']; ?></td>
			<td class="text-center"><?php echo $item['spinfo_personal_phone']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['student_regdate'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['student_regdate'])); ?></td>
			<td class="text-center item-row-status-<?php echo $item['student_id']; ?>">
				<?php if($item['student_status'] === '1'): ?>
				<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>
				<?php else: ?>
				<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<button data-student="<?php echo $item['student_id']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
				<button data-student="<?php echo $item['student_id']; ?>" onclick="return confirm('Are you sure?', true);" class="remove-row btn btn-danger btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
				
			</td>
		</tr>
		<?php endforeach; ?>
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