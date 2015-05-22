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
    $option = $this->input->post('e');
    $result = $this->cron->login($usrname, sha1($passmd5));
    $data['test'] = "succeed";
    if($result){  
      $data['daily'] = $this->cron->get_daily_waste(); 
      $data['weekly'] = $this->cron->get_weekly_waste(); 
      $data['monthly'] = $this->cron->get_monthly_waste();
      $data['orders'] = $this->cron->get_orders_waste();
      
      if($option=="daily"){ 
        $run = $data['daily'];
      } else if($option=="weekly"){ 
        $run = $data['weekly'];
      } else if($option=="monthly"){ 
        $run = $data['monthly'];
      } else if($option=="orders"){
        if(count($data['orders'])>0){
          $data['actrest'] = $this->cron->get_active_rest();
          $run = $data['actrest'];
          $data['test'] .= " some orders";
        } else {
          $run = array(); 
          $data['test'] .= " no orders";
        } 
      } 
      
      if(count($run)>0) {   
        foreach($run as $row){  
          if($option=="orders"){    
            $this->cron->update_quantity_from_orders($row->ID+0); 
            $data['test'] .= " upd quant ".$row->ID;
            $this->cron->update_deducted($userid,$row->ID+0); 
            $data['test'] .= " upd ded ".$row->ID;
          } else {   
            $this->cron->update_quantity($userid,$row->ID,$row->NEW_QUANTITY);
          } 
          //$data['test'] .= $row->ID."<br>"; 
        }  
      }
      
      $this->load->view('cron/inventorywastage',$data);
    } else {
      echo "invalid login";
    }
  }
	
}
