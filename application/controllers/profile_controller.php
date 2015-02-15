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
    $this->load->library('picture');   
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
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
      $piccode = substr(strstr(uri_string(),'/'),5,-4); 
      
      if($this->input->post('spro')){         
				if($this->input->post('name')){$this->profile->update_name($this->input->post('name'));}       
				if($this->input->post('email')){$this->profile->update_email($this->input->post('email'));}     
				if($this->input->post('user')){$this->profile->update_username($this->input->post('user'));}   
				if($this->input->post('rest_id')){$this->profile->update_def_rest($this->input->post('rest_id'));}       
				if(($_FILES['photo']['tmp_name']!="")&&($_FILES['photo']['size']<307200)&&(substr($_FILES['photo']['type'],0,5)=="image")){$this->profile->update_photo(@file_get_contents($_FILES['photo']['tmp_name']),TRUE);}
				if($this->input->post('pass2')&&($this->input->post('pass2')==$this->input->post('pass1'))){$this->profile->update_pass($this->input->post('pass2'));}
      } 	                                
		  
      $data['user'] = $this->profile->get_profile();    
      $data['image'] = $data['user']->IMAGE;	          
			$data['default'] = $this->profile->get_default_rest();      
			$data['profpic'] = ($data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->profile->gettyimg().".jpg";
      
			if($piccode==$this->profile->gettyimg()){ 
        $this->load->view('extracts/img',$data);
      } else {      
        $this->load->view('shared/header',$this->data);
        $this->load->view('shared/left_menu', $data);
        $this->load->view('profile',$data);   
        $this->load->view('shared/footer');
      }
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
