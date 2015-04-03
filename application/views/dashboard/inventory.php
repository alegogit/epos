<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
    
    <div class="row">
    
      <div class="col-sm-10">
        <div class="row">
          <div class="col-md-6">
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a role="button" class="btn btn-default" href="<?=base_url()?>dashboard/sales">&nbsp;&nbsp;Sales&nbsp;&nbsp;</a>   
              <a role="button" class="btn btn-default" href="<?=base_url()?>dashboard/trends">&nbsp;&nbsp;Trends&nbsp;&nbsp;</a>
              <a role="button" class="btn btn-primary" href="<?=base_url()?>dashboard/inventory">Inventory</a>         
            </div> 
          </div>
          <div class="col-md-6">    
            <div class="pull-right">
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a id="print" role="button" class="btn btn-primary" href="#">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>        
            </div> 
            <!--<div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a id="export" role="button" class="btn btn-primary" href="#"><span class="glyphicon glyphicon-export"></span>&nbsp;&nbsp;Export</a>        
            </div>--> 
            </div>
          </div> 
        </div>                          
        <hr style="margin-bottom:10px;margin-top:10px" />
        
        <div class="row" style="padding-left: 15px">
          <?php
            $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
            echo form_open('dashboard/inventory',$attributes)
          ?>   
            <div class="form-group" style="margin-bottom:0px">
              <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
                <select id = "myRestaurant" name="rest_id" title="Restaurant Name" class="form-control" style="display:inline">
                  <!--<option value = "0">ALL Restaurants</option>-->
                  <option value = "0">Select Restaurant</option>
                  <?php foreach($restaurants as $row){ ?>
                  <option value = "<?=$row->REST_ID?>" <?= ($row->REST_ID==$rest_id)?'selected':''?> ><?=$row->NAME?></option>
                  <?php } ?>
                </select>   
              </div>
            </div>
            <div class="form-group" style="margin-bottom:0px">
              <div class="input-group">
                <input type="submit" name="filter" class="btn btn-success" style="display:inline" value="Filter">  
              </div>
            </div>
          <?=form_close()?>
	      </div>   
	      
		    <hr style="margin-bottom:10px;margin-top:10px" />
		
	      <div class="row"> 
	      
          <div class="col-md-4">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Non Moving Items</b></div>
  					  <div class="panel-body" style="min-height:180px;">
  					   <div class="table-responsive">
						    <table id="" class="inv table dt-right compact">
						      <thead>
						        <tr><th></th></tr>
						      </thead>
						      <tbody>
						        
                      <?php    
                        $i = 1;
                        foreach ($nonmovitm as $row){ 
                          echo '<tr><td class="alert alert-info" style="padding:10px;margin-bottom:10px">'.$i.". <b>".ucwords(strtolower($row->NAME))."</b></td> </tr>";
                          $i++;  
                        }
                      ?>
                   
                  </tbody>
                </table>
               </div>
  					  </div>
  				  </div>
  				</div> 
          
          <div class="col-md-4">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Low in Stock</b></div>
  					  <div class="panel-body" style="min-height:180px;"> 
  					   <div class="table-responsive">
						    <table id="" class="inv table dt-right compact">
						      <thead>
						        <tr><th></th></tr>
						      </thead>
						      <tbody>
  					     
      					     <?php 
                      $i = 1;
                      foreach ($lowinstck as $row){  
                        echo '<tr><td class="alert alert-warning" style="padding:10px;margin-bottom:10px">'.$i.". <b>".ucwords(strtolower($row->NAME))."</b></td></tr>";
                        $i++;  
                      }
                    ?> 
                   
                  </tbody>
                </table>
              </div>
  				   </div>
  				  </div>
  				</div>
				  
				  <div class="col-md-4">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>No Stock</b></div>
  					  <div class="panel-body" style="min-height:180px;">
  					   <div class="table-responsive">
						    <table id="" class="inv table dt-right compact">
						      <thead>
						        <tr><th></th></tr>
						      </thead>
						      <tbody>
						      
                  <?php 
                    $i = 1;
                    foreach ($nostock as $row){
                      echo '<tr><td class="alert alert-danger" style="padding:10px;margin-bottom:10px">'.$i.". <b>".ucwords(strtolower($row->NAME))."</b></td></tr>";
                      $i++;  
                    }
                  ?>   
                   
                  </tbody>
                </table>
  					  </div>
  				   </div>
  				  </div>
				  </div>
				  
				  
			  </div>	
			                 
      </div><!-- /.col-sm-10 -->

      <div class="col-sm-2" style="padding:0;">
        
        <div class="list-group rightdash" style="margin-top:10px;">      
          <div class="rdtitle">Sales Today</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item orgbg noborder pad30">
            <span class="text270"><?=$cur?> <span id="nsales" value="<?=$this->currency->decimal($net_sales_today->NET_SALES,$cur)?>" data-cur="<?=$cur?>"></span></span><br>  
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:120%;"><b>Net Sales Today</b></span><br>
            &nbsp;<br>
            <span class="text270"><?=$cur?> <span id="tsales" value="<?=$this->currency->decimal($tot_sales_today->TOTAL_SALES,$cur)?>" data-cur="<?=$cur?>"></span></span><br>     
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:120%;"><b>Total Sales Today</b></span><br>
          </span>      
          <div class="rdinfo">
          </div>
        </div>    
        
        <div class="list-group rightdash">            
          <div class="rdtitle">Customer</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item teabg noborder pad30">   
            <span class="text270"><?=$cur?> <span id="csales" value="<?=$this->currency->decimal($avrsls_percust->AVG_SALES_CUST,$cur)?>" data-cur="<?=$cur?>"></span></span> <br>  
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:120%;"><b>Average Sales/Customer</b></span>
          </span>   
          <div class="rdinfo"><?=$num_cust_today->TOTAL_CUST?> Customer(s) Today</div>
        </div>        
                  
        <div class="list-group rightdash">    
          <div class="rdtitle">Invoice</div>   
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item redbg noborder pad30">
            <span class="text270"><?=$cur?> <span id="isales" value="<?=$this->currency->decimal($avrsls_perinv->AVG_SALES_INV,$cur)?>" data-cur="<?=$cur?>"></span></span> <br>  
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:120%;"><b>Average Sales/Invoice</b></span>
          </span>  
          <div class="rdinfo"><?=$com_inv_today->TOTAL_INV?> Invoice(s) Today</div> 
        </div>    
       
        
      </div><!-- /.col-sm-3 -->
      
    </div><!-- /.row -->
    
  </div><!-- /.container-fluid -->
  
