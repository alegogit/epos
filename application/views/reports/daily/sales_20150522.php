<?php
  $this->load->view('shared/notopbar_header',$this->data);   //var_dump($recon);
?>
<div id="page-content-wrapper" style="margin-top:-10px;">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:72%;letter-spacing:1px;">  
    <div class="row" style="vertical-align:bottom !important;">
    <table width="100%">
      <tr>
        <td width="30%"> 
          &nbsp;&nbsp;&nbsp;&nbsp;<img class="img-thumbnail" style="width:63px; height:63px;" src="<?=$reslogo?>"/>
        </td>  
        <td width="40%" style="text-align:center;">
          <span style="font-weight:bold;font-size:200%;"> 
            <b>DAILY<br>SALES REPORT</b>
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
                  <tr>
                    <td class="text3D">Subtotal</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->SUBTOTAL+0?>&nbsp;&nbsp;</td> 
                  </tr>  
                  <tr class="text-danger">
                    <td class="text3D">Discount</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=(($revenue->DISCOUNT+0)*-1)?></td> 
                  </tr>  
                  <tr class="info" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="text3D">NET SALES</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->NET_SALES+0?>&nbsp;&nbsp;</td>
                  </tr>  
                  <tr>
                    <td class="text3D"></td>
                    <td class="cin text3D"></td>
                    <td class="cin cur text3D"></td> 
                  </tr>   
                  <tr>
                    <td class="text3D">Service Charge</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->SERVICE_CHARGE+0?>&nbsp;&nbsp;</td> 
                  </tr>  
                  <tr class="">
                    <td class="text3D">Tax</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->TOTAL_TAX+0?>&nbsp;&nbsp;</td> 
                  </tr>  
                  <tr class="">
                    <td class="text3D">Tip</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->TIP+0?>&nbsp;&nbsp;</td> 
                  </tr>  
                  <tr class="">
                    <td class="text3D">Rounding</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->ROUNDING+0?>&nbsp;&nbsp;</td> 
                  </tr>  
                  <tr class="info" style="font-weight:bold;border-top:black 2px solid;">
                    <td class="text3D">TOTAL SALES</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->TOTAL_SALES?>&nbsp;&nbsp;</td>
                  </tr>  
                </tbody>
                <tfoot> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin cur text3D"></th>
                  </tr>  
                <tfoot> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin cur text3D"></th>
                  </tr>  
                </tfoot>
              </table> 
              
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">SUMMARY</span>
              
              <table width="100%" class="table ah nb">  
                <thead> 
                  <tr>
                    <th class="text3D" colspan="2" style="text-align:center;font-size:150% !important;"><b>Total Sales : <?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->TOTAL_SALES),$cur)?></b></th>
                  </tr> 
                  <tr>
                    <th class="text3D" style="text-align:center">Total<br>Customers</th>
                    <th class="text3D" style="text-align:center">Average Amount<br>Per Customer</th>
                  </tr>   
                </thead>
                <tbody>
                  <tr class="info">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$summary->TOTAL_CUSTOMERS+0?></td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_CUST+0),$cur)?></td>
                  </tr> 
                </tbody>
              </table>
              
              <table width="100%" class="table ah nb">  
                <thead> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="text3D"></th>
                  </tr>   
                  <tr>
                    <th class="text3D" style="text-align:center">Total<br>Invoices</th>
                    <th class="text3D" style="text-align:center">Average Amount<br>Per Invoice</th>
                  </tr>   
                </thead>
                <tbody>
                  <tr class="info">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$summary->TOTAL_INVOICE+0?></td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_INVOICE+0),$cur)?></td>
                  </tr> 
                </tbody>
              </table>
              
            </div> 
            
              </td>
              <td style="border-right:#3071a9 2px solid;">
              
            <div class="col-sm-5">
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">PAYMENT TYPE</span>   
              
              <table width="100%" class="table ah nb" style="border-bottom:#3071a9 3px solid;">
                <tbody>
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin text3D">%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL'] = 0;
                    $tot['AMOUNT'] = 0;
                    $n = count($payment); 
                    if($n!=0){
                      $payment = $payment;
                    } else {     
                      $payment = $pmethod;
                    }
                    foreach($payment as $rowt){
                      $tot['TOTAL'] = $tot['TOTAL'] + $rowt->TOTAL;  
                      $tot['AMOUNT'] = $tot['AMOUNT'] + $rowt->AMOUNT;  
                    }
                    foreach($payment as $row){
                  ?>  
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"><?=$row->PAYMENT_METHOD?></td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', ''):0?> %</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?> 
                </tbody>
                <tfoot> 
                  <tr class="" style="border-top:black 2px solid;">
                    <th class="cin text3D" style="border-right:black 2px solid;">TOTAL</th>
                    <th class="cin text3D info"><?=$tot['TOTAL']?></th>
                    <th class="cin cur text3D info"><?=$tot['AMOUNT']?></th>
                    <th class="cin text3D info"><?=($tot['AMOUNT']!=0)?100:0?> %</th>
                  </tr>  
                  <tr class="">
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                  </tr>  
                </tfoot>
              </table> 
              
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">SALES TYPE</span>   
              
              <table width="100%" class="table ah nb" style="border-bottom:#3071a9 3px solid;">
                <tbody>
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin text3D">%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL'] = 0;
                    $tot['AMOUNT'] = 0; 
                    foreach($ordtype as $rowt){
                      $tot['TOTAL'] = $tot['TOTAL'] + $rowt->TOTAL;  
                      $tot['AMOUNT'] = $tot['AMOUNT'] + $rowt->AMOUNT;  
                    }
                    foreach($ordtype as $row){
                  ?>  
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"><?=$row->ORDER_TYPE?></td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', ''):0?> %</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?> 
                </tbody>
                <tfoot> 
                  <tr class="" style="border-top:black 2px solid;">
                    <th class="cin text3D" style="border-right:black 2px solid;">TOTAL</th>
                    <th class="cin text3D info"><?=$tot['TOTAL']?></th>
                    <th class="cin cur text3D info"><?=$tot['AMOUNT']?></th>
                    <th class="cin text3D info"><?=($tot['AMOUNT']!=0)?100:0?> %</th>
                  </tr>  
                  <tr class="">
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                  </tr>  
                </tfoot>
              </table>  
              
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">TOP CATEGORY BY SALES</span>   
              
              <table width="100%" class="table ah nb">
                <tbody>
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin text3D">%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL'] = $adjust->TOTAL+0;
                    $tot['AMOUNT'] = $adjust->AMOUNT+0; 
                    if(count($topcat)!=0){
                      foreach($topcat as $rowt){
                        $tot['TOTAL'] = $tot['TOTAL'] + $rowt->TOTAL;  
                        $tot['AMOUNT'] = $tot['AMOUNT'] + $rowt->AMOUNT;  
                      }
                      foreach($topcat as $row){
                        if($row->CAT_NAME=="others"){     
                          $row->CAT_NAME = strtoupper($row->CAT_NAME);
                  ?> 
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D"></td>
                    <td class="cin cur text3D"></td>
                    <td class="cin text3D"></td> 
                  </tr> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;"><?=$adjust->CAT_NAME?></td>
                    <td class="cin text3D"><?=$adjust->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$adjust->AMOUNT+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT']!=0)?$this->currency->my_number_format((float)(($adjust->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', ''):0?> %</td> 
                  </tr>                
                  <?php
                        } 
                  ?> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;"><?=$row->CAT_NAME?></td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', ''):0?> %</td> 
                  </tr> 
                  <?php
                        $i++;
                      } 
                      if(count($topcat)<=5){
                  ?>   
                  <tr class="">
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D"></td>
                    <td class="cin cur text3D"></td>
                    <td class="cin text3D"></td> 
                  </tr> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;">ADJUSTMENTS</td>
                    <td class="cin text3D">0</td>
                    <td class="cin cur text3D">0</td>
                    <td class="cin text3D">0 %</td> 
                  </tr> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;">OTHERS</td>
                    <td class="cin text3D">0</td>
                    <td class="cin cur text3D">0</td>
                    <td class="cin text3D">0 %</td> 
                  </tr>   
                  <?php
                      }
                    } else {
                  ?> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;">ADJUSTMENTS</td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', ''):0?> %</td> 
                  </tr> 
                  <tr class="">
                    <td class="text3D" style="border-right:black 2px solid;">OTHERS</td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=($tot['AMOUNT']!=0)?$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', ''):0?> %</td> 
                  </tr>   
                  <?php
                    }
                  ?>
                </tbody>
                <tfoot> 
                  <tr class="" style="border-top:black 2px solid;">
                    <th class="cin text3D" style="border-right:black 2px solid;">TOTAL</th>
                    <th class="cin text3D info"><?=$tot['TOTAL']?></th>
                    <th class="cin cur text3D info"><?=$tot['AMOUNT']?></th>
                    <th class="cin text3D info"><?=($tot['AMOUNT']!=0)?100:0?> %</th>
                  </tr>  
                </tfoot>
              </table> 
              
            </div> 
            
              </td>
              <td>
              
            <div class="col-sm-4">
              <span style="font-weight:bold;font-size:150%;color:#3071a9;">VOID ITEM LIST</span>   
            <?php 
              if(count($voiditem)==0){
                echo '<br><div class="alert alert-danger" style="font-weight:bold;font-size:125%;">NO DATA</div>'; 
              } else { 
            ?>
              <table width="100%" class="table ah nb"> 
                <thead> 
                  <tr>
                    <th class="text3D">Menu Item</th>
                    <th class="cin text3D"><?=$cur?></th>  
                    <th class="cin text3D">#</th>
                  </tr> 
                </thead>
                <tbody>
                  <?php
                    $i = 0;
                    $tot['PRICE'] = 0;
                    $tot['QUANTITY'] = 0;
                    foreach($voiditem as $rowt){
                      $tot['PRICE'] = $tot['PRICE'] + $rowt->PRICE;  
                      $tot['QUANTITY'] = $tot['QUANTITY'] + $rowt->QUANTITY;  
                    }
                    foreach($voiditem as $row){
                  ?>  
                  <tr>
                    <td class="text3D"><?=$row->MENU_NAME?></td>
                    <td class="cin cur text3D"><?=$row->PRICE+0?></td>
                    <td class="cin text3D"><?=$row->QUANTITY+0?></td>
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?> 
                </tbody>
                <tfoot> 
                  <tr style="border-top:black 2px solid;">
                    <th class="cin text3D info">TOTAL</th>
                    <th class="cin cur text3D info"><?=$tot['PRICE']?></th>
                    <th class="cin text3D info"><?=$tot['QUANTITY']?></th>
                  </tr>  
                </tfoot>
              </table>
             <?php } ?> 
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