<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {
	
	public function get_dlp_organograms()
	{
		$query = $this->db->query("SELECT * FROM starter_organogram WHERE owner_activate='1' AND owner_show_at_landing='1'");
		return $query->result_array();
	}
	
}
