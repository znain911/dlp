<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Students</a></li>
				<li><a href="javascript:;">Enrolled Students</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h2 class="page-header">Total Enrolled Students : <span id="totalEnrolledStudents"><?php echo count($totalenrlmnt) ?></span> | Total Active Batch : <span id="totalEnrolledStudents"><?php echo count($betchlist) ?></span></h2>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12">
					<!-- begin widget -->
					<div id="onPgaeLoadingForm"></div>

					<div style="vertical-align: middle; text-align: center;">
						<?php foreach ($betchlist as $btclist) {?>
							<a href="<?php echo base_url('coordinator/students/enrolled_student_bybatch/').$btclist->batch_id; ?>" class="btn btn-success"><?php echo $btclist->batch_name;?></a>
						<?php }?>
					</div>
					<div class="widget p-0">
						


						<div class="table-responsive">
							<div class="filtar-bar">
								<div class="limit-box">
									<p>
										<span>Sort By : &nbsp;&nbsp;</span>
										<select id="sortby" onchange="searchFilter()">
											<option value="DESC" selected="selected">New Student</option>
											<option value="ASC">Old Student</option>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<span>Show : &nbsp;&nbsp;</span>
										<?php 
											$value_array = array(10,20,30,40,50,60,70,80,90,100);
										?>
										<select name="limit" id="limit" onchange="searchFilter()">
											<option value="10" selected="selected">10</option>
											<?php 
												foreach($value_array as $array):
											?>
													<option value="<?php echo $array; ?>" <?php echo (isset($_GET['limit']) && $_GET['limit'] == $array)? 'selected' : null; ?>><?php echo $array; ?></option>
											<?php
												endforeach;
											?>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<span>From : &nbsp;&nbsp;</span>
										<input type="text" name="from" id="fromDate" onload="clearThis(this.value)" class="custominp daterange-singledate-from" placeholder="From" />
									</p>
								</div>
								<div class="limit-box">
									<p>
										<span>To : &nbsp;&nbsp;</span>
										<input type="text" name="to" id="toDate" onload="clearThis(this.value)" class="custominp daterange-singledate-to" placeholder="To" />
										<input type="submit" value="Search By Date" onclick="searchFilter()" style="height: 32px;" />
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<?php 
											$months = array(
																'01' => 'January',
																'02' => 'February',
																'03' => 'March',
																'04' => 'April',
																'05' => 'May',
																'06' => 'June',
																'07' => 'July',
																'08' => 'August',
																'09' => 'September',
																'10' => 'October',
																'11' => 'November',
																'12' => 'December',
															);
										?>
										<select name="month" id="month" onchange="searchFilter()">
											<option value="" selected="selected">All</option>
											<?php 
												foreach($months as $key => $month):
											?>
													<option value="<?php echo $key; ?>"><?php echo $month; ?></option>
											<?php
												endforeach;
											?>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<?php 
											$starting_date = 2019;
											$current_year = date("Y");
										?>
										<select name="year" id="year" onchange="searchFilter()">
											<option value="" selected="selected">All</option>
											<?php 
												for($i=$starting_date; $i < $current_year + 2;$i++):
											?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php
												endfor;
											?>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<select name="country" id="country" onchange="searchFilter()">
											<option value="" selected="selected">Country</option>
											<option value="18">Bangladesh</option>
											<option value="101">India</option>
										</select>
									</p>
								</div>
								<div class="search-box">
									<p><input type="text" id="keywords" placeholder="Search..." onkeyup="searchFilter()"/></p>
								</div>
							</div>
							<div id="postList">
								<table class="table table-td-valign-middle m-b-0">
									<thead>
										<tr>
											<th nowrap>Temp ID</th>
											<th nowrap>ID</th>
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
										<tr class="items-row-<?php echo $item['student_id']; ?>">
											<td><?php echo $item['student_tempid']; ?></td>
											<td><?php echo $item['student_entryid']; ?></td>
											<?php if($item['spinfo_photo']): ?>
											<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
											<?php else: ?>
											<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
											<?php endif; ?>
											<td class="text-center"><?php echo $full_name.$item['student_payment_status']; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['student_regdate'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['student_regdate'])); ?></td>
											<?php $onlinepay = $this->Students_model->get_onlinepayment_info($item['student_entryid']);
			$bankpay = $this->Students_model->get_depositpayment_info($item['student_entryid']);
			if(!empty($onlinepay)){
				echo '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
			}elseif (!empty($bankpay)) {
				echo '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
			}else{
				/*$date1=date_create($item['student_approve_date']);
				$date2=date_create(date("Y-m-d H:i:s"));
				$diff=date_diff($date1,$date2);
				$difdate = $diff->format("%a");
				if ($difdate > 4) {
					echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td>';
				}else{
					echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td>';
				}*/
				echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td>';
				
			}

			/*$date1=date_create($item['student_approve_date']);
				$date2=date_create(date("Y-m-d H:i:s"));
				$diff=date_diff($date1,$date2);
				$difdate = $diff->format("%a");

				$hour = $diff->h;

				echo $hour;*/

			?>



											<td class="text-center item-row-status-<?php echo $item['student_id']; ?>">
												<?php if($item['student_status'] === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>
												<?php else: ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
												<?php endif; ?>


											</td>
											<td class="text-center">
												<button data-student="<?php echo $item['student_id']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
												<button data-target="#modal-without-animation" data-toggle="modal" data-student="<?php echo $item['student_entryid']; ?>" class="row-action-payment btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-credit-card"></i> Payments</button>
												<span class="row-action-status-holder-<?php echo $item['student_id']; ?>">
													<?php if($item['student_status'] === '0'): ?>
													<button data-status="1" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Approve</button>
													<?php else: ?>
													<?php if(!empty($onlinepay) || !empty($bankpay)){?>
													<button data-status="2" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-info btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Verified Payment</button>
													<?php }?>
													<button data-status="0" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button>
													<?php endif; ?>
												</span>
												<!--<button data-student="<?php echo $item['student_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Reject</button>-->
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
							</div>
						</div>

<!-- <button type="button" class="btn btn-warning">Warning</button> -->
							
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			<div style="height: 10px; clear: both;"></div>
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				
				
			});
			
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>