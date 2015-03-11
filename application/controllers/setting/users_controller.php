<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('setting/users_model','setting',TRUE);  
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');  
		$this->data['menu'] = 'setting';      
		$this->data['user'] = $this->setting->get_profile();
		$this->data['restaurants'] = ($session_data['role']==1)?$this->setting->get_all_restaurants():$this->setting->get_restaurant(); 
    $this->load->library('picture');   
    @$this->data['reslogo'] = ($this->setting->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->setting->get_rest_logo();     
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'setting';         
			$session_data = $this->session->userdata('logged_in');  
		  $role = $session_data['role'];
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
				$this->setting->new_users($this->input->post('name'),$this->input->post('email'),$this->input->post('username'),$this->input->post('password'),$this->input->post('role'),$this->input->post('drest'),$this->input->post('arest'));
		    }        
		                    
		    if($this->input->post('cps')&&($this->input->post('pass1')==$this->input->post('pass2'))){             
				$this->setting->update_pass($this->input->post('uid'),$this->input->post('pass2'));
		    }     
			    
		    if($this->input->post('asgrest')){             
				$this->setting->assign_rest($this->input->post('uid'),$this->input->post('asgrest'));
		  	} 
      
		  	$data['users'] = $this->setting->get_users_data();
		  	$data['roles'] = $this->setting->get_roles();			                   
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('setting/users',$data);
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
		$data['profile'] = $this->setting->get_profile();
		
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
