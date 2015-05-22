<?php
  $this->load->view('shared/notopbar_header',$this->data);   //var_dump($recon);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:70%;">  
    <div class="row" style="vertical-align:bottom !important;">
    <table width="100%">
      <tr>
        <td width="30%"> 
          &nbsp;&nbsp;&nbsp;&nbsp;<img class="img-thumbnail" style="width:63px; height:63px;" src="<?=$reslogo?>"/>
        </td>  
        <td width="40%" style="text-align:center;">
          <span style="font-weight:bold;font-size:200%;"> 
            <b>ATTENDANCE<br>REPORT</b>
          </span>
        </td>  
        <td width="30%" style="text-align:right;">      
          <span style="font-weight:bold;font-size:175%;"><b><?=$fmonthn?></b>&nbsp;&nbsp;&nbsp;</span><br>
          <span style="font-weight:bold;font-size:125%;"><b><?=$restname->REST_NAME?></b>&nbsp;&nbsp;&nbsp;</span> 
        </td>
      </tr>
    </table> 
    </div>
    <hr style="margin-bottom:10px;margin-top:10px;border-top:black 2px solid;" />
    
	        <table id="attnd" class="table table-striped" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					  <thead>
						  <tr class="" style="background-color:#3071a9; color: #fff">
						    <th>Week</th>
						    <th>Name</th>
						    <th class="cin">Total Hours<br>Expected</th>
						    <th class="cin">Total Hours<br>Worked</th>
						    <th class="cin">Difference</th>
						    <th class="cin">Total<br>Days</th>
						    <th class="cin">Days<br>Worked</th>
						    <th class="cin">Missed<br>Days</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php 
                $i = 1;  //echo count($recon);
                $prev[0] = 1;
                foreach ($attnd as $row){
                  $prev[$i] = $row->WEEK_NUMBER; 
              ?>
              <tr <?=($row->WEEK_NUMBER!=$prev[$i-1])?'style="border-top:black 2px dotted !important;"':''?>>
						    <td class="wknum" style="border-right:black 1px solid !important;"><?=(count($attnd)>0)?$row->WEEK_NUMBER:'&#8211;'?></td>
						    <td style="border-right:black 1px solid !important;"><?=(count($attnd)>0)?$row->USER_NAME:"&#8211;"?></td> 
						    <td class="cin"><?=$row->TOTAL_HRS_EXPECTED+0?></td>
						    <td class="cin"><?=$row->TOTAL_HRS_WORKED+0?></td>
						    <td class="cin" style="border-right:black 1px solid !important;"><?=$row->DIFFERENCE+0?></td>
						    <td class="cin"><?=$row->TOTAL_DAYS+0?></td>
						    <td class="cin"><?=$row->DAYS_WORKED+0?></td>
						    <td class="cin"><?=$row->MISSED_DAYS+0?></td>
						  </tr>
						  <?php 
                $i++; 
              } ?>
						</tbody>
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
  
  $( window ).load(function() {
    MergeCommonRows($('#attnd'),'.wknum');
  });
  
  function MergeCommonRows(table,tdclass="") {
    var firstColumnBrakes = [];
    // iterate through the columns instead of passing each column as function parameter:
    for(var i=1; i<=table.find('th').length; i++){
        var previous = null, cellToExtend = null, rowspan = 1;
        table.find("td"+tdclass+":nth-child(" + i + ")").each(function(index, e){
            var jthis = $(this), content = jthis.text();
            // check if current row "break" exist in the array. If not, then extend rowspan:
            if (previous == content && content !== "" && $.inArray(index, firstColumnBrakes) === -1) {
                // hide the row instead of remove(), so the DOM index won't "move" inside loop.
                jthis.addClass('hidden');
                cellToExtend.attr("rowspan", (rowspan = rowspan+1));
            }else{
                // store row breaks only for the first column:
                if(i === 1) firstColumnBrakes.push(index);
                rowspan = 1;
                previous = content;
                cellToExtend = jthis;
            }
        });
    }
    // now remove hidden td's (or leave them hidden if you wish):
    $('td.hidden').remove();
  }

</script>         

<?php
  $this->load->view('shared/footer');
?>
