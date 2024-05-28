<?php 
	$row_info = $this->Zoom_model->get_info($id);
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
			<label class="col-md-8 control-label">Title</label>
			<div class="col-md-4">
				<input type="text" name="title" value="<?php echo $row_info['zoom_title'];?>" placeholder="RTC Name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Button Name</label>
			<div class="col-md-4">
				<input type="text" name="button_title" placeholder="Button Name" class="form-control" value="<?php echo $row_info['button_title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">RTC</label>
			<div class="col-md-4">
				<select name="type" id="type" class="form-control" required>
				<option value="">Select RTC</option>
				<?php 
					$rtc_info = $this->Zoom_model->get_rtc();
					foreach($rtc_info as $rtclst){
				?>				
				<option value="<?php echo $rtclst->batch_id;?>" <?php if ($rtclst->batch_id == $row_info['zoom_rtl']) { echo 'selected'; } ?>><?php echo $rtclst->batch_name.' - Batch '.$rtclst->batch;?></option>					
			<?php }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Zoom Link</label>
			<div class="col-md-4">
				<textarea name="details" class="form-control" cols="30" rows="5"><?php echo $row_info['zoom_link'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Date</label>
			<div class="col-md-4">
				<input type="text" name="event_date" class="form-control daterange-singledate" value="<?php echo $row_info['zoom_date'];?>">
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