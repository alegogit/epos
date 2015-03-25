<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('dashboard/sales_model','dash_sls',TRUE);
		$this->load->library('currency');   
  }

	public function index()	{            
			$datat['def_rest'] = 1;
			$datat['def_start_date'] = date('d M Y', time() - 30 * 60 * 60 * 24);
			$datat['def_end_date'] = date('d M Y', time());
			$rest_id = (!($this->input->post('rest_id')))?$datat['def_rest']:$this->input->post('rest_id'); 
			$start_date = (!($this->input->post('startdate')))?$datat['def_start_date']:$this->input->post('startdate'); 
			$end_date = (!($this->input->post('enddate')))?$datat['def_end_date']:$this->input->post('enddate'); 
			$datat['rest_id'] = $rest_id;
			$datat['startdate'] = $start_date;
			$datat['enddate'] = $end_date;
      $datat['cur'] = $this->dash_sls->get_currency($rest_id);
			$datat['trans_today'] = $this->dash_sls->num_transactions_today($rest_id);
			$datat['sales_today'] = $this->dash_sls->total_sales_today($rest_id);
			$datat['percent_today'] = $this->dash_sls->percentage_increase_from_yesterday($rest_id);
			$datat['trans_this_year'] = $this->dash_sls->num_transactions_this_year($rest_id);
			$datat['sales_this_year'] = $this->dash_sls->total_sales_this_year($rest_id);      
			$datat['percent_this_week'] = $this->dash_sls->percentage_increase_from_last_week($rest_id); 
			$datat['num_cust_30day'] = $this->dash_sls->num_customers_30day($rest_id);
			$datat['dpayment'] = $this->dash_sls->dash_payment_method(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id);
			$datat['dtopcats'] = $this->dash_sls->dash_top_categories(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id);
			$datat['dbestsells'] = $this->dash_sls->dash_best_sellers(date('Y-m-d', strtotime($start_date)),date('Y-m-d', strtotime($end_date)),$rest_id);
			$datat['dmorevenue'] = $this->dash_sls->dash_monthly_revenue($rest_id); 
      $datat['dwkrevenue'] = $this->dash_sls->dash_weekly_revenue($rest_id);	
      $datat['nostock'] = $this->dash_sls->no_stock($rest_id);
		  
			@$datat['reslogo'] = ($this->dash_sls->get_logo_rest()=="")?base_url()."assets/images/logo3d.png":$this->dash_sls->get_logo_rest();  
		  
      $this->load->view('shared/notopbar_header');
			$this->load->view('dashboard/dash_print_test',$datat);
			$this->load->view('shared/footer');
		
	}   
	
	
}
