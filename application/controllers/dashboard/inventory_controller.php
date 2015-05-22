<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('dashboard/inventory_model','dash_inv',TRUE);  
		$this->load->model('dashboard/rpanel_model','rpanel',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->dash_inv->get_profile();
		$this->data['restaurants'] = $this->dash_inv->get_restaurant();   
    $this->load->library('picture');    
		$this->load->library('currency');       
    @$this->data['reslogo'] = ($this->dash_inv->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->dash_inv->get_rest_logo();  
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
      $data['cur'] = $this->dash_inv->get_currency($rest_id);
      //==rpanel=======>       
			$data['net_sales'] = $this->rpanel->net_sales($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)));
			$data['tot_sales'] = $this->rpanel->total_sales($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)));
			$data['avrsls_percust'] = $this->rpanel->average_sales_per_customer($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)));
			$data['num_cust'] = $this->rpanel->number_customer($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)));
			$data['avrsls_perinv'] = $this->rpanel->average_sales_per_invoice($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)));
			$data['com_inv'] = $this->rpanel->completed_invoice($rest_id,date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)));
      //<==rpanel=====
			$data['nonmovitm'] = $this->dash_inv->non_moving_items($rest_id);
			$data['lowinstck'] = $this->dash_inv->low_in_stock($rest_id);
			$data['nostock'] = $this->dash_inv->no_stock($rest_id);   
      
			$passvars = $session_data['id'].",".$session_data['role'].",".$rest_id;  
      $this->load->library('hash');  
			$data['hashvars'] = $this->hash->epos_encrypt($passvars,$this->config->item('encryption_key'));
			
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
	
	public function view() {
    $callpage = "inventoryview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+2); //echo $parshash; 
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
		$data['restname'] = $this->dash_inv->get_restaurant_name($parsed[2]); //(restid)
    @$data['reslogo'] = ($this->dash_inv->get_logo_rest($parsed[2])=="")?base_url()."assets/images/logo3d.png":$this->dash_inv->get_logo_rest($parsed[2]);  //(userid)  
		$rest_id = $parsed[2];    //restid
		$data['rest_id'] = $rest_id;
		$data['nowadate'] = date('d F Y');
    
		$data['nonmovitm'] = $this->dash_inv->non_moving_items($rest_id);
		$data['lowinstck'] = $this->dash_inv->low_in_stock($rest_id);
		$data['nostock'] = $this->dash_inv->no_stock($rest_id);   
      
		$this->load->view('dashboard/printview/'.$callpage,$data);   
	}    
		
  public function printing(){ 
    $callpage = "inventoryview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+3);
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
    $filename = "Inventorydashboard".$parsed[2].".pdf";
    $config = $this->config->config;
    $p = $config['phantomjs']." ";
    $r = $config['html2pdfp']." ";  //potrait
    $u2 = base_url()."dashboard/".$callpage."/".$parshash." ";    
    $o2 = $config['savedpdf'].$filename." ";
    $commando2 = $p.$r.$u2.$o2;
    $getout2 = exec($commando2,$out2,$err2);
    //var_dump($out2);
    //echo '<br>'.$commando2;
    redirect(base_url().$config['outputpdf'].$filename); 	 
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
