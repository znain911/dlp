<?php 
	$messages = $this->Discussion_with_student_model->get_reply_by_discussion($discuss_id);
	foreach($messages as $message):
?>
	<?php if($message['reply_user_type'] == 'FACULTY'): ?>
	<?php 
		$teacher_photo = $this->Discussion_with_student_model->get_teacher_photo($message['reply_answered_by']);
		if($teacher_photo['tpinfo_photo'])
		{
			$message_faculty_photo_url = attachment_url('faculties/'.$teacher_photo['teacher_entryid'].'/'.$teacher_photo['tpinfo_photo']);
		}else
		{
			$message_faculty_photo_url = base_url('frontend/tools/default.png');
		}
	?>
	<div class="d-flex justify-content-start mb-4">
		<div class="img_cont_msg">
			<img src="<?php echo $message_faculty_photo_url; ?>" class="rounded-circle user_img_msg">
		</div>
		<div class="msg_cotainer">
			<?php echo $message['reply_content']; ?>
			<span class="msg_time"><?php echo get_chat_time($message['reply_created_date']); ?></span>
		</div>
	</div>
	<?php elseif($message['reply_user_type'] == 'STUDENT'): ?>
	<?php 
		$student_photo = $this->Discussion_with_student_model->get_student_photo($message['reply_answered_by']);
		if($student_photo['spinfo_photo'])
		{
			$message_student_photo_url = attachment_url('students/'.$student_photo['student_entryid'].'/'.$student_photo['spinfo_photo']);
		}else
		{
			$message_student_photo_url = base_url('frontend/tools/default.png');
		}
	?>
	<div class="d-flex justify-content-end mb-4">
		<div class="msg_cotainer_send">
			<?php echo $message['reply_content']; ?>
			<span class="msg_time_send"><?php echo get_chat_time($message['reply_created_date']); ?></span>
		</div>
		<div class="img_cont_msg">
			<img src="<?php echo $message_student_photo_url; ?>" class="rounded-circle user_img_msg">
		</div>
	</div>
	<?php endif; ?>
<?php endforeach; ?>