<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
    
    <div class="row">
    
      <div class="col-sm-10">
      
        <div>
          <div style="display:inline-block;float:left" name="sales_tab" class="navdash navdash_first active">Sales</div>
          <div style="display:inline-block" name="inventory_tab" class="navdash navdash_last">Inventory</div>
          <span class="pull-right">
            <div style="display:inline-block" name="print_tab" class="navdash navdash_alone">
              <span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print
            </div>
            <div style="display:inline-block" name="export_tab" class="navdash navdash_alone">
              <span class="glyphicon glyphicon-export"></span>&nbsp;&nbsp;Export
            </div>
          </span>                        
          <hr style="margin-bottom:10px" />
        </div>   
        
        <div>  
          <form id="selRest" method="POST" role="form">
          <ul class="list-inline">
            <li>
              <div class="form-group" style="margin-bottom:0px">
                <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                  <input id="startdate" name="startdate" type="text" value="<?=$startdate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="Start Date">
                </div>                                                                                                                                                              
              </div>
            </li>
            <li>                                                                                                                                                                            
               <div class="form-group" style="margin-bottom:0px">
                  <div class="input-group">       
                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                    <input id="enddate" name="enddate" type="text" value="<?=$enddate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="End Date">
                  </div>
               </div>
            </li>
            <li>     
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
            </li>
            <li>      
               <div class="form-group" style="margin-bottom:0px">
                  <div class="input-group">
                    <button type="submit" class="btn btn-success" style="display:inline">Filter</button>   
                  </div>
               </div>
            </li>
          </ul>
          </form>
		      <hr style="margin-top:-5px" />
	      </div>
		
	      <div class="col-md-6"> 
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
            
          <? //echo "<pre>" . var_dump($dpayment) . "</pre>"; ?>
				  <div class="panel panel-default">
				    <div class="panel-heading"><b>Top Categories By Sales</b></div>
					  <div class="panel-body">
						  <div class="canvas-wrapper">
							  <canvas class="chart" id="topcats_donut" ></canvas>
						  </div>  
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
                  $chart_legend .= " <b>".ucwords(strtolower($row->CAT_NAME))."</b>\t";
                  //$chart_legend .= " <b>".number_format($row->AMOUNT, 0, '', '.')."</b>\t";
                  $chart_legend .= " ".round(($row->AMOUNT/$total)*100)."% <br>";
                  $i++;  
                }
                echo $chart_legend;
                ?> 
					  </div>
				  </div>
          
          <div class="panel panel-default">
				    <div class="panel-heading"><b>Top Items By Sales</b></div>
					  <div class="panel-body">
					     <?php 
                $i = 0;
                $n = count($dbestsells);
                $chart_legend = "";
                foreach ($dbestsells as $row){
                  $chart_legend .= "<b>".($i+1)."</b> ";  
                  $chart_legend .= " <b>".ucwords(strtolower($row->ITEMS))."</b>";
                  $chart_legend .= " <b>".number_format($row->AMOUNT, 0, '', '.')."</b>";
                  $chart_legend .= " ".$row->QTY."<br>";
                  $i++;  
                }
                echo $chart_legend;
              ?>
            </div>
				  </div>
				  
				  <div class="panel panel-default">
				    <div class="panel-heading"><b>Payment Methods</b></div>
					  <div class="panel-body">
						  <div class="canvas-wrapper">
							  <canvas class="chart" id="payment_donut" ></canvas>
						  </div> 
              <?php 
                $i = 0;
                $n = count($dpayment);
                $chart_legend = ""; 
                $total = 0; 
                foreach ($dpayment as $tot){
                  $total = $total + $tot->AMOUNT;
                }
                foreach ($dpayment as $row){
                  $chart_legend .= "<span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i]."'></span>";  
                  $chart_legend .= " ".ucwords(strtolower($row->PAYMENT_METHOD));
                  $chart_legend .= " ".number_format($row->AMOUNT, 0, '', '.')."<br>";
                  $i++;  
                }
                
                $chart_legend .= "Total: ".number_format($total, 0, '', '.')."<br>";
                echo $chart_legend;
              ?> 
					  </div>
				  </div>
				  
				  
				  
			  </div>	
			  
		    <div class="row">
      			<div class="col-lg-12">
      				<div class="panel panel-default">
      					<div class="panel-heading">
      					  <b>
                    <span id="motit">Monthly Revenue</span>
                    <span id="wktit" style="display:none">Weekly Revenue</span>
                  </b>
                  <div class="btn-group pull-right" role="group" aria-label="...">
                    <a role="button" class="btn btn-primary" id="mobutt" href="#monthly-line-chart">Monthly</a> 
                    <a role="button" class="btn btn-default" id="wkbutt" href="#weekly-line-chart">Weekly</a>        
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
               
      </div><!-- /.col-sm-9 -->

      <div class="col-sm-2" style="padding:0;">
        
        <div class="list-group rightdash" style="margin-top:10px;">      
          <div class="rdtitle">Sales Today</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item orgbg noborder pad30">
            <span class="text270">Rp <?=number_format($sales_today->res, 0, '', '.')?></span>
            <br><span class="glyphicon glyphicon-info-sign"></span>&nbsp;<?=round((float)$percent_today->PERCENTAGE * 100 ) . '%'?> From Yesterday
          </span>      
          <div class="rdinfo"><?=$trans_today->res?> Transactions</div>
        </div>    
        
        <div class="list-group rightdash">            
          <div class="rdtitle">Sales This Year</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item teabg noborder pad30">
            <span class="text270">Rp <?=number_format($sales_this_year->res, 0, '', '.')?></span>  
            <span class="numAnim" value="<?=$sales_this_year->res?>"></span>
            <br><span class="glyphicon glyphicon-info-sign"></span>&nbsp;<?=round((float)$percent_last_week->PERCENTAGE * 100 ) . '%'?> From Last Week
            <br><span class="glyphicon glyphicon-info-sign"></span>&nbsp;<?=round((float)$percent_this_year->PERCENTAGE * 100 ) . '%'?> From Beginning Of The Year
          </span>   
          <div class="rdinfo"><?=$trans_this_year->res?> Transactions</div>
        </div>        
                  
        <div class="list-group rightdash">    
          <div class="rdtitle">Your Customers</div>   
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item redbg noborder pad30">
            <span class="text270"><?=$num_cust_30day->res?></span>
            <br>People
          </span>  
          <div class="rdinfo">Last 30 Days</div> 
        </div>    
       
        
      </div><!-- /.col-sm-3 -->
      
    </div><!-- /.row -->
    
    <!-- FOOTER -->
    <hr class="featurette-divider" />
    
    <footer>
      <p class="pull-right">
        <a href="#">Back to top <span class="glyphicon glyphicon-circle-arrow-up"></span></a>
      </p>
    </footer>
  
  </div><!-- /.container-fluid -->
  
