<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<title>Distance Learning Programme (DLP)</title>
	<style type="text/css">
		.main-title{
		color: #393939;
		text-align: left;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		.main-title > span{
		color: #ffa500;
		font-weight: bold;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		p.login-dtls{}
		p.regards-best{line-height:23px;}
		p {
		  color: #454545;
		  font-size: 14px;
		  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		.aftr-pid, .login-dtls{line-height:22px;}
		.mail-container-bdy{
			background: #fff;
			padding: 37px 50px 50px;
			margin: 0px 150px;
		}
		.main-body{
			background:#3C73B1;
			padding:100px 0px;
			margin:0;
		}
		.result-ar-box {
		    border: 5px solid #ff0000;
		    margin: 50px auto 0;
		    padding: 20px;
		    text-align: left;
		    width: 500px;
		}
		.details-ofright {
		    border-top: 3px solid #0a0;
		    font-size: 14px;
		    margin-top: 10px;
		    padding: 10px 0;
		}
		.result-ar-box > h2 {
		    color: #333;
		    font-size: 21px;
		    font-weight: bold;
		    text-align: center;
		}
		.result-ar-box p {
		    line-height: 27px;
		    margin: 0;
		    text-align: center;
		}
		.details-ofresult {
		    border-top: 3px solid #0a0;
		    font-size: 14px;
		    padding-top: 15px;
		}
		.text-left {
		    text-align: left!important;
		}
		@media (min-width: 320px) and (max-width: 480px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 360px) and (max-width: 640px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 768px) and (max-width: 1024px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 980px) and (max-width: 1280px) {}
		@media (min-width: 980px) and (max-width: 1280px) {}
	</style>
</head>
<body class="main-body">
	<div class="mail-container-bdy">
		<h2 class="main-title"><span>Dear Mr/Ms/Mrs </span><?php echo $name; ?>,</h2>
		<?php echo $content; ?>

		<div class="result-ar-box">
			<h2>Module: <strong><?php echo $mdlname; ?></strong></h2>
			<h2>Lesson: <strong><?php echo $lnsname; ?></strong></h2>
					<h2>Practice Examination Result</h2>
					<?php if($total_score >= $total_passing_score): ?>
					<p>Congratulations! You have passed in your practice examination.</p>
					<?php endif; ?>
					<div class="details-ofright">
						<p><strong>Total Questions : <?php echo $total_questions; ?></strong></p>
						<p><strong>Total Right Answer : <?php echo $total_right_answers; ?></strong></p>
						<p><strong>Total Wrong Answer : <?php echo $total_wrong_answers; ?></strong></p>
					</div>
					<?php 
						$wrong_answers = $this->Exam_model->get_wrong_answer($this->session->userdata('practice_exam_id'));
						if(count($wrong_answers) !== 0):
						$w_sl = 1;
						foreach($wrong_answers as $answer):
						if($answer['question_type'] == 'JUSTIFY')
						{
							
							/*$right_answer = $answer['question_justify_answer'];*/

							if ($answer['answer_status'] == 0) {
									$right_answer = $answer['question_justify_answer'].'';
								}else{
									$right_answer = $answer['question_justify_answer'];
								}
							
						}elseif($answer['question_type'] == 'MCQ'){
							
							$right_ans_ids = $this->Exam_model->get_right_answersids($answer['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Exam_model->get_answer_titleby_id($answer_id);
								/*$r_answer .= $get_answer_title['answer_title'].', ';*/
								if ($answer['answer_status'] == 0) {
									$r_answer .= $get_answer_title['answer_title'].',';
								}else{
									$r_answer .= $get_answer_title['answer_title'].', ';
								}
							}
							$right_answer = $r_answer;
						}elseif($answer['question_type'] == 'BLANK'){
							$right_ans_ids = $this->Exam_model->get_right_answersids($answer['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Exam_model->get_answer_titleby_id($answer_id);
								if ($answer['answer_status'] == 0) {
									$r_answer .= $get_answer_title['answer_title'].',';
								}else{
									$r_answer .= $get_answer_title['answer_title'].', ';
								}
								
							}
							$right_answer = $r_answer;
						}elseif($answer['question_type'] == 'MULTIPLE_JUSTIFY'){
							$right_ans_ids = $this->Exam_model->get_right_answersids($answer['question_id']);
							$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
							$r_answer = '';
							foreach($answer_array as $answer_id => $jusitfy_answer)
							{
								$get_answer_title = $this->Exam_model->get_answer_titleby_id($answer_id);
								if($jusitfy_answer == '1')
								{
									$ans_justify = '<span style="color:#0A0">TRUE</span>';
								}elseif($jusitfy_answer == '0')
								{
									$ans_justify = '<span style="color:#F00">FALSE</span>';
								}else
								{
									$ans_justify = '';
								}
								/*$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong> ';*/

								if ($answer['answer_status'] == 0) {
									$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong>';
								}else{
									$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong> ';
								}
							}
							$right_answer = $r_answer;
						}
					?>
					<div class="details-ofright">
						<div class="single-question">
							<strong class="question-li"><span style="color:#f00"><?php echo $w_sl; ?>.</span> <?php echo $answer['question_title']; ?></strong> <br />
							<p class="text-left" style="padding-left: 15px;font-size: 13px;"><strong style="color:#F00">Right Answer : </strong> <?php echo $right_answer; ?></p>
						</div>
					</div>
					<?php 
						$w_sl++;
						endforeach; 
					?>
					<?php endif; ?>
					<div class="details-ofresult">
						<p><strong>Your Score : <?php echo $total_score; ?></strong></p>
						<p><strong>Passing Score : <?php echo $total_passing_score; ?></strong></p>
						<p><strong>Result : <?php echo $result_shw; ?></strong></p>
					</div>
				</div>

		<p class="regards-best">
			Thanks & Regards <br />
			<strong>Coordinator</strong> <br />
			Distance Learning Programme (DLP)
		</p>
	</div>
	
	
</body>
</html>