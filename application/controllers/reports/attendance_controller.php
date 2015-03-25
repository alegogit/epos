<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('reports/attendance_model','attendance',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->attendance->get_profile();
		$this->data['restaurants'] = $this->attendance->get_restaurant();  
    $this->load->library('picture');      
    @$this->data['reslogo'] = ($this->attendance->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->attendance->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'reports';         
			$session_data = $this->session->userdata('logged_in');
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_themonth'] = date('M Y', time());     
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
			$themonth = (!($this->input->post('themonth')))?$data['def_themonth']:$this->input->post('themonth'); 
			$data['rest_id'] = $rest_id;
			$data['themonth'] = $themonth;      
      $data['cur'] = $this->attendance->get_currency($rest_id);  
			$data['attendance'] = $this->attendance->get_attendance($rest_id,date('Y-m-d', strtotime($themonth)),date('Y-m-d', strtotime($themonth))); 
			
			$data['deleteId'] = (!($this->input->post('invid')))?'invid':$this->input->post('invid');
      $data['deleteIdStr'] = (!($this->input->post('invid')))?'invidstr':implode(',', $deleteId);
      		//$sql = "delete from usertable where userid in ($deleteIdStr)";

			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('reports/attendance',$data);
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
  
  
	public function exec() { 
		$data['def_rest'] = 1;
		$data['def_themonth'] = date('M Y', time());     
		$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
		$themonth = (!($this->input->post('themonth')))?$data['def_themonth']:$this->input->post('themonth'); 
		$data['rest_id'] = $rest_id;
		$data['themonth'] = $themonth;      
    $data['cur'] = $this->attendance->get_currency($rest_id);  
		$data['attendance'] = $this->attendance->get_attendance($rest_id,date('Y-m-d', strtotime($themonth)),date('Y-m-d', strtotime($themonth))); 
			
		$data['deleteId'] = (!($this->input->post('invid')))?'invid':$this->input->post('invid');
    $data['deleteIdStr'] = (!($this->input->post('invid')))?'invidstr':implode(',', $deleteId);
    
    $this->load->view('shared/notopbar_header',$this->data);
		$this->load->view('reports/test',$data);
		$this->load->view('shared/footer');
    
  }
	
}  