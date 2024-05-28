<?php 
	$faculty_info = $this->Discussion_model->get_faculty_info_by_id($teacher_id); 
?>
<?php 
	$faculty_name = $faculty_info['tpinfo_first_name'].' '.$faculty_info['tpinfo_middle_name'].' '.$faculty_info['tpinfo_last_name'];
	$faculty_total_message = $this->Discussion_model->get_total_messages_by_faculty($teacher_id);
	if($faculty_info['tpinfo_photo'])
	{
		$faculty_photo_url = attachment_url('faculties/'.$faculty_info['teacher_entryid'].'/'.$faculty_info['tpinfo_photo']);
	}else
	{
		$faculty_photo_url = base_url('frontend/tools/default.png');
	}
?>
<div class="d-flex bd-highlight">
	<div class="img_cont">
		<img src="<?php echo $faculty_photo_url; ?>" class="rounded-circle user_img">
		<!--<span class="online_icon"></span>-->
	</div>
	<div class="user_info">
		<span>Chat with <?php echo $faculty_name; ?></span>
		<p><?php echo $faculty_total_message; ?> Messages</p>
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