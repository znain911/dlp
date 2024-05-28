<?php 
	$get_sessions = $this->Perm_model->get_ece_schedules();
	
	//check booked
	$get_booked_schedules = $this->Booking_model->get_ece_already_booked_details();
	$get_schedules = array();
	foreach($get_booked_schedules as $booked){
		$get_schedules[] = $booked['booking_schedule_id'];
	}
	$check_array = array_unique($get_schedules);
	
	if(count($get_sessions) !== 0):
	foreach($get_sessions as $session):
	
	if(in_array($session['endmschedule_id'], $check_array))
	{
		continue;
	}
	
?>
<?php 
	$now_date = strtotime(date("Y-m-d"));
	$boking_to_date = strtotime($session['endmschedule_to_date']);
	$boking_from_date = strtotime($session['endmschedule_from_date']);
?>
<tr>
	<td><?php echo $session['endmschedule_title']; ?></td>
	<td class="text-center" style="font-size: 14px;"><strong>From</strong> &nbsp;&nbsp;<?php echo date("d M Y", strtotime($session['endmschedule_from_date'])); ?> &nbsp;&nbsp;<strong>To</strong>&nbsp;&nbsp; <?php echo date("d M Y", strtotime($session['endmschedule_to_date'])); ?></td>
	<td class="text-center">
		<?php if($now_date < $boking_from_date): ?>
		<span class="sch_available">Available</span>
		<?php else: ?>
		<span class="sch_unavailable" style="background:#A00">Unavailable</span>
		<?php endif; ?>
	</td>
	<td class="text-center">
		<?php if($now_date < $boking_from_date): ?>
		<button data-schedule="<?php echo $session['endmschedule_id']; ?>" class="session-row btn btn-raised btn-xs btn-info" style="margin:0;">Booking Now</button>
		<?php else: ?>
		<button class="btn btn-raised btn-xs btn-primary" style="margin:0;">Booking Now</button>
		<?php endif; ?>
	</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
	<td class="text-center" colspan="5">Schedules are not available!</td>
</tr>
<?php endif; ?>