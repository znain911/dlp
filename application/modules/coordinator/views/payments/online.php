<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Payments</a></li>
				<li><a href="javascript:;">Online</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<?php 
				$total_online_transaction = $this->Payments_model->total_online_transaction();
				$total_transaction_amount = $this->Payments_model->total_transaction_amount();
			?>
			<h1 class="page-header online-transaction-h-txt"><span class="h-left-txt">Online Transaction Details : <span id="totalOnlineTransaction"><?php echo $total_online_transaction; ?></span></span> <span class="h-left-txt">Total Online Transactions : Tk. <span id="totalOnlineTransactionAmount"><?php echo $total_transaction_amount; ?></span></span></h1>

			<!-- <a href="<?php echo base_url('coordinator/payments/online_csv');?>" class="btn btn-info pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</a> -->
			<a href="javascript:void(0)" class="btn btn-info pull-right exportbybatch" id="exportbybatch"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a>
			<!-- end page-header -->
			
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
								<div class="limit-box">
									<p>
										<span>Batch : &nbsp;&nbsp;</span>
										<select name="batch" id="batch" onchange="searchFilter()">
											<option value="0" selected="selected">All Batch</option>
											<?php 
												foreach($get_betch as $key => $batch):
											?>
													<option value="<?php echo $batch->btc_name; ?>"><?php echo $batch->btc_name; ?></option>
											<?php
												endforeach;
											?>
										</select>
									</p>
								</div>
								<div class="limit-box">
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
											<th nowrap>SL.</th>
											<th nowrap>Student ID</th>
											<th nowrap>Name</th>
											<th nowrap>Payment</th>
											<th nowrap>Amount</th>
											<th nowrap>Transaction ID</th>
											<th nowrap>Transaction Date</th>
											<th nowrap>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											if(count($get_items) !== 0):
											$inc_sl = 1;
											foreach($get_items as $payment):
											$name = $this->Payments_model->student_name($payment['onpay_student_entryid']);
										?>
										<tr>
											<td><?php echo $inc_sl; ?></td>
											<td><?php echo $payment['onpay_student_entryid']; ?></td>
											<td><?php echo $name; ?></td>
											<td><?php echo $payment['onpay_account']; ?></td>
											<td><?php echo 'BDT '.$payment['onpay_transaction_amount']; ?></td>
											<td><?php echo $payment['onpay_transaction_id']; ?></td>
											<td class="text-center">
												<?php
													$time = strtotime($payment['onpay_transaction_date']);
													$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
													echo $myFormatForView;
												?>
											</td>
											<td class="text-center"><strong style="color:#0a0">Paid</strong></td>
										</tr>
										<?php 
											$inc_sl++;
											endforeach; 
											else:
										?>
										<tr>
											<td colspan="8"><span class="not-data-found">No Data Found!</span></td>
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
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.exportbybatch', function(){
					var bid = $('#batch').val();
					window.location.href = baseUrl+'coordinator/payments/online_detail_csvbatch/'+bid;					
				});
			});

			function searchFilter(page_num) {
				page_num = page_num?page_num:0;
				var keywords = $('#keywords').val();
				var limit = $('#limit').val();
				var fromDate = $('#fromDate').val();
				var toDate = $('#toDate').val();
				var month = $('#month').val();
				var year = $('#year').val();
				var batch = $('#batch').val();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>paymentapi/online/'+page_num,
					data:'page='+page_num+'&keywords='+keywords+'&limit='+limit+'&from_date='+fromDate+'&to_date='+toDate+'&month='+month+'&year='+year+'&batch='+batch+'&_jwar_t_kn_='+sqtoken_hash,
					dataType:'json',
					beforeSend: function () {
						
					},
					success: function (data) {
						if(data.status == 'ok')
						{
							$('#postList').html(data.content);
							$('#totalOnlineTransaction').html(data.total_rows);
							$('#totalOnlineTransactionAmount').html(data.total_amount);
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