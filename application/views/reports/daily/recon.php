<?php
  $this->load->view('shared/notopbar_header',$this->data);   //var_dump($recon);
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
              <b>&nbsp;&nbsp;&nbsp;Daily Recon Report</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$enddate?></b>
            </td>
          </tr></table>
          </div>  
        </div>
	      <div class="panel-body table-responsive">  
	        <table id="void" class="table table-striped table-bordered" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					  <thead>
						  <tr class="tablehead text3D">
						    <th class="tablehead text3D cin">A</th>
						    <th>B</th>
						    <th colspan="2">C</th>
						    <th colspan="2">D</th>
						    <th colspan="2">E=D-C</th>
						    <th colspan="2">F</th>
						    <th colspan="2">G=E-F</th>
						  </tr>
						  <tr class="primary">
						    <th class="tablehead text3D cin">No</th>
						    <th>Terminal</th>
						    <th colspan="2">Start of Day Cash Register</th>
						    <th colspan="2">End of Day Cash Register</th>
						    <th colspan="2">Cash From Register</th>
						    <th colspan="2">Cash From Orders</th>
						    <th colspan="2">Differences</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php $i = 0;  foreach ($recon as $row){ ?>
						  <tr>
						    <td class="tablehead text3D cin"><?=(count($recon)>0)?$i+1:''?></td>
						    <td><?=$row->TERMINAL_NAME?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=$row->CASH_OPENING?></td>  
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=$row->CASH_CLOSING?></td>  
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=$row->CASH_FROM_REGISTER?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=$row->CASH_FROM_INVOICES?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D <?=(((float)$row->DIFFERENCE)<0)?'text-danger':''?>"><?=$this->currency->my_number_format((float)$row->DIFFERENCE+0.00, 2, '.', '')?></td>
						  </tr>
						  <?php 
                $total['CASH_OPENING'] = $total['CASH_OPENING']+$row->CASH_OPENING;  
                $total['CASH_CLOSING'] = $total['CASH_CLOSING']+$row->CASH_CLOSING;  
                $total['CASH_FROM_REGISTER'] = $total['CASH_FROM_REGISTER']+$row->CASH_FROM_REGISTER;  
                $total['CASH_FROM_INVOICES'] = $total['CASH_FROM_INVOICES']+$row->CASH_FROM_INVOICES;  
                $total['DIFFERENCE'] = $total['DIFFERENCE']+((float)$row->DIFFERENCE); 
                $i++; 
              } ?>
						</tbody>
						<tfoot>
						  <tr class="tablefoot text3D info">  
						    <th class="tablehead text3D"></th>
						    <th class="cin text3D no-sort">Grand Total</th>
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_OPENING'], 2, '.', '')?></th>  
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_CLOSING'], 2, '.', '')?></th>
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_FROM_REGISTER'], 2, '.', '')?></th>  
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_FROM_INVOICES'], 2, '.', '')?></th> 
						    <th class="text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>"><?=$cur?></td>
						    <th class="cin cur text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>"><?=$this->currency->my_number_format((float)$total['DIFFERENCE'],2,'.','')?></th> 
						  </tr>
						</tfoot>
					</table>
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
