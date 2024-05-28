<?php 
	$dashboard_info = $this->Common_model->get_student_information();
	$rtc_faculty = $this->Common_model->rtc_faculty_info($dashboard_info['student_rtc']);
?>
<header class="ms-header ms-header-primary student-lgg-hdr">
	<!--ms-header-primary-->
	<div class="container container-full">
	  <div class="ms-title">
		<a href="<?php echo site_url(); ?>" style="float: left;">
		  <img src="<?php echo base_url('frontend/tools/badas.png'); ?>" class="badas-logo" alt="BADAS">
		  <span class="ccd-lg-txt">CCD Online</span>
		</a>
		<!--<div style="float: left; color: #000; padding-left: 30px;">
			<h3><?php echo $rtc_faculty->batch_name;?> <br><small>Tutor Name: <?php echo $rtc_faculty->tpinfo_first_name.' '.$rtc_faculty->tpinfo_middle_name.' '.$rtc_faculty->tpinfo_last_name;?></small></h3>			
		</div>-->
	  </div>
	  <div class="header-right student-header-right">
		<div class="notofication-bel">
			<span class="fa fa-bell"></span>
		</div>
		<div class="profile-link">
			<a href="<?php echo base_url('student/dashboard'); ?>" class="profile-link-anchor">Dashboard</a>
		</div>
		<div class="log-in-out-btn">
			<a href="<?php echo base_url('student/logout'); ?>" class="auth-link-anchor">Log Out</a>
		</div>
	  </div>
	</div>
</header>