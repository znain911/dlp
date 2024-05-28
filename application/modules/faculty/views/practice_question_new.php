<?php $gte_questions = $this->Examquestion_model->get_practice_question($phase_level, $module_id, $lesson_id, $question_type, $limit);?>
<input type="hidden" name="module" value="<?php echo $module_id; ?>" />
<input type="hidden" name="lesson" value="<?php echo $lesson_id; ?>" />
<input type="hidden" name="active_phase" value="<?php echo $phase_level; ?>" />
<div id="loader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
<div class="container-question-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<section class="jd-slider example">
					<div class="slide-inner">
						<ul class="slide-area">
							<li>
								<?php 
									$sl_number = 0;
									$ttl_elmnt = count($gte_questions);
									foreach($gte_questions as $key => $question): 
									
									if(!in_array($question['question_type'], $question_type))
									{
										continue;
									}
									
									if($question['question_right_answerid'])
									{
										$right_answer_string = json_decode($question['question_right_answerid'], true);
										$answer_count = count($right_answer_string);
										
										if($answer_count > 1)
										{
											$has_multiple_answer = 1;
										}else
										{
											$has_multiple_answer = 0;
										}
									}
									
									$q_no = $sl_number+1;
								?>
								<div class="question">
									<p class="question-n"><strong>Question <?php echo $q_no; ?>: </strong> <?php echo $question['question_title']; ?></p>
									<input type="hidden" name="question_row[]" value="<?php echo $q_no; ?>" />
									<input type="hidden" name="question_row_value_<?php echo $q_no; ?>" value="<?php echo $question['question_id']; ?>" />
									<?php if($question['question_type'] == 'MCQ'){ ?>
										<input type="hidden" name="has_multiple_answer_row_<?php echo $q_no; ?>" value="<?php echo $has_multiple_answer; ?>" />
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />
										<div class="anser-lists">
											<ul>
												<li>
													<?php
														$mcq_answers = $this->Examquestion_model->get_question_answers($question['question_id']);
														$alpha = 'a';
														if($has_multiple_answer == 1)
														{
															echo '<span class="sel-list-lbl">You have to select more than 1 answer.</span>';
														}
														foreach($mcq_answers as $ans):
														if($ans['answer_title'] == '')
														{
															continue;
														}
														if($has_multiple_answer == 1):
													?>
													<label class="ansr-q"><input type="checkbox" name="q_answer_row_<?php echo $q_no; ?>_row[]" value="<?php echo $ans['answer_id']; ?>" /> <?php echo $ans['answer_title']; ?></label> <br />
													<?php else: ?>
													<label class="ansr-q"><input type="radio" name="q_answer_row_<?php echo $q_no; ?>" value="<?php echo $ans['answer_id']; ?>" /> <?php echo $ans['answer_title']; ?></label> <br />
													<?php
														endif;
														$alpha++;
														endforeach; 
													?>
												</li>
											</ul>

										</div>
									<?php }elseif($question['question_type'] == 'BLANK'){ ?>
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />	
										<div class="anser-lists">
											<p class="blank_ans_field">
												<?php 
													$alpha = 'a';
													foreach($right_answer_string as $ans_id):
												?>
												(<?php echo $alpha; ?>)<input type="text" name="blank_ans_field_<?php echo $q_no; ?>_row[]" value="" /> &nbsp;&nbsp;&nbsp;
												<?php
													$alpha++;
													endforeach;
												?>
											</p>
											<span class="sel-list-lbl">Select the right answer from the list below & fill up the blank.</span>
											<ul>
												<li class="blank-answer-li">
													<?php
														$blank_answers = $this->Examquestion_model->get_question_answers($question['question_id']);
														$psn = 0;
														foreach($blank_answers as $ans):
														if($ans['answer_title'] == '')
														{
															continue;
														}
													?>
													<span><i class="fa fa-circle"></i> <?php echo $ans['answer_title']; ?></span> <br />
													<input type="hidden" name="q_blank_<?php echo $q_no; ?>_ans[]" value="<?php echo $ans['answer_title']; ?>" />
													<?php 
														$psn++;
														endforeach; 
													?>
												</li>
											</ul>
										</div>
											
									<?php }elseif($question['question_type'] == 'JUSTIFY'){ ?>
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />
										<div class="anser-lists">
											<ul>
												<li>
													<label class="ansr-q"><input type="radio" name="q_answer_row_<?php echo $q_no; ?>" value="1" /> True</label> <br />
													<label class="ansr-q"><input type="radio" name="q_answer_row_<?php echo $q_no; ?>" value="0" /> False</label>
												</li>
											</ul>
										</div>
									<?php }elseif($question['question_type'] == 'MULTIPLE_JUSTIFY'){ ?>
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />
										<div class="anser-lists">
											<ul>
												<li style="line-height:25px">
													<?php
														$mcq_answers = $this->Examquestion_model->get_question_answers($question['question_id']);
														$right_answers = json_decode($question['question_right_answerid'], true);
														$alpha = 'a';
														$ans_sl = 1;
														foreach($mcq_answers as $ans):
															if($ans['answer_title'] == '')
															{
																continue;
															}
													?>
													<?php echo '<strong>('.$alpha.') '.$ans['answer_title'].'</strong>'; ?> <br />
													<input type="hidden" name="q_answer_row_<?php echo $q_no; ?>_row[]" value="<?php echo $ans['answer_id']; ?>" />
													<label style="margin-right:10px;color:#0A0;">
														 <input type="radio" name="q_answer_<?php echo $q_no; ?>_<?php echo $ans['answer_id']; ?>" value="1" /> TRUE
													</label> 
													<label style="color:#F00">
														 <input type="radio" name="q_answer_<?php echo $q_no; ?>_<?php echo $ans['answer_id']; ?>" value="0" /> FALSE
													</label> 
													<br />
													
													<?php
														$alpha++;
														$ans_sl++;
														endforeach; 
													?>
												</li>
											</ul>
										</div>
									<?php } ?>
								</div>
