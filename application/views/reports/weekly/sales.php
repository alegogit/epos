<?php
  $this->load->view('shared/notopbar_header',$this->data);   //var_dump($recon);
?>
<div id="page-content-wrapper" style="margin-top:-10px;">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:69%;letter-spacing:1px;">  
    <div class="row" style="vertical-align:bottom !important;">
    <table width="100%">
      <tr>
        <td width="30%"> 
          &nbsp;&nbsp;&nbsp;&nbsp;<img class="img-thumbnail" style="width:63px; height:63px;" src="<?=$reslogo?>"/>
        </td>  
        <td width="40%" style="text-align:center;">
          <span style="font-weight:bold;font-size:200%;"> 
            <b>WEEKLY<br>SALES REPORT</b>
          </span>
        </td>  
        <td width="30%" style="text-align:right;">      
          <span style="font-weight:bold;font-size:175%;"><b><?=$dayname.", ".$enddate?></b>&nbsp;&nbsp;&nbsp;</span><br>
          <span style="font-weight:bold;font-size:125%;"><b><?=$restname->REST_NAME?></b>&nbsp;&nbsp;&nbsp;</span> 
        </td>
      </tr>
    </table> 
    </div>
    <hr style="margin-bottom:10px;margin-top:10px;border-top:black 2px solid;" />
    <div class="row">
      <table width="100%">
        <tr style="width:100%;vertical-align:top;">
          <td style="border-right:#3071a9 2px solid;">
            <div class="col-sm-3">
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">REVENUE</span>
              
              <table width="100%" class="table nb" style="border-bottom:#3071a9 3px solid;">
                <tbody>    
                  <tr style="font-weight:bold;">
                    <td class="text3D"></td>     
                    <td class="text3D"></td>
                    <td class="mid text3D"><b>This Week</b></td>  
                    <td class="text3D"></td>
                    <td class="mid text3D" style="border-right:black 2px dotted !important;"><b>Last Week</b></td> 
                    <td class="mid text3D"colspan ="2"><b>&Delta;%</b></td> 
                  </tr>  
                  <tr>
                    <td class="text3D">Subtotal</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->TOTAL_THIS_WEEK+0?></td>  
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->TOTAL_LAST_WEEK+0?></td>   
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->TOTAL_THIS_WEEK+0),($revenue->TOTAL_LAST_WEEK+0))?></td>      
                    <td class="text3D">%</td>
                  </tr> 
                  <tr class="text-danger">
                    <td class="text3D">Discount</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=(($revenue->DISCOUNT_THIS_WEEK+0)*-1)?></td> 
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=(($revenue->DISCOUNT_LAST_WEEK+0)*-1)?></td> 
                    <td class="cin cur text3D"><?=$this->currency->diffpercent((($revenue->DISCOUNT_THIS_WEEK+0)*-1),(($revenue->DISCOUNT_LAST_WEEK+0)*-1))?></td>      
                    <td class="text3D">%</td>
                  </tr>  
                  <tr class="info" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="text3D">NET SALES</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->NET_SALES_THIS_WEEK+0?></td> 
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->NET_SALES_LAST_WEEK+0?></td> 
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->NET_SALES_THIS_WEEK+0),($revenue->NET_SALES_LAST_WEEK+0))?></td>     
                    <td class="text3D">%</td>
                  </tr>  
                  <tr>
                    <td class="text3D"></td>
                    <td class="cin text3D"></td>
                    <td class="cin cur text3D"></td> 
                    <td class="cin cur text3D"></td> 
                    <td class="cin cur text3D"></td> 
                    <td class="cin cur text3D"></td>     
                    <td class="text3D"></td> 
                  </tr>   
                  <tr>
                    <td class="text3D">Service Charge</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->SERVICE_CHARGE_THIS_WEEK+0?></td> 
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->SERVICE_CHARGE_LAST_WEEK+0?></td> 
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->SERVICE_CHARGE_THIS_WEEK+0),($revenue->SERVICE_CHARGE_LAST_WEEK+0))?></td>      
                    <td class="text3D">%</td>
                  </tr>  
                  <tr class="">
                    <td class="text3D">Tax</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->TOTAL_TAX_THIS_WEEK+0?></td>
                    <td class="cin text3D"><?=$cur?></td> 
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->TOTAL_TAX_LAST_WEEK+0?></td>  
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->TOTAL_TAX_THIS_WEEK+0),($revenue->TOTAL_TAX_LAST_WEEK+0))?></td>     
                    <td class="text3D">%</td>
                  </tr>  
                  <tr class="">
                    <td class="text3D">Tip</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->TIP_THIS_WEEK+0?></td> 
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->TIP_LAST_WEEK+0?></td> 
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->TIP_THIS_WEEK+0),($revenue->TIP_LAST_WEEK+0))?></td>      
                    <td class="text3D">%</td>
                  </tr>  
                  <tr class="">
                    <td class="text3D">Rounding</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->ROUNDING_THIS_WEEK+0?></td>  
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->ROUNDING_LAST_WEEK+0?></td> 
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->ROUNDING_THIS_WEEK+0),($revenue->ROUNDING_LAST_WEEK+0))?></td>       
                    <td class="text3D">%</td>
                  </tr>  
                  <tr class="info" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="text3D">TOTAL SALES</td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$cur?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$revenue->TOTAL_SALES_THIS_WEEK?></td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$revenue->TOTAL_SALES_LAST_WEEK?></td>
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($revenue->TOTAL_SALES_THIS_WEEK+0),($revenue->TOTAL_SALES_LAST_WEEK+0))?></td>      
                    <td class="text3D">%</td>
                  </tr>  
                </tbody>
                <tfoot> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin cur text3D"></th>
                    <th class="cin cur text3D"></th>
                    <th class="cin cur text3D"></th>
                    <th class="cin cur text3D"></th>      
                    <th class="text3D"></th>
                  </tr>  
                <tfoot> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin cur text3D"></th>
                    <th class="cin cur text3D"></th> 
                    <th class="cin cur text3D"></th>
                    <th class="cin cur text3D"></th>      
                    <th class="text3D"></th>
                  </tr>  
                </tfoot>
              </table> 
              
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">SUMMARY</span>
              
              <table width="100%" class="table ah nb">  
                <thead> 
                  <tr>
                    <th class="text3D" colspan="5" style="text-align:center;font-size:150% !important;"><b>Total Sales : <?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->TOTAL_SALES_THIS_WEEK),$cur)?></b></th>
                  </tr> 
                  <tr style="font-weight:bold;">
                    <th class="text3D" style="text-align:center"><b></b></th>
                    <th class="text3D" style="text-align:center"><b>This Week</b></th>
                    <th class="text3D" style="border-right:black 2px dotted !important;text-align:center"><b>Last Week</b></th>
                    <th class="text3D" style="text-align:center" colspan="2"><b>&Delta;%</b></th>
                  </tr>   
                </thead>
                <tbody>
                  <tr class="info">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center">Total Customers</td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$summary->TOTAL_CUSTOMERS_THIS_WEEK+0?></td> 
                    <td class="text3D" style="border-right:black 2px dotted !important;font-weight:normal;font-size:125%;text-align:center"><?=$summary->TOTAL_CUSTOMERS_LAST_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:normal;font-size:125%;"><?=$this->currency->diffpercent(($summary->TOTAL_CUSTOMERS_THIS_WEEK+0),($summary->TOTAL_CUSTOMERS_LAST_WEEK+0))?></td> 
                    <td class="text3D" style="font-weight:normal;font-size:125%;">%</td>
                  </tr> 
                  <tr class="">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center">Average Amount<br>Per Customer</td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_CUST_THIS_WEEK+0),$cur)?></td>
                    <td class="text3D" style="border-right:black 2px dotted !important;font-weight:normal;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_CUST_LAST_WEEK+0),$cur)?></td> 
                    <td class="cin cur text3D" style="font-weight:normal;font-size:125%;"><?=$this->currency->diffpercent(($summary->AVG_SALES_PER_CUST_THIS_WEEK+0),($summary->AVG_SALES_PER_CUST_LAST_WEEK+0))?></td> 
                    <td class="text3D" style="font-weight:normal;font-size:125%;">%</td>
                  </tr> 
                  <tr class="info">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center">Total Invoices</td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$summary->TOTAL_INVOICE_THIS_WEEK+0?></td> 
                    <td class="text3D" style="border-right:black 2px dotted !important;font-weight:normal;font-size:125%;text-align:center"><?=$summary->TOTAL_INVOICE_LAST_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:normal;font-size:125%;"><?=$this->currency->diffpercent(($summary->TOTAL_INVOICE_THIS_WEEK+0),($summary->TOTAL_INVOICE_LAST_WEEK+0))?></td>
                    <td class="text3D" style="font-weight:normal;font-size:125%;">%</td>
                  </tr> 
                  <tr class="" style="border-bottom: 2px solid #ddd;">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center">Average Amount<br>Per Invoice</td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_INVOICE_THIS_WEEK+0),$cur)?></td>
                    <td class="text3D" style="border-right:black 2px dotted !important;font-weight:normal;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_INVOICE_LAST_WEEK+0),$cur)?></td> 
                    <td class="cin cur text3D" style="font-weight:normal;font-size:125%;"><?=$this->currency->diffpercent(($summary->AVG_SALES_PER_INVOICE_THIS_WEEK+0),($summary->AVG_SALES_PER_INVOICE_LAST_WEEK+0))?></td> 
                    <td class="text3D" style="font-weight:normal;font-size:125%;">%</td>
                  </tr> 
                </tbody>
              </table>
              
            </div> 
            
              </td>
              <td>
              
            <div class="col-sm-5">
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">PAYMENT TYPE</span>   
              
              <table width="100%" class="table ah nb">
                <tbody>
                  <tr class="" style="font-weight:bold;">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="text3D" colspan="4" style="border-right:black 2px dotted !important; text-align:center;">This Week</td> 
                    <td class="text3D" colspan="4" style="border-right:black 2px dotted !important; text-align:center;">Last Week</td> 
                    <td class="cin text3D" colspan="2"></td> 
                  </tr>
                  <tr class="" style="font-weight:bold;">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="mid text3D"><?=$cur?></td>
                    <td class="mid text3D" colspan="2" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin text3D">#</td>
                    <td class="mid text3D"><?=$cur?></td>
                    <td class="mid text3D" colspan="2" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="mid text3D" colspan="2">&Delta;%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL_THIS_WEEK'] = 0;
                    $tot['TOTAL_LAST_WEEK'] = 0;
                    $tot['AMOUNT_THIS_WEEK'] = 0;
                    $tot['AMOUNT_LAST_WEEK'] = 0;
                    $n = count($payment);
                    foreach($payment as $rowt){
                      $tot['TOTAL_THIS_WEEK'] = $tot['TOTAL_THIS_WEEK'] + $rowt->TOTAL_THIS_WEEK;
                      $tot['TOTAL_LAST_WEEK'] = $tot['TOTAL_LAST_WEEK'] + $rowt->TOTAL_LAST_WEEK;  
                      $tot['AMOUNT_THIS_WEEK'] = $tot['AMOUNT_THIS_WEEK'] + $rowt->AMOUNT_THIS_WEEK;  
                      $tot['AMOUNT_LAST_WEEK'] = $tot['AMOUNT_LAST_WEEK'] + $rowt->AMOUNT_LAST_WEEK;  
                    }
                    foreach($payment as $row){
                  ?>  
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"><?=$row->PAYMENT_METHOD?></td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$row->TOTAL_THIS_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$row->AMOUNT_THIS_WEEK+0?></td>
                    <td class="cin text3D" style="font-weight:bold;"><?=($tot['AMOUNT_THIS_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_THIS_WEEK+0)*100/$tot['AMOUNT_THIS_WEEK']), 0, '.', ''):0?></td>
                    <td class="text3D" style="font-weight:bold;border-right:black 2px dotted !important;">%</td>  
                    <td class="cin text3D"><?=$row->TOTAL_LAST_WEEK+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT_LAST_WEEK+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT_LAST_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_LAST_WEEK+0)*100/$tot['AMOUNT_LAST_WEEK']), 0, '.', ''):0?></td>
                    <td class="text3D" style="border-right:black 2px dotted !important;">%</td>  
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($row->AMOUNT_THIS_WEEK+0),($row->AMOUNT_LAST_WEEK+0))?></td> 
                    <td>%</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?>    
                  <tr class="" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="cin text3D" style="font-weight:bold;border-right:black 2px solid;">TOTAL</td>
                    <td class="cin text3D info" style="font-weight:bold;"><?=$tot['TOTAL_THIS_WEEK']?></td>
                    <td class="cin cur text3D info" style="font-weight:bold;"><?=$tot['AMOUNT_THIS_WEEK']?></td>
                    <td class="cin text3D info" style="font-weight:bold;"><?=($tot['AMOUNT_THIS_WEEK']!=0)?100:0?></td> 
                    <td class="text3D info" style="font-weight:bold;border-right:black 2px dotted !important;">%</td> 
                    <td class="cin text3D info"><?=$tot['TOTAL_LAST_WEEK']?></td>
                    <td class="cin cur text3D info"><?=$tot['AMOUNT_LAST_WEEK']?></td>
                    <td class="cin text3D info"><?=($tot['AMOUNT_LAST_WEEK']!=0)?100:0?></td> 
                    <td class="text3D info" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin cur text3D info"><?=$this->currency->diffpercent(($tot['AMOUNT_THIS_WEEK']+0),($tot['AMOUNT_LAST_WEEK']+0))?></td>
                    <td class="text3D info">%</td> 
                  </tr>     
                  <tr style="border-bottom:#3071a9 3px solid;">
                    <td colspan="11">
                    </td>
                  </tr>      
                  <tr>
                    <td colspan="11">
                      <span style="font-weight:bold;font-size:150%;color:#3071a9;">SALES TYPE</span>
                    </td>
                  </tr>
                  <tr class="">
                    <td class="cin text3D" colspan="11"></td>
                  </tr>       
                  <tr class="" style="font-weight:bold;">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="text3D" colspan="4" style="border-right:black 2px dotted !important; text-align:center;">This Week</td> 
                    <td class="text3D" colspan="4" style="border-right:black 2px dotted !important; text-align:center;">Last Week</td> 
                    <td class="cin text3D" colspan="2"></td> 
                  </tr>
                  <tr class="" style="font-weight:bold;">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="mid text3D"><?=$cur?></td>
                    <td class="mid text3D" colspan="2" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin text3D">#</td>
                    <td class="mid text3D"><?=$cur?></td>
                    <td class="mid text3D" colspan="2" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="mid text3D" colspan="2">&Delta;%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL_THIS_WEEK'] = 0;
                    $tot['TOTAL_LAST_WEEK'] = 0;  
                    $tot['AMOUNT_THIS_WEEK'] = 0;
                    $tot['AMOUNT_LAST_WEEK'] = 0;
                    foreach($ordtype as $rowt){
                      $tot['TOTAL_THIS_WEEK'] = $tot['TOTAL_THIS_WEEK'] + $rowt->TOTAL_THIS_WEEK; 
                      $tot['TOTAL_LAST_WEEK'] = $tot['TOTAL_LAST_WEEK'] + $rowt->TOTAL_LAST_WEEK;   
                      $tot['AMOUNT_THIS_WEEK'] = $tot['AMOUNT_THIS_WEEK'] + $rowt->AMOUNT_THIS_WEEK;  
                      $tot['AMOUNT_LAST_WEEK'] = $tot['AMOUNT_LAST_WEEK'] + $rowt->AMOUNT_LAST_WEEK; 
                    }
                    foreach($ordtype as $row){
                  ?>  
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"><?=$row->ORDER_TYPE?></td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$row->TOTAL_THIS_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$row->AMOUNT_THIS_WEEK+0?></td>
                    <td class="cin text3D" style="font-weight:bold;"><?=($tot['AMOUNT_THIS_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_THIS_WEEK+0)*100/$tot['AMOUNT_THIS_WEEK']), 0, '.', ''):0?></td>
                    <td class="text3D" style="font-weight:bold;border-right:black 2px dotted !important;">%</td>  
                    <td class="cin text3D"><?=$row->TOTAL_LAST_WEEK+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT_LAST_WEEK+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT_LAST_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_LAST_WEEK+0)*100/$tot['AMOUNT_LAST_WEEK']), 0, '.', ''):0?></td>
                    <td class="text3D" style="border-right:black 2px dotted !important;">%</td>  
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($row->AMOUNT_THIS_WEEK+0),($row->AMOUNT_LAST_WEEK+0))?></td> 
                    <td>%</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?>    
                  <tr class="" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="cin text3D" style="border-right:black 2px solid;">TOTAL</td>
                    <td class="cin text3D info" style="font-weight:bold;"><?=$tot['TOTAL_THIS_WEEK']?></td>
                    <td class="cin cur text3D info" style="font-weight:bold;"><?=$tot['AMOUNT_THIS_WEEK']?></td>
                    <td class="cin text3D info" style="font-weight:bold;"><?=($tot['AMOUNT_THIS_WEEK']!=0)?100:0?></td> 
                    <td class="text3D info" style="font-weight:bold;border-right:black 2px dotted !important;">%</td> 
                    <td class="cin text3D info"><?=$tot['TOTAL_LAST_WEEK']?></td>
                    <td class="cin cur text3D info"><?=$tot['AMOUNT_LAST_WEEK']?></td>
                    <td class="cin text3D info"><?=($tot['AMOUNT_LAST_WEEK']!=0)?100:0?></td> 
                    <td class="text3D info" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin cur text3D info"><?=$this->currency->diffpercent(($tot['AMOUNT_THIS_WEEK']+0),($tot['AMOUNT_LAST_WEEK']+0))?></td>
                    <td class="text3D info">%</td> 
                  </tr>   
                  <tr style="border-bottom:#3071a9 3px solid;">
                    <td colspan="11">
                    </td>
                  </tr>            
                  <tr>
                    <td colspan="11">
                      <span style="font-weight:bold;font-size:150%;color:#3071a9;">TOP CATEGORY BY SALES</span>
                    </td>
                  </tr>  
                  <tr class="" style="font-weight:bold;">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="text3D" colspan="4" style="border-right:black 2px dotted !important; text-align:center;">This Week</td> 
                    <td class="text3D" colspan="4" style="border-right:black 2px dotted !important; text-align:center;">Last Week</td> 
                    <td class="cin text3D" colspan="2"></td> 
                  </tr>
                  <tr class="" style="font-weight:bold;">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="mid text3D"><?=$cur?></td>
                    <td class="mid text3D" colspan="2" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin text3D">#</td>
                    <td class="mid text3D"><?=$cur?></td>
                    <td class="mid text3D" colspan="2" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="mid text3D" colspan="2">&Delta;%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL_THIS_WEEK'] = $adjust->TOTAL_THIS_WEEK+0;
                    $tot['TOTAL_LAST_WEEK'] = $adjust->TOTAL_LAST_WEEK+0; 
                    $tot['AMOUNT_THIS_WEEK'] = 0;
                    $tot['AMOUNT_LAST_WEEK'] = 0;
                    foreach($topcat as $rowt){
                      $tot['TOTAL_THIS_WEEK'] = $tot['TOTAL_THIS_WEEK'] + $rowt->TOTAL_THIS_WEEK;
                      $tot['TOTAL_LAST_WEEK'] = $tot['TOTAL_LAST_WEEK'] + $rowt->TOTAL_LAST_WEEK;    
                      $tot['AMOUNT_THIS_WEEK'] = $tot['AMOUNT_THIS_WEEK'] + $rowt->AMOUNT_THIS_WEEK;  
                      $tot['AMOUNT_LAST_WEEK'] = $tot['AMOUNT_LAST_WEEK'] + $rowt->AMOUNT_LAST_WEEK; 
                    }
                    foreach($topcat as $row){
                      if(strtolower($row->CAT_NAME)=="others"){
                        $row->CAT_NAME = strtoupper($row->CAT_NAME);
                  ?> 
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D" colspan="7"></td>
                  </tr> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;"><?=strtoupper($adjust->CAT_NAME)?></td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$adjust->TOTAL_THIS_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$row->AMOUNT_THIS_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=($tot['AMOUNT_THIS_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_THIS_WEEK+0)*100/$tot['AMOUNT_THIS_WEEK']), 0, '.', ''):0?></td> 
                    <td class="text3D" style="font-weight:bold;border-right:black 2px dotted !important;">%</td>  
                    <td class="cin text3D"><?=$row->TOTAL_LAST_WEEK+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT_LAST_WEEK+0?></td>
                    <td class="cin cur text3D"><?=($tot['AMOUNT_LAST_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_LAST_WEEK+0)*100/$tot['AMOUNT_LAST_WEEK']), 0, '.', ''):0?></td> 
                    <td class="text3D" style="border-right:black 2px dotted !important;">%</td>  
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($tot['AMOUNT_THIS_WEEK']+0),($tot['AMOUNT_LAST_WEEK']+0))?></td>  
                    <td>%</td> 
                  </tr>                
                  <?php
                      }
                  ?> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;"><?=$row->CAT_NAME?></td>
                    <td class="cin text3D" style="font-weight:bold;"><?=$row->TOTAL_THIS_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=$row->AMOUNT_THIS_WEEK+0?></td>
                    <td class="cin cur text3D" style="font-weight:bold;"><?=($tot['AMOUNT_THIS_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_THIS_WEEK+0)*100/$tot['AMOUNT_THIS_WEEK']), 0, '.', ''):0?></td>  
                    <td class="text3D" style="font-weight:bold;border-right:black 2px dotted !important;">%</td>  
                    <td class="cin text3D"><?=$row->TOTAL_LAST_WEEK+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT_LAST_WEEK+0?></td>
                    <td class="cin cur text3D"><?=($tot['AMOUNT_LAST_WEEK']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT_LAST_WEEK+0)*100/$tot['AMOUNT_LAST_WEEK']), 0, '.', ''):0?></td> 
                    <td class="text3D" style="border-right:black 2px dotted !important;">%</td>  
                    <td class="cin cur text3D"><?=$this->currency->diffpercent(($tot['AMOUNT_THIS_WEEK']+0),($tot['AMOUNT_LAST_WEEK']+0))?></td>    
                    <td>%</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?>  
                  <tr class="" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="cin text3D" style="border-right:black 2px solid;">TOTAL</td>
                    <td class="cin text3D info"><?=$tot['TOTAL_THIS_WEEK']?></td>
                    <td class="cin cur text3D info"><?=$tot['AMOUNT_THIS_WEEK']?></td>
                    <td class="cin text3D info"><?=($tot['AMOUNT_THIS_WEEK']!=0)?100:0?></td> 
                    <td class="text3D info" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin text3D info"><?=$tot['TOTAL_LAST_WEEK']?></td>
                    <td class="cin cur text3D info"><?=$tot['AMOUNT_LAST_WEEK']?></td>
                    <td class="cin text3D info"><?=($tot['AMOUNT_LAST_WEEK']!=0)?100:0?></td> 
                    <td class="text3D info" style="border-right:black 2px dotted !important;">%</td> 
                    <td class="cin cur text3D info"><?=$this->currency->diffpercent(($tot['AMOUNT_THIS_WEEK']+0),($tot['AMOUNT_LAST_WEEK']+0))?></td>
                    <td class="text3D info">%</td> 
                  </tr>        
                </tbody> 
                <tfoot> 
                </tfoot>
              </table> 
              
            </div> 
            
              </td>
            </tr>
          </table>
          </div><!-- /.row -->
		</div>
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->
<div id="ajaxurl" data-url="<?=base_url()?>"></div>
<div id="cur" data-val="<?=$cur?>"></div>
<div id="rest_id" data-val="<?=$rest_id?>"></div>

<script type="text/javascript">      
  //datepickers    
  //$("#startdate").datepicker({format: 'dd M yyyy'});
  //$("#enddate").datepicker({format: 'dd M yyyy'});

   
  var ajaxurl = $("#ajaxurl").data('url');  
  var rest_id = $("#rest_id").data('val'); 
  
  var table1 = $('#sales').footable({
    paginate: true,
    pageSize: 50,
    pageNavigationSize: 8
  });
  
  
  //currency control
  jQuery(function($) {
    var cur = $("#cur").data('val');
    switch(cur) {
      case "RS":                  
        $('.cur').autoNumeric('init', { dGroup: 2, nBracket: '(,)', vMin: '-99999999.99' });
        break;
      case "RP":   
        $('.cur').autoNumeric('init', { aSep: '.', dGroup: 3, aDec: ',', aPad: false, nBracket: '(,)', vMin: '-99999999.99' });
        break;
      default: 
        $('.cur').autoNumeric('init', { nBracket: '(,)', vMin: '-99999999.99' });
        break;
    }     
  });
  
  $(function () {   
    $('#sales .table').footable().bind('footable_filtering', function (e) {
      var selected = $('.filter-status').find(':selected').text();
      if (selected && selected.length > 0) {
        e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
        e.clear = !e.filter;
      }
    });
  });
</script>         

<?php
  $this->load->view('shared/footer');
?>