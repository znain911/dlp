<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zoom_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_zoom_link LEFT JOIN starter_batch ON starter_batch.batch_id=starter_zoom_link.zoom_rtl WHERE starter_zoom_link.class_type = 0 ORDER BY starter_zoom_link.id DESC");
		return $query->result_array();
	}

	public function get_all_items_carryon()
	{
		$query = $this->db->query("SELECT * FROM starter_zoom_link LEFT JOIN starter_batch ON starter_batch.batch_id=starter_zoom_link.zoom_rtl WHERE starter_zoom_link.class_type = 1 ORDER BY starter_zoom_link.id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_zoom_link', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('starter_zoom_link', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_zoom_link WHERE id='$id' LIMIT 1");
		return $query->row_array();
	}


    public function get_batch_info($id) { /*get teacher list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_zoom_link');
		$this -> db -> where('id', $id);
		$query = $this->db->get();
		return $query->first_row();
    } // End of function

	public function get_info_batch($id)
	{
		$query = $this->db->query("SELECT * FROM starter_zoom_link WHERE id='$id' LIMIT 1");
		return $query->row_array();
	}

	public function get_rtc() { /*get RTC list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('status', 1);
		$this -> db -> order_by('batch_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
    } // End of function

	public function get_carryonrtc() { /*get RTC list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_batch');
		$this -> db -> where('status', 1);
		$this -> db -> where('carryon', 1);
		$this -> db -> order_by('batch_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
    } // End of function
	
}
