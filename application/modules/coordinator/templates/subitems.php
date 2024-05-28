<?php 
	$item = $this->uri->segment(2);
	$item3 = $this->uri->segment(3);
?>
<div class="sub-menu-itm-mostak sb-item-1" <?php echo ($item === 'faculties')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_activate('faculties', 'pending'); ?>">
				<a href="<?php echo base_url('coordinator/faculties/pending'); ?>">
					<i class="fa fa-folder"></i>
					<span>Pending Faculties</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('faculties', 'enrolled'); ?>">
				<a href="<?php echo base_url('coordinator/faculties/enrolled'); ?>">
					<i class="fa fa-folder"></i>
					<span>Enrolled Faculties</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-2" <?php echo ($item === 'students')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_activate('students', 'pending'); ?>">
				<a href="<?php echo base_url('coordinator/students/pending'); ?>">
					<i class="fa fa-folder"></i>
					<span>Pending Students</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('students', 'approved_list'); ?>">
				<a href="<?php echo base_url('coordinator/students/approved_list'); ?>">
					<i class="fa fa-folder"></i>
					<span>Approved Students</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('students', 'placement_list'); ?>">
				<a href="<?php echo base_url('coordinator/students/placement_list'); ?>">
					<i class="fa fa-folder"></i>
					<span>Placement Students</span> 
				</a>
			</li>
			<!-- <li class="<?php echo submenu_item_activate('students', 'enrolled'); ?>">
				<a href="<?php echo base_url('coordinator/students/enrolled'); ?>">
					<i class="fa fa-folder"></i>
					<span>Enrolled Students</span> 
				</a>
			</li> -->
			<li class="<?php echo submenu_item_activate('students', 'enrolled_batch'); ?>">
				<a href="<?php echo base_url('coordinator/students/enrolled_batch'); ?>">
					<i class="fa fa-folder"></i>
					<span>Enrolled Students</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('students', 'declinepayments_list'); ?>">
				<a href="<?php echo base_url('coordinator/students/declinepayments_list'); ?>">
					<i class="fa fa-folder"></i>
					<span>Declined Students(Payment)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('students', 'rejectlist'); ?>">
				<a href="<?php echo base_url('coordinator/students/rejectlist'); ?>">
					<i class="fa fa-folder"></i>
					<span>Rejected Students</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('students', 'pchanged'); ?>">
				<a href="<?php echo base_url('coordinator/students/pchanged'); ?>" style="postion:relative">
					<i class="fa fa-folder"></i>
					<span>Changed Phone Number</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('students', 'rtcchange_list'); ?>">
				<a href="<?php echo base_url('coordinator/students/rtcchange_list'); ?>">
					<i class="fa fa-folder"></i>
					<span>RTC Change Request</span> 
				</a>
			</li>
			<li class="pass_email_page">
				<a href="<?php echo base_url('coordinator/students/update_pass_and_gmail'); ?>">
					<i class="fa fa-folder"></i>
					<span>Update Password and Gmail</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-3" <?php echo ($item === 'course')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_queryactivate('course', 'phase', 'step', 'A'); ?>">
				<a href="<?php echo base_url('coordinator/course/phase?step=A&module=1-3'); ?>">
					<i class="fa fa-folder"></i>
					<span>Phase A (Books/Modules)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('course', 'phase', 'step', 'B'); ?>">
				<a href="<?php echo base_url('coordinator/course/phase?step=B&module=4-7'); ?>">
					<i class="fa fa-folder"></i>
					<span>Phase B (Books/Modules)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('course', 'phase', 'step', 'C'); ?>">
				<a href="<?php echo base_url('coordinator/course/phase?step=C&module=8-10'); ?>">
					<i class="fa fa-folder"></i>
					<span>Phase C (Books/Modules)</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-4" <?php echo ($item === 'payments')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_activate('payments', 'online'); ?>">
				<a href="<?php echo base_url('coordinator/payments/online'); ?>">
					<i class="fa fa-folder"></i>
					<span>Online Payments</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('payments', 'deposit'); ?>">
				<a href="<?php echo base_url('coordinator/payments/deposit'); ?>">
					<i class="fa fa-folder"></i>
					<span>Bank Deposit</span> 
				</a>
			</li>
			<!--
			<li class="<?php echo submenu_item_activate('payments', 'transaction'); ?>">
				<a href="<?php echo base_url('coordinator/payments/transaction'); ?>">
					<i class="fa fa-folder"></i>
					<span>SSL Commerz Transaction</span> 
				</a>
			</li>
			-->
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-5" <?php echo ($item === 'discussion')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_activate('discussion', 'withfaculty'); ?>">
				<a href="<?php echo base_url('coordinator/discussion/withfaculty'); ?>">
					<i class="fa fa-folder"></i>
					<span>Students To Faculties</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('discussion', 'withstudent'); ?>">
				<a href="<?php echo base_url('coordinator/discussion/withstudent'); ?>">
					<i class="fa fa-folder"></i>
					<span>Faculties To Students</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-6" <?php echo ($item === 'questions')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_activate('questions', 'module'); ?>">
				<a href="<?php echo base_url('coordinator/questions/module'); ?>">
					<i class="fa fa-folder"></i>
					<span>End-Of-Lesson Exam Questions</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('questions', 'pca'); ?>">
				<a href="<?php echo base_url('coordinator/questions/pca'); ?>">
					<i class="fa fa-folder"></i>
					<span>PCA Exam Questions</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-7" <?php echo ($item === 'schedules')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<!--
			<li class="<?php echo submenu_item_activate('schedules', 'moduleexam'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/moduleexam'); ?>">
					<i class="fa fa-folder"></i>
					<span>End-Module Exam Schedules</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('schedules', 'ftwofsession'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/ftwofsession'); ?>">
					<i class="fa fa-folder"></i>
					<span>F2F Session Schedules</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('schedules', 'phaseexam'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/phaseexam'); ?>">
					<i class="fa fa-folder"></i>
					<span>Phase Exam Schedules</span> 
				</a>
			</li>
			-->
			<li class="<?php echo submenu_item_queryactivate('schedules', 'sdt', 'type', '1'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/sdt?type=1'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 1 Schedules</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('schedules', 'sdt', 'type', '2'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/sdt?type=2'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 2 Schedules</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('schedules', 'workshop'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/workshop'); ?>">
					<i class="fa fa-folder"></i>
					<span>Workshop Schedules</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('schedules', 'eceexam'); ?>">
				<a href="<?php echo base_url('coordinator/schedules/eceexam'); ?>">
					<i class="fa fa-folder"></i>
					<span>ECE Exam Schedules</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-8" <?php echo ($item === 'booking')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<!--
			<li class="<?php echo submenu_item_queryactivate('booking', 'ftwof', 'type', 'Faculties'); ?>">
				<a href="<?php echo base_url('coordinator/booking/ftwof?type=Faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>F2F Session (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('booking', 'ftwof', 'type', 'Students'); ?>">
				<a href="<?php echo base_url('coordinator/booking/ftwof?type=Students'); ?>">
					<i class="fa fa-folder"></i>
					<span>F2F Session (Students)</span> 
				</a>
			</li>
			-->
			<li class="<?php echo submenu_item_multiple_queryactivate('booking', 'sdt', 'type', 'Faculties', 'sdt', '1'); ?>">
				<a href="<?php echo base_url('coordinator/booking/sdt?type=Faculties&sdt=1'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 1 Applicants (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_multiple_queryactivate('booking', 'sdt', 'type', 'Students', 'sdt', '1'); ?>">
				<a href="<?php echo base_url('coordinator/booking/sdt?type=Students&sdt=1'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 1 Applicants (Students)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_multiple_queryactivate('booking', 'sdt', 'type', 'Faculties', 'sdt', '2'); ?>">
				<a href="<?php echo base_url('coordinator/booking/sdt?type=Faculties&sdt=2'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 2 Applicants (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_multiple_queryactivate('booking', 'sdt', 'type', 'Students', 'sdt', '2'); ?>">
				<a href="<?php echo base_url('coordinator/booking/sdt?type=Students&sdt=2'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 2 Applicants (Students)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('booking', 'workshop', 'type', 'Faculties'); ?>">
				<a href="<?php echo base_url('coordinator/booking/workshop?type=Faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>Workshop Applicants (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('booking', 'workshop', 'type', 'Students'); ?>">
				<a href="<?php echo base_url('coordinator/booking/workshop?type=Students'); ?>">
					<i class="fa fa-folder"></i>
					<span>Workshop Applicants (Students)</span> 
				</a>
			</li>
			<!--
			<li class="<?php echo submenu_item_queryactivate('booking', 'phaseexam', 'type', 'Faculties'); ?>">
				<a href="<?php echo base_url('coordinator/booking/phaseexam?type=Faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>Phase Exam Applicants (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('booking', 'phaseexam', 'type', 'Students'); ?>">
				<a href="<?php echo base_url('coordinator/booking/phaseexam?type=Students'); ?>">
					<i class="fa fa-folder"></i>
					<span>Phase Exam Applicants (Students)</span> 
				</a>
			</li>
			-->
			<li class="<?php echo submenu_item_queryactivate('booking', 'eceexam', 'type', 'Faculties'); ?>">
				<a href="<?php echo base_url('coordinator/booking/eceexam?type=Faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>ECE Exam Applicants (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('booking', 'eceexam', 'type', 'Students'); ?>">
				<a href="<?php echo base_url('coordinator/booking/eceexam?type=Students'); ?>">
					<i class="fa fa-folder"></i>
					<span>ECE Exam Applicants (Students)</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-16" <?php echo ($item === 'sessions')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_queryactivate('sessions', 'sdt', 'type', '1'); ?>">
				<a href="<?php echo base_url('coordinator/sessions/sdt?type=1'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 1 Sessions</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_queryactivate('sessions', 'sdt', 'type', '2'); ?>">
				<a href="<?php echo base_url('coordinator/sessions/sdt?type=2'); ?>">
					<i class="fa fa-folder"></i>
					<span>SDT 2 Sessions</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('sessions', 'workshop'); ?>">
				<a href="<?php echo base_url('coordinator/sessions/workshop'); ?>">
					<i class="fa fa-folder"></i>
					<span>Workshop Sessions</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('sessions', 'export'); ?>">
				<a href="<?php echo base_url('coordinator/sessions/export'); ?>">
					<i class="fa fa-folder"></i>
					<span>Export Session Report</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-9" <?php echo ($item === 'results')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<!--
			<li class="<?php echo submenu_item_activate('results', 'module'); ?>">
				<a href="<?php echo base_url('coordinator/results/module'); ?>">
					<i class="fa fa-folder"></i>
					<span>End-Module Exam Results</span> 
				</a>
			</li>
			-->
			<li class="<?php echo submenu_item_activate('results', ''); ?>">
				<a href="<?php echo base_url('coordinator/results'); ?>">
					<i class="fa fa-folder"></i>
					<span>View Results</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('results', 'sdt'); ?>">
				<a href="<?php echo base_url('coordinator/results/sdt'); ?>">
					<i class="fa fa-folder"></i>
					<span>Upload SDT Results</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('results', 'workshop'); ?>">
				<a href="<?php echo base_url('coordinator/results/workshop'); ?>">
					<i class="fa fa-folder"></i>
					<span>Upload Workshop Results</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('results', 'ece'); ?>">
				<a href="<?php echo base_url('coordinator/results/ece'); ?>">
					<i class="fa fa-folder"></i>
					<span>Upload ECE Results</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-10" <?php echo ($item === 'certificates')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo menu_item_activate('certificates'); ?>">
				<a href="<?php echo base_url('coordinator/certificates'); ?>">
					<i class="fa fa-folder"></i>
					<span>Manage Certificates</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-13" <?php echo ($item === 'contacts')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo menu_item_activate('contacts'); ?>">
				<a href="<?php echo base_url('coordinator/contacts'); ?>">
					<i class="fa fa-folder"></i>
					<span>View Website Contacts</span> 
				</a>
			</li>
			<li class="<?php echo menu_item_activate('contacts'); ?>">
				<a href="<?php echo base_url('coordinator/contacts/students'); ?>">
					<i class="fa fa-folder"></i>
					<span>View Student Contacts</span> 
				</a>
			</li>
			<li class="<?php echo menu_item_activate('contacts'); ?>">
				<a href="<?php echo base_url('coordinator/contacts/faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>View Faculty Contacts</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-14" <?php echo ($item === 'setup' || $item === 'page' || $item === 'faqs')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_item_activate('setup', 'coordinators'); ?>">
				<a href="<?php echo base_url('coordinator/setup/coordinators'); ?>">
					<i class="fa fa-folder"></i>
					<span>Coordinators</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'rtc'); ?>">
				<a href="<?php echo base_url('coordinator/setup/rtc'); ?>">
					<i class="fa fa-folder"></i>
					<span>RTC</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'roles'); ?>">
				<a href="<?php echo base_url('coordinator/setup/roles'); ?>">
					<i class="fa fa-folder"></i>
					<span>Roles</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'banks'); ?>">
				<a href="<?php echo base_url('coordinator/setup/banks'); ?>">
					<i class="fa fa-folder"></i>
					<span>Banks Details</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'specialization'); ?>">
				<a href="<?php echo base_url('coordinator/setup/specialization'); ?>">
					<i class="fa fa-folder"></i>
					<span>Specialization</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'categories'); ?>">
				<a href="<?php echo base_url('coordinator/setup/categories'); ?>">
					<i class="fa fa-folder"></i>
					<span>DLP Categories</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'centers'); ?>">
				<a href="<?php echo base_url('coordinator/setup/centers'); ?>">
					<i class="fa fa-folder"></i>
					<span>Center Lists</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'smsconfig'); ?>">
				<a href="<?php echo base_url('coordinator/setup/smsconfig'); ?>">
					<i class="fa fa-folder"></i>
					<span>SMS Configuration</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'paymentconfig'); ?>">
				<a href="<?php echo base_url('coordinator/setup/paymentconfig'); ?>">
					<i class="fa fa-folder"></i>
					<span>Payment Configuration</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'marksconfig'); ?>">
				<a href="<?php echo base_url('coordinator/setup/marksconfig'); ?>">
					<i class="fa fa-folder"></i>
					<span>Exam & Marks Distribution</span> 
				</a>
			</li>
			<li class="<?php echo submenu_singleitem_queryactivate('faqs', 'type', 'Website'); ?>">
				<a href="<?php echo base_url('coordinator/faqs?type=Website'); ?>">
					<i class="fa fa-folder"></i>
					<span>Website FAQs</span> 
				</a>
			</li>
			<li class="<?php echo submenu_singleitem_queryactivate('faqs', 'type', 'Students'); ?>">
				<a href="<?php echo base_url('coordinator/faqs?type=Students'); ?>">
					<i class="fa fa-folder"></i>
					<span>Students FAQs</span> 
				</a>
			</li>
			<li class="<?php echo submenu_singleitem_queryactivate('faqs', 'type', 'Faculties'); ?>">
				<a href="<?php echo base_url('coordinator/faqs?type=Faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>Faculties FAQs</span> 
				</a>
			</li>
			
			<li class="<?php echo menu_item_activate('page'); ?>">
				<a href="<?php echo base_url('coordinator/page'); ?>">
					<i class="fa fa-folder"></i>
					<span>Manage Web Pages</span> 
				</a>
			</li>
			
			<li class="<?php echo submenu_singleitem_queryactivate('setup', 'contactinfo'); ?>">
				<a href="<?php echo base_url('coordinator/setup/contactinfo'); ?>">
					<i class="fa fa-folder"></i>
					<span>Contact Information</span> 
				</a>
			</li>
			
			<li class="<?php echo submenu_singleitem_queryactivate('setup', 'type', 'students'); ?>">
				<a href="<?php echo base_url('coordinator/setup/evaluations?type=students'); ?>">
					<i class="fa fa-folder"></i>
					<span>Students Evaluations Settings</span> 
				</a>
			</li>
			
			<li class="<?php echo submenu_singleitem_queryactivate('setup', 'type', 'faculties'); ?>">
				<a href="<?php echo base_url('coordinator/setup/evaluations?type=faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>Faculties Evaluations Settings</span> 
				</a>
			</li>
			
			<li class="<?php echo submenu_item_activate('setup', 'optionals'); ?>">
				<a href="<?php echo base_url('coordinator/setup/optionals'); ?>">
					<i class="fa fa-folder"></i>
					<span>Options Panel</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'organograms'); ?>">
				<a href="<?php echo base_url('coordinator/setup/organograms'); ?>">
					<i class="fa fa-folder"></i>
					<span>Organogram Panel</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'events'); ?>">
				<a href="<?php echo base_url('coordinator/setup/events'); ?>">
					<i class="fa fa-folder"></i>
					<span>Events</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'imagesupload'); ?>">
				<a href="<?php echo base_url('coordinator/setup/imagesupload'); ?>">
					<i class="fa fa-folder"></i>
					<span>Images Upload</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'zoomlink'); ?>">
				<a href="<?php echo base_url('coordinator/setup/zoomlink'); ?>">
					<i class="fa fa-folder"></i>
					<span>Zoom Link</span> 
				</a>
			</li>
			<li class="<?php echo submenu_item_activate('setup', 'carryzoomlink'); ?>">
				<a href="<?php echo base_url('coordinator/setup/carryzoomlink'); ?>">
					<i class="fa fa-folder"></i>
					<span>Carry On Zoom Link</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>
<div class="sub-menu-itm-mostak sb-item-15" <?php echo ($item === 'evaluation')? null : 'style="display:none;"'; ?>>
	<div id="sidebar" class="sidebar">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo submenu_singleitem_queryactivate('evaluation', 'type', 'Faculties'); ?>">
				<a href="<?php echo base_url('coordinator/evaluation?type=Faculties'); ?>">
					<i class="fa fa-folder"></i>
					<span>Evaluations (Faculties)</span> 
				</a>
			</li>
			<li class="<?php echo submenu_singleitem_queryactivate('evaluation', 'type', 'Students'); ?>">
				<a href="<?php echo base_url('coordinator/evaluation?type=Students'); ?>">
					<i class="fa fa-folder"></i>
					<span>Evaluations (Students)</span> 
				</a>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
</div>