<!-- begin widget -->
<div id="onPgaeLoadingForm">
	
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th nowrap>#ID</th>
						<th class="text-center">Full Name</th>
						<th class="text-center">Photo</th>
						<th class="text-center">Faculty</th>
						<th class="text-center">Register Date</th>
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
						<?php if($item->spinfo_photo): ?>
						<td class="text-center"><img src="<?php echo base_url('attachments/students/'.$item->student_entryid.'/'.$item->spinfo_photo); ?>" width="40" alt="Photo"></td>
						<?php else: ?>
						<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
						<?php endif; ?>
						<td class="text-center"><?php if(!empty($get_faculty)){ echo $get_faculty->tpinfo_first_name.$get_faculty->tpinfo_middle_name.$get_faculty->tpinfo_last_name; }else{ echo 'No teacher assign in this RTC'; } ?></td>
						<td class="text-center">
							<?php
								$time = strtotime($item->student_regdate);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						
						<td class="text-center">
							<button data-student="<?php echo $item->student_id; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> Personal & Academic Details</button>
							<button data-target="#modal-stydydetail" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" class="row-action-study btn btn-success btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> Study details</button>
							<button data-target="#modal-batch-assing" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" class="row-action-batch btn btn-info btn-xs p-l-10 p-r-10"><i class="fa fa-exchange"></i> Transfer RTC</button>
							<button data-student="<?php echo $item->student_id; ?>" class="blockstudent btn btn-warning btn-xs p-l-10 p-r-10"><i class="fa fa-stop"></i> Block</button>
							<button data-student="<?php echo $item->student_id; ?>" class="dropoutst btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-crop"></i> Dropout</button>
							<!-- <a href="<?php echo base_url('coordinator/setup/batch_teacher/').$item->student_rtc; ?>" class="btn btn-warning btn-xs p-l-10 p-r-10" target="_blank"><i class="fa fa-eye"></i> View Faculty</a> -->
							<!-- <button data-status="0" data-student="<?php echo $item->student_id; ?>" class="row-action-status btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button> -->
							<a href="<?php echo base_url('coordinator/students/certificate_download/').$item->student_id.'/'.$item->student_entryid.'/'.$item->student_finalid;?>" class="btn btn-info btn-rounded btn-xs p-l-10 p-r-10">Export File</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->