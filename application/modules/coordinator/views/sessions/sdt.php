<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Sessions</a></li>
				<li><a href="javascript:;">SDT <?php echo $sdt_type; ?></a></li>
			</ol>
			<!-- end breadcrumb -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12">
					<!-- begin widget -->
					<div id="onPgaeLoadingFormUp"></div>
					<div id="onPgaeLoadingForm"></div>
					<div class="widget p-0">
						<div class="table-responsive">
							<div class="filtar-bar">
								<div class="limit-box">
									<p>
										<span>View : &nbsp;&nbsp;</span>
										<select id="sortby" onchange="searchFilter()">
											<option value="DESC" selected="selected">New Sessions</option>
											<option value="ASC">Old Sessions</option>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<span>Limit : &nbsp;&nbsp;</span>
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
								<div class="search-box">
									<p><input type="text" id="keywords" placeholder="Search..." onkeyup="searchFilter()"/></p>
								</div>
							</div>
							<div id="postList">
								<table class="table table-td-valign-middle m-b-0">
									<thead>
										<tr>
											<th style="font-size: 11px;" nowrap>#SL</th>
											<th style="font-size: 11px;" class="text-center">SDT ID</th>
											<th style="font-size: 11px;" class="text-center">Created Date</th>
											<th style="font-size: 11px;" class="text-center">Schedule</th>
											<th style="font-size: 11px;" class="text-center">Location</th>
											<th style="font-size: 11px;" class="text-center">Faculty</th>
											<th style="font-size: 11px;" class="text-center">Student</th>
											<th style="font-size: 11px;" class="text-center">Material(Faculty)</th>
											<th style="font-size: 11px;" class="text-center">Material(Student)</th>
											<th style="font-size: 11px;" class="text-center">Evaluated by(Faculty)</th>
											<th style="font-size: 11px;" class="text-center">Evaluated by(Student)</th>
											<th style="font-size: 11px;" class="text-center">Marks</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(count($get_items) !== 0):
											$sl = 1;
											foreach($get_items as $item):
											$student_info = $this->Sessions_model->get_student_personal_info($item['student_id']);
											
											$faculty_full_name = null;
											$f_eval_id = 0;
											$s_eval_id = 0;
											
											$faculty_id = $this->Sessions_model->get_faculty_id($item['booking_schedule_centerid']);
											$student_id = $item['student_id'];
											if($faculty_id !== null)
											{
												$teacher_info = $this->Sessions_model->get_teacher_personal_info($faculty_id);
												if($teacher_info['tpinfo_middle_name'])
												{
													$faculty_full_name = $teacher_info['tpinfo_first_name'].' '.$teacher_info['tpinfo_middle_name'].' '.$teacher_info['tpinfo_last_name'];
												}else
												{
													$faculty_full_name = $teacher_info['tpinfo_first_name'].' '.$teacher_info['tpinfo_last_name'];
												}
												
												$faculty_eval_info = $this->Sessions_model->get_faculty_eval_info('SDT', $faculty_id, $student_id, $item['centerschdl_id']);
												$student_eval_info = $this->Sessions_model->get_student_eval_info('SDT', $faculty_id, $student_id, $item['centerschdl_id']);
												if($faculty_eval_info == true)
												{
													$f_eval_id = $faculty_eval_info['evaluation_id'];
												}else{
													$f_eval_id = 0;
												}
												if($student_eval_info == true)
												{
													$s_eval_id = $student_eval_info['evaluation_id'];
												}else{
													$s_eval_id = 0;
												}
											}
											
											
											if($student_info['spinfo_middle_name'])
											{
												$student_full_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name'];
											}else
											{
												$student_full_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_last_name'];
											}
											
											if($item['endmschedule_student_resource']){
												$student_resource_download_link = attachment_url('resources/sdt/'.$item['endmschedule_student_resource']);
											}else{
												$student_resource_download_link = 'javascript:void(0)';
											}
											
											if($item['endmschedule_faculty_resource']){
												$faculty_resource_download_link = attachment_url('resources/sdt/'.$item['endmschedule_faculty_resource']);
											}else{
												$faculty_resource_download_link = 'javascript:void(0)';
											}
											
											$score = $this->Sessions_model->get_sdt_score($item['student_id'], $item['booking_id']);
											
										?>
										<tr>
											<td style="font-size: 12px;"><?php echo $sl; ?></td>
											<td style="font-size: 12px;"><?php echo $item['centerschdl_entryid']; ?></td>
											<td style="font-size: 12px;" class="text-center"><?php echo date("d M, Y", strtotime($item['endmschedule_create_date'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['endmschedule_create_date'])); ?></td>
											<td style="font-size: 12px;" class="text-center"><?php echo date("d M, Y", strtotime($item['centerschdl_to_date'])).' '.$item['centerschdl_to_time']; ?></td>
											<td style="font-size: 12px;" class="text-center"><?php echo $item['center_location']; ?></td>
											<td style="font-size: 12px;" class="text-center"><a href="javascript:void(0)" class="row-action-view-center-fclts" data-schedule-centerid="<?php echo $item['booking_schedule_centerid']; ?>" data-booking-type="SDT" style="background: #a00;color: #FFF;padding: 2px 4px;border-radius: 3px;text-decoration: none;">View Faculties</a></td>
											<td style="font-size: 12px;" class="text-center"><a href="javascript:void(0)" style="text-decoration:none;color:#00a" class="row-action-view-student" data-student="<?php echo $student_id; ?>"><?php echo $student_full_name; ?></a></td>
											<td style="font-size: 12px;" class="text-center"><a href="<?php echo $faculty_resource_download_link; ?>" target="_blank" class="row-action-view btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</a></td>
											<td style="font-size: 12px;" class="text-center"><a href="<?php echo $student_resource_download_link; ?>" target="_blank" class="row-action-view btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</a></td>
											<td style="font-size: 12px;" class="text-center"><button data-item="<?php echo $f_eval_id; ?>" class="row-action-view-evl-fclt btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button></td>
											<td style="font-size: 12px;" class="text-center"><button data-schedule-centerid="<?php echo $item['booking_schedule_centerid']; ?>" data-booking-type="SDT" data-student-id="<?php echo $item['student_id']; ?>" class="row-action-view-multiple-fclts btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button></td>
											<td style="font-size: 12px;" class="text-center"><?php echo ($score == true)? $score['scrboard_score'].' of '.$score['scrboard_total_score'] : null; ?></td>
										</tr>
										<?php 
											$sl++;
											endforeach; ?>
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
				
				$(document).on('click', '.row-action-view-student', function(){
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
				
				$(document).on('click', '.row-action-view-evl-fclt', function(){
					$('#onPgaeLoadingForm').html('');
					var lesson_id = $(this).attr('data-item');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/evaluation/view",
						data : {evaluation:lesson_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content);
								$('#mdlBoxLoader').hide();
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				});
				
				$(document).on('click', '.row-action-view-center-fclts', function(){
					$('#onPgaeLoadingForm').html('');
					var centerschdl_id = $(this).attr('data-schedule-centerid');
					var booking_type = $(this).attr('data-booking-type');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/evaluation/view_center_faculties",
						data : {centerschdl_id:centerschdl_id, booking_type:booking_type, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content);
								$('#mdlBoxLoader').hide();
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				});
				
				$(document).on('click', '.row-action-view-multiple-fclts', function(){
					$('#onPgaeLoadingForm').html('');
					$('#onPgaeLoadingFormUp').html('');
					var centerschdl_id = $(this).attr('data-schedule-centerid');
					var booking_type = $(this).attr('data-booking-type');
					var student_id = $(this).attr('data-student-id');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/evaluation/view_multiple_faculties",
						data : {centerschdl_id:centerschdl_id, booking_type:booking_type, student_id:student_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content);
								$('#mdlBoxLoader').hide();
								
								$(document).on('click', '.row-action-view-evl', function(){
									var lesson_id = $(this).attr('data-item');
									$.ajax({
										type : "POST",
										url : baseUrl + "coordinator/evaluation/facultyview",
										data : {evaluation:lesson_id, _jwar_t_kn_:sqtoken_hash},
										dataType : "json",
										beforeSend: function(){
											$('#mdlBoxLoader').show();
										},
										success : function (data) {
											if(data.status == "ok")
											{
												$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
												sqtoken_hash=data._jwar_t_kn_;
												$('#onPgaeLoadingFormUp').html(data.content);
												$('#mdlBoxLoader').hide();
												return false;
											}else
											{
												//have end check.
											}
											return false;
										}
									});
								});
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
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
				var sdt_type = '<?php echo $sdt_type; ?>';
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>sessionfilter/get_sdt_sessions/'+page_num,
					data:'page='+page_num+'&keywords='+keywords+'&sdt_type='+sdt_type+'&sortby='+sortby+'&limit='+limit+'&from_date='+fromDate+'&to_date='+toDate+'&month='+month+'&year='+year+'&_jwar_t_kn_='+sqtoken_hash,
					dataType:'json',
					beforeSend: function () {
						
					},
					success: function (data) {
						if(data.status == 'ok')
						{
							$('#postList').html(data.content);
							$('#totalPendingStudents').html(data.total_rows);
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