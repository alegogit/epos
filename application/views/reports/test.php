<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <img src="http://54.169.200.242/epos/dev/img/wpqtpeqqwqw.jpg" style="width:40px; height:40px;" class="img-thumbnail">
    
    <hr style="margin-bottom:10px;margin-top:10px" />
	   
    <div class="panel panel-default">
		    <div class="alert-info">&nbsp;<br>
          <b>Attendance Report</b>  
        </div>
	      <div class="panel-body table-responsive">   
	        <table id="report" class="table table-striped dt-right compact">
				<thead>
						  <tr class="tablehead text3D">
						    <th class="no-sort">Date</th>
						    <!--<th>Restaurant</th>-->
						    <th class="no-sort">Device</th>  
						    <th class="cin"></th>
						    <th class="cin no-sort">Cash From Register</th>     
						    <th class="cin"></th>
						    <th class="cin no-sort">Cash From Order</th>   
						    <th class="cin"></th>
						    <th class="cin no-sort">Debit From Order</th>   
						    <th class="cin"></th>
						    <th class="cin no-sort">Credit From Order</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php 
                $i = 0;
                $total['CASH_FROM_REGISTER'] = 0;  
                $total['CASH_FROM_ORDER'] = 0;  
                $total['DEBIT_FROM_ORDERS'] = 0;  
                $total['CREDIT_FROM_ORDERS'] = 0;  
                foreach ($attendance as $row){ 
              ?>
						  <tr class="<?=$this->attendance->inv_status_class($row->STATUS)?>" data-index="<?=$i?>">
						    <td><?=$row->TERMINAL_DATE?></td>
						    <!--<td><?=$row->REST_NAME?></td>-->
						    <td><?=$row->DEVICE_NAME?></td>     
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_FROM_REGISTER, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_FROM_ORDER, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->DEBIT_FROM_ORDERS, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CREDIT_FROM_ORDERS, 2, '.', '')?></td>
						  </tr>
						  <?php 
                $total['CASH_FROM_REGISTER'] = $total['CASH_FROM_REGISTER']+$row->CASH_FROM_REGISTER;  
                $total['CASH_FROM_ORDER'] = $total['CASH_FROM_ORDER']+$row->CASH_FROM_ORDER;  
                $total['DEBIT_FROM_ORDERS'] = $total['DEBIT_FROM_ORDERS']+$row->DEBIT_FROM_ORDERS;  
                $total['CREDIT_FROM_ORDERS'] = $total['CREDIT_FROM_ORDERS']+$row->CREDIT_FROM_ORDERS;  
                $i++; 
              } ?>
						</tbody>
						<tfoot>
						  <tr class="tablefoot text3D">
						    <th class="no-sort">Grand Total</th>
						    <!--<th>Restaurant</th>-->
						    <th class="no-sort"></th> 
						    <th class="cin text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_FROM_REGISTER'], 2, '.', '')?></th>  
						    <th class="cin text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_FROM_ORDER'], 2, '.', '')?></th> 
						    <th class="cin text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['DEBIT_FROM_ORDERS'], 2, '.', '')?></th>  
						    <th class="cin text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CREDIT_FROM_ORDERS'], 2, '.', '')?></th>
						  </tr>
						</tfoot>
					</table>      
			  </div>
			</div>
		</div>
		
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->  
<div id="cur" data-val="<?=$cur?>"></div>

<script>  
  //datepickers    
  $("#themonth").datepicker({format: 'M yyyy', viewMode: "months", minViewMode: "months"});
    
  //inititate datatable
  var table = $('#report').DataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],    
    searching: true,
    ordering:  false,
    bLengthChange: true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    pageLength: 25,
    "aLengthMenu": [[10, 25, 100, -1], [10, 25, 100, "All"]],
    "bAutoWidth": false
  });
  
  //currency control
  jQuery(function($) {
    var cur = $("#cur").data('val');
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
