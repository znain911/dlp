<!-- begin widget -->
<div id="onPgaeLoadingForm">
	
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th nowrap>Student ID</th>
						<th class="text-center">Full Name</th>
						<th class="text-center">Current RTC</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
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
						
						<td class="text-center">
							<button data-student="<?php echo $item->student_id; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> Personal & Academic Details</button>
							<?php if($item->shift_stutus === '1'): ?>
							<button class="row-action-batch btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-exchange"></i> Shifted</button>
							<?php else: ?>
								<button data-target="#modal-batch-assing" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" data-shiftid="<?php echo $item->shift_id; ?>" class="row-action-batch btn btn-info btn-xs p-l-10 p-r-10"><i class="fa fa-exchange"></i> Transfer RTC</button>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->