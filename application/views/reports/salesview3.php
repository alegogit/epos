<?php
  $this->load->view('shared/notopbar_header',$this->data);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
           
    <div class="row" style="text-align:center;">  
        <h4>
          <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <br><?=$restaurants->NAME?> 
        </h4>
    </div>
    
    <hr style="margin-bottom:10px;margin-top:10px" />
        
	  <div class="panel panel-default">
		    <div class="panel-heading" style="font-size:110% !important;">
          <div class="row" style="vertical-align:bottom !important;"> 
          <table width="100%"><tr> 
            <td>
              <b>&nbsp;&nbsp;&nbsp;<?=$report_name?> Report</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$startdate." - ".$enddate?></b>
            </td>
          </tr></table>
          </div>  
        </div>
	      <div class="panel-body table-responsive" style="font-size:80% !important;"> 
	         <table id="sales" class="table table-striped dt-right table-hover table-condensed" data-filter="#sfilter" data-filter-text-only="true" data-sort="false">
					   <thead>
						  <tr class="tablehead text3D">
						    <th class="cin">Order Number</th>
						    <th class="cin">Table Number</th>
						    <th>Started</th>
						    <th>Ended</th>  
						    <th>Order Type</th>
						    <th>Server Name</th>
						    <th class="cin">No. Of Guest</th>
						    <th class="" colspan="2">Total Bill</th>  
						    <th class="" colspan="2">Tip</th>  
						    <th class="" colspan="2">Discount</th>
						    <th class="" colspan="2">Service Charge</th>
						    <th class="" colspan="2">Total Tax</th>
						    <th class="" colspan="2">Delivery Fee</th>
						    <th class="" colspan="2">Total Rounding</th> 
						    <th class="" colspan="2">Paid Amount</th>
						  </tr>
						</thead>
						<tbody>   
						  <?php 
                $i = 0;
                $total['NO_OF_GUEST'] = 0;  
                $total['TOTAL_BILL'] = 0;  
                $total['TIP'] = 0;  
                $total['DISCOUNT'] = 0; 
                $total['SERVICE_CHARGE'] = 0;  
                $total['DELIVERY_FEE'] = 0;     
                $total['TOTAL_ROUNDING'] = 0;   
                $total['TOTAL_TAX'] = 0;  
                $total['PAID_AMOUNT'] = 0;
                foreach ($sales_report as $row){ 
              ?>
						  <tr>
						    <td data-field="name" class="cin details-control" data-valign="center">
                  <a href="#" style="font-size:90%" class="label label-lg label-success" data-id="<?=$row->OID?>">
                    <?=$row->ORDER_NUMBER?>
                  </a>  
                </td>
						    <td class="cin"><?=$row->TABLE_NUMBER?></td>
						    <td><?=$row->STARTED?></td>
						    <td><?=$row->ENDED?></td>     
						    <td><?=$row->ORDER_TYPE?></td>
						    <td><?=$row->SERVER_NAME?></td>
						    <td class="cin"><?=$row->NO_OF_GUEST?></td>
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->TOTAL_BILL, 2, '.', '')?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->TIP, 2, '.', '')?></td> 
						    <td class="text3D text-danger"><?=$cur?></td>
						    <td class="cin cur text3D text-danger"><?=number_format((float)$row->DISCOUNT, 2, '.', '')?></td>
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->SERVICE_CHARGE, 2, '.', '')?></td>
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->TOTAL_TAX, 2, '.', '')?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->DELIVERY_FEE, 2, '.', '')?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->TOTAL_ROUNDING, 2, '.', '')?></td>
						    <td class="text3D info"><strong><?=$cur?></strong></td>
						    <td class="cin cur text3D info" style="font-weight:bolder"><strong><?=number_format((float)$row->PAID_AMOUNT, 2, '.', '')?></strong></td>
						  </tr>
						  <tr id="inv-<?=$row->OID?>">
                <td class="active inv" style=""></td>
                <td colspan="22" class="inv" style="">
                  <table id="invoice" class="table-striped dt-right table-hover table-condensed" style="width:100%;" data-sort="false">
                    <thead>
                      <tr class="tablehead text3D">
                        <th class="cin">Invoice ID</th> 
                        <th>Customer</th>
                        <th>Terminal</th>
                        <th>Payment Method</th> 
                        <th class="" colspan="2">Total</th>
                        <th class="" colspan="2">Tip</th>
                        <th class="" colspan="2">Discount</th>  
                        <th class="" colspan="2">Service Charge</th>
                        <th class="" colspan="2">Total Tax</th> 
                        <th class="" colspan="2">Rounding</th>
                        <th class="" colspan="2">Paid Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      foreach($this->sales->get_order_invoice($row->OID) as $rowi){
                    ?>
                      <tr>
                        <td class="cin"><?=$rowi->IID?></td> 
                        <td><?=$rowi->CUSTOMER_NAME?></td>
                        <td><?=$rowi->TERMINAL_NAME?></td>
                        <td><?=$rowi->PAYMENT_METHOD?></td> 
						            <td class="text3D"><?=$cur?></td>
                        <td class="cin cur text3D"><?=number_format((float)$rowi->TOTAL, 2, '.', '')?></td>  
						            <td class="text3D"><?=$cur?></td>
                        <td class="cin cur text3D"><?=number_format((float)$rowi->TIP, 2, '.', '')?></td>  
						            <td class="text3D text-danger"><?=$cur?></td>
                        <td class="cin cur text3D text-danger"><?=number_format((float)$rowi->DISCOUNT, 2, '.', '')?></td>   
						            <td class="text3D"><?=$cur?></td>
                        <td class="cin cur text3D"><?=number_format((float)$rowi->SERVICE_CHARGE, 2, '.', '')?></td>  
						            <td class="text3D"><?=$cur?></td>
                        <td class="cin cur text3D"><?=number_format((float)$rowi->TOTAL_TAX, 2, '.', '')?></td> 
						            <td class="text3D"><?=$cur?></td>
                        <td class="cin cur text3D"><?=number_format((float)$rowi->ROUNDING, 2, '.', '')?></td>  
						            <td class="text3D info"><?=$cur?></td>
                        <td class="cin cur text3D info"><?=number_format((float)$rowi->PAID_AMOUNT, 2, '.', '')?></td> 
                      </tr>
                      <tr>
                        <td class="active odt" style=""></td>
                        <td colspan="24" class="odt" style="">
                          <table id="odetail" class="table-striped dt-right table-hover table-condensed" style="width:100%;" data-sort="false">
                            <thead>
                              <tr class="tablehead text3D">
                                <th>Menu Name</th>
                                <th>Category Name</th>
                                <th>Kitchen Note</th>
                                <th class="cin">Qty</th>  
                                <th class="" colspan="2">Price</th> 
                                <th class="" colspan="2">Total</th>
                              </tr>
                            </thead>
                            <tbody> 
                            <?php 
                              foreach($this->sales->get_order_details($rowi->IID) as $rowd){
                            ?>
                              <tr>
                                <td><?=$rowd->MENU_NAME?></td>
                                <td><?=$rowd->CATEGORY_NAME?></td>
                                <td><?=($rowd->KITCHEN_NOTE==NULL)?"-":$rowd->KITCHEN_NOTE?></td>
                                <td class="cin text3D"><?=$rowd->QUANTITY?></td>
						                    <td class="text3D"><?=$cur?></td>
                                <td class="cin cur text3D"><?=number_format((float)$rowd->PRICE, 2, '.', '')?></td> 
						                    <td class="text3D"><?=$cur?></td>
                                <td class="cin cur text3D"><?=number_format((float)$rowd->TOTAL, 2, '.', '')?></td>
                              </tr>
                            <?php } ?>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </td>
						  </tr>
						  <?php  
                  $total['NO_OF_GUEST'] = $total['NO_OF_GUEST']+$row->NO_OF_GUEST;  
                  $total['TOTAL_BILL'] = $total['TOTAL_BILL']+$row->TOTAL_BILL;  
                  $total['TIP'] = $total['TIP']+$row->TIP;  
                  $total['DISCOUNT'] = $total['DISCOUNT']+$row->DISCOUNT;   
                  $total['DELIVERY_FEE'] = $total['DELIVERY_FEE']+$row->DELIVERY_FEE;  
                  $total['TOTAL_ROUNDING'] = $total['TOTAL_ROUNDING']+$row->TOTAL_ROUNDING;
                  $total['SERVICE_CHARGE'] = $total['SERVICE_CHARGE']+$row->SERVICE_CHARGE;  
                  $total['TOTAL_TAX'] = $total['TOTAL_TAX']+$row->TOTAL_TAX;  
                  $total['PAID_AMOUNT'] = $total['PAID_AMOUNT']+$row->PAID_AMOUNT;
                  $i++; 
                } 
              ?>
						</tbody>
            <tfoot> 
						  <tr class="tablefoot text3D">
						    <th> </th>
						    <th> </th>
						    <th> </th> 
						    <th class="no-sort"></th>
						    <th class="no-sort"></th>    
						    <th class="cin no-sort">Grand Total</th>
						    <th class="cin text3D no-sort"><?=$total['NO_OF_GUEST']?></th>
						    <th class="text3D no-sort"><?=$cur?></th>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['TOTAL_BILL'], 2, '.', '')?></th>  
						    <th class="text3D no-sort"><?=$cur?></th>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['TIP'], 2, '.', '')?></th>    
						    <th class="text3D no-sort text-danger"><?=$cur?></th>
						    <th class="cin cur text3D no-sort text-danger"><?=number_format((float)$total['DISCOUNT'], 2, '.', '')?></th> 
						    <th class="text3D no-sort"><?=$cur?></th>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['SERVICE_CHARGE'], 2, '.', '')?></th> 
						    <th class="text3D no-sort"><?=$cur?></th>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['TOTAL_TAX'], 2, '.', '')?></th>  
						    <th class="text3D no-sort"><?=$cur?></th>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['DELIVERY_FEE'], 2, '.', '')?></th> 
						    <th class="text3D no-sort"><?=$cur?></th>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['TOTAL_ROUNDING'], 2, '.', '')?></th> 
						    <th class="text3D no-sort info"><?=$cur?></th>
						    <th class="cin cur text3D no-sort info"><?=number_format((float)$total['PAID_AMOUNT'], 2, '.', '')?></th>
						  </tr>
						  <tr> 
                <td colspan="23">                                                
                  <div class="pagination pagination-centered hide-if-no-paging row row-centered"></div>
                </td>
              </tr>
            </tfoot>
					</table> 
			  </div>
			</div>
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<div id="ajaxurl" data-url="<?=base_url()?>"></div>
<div id="cur" data-val="<?=$cur?>"></div>
<div id="rest_id" data-val="<?=$rest_id?>"></div>

<script type="text/javascript">   
   
  var ajaxurl = $("#ajaxurl").data('url');  
  var rest_id = $("#rest_id").data('val'); 
  
  var table1 = $('#sales').footable({
    paginate: false
  });
  
  //currency control
  jQuery(function($) {
    var cur = '<?=$cur?>';
    //var cur = $("#cur").data("val");
    switch(cur) {
      case "RS":                  
        $('.cur').autoNumeric('init', { dGroup: 2 });
        break;
      case "RP":   
        $('.cur').autoNumeric('init', { aSep: '.', dGroup: 3, aDec: ',', aPad: false });
        break;
      default: 
        $('.cur').autoNumeric('init');
        break;
    }     
  });    
</script>

<?php
  $this->load->view('shared/footer');
?>