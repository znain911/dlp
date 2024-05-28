<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="course-content-start">
					<h3>
						Student Name: <strong><?php echo $stdinfo->spinfo_first_name.' '.$stdinfo->spinfo_middle_name.' '.$stdinfo->spinfo_last_name;?></strong><br> 
						Student ID: <strong><?php echo $stdinfo->student_finalid;?></strong><br>
						Student Phone: <strong><?php echo $stdinfo->spinfo_personal_phone;?></strong>
					</h3>
					</div>

					<div class="course-content-start">
						
						<!-- begin #wizard -->
						<div class="wizard-step-start-box">
							<div class="step-wzard active">
								<a class="step-up-link">
									<span class="step-num">1</span>
									<strong class="phase-name">Phase A</strong>
									<span class="module-dtls">Module 1, 2, 3</span>
								</a>
							</div>
							<div class="step-wzard">
								<a class="step-up-link" href="<?php echo base_url('faculty/dashboard/sthistry_b/'.$stid.'?rdr=Course&phase=PCA-2&return=true'); ?>">
									<span class="step-num">2</span>
									<strong class="phase-name">Phase B</strong>
									<span class="module-dtls">Module 4, 5, 6, 7</span>
								</a>
							</div>
							<div class="step-wzard">
								<a class="step-up-link" href="<?php echo base_url('faculty/dashboard/sthistry_c/'.$stid.'?rdr=Course&phase=PCA-3&return=true'); ?>">
									<span class="step-num">3</span>
									<strong class="phase-name">Phase C</strong>
									<span class="module-dtls">Module 8, 9, 10</span>
								</a>
							</div>
							<!-- <div class="step-wzard ece-step">
								<a class="step-up-link">
									<span class="step-num">4</span>
									<strong class="phase-name">ECE</strong>
								</a>
							</div> -->
						</div>
						<!-- end #wizard -->
					</div>
					
					<div class="module-wizard-container">
						<div class="row">
							
							<input type="hidden" id="activeModule" value="<?php echo $active_module; ?>" />
							<input type="hidden" id="studentid" value="<?php echo $student_id; ?>" />
							<!--
								class: active, completed
							-->
							<?php 
								$get_modules = $this->Dashboard_model->get_modulesby_phase($phase_lavel);
								$module_x = 1;
								foreach($get_modules as $module):
								$has_completed = completed_module($module['module_id']);
								if($has_completed == true)
								{
									$progress_class = 'completed';
								}elseif($has_completed == false && $active_module == $module['module_id'])
								{
									$progress_class = 'active';
								}else
								{
									$progress_class = null;
								}
							?>
							<div class="<?php echo (count($get_modules) > 3)? 'col-lg-3' : 'col-lg-4' ?>">
								<div style="cursor:pointer;" onclick="window.location.href='<?php echo base_url('faculty/dashboard/sthistry/'.$stid.'?rdr=Course&actmdl='.$module['module_id'].'&shw=true&phase=PCA-1&return=true'); ?>'" class="module-number-stp <?php echo $progress_class; ?>"><?php echo $module['module_name']; ?></div>
							</div>
							<?php 
								$module_x++;
								endforeach; 
							?>
						</div>
					</div>
					<div class="module-lesson-content">
						<div class="row">
							<div class="col-lg-12">
								<div id="displayLessonContent"></div>
							</div>
						</div>
					</div>
					<div class="module-lesson-wizard-container">
						<div class="row" id="postList">
							<!--
								class: active, completed
							-->
							<?php 
								if(count($items) !== 0):
								foreach($items as $item): 
								/*$active_user = $this->session->userdata('active_student');*/
								$check_has_ready = $this->Dashboard_model->check_lesson_has_read($item['lesson_module_id'], $item['lesson_id'], $stid);
								if($check_has_ready == true){
									$has_read = 'completed';
								}else
								{
									$has_read = '';
								}
							?>
							<div class="col-lg-4">
								<div class="module-number-stp-lesson mdl-lssn-srl-<?php echo $item['lesson_id']; ?> <?php echo $has_read; ?>" data-found="<?php echo $item['lesson_id']; ?>" data-found-mdl="<?php echo $item['lesson_module_id']; ?>" data-phase="1"><?php echo $item['lesson_title']; ?></div>
							</div>
							<?php endforeach; ?>
							<?php endif; ?>
							<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.downld-btn-ext', function(){
				var lesson = $(this).attr('data-lesson');
				$.ajax({
				   type:"POST",
				   url: baseUrl + "faculty/dashboard/sendotp",
				   data: {lesson:lesson, _jwar_t_kn_:sqtoken_hash},
				   dataType: 'json',
				   cache: false,
				   success: function(data){
					   if(data.status == 'ok')
					   {
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#getLesson').val(data.lesson);
							return false;
					   }else
					   {
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
			});

			/*$(document).on('click', '.downld-btn-ext', function(){
				var lesson = $(this).attr('data-lesson');
				$.ajax({
				   type:"POST",
				   url: baseUrl + "student/lesson/pdfdownload",
				   data: {lesson:lesson, _jwar_t_kn_:sqtoken_hash},
				   dataType: 'json',
				   cache: false,
				   success: function(data){
					   if(data.status == 'ok')
					   {
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#getLesson').val(data.lesson);
							return false;
					   }else
					   {
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
			});*/


			
			$(document).on('click', '.crs-view-btn', function(){
				var lesson = $(this).attr('data-lesson');
				$.ajax({
				   type:"POST",
				   url: baseUrl + "faculty/dashboard/get_less_content",
				   data: {lesson:lesson, _jwar_t_kn_:sqtoken_hash},
				   dataType: 'json',
				   cache: false,
				   success: function(data){
					   if(data.status == 'ok')
					   {
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#viewCourseContent').html(data.content);
							return false;
					   }else
					   {
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
			});
			
			$("#sendOtpForm").validate({
				rules:{
					otp:{
						required: true,
						number: true,
					},
				},
				messages:{
					otp:{
						required: null,
						number: null,
					},
				},
				submitHandler : function () {
					$('#otpLoader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "faculty/dashboard/check_otp",
						data : $('#sendOtpForm').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("sendOtpForm").reset();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#sendOtp').modal('hide');
								$('#otpLoader').hide();
								if(data.attach == 'Yes')
								{
									window.location.href=baseUrl+'faculty/dashboard/download';
								}else if(data.attach == 'No')
								{
									window.location.href=baseUrl+'faculty/dashboard/create_pdf';
								}else
								{
									return false;
								}
								return false;
							}else if(data.status == "error"){
								$('#otpMessaging').html(data.error_content);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#otpLoader').hide();
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				}
			});
		});
	</script>
	<script type="text/javascript">
		function getCourseLessons(page_num) {
			page_num = page_num?page_num:0;
			var activeModule = $('#activeModule').val();
			var studentid = $('#studentid').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>lessonfilter/get_lessons/'+page_num,
				data:'page='+page_num+'&active_module='+activeModule+'&phase=1'+'&sid='+studentid,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.module-number-stp-lesson', function(){
				var lessonID = $(this).attr('data-found');
				var activeLssnID = $('.module-number-stp-lesson.active').attr('data-found');
				var lessonModuleID = $(this).attr('data-found-mdl');
				var phase = $(this).attr('data-phase');
				var stid = <?php echo $stid;?>;
				$.ajax({
				   type:"POST",
				   url: baseUrl + "faculty/dashboard/get_less_content",
				   data: {lesson:lessonID, data_module:lessonModuleID, phase:phase, stid:stid, _jwar_t_kn_:sqtoken_hash},
				   dataType: 'json',
				   cache: false,
				   success: function(data){
					   if(data.status == 'ok')
					   {
						   $('html, body').animate({
								scrollTop: $("body").offset().top
							 }, 1000);
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#displayLessonContent').html(data.content);
							
							if(data.part_has_completed == '1')
							{
								setInterval(function() {
								  window.location.reload();
								}, 3600000); 
							}
							return false;
					   }else
					   {
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
				
				
				$('.mdl-lssn-srl-'+activeLssnID).addClass('completed');
				$('.mdl-lssn-srl-'+activeLssnID).removeClass('active');
				$('.mdl-lssn-srl-'+lessonID).addClass('active');
				
				//$('.module-number-stp-lesson.completed').removeClass('active');
			})
			
			$(document).on('click', '.module-number-stp-lesson.completed', function(){
				$(this).removeClass('completed');
				$(this).addClass('active');
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>