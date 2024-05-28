<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<div class="widget p-0" style="vertical-align: middle; text-align: center;">
						

<!-- <button type="button" class="btn btn-warning">Warning</button> -->
							
						</div>
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Students</a></li>
				<li><a href="javascript:;">RTC Tranfer Request</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h2 class="page-header">RTC Tranfer Request</h2>
			<a href="<?php echo base_url('coordinator/students/rtcchange_csv');?>" class="btn btn-info pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</a>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/students/enrolled/change_list.php'; ?>
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

		<div class="modal fade" id="modal-stydydetail">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						
						<h4 class="modal-title" style="float: left;">Student Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: right; color: red">X Close</button>
					</div>
					<div class="modal-body">
						<div class="tabbable-panel">
							<div class="tab-content" id="studydetails"></div>
						</div>
					</div>
					<div class="modal-footer">
			          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
					var shift_id = $(this).attr('data-shiftid');
					/*alert(student_id);*/
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/rtc_transfer_view_std',
						data:{student_id:student_id,shift_id:shift_id, _jwar_t_kn_:sqtoken_hash},
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
					var sift_id = $('#shefterid').val();
					var batchid = $('#batch_dt option:selected').val();
					/*alert(sift_id);*/
					if(confirm('Are you sure?', true))
					{
						/*$('.items-row-'+student_id).remove();*/
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/rtc_transferredby_student',
							data:{student_id:student_id,batchid:batchid,sift_id:sift_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									$('#modal-batch-assing').modal('toggle');
									return false;
								}else
								{
									return false;
								}
							}
						});
						location.reload();
					}else
					{
						return false;
					}
				});



				
				
			});
		</script>
	
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>