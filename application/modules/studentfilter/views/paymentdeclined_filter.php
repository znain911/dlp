<table class="table table-td-valign-middle m-b-0">
									<thead>
										<tr>
											<th nowrap>#ID</th>
											<th class="text-center">Photo</th>
											<th class="text-center">Full Name</th>
											<th class="text-center">Register Date</th>
											<th class="text-center">Payment</th>
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
										?>

										<?php 
											/*$date1=date_create($item['student_approve_date']);
											$date2=date_create(date("Y-m-d H:i:s"));
											$diff=date_diff($date1,$date2);
											$difdate = $diff->format("%a");
											if ($difdate > 4) {*/
										?>


										<tr class="items-row-<?php echo $item['student_id']; ?>">
											<td><?php echo $item['student_entryid']; ?></td>
											<?php if($item['spinfo_photo']): ?>
											<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
											<?php else: ?>
											<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
											<?php endif; ?>
											<td class="text-center"><?php echo $full_name; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['student_regdate'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['student_regdate'])); ?></td>
			
										<!--<td class="text-center"><strong style="color:red">Unpaid</strong></td>-->
										<?php $onlinepay = $this->Students_model->get_onlinepayment_info($item['student_entryid']);
										$bankpay = $this->Students_model->get_depositpayment_info($item['student_entryid']);
										if(!empty($onlinepay)){
											echo '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
										}elseif (!empty($bankpay)) {
											echo '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
										}else{
											echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td>';				
										} ?>



											<td class="text-center item-row-status-<?php echo $item['student_id']; ?>">
												<?php if($item['student_status'] === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>
												<?php else: ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
												<?php endif;?>


											</td>
											<td class="text-center">
												<button data-student="<?php echo $item['student_id']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
												<button data-target="#modal-without-animation" data-toggle="modal" data-student="<?php echo $item['student_entryid']; ?>" class="row-action-payment btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-credit-card"></i> Payments</button>
												<span class="row-action-status-holder-<?php echo $item['student_id']; ?>">
													
													<button data-status="1" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-success btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Restore Approve</button>
													<button data-status="0" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Restore Pending</button>
													
												</span>
												<!--<button data-student="<?php echo $item['student_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Reject</button>-->
											</td>
										</tr>
										<?php /*}*/ endforeach; ?>
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