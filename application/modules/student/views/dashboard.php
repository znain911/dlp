<?php require_once APPPATH.'modules/common/header.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('backend/assets/css/event.css');?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div class="student-dashboard-progress-tracker">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<h3 class="progress-title" style="position:relative">PROGRESS TRACKER
									<span class="clr-declaration">
										<span class="green-clr"><span class="grn"></span> Completed</span>
										<span class="blue-clr"><span class="blu"></span> In-Progress</span>
									</span>
								</h3>
								<div class="progress-bar-li-ms">
									<div class="progress">
										<?php 
											$tracker = '';
											if($dashboard_info['student_phaselevel_id'] == 1){
												
												$tracker .= '<span class="proccessing-one-phase"></span>';
											}
											if($dashboard_info['student_phaselevel_id'] == 2){
												
												$tracker .= '
															<span class="complete-one-phase"></span>
															<span class="proccessing-two-phase"></span>
															';
											}			
											if($dashboard_info['student_phaselevel_id'] == 3){
												
												$tracker .= '
															<span class="complete-one-phase"></span>
															<span class="complete-two-phase"></span>
															<span class="proccessing-three-phase"></span>
															';
															
											}
											
											if($dashboard_info['student_phaselevel_id'] == 0 && $dashboard_info['student_ece_status'] == 1){
												
												$tracker .= '
															<span class="complete-one-phase"></span>
															<span class="complete-two-phase"></span>
															<span class="proccessing-three-phase"></span>
															';
															
											}
											if($dashboard_info['student_phaselevel_id'] == 0 && $dashboard_info['student_ece_status'] == 0){
												
												$tracker .= '
																<span class="complete-one-phase"></span>
																<span class="complete-two-phase"></span>
																<span class="complete-three-phase"></span>
															';
												
											}
											
											echo $tracker;
											
											
										?>
									</div>
									<span class="phase phase-a">Phase A </span>
									<span class="phase phase-b">Phase B <span class="pca-exam pce-one">PCA 1</span></span>
									<span class="phase phase-c">Phase C <span class="pca-exam pce-two">PCA 2</span></span>
									<span class="phase ece">ECE <span class="pca-exam pce-three">PCA 3</span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="student-dashboard-notification">
					<div class="row">
					<?php  if($dashboard_info['student_batch'] == 33){  ?>
						<div class="col-lg-12" style = "    margin-top: 10px;">
							<a href="https://ccd_batch-32_flipbook.aflip.in/<?php echo $dashboard_info['student_finalid'];?>" class="btn btn-info" style="background: green; color: #fff;    margin-top: 0px; font-size:22px; " target="_blank">Download Flipbook</a>
							<button type="button" style = "padding: 10px 40px;background-color: green;color: white;font-weight: bolder;font-size: 22px;" class="pca">PCA</button>
							<?php //print_r($dashboard_info);
									 //echo base64_encode($dashboard_info['student_entryid']);  //MTIz
									//echo "<br>";
									//echo base64_decode('ZUNDREJEMzMyMDIxMDAwMDA0MTA4'); //123
							?>
						</div>
						<!--<div class="col-lg-12">
							<a href="https://eceexam.dldchc-badas.org.bd/students/login" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " target="_blank">ECE Exam</a>
						</div>-->
						<?php  }  ?>
						<?php  date_default_timezone_set("Asia/Dhaka");
							$time = date("Y-m-d H:i:s");
							
							if($time > '2024-05-05 07:55:00' && $time < '2024-05-06 20:00:00'){?>
						<div class="col-lg-12" style = "    margin-top: 10px;">
							<button type="button" style = "padding: 10px 40px;background-color: green;color: white;font-weight: bolder;font-size: 22px;" class="pca">PCA</button>
							
						</div>
						<?php  }  ?>
						
						<?php
							date_default_timezone_set("Asia/Dhaka");
							$time = date("Y-m-d H:i:s");
							
							if($time > '2024-05-16 07:55:00' && $time < '2024-05-18 20:00:00'){
						?>
						
						<div class="col-lg-12" style = "    margin-top: 10px;">
							<button type="button" style = "padding: 10px 40px;background-color: green;color: white;font-weight: bolder;font-size: 22px;" class="eceexam">ECE Exam</button>
							
						</div>
						<?php  }  ?>
					<?php /* if($dashboard_info['student_batch'] == 33){ */ ?>
					<!--<div class="col-lg-12">
						<a href="https://pcaexam.dldchc-badas.org.bd/students/login" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " target="_blank">PCA-2 Exam</a>
					</div>-->
					<?php /* } */ ?>
					<?php /* if($dashboard_info['student_rtc'] == 125){ */  ?>
					<!--<div class="col-lg-12">
						<a href="https://eceexam.dldchc-badas.org.bd/students/login" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " target="_blank">ECE Re-Exam Batch-32</a>
					</div>-->
					<?php /* } */ ?>
					<?php if($dashboard_info['student_rtc'] == 125){}else{ ?>
					<div class="col-lg-6">
							<h3>Regular Class</h3>
							<hr>
							<?php $zoomlink = $this->Dashboard_model->get_zoomlink($dashboard_info['student_rtc']);
								if (!empty($zoomlink)) {
									foreach ($zoomlink as $zm) { ?>
										<h3 class="rslt-cgp-title">
											<small>
												<?php echo $zm->zoom_title;?><br>
												<?php echo $zm->zoom_date;?><br>
												<?php $cdate = date("Y-m-d");
												if ($zm->zoom_date == $cdate) {?>
													<a href="<?php echo $zm->zoom_link;?>" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " target="_blank"><?php echo $zm->button_title;?></a>	
												<?php }else{
													echo '<button type="button" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " disabled>'.$zm->button_title.'</button>';
												}?>			
											</small>
										</h3>
										<hr>
							<?php	}
								}
							?>
						</div>
						<div class="col-lg-6">
							<h3>Carry On Class</h3>
							<hr>
							<?php $zoomlink2 = $this->Dashboard_model->get_carryzoomlink();
								if (!empty($zoomlink2)) {
									foreach ($zoomlink2 as $zm2) { 
										$myString = $zm2->student_list;
										$myArray = explode(',', $myString);
										/*print_r($myArray);*/
										foreach($myArray as $sids){

										$str = $sids;
										$new_str = preg_replace("/\s+/", "", $str);

											if ($dashboard_info['student_finalid'] == $new_str) {?>
												<h3 class="rslt-cgp-title">
											<small>
												<?php echo $zm2->zoom_title;?><br>
												Date: <?php echo $zm2->zoom_date;?><br>
												Time: <?php echo $zm2->zoom_time;?><br>
												<?php $cdate = date("Y-m-d");
												if ($zm2->zoom_date == $cdate) {?>
													<a href="<?php echo $zm2->zoom_link;?>" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " target="_blank"><?php echo $zm2->button_title;?></a>	
												<?php }else{
													echo '<button type="button" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " disabled>'.$zm2->button_title.'</button>';
												}?>			
											</small>
										</h3>
										<hr>
											<?php }
										}
										?>										
							<?php	}
								}
							?>
						</div>
					<div class="col-lg-12">
						
						<div style="height: 30px; clear: both;"></div>
						<?php 
							$get_stid = $this->Dashboard_model->get_pcastid();
								if(!empty($get_stid)){
						?>
						<!--<a href="https://eceexam.dldchc-badas.org.bd/students/login" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; " target="_blank">ECE Exam</a>
						<div class="result-table">-->
						
						<p><strong>PCA 1 Results</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
                                    <th>Total Question</th>
                                    <th>Total Marks</th>
                                    <th>Pass Marks</th>
                                    <th>Questions Attempted</th>
                                    <th>Correct Answer</th>
                                    <th>Wrong Answer</th>
                                    <th>Marks Obtained</th>
                                    <th>Attempt</th>
                                    <th>Status</th>                                
                                </tr>
							</thead>
							<tbody>
								<?php
								
								$get_itemstest = $this->Dashboard_model->getExamReport($get_stid->st_id);
									$i = 1;
								foreach($get_itemstest as $pca1){
									$rightans = (int)$pca1->total_marks / (int)1;
									$wrongans = (float)$pca1->negative_marks / (float)0.5;?>
								<tr>
									<td class="text-center">40</td>
									<td class="text-center">40</td>
									<td class="text-center">20</td>
									<td class="text-center"><?php echo $rightans + $wrongans;?></td>
									<td class="text-center"><?php echo $rightans; ?></td>
									<td class="text-center"><?php echo $wrongans;?></td>
									<td class="text-center"><?php echo $pca1->geting_marks; ?></td>
									<td class="text-center">Attempt <?php echo $i;?></td>
									<td class="text-center"><?php echo $pca1->result; ?></td>
									
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div>
					<?php } ?>	
					<!--</div>-->
					
						<div class="col-lg-6 evnts">
							<div style="height: 10px; clear: both;"></div>
							<div id="calendar_div">
							    <?php echo $eventCalendar; ?>
							</div>
							<!-- <h2>
								<span class="top-tt">SCHEDULED</span> <br />
								<span class="bottom-tt">EVENTS</span>
							</h2> -->
							<!-- <div class="events-calender">
								<?php 
									
									if($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)))
									{
										echo $this->calendar->generate($this->uri->segment(4), $this->uri->segment(5));
									}else
									{
										echo $this->calendar->generate(date("Y"), date("m"));
									}
								?>
							</div> -->
							<!-- <div class="schdl-indicator">
								<?php 
									$get_sdt_schedule_dates      = $this->Dashboard_model->get_sdt_schedule_dates();
									$get_workshop_schedule_dates = $this->Dashboard_model->get_workshop_schedule_dates();
									$get_ece_schedule_dates      = $this->Dashboard_model->get_ece_schedule_dates();
								?>
							
								<?php foreach($get_sdt_schedule_dates as $sdt): ?>
								<span class="indicator indicator-two"><i class="fa fa-star"></i> &nbsp; <?php echo $sdt['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($sdt['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($sdt['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
								
								<?php foreach($get_workshop_schedule_dates as $workshop): ?>
								<span class="indicator indicator-three"><i class="fa fa-star"></i> &nbsp; <?php echo $workshop['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($workshop['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($workshop['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
								
								<?php foreach($get_ece_schedule_dates as $ece): ?>
								<span class="indicator indicator-four"><i class="fa fa-star"></i> &nbsp; <?php echo $ece['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($ece['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($ece['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
							</div> -->
						</div>
						
						
						<div class="col-lg-6">
							<div class="admin-notification-title">
								<h2>
									<span class="top-tt">ADMINISTRATION</span> <br />
									<span class="bottom-tt">NOTIFICATION</span>
								</h2>
							</div>
							<div class="jsVerSlidr">
								<?php 
									$notifications = $this->Dashboard_model->get_dahboard_notifications();
									foreach($notifications as $notification):
									$crnt_date = strtotime(date("Y-m-d"));
									$notice_date = strtotime(date("Y-m-d", strtotime($notification['notif_create_date'])));
								?>
								<div class="single-notification">
									<span class="new-or-op-nt pull-right"><?php echo ($notice_date == $crnt_date)? 'NEW' : 'OLD'; ?></span>
									<div class="coordinator-nt-date">
										<span class="nt-date"><?php echo date("d F Y", strtotime($notification['notif_create_date'])); ?>, </span>
										<span class="nt-time"><?php echo date("H:i:s A", strtotime($notification['notif_create_date'])); ?></span>
									</div>
									<div class="coordinator-nt-description">
										<?php echo $notification['notif_content']; ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>

							<h4><strong>1. INSTRUCTIONS FOR USING DASHBOARD.</strong></h4>
							<ul>
							  <li>After login as a student, you will find a large blue menu on the left side of the screen with many options. A progress tracker is on the top of the page. The progress tracker will indicate the status of phases in terms of ‘in-progress’ and ‘completed’.  The calendar is on the right side of the screen. In the calendar you will find dates highlighted in <b>Green, Red and Dark Blue</b> colors. <b>Upcoming Classes</b> are highlighted in <b>Green</b> color, <b>Exams are Red</b> color and <b>SDT & Workshops in Dark Blue</b> color. If you click any highlighted color dates (green or red or dark blue), it will show you the event details, meaning details of the class, exam or SDT & workshop, at the top of the calendar.</li>
							  <li>By clicking on the course option in the left side blue menu, you can access all the study material for reading online, downloading, or taking end lesson exams. Please remember that OTP will be sent to your registered mobile number to download course materials. </li>
							  <li>PCA exam buttons will appear below the course material on the scheduled date and after taking the exam successfully it will be deactivated. The PCA Exams are Phase Completion Assessment Exams. Students must pass PCA Exams to progress from one Phase to the next. To progress from Phase A to Phase B and from Phase B to Phase C and Phase C to ECE Exams students must pass PCA Exams. If a student fails a PCA Exam, they will not be able to progress to the next phase of the Course. The retake exam will be scheduled by the CCD Authorities within the period of the course.</li>
							  <li>By selecting the Result option in left side blue menu, you can find results for PCA Exams, ECE Exams and Workshop Results.</li>
							  <li>Payment status and details can be viewed by selecting Payment from left side blue menu.</li>
							  <li>To view details of your RTC, you need to select the RTC option in the left side blue menu. Inside the RTC option, you fill find Faculty/Tutor name and Faculty/Tutor contact number along with the list of other CCD Batch 32 students inside the RTC. </li>
							</ul>
							<h3><strong>2. INSTRUCTIONS FOR APPLYING TO CHANGE RTC SCHEDULE</strong></h3>
							<ul>
								<li>You can place a request to change your RTC schedule, from your current RTC schedule. To do this you will need to first click on the RTC option in the left side blue menu. A green button Change RTC will on the top of the RTC list. After selecting the green button, a pop-up box will appear to Please confirm your request. Selecting Yes will send the change request to CCD Authorities. After reviewing your request, if the CCD Authorities approves your request, you will receive an SMS and email to your registered mobile number and registered email address. Please note after you place request for RTC change using the green button Change Request, the button will remain deactivated until CCD Course authorities approves or declines your request. </li>
							</ul>
							<h3><strong>3. INSTRUCTIONS FOR USING CALENDAR</strong></h3>
							<ul>
								<li>The calendar is on the right side of the screen. In the calendar you will find dates highlighted in <b>Green, Red and Dark Blue</b> colors. <b>Upcoming Classes</b> are highlighted in <b>Green</b> color, <b>Exams</b> are <b>Red</b> color and <b>SDT & Workshops</b> in <b>Dark Blue</b> color. If you click any highlighted color dates (green or red or dark blue), it will show you the event details, meaning details of the class, exam or SDT & workshop, at the top of the calendar.</li>
							</ul>
							<h3><strong>4. INSTRUCTIONS FOR ATTENDING ZOOM CLASS</strong></h3>
							<ul>
								<li>Zoom class links will be sent to you by SMS and mail. We advise that you attend the class by your name. Please change the name when logging in using Zoom. </li>
								<li>You will have to select your name and id number when entering the CCD Class Zoom Session. </li>
								<li>Please turn on your camera when attending the zoom class. Attending Zoom class without switching on your camera will lead to absent in the attendance sheet. If you join and then leave the Zoom class before the end of session while the session is ongoing, you will be marked absent. </li>
								<li>Please mute the mic when Faculty/Tutor is giving the lecture. </li>
								<li>Please use the raise hand function to ask questions. You can also use the chat box to ask relevant questions about the Module. The chat box is on the lower part of the screen.  </li>
								<li>We will discourage you not to attend the class while travelling. Please try to be in a specific location when attending the CCD Class Zoom Session. </li>
							</ul>
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function getCalendar(target_div, year, month){
		    $.get( '<?php echo base_url('student/dashboard/eventCalendar/'); ?>'+year+'/'+month, function( html ) {
		        $('#'+target_div).html(html);
		    });
		}

		function getEvents(date){
		    $.get( '<?php echo base_url('student/dashboard/getEvents/'); ?>'+date, function( html ) {
		        $('#event_list').html(html);
		    });
		}

		$(document).on('change', '.month-dropdown', function(){ 
			getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val());
		});
		$(document).on('change', '.year-dropdown', function(){ 
			getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val());
		});
		
		$(document).ready(function(){
			
			$(document).on('click', '.pca', function(){
				
				
				//alert('ok');
				
				 window.location = 'https://pcaexam.dldchc-badas.org.bd/students/login?id=<?php echo base64_encode($dashboard_info['student_finalid'])?>';
			});
			
			$(document).on('click', '.eceexam', function(){
				
				
				//alert('ok');
				
				 window.location = 'https://eceexam.dldchc-badas.org.bd/students/login';
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>