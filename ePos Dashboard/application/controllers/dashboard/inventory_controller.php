<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('dashboard/inventory_model','dash_inv',TRUE);  
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->dash_inv->get_profile();
		$this->data['restaurants'] = $this->dash_inv->get_restaurant(); 
	}

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'dashboard';         
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
			$data['trans_today'] = $this->dash_inv->num_transactions_today($rest_id);
			$data['sales_today'] = $this->dash_inv->total_sales_today($rest_id);
			$data['percent_today'] = $this->dash_inv->percentage_increase_from_yesterday($rest_id);
			$data['trans_this_year'] = $this->dash_inv->num_transactions_this_year($rest_id);
			$data['sales_this_year'] = $this->dash_inv->total_sales_this_year($rest_id);
			$data['percent_this_year'] = $this->dash_inv->percentage_increase_this_year($rest_id);       
			$data['percent_this_week'] = $this->dash_inv->percentage_increase_from_last_week($rest_id); 
			$data['num_cust_30day'] = $this->dash_inv->num_customers_30day($rest_id);
			$data['nonmovitm'] = $this->dash_inv->non_moving_items();
			$data['lowinstck'] = $this->dash_inv->low_in_stock();
			$data['nostock'] = $this->dash_inv->no_stock();
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('dashboard/inventory',$data);
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
		$data['profile'] = $this->dash_inv->get_profile();
		
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
