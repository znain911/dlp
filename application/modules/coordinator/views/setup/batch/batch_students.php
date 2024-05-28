<!-- begin panel -->
	<div class="details-view-contnr">
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-purple">
					
					<div class="panel-body">
						<table class="table table-td-valign-middle m-b-0">
							<thead>
								<tr>
									<th class="text-center">Student Id</th>
									<th class="text-center">Name</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($item as $stls) {?>
								<tr>
									<td class="text-center"><?php echo $stls->student_finalid;?></td>
									<td class="text-center"><?php echo $stls->spinfo_first_name.' '.$stls->spinfo_middle_name.' '.$stls->spinfo_last_name;?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						
						

					</div>
				</div>
			</div>
			
		</div>
	</div>
<!-- end panel -->