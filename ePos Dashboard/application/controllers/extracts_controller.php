<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Extracts_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('extracts_model','extracts',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->extracts->get_profile();
		$this->data['restaurants'] = $this->extracts->get_restaurant(); 
			//echo "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>";
			//echo "<pre>" . var_dump($this->data['restaurants']) . "</pre>";
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'extracts';         
			$session_data = $this->session->userdata('logged_in');
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_data_name'] = 'Orders';
			$data['def_start_date'] = date('d M Y', time() - 7 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());     
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id');
			$data_name = (!($this->input->post('data_name')))?$data['def_data_name']:$this->input->post('data_name'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['data_name'] = $data_name;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;        
			$data['orders_data'] = $this->extracts->get_orders_data(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			//$data['void_items'] = $this->extracts->get_void_items(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			//$data['inventory'] = $this->extracts->get_inventory(); 
			
			if(!($this->input->get('p'))){
			   $this->load->view('shared/header',$this->data);
			   $this->load->view('shared/left_menu', $data);
			   $this->load->view('contents/extracts',$data);
			   //(!($this->input->get('p')))?$this->load->view('contents/extracts',$data):$this->load->view('extracts/'.$this->input->get('p'),$data);
			   $this->load->view('shared/footer');
			} else {
         $this->load->view('extracts/'.$this->input->get('p'),$data);
			}
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
