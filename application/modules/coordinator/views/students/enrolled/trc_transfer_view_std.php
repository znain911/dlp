<!-- begin panel -->
	<div class="details-view-contnr items-row-<?php echo $item['student_id']; ?>">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-purple">
					<!-- <div class="panel-heading">
						<h4 class="panel-title">Personal Information</h4>
					</div> -->
					<div class="panel-body">
						<table class="table">
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Applicants ID : </strong></td>
								<td><?php echo $item['student_finalid']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Full Name : </strong></td>
								<td>
									<?php 
										if($item['spinfo_middle_name'])
										{
											$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
										}else
										{
											$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
										}
									?>
									<?php echo $full_name; ?>
								</td>
							</tr>
							
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Recent Photo : </strong></td>
								<td>
									<img src="<?php echo attachment_url('students/'.$item['student_entryid'].'/'.$item['spinfo_photo']); ?>" width="50" alt="" />
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>RTC : </strong></td>
								<td>
									<select name="batch" id="batch_dt" class="form-control">
										<option value="">-- Select batch --</option>
										<?php foreach ($betchlist as $blist) {
										$stdu = count($this->Students_model->getTotalBatchStdnt($blist->batch_id));		?>			
										<option value="<?php echo $blist->batch_id;?>" <?php if($item['student_rtc'] == $blist->batch_id){ echo 'selected'; }elseif($stdu == $blist->number_of_students){ echo 'disabled'; } ?>><?php echo $blist->batch_name;?> ---- (<?php echo count($this->Students_model->getTotalBatchStdnt($blist->batch_id)).'/'.$blist->number_of_students;?>)</option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</table>
						<input type="hidden" id="shefterid" name="" value="<?php echo $shiftid;?>" >
					</div>
				</div>
			</div>
			
			
			
			<div class="col-lg-12">
				<div class="details-action-sec">
					<button data-student="<?php echo $item['student_id']; ?>" class="assing-row btn btn-info btn-lg btn-rounded p-l-10 p-r-10"><i class="fa fa-times"></i> Transfer RTC</button>
				</div>
			</div>
		</div>
	</div>
<!-- end panel -->