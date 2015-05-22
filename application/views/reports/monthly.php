<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/sales">&nbsp;&nbsp;&nbsp;Sales&nbsp;&nbsp;&nbsp;</a>
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/inventory">Inventory</a>          
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/cashflow">Cash Flow</a>           
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/payment">Payment Type</a>           
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/attendance">Attendance</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/daily">&nbsp;&nbsp;<i class="fa fa-th-list"></i> Daily&nbsp;&nbsp;</a>              
      <a role="button" class="btn btn-default" href="<?=base_url()?>reports/weekly">&nbsp;<i class="fa fa-th"></i> Weekly&nbsp;</a>              
      <a role="button" class="btn btn-primary" href="<?=base_url()?>reports/monthly">&nbsp;<i class="fa fa-th-large"></i> Monthly&nbsp;</a>       
    </div>      
    <!--   
    <div class="pull-right">
      <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
        <a id="print" role="button" class="btn btn-primary" href="<?=base_url()?>reports/salesprint/<?=$hashvars?>" target="_blank">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>
      </div>
    </div>
    -->                                                                    
    <hr style="margin-bottom:10px;margin-top:10px" />
    <div class="row" style="padding-left: 15px">  
    <?php
      $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
      echo form_open('reports/monthly',$attributes)
    ?>
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
            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            <input id="enddate" name="enddate" type="text" value="<?=$enddate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="Select Month">
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
    <div class="row">
      <div class="col-sm-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <b>Monthly Sales Report</b>
          </div>
          <div class="panel-body table-responsive"> 
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a id="print" role="button" class="btn btn-primary" href="<?=base_url()?>reports/monthlysalesprint/<?=$hashvars?>" target="_blank">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>
            </div>
          </div>
        </div>
      </div><!-- /.col-sm-6 -->
    </div><!-- /.row --> 
    <div class="row">
      <div class="col-sm-3">
        <div class="panel panel-default">
          <div class="panel-heading">
             <b>Monthly Attendance Report</b>
          </div>
          <div class="panel-body table-responsive"> 
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <!--<a id="print" role="button" class="btn btn-primary" href="<?=base_url()?>reports/attndmonthly/<?=$hashvars?>" target="_blank">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a> 
              -->  
              <a id="print" role="button" class="btn btn-primary" href="<?=base_url()?>reports/monthlyattndprint/<?=$hashvars?>" target="_blank">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>
            </div>
			    </div>
        </div>
      </div><!-- /.col-sm-6 -->  
    </div><!-- /.row --> 
		
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<div id="ajaxurl" data-url="<?=base_url()?>"></div>
<div id="cur" data-val="<?=$cur?>"></div>
<div id="rest_id" data-val="<?=$rest_id?>"></div>

<script type="text/javascript">      
  //datepickers    
  //$("#startdate").datepicker({format: 'dd M yyyy'});
  $("#enddate").datepicker({format: 'M yyyy', viewMode: "months", minViewMode: "months" });
  //$('#enddate').datepicker({daysOfWeekHighlighted: [0,6]});
   
  var ajaxurl = $("#ajaxurl").data('url');  
  var rest_id = $("#rest_id").data('val'); 
  
  var table1 = $('#sales').footable({
    paginate: true,
    pageSize: 50,
    pageNavigationSize: 8
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
