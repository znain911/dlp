<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Page_model');
	}
	
	public function dlp()
	{
		$this->load->view('about');
	}
	
}
