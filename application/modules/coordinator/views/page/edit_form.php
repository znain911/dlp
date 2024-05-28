<?php 
	$row_info = $this->Page_model->get_info($id);
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
				<input type="text" name="title" placeholder="Enter Title" class="form-control" value="<?php echo $row_info['page_title']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-6 control-label">Short Description</label>
			<div class="col-md-6">
				<textarea name="short_description" class="form-control" rows="5"><?php echo $row_info['page_short_description']; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Location</label>
			<div class="col-md-4">
				<?php
					$locations = array('1' => 'Header', '2' => 'Footer');
				?>
				<select name="location" class="form-control">
					<option value="">Select Page Location</option>
					<?php foreach($locations as $key => $location): ?>
						<option value="<?php echo $key; ?>" <?php echo ($row_info['page_location'] == $key)?  'selected' : null; ?>><?php echo $location; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-12 control-label">Description</label>
			<div class="col-md-12">
				<textarea name="details" class="textarea form-control ckeditor" rows="15" data-height="350"><?php echo $row_info['page_description']; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['page_action'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Published</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['page_action'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Unpublished</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit" onclick="document.getElementById('updateData').value=CKEDITOR.instances.details.getData();CKEDITOR.instances.details.destroy()">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>