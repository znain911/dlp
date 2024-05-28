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
				<li><a href="javascript:;">Update Password and Email</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h2 class="page-header">Total : <span id="totalEnrolledStudents"><?php echo count($get_total) ?></span></h2>

			
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
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
												<th class="text-center">Phone</th>
												<th class="text-center">Email</th>
												<th class="text-center">RTC</th>
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
												
												<td class="text-center">
													<?php echo $item->spinfo_personal_phone; ?>
												</td>
												
												<td class="text-center">
													<?php echo $item->student_email; ?>
												</td>
												<td class="text-center">
													<?php
														/*$time = strtotime($item->student_regdate);
														$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
														echo $myFormatForView;*/
														echo $item->batch_name;
													?>
												</td>

												

												<td class="text-center">
													<button data-student="<?php echo $item->student_id; ?>" type="button" class="reset-pass btn btn-primary btn-sm">Reset Password</button>
													<button data-target="#email-form" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" type="button" class="reset-gmail btn btn-secondary btn-sm">Change Email</button>
													<button data-target="#mobile-form" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" type="button" class="reset-phone btn btn-info btn-sm">Change Phone</button>
													<input type="hidden" value = "<?php echo $item->spinfo_personal_phone; ?>">
													
												</td>
												
												
												<td class="text-center">
													<button data-student="<?php echo $item->student_id; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View Details</button>
													<!-- <button data-target="#modal-batch-assing" data-toggle="modal" data-student="<?php echo $item->student_id; ?>" class="row-action-batch btn btn-info btn-xs p-l-10 p-r-10"><i class="fa fa-exchange"></i> Transfer RTC</button> -->
													
													
												</td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->

		<div class="modal fade" id="email-form">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Change Email</h4>
					</div>
					
						<div class="modal-body">
							<div class="tabbable-panel">
								<div class="tab-content" id="batchdata">
									<label for="">Enter New email:</label>
									<input type="email" id="new-email" >
								</div>
							</div>
						</div>
						<div class="modal-footer">
						  <button type="submit" class="btn btn-primary email-id"  >Submit</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="mobile-form">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Change Phone Number</h4>
					</div>
					
						<div class="modal-body">
							<div class="tabbable-panel">
								<div class="tab-content" id="batchdata">
									<label for="">Enter 11 digit phone number:</label>
									<input type="number" id="new-phone" >
									<input type="hidden" id="present-phone">
								</div>
							</div>
						</div>
						<div class="modal-footer">
						  <button type="submit" class="btn btn-primary phone-id"  >Submit</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('.pass_email_page').addClass('active');
			
				

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
				
				$(document).on('click', '.reset-pass', function(){
					
					var student_id = $(this).attr('data-student');
					//alert(student_id);
					if (confirm('Are you sure you want to reset password?')) {
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/reset_pass',
							data:{student_id:student_id},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
								 //$('#onPgaeLoadingForm').html(data.content).slideDown();
									alert('Password Reset to 123456');
									return false;
								}else
								{
									alert(data.status)
									return false;
								}
							}
						});
					}
					
				});
				
				$(document).on('click', '.reset-gmail', function(){
					var student_id = $(this).attr('data-student');
					//alert(student_id);
					$('.email-id').val(student_id);
				});
				
				$(document).on('click', '.reset-phone', function(){
					var student_id = $(this).attr('data-student');
					var present = $(this).next().val();
					//alert(student_id);
					$('.phone-id').val(student_id);
					$('#present-phone').val(present);
				});
				
				$(document).on('click', '.phone-id', function(){
					var lenth = $("#new-phone").val().length;
					var phone = $("#new-phone").val();
					var present = $('#present-phone').val();
					var newPhone = '88' + phone;
					var student_id = $(this).val();
					if(lenth !== 11){
						alert('Phone number should be 11 digit');
						$("#new-phone").val(null);
					}else{
						if(present == newPhone){
							alert(newPhone + ' already exist. Please enter a 11 digit new number');
						}else{
							$.ajax({
								type: 'POST',
								url: baseUrl+'coordinator/students/reset_phone',
								data:{student_id:student_id, phone:newPhone},
								dataType: 'json',
								success: function(data)
								{
									if(data.status == 'ok')
									{
									 
										alert('Phone Reset to ' + data.content);
										$('#mobile-form').modal('toggle');
										
										window.location.reload();
										return false;
									}else
									{
										alert(data.status)
										return false;
									}
								}
							});
						}
					}
					
				  });
				
				$(document).on('click', '.email-id', function(){
					var student_id = $(this).val();
					var newEmail = $('#new-email').val();
					//alert(student_id);
					
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/reset_email',
						data:{student_id:student_id, newEmail:newEmail},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
							 //$('#onPgaeLoadingForm').html(data.content).slideDown();
								alert('Email Reset to ' + data.content);
								$('#email-form').modal('toggle');
								return false;
							}else
							{
								alert(data.status)
								return false;
							}
						}
					});
					
				});
				

				
				
				$(document).on('click', '.assing-row', function(){
					var student_id = $(this).attr('data-student');
					var batchid = $('#batch_dt option:selected').val();
					/*alert(batchid);*/
					if(confirm('Are you sure?', true))
					{
						/*$('.items-row-'+student_id).remove();*/
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/rtc_transferred',
							data:{student_id:student_id,batchid:batchid, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									/*$('#data-table').DataTable();*/
									$('#modal-batch-assing').modal('toggle');
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

				
		
		</script>
	
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>