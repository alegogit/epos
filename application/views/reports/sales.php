<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-primary" href="<?=base_url()?>reports/sales">&nbsp;&nbsp;&nbsp;Sales&nbsp;&nbsp;&nbsp;</a>
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/inventory">Inventory</a>          
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/cashflow">Cash Flow</a>           
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/payment">Payment Type</a>           
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/attendance">Attendance</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/daily">&nbsp;&nbsp;<i class="fa fa-th-list"></i> Daily&nbsp;&nbsp;</a>              
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/weekly">&nbsp;<i class="fa fa-th"></i> Weekly&nbsp;</a>              
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/monthly">&nbsp;<i class="fa fa-th-large"></i> Monthly&nbsp;</a>       
    </div>      
    <div class="pull-right">
      <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
        <a id="print" role="button" class="btn btn-primary" href="<?=base_url()?>reports/salesprint/<?=$hashvars?>" target="_blank">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>
      </div>
    </div>                                                                    
    <hr style="margin-bottom:10px;margin-top:10px" />         
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('reports/sales',$attributes)
      ?>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            <input id="startdate" name="startdate" type="text" value="<?=$startdate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="Start Date">
          </div>                                                                                                                                                              
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">       
            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            <input id="enddate" name="enddate" type="text" value="<?=$enddate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="End Date">
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <select id = "myRestaurant" name="rest_id" title="Restaurant Name" class="form-control" style="display:inline">
              <option value = "0">ALL Restaurants</option>
              <?php foreach($restaurants as $row){ ?>
              <option value = "<?=$row->REST_ID?>" <?= ($row->REST_ID==$rest_id)?'selected':''?> ><?=$row->NAME?></option>
              <?php } ?>
            </select>   
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-file"></span></div>
            <select id = "repch" name="report_name" title="Choose Report" class="form-control" style="display:inline">
              <option value = "0">Choose Report</option>
              <option value = "Sales" <?=($report_name=='Sales')?'selected':''?>>Sales</option>
              <option value = "Void Items" <?=($report_name=='Void Items')?'selected':''?>>Void Items</option>
            </select>   
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <button type="submit" class="btn btn-success" style="display:inline">Filter</button>   
          </div>
        </div>
      <?=form_close()?>
	  </div>            
    
    <hr style="margin-bottom:10px;margin-top:10px" />
        
	  <div class="panel panel-default">
		    <div class="panel-heading">
          <b><?=$report_name?> Report</b>  
        </div>
	      <div class="panel-body table-responsive" style="overflow-x:scroll;">  
	       <?php if($report_name!="Sales"){?>   
	        <table id="void" class="table table-striped" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					  <thead>
						  <tr>
						    <th data-field="state" data-checkbox="true" >Void ID</th>
						    <th data-field="name" data-sortable="true">Menu Name</th>
						    <th data-field="rson"  data-sortable="true">Void Reason</th>
						    <th data-field="onum" data-sortable="true">Order Number</th>
						    <th data-field="strd" data-sortable="true">Started</th>
						    <th data-field="endd"  data-sortable="true">Ended</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php $i = 0;  foreach ($void_items as $row){ ?>
						  <tr>
						    <td data-field="state" data-checkbox="true" ><?=$i?></td>
						    <td data-field="name" data-sortable="true"><?=$row->MENU_NAME?></td>
						    <td data-field="rson"  data-sortable="true"><?=$row->VOID_REASON?></td>
						    <td data-field="onum" data-sortable="true"><?=$row->ORDER_NUMBER?></td>
						    <td data-field="strd" data-sortable="true"><?=$row->STARTED?></td>
						    <td data-field="endd"  data-sortable="true"><?=$row->ENDED?></td>
						  </tr>
						  <?php $i++; } ?>
						</tbody>
					</table>
				<?php } else {?>
          <!--<div class="row" style="position:fixed;">-->
          <div style="margin-bottom:15px;">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <button data-toggle="dropdown" class="dropdown-toggle text3D btn btn-default">
                  &nbsp;<i class="fa fa-navicon"></i>
                  <b>Show More Details </b>
                  <b class="caret"></b>&nbsp;
                </button>
                <ul class="dropdown-menu">
                  <li><a id="sallb" href="#">Show Invoice & Order Details</a></li>
                  <li><a id="sinvb" href="#">Show Invoice Details Only</a></li>
                  <li class="divider"></li>
                  <li><a id="hallb" href="#">Hide Details</a></li>
                </ul>  
              </li>
            </ul>
            <form class="form-inline" role="form">      
              <div class="form-group pull-right">
                <div class="input-group">       
                  <div class="input-group-addon"><span class="fa fa-search"></span></div>
                  <input id="sfilter" type="text" class="form-control" placeholder="Search"/>
                </div>
              </div>
            </form> 
           </div> 
          <div style="margin-bottom:15px;">
            &nbsp;
          </div>
	         <table id="sales" class="table table-striped dt-right table-hover table-condensed" data-filter="#sfilter" data-filter-text-only="true" data-sort="false">
					   <thead>
						  <tr class="tablehead text3D">
						    <th class="cin">Order Number</th>
						    <th class="cin">Table Number</th>
						    <!--<th>Customer Name</th>-->
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
						    <!--<th>Payment Method</th>-->
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
						    <!--<td><?=$row->CUSTOMER_NAME?></td>-->
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
						    <!--<td><?=$row->PAYMENT_METHOD?></td>-->
						  </tr>
						  <tr id="inv-<?=$row->OID?>">
                <td class="active inv" style="display:none !important;"></td>
                <td colspan="22" class="inv" style="display:none !important;">
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
                        <td class="active odt" style="display:none !important;"></td>
                        <td colspan="24" class="odt" style="display:none !important;">
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
						    <!--<th class="no-sort"></th>-->
						  </tr>
						  <tr> 
                <td colspan="23">                                                
                  <div class="pagination pagination-centered hide-if-no-paging row row-centered"></div>
                </td>
              </tr>
            </tfoot>
					</table> 
				<?php } ?>
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
  $("#startdate").datepicker({format: 'dd M yyyy'});
  $("#enddate").datepicker({format: 'dd M yyyy'});

   
  var ajaxurl = $("#ajaxurl").data('url');  
  var rest_id = $("#rest_id").data('val');    
	
  /*  
  //inititate datatable
  var table1 = $('#sales').DataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 0, "asc" ]],
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    pageLength: 25,
    "aLengthMenu": [[10, 25, 100, -1], [10, 25, 100, "All"]],
    "bAutoWidth": false
  }); 
  */
  
  var table1 = $('#sales').footable({
    paginate: true,
    pageSize: 50,
    pageNavigationSize: 8
  });
  
  //inititate datatable
  var table2 = $('#void').DataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 0, "asc" ]],
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    pageLength: 25,
    "aLengthMenu": [[10, 25, 100, -1], [10, 25, 100, "All"]],
    "bAutoWidth": false
  }); 
  
  /* temporary disabled  
   $('#sales tbody').on('click', 'td.details-control', function () {
   //$('td.details-control').click(function () {
        var tr = $(this).closest('tr');           
        //var td = $(this).closest('tr').next('td').find('inv');           
        var td = $('td.inv');
         console.log(tr);
          console.log(td);
        
        if ( td.is(":visible") ) {
            // This row is already open - close it
            td.hide();
            td.removeClass('shown');
        }
        else {
            // Open this row
            td.show();
            td.addClass('shown');     
        }
    } );  
  */
    
  $(document).ready(function(){
    $('#sallb').click(function(){
      $('td.inv').show();
      $('td.odt').show();
    });
    $('#sinvb').click(function(){
      $('td.inv').show();   
      $('td.odt').hide();
    });
    $('#hallb').click(function(){
      $('td.inv').hide();   
      $('td.odt').hide();
    }); 
    $('#sales table').css({
      paddingLeft: '3px',
      paddingRight: '3px'
    }); 
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
