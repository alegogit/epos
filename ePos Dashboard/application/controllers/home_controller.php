<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('home_model','home',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->home->get_profile();
		$this->data['restaurants'] = $this->home->get_restaurant();
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'home';
			$data['trans_today'] = $this->home->num_transactions_today();
			$data['sales_today'] = $this->home->total_sales_today();
			$data['percent_today'] = $this->home->percentage_increase_from_yesterday();
			$data['trans_this_year'] = $this->home->num_transactions_this_year();
			$data['sales_this_year'] = $this->home->total_sales_this_year();
			$data['percent_this_year'] = $this->home->percentage_increase_this_year();       
			$data['percent_this_week'] = $this->home->percentage_increase_from_last_week(); 
			$data['num_cust_30day'] = $this->home->num_customers_30day();
			//$data['promotions'] = $this->home->get_latest_promotions();
			//$data['services'] = $this->home->get_latest_services();
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('contents/home',$data);
			$this->load->view('shared/footer');
			//var_dump($this->data);
			//echo "<pre>" . var_dump($this->data) . "</pre>";

		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
	
	public function profile()
	{
		$data['profile'] = $this->home->get_profile();
		
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
