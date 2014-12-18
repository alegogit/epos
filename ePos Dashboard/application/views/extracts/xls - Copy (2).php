<?php  
                                                          
    $filename = date("Y-m-d")."_".trim($this->extracts->get_restaurant_name($rest_id))."_data.xls";
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('test worksheet');
    //set cell A1 content with some text
    //$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
    //change the font size
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    //make the font become bold
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    //merge cell A1 until D1
    //$this->excel->getActiveSheet()->mergeCells('A1:D1');
    //set aligment to center for that merged cell (A1 to D1)
    //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
    //header("Content-type: application/octet-stream");
    //header("Content-type: application/vnd.ms-excel");
    //header("Content-Disposition: attachment; filename=".$filename);
    //header("Pragma: no-cache");
    //header("Expires: 0");
    $result = $this->extracts->get_orders_data(date('Y-m-d', strtotime($_GET['startdate'])),date('Y-m-d', strtotime($_GET['enddate'])),$_GET['rest_id']); 
    $output = $result[0]."\n";
    foreach($result[2] as $row){
      $output .= $row->ORDER_NUMBER."\t".$row->MENU_NAME."\t".$row->PRICE."\t";
      $output .= $row->QUANTITY."\t".$row->KITCHEN_NOTE."\t".$row->ITEM_VOID."\t".$row->ITEM_VOID_REASON."\t".$row->CUSTOMER_NAME."\t".$row->STARTED."\t".$row->ENDED."\t";
      $output .= $row->NO_OF_GUEST."\t".$row->TOTAL_AMOUNT."\t".$row->PAID_AMOUNT."\t".$row->CURRENCY."\t".$row->PAYMENT_METHOD."\t".$row->TIP."\t".$row->DISCOUNT."\t";
      $output .= $row->ORDER_VOID."\t".$row->ORDER_VOID_REASON."\t".$row->RESTAURANT_NAME."\t".$row->ORDER_CREATED_DATE."\t".$row->ORDER_LAST_UPDATED_DATE."\t".$row->ORDER_LAST_UPDATED_BY."\t";
      $output .= "\n";
    }
    //print $output;
    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $a = "A";
    $i = 1;         
    $head_field = explode('|',$result[0]);
    var_dump($head_field);
    foreach($head_field as $row){        
      $this->excel->getActiveSheet()->setCellValue($a.$i, $row[$i]);
      $a++; $i++;
      print $a.$i."/n";
    }
    //$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    //force user to download the Excel file without writing it to server's HD
    //$objWriter->save('php://output');
    //print $this->extracts->get_orders_data(date('Y-m-d', strtotime($_GET['startdate'])),date('Y-m-d', strtotime($_GET['enddate'])),$_GET['rest_id']); 
?>