</div><!-- /#page-content-wrapper -->

<?php 
  //donut chart script
  $i = 0;
  $n = count($dtopcats);
  $chart_script = "<script>"; 
  $chart_script .= "var doughnutData = [";
  foreach ($dtopcats as $row){
    $chart_script .= "{";  
    $chart_script .= "value: ".$row->AMOUNT.",";
    //$chart_script .= "value: ".round(($row->AMOUNT/$total)*100).",";
    //$chart_script .= "template: '#= category #: \n #= value#%',";
    $chart_script .= "color: '".$donut_color[$i]."',";
    $chart_script .= "highlight: '".$donut_highl[$i]."',";
    $chart_script .= "label: '".$row->CAT_NAME."',";
    $chart_script .= ($i==($n-1))?"}":"},";  
    $i++;  
  }
  $chart_script .= "];";
  $chart_script .= "var chart1 = document.getElementById('topcats_donut').getContext('2d');";
  $chart_script .= "window.myDoughnut = new Chart(chart1).Doughnut(doughnutData, {responsive : true});";  
	$chart_script .= '</script>';
  echo $chart_script;
?>  
 
<?php 
  //donut chart script
  $i = 0;
  $n = count($dpayment);
  $chart_script = "<script>"; 
  $chart_script .= "var doughnutData = [";
  foreach ($dpayment as $row){
    $chart_script .= "{";  
    $chart_script .= "value: ".$row->AMOUNT.",";
    $chart_script .= "color: '".$donut_color[$i]."',";
    $chart_script .= "highlight: '".$donut_highl[$i]."',";
    $chart_script .= "label: '".ucwords(strtolower($row->PAYMENT_METHOD))."',";
    $chart_script .= ($i==($n-1))?"}":"},";  
    $i++;  
  }
  $chart_script .= "];";
  $chart_script .= "var chart2 = document.getElementById('payment_donut').getContext('2d');";
  $chart_script .= "window.myDoughnut = new Chart(chart2).Doughnut(doughnutData, {responsive : true});";  
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
	$chart_script .= "window.myLine = new Chart(chart3).Line(lineChartData, { ";
	$chart_script .= "	responsive: true ";
	$chart_script .= "});  ";
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
	$chart_script .= "window.myLine = new Chart(chart5).Line(lineChartData, { ";
	$chart_script .= "	responsive: true ";
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
     
     //datepickers
     $("#startdate").datepicker({format: 'dd M yyyy'});
     $("#enddate").datepicker({format: 'dd M yyyy'});
     
     //switch chart
     $("#mobutt").click(function(){      
        $("#monthly-line-chart,#motit").show(); 
        $("#weekly-line-chart,#wktit").hide();  
        $("#mobutt").addClass("btn-primary"); 
        $("#wkbutt").removeClass("btn-primary").addClass("btn-default");
     });  
     $("#wkbutt").click(function(){
        $("#monthly-line-chart,#motit").hide(); 
        $("#weekly-line-chart,#wktit").show();  
        $("#mobutt").removeClass("btn-primary").addClass("btn-default"); 
        $("#wkbutt").addClass("btn-primary");   
     });
                     
     num = $('.numAnim').attr("value");
      $({someValue: 0}).animate({someValue: num}, {
        duration: 3000,
        easing:'swing', 
        step: function() { 
          // Update the element's text with rounded-up value:
          $('.numAnim').text(dotSeparateNumber(Math.round(this.someValue)));
        }
      });
     
    //number format
    function dotSeparateNumber(val){
      while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      }
    return val;
    }
     	
</script>
