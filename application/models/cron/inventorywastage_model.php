<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Inventorywastage_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function login($username, $password) {
        $this->db->where('USERS.USERNAME', $username);
        $this->db->where('USERS.PASSWORD', $password);  
        $this->db->limit(1); 
        $query = $this->db->get('USERS');
        if($query->num_rows() == 1){
          return $query->result(); //if data is true
        } else {
          return false; //if data is wrong
        }               		
    }
    
    function get_daily_waste(){
      $query = $this->db->query("SELECT ID, QUANTITY, METRIC, WASTAGE_PERCENT, WASTAGE_FREQ, 
                                  CASE METRIC 
                                  WHEN 'PIECES' THEN ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 0) 
                                  ELSE ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 1) 
                                  END  AS NEW_QUANTITY
                                FROM INVENTORY
                                WHERE WASTAGE_FREQ = 'PER_DAY';"); 
      return $query->result();
    }
    
    function get_weekly_waste(){
      $query = $this->db->query("SELECT ID, QUANTITY, METRIC, WASTAGE_PERCENT, WASTAGE_FREQ, 
                                  CASE METRIC
                                	WHEN 'PIECES' THEN ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 0) 
                                  ELSE ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 1)
                                  END  AS NEW_QUANTITY
                                FROM INVENTORY
                                WHERE WASTAGE_FREQ = 'PER_WEEK';"); 
      return $query->result();
    }    
    
    function get_monthly_waste(){
      $query = $this->db->query("SELECT ID, QUANTITY, METRIC, WASTAGE_PERCENT, WASTAGE_FREQ, 
                                  CASE METRIC
                                	WHEN 'PIECES' THEN ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 0) 
                                  ELSE ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 1)
                                  END  AS NEW_QUANTITY
                                FROM INVENTORY
                                WHERE WASTAGE_FREQ = 'PER_MONTH';"); 
      return $query->result();
    } 
    
    function get_orders_waste(){
      $query = $this->db->query("-- menu-inventory to deduct checking
        SELECT 
			INV_QUANT.QUAN_TO_DEDUCT AS NEW_QUANTITY, INVENTORY_ID AS ID
			FROM
				(
				-- Get their Inventory ids from mapping
				SELECT MI.INVENTORY_ID, SUM(MI.QUANTITY * MENU_QUANT.QUANTITY) QUAN_TO_DEDUCT 
				FROM MENU_INVENTORY MI
				INNER JOIN 
					(
						-- Get Their Menu IDS From Invoices
						SELECT OD.MENU_ID, OD.QUANTITY FROM ORDER_DETAILS OD
						WHERE OD.INVOICE_ID IN 
						(
						-- Get Invoices where inv_deducted is still 0
							SELECT I.ID FROM INVOICES I
							INNER JOIN TERMINAL T
								ON T.ID = I.TERMINAL_ID
							INNER JOIN INVOICES_ORDERS OI 
								ON OI.INVOICE_ID = I.ID
							INNER JOIN ORDERS O
								ON O.ID = OI.ORDER_ID
							WHERE O.INV_DEDUCTED = 0
								-- AND O.REST_ID = 1
						) 
					) MENU_QUANT
					ON MENU_QUANT.MENU_ID = MI.MENU_ID
				GROUP BY MI.INVENTORY_ID
				)INV_QUANT;"); 
      return $query->result();
    } 
    
    function get_active_rest(){
      $query = $this->db->query("SELECT ID FROM RESTAURANTS WHERE ACTIVE = 1;"); 
      return $query->result();
    } 
    
    function update_quantity_from_orders($rid,$uid=2){
      $query = $this->db->query("UPDATE INVENTORY 
    		SET QUANTITY = (
    			SELECT 
    			ROUND(IF ((QUANTITY < INV_QUANT.QUAN_TO_DEDUCT), 0, (QUANTITY - INV_QUANT.QUAN_TO_DEDUCT)), 2)
    			FROM
    				(
    				-- Get their Inventory ids from mapping
    				SELECT MI.INVENTORY_ID, SUM(MI.QUANTITY * MENU_QUANT.QUANTITY) QUAN_TO_DEDUCT 
    				FROM MENU_INVENTORY MI
    				INNER JOIN 
    					(
    						-- Get Their Menu IDS From Invoices
    						SELECT OD.MENU_ID, OD.QUANTITY FROM ORDER_DETAILS OD
    						WHERE OD.INVOICE_ID IN 
    						(
    						-- Get Invoices where inv_deducted is still 0
    							SELECT I.ID FROM INVOICES I
    							INNER JOIN TERMINAL T
    								ON T.ID = I.TERMINAL_ID
    							INNER JOIN INVOICES_ORDERS OI 
    								ON OI.INVOICE_ID = I.ID
    							INNER JOIN ORDERS O
    								ON O.ID = OI.ORDER_ID
    							WHERE O.INV_DEDUCTED = 0
    								AND O.REST_ID = ".$rid."
    						) 
    					) MENU_QUANT
    					ON MENU_QUANT.MENU_ID = MI.MENU_ID
    				GROUP BY MI.INVENTORY_ID
    				)INV_QUANT
    		WHERE INV_QUANT.INVENTORY_ID = INVENTORY.ID
    		),
        LAST_UPDATED_BY = ".$uid.",
        LAST_UPDATED_DATE = NOW() 
    		WHERE INVENTORY.ID IN
                (
    				-- Get their Inventory ids from mapping
    				SELECT MI.INVENTORY_ID
    				FROM MENU_INVENTORY MI
    				INNER JOIN 
    					(
    						-- Get Their Menu IDS From Invoices
    						SELECT OD.MENU_ID, OD.QUANTITY FROM ORDER_DETAILS OD
    						WHERE OD.INVOICE_ID IN 
    						(
    						-- Get Invoices where inv_deducted is still 0
    							SELECT I.ID FROM INVOICES I
    							INNER JOIN TERMINAL T
    								ON T.ID = I.TERMINAL_ID
    							INNER JOIN INVOICES_ORDERS OI 
    								ON OI.INVOICE_ID = I.ID
    							INNER JOIN ORDERS O
    								ON O.ID = OI.ORDER_ID
    							WHERE O.INV_DEDUCTED = 0 
    								AND O.REST_ID = ".$rid."
    						) 
    					) MENU_QUANT
    					ON MENU_QUANT.MENU_ID = MI.MENU_ID
    				GROUP BY MI.INVENTORY_ID
    		);"); 
    }   
  
  function update_deducted($uid,$rid){ 
	  date_default_timezone_set('Asia/Jakarta');
		$id = $uid; 
		$dt = date('Y-m-d H:i:s');
	  $data = array(
               'INV_DEDUCTED' => 1,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt
            ); 
		$this->db->where('INV_DEDUCTED',0);
		$this->db->where('REST_ID',$rid);
    $query = $this->db->update('ORDERS',$data);
	}
    
	function update_quantity($uid,$iid,$qty){ 
	  date_default_timezone_set('Asia/Jakarta');
		$id = $uid; 
		$dt = date('Y-m-d H:i:s');
	  $data = array(
               'QUANTITY' => $qty,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt
            ); 
		$this->db->where('ID',$iid);
    $query = $this->db->update('INVENTORY',$data);
	}
        
}