<?php
  $this->load->view('shared/notopbar_header',$this->data);   //var_dump($recon);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">  
    <div class="row" style="vertical-align:bottom !important;">
    <table width="100%">
      <tr>
        <td width="30%"> 
          &nbsp;&nbsp;&nbsp;&nbsp;<img class="img-thumbnail" style="width:63px; height:63px;" src="<?=$reslogo?>"/>
        </td>  
        <td width="40%" style="text-align:center;">
          <span style="font-weight:bold;font-size:200%;"> 
            <b>WEEKLY<br>CASH FLOW REPORT</b>
          </span>
        </td>  
        <td width="30%" style="text-align:right;">      
          <span style="font-weight:bold;font-size:175%;">
          <?php
            $i = 0;
            foreach ($recon as $row){
              if($i==0){
                $strdt = $row->TERMINAL_DATE;
              } 
              $enddt = $row->TERMINAL_DATE; 
              $i++;
            }
          ?>
            <b><?=date('d', strtotime($strdt))." - ".date('d F Y', strtotime($enddt))?></b>&nbsp;&nbsp;&nbsp;
          </span>
          <br>
          <span style="font-weight:bold;font-size:125%;"><b><?=$restname->REST_NAME?></b>&nbsp;&nbsp;&nbsp;</span> 
        </td>
      </tr>
    </table> 
    </div>
    <hr style="margin-bottom:10px;margin-top:10px;border-top:black 2px solid;" />
        
	        <table id="void" class="table table-striped" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					  <thead>
						  <tr class="tablehead text3D">
						    <th class="" style="border-right:#ddd 1px solid !important;">A</th>
						    <th style="border-right:#ddd 1px solid !important;">B</th>
						    <th colspan="2" style="border-right:#ddd 1px solid !important;">C</th>
						    <th colspan="2" style="border-right:#ddd 1px solid !important;">D</th>
						    <th colspan="2" style="border-right:#ddd 1px solid !important;">E = D &#8211; C</th>
						    <th colspan="2" style="border-right:#ddd 1px solid !important;">F</th>
						    <th colspan="2" style="border-right:#ddd 1px solid !important;">G = E &#8211; F</th> 
						    <th colspan="2" style="border-right:#ddd 1px solid !important;">H</th>
						  </tr>
						  <tr class="" style="background-color:#3071a9; color: #fff">
						    <th class="">Day</th>
						    <th style="border-right:black 2px dotted !important;">Terminal</th>
						    <th colspan="2">Starting Day<br>Cash Register</th>
						    <th colspan="2" style="border-right:black 2px dotted !important;">Closing Day<br>Cash Register</th>
						    <th colspan="2">Cash<br>From Register</th>
						    <th colspan="2" style="border-right:black 2px dotted !important;">Cash<br>From Orders</th>
						    <th colspan="2" style="border-right:black 2px solid !important;">Differences</th>
						    <th colspan="2">Daily<br>Differences</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php 
                $i = 0;  //echo count($recon);
                foreach ($recon as $row){ 
              ?>
						  <tr>
						    <td class=""><?=(count($recon)>0)?$row->TERMINAL_DATE:'&#8211;'?></td>
						    <td style="border-right:black 2px dotted !important;"><?=(count($recon)>0)?$row->TERMINAL_NAME:"&#8211;"?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=$row->CASH_OPENING+0?></td>  
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$row->CASH_CLOSING+0?></td>  
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D"><?=$row->CASH_FROM_REGISTER+0?></td> 
						    <td class="text3D"><?=$cur?></td>
						    <td class="cin cur text3D" style="border-right:black 2px dotted !important;"><?=$row->CASH_FROM_INVOICES+0?></td> 
						    <td class="text3D <?=(((float)$row->DIFFERENCE)<0)?'text-danger':''?>"><?=$cur?></td>
						    <td class="cin cur text3D <?=(((float)$row->DIFFERENCE)<0)?'text-danger':''?>" style="border-right:black 2px solid !important;"><?=$this->currency->my_number_format((float)$row->DIFFERENCE+0.00, 2, '.', '')?></td> 
						    <td class="text3D <?=(((float)$row->DIFFERENCE)<0)?'text-danger':''?>"><?=$cur?></td>
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
						  <tr class="tablefoot text3D info" style="border-top:black 3px solid !important;">  
						    <th class="cin"></th>
						    <th class="cin text3D no-sort" style="border-right:black 2px dotted !important;">Grand Total</th>
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_OPENING'], 2, '.', '')?></th>  
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="border-right:black 2px dotted !important;"><?=number_format((float)$total['CASH_CLOSING'], 2, '.', '')?></th>
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort"><?=number_format((float)$total['CASH_FROM_REGISTER'], 2, '.', '')?></th>  
						    <th class="text3D no-sort"><?=$cur?></td>
						    <th class="cin cur text3D no-sort" style="border-right:black 2px dotted !important;"><?=number_format((float)$total['CASH_FROM_INVOICES'], 2, '.', '')?></th> 
						    <th class="text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>"><?=$cur?></td>
						    <th class="cin cur text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>" style="border-right:black 2px solid !important;"><?=$this->currency->my_number_format((float)$total['DIFFERENCE'],2,'.','')?></th> 
						    <th class="text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>"><?=$cur?></td>
						    <th class="cin cur text3D no-sort <?=((float)$total['DIFFERENCE']<0)?'text-danger':''?>"><?=$this->currency->my_number_format((float)$total['DIFFERENCE'],2,'.','')?></th> 
						  </tr>
						</tfoot>
					</table>
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
