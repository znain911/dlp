<?php require_once APPPATH.'modules/common/header.php'; ?>
<style type="text/css">

.calendar-contain {
  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
  font-family: -apple-system, BlinkMacSystemFont, system-ui, "Segoe UI", Roboto, Oxygen, Ubuntu, "Helvetica Neue", sans-serif;
  position: relative;
  left: 0;
  right: 0;
  border-radius: 0;
  width: 100%;
  overflow: hidden;
  max-width: 1020px;
  min-width: 450px;
  margin: 1rem auto;
  background-color: #f5f7f6;
  box-shadow: 5px 5px 72px rgba(30, 46, 50, 0.5);
  color: #040605;
}
@media screen and (min-width: 55em) {
  .calendar-contain {
    margin: auto;
    top: 5%;
  }
}

.title-bar {
  position: relative;
  width: 100%;
  display: table;
  text-align: right;
  background: #f5f7f6;
  padding: 0.5rem;
  margin-bottom: 0;
}
.title-bar:after {
  display: table;
  clear: both;
}

.title-bar__prev{
  position: relative;
  float: left;
  text-align: left;
  cursor: pointer;
  width: 22px;
  height: 30px;
}
.title-bar__prev:after {
    content: "";
    display: inline;
    position: absolute;
    width: 14px;
    height: 14px;
    right: 0;
    left: 2px;
    top: 7px;
    margin: auto;
    border-top: 1.5px solid black;
    border-right: 1.5px solid black;
    -webkit-transform: rotate(224deg);
    transform: rotate(224deg);
}
.title-bar__next{
  position: relative;
  float: right;
  text-align: right;
  cursor: pointer;
  width: 22px;
  height: 30px;
}
.title-bar__next:after {
    content: "";
    display: inline;
    position: absolute;
    width: 14px;
    height: 14px;
    right: 2px;
    top: 7px;
    margin: auto;
    border-top: 1.5px solid black;
    border-right: 1.5px solid black;
    -webkit-transform: rotate(44deg);
    transform: rotate(44deg);
}
.title-bar__year {
  display: block;
  position: relative;
  float: left;
  font-size: 1rem;
  line-height: 30px;
  width: 45%;
  padding: 0 0.5rem;
  text-align: center;
}
.title-bar__year select{
  padding: 2px 6px;
  font-size: 16px;
}
@media screen and (min-width: 55em) {
  .title-bar__year {
    width: 45%;
  }
}

.title-bar__month {
  position: relative;
  float: left;
  font-size: 1rem;
  line-height: 30px;
  width: 45%;
  padding: 0 0.5rem;
  text-align: center;
}
.title-bar__month select{
  padding: 2px 6px;
  font-size: 16px;
}
@media screen and (min-width: 55em) {
  .title-bar__month {
    width: 45%;
  }
}

.calendar__sidebar {
  width: 100%;
  margin: 0 auto;
  float: none;
  background: linear-gradient(120deg, #eff3f3, #e1e7e8);
  padding-bottom: 0.7rem;
}
@media screen and (min-width: 55em) {
  .calendar__sidebar {
    position: relative;
    height: 100%;
    width: 100%;
    float: none;
    margin-bottom: 0;
  }
}

.calendar__sidebar .content {
  padding: 2rem 1.5rem 2rem 4rem;
  color: #040605;
}

.sidebar__list {
  list-style: none;
  margin: 0;
  padding-left: 1rem;
  padding-right: 1rem;
}

.sidebar__list-item {
  margin: 1.2rem 0;
  color: #2d4338;
  font-weight: 100;
  font-size: 1rem;
}

.list-item__time {
  display: inline-block;
  /*width: 60px;*/
}
@media screen and (min-width: 55em) {
  .list-item__time {
    margin-right: 1rem;
  }
}

.sidebar__list-item--complete {
  color: rgba(4, 6, 5, 0.3);
}
.sidebar__list-item--complete .list-item__time {
  color: rgba(4, 6, 5, 0.3);
}

.sidebar__heading {
  font-size: 2.2rem;
  font-weight: bold;
  padding-left: 1rem;
  padding-right: 1rem;
  margin-bottom: 3rem;
  margin-top: 1rem;
}
.sidebar__heading span {
  float: right;
  font-weight: 300;
}

.calendar__heading-highlight {
  color: #2d444a;
  font-weight: 900;
}

.calendar__days {
  display: -webkit-box;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
          flex-flow: column wrap;
  -webkit-box-align: stretch;
          align-items: stretch;
  width: 100%;
  float: none;
  min-height: 580px;
  height: 100%;
  font-size: 12px;
  padding: 0.8rem 0 1rem 1rem;
  background: #f5f7f6;
}
@media screen and (min-width: 55em) {
  .calendar__days {
    width: 100%;
    float: none;
  }
}

.calendar__top-bar {
  display: -webkit-box;
  display: flex;
  -webkit-box-flex: 32px;
          flex: 32px 0 0;
}

.top-bar__days {
  width: 100%;
  padding: 0 5px;
  color: #2d4338;
  font-weight: 100;
  -webkit-font-smoothing: subpixel-antialiased;
  font-size: 1rem;
}

.calendar__week {
  display: -webkit-box;
  display: flex;
  -webkit-box-flex: 1;
          flex: 0 1 0;
}

.calendar__day {
  display: -webkit-box;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
          flex-flow: column wrap;
  -webkit-box-pack: justify;
          justify-content: space-between;
  width: 100%;
  padding: 1.9rem 0.2rem 0.2rem;
  cursor: pointer;
}

.calendar__day.event .calendar__date, .calendar__day.event .calendar__task{
  color: #4285f4;
}

.calendar__date {
  color: #040605;
  font-size: 1.7rem;
  font-weight: 600;
  line-height: 0.7;
}
@media screen and (min-width: 55em) {
  .calendar__date {
    font-size: 2.3rem;
  }
}

.calendar__week .inactive .calendar__date,
.calendar__week .inactive .task-count {
  color: #c6c6c6;
}
.calendar__week .today .calendar__date {
  color: #fd588a;
}

.calendar__task {
  color: #040605;
  display: -webkit-box;
  display: flex;
  font-size: 0.8rem;
}
@media screen and (min-width: 55em) {
  .calendar__task {
    font-size: 1rem;
  }
}
.calendar__task.calendar__task--today {
  color: #fd588a;
}
</style>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-4">
				<div style="height: 50px; clear: both;"></div>
				<div id="calendar_div">
				    <?php echo $eventCalendar; ?>
				</div>
			</div>
			
		</div>
	</div>
<script>
function getCalendar(target_div, year, month){
    $.get( '<?php echo base_url('student/calendar/eventCalendar/'); ?>'+year+'/'+month, function( html ) {
        $('#'+target_div).html(html);
    });
}

function getEvents(date){
    $.get( '<?php echo base_url('student/calendar/getEvents/'); ?>'+date, function( html ) {
        $('#event_list').html(html);
    });
}

$(document).on('change', '.month-dropdown', function(){ 
	getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val());
});
$(document).on('change', '.year-dropdown', function(){ 
	getCalendar('calendar_div', $('.year-dropdown').val(), $('.month-dropdown').val());
});
</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>