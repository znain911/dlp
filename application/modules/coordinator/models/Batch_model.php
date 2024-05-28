<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_batch ORDER BY batch_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_batch', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('batch_id', $id);
		$this->db->update('starter_batch', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_batch WHERE batch_id='$id' LIMIT 1");
		return $query->row_array();
	}

	public function get_teacher_batch($id) { /*get teacher list*/
        $this -> db -> select('t1.*, t2.tpinfo_first_name,t2.tpinfo_middle_name,t2.tpinfo_last_name');
        $this -> db -> join('starter_teachers_personalinfo t2','t2.tpinfo_teacher_id=t1.teacher_id', 'left');
		$this -> db -> from('starter_batch_teacher t1');
		$this -> db -> where('t1.batch_id', $id);
		$query = $this->db->get();
		return $query->result();
    } // End of function
    public function get_teacher_add() { /*get teacher list*/
        $this->db->select('t1.*, t2.tpinfo_first_name,t2.tpinfo_middle_name,t2.tpinfo_last_name');
        $this->db->join('starter_teachers_personalinfo t2','t2.tpinfo_teacher_id=t1.teacher_id', 'left');
		$this->db->from('starter_teachers t1');
		$this -> db -> where('teacher_status', 1);
		$query = $this->db->get();
		return $query->result();
    } // End of function

    public function get_batch_info($id) { /*get teacher list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('batch_id', $id);
		$query = $this->db->get();
		return $query->first_row();
    } // End of function

    public function create_batch($data)
	{
		$this->db->insert('starter_batch_teacher', $data);
	}
	public function update_batch($id, $data)
	{
		$this->db->where('bt_id', $id);
		$this->db->update('starter_batch_teacher', $data);
	}

	 public function get_batch_info_tchr($id) { /*get teacher list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_batch_teacher');
		$this -> db -> where('bt_id', $id);
		$query = $this->db->get();
		return $query->first_row();
    } // End of function
	public function get_info_batch($id)
	{
		$query = $this->db->query("SELECT * FROM starter_batch WHERE batch_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	function check_teacher($id,$batch){
		$this->db->trans_start();
		$this -> db -> select('teacher_id');
		$this -> db -> from('starter_batch_teacher');
		$this -> db -> where('teacher_id',$id);
		$this -> db -> where('teacher_batch',$batch);
	
		$query = $this->db->get();	
		$this->db->trans_complete();			
		if ($query->num_rows() > 0) {
			$row = $query->row();
        	return $row->teacher_id;
		}
		return 0;
	
	}// End function
	
	public function get_students($id) { /*get student list*/
        $this->db->select('t1.*, t2.spinfo_first_name,t2.spinfo_middle_name,t2.spinfo_last_name');
        $this->db->join('starter_students_personalinfo t2','t2.spinfo_student_id=t1.student_id', 'left');
		$this->db->from('starter_students t1');
		$this -> db -> where('student_rtc', $id);
		$query = $this->db->get();
		return $query->result();
    } // End of function
	
	public function get_batchforrtc() { /*get batch list*/
        $this -> db -> select('*');
		$this -> db -> from('ccd_batch');
		$this -> db -> order_by('btc_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
    } // End of function
	
}
