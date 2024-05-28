<?php 
	$f_sl = 1;
	foreach($faculties as $faculty):
	$name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
	if($faculty['tpinfo_photo'])
	{
		$photo_url = attachment_url('faculties/'.$faculty['teacher_entryid'].'/'.$faculty['tpinfo_photo']);
	}else
	{
		$photo_url = base_url('frontend/tools/default.png');
	}
	$total_new_message = $this->Discussion_model->get_total_new_messages($faculty['teacher_id'], 'FACULTY');
?>
<!--<li class="active">-->
<li class="clk-on-fclty <?php echo ($f_sl == 1)?  'active': null; ?>" data-fclty="<?php echo $faculty['teacher_id']; ?>" style="position:relative;">
	<div class="d-flex bd-highlight">
		<div class="img_cont">
			<img src="<?php echo $photo_url; ?>" class="rounded-circle user_img">
			<!--<span class="online_icon"></span>-->
			<!--<span class="online_icon offline"></span>-->
		</div>
		<div class="user_info">
			<span><?php echo $name; ?></span>
			<p><strong>ID : <?php echo $faculties[0]['teacher_entryid']; ?></strong></p>
		</div>
	</div>
	<?php if($total_new_message !== 0): ?>
	<span class="ntfy-new-message"><?php echo $total_new_message; ?></span>
	<?php endif; ?>
</li>
<?php $f_sl++; endforeach; ?>