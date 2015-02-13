<div id="page-content-wrapper" style="padding-bottom:0px !important">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
    
    <div class="row">
    
      <div class="col-sm-10">
        <div class="row">
          <div class="col-md-6">
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a role="button" class="btn btn-primary" href="<?=base_url()?>dashboard/sales">&nbsp;&nbsp;Sales&nbsp;&nbsp;</a>
              <a role="button" class="btn btn-default" href="<?=base_url()?>dashboard/inventory" <?=(count($nostock)>0)?'title="'.(count($nostock)>0).' no stock item(s)"':''?>>Inventory</a>
            </div>  
            <?php if(count($nostock)>0){ ?>
            <span class="label label-danger label-as-badge" style="margin-top:5px;margin-left:-10px;z-index:3;position:absolute">
              <?=count($nostock)?>
            </span>         
            <?php } ?>
          </div>
          <div class="col-md-6">    
            <!--<div style="display:inline-block;float:left" name="sales_tab" class="navdash navdash_first active">Sales</div>
            <div style="display:inline-block" name="inventory_tab" class="navdash navdash_last">Inventory</div>-->
            <div class="pull-right">
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a id="print" role="button" class="btn btn-primary" href="#">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>        
            </div> 
            <!--<div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a id="export" role="button" class="btn btn-primary" href="#"><span class="glyphicon glyphicon-export"></span>&nbsp;&nbsp;Export</a>        
            </div>--> 
            </div>
            <!--<span class="pull-right">
              <div style="display:inline-block" name="print_tab" class="navdash navdash_alone">
                <span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print
              </div>
              <div style="display:inline-block" name="export_tab" class="navdash navdash_alone">
                <span class="glyphicon glyphicon-export"></span>&nbsp;&nbsp;Export
              </div>
            </span>-->
          </div> 
        </div>                          
        <hr style="margin-bottom:10px;margin-top:10px" /> 
                     
        <div class="row" style="padding-left: 15px">  
          <?php
            $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
            echo form_open('dashboard/sales',$attributes)
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
                <input type="submit" name="filter" class="btn btn-success" style="display:inline" value="Filter">
              </div>
            </div>
          <?=form_close()?>
	      </div>   
		    
        <hr style="margin-bottom:10px;margin-top:10px" />
		
	      <div class="row"> 
          <?php 
          //chart config
            $donut_color[0] = "#30a5ff";
            $donut_color[1] = "#ffb53e";
            $donut_color[2] = "#1ebfae";
            $donut_color[3] = "#f9243f";
            $donut_color[4] = "#d2691e";
            $donut_highl[0] = "#62b9fb";
            $donut_highl[1] = "#fac878";
            $donut_highl[2] = "#3cdfce";
            $donut_highl[3] = "#f6495f";
            $donut_highl[4] = "#e4843f";
            
          ?>                 
            
          <?php //echo "<pre>" . var_dump($dpayment) . "</pre>"; ?>
          <div class="col-md-4">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Top Category By Sales</b></div>
  					  <div class="panel-body">
    					  <div class="row">
    						  <div class="canvas-donut" style="float:left;margin-left:2px">
    							  <canvas class="chart" id="topcats_donut" ></canvas>
    						  </div> 
                  <div class="fitin" style="display:inline-block;margin-left:2px;max-width:150px;"> 
                    <div>
                      <?php    
                        $i = 0;
                        $n = count($dtopcats);
                        $chart_legend = "";
                        $total = 0; 
                        foreach ($dtopcats as $tot){
                          $total = $total + $tot->AMOUNT;
                        }
                        foreach ($dtopcats as $row){
                          $chart_legend .= "<span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i]."'></span>";  
                          $chart_legend .= " <span><b>".ucwords(strtolower($row->CAT_NAME))."</b></span><span style='padding:10px'>&nbsp;</span>";
                          //$chart_legend .= " <b>".number_format($row->AMOUNT, 0, '', '.')."</b>\t";
                          $chart_legend .= " <span style='float:right;display:inline-block'>".round(($row->AMOUNT/$total)*100)."% </span><hr style='margin-top:5px;margin-bottom:5px'>";
                          $i++;  
                        }
                        if($n!=0){    
                          echo $chart_legend;
                        }else{
                          echo "<div id='nrtcbs' class='alert alert-danger' style='padding:10px;'>No Records</div>";
                        }
                    ?>
                    </div>
                  </div> 
                </div>  
  					  </div>
  				  </div>
  				</div>
          
          <div class="col-md-3">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Top Menu Items By Sales</b></div>
  					  <div class="panel-body">  
                <div class="fitin">
                  <div style="display:inline-block;width:100%;">
      					     <?php 
                      $i = 0;
                      $n = count($dbestsells);
                      $chart_legend = "<table id='ttibs' style='width:100%'>";
                      foreach ($dbestsells as $row){
                        $chart_legend .= "<tr>
                          <td><b>".($i+1)."</b>&nbsp;</td>";  
                        $chart_legend .= "<td><b>".ucwords(strtolower($row->ITEMS))."</b>&nbsp;</td><td style='text-align:right'><span style='padding-left:10px;'>&nbsp;</span>".$cur."&nbsp;</td>";
                        $chart_legend .= "<td style='text-align:right'><b>".number_format($row->AMOUNT, 0, '', '.')."</b>&nbsp;</td>";
                        $chart_legend .= "<td style='text-align:right'><span style='padding-left:10px;'>&nbsp;</span>".$row->QTY."</td>
                          </tr>
                          <tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></td></tr>";
                        $i++;  
                      }
                      $chart_legend .= "</table>";
                      if($n!=0){    
                        echo $chart_legend;
                      }else{
                        echo "<div id='nrtibs' class='alert alert-danger' style='padding:10px;'>No Records</div>";
                      }
                    ?>
                  </div>
                </div>
              </div>
  				  </div>
  				</div>
				  
				  <div class="col-md-5">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Payment Methods</b></div>
  					  <div class="panel-body">
  					  <div class="row">
  						  <div class="canvas-donut" style="float:left;margin-left:2px">
  							  <canvas class="chart" id="payment_donut" ></canvas>
  						  </div>  
                <div class="fitin" style="display:inline-block;margin-left:2px;max-width:205px;"> 
                  <div>
                  <?php 
                    $i = 0;
                    $n = count($dpayment);
                    $chart_legend = ""; 
                    $total = 0; 
                    foreach ($dpayment as $tot){
                      $total = $total + $tot->AMOUNT;
                    }
                    $chart_legend .= "<table>";
                    foreach ($dpayment as $row){
                      $chart_legend .= "<tr><td class='col-md-1' style='padding-left:5px;padding-right:5px;'><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i]."'></span></td>";  
                      $chart_legend .= "<td class='col-md-4' style='padding-left:5px;padding-right:5px;'>".ucwords(strtolower($row->PAYMENT_METHOD))."</td> <td class='col-md-1' style='padding-left:10px;padding-right:5px;'>".$cur."</td>";
                      $chart_legend .= "<td class='col-md-6' style='padding-left:5px;padding-right:5px;'><span style='float:right;display:inline-block'>".number_format($row->AMOUNT, 0, '', '.')."</span></td></tr>";
                      $i++;  
                    }
                    
                    $chart_legend .= "<tr>
                        <td colspan='4'><hr style='margin-top:5px;margin-bottom:5px;border-color:#222'></td>
                      </tr>
                      <tr>
                        <td class='col-md-1' style='padding-left:5px;padding-right:5px;'><b><i class='fa fa-money'></i></b></td> 
                        <td class='col-md-4' style='padding-left:5px;padding-right:5px;'><b>Total</b></td>
                        <td class='col-md-1' style='padding-left:10px;padding-right:5px;'><b>".$cur."</b></td>
                        <td class='col-md-6' style='padding-left:5px;padding-right:5px;'><b><span style='float:right;display:inline-block'>".number_format($total, 0, '', '.')."</span></b></td>";
                    $chart_legend .= "</tr></table>";
                    if($total!=0){    
                      echo $chart_legend;
                    }else{
                      echo "<div class='alert alert-danger' style='padding:10px;'>No Records</div>";
                    }
                  ?>
                 </div>
                </div>
              </div> 
  					  </div>
  				  </div>
				  </div>
				  
				  
			  </div>	
			  
		    <div class="row">
      			<div class="col-lg-12">
      				<div class="panel panel-default">
      					<div class="panel-heading">
      					  <div class="row" style="padding-left:10px;padding-right:10px">
        					  <b>
                      <span id="motit">Monthly Revenue</span>
                      <span id="wktit" style="display:none">Weekly Revenue</span>
                    </b>
                    <div class="btn-group pull-right" role="group" aria-label="...">
                      <a role="button" class="btn btn-sm btn-primary" id="mobutt" href="#monthly-line-chart">Monthly</a> 
                      <a role="button" class="btn btn-sm btn-default" id="wkbutt" href="#weekly-line-chart">Weekly</a>        
                    </div>
                  </div>
                </div>
      					<div class="panel-body">
      						<div class="canvas-wrapper">
      							<canvas class="main-chart" id="monthly-line-chart" height="200" width="600"></canvas>
      						</div>
      						<div class="canvas-wrapper">
      							<canvas class="main-chart" id="weekly-line-chart" height="200" width="600" style="display:none"></canvas>
      						</div>
      					</div>
      				</div>
      			</div>
      	</div><!--/.row-->
               
      </div><!-- /.col-sm-10 -->

      <div class="col-sm-2" style="padding:0;">
        
        <div class="list-group rightdash" style="margin-top:10px;">      
          <div class="rdtitle">Sales Today</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item orgbg noborder pad30">
            <span class="text270"><?=$cur?> <span id="salesd" value="<?=$sales_today->RES?>"></span></span>
            <br><span class="glyphicon glyphicon-info-sign"></span>&nbsp;<?=round((float)$percent_today->PERCENTAGE * 100 ) . '%'?> From Yesterday
          </span>      
          <div class="rdinfo"><?=$trans_today->RES?> Transactions</div>
        </div>    
        
        <div class="list-group rightdash">            
          <div class="rdtitle">Sales This Year</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item teabg noborder pad30">
            <span class="text270"><?=$cur?> <span id="salesy" value="<?=$sales_this_year->RES?>"></span></span>   
            <br><span class="glyphicon glyphicon-info-sign"></span>&nbsp;<?=round((float)$percent_last_week->PERCENTAGE * 100 ) . '%'?> From Last Week
            <!--<br><span class="glyphicon glyphicon-info-sign"></span>&nbsp;<?=round((float)$percent_this_year->PERCENTAGE * 100 ) . '%'?> From Beginning Of The Year -->
          </span>   
          <div class="rdinfo"><?=$trans_this_year->RES?> Transactions</div>
        </div>        
                  
        <div class="list-group rightdash">    
          <div class="rdtitle">Your Customers</div>   
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item redbg noborder pad30">
            <span class="text270"><span id="cust30" value="<?=$num_cust_30day->RES?>"></span></span>
            <br>People
          </span>  
          <div class="rdinfo">Last 30 Days</div> 
        </div>    
       
        
      </div><!-- /.col-sm-3 -->
      
    </div><!-- /.row -->
      
  </div><!-- /.container-fluid -->
  
