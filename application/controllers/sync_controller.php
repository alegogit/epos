<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sync_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('sync_model','sync',TRUE);  
    	$this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');  
		$this->data['menu'] = 'sync';      
		$this->data['user'] = $this->sync->get_profile();
		$this->data['restaurants'] = $this->sync->get_restaurant();   
    	$this->load->library('picture');   
    	@$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";
  }

	public function index()
	{
		if($this->session->userdata('logged_in')){
			$data['menu'] = 'sync';         
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
			$data['synchist'] = $this->sync->get_sync_history($rest_id);
        	$this->load->view('shared/header',$this->data);
        	$this->load->view('shared/left_menu', $data);
        	$this->load->view('sync',$data);   
        	$this->load->view('shared/footer');
		} else {
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
	
	public function exec() { 
		$restid = $this->input->post('restid');
		$synchist = $this->sync->get_sync_history($restid);
		foreach ($synchist as $row){
			$MENU = $this->sync->get_updated_records('MENU',$row->LAST_SYNC);
			$CATEGORY = $this->sync->get_updated_records('CATEGORY',$row->LAST_SYNC);
			$PRINTER = $this->sync->get_updated_records('PRINTER',$row->LAST_SYNC);
			$USERS = $this->sync->get_updated_records('USERS',$row->LAST_SYNC);
			$TABLES = $this->sync->get_updated_records('TABLES',$row->LAST_SYNC);
			$RESTAURANTS = $this->sync->get_updated_records('RESTAURANTS',$row->LAST_SYNC);
			$REF_VALUES = $this->sync->get_updated_records('REF_VALUES',$row->LAST_SYNC);
		}
		$upd = array('MENU' => array(),'CATEGORY' => array(),'PRINTER' => array(),'USER' => array(),'TABLES' => array(),'RESTAURANTS' => array(),'REF_VALUES' => array());
		foreach($MENU as $mn){
			$upd['MENU'] = $mn->ID;
		} 
		foreach($CATEGORY as $ct){
			$upd['CATEGORY'] = $ct->ID;
		} 
		foreach($PRINTER as $pr){
			$upd['PRINTER'] = $pr->ID;
		} 
		foreach($USERS as $us){
			$upd['USERS'] = $us->ID;
		} 
		foreach($TABLES as $tb){
			$upd['TABLES'] = $tb->ID;
		} 
		foreach($RESTAURANTS as $rs){
			$upd['RESTAURANTS'] = $rs->ID;
		} 
		foreach($REF_VALUES as $rv){
			$upd['REF_VALUES'] = $rv->ID;
		} 
    	$registatoin_ids = array("APA91bFV52QJffsTCVZJcDqP923hiwh_jBkt-p8epifAhTHfk7bzERngujrlhdKEPcMjdoJZEsXQoELSAKMhqGSyz2IISq--h_NxMmiPrdlfRiu6Rw_yvWFsnA-ss-8oZ97G-qj20jPp0FrOC5UNzs3zhpSNZuA1bg");
    	$message = array(
                  "sync" => "1",
				  "MENU" => array($upd['MENU']),
				  "CATEGORY" => array($upd['CATEGORY']),
				  "PRINTER" => array($upd['PRINTER']),
				  "USERS" => array($upd['USERS']),
				  "TABLES" => array($upd['TABLES']),
				  "RESTAURANTS" => array($upd['RESTAURANTS']),
				  "REF_VALUES" => array($upd['REF_VALUES'])
                );
		//echo $this->sync->send_notification($registatoin_ids, $message); 
		var_dump($upd);
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
