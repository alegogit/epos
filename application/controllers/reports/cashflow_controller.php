<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('reports/cashflow_model','cashflow',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->cashflow->get_profile();
		$this->data['restaurants'] = $this->cashflow->get_restaurant();  
    $this->load->library('picture');
		$this->load->library('currency');         
    @$this->data['reslogo'] = ($this->cashflow->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->cashflow->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'reports';
      $report_name = "Cashflow";         
			$session_data = $this->session->userdata('logged_in');
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_start_date'] = date('d M Y', time() - 7 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());     
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id');
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;      
      $data['cur'] = $this->cashflow->get_currency($rest_id);  
			$data['cashflow'] = $this->cashflow->get_cashflow($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date))); 
			              
			$passvars = $session_data['id'].",".$session_data['role'].",".$rest_id.",".$report_name.",".$start_date.",".$end_date;  
      $this->load->library('hash');  
			$data['hashvars'] = $this->hash->epos_encrypt($passvars,$this->config->item('encryption_key'));

			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('reports/cashflow',$data);
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}   
  
	public function view(){  
    $callpage = "cashflowview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+2);
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
		$data['restname'] = $this->cashflow->get_restaurant_name($parsed[2]); //(restid)
    @$data['reslogo'] = ($this->cashflow->get_restid_logo($parsed[2])=="")?base_url()."assets/images/logo3d.png":$this->cashflow->get_restid_logo($parsed[2]);  //(userid)  
		$rest_id = $parsed[2];    //restid
		$report_name = $parsed[3];     
		$start_date = $parsed[4];
		$end_date = $parsed[5];
		$data['rest_id'] = $rest_id;
		$data['report_name'] = $report_name;
		$data['startdate'] = $start_date;
		$data['enddate'] = $end_date;
    $data['cur'] = $this->cashflow->get_currency($rest_id);
		$data['cashflow'] = $this->cashflow->get_cashflow($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date))); 
						
		$this->load->view('reports/printview/'.$callpage,$data);
	}
		
  public function printing(){ 
    $callpage = "cashflowview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+3); 
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015   
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
    $filename = $parsed[3]."report".$parsed[2].".pdf";
    $config = $this->config->config;
    $p = $config['phantomjs']." ";
    $r = $config['html2pdfp']." ";   //potrait
    $u2 = base_url()."reports/".$callpage."/".$parshash." ";    
    $o2 = $config['savedpdf'].$filename." ";
    $commando2 = $p.$r.$u2.$o2;
    $getout2 = exec($commando2,$out2,$err2);
    //var_dump($out2);
    //echo '<br>'.$commando2;
    redirect(base_url().$config['outputpdf'].$filename); 	 
  }
	
	public function profile()
	{
		$data['profile'] = $this->cashflow->get_profile();
		
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
