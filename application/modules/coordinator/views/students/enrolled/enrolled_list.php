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
						<th class="text-center">Batch</th>
						<th class="text-center">RTC</th>
						<th class="text-center">Faculty</th>
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
						<?php if($item->spinfo_photo): ?>
						<td class="text-center"><img src="<?php echo base_url('attachments/students/'.$item->student_entryid.'/'.$item->spinfo_photo); ?>" width="40" alt="Photo"></td>
						<?php else: ?>
						<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
						<?php endif; ?>
						<td class="text-center">
							<?php echo $item->student_batch; ?>
						</td>
						<td class="text-center">
							<?php
								/*$time = strtotime($item->student_regdate);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;*/
								echo $item->batch_name;
							?>
						</td>

						<?php $fclt = $this->Students_model->get_teacher_batch($item->student_rtc); ?>
						<td class="text-center"><?php if(!empty($fclt)){ echo $fclt->tpinfo_first_name.' '.$fclt->tpinfo_middle_name.' '.$fclt->tpinfo_last_name; }else{ echo 'No teacher assign in this RTC'; } ?></td>

						<td class="text-center">
							<?php if($item->student_status === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Active</span>
												<?php elseif($item->student_status === '2'): ?>
												<span class="btn btn-warning btn-xs btn-rounded p-l-10 p-r-10">Blocked</span>
												<?php elseif($item->student_status === '3'): ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Dropout</span>
												<?php endif; ?>
						</td>
						
						
						<td class="text-center">
							<button data-student="<?php echo $item->student_id; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View Details</button>
							<!-- <button data-target="#modal-batch-assing" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" class="row-action-batch btn btn-info btn-xs p-l-10 p-r-10"><i class="fa fa-exchange"></i> Transfer RTC</button> -->
							<?php if($item->student_status === '2'){ ?>
							<button data-student="<?php echo $item->student_id; ?>" class="unblockstudent btn btn-warning btn-xs p-l-10 p-r-10"><i class="fa fa-stop"></i> Unblock</button>
						<?php }elseif($item->student_status === '3'){ ?>
							<button data-student="<?php echo $item->student_id; ?>" class="undropoutst btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-crop"></i> UnDropout</button>
						<?php }?>
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