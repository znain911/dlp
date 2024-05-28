<h1>STEP 1: ACCOUNT</h1>
<p><strong>Note</strong>: Students will need a valid email address and valid mobile number for registration. The email address needs to be provided in Step 1 for username and mobile number in Step 2 under contact information. Please note that the email address and mobile number will be used throughout the course to contact Student and count attendance in online class. <br> 
Students are advised to use email address and mobile number which they should maintain throughout the course. Requests for changing email address and mobile number will not be entertained once the student has already submitted registration.<br>
Students will need the followings for registration. Please ensure you have these in your pc/laptop/tablet pc/mobile before you proceed:<br>
1.	Soft copy image/photo of student (yourself) <br>
2.	Soft copy image/photo of NID (National Identification Card)<br>
3.	Soft copy image/photo of BMDC Certificate<br>
4.	Soft copy image/photo of SSC Certificate<br>
5.	Soft copy image/photo of MBBS Certificate<br>

</p>
<?php  
	$attr = array('id' => 'regStepOneStudent', 'class' => 'position-relative');
	echo form_open('', $attr);
?>
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
<div class="form-field-content">
	<input type="hidden" name="update" value="0" />
	<fieldset>
		<div class="form-group row">
		  <div class="col-md-12">
			<div id="messaging"></div>
		  </div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Email<span class="mdtry">*</span></label>
		  <div class="col-md-8">
			<input type="text" name="email" class="form-control" placeholder="Enter email"> 
			<p>Please use your own Email address, otherwise you will face problem during the course.</p>
		</div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Password<span class="mdtry">*</span></label>
		  <div class="col-md-8 position-relative">
			<input type="password" name="password" class="form-control" id="mainPass" placeholder="Enter password">
			<label class="pass-visibility-method"><input type="checkbox" onclick="displayMainPassword()"> Show password</label>
		  </div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Re-Password<span class="mdtry">*</span></label>
		  <div class="col-md-8 position-relative">
			<input type="password" name="re_password" class="form-control" id="confirmPass" placeholder="Re-enter password"> 
			<label class="pass-visibility-method"><input type="checkbox" onclick="displayConfirmPassword()"> Show password</label>
		  </div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Class Shift Choice Options<span class="mdtry">*</span></label>
		  <div class="col-md-8 position-relative">			
			<select class="form-control" name="student_shift_choice" id="student_shift_choice" required>
				<option value="">-- Select Class Shift --</option>
				<option value="1">I can study in Any Shift.</option>
				<option value="2">I prefer Morning Shift but I shall be able to attend Evening Shift if needed.</option>
				<option value="3">I prefer Evening Shift but I shall be able to attend Morning  Shift if needed.</option>
				<option value="4">I need Morning Shift and I shall not be able to join the course in Evening shift.</option>
				<option value="5">I need Evening Shift and I shall not be able to join the course in Morning shift.</option>
			</select>			
		  </div>
		</div>
	</fieldset>
</div>
<div class="form-submit-btn">
	<a href="https://www.dlpbadas-bd.org/" class="wzrd-submitbtn" style="background: #A00; float: left; width: auto ! important; padding: 20px; color: rgb(255, 255, 255);">CANCEL REGISTRATION</a>
	<button type="button" style="float: right;" class="wzrd-submitbtn" data-toggle="modal" data-target="#myModalr1">CONTINUE TO STEP 2 <br /> <span>Personal Information</span> <i class="fa fa-angle-right"></i></button>
	<div style="clear:both;"></div>
</div>
<div class="row">
<!-- Modal -->
<div id="myModalr1" class="modal fade" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title"><strong>Terms and Condition</strong></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>•	The duration of the CCD is 6 (six) months. CCD is managed by the CCD Software Application. Students of the CCD Course are assigned into different Regional Tutorial Centers (RTCs). Each RTC is managed by a Faculty of CCD. <br>
•	Prospective Students need to provide a valid email address, set a password, complete personal information form (Step 2) and professional information form (Step 3) to submit their applications. Students must ensure that BMDC certificates uploaded by Students match the BMDC certificate in BMDC Website. Otherwise DLP authority has every right to reject Student Application for CCD.<br>
•	Temporary Students are provided payment gateway through which they can deposit the course fee using 2 (two) methods: <br>
&nbsp;&nbsp;&nbsp; o	Online payment gateway – Temporary Students can choose this option to pay via debit, credit cards, mobile money providers and online banking gateways.<br>
&nbsp;&nbsp;&nbsp;o	Bank deposit method – Temporary Students choose this method to view the bank account details of DLP. The Temporary Students can deposit the course fee to the provided bank account details of DLP and upload the deposit slip. <br>
•	After payment of course fee, Temporary Students will have to wait a maximum period of 7 (seven) days to receive an automated response, from the CCD software Application, confirming payment. The automated response is sent in the form of SMS and Email. The automated response confirming payment is sent after Admin, CCD, approves the payment receipt through the CCD Software Application. Upon confirmation of payment Temporary Students are converted to Enrolled Students.<br>
•	Enrolled Students are then assigned to Regional Tutorial Centers (RTCs) in the CCD Software Application. After assigning to RTCs, students are provided a permanent Enrollment ID. <br>
•	The Enrollment ID is valid for a maximum 3 (three) years. Enrolled Students receive their Enrollment ID by an automated response from the CCD software Application in the form of SMS and Email. <br>
•	A single Faculty is assigned to a single RTC. The maximum capacity of a single RTC ranges between 15 seats to 40 seats. After 3 (three) years the Enrollment ID expires. After the expiry of an Enrollment ID, Enrolled Students becomes a new Prospective Student. <br>
•	All new Prospective Students need to pay the course fee for receiving the Enrollment ID. A student shall receive Enrollment ID of CCD if they fulfill the below 3 criteria: <br>
&nbsp;&nbsp;&nbsp;o	If approved for payment by CCD Course authorities <br>
&nbsp;&nbsp;&nbsp;o	Has paid course fee of CCD using either of the 2 (two) payment methods<br>
&nbsp;&nbsp;&nbsp;o	Has been assigned to RTC in the CCD Software Application. <br>
</p>
<div class="form-control" style="background:none !important;">
    <input  type="checkbox" class="" value="1" name="step1tc" id="step1tc" style="float:left; height: 20px; width: 20px;" >
    <label for="step1tc" style="float:left; font-size: 16px; text-align:left; padding-left: 10px;"><strong>I agree and shall abide the terms and conditions set by DLP Authorities</strong></label>
</div>
	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="wzrd-submitbtn">Submit</button>
      </div>
    </div>

  </div>
</div>
</div>
<?php echo form_close(); ?>