</div><!-- /#page-content-wrapper -->     
<div id="cur" data-val="<?=$cur?>"></div>
       
<script>
  //datepickers
  $("#startdate").datepicker({format: 'dd M yyyy'});
  $("#enddate").datepicker({format: 'dd M yyyy'});
     
  //print page
  $("#print").click(function(){      
    window.print();
  });   
             
  //animating numbers 
  $(document).ready(function () {
      animateNumbers("#nsales");
      animateNumbers("#tsales");
      animateNumbers("#csales");
      animateNumbers("#isales");
  });
           
  function animateNumbers(ale) {    
    var num = $(ale).attr("value"); 
    var cur = $(ale).data("cur");
    $(ale).countTo({
      from: 0,
      to: num,
      speed: 1000,
      refreshInterval: 50,
      onComplete: function(value) {
        if(cur.toLowerCase() == "RP".toLowerCase()){
          $(ale).html(currencyFormat(num));
      	} else if(cur.toLowerCase() == "RS".toLowerCase()){
          $(ale).html(currencyFormatRS(num));
      	} else {
          $(ale).html(numberWithCommas(num));
      	}
        //console.debug(this);
      }
    });
  }
           
  function currencyFormat(number){   
		return (number + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  }  
  
  function currencyFormatRS(x){
    	var parts = x.toString().split(".");
    	parts[0] = parts[0].replace(/(\B)(?=((\d)(\d{2}?)+)$)/g, "$1,");
    	return parts.join(".");
  }          
    
	function numberWithCommas(x) {
    	var parts = x.toString().split(".");
    	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    	return parts.join(".");
	}    
    
    (function($) {
    $.fn.countTo = function(options) { 
        // merge the default plugin settings with the custom options
        options = $.extend({}, $.fn.countTo.defaults, options || {});

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(options.speed / options.refreshInterval),
            increment = (options.to - options.from) / loops;

        return $(this).each(function() {
            var _this = this,
                loopCount = 0,
                value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                $(_this).html(currencyFormat(value.toFixed(options.decimals)));

                if (typeof(options.onUpdate) == 'function') {
                    options.onUpdate.call(_this, value);
                }

                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;

                    if (typeof(options.onComplete) == 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,  // the number the element should start at
        to: 100,  // the number the element should end at
        speed: 1000,  // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,  // the number of decimal places to show
        onUpdate: null,  // callback method for every time the element is updated,
        onComplete: null,  // callback method for when the element finishes updating
    };
    
    while( $('.fitin div').height() > $('.fitin').height() ) {
        $('.fitin div').css('font-size', (parseInt($('.fitin div').css('font-size')) - 1) + "px" );
    }
    
    })(jQuery);
    
    
  //inititate datatable
  var table = $('.inv').DataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],    
    searching: false,
    ordering:  false,
    bLengthChange: false,
    pageLength: 5
  });
  
  $('table.dataTable thead th, table.dataTable thead td').css('border','none');
  $('.dataTables_empty').html('None');
     	
</script>