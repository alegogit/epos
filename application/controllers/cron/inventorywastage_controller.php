<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventorywastage_controller extends CI_Controller {
	
	function __construct(){
		parent::__construct();	
		$this->load->model('cron/inventorywastage_model','cron',TRUE);
	}

	public function index(){
    $userid = $this->input->post('i');
    $usrname = $this->input->post('u');
    $passmd5 = $this->input->post('p');
    $periode = $this->input->post('e');
    $result = $this->cron->login($usrname, sha1($passmd5));
    $data['test'] = "safsdf";
    if($result){  
      $data['daily'] = $this->cron->get_daily_waste(); 
      $data['weekly'] = $this->cron->get_weekly_waste(); 
      $data['monthly'] = $this->cron->get_monthly_waste();
      if($periode=="daily"){ 
        $run =  $data['daily'];
      } else if($periode=="weekly"){ 
        $run =  $data['weekly'];
      } else if($periode=="monthly"){ 
        $run =  $data['monthly'];
      } 
      foreach($run as $row){
        $this->cron->update_quantity($userid,$row->ID,$row->NEW_QUANTITY);  
      }  
      $this->load->view('cron/inventorywastage',$data);
    }
  }
	
}
