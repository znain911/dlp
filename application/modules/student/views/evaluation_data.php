<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<br />
					<div class="result-table">
						<h2 style="padding:10px;margin:0;text-align:center">
							<strong>Your evaluation has been done</strong><br>
							<a href="<?php echo base_url('student/evaluation/lists');?>" class="btn btn-info" style="background: green; color: #fff; margin-top: 20px; font-size:22px; ">View List</a>
						</h2>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
<?php require_once APPPATH.'modules/common/footer.php'; ?>