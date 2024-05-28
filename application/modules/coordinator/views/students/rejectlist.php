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
				<li><a href="javascript:;">Rejected Student List</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Rejected Student List : <span id="totalEnrolledStudents"><?php echo count($gettotal) ?></span></h1>
			<a href="<?php echo base_url('coordinator/students/rejectlist_csv');?>" class="btn btn-info pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</a>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12">
					<!-- begin widget -->
					<div id="onPgaeLoadingForm"></div>
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
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->
		<div class="modal payment-details-modal" id="modal-without-animation">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Payment Details</h4>
					</div>
					<div class="modal-body">
						<div class="tabbable-panel">
							<div class="tabbable-line">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_default_1" data-toggle="tab">
										Online Payments </a>
									</li>
									<li>
										<a href="#tab_default_2" data-toggle="tab">
										Bank Deposit </a>
									</li>
								</ul>
								<div class="tab-content" id="paymentContents"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.row-action-view', function(){
					$('#onPgaeLoadingForm').html('');
					var student_id = $(this).attr('data-student');
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/view',
						data:{student_id:student_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
								sqtoken_hash = data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content).slideDown();
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
				
				$(document).on('click', '.row-action-payment', function(){
					var student_id = $(this).attr('data-student');
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/payment_details',
						data:{sid:student_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
								sqtoken_hash = data._jwar_t_kn_;
								$('#paymentContents').html(data.content).slideDown();
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
				
				$(document).on('click', '.row-action-status', function(){
					var student_id = $(this).attr('data-student');
					var status_approve = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>';
					var status_decline = '<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Declined</span>';
					var staus = $(this).attr('data-status');
					var staus_action_approve = '<button data-status="1" data-student="'+student_id+'" class="row-action-status btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-cog"></i> Approve</button>';
					var staus_action_declined = '<button data-status="0" data-student="'+student_id+'" class="row-action-status btn btn-danger btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button>';
					if(staus == '1')
					{
						$('.item-row-status-'+student_id).html(status_approve);
						$('.row-action-status-holder-'+student_id).html(staus_action_declined);
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/approve',
							data:{student_id:student_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else if(staus == '0')
					{
						$('.item-row-status-'+student_id).html(status_decline);
						$('.row-action-status-holder-'+student_id).html(staus_action_approve);
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/restored',
							data:{student_id:student_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else
					{
						return false;
					}
				});
				
				$(document).on('click', '.remove-row', function(){
					var student_id = $(this).attr('data-student');
					if(confirm('Are you sure?', true))
					{
						$('.items-row-'+student_id).remove();
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/delete',
							data:{student_id:student_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else
					{
						return false;
					}
				});
			});
			
			function searchFilter(page_num) {
				page_num = page_num?page_num:0;
				var keywords = $('#keywords').val();
				var sortby = $('#sortby').val();
				var limit = $('#limit').val();
				var fromDate = $('#fromDate').val();
				var toDate = $('#toDate').val();
				var month = $('#month').val();
				var year = $('#year').val();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>studentfilter/get_reject_student/'+page_num,
					data:'page='+page_num+'&keywords='+keywords+'&sortby='+sortby+'&limit='+limit+'&from_date='+fromDate+'&to_date='+toDate+'&month='+month+'&year='+year+'&_jwar_t_kn_='+sqtoken_hash,
					dataType:'json',
					beforeSend: function () {
						
					},
					success: function (data) {
						if(data.status == 'ok')
						{
							$('#postList').html(data.content);
							$('#totalEnrolledStudents').html(data.total_rows);
							sqtoken_hash = data._jwar_t_kn_;
						}else
						{
							return false;
						}
					}
				});
			}
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>