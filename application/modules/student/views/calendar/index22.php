<!DOCTYPE html>
<html>
<head>
	<title>Calender</title>
	<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Display event calendar -->
<div id="calendar_div">
    <?php echo $eventCalendar; ?>
</div>
<script>
function getCalendar(target_div, year, month){
    $.get( '<?php echo base_url('calendar/eventCalendar/'); ?>'+year+'/'+month, function( html ) {
        $('#'+target_div).html(html);
    });
}

function getEvents(date){
    $.get( '<?php echo base_url('calendar/getEvents/'); ?>'+date, function( html ) {
        $('#event_list').html(html);
    });
}
</script>
</body>
</html>
