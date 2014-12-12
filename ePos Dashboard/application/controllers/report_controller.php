<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('report_model','report',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->report->get_profile();
		$this->data['restaurants'] = $this->report->get_restaurant(); 
			//echo "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>";
			//echo "<pre>" . var_dump($this->data['restaurants']) . "</pre>";
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'report';         
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
			$data['sales_report'] = $this->report->get_sales_report(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			$data['void_items'] = $this->report->get_void_items(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			$data['inventory'] = $this->report->get_inventory(); 
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			(!($this->input->get('p')))?$this->load->view('contents/report',$data):$this->load->view('report/'.$this->input->get('p'),$data);
			$this->load->view('shared/footer');
			//$this->output->enable_profiler(TRUE);  
			//echo "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>";
			//echo $start_date.",".$end_date.",".$rest_id."<br>";
			//echo "<pre>" . var_dump($data['sales_report']) . "</pre>";
               //echo $this->input->get('rest_id');        
		    //print_r($query);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
	
	public function profile()
	{
		$data['profile'] = $this->report->get_profile();
		
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
