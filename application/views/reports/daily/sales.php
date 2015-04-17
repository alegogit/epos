<?php
  $this->load->view('shared/notopbar_header',$this->data);   //var_dump($recon);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:50%;">  
           
    <div class="row" style="text-align:center;">  
        <h4>
          <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <br><?=$restname->REST_NAME?> 
        </h4>
    </div>
    
    <hr style="margin-bottom:10px;margin-top:10px" />
        
	  <div class="panel panel-default">
		    <div class="panel-heading" style="font-size:110% !important;">
          <div class="row" style="vertical-align:bottom !important;"> 
          <table width="100%"><tr> 
            <td>
              <b>&nbsp;&nbsp;&nbsp;Daily Sales Report</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$enddate?></b>
            </td>
          </tr></table>
          </div>  
        </div>
	      <div class="panel-body table-responsive"> 
        
          <div class="row">
          <table width="100%">
            <tr style="width:100%;vertical-align:top;">
              <td>
            <div class="col-sm-3">
              <b>REVENUE</b>
              
              <table width="100%" class="table" style="border-bottom:black 3px solid;">
                <tbody>
                  <tr>
                    <td class="text3D">Subtotal</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->SUBTOTAL+0?></td> 
                  </tr>  
                  <tr class="text-danger">
                    <td class="text3D">Discount</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=(($revenue->DISCOUNT+0)*-1)?></td> 
                  </tr>  
                  <tr class="info" style="border-top:black 2px solid;">
                    <th class="text3D">NET SALES</th>
                    <th class="cin text3D"><?=$cur?></th>
                    <th class="cin cur text3D"><?=$revenue->NET_SALES+0?></th>
                  </tr>  
                  <tr>
                    <td class="text3D">Service Charge</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->SERVICE_CHARGE+0?></td> 
                  </tr>  
                  <tr class="">
                    <td class="text3D">Tax</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->TOTAL_TAX+0?></td> 
                  </tr>  
                  <tr class="">
                    <td class="text3D">Tip</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->TIP+0?></td> 
                  </tr>  
                  <tr class="">
                    <td class="text3D">Rounding</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin cur text3D"><?=$revenue->ROUNDING+0?></td> 
                  </tr>  
                  <tr class="info" style="border-top:black 2px solid;">
                    <th class="text3D">TOTAL SALES</th>
                    <th class="cin text3D"><?=$cur?></th>
                    <th class="cin cur text3D"><?=$revenue->TOTAL_SALES?></th>
                  </tr>  
                </tbody>
                <tfoot> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin cur text3D"></th>
                  </tr>  
                </tfoot>
              </table> 
              
              <b>SUMMARY</b>
              
              <table width="100%" class="table">  
                <thead> 
                  <tr>
                    <th class="text3D" colspan="2"><h4>Total Sales : <?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->TOTAL_SALES),$cur)?></h4></th>
                  </tr> 
                  <tr>
                    <th class="text3D">Total Customers</th>
                    <th class="text3D">Average Amount Per Customer</th>
                  </tr>   
                </thead>
                <tbody>
                  <tr class="info">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$summary->TOTAL_CUSTOMERS+0?></td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_CUST+0),$cur)?></td>
                  </tr> 
                </tbody>
              </table>
              
              <table width="100%" class="table">  
                <thead> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="text3D"></th>
                  </tr>   
                  <tr>
                    <th class="text3D">Total Invoices</th>
                    <th class="text3D">Average Amount Per Invoice</th>
                  </tr>   
                </thead>
                <tbody>
                  <tr class="info">
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$summary->TOTAL_INVOICE+0?></td>
                    <td class="text3D" style="font-weight:bold;font-size:125%;text-align:center"><?=$cur?> <?=$this->currency->format($this->currency->my_number_format((float)$summary->AVG_SALES_PER_INVOICE+0),$cur)?></td>
                  </tr> 
                </tbody>
                <tfoot> 
                  <tr>
                    <th class="text3D"></th>
                    <th class="cin text3D"></th>
                  </tr>  
                </tfoot>
              </table>
              
            </div> 
            
              </td>
              <td>
              
            <div class="col-sm-5">
              <b>PAYMENT TYPE</b>   
              
              <table width="100%" class="table" style="border-bottom:black 3px solid;">
                <tbody>
                  <tr>
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin text3D">%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL'] = 0;
                    $tot['AMOUNT'] = 0;
                    foreach($payment as $rowt){
                      $tot['TOTAL'] = $tot['TOTAL'] + $rowt->TOTAL;  
                      $tot['AMOUNT'] = $tot['AMOUNT'] + $rowt->AMOUNT;  
                    }
                    foreach($payment as $row){
                  ?>  
                  <tr>
                    <td class="cin text3D" style="border-right:black 2px solid;"><?=$row->PAYMENT_METHOD?></td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', '')?> %</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?> 
                </tbody>
                <tfoot> 
                  <tr style="border-top:black 2px solid;">
                    <th class="cin text3D" style="border-right:black 2px solid;">TOTAL</th>
                    <th class="cin text3D info"><?=$tot['TOTAL']?></th>
                    <th class="cin cur text3D info"><?=$tot['AMOUNT']?></th>
                    <th class="cin text3D info">100 %</th>
                  </tr>  
                  <tr>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                  </tr>  
                </tfoot>
              </table> 
              
              <b>SALES TYPE</b>   
              
              <table width="100%" class="table" style="border-bottom:black 3px solid;">
                <tbody>
                  <tr>
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
                  <tr>
                    <td class="cin text3D" style="border-right:black 2px solid;"><?=$row->ORDER_TYPE?></td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', '')?> %</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?> 
                </tbody>
                <tfoot> 
                  <tr style="border-top:black 2px solid;">
                    <th class="cin text3D" style="border-right:black 2px solid;">TOTAL</th>
                    <th class="cin text3D info"><?=$tot['TOTAL']?></th>
                    <th class="cin cur text3D info"><?=$tot['AMOUNT']?></th>
                    <th class="cin text3D info">100 %</th>
                  </tr>  
                  <tr>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                  </tr>  
                </tfoot>
              </table>  
              
              <b>TOP CATEGORY BY SALES</b>   
              
              <table width="100%" class="table">
                <tbody>
                  <tr>
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D">#</td>
                    <td class="cin text3D"><?=$cur?></td>
                    <td class="cin text3D">%</td> 
                  </tr>
                  <?php
                    $i = 0;
                    $tot['TOTAL'] = $adjust->TOTAL+0;
                    $tot['AMOUNT'] = $adjust->AMOUNT+0;
                    foreach($topcat as $rowt){
                      $tot['TOTAL'] = $tot['TOTAL'] + $rowt->TOTAL;  
                      $tot['AMOUNT'] = $tot['AMOUNT'] + $rowt->AMOUNT;  
                    }
                    foreach($topcat as $row){
                      if($row->CAT_NAME=="others"){
                  ?> 
                  <tr>
                    <td class="cin text3D" style="border-right:black 2px solid;"></td>
                    <td class="cin text3D"></td>
                    <td class="cin cur text3D"></td>
                    <td class="cin text3D"></td> 
                  </tr> 
                  <tr>
                    <td class="text3D" style="border-right:black 2px solid;"><?=$adjust->CAT_NAME?></td>
                    <td class="cin text3D"><?=$adjust->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$adjust->AMOUNT+0?></td>
                    <td class="cin text3D"><?=$this->currency->my_number_format((float)(($adjust->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', '')?> %</td> 
                  </tr>                
                  <?php
                      }
                  ?> 
                  <tr>
                    <td class="text3D" style="border-right:black 2px solid;"><?=$row->CAT_NAME?></td>
                    <td class="cin text3D"><?=$row->TOTAL+0?></td>
                    <td class="cin cur text3D"><?=$row->AMOUNT+0?></td>
                    <td class="cin text3D"><?=$this->currency->my_number_format((float)(($row->AMOUNT+0)*100/$tot['AMOUNT']), 0, '.', '')?> %</td> 
                  </tr> 
                  <?php
                      $i++;
                    }
                  ?> 
                </tbody>
                <tfoot> 
                  <tr style="border-top:black 2px solid;">
                    <th class="cin text3D" style="border-right:black 2px solid;">TOTAL</th>
                    <th class="cin text3D info"><?=$tot['TOTAL']?></th>
                    <th class="cin cur text3D info"><?=$tot['AMOUNT']?></th>
                    <th class="cin text3D info">100 %</th>
                  </tr>  
                  <tr>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                    <th class="cin text3D"></th>
                  </tr>  
                </tfoot>
              </table> 
              
            </div> 
            
              </td>
              <td>
              
            <div class="col-sm-4">
              <b>VOID ITEM LIST</b>   
              
              <table width="100%" class="table"> 
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
            </div>  
             
              </td>
            </tr>
          </table>
          </div><!-- /.row -->
			  
        </div>
			</div>
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