<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results_model extends CI_Model {
	
	public function get_module_results()
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_phases.phase_name
								   FROM starter_module_progress
								   LEFT JOIN starter_module_marks ON
								   starter_module_marks.mdlmark_cmreport_id=starter_module_progress.cmreport_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_module_progress.cmreport_student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_module_progress.cmreport_student_id
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_module_progress.cmreport_phase_id
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}
	
}
