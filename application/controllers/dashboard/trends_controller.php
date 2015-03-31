<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trends_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('dashboard/trends_model','dash_trn',TRUE);
		$this->load->model('dashboard/rpanel_model','rpanel',TRUE);
		$this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->dash_trn->get_profile();
		$this->data['restaurants'] = $this->dash_trn->get_restaurant();
		$this->load->library('picture');
		$this->load->library('currency');    
    @$this->data['reslogo'] = ($this->dash_trn->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->dash_trn->get_rest_logo();  
		@$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in')){
			if($this->input->post('filter')){
				$sess_array = array(
					'def_rest' => $this->input->post('rest_id'),
					'def_start_date' => $this->input->post('startdate'),
					'def_end_date' => $this->input->post('enddate')
			   	);
				$this->session->set_userdata('filtered', $sess_array);
			}
			$data['menu'] = 'dashboard';         
			$session_data = $this->session->userdata('logged_in');
			$session_filt = $this->session->userdata('filtered');
			$data['def_rest'] = ($session_filt['def_rest'])?$session_filt['def_rest']:$session_data['def_rest'];
			@$data['def_start_date'] = ($session_filt['def_start_date'])?$session_filt['def_start_date']:date('d M Y', time() - 30 * 60 * 60 * 24);
			@$data['def_end_date'] = ($session_filt['def_end_date'])?$session_filt['def_end_date']:date('d M Y', time());
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('enddate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;
      $data['cur'] = $this->dash_trn->get_currency($rest_id);
      //==rpanel=======>       
			$data['net_sales_today'] = $this->rpanel->net_sales_today($rest_id);
			$data['tot_sales_today'] = $this->rpanel->total_sales_today($rest_id);
			$data['avrsls_percust'] = $this->rpanel->average_sales_per_customer($rest_id);
			$data['num_cust_today'] = $this->rpanel->number_customer_today($rest_id);
			$data['avrsls_perinv'] = $this->rpanel->average_sales_per_invoice($rest_id);
			$data['com_inv_today'] = $this->rpanel->completed_invoice_today($rest_id);
      //<==rpanel=====
			$data['dmorevenue'] = $this->dash_trn->dash_monthly_revenue($rest_id);
      $data['dwkrevenue'] = $this->dash_trn->dash_weekly_revenue($rest_id);
			$data['davrspcust'] = $this->dash_trn->dash_weekly_avslspcust($rest_id);
      $data['davrspinvo'] = $this->dash_trn->dash_weekly_avslspinv($rest_id);
      $data['nostock'] = $this->dash_trn->no_stock($rest_id);
		  //$data['promotions'] = $this->home->get_latest_promotions();
			//$data['services'] = $this->home->get_latest_services();
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			//(!($this->input->get('p')))?$this->load->view('dashboard/sales',$data):$this->load->view('dashboard/'.$this->input->get('p'),$data);
			$this->load->view('dashboard/trends',$data);
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
		$data['profile'] = $this->dash_trn->get_profile();
		
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
