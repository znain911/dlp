<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<div class="widget p-0" style="vertical-align: middle; text-align: center;">
						<?php foreach ($betchlist as $btclist) {?>
							<a href="<?php echo base_url('coordinator/students/enrolled_student_bybatch/').$btclist->batch_id; ?>" class="btn btn-success"><?php echo $btclist->batch_name;?></a>
						<?php }?>

						<a href="<?php echo base_url('coordinator/students/enrolled_dropout'); ?>" class="btn btn-danger">Dropout</a>
						<a href="<?php echo base_url('coordinator/students/enrolled_blocked'); ?>" class="btn btn-warning">Blocked</a>

<!-- <button type="button" class="btn btn-warning">Warning</button> -->
							
						</div>
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Students</a></li>
				<li><a href="javascript:;">Enrolled Students</a></li>
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
						<?php require_once APPPATH.'modules/coordinator/views/students/enrolled/enrolled_list.php'; ?>
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

		<div class="modal fade" id="modal-batch-assing">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">RTC Transfer</h4>
					</div>
					<div class="modal-body">
						<div class="tabbable-panel">
							<div class="tab-content" id="batchdata"></div>
						</div>
					</div>
					<div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        </div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				$(document).on('click', '.remove-row', function(){
					if(confirm('Are you sure?', true))
					{
						var id = $(this).attr('data-id');
						$('.items-row-'+id).remove();
						if(document.querySelector('.cnt-row'))
						{
							var total_row = document.querySelector('.cnt-row').length + 1;
						}else
						{
							var total_row = 1;
						}
						
						if(total_row == 1)
						{
							$('.appnd-not-fnd-row').html(not_data);
						}
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/setup/batch_delete',
							data:{id:id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function()
							{
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.form-number-'+id))
									{
										$('.form-number-'+id).remove();
										$('#onPgaeLoadingForm').html(data.content);
									}
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
									
									$("#createData").validate({
										rules:{
											title:{
												required: true,
											},
										},
										messages:{
											title:{
												required: null,
											},
										},
										submitHandler : function () {
											$('#loader').show();
											// your function if, validate is success
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/setup/batch_create",
												data : $('#createData').serialize(),
												dataType : "json",
												success : function (data) {
													if(data.status == "ok")
													{
														document.getElementById("createData").reset();
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#alert').html(data.success);
														$('#loader').hide();
														$('#getContents').html(data.content);
														$('#data-table').DataTable();
														return false;
													}else if(data.status == "error"){
														$('#alert').html(data.error);
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#loader').hide();
														return false;
													}else
													{
														//have end check.
													}
													return false;
												}
											});
										}
									});
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
				
				$(document).on('click', '.btn-remove-form', function(){
					$(this).parent().parent().parent().hide();
					$('.display-crtbtn').show();
				});
				
				$(document).on('click', '.display-create-frm', function(){
					$(this).parent().hide();
					$('.form-cntnt').show();
				});

				$(document).on('click', '.row-action-batch', function(){
					$('#batchdata').html('');
					var student_id = $(this).attr('data-student');
					/*alert(student_id);*/
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/rtc_transfer_view',
						data:{student_id:student_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
								sqtoken_hash = data._jwar_t_kn_;
								$('#batchdata').html(data.content).slideDown();
								return false;
							}else
							{
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


				$(document).on('click', '.unblockstudent', function(){
					var student_id = $(this).attr('data-student');
					/*alert(batchid);*/
					if(confirm('Are you sure?', true))
					{
						$('.items-row-'+student_id).remove();
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/student_unblocked',
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

				$(document).on('click', '.undropoutst', function(){
					var student_id = $(this).attr('data-student');
					/*alert(batchid);*/
					if(confirm('Are you sure?', true))
					{
						$('.items-row-'+student_id).remove();
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/student_undropout',
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
		</script>
	
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>