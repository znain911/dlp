<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
	<!-- end #header -->
	
	<!-- begin #sidebar -->
	<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
	
	<!-- begin #content -->
	<div id="content" class="content">
		
		<!-- begin row -->
		<div class="row">
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-md-12">
				<!-- begin widget -->
				<div id="onPgaeLoadingForm"></div>
				<div class="widget p-0">
					<div class="table-responsive">
						<div class="filtar-bar">
							<div class="limit-box" style="margin-left: 10px;">
								<p>
									<span>Show : &nbsp;&nbsp;</span>
									<?php 
										$value_array = array(10,20,30,40,50,60,70,80,90,100);
									?>
									<select name="limit" id="limit" onchange="searchFilter()">
										<option value="10" selected="selected">10</option>
										<?php 
											foreach($value_array as $array):
										?>
												<option value="<?php echo $array; ?>" <?php echo (isset($_GET['limit']) && $_GET['limit'] == $array)? 'selected' : null; ?>><?php echo $array; ?></option>
										<?php
											endforeach;
										?>
									</select>
								</p>
							</div>
							<div class="limit-box" style="margin-left: 10px;">
								<p>
									<span>From : &nbsp;&nbsp;</span>
									<input type="text" name="from" id="fromDate" onload="clearThis(this.value)" class="custominp daterange-singledate-from" placeholder="From" />
								</p>
							</div>
							<div class="limit-box">
								<p>
									<span>To : &nbsp;&nbsp;</span>
									<input type="text" name="to" id="toDate" onload="clearThis(this.value)" class="custominp daterange-singledate-to" placeholder="To" />
									<input type="submit" value="Search By Date" onclick="searchFilter()" style="height: 32px;" />
								</p>
							</div>
							<div class="limit-box" style="margin-left: 10px;">
								<p>
									<?php 
										$months = array(
															'01' => 'January',
															'02' => 'February',
															'03' => 'March',
															'04' => 'April',
															'05' => 'May',
															'06' => 'June',
															'07' => 'July',
															'08' => 'August',
															'09' => 'September',
															'10' => 'October',
															'11' => 'November',
															'12' => 'December',
														);
									?>
									<select name="month" id="month" onchange="searchFilter()">
										<option value="" selected="selected">All</option>
										<?php 
											foreach($months as $key => $month):
										?>
												<option value="<?php echo $key; ?>"><?php echo $month; ?></option>
										<?php
											endforeach;
										?>
									</select>
								</p>
							</div>
							<div class="limit-box" style="margin-left: 10px;">
								<p>
									<?php 
										$starting_date = 2019;
										$current_year = date("Y");
									?>
									<select name="year" id="year" onchange="searchFilter()">
										<option value="" selected="selected">All</option>
										<?php 
											for($i=$starting_date; $i < $current_year + 2;$i++):
										?>
												<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php
											endfor;
										?>
									</select>
								</p>
							</div>
							<div class="search-box">
								<p><input type="text" id="keywords" placeholder="Search..." onkeyup="searchFilter()"/></p>
							</div>
						</div>
						<div id="postList">
							<table class="table table-td-valign-middle m-b-0">
								<thead>
									<tr>
										<th>Discuss ID</th>
										<th>By (Student)</th>
										<th>To (Faculty)</th>
										<th class="text-center">Date</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(count($get_items) !== 0):
										foreach($get_items as $item):
									?>
									<tr class="items-row-<?php echo $item['discuss_id']; ?>">
										<td><?php echo $item['discuss_slentry_number']; ?></td>
										<td><?php echo $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'].'<strong style="color:#0a0">('.$item['student_entryid'].')</strong>'; ?></td>
										<td><?php echo $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name'].'<strong style="color:#0a0">('.$item['teacher_entryid'].')</strong>'; ?></td>
										<td class="text-center"><?php echo date("d M, Y", strtotime($item['discuss_created_date'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['discuss_created_date'])); ?></td>
										<td class="text-center item-row-status-<?php echo $item['discuss_id']; ?>">
											<?php if($item['discuss_has_deleted'] === 'NO'): ?>
											<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Active</span>
											<?php else: ?>
											<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Deleted</span>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<button data-target="#modal-without-animation" data-toggle="modal" data-id="<?php echo $item['discuss_id']; ?>" data-discuss-no="<?php echo $item['discuss_slentry_number']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
											<button data-id="<?php echo $item['discuss_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
										</td>
									</tr>
									<?php endforeach; ?>
									<?php else: ?>
									<tr>
										<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
							<div class="page-contr">
								<?php echo $this->ajax_pagination->create_links(); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- end widget -->
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
		
		<div class="modal payment-details-modal" id="modal-without-animation">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="discussTitle">Discuss ID : <span id="discussId"></span></h4>
					</div>
					<div class="modal-body" id="chatContents">
						<div class="h-100 dlp-discussion">
							<div class="row justify-content-center h-100">
								<div class="col-lg-12">
									<div class="card">
										<div class="card-body msg_card_body" id="chtBodyContainer">
											<div id="chatBodyContent">
											
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- begin #footer -->
		<?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
		<!-- end #footer -->
	</div>
	<!-- end #content -->
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.row-action-view', function(){
				var discuss_id = $(this).attr('data-id');
				var discuss_number = $(this).attr('data-discuss-no');
				$('#discussId').html('#'+discuss_number);
				$.ajax({
					type: 'POST',
					url: baseUrl+'coordinator/discussion/get_discussion_with_faculties_replyes',
					data:{discuss_id:discuss_id, _jwar_t_kn_:sqtoken_hash},
					dataType: 'json',
					success: function(data)
					{
						if(data.status == 'ok')
						{
							$('#chatBodyContent').html(data.content);
							sqtoken_hash = data._jwar_t_kn_;
							return false;
						}else
						{
							return false;
						}
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var limit = $('#limit').val();
			var fromDate = $('#fromDate').val();
			var toDate = $('#toDate').val();
			var month = $('#month').val();
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>discussapi/get_discussions_with_faculties/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&limit='+limit+'&from_date='+fromDate+'&to_date='+toDate+'&month='+month+'&year='+year+'&_jwar_t_kn_='+sqtoken_hash,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						sqtoken_hash = data._jwar_t_kn_;
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>