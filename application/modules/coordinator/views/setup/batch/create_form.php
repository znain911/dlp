<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createData');
		echo form_open('#', $attr);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-8 control-label">RCT Name</label>
			<div class="col-md-4">
				<input type="text" name="batch_name" placeholder="Enter RTC" class="form-control" value="RTC">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Batch</label>
			<div class="col-md-4">
				<select name="batch" id="batch" class="form-control" required>
					<option value="">-- Select Batch --</option>
					<?php $btchlist = $this->Batch_model->get_batchforrtc();
					foreach ($btchlist as $tlist) {?>
					<option value="<?php echo $tlist->btc_name;?>"><?php echo $tlist->btc_name;?></option>
					 <?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Number of Students</label>
			<div class="col-md-4">
				<input type="text" name="studentno" placeholder="Number of Students" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New</button>
</div>