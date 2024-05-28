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
				<li><a href="javascript:;">Export</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Export Session Report</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div class="form-cntnt">
							<h2 class="frm-title-ms">Export Excel Report</h2>
							<?php 
								$attr = array('class' => 'form-horizontal', 'id' => 'configData');
								echo form_open('coordinator/sessions/excel', $attr);
							?>
								<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
								<div class="form-group">
									<div class="col-md-offset-6 col-md-6">
										<div id="alert"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Session Type</label>
									<div class="col-md-4">
										<select name="session_type" id="selectedSchedule" class="form-control">
											<option value="">Select Session Type</option>
											<option value="SDT 1">SDT 1</option>
											<option value="SDT 2">SDT 2</option>
											<option value="WORKSHOP">WORKSHOP</option>
										</select>
									</div>
								</div>
								<div id="scheduleContents"></div>
								<div id="idContents"></div>
								<div class="form-group">
									<label class="col-md-8 control-label">Export Report By</label>
									<div class="col-md-4">
										<select id="exportBy" name="export_by" class="form-control">
											<option value="DATE-TO-DATE" selected="selected">DATE-TO-DATE</option>
											<option value="MONTHLY">MONTHLY</option>
											<option value="YEARLY">YEARLY</option>
										</select>
									</div>
								</div>
								<div id="exportByContent">
									<div class="form-group">
										<label class="col-md-8 control-label"></label>
										<div class="col-md-4">
											<input type="text" name="from_date" class="custominp daterange-singledate" />&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;<input type="text" name="to_date" class="custominp daterange-singledate" />
										</div>
									</div>
								</div>
								<div class="generate-buttons text-right">
									<button class="btn btn-purple m-b-5" type="submit">Export Excel</button>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
			<?php
			//Months
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
				$months_string = '';
				foreach($months as $key => $month):
					$months_string .= '<option value="'.$key.'">'.$month.'</option>';
				endforeach;
			
			//Years 
				$starting_date = 2019;
				$current_year = date("Y");
				
				$years_string = '';
				for($i=$starting_date; $i < $current_year + 2;$i++):
					$years_string .= '<option value="'.$i.'">'.$i.'</option>';
				endfor;
			?>
		</div>
		<!-- end #content -->
		
		<script type="text/javascript">
			$("#configData").validate({
				rules:{
					session_type:{
						required: true,
					},
					exportBy:{
						required: true,
					},
					from_date:{
						required: true,
					},
					to_date:{
						required: true,
					},
					month:{
						required: true,
					},
					year:{
						required: true,
					},
				},
				messages:{
					session_type:{
						required: true,
					},
					exportBy:{
						required: true,
					},
					from_date:{
						required: true,
					},
					to_date:{
						required: true,
					},
					month:{
						required: true,
					},
					year:{
						required: true,
					},
				},
				submitHandler : function (form) {
					form.submit();
				}
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('change', '#exportBy', function(){
					var theValue = $(this).val();
					var months = '<?php echo $months_string; ?>';
					var years = '<?php echo $years_string; ?>';
					if(theValue == 'DATE-TO-DATE'){
						var content = '<div class="form-group">'+
										'<label class="col-md-8 control-label"></label>'+
										'<div class="col-md-4">'+
											'<input type="text" name="from_date" class="custominp daterange-singledate" />&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;<input type="text" name="to_date" class="custominp daterange-singledate" />'+
										'</div>'+
									'</div>';
						$('#exportByContent').html(content);
						$(".daterange-singledate").daterangepicker();
					}else if(theValue == 'MONTHLY'){
						var content = '<div class="form-group">'+
										'<label class="col-md-8 control-label"></label>'+
										'<div class="col-md-4">'+
											'<select name="month" class="custominp">'+
												'<option value="" selected="selected">Month</option>'+months+
											'</select>'+
											'<select name="year" class="custominp" style="margin-left: 10px;">'+
												'<option value="" selected="selected">Year</option>'+years+
											'</select>'+
										'</div>'+
									'</div>';
						$('#exportByContent').html(content);
					}else if(theValue == 'YEARLY'){
						var content = '<div class="form-group">'+
										'<label class="col-md-8 control-label"></label>'+
										'<div class="col-md-4">'+
											'<select name="year" class="custominp">'+
												'<option value="" selected="selected">Year</option>'+years+
											'</select>'+
										'</div>'+
									'</div>';
						$('#exportByContent').html(content);
					}else{
						return false;
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('change', '#selectedSchedule', function(){
					var theValue = $(this).val();
					if(theValue !== '')
					{
						$.ajax({
							type : "POST",
							url : baseUrl + "coordinator/sessions/get_schedules",
							data : {session_type:theValue},
							dataType : "json",
							success : function (data) {
								if(data.status == "ok")
								{
									$('#scheduleContents').html(data.content);
									$(document).on('change', '#onchnageScheduleId', function(){
										var schedule_id = $(this).val();
										var session_type = $(this).attr('data-session-type');
										if(schedule_id !== '')
										{
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/sessions/get_center_schedule_ids",
												data : {schedule_id:schedule_id, session_type:session_type},
												dataType : "json",
												success : function (data) {
													if(data.status == "ok")
													{
														$('#idContents').html(data.content);
														return false;
													}else{
														//have end check.
													}
													return false;
												}
											});
										}
									});
									return false;
								}else{
									//have end check.
								}
								return false;
							}
						});
					}else{
						$('#scheduleContents').html('');
						$('#idContents').html('');
					}
				});
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>