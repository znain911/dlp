<?php 
	$row_info = $this->Batch_model->get_info($id);
?>
<div class="form-cntnt form-number-<?php echo $id; ?>">
	<h2 class="frm-title-ms">Edit</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'updateData');
		$hidden = array('id' => $id);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">RTC Name</label>
			<div class="col-md-4">
				<input type="text" name="batch_name" value="<?php echo $row_info['batch_name'];?>" placeholder="RTC Name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Batch</label>
			<div class="col-md-4">
				<select name="batch" id="batch" class="form-control" required>
					<option value="">-- Select Batch --</option>
					<?php $btchlist = $this->Batch_model->get_batchforrtc();
					foreach ($btchlist as $tlist) {?>
					<option value="<?php echo $tlist->btc_name;?>" <?php if($row_info['batch'] == $tlist->btc_name){ echo 'selected'; } ?>><?php echo $tlist->btc_name;?></option>
					 <?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Number of Students</label>
			<div class="col-md-4">
				<input type="text" name="studentno" value="<?php echo $row_info['number_of_students'];?>" placeholder="Number of Students" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>