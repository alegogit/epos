<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('reports/daily_model','daily',TRUE);
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');
		$this->data['user'] = $this->daily->get_profile();
		$this->data['restaurants'] = $this->daily->get_restaurant(); 
    $this->load->library('picture');     
		$this->load->library('currency');         
    @$this->data['reslogo'] = ($this->daily->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->daily->get_rest_logo();    
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
			$end_date = (!($this->input->post('enddate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['report_name'] = $report_name;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date;
      $data['cur'] = $this->daily->get_currency($rest_id);
			//$data['sales_report'] = $this->daily->get_revenue($rest_id); 
			              
			$passvars = $session_data['id'].",".$session_data['role'].",".$rest_id.",".$report_name.",".$start_date.",".$end_date;  
      $this->load->library('hash');  
			$data['hashvars'] = $this->hash->epos_encrypt($passvars,$this->config->item('encryption_key'));
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
      if (!($this->input->post('report_name'))){                      
        $this->load->view('reports/daily',$data);
      } else {  
        if($report_name=='Sales'){                        
          $this->load->view('reports/daily/sales',$data);
        } else { 
          $this->load->view('reports/daily/recon',$data);
        }
      }
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
  
	public function salesview(){  
    $callpage = "dailysales";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+2);       
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015 
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
		$data['restname'] = $this->daily->get_restaurant_name($parsed[2]); //(restid)
    @$data['reslogo'] = ($this->daily->get_restid_logo($parsed[2])=="")?base_url()."assets/images/logo3d.png":$this->daily->get_restid_logo($parsed[2]);  //(userid)  
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
    $data['dayname'] = date('l', strtotime($end_date));
    $data['cur'] = $this->daily->get_currency($rest_id);
    $data['revenue'] = $this->daily->get_revenue($rest_id,date('Y-m-d', strtotime($end_date)));
    $data['summary'] = $this->daily->get_summary($rest_id,date('Y-m-d', strtotime($end_date)));
    $data['payment'] = $this->daily->get_payment($rest_id,date('Y-m-d', strtotime($end_date)));
    $data['pmethod'] = $this->daily->get_paymethods();
    $data['ordtype'] = $this->daily->get_ordtype($rest_id,date('Y-m-d', strtotime($end_date)));
    $data['dtopcatsz'] = $this->daily->get_topcat($rest_id,date('Y-m-d', strtotime($end_date))); 
      if(count($data['dtopcatsz'])>5){   
  			$data['dtopcatsx'] = $this->daily->get_topcat($rest_id,date('Y-m-d', strtotime($end_date))); 
  			$array0 = $data['dtopcatsz'];
        $array1 = $data['dtopcatsx'];
        $array2 = $this->daily->get_top_five($array0);
        $array3 = $this->daily->remove_others($array0);
        $array5 = $this->daily->set_as_others($array1);
        $array6 = $this->daily->remove_other_others($array5);
        $array7 = array_merge($array2,$array3,$array6);
        $array8 = array_merge($array2,$array6,$array3);
        $data['topcat'] = ($array7[5]->AMOUNT > $array8[5]->AMOUNT)?$array7:$array8;
      } else {   
  			$array0 = $this->daily->remove_zero_values($data['dtopcatsz']);
        $data['topcat'] = $array0;  
      }
    $data['adjust'] = $this->daily->get_adjust($rest_id,date('Y-m-d', strtotime($end_date)));
    $data['voiditem'] = $this->daily->get_voiditem($rest_id,date('Y-m-d', strtotime($end_date)));
						
		$this->load->view('reports/daily/sales',$data);
	}
  
	public function reconview(){  
    $callpage = "dailyrecon";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+2);       
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015 
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
		$data['restname'] = $this->daily->get_restaurant_name($parsed[2]); //(restid)
    @$data['reslogo'] = ($this->daily->get_restid_logo($parsed[2])=="")?base_url()."assets/images/logo3d.png":$this->daily->get_restid_logo($parsed[2]);  //(userid)  
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
    $data['dayname'] = date('l', strtotime($end_date));
    $data['cur'] = $this->daily->get_currency($rest_id);
		$data['recon'] = $this->daily->get_recon($rest_id,date('Y-m-d', strtotime($end_date))); 
						
		$this->load->view('reports/daily/recon',$data);
	}
		
  public function salesprint(){ 
    $callpage = "salesdaily";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+7);    
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015   
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
    $filename = "DailySalesReport".$parsed[2].".pdf";
    $config = $this->config->config;
    $p = $config['phantomjs']." ";
    $r = $config['html2pdfslp']." ";
    $u2 = base_url()."reports/".$callpage."/".$parshash." ";    
    $o2 = $config['savedpdf'].$filename." ";
    $commando2 = $p.$r.$u2.$o2;
    $getout2 = exec($commando2,$out2,$err2); 
    foreach($out2 as $key => $value){
		  echo $key." ".$value."<br>";
    }
    $remove_cache = "?".md5(date('Ymdhis'));
    //var_dump($out2);
    //echo '<br>'.$commando2;
    redirect(base_url().$config['outputpdf'].$filename.$remove_cache); 	 
  }
  
  public function reconprint(){ 
    $callpage = "recondaily";
    $parshash = substr(strstr(uri_string(),'/'),strlen($callpage)+7);    
    $this->load->library('hash');  
    $parsvars = $this->hash->epos_decrypt($parshash,$this->config->item('encryption_key'));
    //echo $parshash."<br>".$parsvars;  //1,1,1,Sales,01 Mar 2015,10 Mar 2015   
    $parsed = explode(",",$parsvars);  //var_dump($parsed);
    $filename = "DailyCashflowReport".$parsed[2].".pdf";
    $config = $this->config->config;
    $p = $config['phantomjs']." ";
    $r = $config['html2pdfslp']." ";
    $u2 = base_url()."reports/".$callpage."/".$parshash." ";    
    $o2 = $config['savedpdf'].$filename." ";
    $commando2 = $p.$r.$u2.$o2;
    $getout2 = exec($commando2,$out2,$err2);  
    foreach($out2 as $key => $value){
		  echo $key." ".$value."<br>";
    }
    $remove_cache = "?".md5(date('Ymdhis'));
    //var_dump($out2);
    //echo '<br>'.$commando2;
    redirect(base_url().$config['outputpdf'].$filename.$remove_cache); 	 
  }
  	
	public function profile()
	{
		$data['profile'] = $this->daily->get_profile();
		
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
