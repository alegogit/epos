<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderdetails_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('process/orderdetails_model','process',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->process->get_profile();
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{        
			$session_data = $this->session->userdata('logged_in'); 
      $data['order_details'] = $this->process->get_order_details($this->input->post('varP'));
      $this->load->view('process/order_details',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
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
