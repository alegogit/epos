<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('home_model','home',TRUE);
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->home->get_profile();
		$this->data['restaurants'] = $this->home->get_restaurant(); 
			//echo "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>";
			//echo "<pre>" . var_dump($this->data['restaurants']) . "</pre>";
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'home';         
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
			$data['trans_today'] = $this->home->num_transactions_today($rest_id);
			$data['sales_today'] = $this->home->total_sales_today($rest_id);
			$data['percent_today'] = $this->home->percentage_increase_from_yesterday($rest_id);
			$data['trans_this_year'] = $this->home->num_transactions_this_year($rest_id);
			$data['sales_this_year'] = $this->home->total_sales_this_year($rest_id);
			$data['percent_this_year'] = $this->home->percentage_increase_this_year($rest_id);       
			$data['percent_this_week'] = $this->home->percentage_increase_from_last_week($rest_id); 
			$data['num_cust_30day'] = $this->home->num_customers_30day($rest_id);
			$data['dpayment'] = $this->home->dash_payment_method(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id);
			$data['dtopcats'] = $this->home->dash_top_categories(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id);
			$data['dbestsells'] = $this->home->dash_best_sellers(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id);
			$data['dmorevenue'] = $this->home->dash_monthly_revenue($rest_id);
		  $data['dwkrevenue'] = $this->home->dash_weekly_revenue($rest_id);
		  //$data['promotions'] = $this->home->get_latest_promotions();
			//$data['services'] = $this->home->get_latest_services();
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('contents/home',$data);
			$this->load->view('shared/footer');
			//echo "&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>";
			//echo "<pre>" . var_dump($data['dpayment']) . "</pre>";
               //echo $this->input->get('rest_id');
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
