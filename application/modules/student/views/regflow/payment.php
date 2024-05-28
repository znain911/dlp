<!--<form id = "createform" method="post">
<div class = "col-sm-12 display2" style="margin: auto">
	<h4>Please select your choice of Course Platform type:-</h4>
	<div class = "row " >
	
			<div class="col-sm-2"  >
				<input type="radio" id="Online" class="apt" name="apt" value="Online">
	  			<label class = "ms" for="html" style =" color:black;">Online Course</label><br>
			</div>
			
			<div class="col-sm-2"  >
				<input type="radio" id="Offline" class="apt" name="apt" value="Offline">
	  			<label class = "ms" for="html" style =" color:black;">Offline Course</label><br>
			</div>
	</div>
	<button type="submit" class="btn btn-success submit" value = "Submit" style =" color:white; background-color: green;">Submit</button>
	</div>
</form>	-->
<?php  
	$attr = array('id' => 'regStepFiveStudent', 'class' => 'position-relative');
	echo form_open('', $attr);
	
	$fee_info = $this->Registration_model->get_payment_config();
	$student_info = $this->Registration_model->student_basic_info(html_escape($_GET['SID']));
	$paidinfo_online = $this->Registration_model->paidstudentonln($student_info['student_entryid']);
	$paidinfo_deposit = $this->Registration_model->paidstudentdpst($student_info['student_entryid']);
?>
<input type="hidden" name="SID" value="<?php echo (isset($_GET['PORT']))? $_GET['PORT'] : null; ?>" />
<input type="hidden" name="port" value="<?php echo (isset($_GET['SID']))? $_GET['SID'] : null; ?>" />
<input type="hidden" name="status" value="pay" />
<input type="hidden" name="rdr" value="online" />
<input type="hidden" name="confirm" value="1" />
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" />
</div>
	

