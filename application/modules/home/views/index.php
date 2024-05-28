<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php $get_banner = $this->Common_model->get_option_banners(); ?>
	<div class="dlp-main-banner banner-orgns">
		<div class="left-portion-box">
			<div class="left-portion-top-container">
				<div class="banner-left-top">
					<a href=""><img src="<?php echo attachment_url($get_banner['option_one']); ?>" /></a>
				</div>
			</div>
		</div>
		<div class="right-portion-box">
			<div class="left-portion-bottom-container">
				<div class="banner-left-bottom-left"><a href=""><img src="<?php echo attachment_url($get_banner['option_two']); ?>" /></a></div>
				<div class="banner-left-bottom-right"><a href=""><img src="<?php echo attachment_url($get_banner['option_three']); ?>" /></a></div>
			</div>
		</div>
	</div>
	<div class="dlp-main-banner">
		<div class="left-portion-box">
			<div class="left-portion-top-container">
				<div class="banner-left-top">
					<a href=""><img src="<?php echo attachment_url($get_banner['option_four']); ?>" /></a>
				</div>
			</div>
			<div class="left-portion-bottom-container">
				<div class="banner-left-bottom-left"><a href=""><img src="<?php echo attachment_url($get_banner['option_five']); ?>" /></a></div>
				<div class="banner-left-bottom-right"><a href=""><img src="<?php echo attachment_url($get_banner['option_six']); ?>" /></a></div>
			</div>
		</div>
		<div class="right-portion-box">
			<div class="banner-right-portion">
				<h3>ONLINE CCD</h3>
				<div class="single-post set-position-relative">
					<p><a href="<?php echo base_url('page/about-dlp'); ?>">About DLP</a></p>
					<p><?php echo $this->Common_model->short_descby_slug('about-dlp'); ?></p>
					<a href="<?php echo base_url('page/about-dlp'); ?>" class="read-more">Read More <i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="single-post set-position-relative">
					<p><a href="<?php echo base_url('page/benifits'); ?>">Online CCD & Its benifits</a></p>
					<p><?php echo $this->Common_model->short_descby_slug('benifits'); ?></p>
					<a href="<?php echo base_url('page/benifits'); ?>" class="read-more">Read More <i class="fa fa-angle-double-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3" style="color:#FFF">DLP Organogram</h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$organograms = $this->Home_model->get_dlp_organograms();
					foreach($organograms as $organogram):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram['owner_photo']):
							?>
							<img src="<?php echo attachment_url('coordinators/'.$organogram['owner_photo']); ?>"/>
							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram['owner_designation']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3" style="color:#FFF">Coordinators</h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$coordinators = $this->Common_model->get_coordinator();
					foreach($coordinators as $coordinator):
				?>
				<div class="col-lg-15">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($coordinator['owner_photo']):
							?>
							<img src="<?php echo attachment_url('coordinators/'.$coordinator['owner_photo']); ?>"/>
							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $coordinator['owner_name']; ?></strong></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="dlp-home-container-head" id="landingFaqs">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3" style="color:#FFF">FAQS</h3>
			</div>
		</div>
	</div>
	<div class="home-faq-containers">
		<div class="row">
			<div class="col-lg-4 text-center" style="padding:0">
				<div class="home-faq-title">Website FAQS</div>
			</div>
			<div class="col-lg-4 text-center" style="padding:0">
				<div class="home-faq-title">Students FAQS</div>
			</div>
			<div class="col-lg-4 text-center" style="padding:0">
				<div class="home-faq-title">Faculties FAQS</div>
			</div>
		</div>
	</div>
	<div class="home-faq-content-containers">
        <div class="row">
            <div class="col-lg-4">
                 
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php 
                        $get_faqs = $this->Faqs_model->get_all_faqs();
                        foreach($get_faqs as $faq1):
                        $inc1 = $faq1['faq_id'];
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading<?php echo $inc1; ?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc1; ?>" aria-expanded="true" aria-controls="collapse<?php echo $inc1; ?>" style="display: block;">
                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                    <?php echo $faq1['faq_title']; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $inc1; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $inc1; ?>">
                            <div class="panel-body">
                                  <?php echo $faq1['faq_description']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div><!-- panel-group -->
  
            </div>
            <div class="col-lg-4">
                 
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php 
                        $get_faqs = $this->Faqs_model->get_all_faqs('Student');
                        foreach($get_faqs as $faq2):
                        $inc2 = $faq2['faq_id'];
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading<?php echo $inc2; ?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc2; ?>" aria-expanded="true" aria-controls="collapse<?php echo $inc2; ?>" style="display: block;">
                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                    <?php echo $faq2['faq_title']; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $inc2; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $inc2; ?>">
                            <div class="panel-body">
                                  <?php echo $faq2['faq_description']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div><!-- panel-group -->
            </div>
            <div class="col-lg-4">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php 
                        $get_faqs = $this->Faqs_model->get_all_faqs('Faculty');
                        foreach($get_faqs as $faq):
                        $inc = $faq['faq_id'];
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading<?php echo $inc; ?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc; ?>" aria-expanded="true" aria-controls="collapse<?php echo $inc; ?>" style="display: block;">
                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                    <?php echo $faq['faq_title']; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $inc; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $inc; ?>">
                            <div class="panel-body">
                                  <?php echo $faq['faq_description']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div><!-- panel-group -->
            </div>
        </div>
    </div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>