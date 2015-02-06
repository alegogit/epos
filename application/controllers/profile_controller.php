<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('profile_model','profile',TRUE);  
    	$this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');  
		$this->data['menu'] = 'profile';      
		$this->data['user'] = $this->profile->get_profile();
		$this->data['restaurants'] = $this->profile->get_restaurant(); 
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'profile';         
			$session_data = $this->session->userdata('logged_in');
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_start_date'] = date('d M Y', time() - 30 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date; 
      
		    if($this->input->post('spro')){         
				if($this->input->post('name')){$this->profile->update_name($this->input->post('name'));}       
				if($this->input->post('email')){$this->profile->update_email($this->input->post('email'));}     
				if($this->input->post('user')){$this->profile->update_username($this->input->post('user'));}   
				if($this->input->post('rest_id')){$this->profile->update_def_rest($this->input->post('rest_id'));}       
				if($this->input->post('photo')){$this->profile->update_photo($this->input->post('photo'));}
				if($this->input->post('pass2')&&($this->input->post('pass2')==$this->input->post('pass1'))){$this->profile->update_pass($this->input->post('pass2'));}
		    } 	
			   
		  	$data['profile'] = $this->profile->get_rest_profile($rest_id);
		  	$data['default'] = $this->profile->get_default_rest();	                
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('profile',$data);
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
	
	public function profile()
	{
		$data['profile'] = $this->profile->get_profile();
		
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
		redirect('dashboard', 'refresh');
	}
		
	public function notif()
	{
		$this->load->view('shared/header');
		$this->load->view('shared/left_menu', $data);
		$this->load->view('contents/notifications');
		$this->load->view('shared/footer');
	}
	
}
