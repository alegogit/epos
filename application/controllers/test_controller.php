<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
  function __construct(){
    parent::__construct();
    //$this->cron();        
  }
  
  function cron(){
    if(!$this->input->is_cli_request()){               
        die();
    }
  }
  
  public function index(){
    echo "eek";
  }
}
