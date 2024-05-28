<?php require_once APPPATH.'modules/common/header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('backend/assets/css/event.css');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div style="height: 50px; clear: both;"></div>
				<!--<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/1');?>" class="btn btn-lg bg-success">Phase A<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/2');?>" class="btn btn-lg bg-primary">Phase B<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/3');?>" class="btn btn-lg bg-info">Phase C<br>Download Course Material</a>-->

				<?php 
				if($batch):
				$phase = $this->Dashboard_model->get_teacher_phase($batch->batch);
					//print_r($phase->student_phaselevel_id);
				?>
				<a style="text-transform: capitalize;" href="https://drive.google.com/drive/folders/1B0jQDJk8lCLLLvW-UdDAj1mAXjHGvKnE?usp=sharing" class="btn btn-lg <?php if($phase->student_phaselevel_id == 1){echo 'bg-success';}?>" target="_blank" >Phase A<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="https://drive.google.com/drive/folders/1UhI0iyYPwNR1ynkLLeJh8Kkpcj5gylHB?usp=sharing" class="btn btn-lg <?php if($phase->student_phaselevel_id == 2){echo 'bg-success';}?>" target="_blank" >Phase B<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="https://drive.google.com/drive/folders/1CXRq_IwuF9uYgZhMs9avKV7TgNFnynGa?usp=sharing" class="btn btn-lg <?php if($phase->student_phaselevel_id == 3){echo 'bg-success';}?>" target="_blank" >Phase C<br>Download Course Material</a>

				<?php 
				endif;
				if(empty($getrtc)){
					echo '<h1>No RTC Assign</h1>';
				}else{
				foreach($getrtc as $rtc){?>
					<h1><?php echo $rtc->batch_name; ?></h1>
				<div style="width: 100%; overflow: scroll;">
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>SL</th>
				        <th>ID</th>
				        <th>Name</th>
				        <th>Phone</th>
						<th>Email</th>
				        <th>Details</th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php 
					$getstdnts = $this->Dashboard_model->get_students($rtc->batch_id);
					$i=1; foreach ($getstdnts as $stlist) {?>
				    	
				      <tr>
				        <td><?php echo $i;?></td>
				        <td><?php echo $stlist->student_finalid;?></td>						
				        <td><?php echo $stlist->spinfo_first_name.' '.$stlist->spinfo_middle_name.' '.$stlist->spinfo_last_name;?></td>
						<td><?php echo $stlist->spinfo_personal_phone;?></td>
						<td><?php echo $stlist->student_email;?></td>
						<td><button data-target="#modal-batch-assing" data-toggle="modal" data-id="<?php echo $stlist->student_id; ?>" class="row-action-batch btn btn-info p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button></td>
				        
				      </tr>	
				  <?php $i++; }?>
				    </tbody>
				  </table>
				</div>
				<?php } } ?>
				<div class="evnts">
					<div style="height: 10px; clear: both;"></div>
					<div id="calendar_div">
						<?php echo $eventCalendar; ?>
					</div>
							
				</div>
				
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-batch-assing">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="float: left;">Student Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: left; color: red">X Close</button>
					</div>
					<div class="modal-body">
						<div class="tabbable-panel">
							<div class="tab-content" id="batchdata"></div>
						</div>
					</div>
					<div class="modal-footer">
			          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			        </div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function getCalendar(target_div, year, month){
			    $.get( '<?php echo base_url('faculty/dashboard/eventCalendar/'); ?>'+year+'/'+month, function( html ) {
			        $('#'+target_div).html(html);
			    });
			}

			function getEvents(date){
			    $.get( '<?php echo base_url('faculty/dashboard/getEvents/'); ?>'+date, function( html ) {
			        $('#event_list').html(html);
			    });
			}

			$(document).on('change', '.month-dropdown', function(){ 
				getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val());
			});
			$(document).on('change', '.year-dropdown', function(){ 
				getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val());
			});
		</script>
	<script type="text/javascript">
		$(document).on('click', '.row-action-batch', function(){
					var loaddata = '<h1><i class="fa fa-spinner fa-spin"></i></h1>';
					$('#batchdata').html(loaddata);
					var student_id = $(this).attr('data-id');
					/*alert(student_id);*/
					$.ajax({
						type: 'POST',
						url: baseUrl+'faculty/dashboard/student_details',
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
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>