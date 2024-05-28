<?php
defined('BASEPATH') OR EXIT('no access allowed');

class Sessionfilter extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->library('ajax_pagination');
		$this->load->model('Sessions_model');
		$this->perPage = 15;
	}
	
	public function get_sdt_sessions(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$sdt_type = $this->input->post('sdt_type');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($from_date){
            $conditions['search']['from_date'] = $from_date;
        }
		if($to_date){
            $conditions['search']['to_date'] = $to_date;
        }
		if($month){
            $conditions['search']['month'] = $month;
        }
		if($year){
            $conditions['search']['year'] = $year;
        }
		if($sdt_type){
            $conditions['search']['sdt_type'] = $sdt_type;
        }
        
        //total rows count
        $totalRec = $this->Sessions_model->count_total_sdt_sessions($conditions);
        if($limit)
		{
			$per_page = $limit;
		}else
		{
			$per_page = $this->perPage;
		}
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'sessionfilter/get_sdt_sessions';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		if($limit)
		{
			$conditions['limit'] = $limit;
		}else
		{
			$conditions['limit'] = $this->perPage;
		}
        
        //get posts data
        $data['get_items'] = $this->Sessions_model->get_total_sdt_sessions($conditions);
        $data['sl_no'] = $page + 1;
        //load the view
        $content = $this->load->view('sdt', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_workshop_sessions(){
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortby = $this->input->post('sortby');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($from_date){
            $conditions['search']['from_date'] = $from_date;
        }
		if($to_date){
            $conditions['search']['to_date'] = $to_date;
        }
		if($month){
            $conditions['search']['month'] = $month;
        }
		if($year){
            $conditions['search']['year'] = $year;
        }
        
        //total rows count
        $totalRec = $this->Sessions_model->count_total_workshop_sessions($conditions);
        if($limit)
		{
			$per_page = $limit;
		}else
		{
			$per_page = $this->perPage;
		}
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'sessionfilter/get_workshop_sessions';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		if($limit)
		{
			$conditions['limit'] = $limit;
		}else
		{
			$conditions['limit'] = $this->perPage;
		}
        
        //get posts data
        $data['get_items'] = $this->Sessions_model->get_total_workshop_sessions($conditions);
		$data['sl_no'] = $page + 1;
        //load the view
        $content = $this->load->view('workshop', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
}