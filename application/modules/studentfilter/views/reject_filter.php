<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th nowrap>#ID</th>
											<th nowrap>Temp ID</th>
											<th class="text-center">Photo</th>
											<th class="text-center">Full Name</th>
											<th class="text-center">BMDC No</th>
											<th class="text-center">Designation</th>
											<th class="text-center">SSC Year</th>
											<th class="text-center">MBBS Year</th>
											<th class="text-center">Note</th>
											<th class="text-center">Status</th>
											<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
										<?php
										if(count($get_items) !== 0):
											foreach($get_items as $item):
											$photo = attachment_url('students/'.$item['student_entryid'].'/'.$item['spinfo_photo']);
											if($item['spinfo_middle_name'])
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
											}else
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
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
											
											<td class="text-center"><?php echo $item['spsinfo_bmanddc_number']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_designation']; ?></td>
											<?php $academyinfo = $this->Students_model->getStudentAcademyList($item['student_id']);
											if(!empty($academyinfo)){
											foreach($academyinfo as $acinfo){?>
											<td><?php echo $acinfo->sacinfo_year;?></td>
												<?php } }else{?>
													<td></td>
													<td></td>
												<?php }?>
											
											
											<td class="text-center"><?php echo $item['student_note']; ?></td>
											<td class="text-center item-row-status-<?php echo $item['student_id']; ?>">
												<?php if($item['student_status'] === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>
												<?php elseif($item['student_status'] === '5'): ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Rejected</span>	
												<?php else: ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
												<?php endif; ?>
											</td>
											<td><button data-status="0" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Restore</button></td>
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