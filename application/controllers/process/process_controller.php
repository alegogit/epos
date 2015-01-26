<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('Process_model','process',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->process->get_profile();
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'process';         
			$session_data = $this->session->userdata('logged_in'); 
      $data['varP'] = $this->input->post('varP'); 
      $data['funP'] = $this->input->post('funP'); 
      $this->load->view('shared/process',$data);
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
		redirect('home', 'refresh');
	}
	
}
