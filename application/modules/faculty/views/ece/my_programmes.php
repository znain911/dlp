<?php 
	$programmes = $this->Course_model->my_ece_programmes();
	foreach($programmes as $programme):
	
	if($programme['endmschedule_faculty_resource']){
		$resource_download_link = attachment_url('resources/ece/'.$programme['endmschedule_faculty_resource']);
	}else{
		$resource_download_link = 'javascript:void(0)';
	}
?>
<tr>
	<td class="text-center"><?php echo $programme['endmschedule_title']; ?></td>
	<td class="text-center"><?php echo $programme['center_location']; ?></td>
	<td class="text-center"><?php echo date("d F, Y", strtotime($programme['centerschdl_to_date'])).' '.$programme['centerschdl_to_time']; ?></td>
	<td class="text-center"><a target="_blank" style="background: pink;color: #333;font-size: 12px;display: inline-block;padding: 3px 5px;text-decoration: none;" href="<?php echo $resource_download_link; ?>">Download</a></td>
</tr>
<?php endforeach; ?>