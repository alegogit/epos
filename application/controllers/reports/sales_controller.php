<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('reports/sales_model','sales',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->sales->get_profile();
		$this->data['restaurants'] = $this->sales->get_restaurant(); 
    $this->load->library('picture');    
    @$this->data['reslogo'] = ($this->sales->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->sales->get_rest_logo();    
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'reports';         
			$session_data = $this->session->userdata('logged_in');
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_report_name'] = 'Sales';
			$data['def_start_date'] = date('d M Y', time() - 7 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());     
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id');
			$report_name = (!($this->input->post('report_name')))?$data['def_report_name']:$this->input->post('report_name'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['report_name'] = $report_name;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;
      $data['cur'] = $this->sales->get_currency($rest_id);
			$data['sales_report'] = $this->sales->get_sales_report(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			$data['void_items'] = $this->sales->get_void_items(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('reports/sales',$data);
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}

	public function view()
	{
			$data['def_rest'] = 2;
			$data['def_report_name'] = 'Sales';
			$data['def_start_date'] = date('d M Y', time() - 7 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());     
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id');
			$report_name = (!($this->input->get('report_name')))?$data['def_report_name']:$this->input->get('report_name'); 
			//$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$start_date = "01 Jan 2015";
      $end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['report_name'] = $report_name;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;
      $data['cur'] = $this->sales->get_currency($rest_id);
			$data['sales_report'] = $this->sales->get_sales_report(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			$data['void_items'] = $this->sales->get_void_items(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			
			$this->load->view('shared/notopbar_header',$this->data);
			$this->load->view('reports/salesview',$data);
			$this->load->view('shared/footer');		
	}
	
	public function profile()
	{
		$data['profile'] = $this->sales->get_profile();
		
		$this->load->view('shared/header',$this->data);
		$this->load->view('shared/left_menu');
		$this->load->view('contents/profile', $data);
		$this->load->view('shared/footer');
	}
	
	public function logOn()
	{
		$this->load->view('login');
	}
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		//session_destroy();
		redirect('home', 'refresh');
	}
		
	public function notif()
	{
		$this->load->view('shared/header');
		$this->load->view('shared/left_menu', $data);
		$this->load->view('contents/notifications');
		$this->load->view('shared/footer');
	}
	
}
