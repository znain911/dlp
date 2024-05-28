<?php
defined('BASEPATH') OR EXIT('no access allowed');

class Studentfilter extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->library('ajax_pagination');
		$this->load->model('Students_model');
		$this->perPage = 15;
	}
	
	public function get_pending_student(){
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
		$batch = $this->input->post('batch');
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
		if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = count($this->Students_model->get_pending_students($conditions));
        if($limit)
		{
			$per_page = $limit;
		}else
		{
			$per_page = $this->perPage;
		}
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
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
        $data['get_items'] = $this->Students_model->get_pending_students($conditions);
        //load the view
        $content = $this->load->view('pending_students', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_approved_student(){
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
		$batch = $this->input->post('batch');
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
		if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = count($this->Students_model->get_approved_students($conditions));
        if($limit)
        {
            $per_page = $limit;
        }else
        {
            $per_page = $this->perPage;
        }
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_approved_student';
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
        $data['get_items'] = $this->Students_model->get_approved_students($conditions);
        //load the view
        $content = $this->load->view('approve_filter', $data, true);
        $result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
        $result[$this->sqtoken] = $this->sqtoken_hash;
        echo json_encode($result);
        exit;
    }

    public function get_placement_student(){
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
		$batch = $this->input->post('batch');
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
		if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = count($this->Students_model->get_placement_students($conditions));
        if($limit)
        {
            $per_page = $limit;
        }else
        {
            $per_page = $this->perPage;
        }
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_placement_student';
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
        $data['get_items'] = $this->Students_model->get_placement_students($conditions);
        //load the view
        $content = $this->load->view('placement_filter', $data, true);
        $result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
        $result[$this->sqtoken] = $this->sqtoken_hash;
        echo json_encode($result);
        exit;
    }

    public function get_paymentdeclined_student(){
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
        $totalRec = count($this->Students_model->get_paymentdeclined_students($conditions));
        if($limit)
        {
            $per_page = $limit;
        }else
        {
            $per_page = $this->perPage;
        }
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_paymentdeclined_student';
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
        $data['get_items'] = $this->Students_model->get_paymentdeclined_students($conditions);
        //load the view
        $content = $this->load->view('paymentdeclined_filter', $data, true);
        $result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
        $result[$this->sqtoken] = $this->sqtoken_hash;
        echo json_encode($result);
        exit;
    }
	
	public function get_reject_student(){
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
        $totalRec = count($this->Students_model->get_reject_students($conditions));
        if($limit)
        {
            $per_page = $limit;
        }else
        {
            $per_page = $this->perPage;
        }
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_reject_student';
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
        $data['get_items'] = $this->Students_model->get_reject_students($conditions);
        //load the view
        $content = $this->load->view('reject_filter', $data, true);
        $result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
        $result[$this->sqtoken] = $this->sqtoken_hash;
        echo json_encode($result);
        exit;
    }

	
	public function get_changed_phone_numbers(){
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
		$batch = $this->input->post('batch');
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
		if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = count($this->Students_model->get_changed_phone_numbers($conditions));
        if($limit)
		{
			$per_page = $limit;
		}else
		{
			$per_page = $this->perPage;
		}
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_changed_phone_numbers';
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
        $data['get_items'] = $this->Students_model->get_changed_phone_numbers($conditions);
        //load the view
        $content = $this->load->view('changed_phone_numbers', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_wantdelete_student(){
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
        $batch = $this->input->post('batch');
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
        if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = count($this->Students_model->get_wantdelete_students($conditions));
        if($limit)
        {
            $per_page = $limit;
        }else
        {
            $per_page = $this->perPage;
        }
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_wantdelete_student';
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
        $data['get_items'] = $this->Students_model->get_wantdelete_students($conditions);
        //load the view
        $content = $this->load->view('delete_lst', $data, true);
        $result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec);
        $result[$this->sqtoken] = $this->sqtoken_hash;
        echo json_encode($result);
        exit;
    }
	
}