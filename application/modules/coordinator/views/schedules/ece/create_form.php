<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New Schedule</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createData', 'enctype' => 'multipart/form-data');
		echo form_open('#', $attr);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Title</label>
			<div class="col-md-4">
				<input type="text" name="schedule_title" placeholder="Enter Schedule Title" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Exam Type</label>
			<div class="col-md-4">
				<select name="exam_type" class="form-control">
					<?php 
						$exam_type_array = array('Regular' => 'Regular', 'Notcomplete' => 'Not Completed');
						foreach($exam_type_array as $exarray_key => $exarray_value):
					?>
						<option value="<?php echo $exarray_key; ?>"><?php echo $exarray_value; ?></option>
					<?php
						endforeach;
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule</label>
			<div class="col-md-4">
				<input type="text" name="from_date" class="custominp daterange-singledate" />&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;<input type="text" name="to_date" class="custominp daterange-singledate" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Upload Resource(Students)</label>
			<div class="col-md-4">
				<input type="file" name="students_resource" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Upload Resource(Faculties)</label>
			<div class="col-md-4">
				<input type="file" name="faculties_resource" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Schedule Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create New Schedule</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New Schedule</button>
</div>