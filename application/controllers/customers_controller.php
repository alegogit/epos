<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('customers_model','customers',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');  
		$this->data['menu'] = 'customers';      
		$this->data['user'] = $this->customers->get_profile();
		$this->data['restaurants'] = $this->customers->get_restaurant();   
    $this->load->library('picture');                        
    @$this->data['reslogo'] = ($this->customers->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->customers->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'customers';         
			$session_data = $this->session->userdata('logged_in');  
      $data['role'] = $session_data['role'];
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_start_date'] = date('d M Y', time() - 30 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;   
			
      	if($this->input->post('email')){               
		    $this->customers->new_customers($this->input->post('name'),$this->input->post('phone'),$this->input->post('address1'),$this->input->post('address2'),$this->input->post('city'),$this->input->post('email'),$this->input->post('postal'),$this->input->post('country'),$this->input->post('rest_id'));
      	} 
      
		  $data['customers'] = $this->customers->get_rest_customers($rest_id);
			                   
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('customers',$data);
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
		$data['profile'] = $this->customers->get_profile();
		
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
