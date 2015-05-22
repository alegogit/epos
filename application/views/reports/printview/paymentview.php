<?php
  $this->load->view('shared/notopbar_header',$this->data);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">   
           
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
              <b>&nbsp;&nbsp;&nbsp;Payment Type Report</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$startdate." - ".$enddate?></b>
            </td>
          </tr></table>
          </div>  
        </div>
	      <div class="panel-body table-responsive" style="font-size:80% !important;">   
	        <table id="report" class="table table-striped dt-right compact">
				    <thead>
						  <tr class="tablehead text3D">
						    <th class="no-sort">Date</th>
						    <th class="no-sort">Terminal</th>  
						    <th class="cin"></th>
						    <th class="cin no-sort">Cash</th>     
						    <th class="cin"></th>
						    <th class="cin no-sort">Debit</th>  
						    <th class="cin"></th>
						    <th class="cin no-sort">Credit</th>     
						    <th class="cin"></th>
						    <th class="cin no-sort">Total</th>
						  </tr>
						</thead>
						<tbody>          
						  <?php 
                $i = 0;
                $total['CASH_FROM_INVOICES'] = 0;  
                $total['DEBIT_FROM_INVOICES'] = 0;   
                $total['CREDIT_FROM_INVOICES'] = 0;  
                $total['TOTAL'] = 0;  
                foreach ($payment as $row){ 
              ?>
						  <tr data-index="<?=$i?>">
						    <td><?=$row->TRAN_DATE?></td>
						    <td><?=$row->TERMINAL_NAME?></td>     
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_FROM_INVOICES, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->DEBIT_FROM_INVOICES, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CREDIT_FROM_INVOICES, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->TOTAL, 2, '.', '')?></td> 
						  </tr>
						  <?php 
                $total['CASH_FROM_INVOICES'] = $total['CASH_FROM_INVOICES']+$row->CASH_FROM_INVOICES;  
                $total['DEBIT_FROM_INVOICES'] = $total['DEBIT_FROM_INVOICES']+$row->DEBIT_FROM_INVOICES;
                $total['CREDIT_FROM_INVOICES'] = $total['CREDIT_FROM_INVOICES']+$row->CREDIT_FROM_INVOICES;  
                $total['TOTAL'] = $total['TOTAL']+$row->TOTAL; 
                $i++; 
              } ?>
						</tbody>
						<tfoot>
						  <tr class="tablefoot text3D">
						    <th class="no-sort" style="padding: 4px 5px !important;">Grand Total</th>
						    <th class="no-sort" style="padding: 4px 5px !important;"></th> 
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CASH_FROM_REGISTER'], 2, '.', '')?></th>  
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CASH_FROM_INVOICES'], 2, '.', '')?></th>
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CREDIT_FROM_INVOICES'], 2, '.', '')?></th>  
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['TOTAL'], 2, '.', '')?></th>
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
  //inititate datatable
  var table = $('#report').DataTable({  
    "searching": false,     
    "paging": false,
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 0, "asc" ]],
    "bAutoWidth": false,
    "info": false,
    "bPaginate": false
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

</script>   
   
<?php
  $this->load->view('shared/footer');
?>
