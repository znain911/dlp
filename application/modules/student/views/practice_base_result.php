<?php require_once APPPATH.'modules/common/header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('backend/assets/css/event.css');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
					<div id="loaderp" style = "    position: absolute;margin-left: auto;top: 70%;left: 40%;z-index: 100; display: none;"  class="disable-select"><img style = 'height:30%' src="<?php echo base_url('frontend/assets/loader.gif'); ?>"  /></div>
					<div class="course-content-start" id = "phase-container">
						<!-- begin #wizard -->
						<div class="wizard-step-start-box ">
							<div class="step-wzard p1 <?php if($student['student_phaselevel_id'] === '1'){ echo 'active';}?>" data ="1">
								<a class="step-up-link" href="#module-container">
									<span class="step-num">1</span>
									<strong class="phase-name">Phase A </strong>
									<span class="module-dtls">Module 1, 2, 3</span>
								</a>
							</div>
							<div class="step-wzard p2 <?php if($student['student_phaselevel_id'] === '2'){ echo 'active';}?> " data ="2">
								<a class="step-up-link" href="#module-container">
									<span class="step-num">2</span>
									<strong class="phase-name">Phase B</strong>
									<span class="module-dtls">Module 4, 5, 6, 7</span>
								</a>
							</div>
							<div class="step-wzard p3 <?php if($student['student_phaselevel_id'] === '3'){ echo 'active';}?>" data ="3">
								<a class="step-up-link" href="#module-container">
									<span class="step-num">3</span>
									<strong class="phase-name">Phase C</strong>
									<span class="module-dtls">Module 8, 9, 10</span>
								</a>
							</div>
							<!--<div class="step-wzard ece-step">
								<a class="step-up-link"  >
									<span class="step-num">4</span>
									<strong class="phase-name">ECE</strong>
								</a>
							</div>-->
						</div>
						<!-- end #wizard -->
					</div>
					
					<div class="module-wizard-container" id = "module-container">
						<div class="row" id = "module-container-row">
							<input type="hidden" id="activeModule" value="<?php echo $student['student_active_module']; ?>" />
							<!--
								class: active, completed
							-->
							<?php 
								$get_modules = $this->Dashboard_model->get_modulesby_phase($student['student_phaselevel_id']);
								$module_x = 1;
								foreach($get_modules as $module):
								$has_completed = completed_module($module['module_id']);
								if($has_completed == true)
								{
									$progress_class = 'completed';
								}elseif($has_completed == false && $student['student_active_module'] == $module['module_id'])
								{
									$progress_class = 'active';
								}else
								{
									$progress_class = null;
								}
							?>
							<div class="<?php echo (count($get_modules) > 3)? 'col-lg-3' : 'col-lg-4' ?>">
								<div style="cursor:pointer;" class="module-number-stp <?php echo $progress_class; ?>" data = "<?php echo $module['module_id'];?>"><?php echo $module['module_name']; ?></div>
							</div>
							<?php 
								$module_x++;
								endforeach; 
							?>
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
								$active_user = $this->session->userdata('active_student');
								$check_has_ready = $this->Dashboard_model->check_lesson_has_read($item['lesson_module_id'], $item['lesson_id'], $active_user);
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
					
					
					<div class="container-question-area " id='result-container'>
						<div class="container" id='result' style = "display: none">
							<div class="row">
								<div class="col-lg-12" >
									<h2 style="text-align: center;">Exam History</h2>
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									
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
			$('.main-li').removeClass('active');
			$('.pbr').addClass('active');
			$('html, body').animate({
				scrollTop: $('#phase-container').offset().top
			}, 'slow');
			
			$(document).on('click', '.step-wzard', function(){
				var phase = $(this).attr('data');
				//alert(phase);
				
				$.ajax({
				   type:"POST",
				   url: baseUrl + "student/dashboard/module",
				   data: {phase:phase},
				   dataType: 'json',
				   success: function(data){
					   if(data.status == 'ok')
					   {
							//console.log(data);
							$('#module-container-row').html(data.content);
							$('#postList').hide();
							$('#result').hide();
							$('.step-wzard').removeClass('active');
							if(phase == '1'){
								$('.p1').addClass('active');
							}else if(phase == '2'){
								$('.p2').addClass('active');
							}else if(phase == '3'){
								$('.p3').addClass('active');
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
				
			})
			
			
			
			$(document).on('click', '.module-number-stp', function(){
				var module = $(this).attr('data');
				$('.module-number-stp').removeClass('active');
				$(this).addClass('active');
				$(this).removeClass('completed');
				//alert(module);
				
				
				$.ajax({
				   type:"POST",
				   url: baseUrl + "student/dashboard/lesson",
				   data: {module:module},
				   dataType: 'json',
				   success: function(data){
					   if(data.status == 'ok')
					   {
							console.log(data);
							$('#postList').html(data.content);
							$('#postList').show();
							$('#result').hide();
							$('html, body').animate({
								scrollTop: $('#postList').offset().top
							}, 'slow');
							$('#activeModule').val(module);
							
							return false;
					   }else
					   {
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
			
			
			})
			
			
			$(document).on('click', '.module-number-stp-lesson', function(){
				var lesson = $(this).attr('data-found');
				//alert(lesson);
				$('html, body').animate({
					scrollTop: $('#result-container').offset().top
				}, 'slow');
				
				$('#loaderp').show();
				
				$.ajax({
				   type:"POST",
				   url: baseUrl + "student/dashboard/pexam",
				   data: {lesson:lesson},
				   dataType: 'json',
				   success: function(data){
					   
					   if(data.status == 'ok')
					   {
						   $('#loaderp').hide();
							console.log(data);
							$('#accordion').html(data.content);
							$('#result').show();
							$('html, body').animate({
								scrollTop: $('#result').offset().top
							}, 'slow');
							
							
							return false;
					   }else if(data.status == 'No Result')
					   {
						   $('#accordion').html(data.content);
						   $('#result').show();
						   $('#loaderp').hide();
						   
						    return false;
					   }else
					   {
						   $('#loaderp').hide();
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
			})
		});
	</script>
	
	<script type="text/javascript">
		function getCourseLessons(page_num) {
			page_num = page_num?page_num:0;
			var activeModule = $('#activeModule').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>lessonfilter/get_lessons/'+page_num,
				data:'page='+page_num+'&active_module='+activeModule+'&phase=1',
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
<?php require_once APPPATH.'modules/common/footer.php'; ?>