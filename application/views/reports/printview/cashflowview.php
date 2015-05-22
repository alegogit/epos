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
              <b>&nbsp;&nbsp;&nbsp;Cash Flow Report</b>
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
						    <th class="cin no-sort">Starting Day<br>Cash Register</th>
						    <th class="cin"></th>
						    <th class="cin no-sort">Closing Day<br>Cash Register</th>
						    <th class="cin"></th>
						    <th class="cin no-sort">Cash From Register</th>     
						    <th class="cin"></th>
						    <th class="cin no-sort">Cash From Order</th>       
						    <th class="cin"></th>
						    <th class="cin no-sort">Differences</th>  
						  </tr>
						</thead>
						<tbody>          
						  <?php 
                $i = 0;            
                $total['CASH_OPENING'] = 0;  
                $total['CASH_CLOSING'] = 0; 
                $total['CASH_FROM_REGISTER'] = 0;  
                $total['CASH_FROM_INVOICES'] = 0;   
                $total['DIFFERENCE'] = 0;  
                foreach ($cashflow as $row){ 
              ?>
						  <tr data-index="<?=$i?>">
						    <td><?=$row->TERMINAL_DATE?></td>
						    <td><?=$row->TERMINAL_NAME?></td>     
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_OPENING, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_CLOSING, 2, '.', '')?></td>    
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_FROM_REGISTER, 2, '.', '')?></td> 
						    <td class="cin text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=number_format((float)$row->CASH_FROM_INVOICES, 2, '.', '')?></td> 
						    <td class="cin text3D <?=(((float)$row->CASH_FROM_REGISTER-(float)$row->CASH_FROM_INVOICES)<0)?'text-danger':''?>"><?=$cur?></td>
						    <td class="cin cur text3D <?=(((float)$row->CASH_FROM_REGISTER-(float)$row->CASH_FROM_INVOICES)<0)?'text-danger':''?>"><?=$this->currency->my_number_format((float)$row->CASH_FROM_REGISTER-(float)$row->CASH_FROM_INVOICES, 2, '.', '')?></td> 
						  </tr>
						  <?php 
                $total['CASH_OPENING'] = $total['CASH_OPENING']+$row->CASH_OPENING;  
                $total['CASH_CLOSING'] = $total['CASH_CLOSING']+$row->CASH_CLOSING;  
                $total['CASH_FROM_REGISTER'] = $total['CASH_FROM_REGISTER']+$row->CASH_FROM_REGISTER;  
                $total['CASH_FROM_INVOICES'] = $total['CASH_FROM_INVOICES']+$row->CASH_FROM_INVOICES;  
                $total['DIFFERENCE'] = $total['DIFFERENCE']+((float)$row->CASH_FROM_REGISTER-(float)$row->CASH_FROM_INVOICES);  
                $i++; 
              } ?>
						</tbody>
						<tfoot>
						  <tr class="tablefoot text3D">
						    <th class="no-sort" style="padding: 4px 5px !important;">Grand Total</th>
						    <th class="no-sort" style="padding: 4px 5px !important;"></th> 
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CASH_OPENING'], 2, '.', '')?></th>  
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CASH_CLOSING'], 2, '.', '')?></th>
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CASH_FROM_REGISTER'], 2, '.', '')?></th>  
						    <th class="cin text3D no-sort" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="padding: 4px 5px !important;"><?=number_format((float)$total['CASH_FROM_INVOICES'], 2, '.', '')?></th> 
						    <th class="cin text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>" style="padding: 4px 5px !important;"><?=$cur?></td>
						    <th class="cin cur text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>" style="padding: 4px 5px !important;"><?=$this->currency->my_number_format((float)$total['DIFFERENCE'],2,'.','')?></th> 
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