</div><!-- /#page-content-wrapper -->

<?php 
  //donut chart script
  $i = 0;
  $n = count($dtopcats);
  $total = 0; 
  foreach ($dtopcats as $tot){
  	$total = $total + $tot->AMOUNT;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var doughnutData = [";
  if ($n!=0){
    foreach ($dtopcats as $row){
      $chart_script .= "{";  
      //$chart_script .= "value: ".$row->AMOUNT.",";
      $chart_script .= "value: ".round(($row->AMOUNT/$total)*100).",";
      //$chart_script .= "tooltip: 'eek',";
      $chart_script .= "color: '".$donut_color[$i]."',";
      $chart_script .= "highlight: '".$donut_highl[$i]."',";
      $chart_script .= "label: '".ucwords(strtolower($row->CAT_NAME))."'";
      $chart_script .= ($i==($n-1))?"}":"},";  
      $i++;  
    }
  }else{                                                                   
    $chart_script .= "{";  
    $chart_script .= "value: 1,";
    $chart_script .= "color: '#ebccd1', label: 'No Records'}";
  }
  $chart_script .= "];";
  $chart_script .= "var chart1 = document.getElementById('topcats_donut').getContext('2d');";
  $chart_script .= "chart1.canvas.width = 117;";
  $chart_script .= "chart1.canvas.height = 117;";
  $chart_script .= "window.myDoughnut1 = new Chart(chart1).Doughnut(doughnutData, {
    responsive: true,  
    tooltipFontSize : 12, 
    maintainAspectRatio: false,
    showInLegend: true,";
  $chart_script .= ($n!=0)?"   
    tooltipTemplate: '<%if (label){%><%=label%>: <%}%><%= value %>%'":"tooltipTemplate: '<%if (label){%><%=label%> <%}%>'";
  $chart_script .= "  });";  
	$chart_script .= '</script>';
  echo $chart_script;
?>                                                                                          
 
<?php 
  //donut chart script
  $i = 0;
  $n = count($dpayment);          
  foreach ($dpayment as $tot){
    $total = $total + $tot->AMOUNT;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var doughnutData = [";   
  if ($total!=0){
    foreach ($dpayment as $row){
      $chart_script .= "{";  
      $chart_script .= "value: ".$row->AMOUNT.",";
      $chart_script .= "color: '".$donut_color[$i]."',";
      $chart_script .= "highlight: '".$donut_highl[$i]."',";
      $chart_script .= "label: '".ucwords(strtolower($row->PAYMENT_METHOD))."',";
      $chart_script .= ($i==($n-1))?"}":"},";  
      $i++;  
    }       
  }else{                                                                   
    $chart_script .= "{";  
    $chart_script .= "value: 1,";
    $chart_script .= "color: '#ebccd1', label: 'No Records'}";
  }
  $chart_script .= "];";
  $chart_script .= "var chart2 = document.getElementById('payment_donut').getContext('2d');";      
  $chart_script .= "chart2.canvas.width = 117;";
  $chart_script .= "chart2.canvas.height = 117;";
  $chart_script .= "chart2.canvas.padding = 2;";
  $chart_script .= "window.myDoughnut2 = new Chart(chart2).Doughnut(doughnutData, {
    responsive : true, 
    tooltipFontSize : 12,
    maintainAspectRatio: false,";
  $chart_script .= ($total!=0)?" 
    tooltipTemplate: '<%if (label){%><%=label%>: ".$cur." <%}%><%= currencyFormat(value) %>'":"tooltipTemplate: '<%if (label){%><%=label%> <%}%>'";
  $chart_script .= "  });"; 
	$chart_script .= '</script>';                       
  echo $chart_script;
?>  

                    
<?php
  //line chart script  
  $i = 0;
  $n = count($dmorevenue);  
  $labels = "";
  $data = "";
  foreach ($dmorevenue as $row){  
    $labels .= ($i==($n-1))?"'".date('M', strtotime($row->REC_MONTH))."'":"'".date('M', strtotime($row->REC_MONTH))."',"; 
    $data .=  ($i==($n-1))?$row->REVENUE:$row->REVENUE.","; 
    $i++;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var lineChartData = {";
	$chart_script .= "		labels : [".$labels."],";
	$chart_script .= "		datasets : [";
	$chart_script .= "			{ ";
	$chart_script .= "				label: 'Monthly Revenue',";
	$chart_script .= "				fillColor : 'rgba(48, 164, 255, 0.2)', ";
	$chart_script .= "				strokeColor : 'rgba(48, 164, 255, 1)', ";
	$chart_script .= "				pointColor : 'rgba(48, 164, 255, 1)', ";
	$chart_script .= "				pointStrokeColor : '#fff', ";
	$chart_script .= "				pointHighlightFill : '#fff', ";
	$chart_script .= "				pointHighlightStroke : 'rgba(48, 164, 255, 1)', ";
	$chart_script .= "				data : [".$data."]";
	$chart_script .= "			}";
	$chart_script .= "		]";
  $chart_script .= "	};";
	$chart_script .= "var chart3 = document.getElementById('monthly-line-chart').getContext('2d');";    
  $chart_script .= "chart3.canvas.height = 175;";
	$chart_script .= "window.myLine1 = new Chart(chart3).Line(lineChartData, { ";
	$chart_script .= "	responsive: true, tooltipFontSize : 12,";
	$chart_script .= "	legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%>eek<%=datasets[i].label%><%}%></li><%}%></ul>', ";
	$chart_script .= "	tooltipTemplate: '<%if (label){%><%=label%>: ".$cur."<%}%> <%= currencyFormat(value) %>' ";  
	$chart_script .= "}); ";
	$chart_script .= '</script>';
  echo $chart_script;
?> 

                   
<?php
  //line chart script  
  $i = 0;
  $n = count($dwkrevenue);  
  $labels = "";
  $data = "";
  foreach ($dwkrevenue as $rowk){  
    $labels .= ($i==($n-1))?"'".$rowk->REC_WEEK."'":"'".$rowk->REC_WEEK."',"; 
    $data .=  ($i==($n-1))?$rowk->REVENUE:$rowk->REVENUE.","; 
    $i++;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var lineChartData = {";
	$chart_script .= "		labels : [".$labels."],";
	$chart_script .= "		datasets : [";
	$chart_script .= "			{ ";
	$chart_script .= "				label: 'Monthly Revenue',";
	$chart_script .= "				fillColor : 'rgba(48, 164, 255, 0.2)', ";
	$chart_script .= "				strokeColor : 'rgba(48, 164, 255, 1)', ";
	$chart_script .= "				pointColor : 'rgba(48, 164, 255, 1)', ";
	$chart_script .= "				pointStrokeColor : '#fff', ";
	$chart_script .= "				pointHighlightFill : '#fff', ";
	$chart_script .= "				pointHighlightStroke : 'rgba(48, 164, 255, 1)', ";
	$chart_script .= "				data : [".$data."]";
	$chart_script .= "			}";
	$chart_script .= "		]";
  $chart_script .= "	};";
	$chart_script .= "var chart5 = document.getElementById('weekly-line-chart').getContext('2d');";    
  $chart_script .= "chart5.canvas.height = 175;";
	$chart_script .= "window.myLine2 = new Chart(chart5).Line(lineChartData, { ";
	$chart_script .= "	responsive: true, tooltipFontSize : 12,";
	$chart_script .= "	tooltipTemplate: '<%if (label){%><%=label%>: ".$cur." <%}%><%= currencyFormat(value) %>' ";
	$chart_script .= "});  ";
	$chart_script .= '</script>';
  echo $chart_script;
?>                  

<script>
     /*
     $('#myRestaurant').change(function() {
            $('#selRest').submit(); 
     });
     */    
$(document).ready(function(){
  var ttibs_w = $("#ttibs").width();
  var ttibs_h = parseInt($("#ttibs").height());
  var colmd4h = parseInt($(".col-md-4 .panel").height());
  var colmd3h = parseInt($(".col-md-3 .panel").height());
  if(ttibs_h > colmd4h){                               
    var ttibs_f = parseInt($("#ttibs").css('font-size'))-((ttibs_h/colmd4h)+1);
    $("#ttibs").css('font-size',ttibs_f+'px');  
    $(".col-md-3 div .panel").css('min-height',colmd4h+'px !important');  
  }
  var nrtcbs_w = parseInt($("#nrtcbs").width())+24;
   $("#nrtibs").css('width',nrtcbs_w+'px');  
  //console.log(ttibs_h+' '+colmd4h+' '+perctwf+' '+ttibs_f);
  //$(".canvas-donut").css("overflow","visible");
}); 
     //datepickers
     $("#startdate").datepicker({format: 'dd M yyyy'});
     $("#enddate").datepicker({format: 'dd M yyyy'});
     
     //switch chart
     $("#mobutt").click(function(){      
        $("#monthly-line-chart,#motit").show(); 
        $("#weekly-line-chart,#wktit").hide();  
        $("#mobutt").removeClass("btn-default").addClass("btn-primary"); 
        $("#wkbutt").removeClass("btn-default").removeClass("btn-primary").addClass("btn-default");
     });  
     $("#wkbutt").click(function(){
        $("#monthly-line-chart,#motit").hide(); 
        $("#weekly-line-chart,#wktit").show();  
        $("#mobutt").removeClass("btn-default").removeClass("btn-primary").addClass("btn-default"); 
        $("#wkbutt").removeClass("btn-default").addClass("btn-primary");         
     });                                  
     
     //print page
     $("#print").click(function(){      
        window.print();
     });   
       
    //animating numbers 
    $(document).ready(function () {
      animateNumbers("#salesd");
      animateNumbers("#salesy");
      animateNumbers("#cust30");
    });
           
    function animateNumbers(ale) {    
        var num = $(ale).attr("value");
        $(ale).countTo({
            from: 0,
            to: num,
            speed: 1000,
            refreshInterval: 50,
            onComplete: function(value) {
                $(ale).html(currencyFormat(num));
                console.debug(this);
            }
        });
    }
           
    function currencyFormat(number){
        return (number + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
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
        
    })(jQuery);
      
</script>