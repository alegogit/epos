<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('reports/sales_model','sales',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->sales->get_profile();
		$this->data['restaurants'] = $this->sales->get_restaurant(); 
    $this->load->library('picture');    
    @$this->data['reslogo'] = ($this->sales->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->sales->get_rest_logo();    
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'reports';         
			$session_data = $this->session->userdata('logged_in');
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_report_name'] = 'Sales';
			$data['def_start_date'] = date('d M Y', time() - 7 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());     
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id');
			$report_name = (!($this->input->post('report_name')))?$data['def_report_name']:$this->input->post('report_name'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['report_name'] = $report_name;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;
      $data['cur'] = $this->sales->get_currency($rest_id);
			$data['sales_report'] = $this->sales->get_sales_report(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			$data['void_items'] = $this->sales->get_void_items(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
			              
			$passvars = $session_data['id'].",".$session_data['role'].",".$rest_id.",".$report_name.",".$start_date.",".$end_date;  
      $this->load->library('hash');  
			$data['hashvars'] = $this->hash->epos_encrypt($passvars,$this->config->item('encryption_key'));
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('reports/sales',$data);
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
  
	public function view(){  
    $callpage = "salesview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+2);       
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015 
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
		$data['restname'] = $this->sales->get_restaurant_name($parsed[2]); //(restid)
    @$data['reslogo'] = ($this->sales->get_restid_logo($parsed[2])=="")?base_url()."assets/images/logo3d.png":$this->sales->get_restid_logo($parsed[2]);  //(userid)  
		$data['def_report_name'] = $parsed[3];     
		$rest_id = $parsed[2];
		$report_name = (!($this->input->get('report_name')))?$data['def_report_name']:$this->input->get('report_name'); 
		//$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
		$start_date = $parsed[4];
    //$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate');  
		$end_date = $parsed[5];
		$data['rest_id'] = $rest_id;
		$data['report_name'] = $report_name;
		$data['startdate'] = $start_date;
		$data['enddate'] = $end_date;
    $data['cur'] = $this->sales->get_currency($rest_id);
		$data['sales_report'] = $this->sales->get_sales_report(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
		$data['void_items'] = $this->sales->get_void_items(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id); 
						
		$this->load->view('reports/printview/salesview',$data);
	}
		
  public function printing(){ 
    $callpage = "salesview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+3);    
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015   
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
    $filename = $parsed[3]."report".$parsed[2].".pdf";
    $config = $this->config->config;
    $p = $config['phantomjs']." ";
    $r = $config['html2pdf']." ";
    $u2 = base_url()."reports/salesview/".$parshash." ";    
    $o2 = $config['savedpdf'].$filename." ";
    $commando2 = $p.$r.$u2.$o2;
    $getout2 = exec($commando2,$out2,$err2);
    //var_dump($out2);
    //echo '<br>'.$commando2;
    redirect(base_url().$config['outputpdf'].$filename); 	 
  }
  	
	public function profile()
	{
		$data['profile'] = $this->sales->get_profile();
		
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
