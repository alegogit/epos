<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {

	public function index()
	{
		
		$this->load->helper(array('form'));
		$this->load->view('login');
		
	}
		
	public function auth()
	{
		
		redirect('/login/form/', 'refresh');
	
	}

}
