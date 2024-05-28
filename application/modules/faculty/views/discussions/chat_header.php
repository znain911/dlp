<?php 
	$student_info = $this->Discussion_model->get_student_info_by_id($student_id); 
?>
<?php 
	$student_name = $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name'];
	$student_total_message = $this->Discussion_model->get_total_messages_by_student($student_id);
	if($student_info['spinfo_photo'])
	{
		$student_photo_url = attachment_url('students/'.$student_info['student_entryid'].'/'.$student_info['spinfo_photo']);
	}else
	{
		$student_photo_url = base_url('frontend/tools/default.png');
	}
?>
<div class="d-flex bd-highlight">
	<div class="img_cont">
		<img src="<?php echo $student_photo_url; ?>" class="rounded-circle user_img">
		<!--<span class="online_icon"></span>-->
	</div>
	<div class="user_info">
		<span>Chat with <?php echo $student_name; ?></span>
		<p><?php echo $student_total_message; ?> Messages</p>
	</div>
	<!--
	<div class="video_cam">
		<span><i class="fa fa-video-camera"></i></span>
		<span><i class="fa fa-phone"></i></span>
	</div>
	-->
</div>
<span id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
<div class="action_menu">
	<ul>
		<li><i class="fa fa-users"></i> Add to close friends</li>
		<li><i class="fa fa-plus"></i> Add to group</li>
		<li><i class="fa fa-ban"></i> Block</li>
	</ul>
</div>