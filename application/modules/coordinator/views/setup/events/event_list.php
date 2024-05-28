<table id="data-table" class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th class="text-center">Events Name</th>
						<th class="text-center">Type</th>
						<th class="text-center">Details</th>
						<th class="text-center">Date</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Event_model->get_all_items();
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['id']; ?>">
						<td class="text-center"><?php echo $item['title']; ?></td>
						<td class="text-center"><?php echo $item['type']; ?></td>
						<td class="text-center"><?php echo $item['details']; ?></td>
						<td class="text-center">
							<?php
								/*$time = strtotime($item['date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;*/
								echo $item['date'];
							?>
						</td>
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