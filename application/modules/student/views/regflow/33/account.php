<h1>STEP 1: ACCOUNT</h1>
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
	<a href="<?php echo site_url(); ?>" class="wzrd-submitbtn" style="background: #A00; float: left; width: auto ! important; padding: 20px; color: rgb(255, 255, 255);">CANCEL REGISTRATION</a>
	<button type="submit" style="float: right;" class="wzrd-submitbtn">CONTINUE TO STEP 2 <br /> <span>Personal Information</span> <i class="fa fa-angle-right"></i></button>
	<div style="clear:both;"></div>
</div>
<?php echo form_close(); ?>