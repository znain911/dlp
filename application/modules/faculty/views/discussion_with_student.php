<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php 
		$item = $this->Teacher_model->get_teacher_info();
	?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="h-100 dlp-discussion">
						<div class="row justify-content-center h-100">
							<div class="col-lg-4 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
								<div class="card-header">
									<div class="input-group">
										<input type="text" placeholder="Search..." name="" class="search" id="srcUsers">
										<div class="input-group-prepend">
											<span class="input-group-text search_btn"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
								<div class="card-body contacts_body">
									<ul class="contacts" id="userLists">
										<?php 
											$students = $this->Discussion_model->get_students();
											$f_sl = 1;
											foreach($students as $student):
											$name = $student['spinfo_first_name'].' '.$student['spinfo_middle_name'].' '.$student['spinfo_last_name'];
											if($student['spinfo_photo'])
											{
												$photo_url = attachment_url('students/'.$student['student_entryid'].'/'.$student['spinfo_photo']);
											}else
											{
												$photo_url = base_url('frontend/tools/default.png');
											}
											$total_new_message = $this->Discussion_model->get_total_new_messages($student['student_id'], 'STUDENT');
										?>
										<!--<li class="active">-->
										<li class="clk-on-fclty <?php echo ($f_sl == 1)?  'active': null; ?>" data-fclty="<?php echo $student['student_id']; ?>" style="position:relative;">
											<div class="d-flex bd-highlight">
												<div class="img_cont">
													<img src="<?php echo $photo_url; ?>" class="rounded-circle user_img">
													<!--<span class="online_icon"></span>-->
													<!--<span class="online_icon offline"></span>-->
												</div>
												<div class="user_info">
													<span><?php echo $name; ?></span>
													<p><strong>ID : <?php echo $students[0]['student_entryid']; ?></strong></p>
												</div>
											</div>
											<?php if($total_new_message !== 0): ?>
											<span class="ntfy-new-message"><?php echo $total_new_message; ?></span>
											<?php endif; ?>
										</li>
										<?php $f_sl++; endforeach; ?>
									</ul>
								</div>
								<div class="card-footer"></div>
							</div>
							</div>
							<div class="col-lg-8 chat">
								<div class="card">
									<?php if(isset($students[0]['student_id'])): ?>
									<div class="card-header msg_head" id="chatHeaderContent">
										<?php 
											$student_id = $students[0]['student_id'];
											$student_info = $this->Discussion_model->get_student_info_by_id($student_id); 
										?>
										<?php 
											$student_name = $student['spinfo_first_name'].' '.$student['spinfo_middle_name'].' '.$student['spinfo_last_name'];
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
									</div>
									<div class="card-body msg_card_body" id="chtBodyContainer">
										<div id="chatBodyContent">
										<?php 
											$messages = $this->Discussion_model->get_discussions_by_student($student_id);
											foreach($messages as $message):
										?>
											<?php if($message['reply_user_type'] == 'FACULTY'): ?>
											<?php 
												$teacher_photo = $this->Discussion_model->get_teacher_photo($message['reply_answered_by']);
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
												$student_photo = $this->Discussion_model->get_student_photo($message['reply_answered_by']);
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
										</div>
									</div>
									<div class="card-footer">
										<form action="javascript:void(0);" id="cnvSendForm">
											<div class="input-group">
												<div class="input-group-append">
													<span class="input-group-text attach_btn"><i class="fa fa-paperclip"></i></span>
												</div>
												<input type="hidden" name="gt_std" id="gtFac" value="<?php echo $student_id; ?>" />
												<input name="message" class="type_msg" placeholder="Type your message..." />
												<div class="input-group-append">
													<button class="input-group-text send_btn" type="submit"><i class="fa fa-location-arrow"></i></button>
												</div>
											</div>
										</form>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.clk-on-fclty', function(){
				var theFclty = $(this).attr('data-fclty');
				$(this).find('.ntfy-new-message').remove();
				$('.clk-on-fclty').removeClass('active');
				$(this).addClass('active');
				
				$('#gtFac').val(theFclty);
				$('#proccessLoader').show();
				$.ajax({
					type : "POST",
					url : baseUrl + "faculty/discussion/get_messages",
					data : {theFclty:theFclty},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#chatHeaderContent').html(data.chat_header);
							$("#chtBodyContainer").scrollTop($("#chatBodyContent").height());
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#proccessLoader').hide();
							check_message()
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
			});
			
			$(document).on('keyup', '#srcUsers', function(){
				var q = $(this).val();
				$.ajax({
					type : "POST",
					url : baseUrl + "faculty/discussion/get_students",
					data : {q:q},
					dataType : "json",
					success : function (data) {
						if(data.status == "ok")
						{
							$('#userLists').html(data.content)
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#proccessLoader').hide();
							return false;
						}else
						{
							//have end check.
						}
						return false;
					}
				});
				
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#cnvSendForm").validate({
				rules:{
					message:{
						required: true,
					},
				},
				messages:{
					message:{
						required: null,
					},
				},
				submitHandler : function () {
					var theFclty = $('#gtFac').val();
					if(theFclty !== '')
					{
						$('#loader').show();
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "faculty/discussion/send",
							data : $('#cnvSendForm').serialize(),
							dataType : "json",
							success : function (data) {
								if(data.status == "ok")
								{
									$('#chatBodyContent').html(data.content);
									$('#loader').hide();
									document.getElementById("cnvSendForm").reset();
									$("#chtBodyContainer").scrollTop($("#chatBodyContent").height());
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$("#chtBodyContainer").scrollTop($("#chatBodyContent").height());
									check_message()
									return false;
								}else
								{
									//have end check.
								}
								return false;
							}
						});
						
						return false;
					}else
					{
						return false;
					}
				}
			});
		});
	</script>
	<script type="text/javascript">
		check_message();
		setInterval(check_message, 1000);
	    $("#chtBodyContainer").scrollTop($("#chatBodyContent").height());
		function check_message(){
			var theFclty = $('#gtFac').val();
			if(theFclty !== '')
			{
				$.ajax({
					type: 'POST',
					url: baseUrl+'faculty/discussion/get_messages',
					data:{_jwar_t_kn_:sqtoken_hash, theFclty:theFclty},
					dataType: 'json',
					success: function(data){
						if(data.status == 'ok')
						{
							$('#chatBodyContent').html(data.content);
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash = data._jwar_t_kn_;
							return false;
						}else
						{
							return false;
						}
					}
				});
				
				return false;
			}else
			{
				return false;
			}
		}
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>