<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordersdata_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('extracts/ordersdata_model','extracts',TRUE);  
    $this->load->helper(array('form', 'url','html')); 
    $this->load->library('excel');
    $session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->extracts->get_profile();
		$this->data['restaurants'] = $this->extracts->get_restaurant();  
    $this->load->library('picture');       
    @$this->data['reslogo'] = ($this->extracts->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->extracts->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
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
      $data['rest_name'] = $this->extracts->get_restaurant_name($rest_id);       
			$data['orders_data'] = $this->extracts->get_orders_data(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			
			if(!($this->input->get('p'))){
			   $this->load->view('shared/header',$this->data);
			   $this->load->view('shared/left_menu', $data);
			   $this->load->view('extracts/ordersdata',$data);
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
	
	public function xls()
	{
		$this->load->view('extracts/xls', $data);
	}
	
	public function logOn()
	{
		$this->load->view('login');
	}
	
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		//session_destroy();
		redirect('dashboard', 'refresh');
	}
	
}
