<div class="dashboard-sidebar-left">
	<div class="profile-area">
		<?php 
			if($dashboard_info['spinfo_photo']): 
			$photo_url = attachment_url('students/'.$dashboard_info['student_entryid'].'/'.$dashboard_info['spinfo_photo']);
		?>
		<div class="img-profile-photo" style="background:url(<?php echo $photo_url; ?>) no-repeat 0 0;background-size:cover;"></div>
		<?php else: ?>
		<div class="img-profile-photo" style="background:url(<?php echo base_url('frontend/tools/default.png'); ?>) no-repeat 0 0;background-size:cover;"></div>
		<?php endif; ?>
		<div class="profile-info">
			<p class="profile-info-name">
				<strong><?php echo $this->session->userdata('full_name'); ?></strong> <br />
				Certificate course in diabetology
			</p>
			<p class="profile-roll"><strong>ID : <?php echo $dashboard_info['student_finalid']; ?></strong></p>
		</div>
	</div>
	<ul class="main-sidebar-ul">
		<li class="main-li <?php echo student_item_activate('student', 'dashboard'); ?>"><a href="<?php echo base_url('student/dashboard'); ?>" class="main-anchor"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'course'); ?>"><a href="<?php echo base_url('student/course'); ?>" class="main-anchor"><i class="fa fa-book"></i> Course</a></li>
		<li class="main-li pbr"><a href="<?php echo base_url('student/dashboard/pb_result'); ?>" class="main-anchor"><i class="fa fa-book"></i> Practice Based Result</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'results'); ?>"><a href="<?php echo base_url('student/results'); ?>" class="main-anchor"><i class="fa fa-calendar-check-o"></i> Result</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'payments'); ?>"><a href="<?php echo base_url('student/payments'); ?>" class="main-anchor"><i class="fa fa-credit-card"></i> Payments</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'classmet'); ?>"><a href="<?php echo base_url('student/classmet'); ?>" class="main-anchor"><i class="fa fa-user"></i> RTC</a></li>
		<!--<li class="main-li <?php echo student_item_activate('student', 'schedules'); ?>"><a href="<?php echo base_url('student/schedules'); ?>" class="main-anchor"><i class="fa fa-hand-o-right"></i> Course Schedule</a></li>-->
		<li class="main-li <?php echo student_item_activate('student', 'contact'); ?>"><a href="<?php echo base_url('student/contact'); ?>" class="main-anchor"><i class="fa fa-envelope"></i> Contact Us</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'evaluation'); ?>">
			<a href="<?php echo base_url('student/evaluation'); ?>" class="main-anchor"><i class="fa fa-star"></i> Evaluations <!--<i class="right-indc fa fa-angle-right"></i>--></a>
			<!--<ul class="second-level-ul">
				<li class="second-level-li">
					<a class="second-level-anchor" href="<?php echo base_url('student/evaluation/lists'); ?>">View Evaluations <i class="fa fa-angle-right"></i></a>
					<a class="second-level-anchor" href="<?php echo base_url('student/evaluation'); ?>">Add Evaluations <i class="fa fa-angle-right"></i></a>
				</li>
			</ul>-->
		</li>
		<li class="main-li <?php echo student_item_activate('student', 'discussion'); ?>"><a href="<?php echo base_url('student/discussion'); ?>" class="main-anchor"><i class="fa fa-comment"></i> Discussion</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'profile'); ?>"><a href="<?php echo base_url('student/profile'); ?>" class="main-anchor"><i class="fa fa-user"></i> Profile</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'changepassword'); ?>"><a href="<?php echo base_url('student/changepassword'); ?>" class="main-anchor"><i class="fa fa-key"></i> Change Password</a></li>
		<li class="main-li"><a href="<?php echo base_url('student/faqs'); ?>" class="main-anchor"><i class="fa fa-question-circle"></i> FAQS</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'logout'); ?>"><a href="<?php echo base_url('student/logout'); ?>" class="main-anchor"><i class="fa fa-sign-out"></i> Logout</a></li>
	</ul>
</div>