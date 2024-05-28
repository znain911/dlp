<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_events ORDER BY id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_events', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('starter_events', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_events WHERE id='$id' LIMIT 1");
		return $query->row_array();
	}


    public function get_batch_info($id) { /*get teacher list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_events');
		$this -> db -> where('id', $id);
		$query = $this->db->get();
		return $query->first_row();
    } // End of function

	public function get_info_batch($id)
	{
		$query = $this->db->query("SELECT * FROM starter_events WHERE id='$id' LIMIT 1");
		return $query->row_array();
	}

	
	
}
