<?php 
    //passed vars
    $startdate = date('Y-m-d', strtotime($_GET['startdate'])); 
    $enddate = date('Y-m-d', strtotime($_GET['enddate']));     
                                                          
    $filename = $startdate."_-_".$enddate."_".trim($this->extracts->get_restaurant_name($_GET['rest_id']))."_data.xls";
    
    //activate worksheet number 1
    $this->excel->setActiveSheetIndex(0);
    
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle('test worksheet');
    
    //default border
    $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
                  'color'   => array(
                      'rgb'     => 'DDDDDD'
                  )
          )
      ),
      
      'font'  => array(
          'name'  => 'Verdana', 
          'size'  => 9,              
          'color' => array(
              'rgb'   => '333333'
          )
      )
    );
    $this->excel->getDefaultStyle()->applyFromArray($styleArray);
        
    //set cell A1 content with some text
    //$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
    //merge cell A1 until D1
    //$this->excel->getActiveSheet()->mergeCells('A1:D1');
    //set aligment to center for that merged cell (A1 to D1)
    //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
    header("Content-type: application/octet-stream");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=".$filename);
    header("Pragma: no-cache");
    header("Expires: 0");
    $result = $this->extracts->get_orders_data($startdate,$enddate,$_GET['rest_id']); 
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
     $head_field = explode('|',$result[0]);
    //var_dump($head_field);
    
    //header      
    $a = "A";      
    for($i=1;$i<count($head_field);$i++){    
      //change the font size
      $this->excel->getActiveSheet()->getStyle($a."1")->getFont()->setSize(10);
      //make the font become bold
      $this->excel->getActiveSheet()->getStyle($a."1")->getFont()->setBold(true);
      //fill the header
      $this->excel->getActiveSheet()->setCellValue($a."1", $head_field[$i-1]);  
      //autosize
      $this->excel->getActiveSheet()->getColumnDimension($a)->setAutoSize(true); 
      //set bgcolor
      $this->excel->getActiveSheet()->getStyle($a."1")->getFill()
        ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'F5F5F5')
        ));
      $a++;
    }
    
    //$eek=array();$eek=$result[5]; var_dump($eek);
    
    $a = "A";         
    foreach($result[5] as $row){
      //$k = $row->MENU_NAME;   
      $j=2;    
      for($i=0;$i<count($row);$i++){
        $this->excel->getActiveSheet()->setCellValue($a.$j, $row[$i]);
        //print $a.($j).":".$row[$i]."<br>"; 
        if($j%2!=0){
          $this->excel->getActiveSheet()->getStyle($a.$j)->getFill()
            ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
              'startcolor' => array('rgb' => 'F9F9F9')
            ));
          }
        $j++;   
      } 
      //autosize
      $this->excel->getActiveSheet()->getColumnDimension($a)->setAutoSize(true);       
      $a++;
      //print "<br>";
    }
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
    //print $this->extracts->get_orders_data(date('Y-m-d', strtotime($_GET['startdate'])),date('Y-m-d', strtotime($_GET['enddate'])),$_GET['rest_id']); 
?>