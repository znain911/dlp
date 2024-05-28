<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Distance Learning Programme (DLP)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/jquery.jdSlider.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/normalize.css">
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/style.light-blue-500.min.css">
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
		<script src="<?php echo base_url('frontend/exam/assets/js/jquery.validate.js'); ?>"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var sqtoken_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
		</script>
	</head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="exam-container">
			<div class="container-logo-bar">
				<div class="top-bar-with-logo container">
					<div class="row">
						<div class="col-lg-12">
							<div class="logo"><img src="<?php echo base_url('frontend/tools/dlp.png'); ?>" alt="Logo" /></div>
							<div class="org-title">Distance Learning Programme (DLP)</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="container-timing-bar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 text-left">
							<div class="item-no">
								<strong>Total Questions : </strong><?php echo $limit; ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>Time : </strong><?php echo $exam_time; ?> Minutes
							</div>
						</div>
						<div class="col-lg-6 text-right">
							<!-- <div class="timing-count-down" id="timeRemaining"></div> -->
						</div>
					</div>
				</div>
			</div>
			
			<?php 
				$attr = array('id' => 'examEndModule');
				echo form_open('', $attr);
			?>
			<div id="refreshArea">
				<?php require_once APPPATH.'modules/faculty/views/practice_question_new.php'; ?>
			</div>
			<?php echo form_close(); ?>
		</div>
        
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/jquery.jdSlider-latest.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/main.js"></script>
		
		
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.btn-cncl', function(){
					if(confirm('Are you want to exit?'))
					{
						/*window.location.href=baseUrl+"student/course";*/
						/*close();*/
						window.location.close();
					}else
					{
						return false;
					}
				});
				
				/*$(document).on('click', '.btn-sbmt', function(){
					if(confirm('Are you want to submit?'))
					{
						return true;
					}else
					{
						return false;
					}
				});*/
			});
		</script>
		<script type="text/javascript">
			function remove_emptyli()
			{
				var get_ln = $('.last-li-q:last-child').children('div').length;
				if(get_ln == 0)
				{
					$('.last-li-q:last-child').remove();
				}
				
			}
		</script>

    </body>
</html>
