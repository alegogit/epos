<?php                                                        
    $filename = date("Y-m-d")."_".$rest_id."_data.xls";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$filename);
    header("Pragma: no-cache");
    header("Expires: 0");
    $result = $this->extracts->get_orders_data(date('Y-m-d', strtotime($_GET['startdate'])),date('Y-m-d', strtotime($_GET['enddate'])),$_GET['rest_id']); 
    $output = $result[0]."\n";
    foreach($result[2] as $row){
      $output .= $row->ORDER_NUMBER."\t".$row->MENU_NAME."\t".$row->PRICE."\t";
      $output .= $row->QUANTITY."\t".$row->KITCHEN_NOTE."\t".$row->ITEM_VOID."\t".$row->ITEM_VOID_REASON."\t".$row->CUSTOMER_NAME."\t".$row->STARTED."\t".$row->ENDED."\t";
      $output .= $row->NO_OF_GUEST."\t".$row->TOTAL_AMOUNT."\t".$row->PAID_AMOUNT."\t".$row->CURRENCY."\t".$row->PAYMENT_METHOD."\t".$row->TIP."\t".$row->DISCOUNT."\t";
      $output .= $row->ORDER_VOID."\t".$row->ORDER_VOID_REASON."\t".$row->RESTAURANT_NAME."\t".$row->ORDER_CREATED_DATE."\t".$row->ORDER_LAST_UPDATED_DATE."\t".$row->ORDER_LAST_UPDATED_BY."\t";
      $output .= "\n";
    }
    print $output;
    //print $this->extracts->get_orders_data(date('Y-m-d', strtotime($_GET['startdate'])),date('Y-m-d', strtotime($_GET['enddate'])),$_GET['rest_id']); 
?>