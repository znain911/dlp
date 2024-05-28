<!-- begin panel -->
	<div class="details-view-contnr items-row-<?php echo $item['student_id']; ?>">
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-purple">
					<div class="panel-heading">
						<h4 class="panel-title">Personal Information</h4>
					</div>
					<div class="panel-body">
						<table class="table">
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Full Name : </strong></td>
								<td>
									<?php 
										if($item['spinfo_middle_name'])
										{
											$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
										}else
										{
											$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
										}
									?>
									<?php echo $full_name; ?>
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Birth Date : </strong></td>
								<td>
									<?php
										if($item['spinfo_birth_date']):
											$time = strtotime($item['spinfo_birth_date']);
											$myFormatForView = date("d M, Y", $time);
											echo $myFormatForView;
										endif;
									?>
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Gender : </strong></td>
								<td>
									<?php
										$gender = array('0' => 'Male', '1' => 'Female', '2' => 'Other');
										echo (isset($item['spinfo_gender']))? $gender[$item['spinfo_gender']] : null;
									?>
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Nationality : </strong></td>
								<td><?php echo $item['country_name']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Recent Photo : </strong></td>
								<td>
									<img src="<?php echo attachment_url('students/'.$item['student_entryid'].'/'.$item['spinfo_photo']); ?>" width="50" alt="" />
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Father's/Mother's/Spouse's Type : </strong></td>
								<td><?php echo $item['spouse_type']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Father's/Mother's/Spouse's Name : </strong></td>
								<td><?php echo $item['spinfo_fmorspouse_name']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>National ID : </strong></td>
								<td><?php echo $item['spinfo_national_id']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>National ID Front : </strong></td>
								
								<?php if($item['nid_front']):?>
								<td>
									<a href = "<?php echo $item['nid_front']; ?>" target = "_blank"><img src="<?php echo $item['nid_front']; ?>" width="100" alt="" /></a>
								</td>
								<?php else:?>
								<td>
									<img src="<?php echo attachment_url('students/'.$item['student_entryid'].'/'.$item['spinfo_national_photo']); ?>" width="90" alt="" />
								</td>
								<?php endif;?>
								
							</tr>
							
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>National ID Back : </strong></td>
								
								<?php if($item['nid_back']):?>
								<td>
									<a href = "<?php echo $item['nid_back']; ?>" target = "_blank"><img src="<?php echo $item['nid_back']; ?>" width="100" alt="" /></a>
								</td>
								
								<?php endif;?>
								
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Contact Email : </strong></td>
								<td><?php echo $item['student_email']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Mobile Number : </strong></td>
								<td><?php echo $item['spinfo_personal_phone']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Office Phone : </strong></td>
								<td><?php echo $item['spinfo_office_phone']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Home Phone : </strong></td>
								<td><?php echo $item['spinfo_home_phone']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Current Address : </strong></td>
								<td><?php echo $item['spinfo_current_address']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Permanent Address : </strong></td>
								<td><?php echo $item['spinfo_permanent_address']; ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-purple">
					<div class="panel-heading">
						<h4 class="panel-title">Professional Information</h4>
					</div>
					<div class="panel-body">
						<table class="table">
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>BADAS Affiliated : </strong></td>
								<td><?php echo $item['badas_affiliated']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Designation : </strong></td>
								<td><?php echo $item['spsinfo_designation']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Organization : </strong></td>
								<td><?php echo $item['spsinfo_organization']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Organization Type : </strong></td>
								<?php if($item['org_type']):?>
								<td>
									<?php echo $item['org_type']; ?>
								</td>
								
								<?php endif;?>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Address of organization : </strong></td>
								<td><?php echo $item['spsinfo_organization_address']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Specialization : </strong></td>
								<td>
									<?php 
										$get_specializations = $this->Students_model->get_specializations($item['student_id']);
										$specialization = '';
										foreach($get_specializations as $row){
											
											if($row['ss_specilzation_has_other'] == '1')
											{
												if(end($get_specializations)['ss_specilzation_other'] == $row['ss_specilzation_other'])
												{
													$specialization .= $row['ss_specilzation_other'];
												}else
												{
													$specialization .= $row['ss_specilzation_other'].', ';
												}
											}else
											{
												$spz_name = $this->Students_model->get_specialization_name($row['ss_specilzation_id']);
												if(end($get_specializations)['ss_specilzation_id'] == $row['ss_specilzation_id'])
												{
													$specialization .= $spz_name;
												}else
												{
													$specialization .= $spz_name.', ';
													
												}
											}
										}
										echo $specialization;
									?>
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>BM&DC Number : </strong></td>
								<td><?php echo $item['spsinfo_bmanddc_number']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>SSC Certificate : </strong></td>
								<?php if($item['ssc_certificate']):?>
								<td>
									<a href = "<?php echo $item['ssc_certificate']; ?>" target = "_blank"><img src="<?php echo $item['ssc_certificate']; ?>" width="100" alt="" /></a>
								</td>
								
								<?php endif;?>
							</tr>
							
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>MBBS Certificate : </strong></td>
								<?php if($item['mbbs_certificate']):?>
								<td>
									<a href = "<?php echo $item['mbbs_certificate']; ?>" target = "_blank"><img src="<?php echo $item['mbbs_certificate']; ?>" width="100" alt="" /></a>
								</td>
								
								<?php endif;?>
							</tr>
							
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>BM&DC Certificate : </strong></td>
								<?php if($item['bmdc_certificate']):?>
								<td>
									<a href = "<?php echo $item['bmdc_certificate']; ?>" target = "_blank"><img src="<?php echo $item['bmdc_certificate']; ?>" width="100" alt="" /></a>
								</td>
								<?php else:?>
								<td>
									<img src="<?php echo attachment_url('students/'.$item['student_entryid'].'/'.$item['spsinfo_bmanddc_certificate']); ?>" width="80" alt="" />
								</td>
								<?php endif;?>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>DLP Category : </strong></td>
								<td>
									<?php 
										$get_dlpcats = $this->Students_model->get_dlp_categories($item['student_id']);
										$cats = '';
										foreach($get_dlpcats as $dlpcat){
											if(end($get_dlpcats)['category_name'] == $dlpcat['category_name'])
											{
												$cats .= $dlpcat['category_name'];
											}else
											{
												$cats .= $dlpcat['category_name'].', ';
											}
										}
										echo $cats;
									?>
								</td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Types of practice : </strong></td>
								<td><?php echo $item['spsinfo_typeof_practice']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Years since passing MBBS : </strong></td>
								<td><?php echo $item['spsinfo_sinceyear_mbbs']; ?></td>
							</tr>
							<tr style="background:#F9F9F9">
								<td class="text-right"><strong>Years of experience : </strong></td>
								<td><?php echo $item['spsinfo_experience']; ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="panel panel-purple">
					<div class="panel-heading">
						<h4 class="panel-title">Academic Information</h4>
					</div>
					<div class="panel-body">
						<table class="table">
							<thead>
								<tr>
									<th>Degree</th>
									<th>Year</th>
									<th>Institue/University</th>
									<th>Marks/CGPA</th>
									<th>Certificate</th>
								</tr>
							</thead>
							<?php 
								$get_academicinfo = $this->Students_model->get_academicinformation($item['student_id']);
								foreach($get_academicinfo as $academic){
							?>
							<tr style="background:#F9F9F9">
								<td><?php echo $academic['sacinfo_degree']; ?></td>
								<td><?php echo $academic['sacinfo_year']; ?></td>
								<td><?php echo $academic['sacinfo_institute']; ?></td>
								<td><?php echo $academic['sacinfo_cgpa']; ?></td>
								<td><a href="<?php echo base_url('attachments/students/'.$item['student_entryid'].'/'.$academic['sacinfo_certificate']); ?>" target="_blank">View Certificate</a></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
			
			<div class="col-lg-12">
				<div class="details-action-sec">
					<span class="row-action-status-holder-<?php echo $item['student_id']; ?>">
						<?php if($item['student_status'] === '0'): ?>
						<button data-status="1" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-cog"></i> Approve</button>
						<?php else: ?>
						<button data-status="0" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-danger btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button>
						<?php endif; ?>
					</span>
					<!--<button data-student="<?php echo $item['student_id']; ?>" onclick="return confirm('Are you sure?', true);" class="remove-row btn btn-danger btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>-->
				</div>
			</div>
		</div>
	</div>
<!-- end panel -->