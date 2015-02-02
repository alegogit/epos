<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {

	public function index()
	{
		
		$this->load->helper(array('form'));
		$data['username'] = ($this->input->post('username'))?$this->input->post('username'):"";
		$this->load->view('login',$data);
		
	}
		
	public function auth()
	{
		
		redirect('/login/form/', 'refresh');
	
	}

}