<div class="display" >
<?php
if (!empty($paidinfo_online)) {?>
	<div class="payment-crsfee-focus">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong><?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?> You have already paid your course fee</strong></p>
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php }elseif (!empty($paidinfo_deposit)) {?>
<div class="payment-crsfee-focus">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong><?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?> You have already paid your course fee</strong></p>
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{
/*$date1=date_create($student_info['student_approve_date']);
	$date2=date_create(date("Y-m-d H:i:s"));
	$diff=date_diff($date1,$date2);
	$difdate = $diff->format("%a");
	if ($difdate < 4) {*/
	$today = date("Y-m-d");
	$expire = '2024-05-24'; 
	$today_time = strtotime($today);
	$expire_time = strtotime($expire);
	if ($expire_time > $today_time) {
?>
<div class="payment-crsfee-focus">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong><?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?> your course fee is : <?php echo ($fee_info['pconfig_course_fee'])? number_format($fee_info['pconfig_course_fee'],0) : null; ?> BDT</strong></p>
					<p>Upon payment you will receive a further SMS and Email. After processing your payment you will obtain your Student ID and be able to enroll in this course.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="std-payment-tabs">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 text-center">
				<div class="std-online-payment-tb">
					<h3 class="pmnt-tb-title">Online Payment</h3>
					<button type="submit" class="pay-to-online-btn">Pay Now</button>
					<div class="pay-with-tt">
						<img src="<?php echo base_url('frontend/tools/SSLCommerz-logo.png'); ?>" alt="Payment Methods" />
					</div>
				</div>
			</div>
			<div class="col-lg-6 text-center">
				<div class="std-bank-payment-tb">
					<h3 class="pmnt-tb-title">Bank Payment</h3>
					<span class="pay-to-online-btn" data-target="#myModalDeposit2" data-toggle="modal">Upload Deposit Slip </span>
					<div class="pay-with-tt-bank">
						<?php 
							$banks = $this->Registration_model->get_banks_details();
							foreach($banks as $bank):
							$photo = attachment_url('banks/'.$bank['bank_photo_icon']);
						?>
						<div class="bank-pay-details">
							<div class="bnk-logo">
								<img src="<?php echo $photo; ?>" alt="" />
							</div>
							<div class="bnk-details">
								<p><strong>Bank Name : </strong> <?php echo $bank['bank_name']; ?></p>
								<p><strong>Branch Name : </strong><?php echo $bank['bank_branch_name']; ?></p>
								<p><strong>Account Name : </strong> <?php echo $bank['bank_account_name']; ?></p>
								<p><strong>Account No : </strong><?php echo $bank['bank_account_number']; ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{?>
	<div class="payment-crsfee-focus">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong><?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?> Your payment link is expire</strong></p>
					<!--<p>Payment needs to be made within 96 hours (4 days) from approval date</p>-->
					<p>Payment needs to be made within 15th March 2023 from approval date</p>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php } } ?>
<?php echo form_close(); ?>
</div>

<div class="modal modal-info" id="myModalDeposit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
		<div class="modal-dialog animated zoomIn animated-3x" role="document">
		  <?php 
			$attributes = array('id' => 'depositType');
			echo form_open('javascript:void(0);', $attributes);
		  ?>
		  <div class="modal-content">
			<div id="depositLoader" class="loader disable-select"><img alt="" class="disable-select" src="<?php echo base_url('frontend/tools/loader.gif'); ?>"></div>
			<div class="modal-header">
			  <h3 class="modal-title" id="myModalLabel7">Upload Deposit Slip</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">
				  <i class="zmdi zmdi-close"></i>
				</span>
				<?php 
					if(isset($_GET['SID']) && $_GET['SID'] !== ''){
				?>
				<input type="hidden" name="portid" value="<?php echo $_GET['SID']; ?>" />
				<?php } ?>
			  </button>
			</div>
			<div class="modal-body">
			  <div id="errmsg" class="text-center"></div>
			  <div class="form-group row justify-content-end">
				<div class="col-lg-12">
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Name</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="fullname" readonly="true" value="<?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?>" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Phone</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="stphone" readonly="true" value="<?php echo $student_info['spinfo_personal_phone']; ?>" />
					  </div>
					</div>
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Temp ID</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="sttemp" readonly="true" value="<?php echo $student_info['student_tempid']; ?>" />
					  </div>
					</div>
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Bank Name</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Account Number</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="ac_number" placeholder="Enter Account Number" />
					  </div>
					</div>
					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Branch Name</label>
					  <div class="col-md-7">
						<input type="text" class="form-control" name="branch_name" placeholder="Enter Branch Name" />
					  </div>
					</div>

					
					<div class="form-group row">
					  <label for="" class="col-md-4 control-label text-right">Deposit Slip</label>
					  <div class="col-md-7">
							<input type="hidden" name="payment" value="Admission" />
							<!-- <input type="hidden" name="amount" value="<?php /*echo (isset($fee_info) && $fee_info['pconfig_course_fee'])? number_format($fee_info['pconfig_course_fee'],0) : null;*/ ?>" /> -->
							<input type="hidden" name="amount" value="<?php echo (isset($fee_info) && $fee_info['pconfig_course_fee'])? $fee_info['pconfig_course_fee'] : null; ?>" />
							<input type="file" style="position:static !important;opacity:1 !important;" name="slip" />
					  </div>
					</div>
				</div>
			  </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-info btn-raised" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn  btn-info btn-raised">Upload Slip</button>
			</div>
		  </div>
		  <?php echo form_close(); ?>
		</div>
	</div>
<script type="text/javascript">
//if (yourvar !== undefined)
$(document).ready(function(){
	$(document).on('click', '.submit', function(){
		var check_val = document.getElementsByName('apt');
		var st_id = <?php echo $student_info['student_id'];?>;
		
		var value;
		
		if(check_val[0].checked)
				{
					$('.display').show();
					$('.display2').hide();
					 value = document.getElementById('Online').value;
					
				}else if(check_val[1].checked)
				{
					$('.display').show();
					$('.display2').hide();
					 value = document.getElementById('Offline').value;
					
					
				}else{
					alert("Please select your choice of Course Platform type first");
				}
				
		if(value !== undefined){
			$("#createform").validate({
					rules:{
						
						
					},
					messages:{
						
						
					},
					submitHandler : function () {
						
						$.ajax({
							  type : "POST",
							  url: baseUrl + "student/onboard/applicant_type",
							   data : {value: value, st_id:st_id},
							  dataType : "json",
							  cache: false,
							 
					  });
					}
			});
		}
		
				
	});
});
</script>