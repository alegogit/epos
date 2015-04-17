<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('reports/inventory_model','inventory',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->inventory->get_profile();
		$this->data['restaurants'] = $this->inventory->get_restaurant();  
    $this->load->library('picture');           
    @$this->data['reslogo'] = ($this->inventory->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->inventory->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'reports';         
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
			$data['inventory'] = $this->inventory->get_inventory($rest_id); 
			
			$data['deleteId'] = (!($this->input->post('invid')))?'invid':$this->input->post('invid');
      $data['deleteIdStr'] = (!($this->input->post('invid')))?'invidstr':implode(',', $deleteId);
      
			$passvars = $session_data['id'].",".$session_data['role'].",".$rest_id;  
      $this->load->library('hash');  
			$data['hashvars'] = $this->hash->epos_encrypt($passvars,$this->config->item('encryption_key'));

			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('reports/inventory',$data);
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
		$data['restname'] = $this->inventory->get_restaurant_name($parsed[2]); //(restid)
    @$data['reslogo'] = ($this->inventory->get_restid_logo($parsed[2])=="")?base_url()."assets/images/logo3d.png":$this->inventory->get_restid_logo($parsed[2]);  //(userid)  
		$rest_id = $parsed[2];    //restid
		$data['rest_id'] = $rest_id;
		$data['nowadate'] = date('d F Y');
          
		$data['inventory'] = $this->inventory->get_inventory($rest_id); 
      
		$this->load->view('reports/printview/'.$callpage,$data);
	}    
		
  public function printing(){ 
    $callpage = "inventoryview";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+3);
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
    $filename = "Inventoryreport".$parsed[2].".pdf";
    $config = $this->config->config;
    $p = $config['phantomjs']." ";
    $r = $config['html2pdfp']." ";  //potrait
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
		$data['profile'] = $this->inventory->get_profile();
		
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