<?php
								if($question['question_type'] == 'JUSTIFY')
						{
							
							$right_answer = $question['question_justify_answer'];
							
						}elseif($question['question_type'] == 'MCQ'){
							
							$right_ans_ids = $this->Examquestion_model->get_right_answersids($question['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
								$r_answer .= $get_answer_title['answer_title'].', ';
							}
							$right_answer = $r_answer;
						}elseif($question['question_type'] == 'BLANK'){
							$right_ans_ids = $this->Examquestion_model->get_right_answersids($question['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
								$r_answer .= $get_answer_title['answer_title'].', ';
							}
							$right_answer = $r_answer;
						}elseif($answer['question_type'] == 'MULTIPLE_JUSTIFY'){
							$right_ans_ids = $this->Examquestion_model->get_right_answersids($question['question_id']);
							$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
							$r_answer = '';
							foreach($answer_array as $answer_id => $jusitfy_answer)
							{
								$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
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
								$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong> ';
							}
							$right_answer = $r_answer;
						}
					?>
					<div class="details-ofright">
						<div class="single-question">
							<strong class="question-li"><!-- <span style="color:#f00"></span> <?php echo $question['question_title']; ?> --><span style="color:#F00">Right Answer : </span> <?php echo $right_answer; ?></strong> <br />
							<!-- <p class="text-left" style="padding-left: 15px;font-size: 13px;"><strong style="color:#F00">Right Answer : </strong> <?php echo $right_answer; ?></p> -->
						</div>
					</div>

								<?php
									$sl_number++;
									if($sl_number % 1 == 0){
										echo '</li><li class="last-li-q">';
									}
									endforeach; 
								?>
							</li>
						</ul>
						<a class="prv-nav">Previous</a>
						<a class="prv-nxt" onclick="remove_emptyli();">Next</a>
					</div>


<!-- <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								        <div class="panel panel-default">
			            <div class="panel-heading" role="tab" id="heading3">
			                <h4 class="panel-title">
			                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3" style="display: block;">
			                        <i class="more-less glyphicon glyphicon-plus"></i>
			                        Who can join as faculty of CCVD?			                    </a>
			                </h4>
			            </div>
			            <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
			                <div class="panel-body">
			                      <p>Postgraduates in Cardiology with a kin interest in teaching and face to face sessions of skill development will be given preference.</p>

			                </div>
			            </div>
			        </div>
</div> -->


					<!-- <div class="result-ar-box">
					<h2>Practice Examination Result</h2>
					
					<?php 
						/*$wrong_answers = $this->Examquestion_model->get_wrong_answer($this->session->userdata('practice_exam_id'));*/
						if(count($gte_questions) !== 0):
						$w_sl = 1;
						foreach($gte_questions as $answer):
						if($answer['question_type'] == 'JUSTIFY')
						{
							
							$right_answer = $answer['question_justify_answer'];
							
						}elseif($answer['question_type'] == 'MCQ'){
							
							$right_ans_ids = $this->Examquestion_model->get_right_answersids($answer['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
								$r_answer .= $get_answer_title['answer_title'].', ';
							}
							$right_answer = $r_answer;
						}elseif($answer['question_type'] == 'BLANK'){
							$right_ans_ids = $this->Examquestion_model->get_right_answersids($answer['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
								$r_answer .= $get_answer_title['answer_title'].', ';
							}
							$right_answer = $r_answer;
						}elseif($answer['question_type'] == 'MULTIPLE_JUSTIFY'){
							$right_ans_ids = $this->Examquestion_model->get_right_answersids($answer['question_id']);
							$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
							$r_answer = '';
							foreach($answer_array as $answer_id => $jusitfy_answer)
							{
								$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
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
								$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong> ';
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
					
				</div> -->
				</section>
			</div>
		</div>
	</div>
</div>

<!-- <div class="sbmt-panl-bar">
	<div class="btsmbt-pnl">
		<span class="btn-cncl">Cancel</span>
		<button type="submit" class="btn-sbmt">Submit</button>
	</div>
</div> -->

<div class="container-question-area">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<h2 style="text-align: center;">Exam History</h2>
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<?php foreach ($stexam as $elist) {?>
										
                                        <div class="panel panel-default">
				                        <div class="panel-heading" role="tab" id="heading90">
				                            <h4 class="panel-title">
				                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $elist->examcnt_id;?>" aria-expanded="true" aria-controls="collapse<?php echo $elist->examcnt_id;?>" style="display: block; color: #000000">
				                                    <i class="more-less glyphicon glyphicon-plus"></i>
				                                    <?php echo $elist->examcnt_date;?>                             </a>
				                            </h4>
				                        </div>
				                        <div id="collapse<?php echo $elist->examcnt_id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $elist->examcnt_id;?>">
				                            <div class="panel-body">
				                                  <div class="result-ar-box">
													<h2>Practice Examination Result</h2>
													<?php 
													$total_right_answers = $this->Examquestion_model->get_lesson_right_answers($elist->examcnt_id);
		$total_wrong_answers = $this->Examquestion_model->get_lesson_wrong_answers($elist->examcnt_id);
				
		$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
		$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];

													if($total_score >= $total_passing_score): ?>
					<p>Congratulations! You have passed in your practice examination.</p>
					<?php endif; ?>
					<div class="details-ofright">
						<p><strong>Total Questions : <?php echo $limit; ?></strong></p>
						<p><strong>Total Right Answer : <?php echo $total_right_answers; ?></strong></p>
						<p><strong>Total Wrong Answer : <?php echo $total_wrong_answers; ?></strong></p>
					</div>
													<?php 
														$wrong_answers = $this->Examquestion_model->get_wrong_answer($elist->examcnt_id);
														if(count($wrong_answers) !== 0):
														$w_sl = 1;
														foreach($wrong_answers as $answer):
														if($answer['question_type'] == 'JUSTIFY')
														{
															
															$right_answer = $answer['question_justify_answer'];
															
														}elseif($answer['question_type'] == 'MCQ'){
															
															$right_ans_ids = $this->Examquestion_model->get_right_answersids($answer['question_id']);
															$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
															$right_answer_string = str_replace(']', '', $right_answer_string);
															$right_answer_string = explode(',', $right_answer_string);
															$answer_array = $right_answer_string;
															$r_answer = '';
															foreach($answer_array as $answer_id)
															{
																$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
																$r_answer .= $get_answer_title['answer_title'].', ';
																
															}
															$right_answer = $r_answer;
														}elseif($answer['question_type'] == 'BLANK'){
															$right_ans_ids = $this->Examquestion_model->get_right_answersids($answer['question_id']);
															$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
															$right_answer_string = str_replace(']', '', $right_answer_string);
															$right_answer_string = explode(',', $right_answer_string);
															$answer_array = $right_answer_string;
															$r_answer = '';
															foreach($answer_array as $answer_id)
															{
																$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
																$r_answer .= $get_answer_title['answer_title'].', ';
																
															}
															$right_answer = $r_answer;
														}elseif($answer['question_type'] == 'MULTIPLE_JUSTIFY'){
															$right_ans_ids = $this->Examquestion_model->get_right_answersids($answer['question_id']);
															$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
															$r_answer = '';
															foreach($answer_array as $answer_id => $jusitfy_answer)
															{
																$get_answer_title = $this->Examquestion_model->get_answer_titleby_id($answer_id);
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
																$r_answer .= '<br />'.$get_answer_title['answer_title'].'<br /><strong>Ans : '.$ans_justify.'</strong>';
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

													<?php
													
		if($total_score < $total_passing_score)
			{
				$result_shw = '<span class="result-shw-failed">Failed</span>';
			}else
			{
				$result_shw = '<span class="result-shw-pass">Passed</span>';
			}
													 ?>
													<div class="details-ofresult">
														<p><strong>Your Score : <?php echo $total_score; ?></strong></p>
														<p><strong>Passing Score : <?php echo $total_passing_score; ?></strong></p>
														<p><strong>Result : <?php echo $result_shw; ?></strong></p>
													</div>
												</div>
				                            </div>
				                        </div>
				                    </div>
				                <?php }?>
				                   
                                    </div>
							</div>
						</div>
					</div>
				</div>
