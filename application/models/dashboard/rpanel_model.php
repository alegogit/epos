<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpanel_model extends CI_Model {

  function __construct(){
    // Call the Model constructor
    parent::__construct();
  }
  
  function net_sales_today($rest_id){           
		$query = $this->db->query("SELECT IFNULL(SUM(TOTAL),0) - IFNULL(SUM(DISCOUNT), 0) AS NET_SALES 
                                FROM ORDERS
                            		WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = ".$rest_id." AND ACTIVE =0;");
		return $query->row();
	}
  
  function total_sales_today($rest_id){ 
		$query = $this->db->query("SELECT IFNULL(SUM(PAID_AMOUNT),0) AS TOTAL_SALES 
                                FROM ORDERS 
                                WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = ".$rest_id." AND ACTIVE =0;");
		return $query->row();
	}
  
  function average_sales_per_customer($rest_id){
		$query = $this->db->query("SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST
                        				FROM ORDERS O
                        				WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = ".$rest_id." AND ACTIVE =0;");
		return $query->row();
  }
  
  function number_customer_today($rest_id){
		$query = $this->db->query("SELECT IFNULL(SUM(O.NO_OF_GUEST),0)  AS TOTAL_CUST 
                        				FROM ORDERS O
                        				WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = ".$rest_id." AND ACTIVE =0;");
		return $query->row();
  }  
  
  function average_sales_per_invoice($rest_id){
		$query = $this->db->query("SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(INV.ID),1) AS AVG_SALES_INV  
                          			FROM INVOICES INV
                          			INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = INV.ID
                          			INNER JOIN ORDERS O ON O.ID = OI.ORDER_ID
                          			WHERE DATE(O.ENDED) = DATE(SYSDATE()) AND O.REST_ID = ".$rest_id." AND O.ACTIVE =0;");
		return $query->row();
  }    
  
  function completed_invoice_today($rest_id){
		$query = $this->db->query("SELECT IFNULL(COUNT(INV.ID),0) AS TOTAL_INV 
                          			FROM INVOICES INV
                          			INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = INV.ID
                          			INNER JOIN ORDERS O ON O.ID = OI.ORDER_ID
                          			WHERE DATE(O.ENDED) = DATE(SYSDATE()) AND O.REST_ID = ".$rest_id." AND O.ACTIVE =0;");
		return $query->row();
  }  
  
}