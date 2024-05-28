<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/setup/zoomcarryon/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">Title</th>
						<th class="text-center">RTC</th>
						<th class="text-center">Button Name</th>
						<th class="text-center">Link</th>
						<th class="text-center">Date</th>
						<th class="text-center">Time</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Zoom_model->get_all_items_carryon();
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['id']; ?>">
						<td class="text-center"><?php echo $item['zoom_title']; ?></td>
						<td class="text-center"><?php echo $item['batch_name'].' - Batch '.$item['batch']; ?></td>
						<td class="text-center"><?php echo $item['button_title']; ?></td>
						<td class="text-center"><?php echo $item['zoom_link']; ?></td>
						<td class="text-center">
							<?php
								/*$time = strtotime($item['date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;*/
								echo $item['zoom_date'];
							?>
						</td>
						<td class="text-center"><?php echo $item['zoom_time']; ?></td>
						<td class="text-center">
							<?php if($item['status'] === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Published</span>
							<?php else: ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Unpublished</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<button data-id="<?php echo $item['id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->