<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('setting/restaurant_model','setting',TRUE);  
    $this->load->helper(array('form', 'url','html'));
		$session_data = $this->session->userdata('logged_in');  
		$this->data['menu'] = 'setting';        
		$this->data['submenu'] = 'restaurant';      
		$this->data['user'] = $this->setting->get_profile();
		$this->data['restaurants'] = $this->setting->get_restaurant();  
    $this->load->library('picture');   
    $this->load->library('curl');   
    //@$this->data['reslogo'] = ($this->setting->get_rest_logo()->LOGO_URL=="")?base_url()."assets/images/logo3d.png":$this->setting->get_rest_logo()->LOGO_URL;  
    @$this->data['reslogo'] = ($this->setting->get_rest_logo()=="")?base_url()."assets/images/logo3d.png":$this->setting->get_rest_logo();  
    @$this->data['profpic'] = ($this->data['user']->IMAGE=="")?base_url()."assets/img/no-photo.jpg":base_url()."profile/pic/".$this->picture->gettyimg($session_data['id']).".jpg";  
  }

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data['menu'] = 'setting';         
			$session_data = $this->session->userdata('logged_in');  
		  $data['role'] = $session_data['role'];
			$data['def_rest'] = $session_data['def_rest'];
			$data['def_start_date'] = date('d M Y', time() - 30 * 60 * 60 * 24);
			$data['def_end_date'] = date('d M Y', time());
			$rest_id = (!($this->input->post('rest_id')))?$data['def_rest']:$this->input->post('rest_id'); 
			$start_date = (!($this->input->post('startdate')))?$data['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('startdate')))?$data['def_end_date']:$this->input->post('enddate'); 
			$data['rest_id'] = $rest_id;
			$data['startdate'] = $start_date;
			$data['enddate'] = $end_date; 
			                                 
      if($this->input->post('email') && $data['role']==1){ 
        if(@$_FILES['cphoto']['tmp_name']){
          $request = curl_init($this->config->config['fileserver_upl']);
          curl_setopt($request, CURLOPT_POST, true); 
          $args['cphoto'] = new CurlFile($_FILES['cphoto']['tmp_name'], 'image/jpg');
          $args['rid'] = $this->setting->new_id();
          $args['key'] = md5($this->setting->gettyimg($args['rid']));
          $args['dir'] = $this->config->config['fileserver_img_dir'];
          curl_setopt($request, CURLOPT_POSTFIELDS, $args);
          curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($request);
          curl_close($request);        
          if($result !== FALSE) {
            $photo_url = $this->config->config['fileserver_url'].$args['dir'].$this->setting->gettyimg($args['rid']).".jpg";  
          } else {
            $photo_url = base_url()."assets/images/logo3d.png";
          }
        } else {
          $photo_url = base_url()."assets/images/logo3d.png";
        } 
        $this->setting->new_restaurant(
          $this->input->post('name'),$this->input->post('telephone'),$this->input->post('FAX'),
          $this->input->post('address1'),$this->input->post('address2'),$this->input->post('city'),
          $this->input->post('postalcode'),$this->input->post('country'),$this->input->post('geoloc'),
          $this->input->post('email'),$this->input->post('currency'),
          $this->input->post('NPWP'),$this->input->post('cutoff_time'),
          $this->input->post('service'),$this->input->post('toservice'),$photo_url
        );
      } else {    
        if(@$_FILES['cphoto']['tmp_name']){
          $request = curl_init($this->config->config['fileserver_upl']);
          // send a file
          curl_setopt($request, CURLOPT_POST, true); 
          //$filename = substr($_FILES['cphoto']['tmp_name'],0,-4).".jpg";   echo $filename;
          //$args['cphoto'] = new CurlFile($filename, 'image/jpg');
          //$args['cphoto'] = new CurlFile($_FILES['cphoto']['tmp_name'], 'image/jpg');
          $args['cphoto'] = class_exists('CurlFile', false) ? new CurlFile($_FILES['cphoto']['tmp_name'], 'image/jpg') : @$_FILES['cphoto']['tmp_name'];
          $args['rid'] = $this->input->post('rid');
          $args['key'] = md5( $this->setting->gettyimg( $this->input->post('rid') ) );
          $args['dir'] = $this->config->config['fileserver_img_dir'];
          curl_setopt($request, CURLOPT_POSTFIELDS, $args);
          //curl_setopt($request, CURLOPT_POSTFIELDS, array('cphoto' => $cfile )); 
          // output the response
          curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
          //curl_setopt($request,CURLOPT_FOLLOWLOCATION,true);
          $result = curl_exec($request);
          // close the session
          curl_close($request);        
          if($result !== FALSE) {
            $photo_url = $this->config->config['fileserver_url'].$args['dir'].$this->setting->gettyimg($this->input->post('rid')).".jpg";
            $this->setting->update_logo($photo_url,$args['rid']);
          }
        }
      }                        
      
		  $data['restaurant'] = $this->setting->get_restaurant_data();
		  $data['currencies'] = $this->setting->get_currencies();	
		  $data['countries'] = $this->setting->get_countries(); 			       
		  $data['statuses'] = $this->setting->get_status(); 			           		                   
			
			$this->load->view('shared/header',$this->data);
			$this->load->view('shared/left_menu', $data);
			$this->load->view('setting/restaurant',$data);
			$this->load->view('shared/footer');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		
	}
	
	public function profile()
	{
		$data['profile'] = $this->setting->get_profile();
		
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
