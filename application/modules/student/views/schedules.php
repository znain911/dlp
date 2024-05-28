<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="all-available-schedules myac-container">
						<div class="row">
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">SDT 1 Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at SDT 1</p>
									  <?php 
										$check_ece_status = $this->Perm_model->check_student_ece_status();
										if($check_ece_status == false && $this->session->userdata('active_phase') == 2):
									  ?>
										  <a class="btn btn-raised btn-info" href="<?php echo base_url('student/schedules/sdt?type=1'); ?>">
												<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
										  </a>
									  <?php else: ?>
										  <a class="btn btn-raised btn-info" href="javascript:void(0);">
												<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
										  </a>
									  <?php endif; ?>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">SDT 2 Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at SDT 2</p>
									  <?php 
										$check_ece_status = $this->Perm_model->check_student_ece_status();
										if($check_ece_status == false && $this->session->userdata('active_phase') == 2):
									  ?>
										  <a class="btn btn-raised btn-info" href="<?php echo base_url('student/schedules/sdt?type=2'); ?>">
												<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
										  </a>
									  <?php else: ?>
										  <a class="btn btn-raised btn-info" href="javascript:void(0);">
												<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
										  </a>
									  <?php endif; ?>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">Workshop Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at Workshop</p>
									  <?php 
										if($check_ece_status == false && ($this->session->userdata('active_phase') == 2 || $this->session->userdata('active_phase') == 3)):
									  ?>
									  <a class="btn btn-raised btn-info" href="<?php echo base_url('student/schedules/workshop'); ?>">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									  <?php else: ?>
									   <a class="btn btn-raised btn-info" href="javascript:void(0);">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									  <?php endif; ?>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">ECE Examination Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at ECE Examination</p>
									  <?php
											$check_ece_schedule = $this->Perm_model->check_ece_schedule();
											if($check_ece_status == true && $check_ece_schedule == true):
									  ?>
									  <a class="btn btn-raised btn-info" href="<?php echo base_url('student/schedules/ece'); ?>">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									  <?php else: ?>
									  <a class="btn btn-raised btn-info" href="javascript:void(0);">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									  <?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>