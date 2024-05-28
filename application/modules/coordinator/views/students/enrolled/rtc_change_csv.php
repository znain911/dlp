<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=RTC_Change_Request.xls");
?>
<table border="1">
	<thead>
		<tr>
			<th nowrap>Student ID</th>
			<th class="text-center">Full Name</th>
			<th class="text-center">Current RTC</th>
			<th class="text-center">Status</th>
			<th class="text-center">Apply Date</th>
		</tr>										
	</thead>
	<tbody class="appnd-not-fnd-row">
					<?php
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item->student_id; ?>">
						<td class="text-center"><?php echo $item->student_finalid; ?></td>
						<td class="text-center"><?php echo $item->spinfo_first_name.' '.$item->spinfo_middle_name.' '.$item->spinfo_last_name; ?></td>
						
						
						<td class="text-center"><?php echo $item->batch_name; ?></td>
						<td class="text-center">
												<?php if($item->shift_stutus === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">TRC Shifted</span>
												<?php else: ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
												<?php endif; ?>
						</td>
						<td class="text-center"><?php echo $item->apply_date; ?></td>						
						
					</tr>
					<?php endforeach; ?>
				</tbody>
</table>