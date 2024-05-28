<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
				<?php $rtcdtl = $this->Student_model->rtc_info($dashboard_info['student_rtc']);
							if(!empty($rtcdtl)){?>
					<div class="result-crtft-cgp-panel">
						
						<h3 class="rslt-cgp-title">
							
							<?php 
							echo $rtcdtl->batch_name;?>
							<br>
							<small>
								Faculty name: <?php $fclt = $this->Student_model->rtc_faculty_info($rtcdtl->batch_id);
								if(!empty($fclt)){								
							echo $fclt->tpinfo_first_name.' '.$fclt->tpinfo_middle_name.' '.$fclt->tpinfo_last_name;?><br>
							Faculty Phone: <?php echo $fclt->tpinfo_personal_phone; ?>
								<?php }else{
									echo 'No teacher assign in this RTC';
								}?>
							</small>
							
						</h3>
						<!--<a href="#" data-target="#myModal" data-toggle="modal" class="btn btn-info" style="background: green; color: #fff">Change RTC</a>-->
					</div>
					<div class="result-table">
					<h3 class="rslt-cgp-title">Other students in RTC</h3>
						<div class="tabbable-panel">
							<div class="tabbable-line">
								<table class="table rslt-tbl-row no-border custom_table no-footer dtr-inline">
													
									<thead>
										<tr>
											<th class="text-center">SL</th>
											<th class="text-center">ID</th>
											<th class="text-center">Name</th>
											<th class="text-center">Mobile Number</th>
											
										</tr>
									</thead>

									<tbody>
										<?php $stlist = $this->Student_model->get_students($dashboard_info['student_rtc']);
										$i=1;
										foreach ($stlist as $slist) {?>
										<tr>
										<td><?php echo $i;?></td>
										<td><?php echo $slist->student_finalid;?></td>
										<td><?php echo $slist->spinfo_first_name.' '.$slist->spinfo_middle_name.' '.$slist->spinfo_last_name;?></td>
										<td><?php echo $slist->spinfo_personal_phone;?></td>
										
										</tr>
										<?php $i++; } ?>
													
									</tbody>
								</table>
							</div>
						</div>
						
					</div>
					<?php }else{?>
					<div class="result-crtft-cgp-panel">						
						<h3 class="rslt-cgp-title">							
							No teacher assign in this RTC							
						</h3>						
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        	<h4 class="modal-title"><?php echo $rtcdtl->batch_name;?> <br> <small>Faculty: <?php $fclt = $this->Student_model->rtc_faculty_info($rtcdtl->batch_id);
							echo $fclt->tpinfo_first_name.' '.$fclt->tpinfo_middle_name.' '.$fclt->tpinfo_middle_name;?></small></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
         
			<h2>Are you sure you want to change RTC</h2>
			<a href="" class="btn btn-info" id="rtcshift">Yes</a>
			<a href="" class="btn btn-danger">No</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).on('click', '#rtcshift', function(e){
        e.preventDefault();

			var student_id = "<?php echo $dashboard_info['student_id'];?>";
					var batchid = "<?php echo $dashboard_info['student_rtc'];?>";
					var burl = "<?php echo base_url('student/rtc_change');?>";
					/*alert(burl);*/


        $.ajax({
           url: '<?php echo base_url('student/rtc_change');?>',
           type: 'POST',
           data: {student_id: student_id, batchid: batchid},
           error: function() {
              alert('Something is wrong');
           },
           success: function(data) {
                /*$("tbody").append("<tr><td>"+title+"</td><td>"+description+"</td></tr>");*/
                alert("Request Submited");  
                window.location.reload();
           }
        });


    });


</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>