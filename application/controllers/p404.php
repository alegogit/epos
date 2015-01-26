<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class P404 extends CI_Controller {

	public function index()
	{
		$data['url'] = !isset($_SERVER['HTTP_REFERER'])?base_url():$_SERVER['HTTP_REFERER'];
		$this->load->view('404',$data);
		
	}

}
