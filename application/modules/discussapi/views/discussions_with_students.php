<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th>Discuss ID</th>
			<th>By (Faculty)</th>
			<th>To (Student)</th>
			<th class="text-center">Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($get_items) !== 0):
			foreach($get_items as $item):
		?>
		<tr class="items-row-<?php echo $item['discuss_id']; ?>">
			<td><?php echo $item['discuss_slentry_number']; ?></td>
			<td><?php echo $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name'].'<strong style="color:#0a0">('.$item['teacher_entryid'].')</strong>'; ?></td>
			<td><?php echo $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'].'<strong style="color:#0a0">('.$item['student_entryid'].')</strong>'; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['discuss_created_date'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['discuss_created_date'])); ?></td>
			<td class="text-center item-row-status-<?php echo $item['discuss_id']; ?>">
				<?php if($item['discuss_has_deleted'] === 'NO'): ?>
				<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Active</span>
				<?php else: ?>
				<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Deleted</span>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<button data-target="#modal-without-animation" data-toggle="modal" data-id="<?php echo $item['discuss_id']; ?>" data-discuss-no="<?php echo $item['discuss_slentry_number']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
				<button data-id="<?php echo $item['discuss_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
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