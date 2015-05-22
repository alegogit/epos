<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terminal_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('setting/terminal_model','setting',TRUE); 
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');  
		$this->data['menu'] = 'setting';      
		$this->data['user'] = $this->setting->get_profile();
		$this->data['restaurants'] = $this->setting->get_restaurant();  
    $this->load->library('picture');      
    @$this->data['reslogo'] = ($this->setting->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->setting->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			if($this->input->post('filter')){
				$sess_array = array(
					'def_rest' => $this->input->post('rest_id')
			   	);
				$this->session->set_userdata('filtered', $sess_array);
			}
			$data['menu'] = 'setting';         
			$session_data = $this->session->userdata('logged_in');   
		  $data['role'] = $session_data['role'];
			$session_filt = $this->session->userdata('filtered');
			$data['def_rest'] = ($session_filt['def_rest'])?$session_filt['def_rest']:$session_data['def_rest'];
			$data['def_rest_name'] = ($session_filt['def_rest'])?$this->setting->get_restaurant_name($session_filt['def_rest']):$this->setting->get_restaurant_name($session_data['def_rest']);
			$data['def_start_date'] = date('d M Y', time() - 30 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;
      
      if($this->input->post('terminal_type')){
        $this->setting->new_terminal($this->input->post('terminal_name'),$this->input->post('terminal_mac'),$this->input->post('terminal_type'),$this->input->post('terminal_manufacturer'),$this->input->post('terminal_model'),$this->input->post('conn_type'),$rest_id);
      }
      
      $data['terminal'] = $this->setting->get_rest_terminal($rest_id);    		       
		  $data['statuses'] = $this->setting->get_status(); 					        		       
		  $data['conn_type'] = $this->setting->get_conn_type(); 		         
      $data['maclist'] = $this->setting->get_mac();				                   
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('setting/terminal',$data);
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
