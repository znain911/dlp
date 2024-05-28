<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div style="height: 50px; clear: both;"></div>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/1');?>" class="btn btn-lg bg-success">Phase 1<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/2');?>" class="btn btn-lg bg-primary">Phase 2<br>Download Course Material</a>
				<a style="text-transform: capitalize;" href="<?php echo base_url('faculty/dashboard/lessons_download/3');?>" class="btn btn-lg bg-info">Phase 3<br>Download Course Material</a>
				
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>