<?php
  $this->load->view('shared/notopbar_header',$this->data);
?>
<div id="page-content-wrapper" style="padding-bottom:0px !important; max-width: 1080px">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
      
        <div class="row" style="text-align:center;">  
          <h4>
            <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <br><?=$restname->REST_NAME?> 
          </h4>
        </div>
		    
        <hr style="margin-bottom:10px;margin-top:10px" />
        
        <div class="panel panel-default">
          <div class="panel-heading tablehead text3D" style="font-size:110% !important;">
              <div class="row" style="vertical-align:bottom !important;"> 
              <table width="100%"><tr> 
                <td>
                  <b>&nbsp;&nbsp;&nbsp;Trends Dashboard</b>
                </td>
                <td class="col-md-6" class="" style="text-align:right;">
                  <b><?=$nowadate?></b>
                </td>
              </tr></table>
              </div>  
          </div>
      		<div class="panel-body">
		
	         <div class="row">
      			<div class="col-lg-12">
      				<div class="panel panel-default">
      					<div class="panel-heading">
      					  <div class="row" style="padding-left:10px;padding-right:10px">
        					  <b>
                      <span id="motit">Monthly Revenue - Last 6 Months</span>
                    </b>
                  </div>
                </div>
      					<div class="panel-body">
      						<div class="canvas-wrapper">
      							<canvas class="main-chart" id="monthly-line-chart" height="125" width="600"></canvas>
      						</div>
      					</div>
      				</div>
      			</div>
      	</div><!--/.row-->
        
	         <div class="row">
      			<div class="col-lg-12">
      				<div class="panel panel-default">
      					<div class="panel-heading">
      					  <div class="row" style="padding-left:10px;padding-right:10px">
        					  <b>
                      <span id="wktit">Weekly Revenue - Last 12 Weeks</span>
                    </b>
                  </div>
                </div>
      					<div class="panel-body">
      						<div class="canvas-wrapper">
      							<canvas class="main-chart" id="weekly-line-chart" height="125" width="600"></canvas>
      						</div>
      					</div>
      				</div>
      			</div>
      	</div><!--/.row-->  
        
  		</div><!-- /.panel-body -->  
    </div><!-- /.panel -->
    
    <div class="row" style="text-align:center;">  
          <h4>
            <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <br><?=$restname->REST_NAME?> 
          </h4>
        </div>
		    
        <hr style="margin-bottom:10px;margin-top:10px" />
        
        <div class="panel panel-default">
          <div class="panel-heading tablehead text3D" style="font-size:110% !important;">
              <div class="row" style="vertical-align:bottom !important;"> 
              <table width="100%"><tr> 
                <td>
                  <b>&nbsp;&nbsp;&nbsp;Trends Dashboard</b>
                </td>
                <td class="col-md-6" class="" style="text-align:right;">
                  <b><?=$nowadate?></b>
                </td>
              </tr></table>
              </div>  
          </div>
      		<div class="panel-body">    
	         <div class="row">
      			<div class="col-lg-12">
      				<div class="panel panel-default">
      					<div class="panel-heading">
      					  <div class="row" style="padding-left:10px;padding-right:10px">
        					  <b>
                      <span id="pctit">Weekly Average Sales Per Customer - Last 12 Weeks</span>
                    </b>
                  </div>
                </div>
      					<div class="panel-body">
      						<div class="canvas-wrapper">
      							<canvas class="main-chart" id="davrspcust-line-chart" height="125" width="600"></canvas>
      						</div>
      					</div>
      				</div>
      			</div>
      	</div><!--/.row-->
        
	         <div class="row">
      			<div class="col-lg-12">
      				<div class="panel panel-default">
      					<div class="panel-heading">
      					  <div class="row" style="padding-left:10px;padding-right:10px">
        					  <b>
                      <span id="pitit">Weekly Average Sales Per Invoice - Last 12 Weeks</span>
                    </b>
                  </div>
                </div>
      					<div class="panel-body">
      						<div class="canvas-wrapper">
      							<canvas class="main-chart" id="davrspinvo-line-chart" height="125" width="600"></canvas>
      						</div>
      					</div>
      				</div>
      			</div>
      	</div><!--/.row-->  
        
  		</div><!-- /.panel-body -->  
    </div><!-- /.panel -->
      
      
  </div><!-- /.container-fluid -->
  
</div><!-- /#page-content-wrapper -->     
<div id="cur" data-val="<?=$cur?>"></div>
                    
<?php
  //line chart script  
  $i = 0;
  $n = count($dmorevenue);  
  $labels = "";
  $data = "";
  foreach ($dmorevenue as $row){  
    $labels .= ($i==($n-1))?"'".date('M', strtotime($row->REC_MONTH))."'":"'".date('M', strtotime($row->REC_MONTH))."',"; 
    $data .=  ($i==($n-1))?(float)$row->AMT:(float)$row->AMT.","; 
    $i++;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var lineChartData = {";
	$chart_script .= "		labels : [".$labels."],";
	$chart_script .= "		datasets : [";
	$chart_script .= "			{ ";
	$chart_script .= "				label: 'Monthly Revenue - Last 6 Months',";
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
  $chart_script .= "chart3.canvas.height = 100;";   
	$chart_script .= "window.myLine1 = new Chart(chart3).Line(lineChartData, { ";
	$chart_script .= "	responsive: true, tooltipFontSize : 12,";
	$chart_script .= "	legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%>eek<%=datasets[i].label%><%}%></li><%}%></ul>', ";
	//$chart_script .= "	tooltipTemplate: '<%if (label){%><%=label%>: ".$cur."<%}%> <%= ".$this->currency->jsformat($cur)." %>', ";  
	$chart_script .= "	tooltipTemplate: '<%if (label){%>".$cur."<%}%> <%= ".$this->currency->jsformat($cur)." %>', ";  
	$chart_script .= "	onAnimationComplete: function(){
                        this.showTooltip(this.datasets[0].points, true);
                      },
                      showTooltips: true,
                      tooltipEvents: [] ";  
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
    $labels .= ($i==($n-1))?"'".date('M d', strtotime($rowk->REC_WEEK))."'":"'".date('M d', strtotime($rowk->REC_WEEK))."',"; 
    $data .=  ($i==($n-1))?(float)$rowk->AMT:(float)$rowk->AMT.","; 
    $i++;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var lineChartData = {";
	$chart_script .= "		labels : [".$labels."],";
	$chart_script .= "		datasets : [";
	$chart_script .= "			{ ";
	$chart_script .= "				label: 'Weekly Revenue - Last 12 Weeks',";
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
  	$chart_script .= "chart5.canvas.height = 100;"; 
	$chart_script .= "window.myLine2 = new Chart(chart5).Line(lineChartData, { ";
	$chart_script .= "	responsive: true, tooltipFontSize : 12,";
	//$chart_script .= "	tooltipTemplate: '<%if (label){%><%=label%>: ".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>', "; 
	$chart_script .= "	tooltipTemplate: '<%if (label){%>".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>', ";  
	$chart_script .= "	onAnimationComplete: function(){
                        this.showTooltip(this.datasets[0].points, true);
                      },
                      showTooltips: true,
                      tooltipEvents: [] ";  
	$chart_script .= "});  ";
	$chart_script .= '</script>';
  echo $chart_script;
?> 
           
<?php
  //line chart script  
  $i = 0;
  $n = count($davrspcust);  
  $labels = "";
  $data = "";
  foreach ($davrspcust as $rowc){  
    $labels .= ($i==($n-1))?"'".date('M d', strtotime($rowc->REC_WEEK))."'":"'".date('M d', strtotime($rowc->REC_WEEK))."',"; 
    $amountc = (strtolower($cur)=="rp")?number_format((float)$rowc->AVG_SALES_CUST, 0, '.', ''):number_format((float)$rowc->AVG_SALES_CUST, 2, '.', '');
    $data .=  ($i==($n-1))?$amountc:$amountc.","; 
    $i++;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var lineChartData = {";
	$chart_script .= "		labels : [".$labels."],";
	$chart_script .= "		datasets : [";
	$chart_script .= "			{ ";
	$chart_script .= "				label: 'Weekly Average Sales Per Customer - Last 12 weeks',";
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
	$chart_script .= "var chart7 = document.getElementById('davrspcust-line-chart').getContext('2d');";    
  	$chart_script .= "chart7.canvas.height = 100;";  
	$chart_script .= "window.myLine7 = new Chart(chart7).Line(lineChartData, { ";
	$chart_script .= "	responsive: true, tooltipFontSize : 12,";
	//$chart_script .= "	tooltipTemplate: '<%if (label){%><%=label%>: ".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>', "; 
	$chart_script .= "	tooltipTemplate: '<%if (label){%>".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>', ";  
	$chart_script .= "	onAnimationComplete: function(){
                        this.showTooltip(this.datasets[0].points, true);
                      },
                      showTooltips: true,
                      tooltipEvents: [] ";  
	$chart_script .= "});  ";
	$chart_script .= '</script>';
  echo $chart_script;
?>  
       
<?php
  //line chart script  
  $i = 0;
  $n = count($davrspinvo);  
  $labels = "";
  $data = "";
  foreach ($davrspinvo as $rowi){  
    if($rowi->AVG_SALES_INV==NULL){ $rowi->AVG_SALES_INV = 0; }
    $labels .= ($i==($n-1))?"'".date('M d', strtotime($rowi->REC_WEEK))."'":"'".date('M d', strtotime($rowi->REC_WEEK))."',"; 
    $amounti = (strtolower($cur)=="rp")?number_format((float)$rowi->AVG_SALES_INV, 0, '.', ''):number_format((float)$rowi->AVG_SALES_INV, 2, '.', '');
    $data .=  ($i==($n-1))?$amounti:$amounti.","; 
    $i++;    
  }
  $chart_script = "<script>"; 
  $chart_script .= "var lineChartData = {";
	$chart_script .= "		labels : [".$labels."],";
	$chart_script .= "		datasets : [";
	$chart_script .= "			{ ";
	$chart_script .= "				label: 'Weekly Average Sales Per Invoice - Last 12 weeks',";
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
	$chart_script .= "var chart9 = document.getElementById('davrspinvo-line-chart').getContext('2d');";    
  	$chart_script .= "chart9.canvas.height = 100;";   
	$chart_script .= "window.myLine9 = new Chart(chart9).Line(lineChartData, { ";
	$chart_script .= "	responsive: true, tooltipFontSize : 12,";
	//$chart_script .= "	tooltipTemplate: '<%if (label){%><%=label%>: ".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>', ";
	$chart_script .= "	tooltipTemplate: '<%if (label){%>".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>', ";  
	$chart_script .= "	onAnimationComplete: function(){
                        this.showTooltip(this.datasets[0].points, true);
                      },
                      showTooltips: true,
                      tooltipEvents: [] ";  
	$chart_script .= "});  ";
	$chart_script .= '</script>';
  echo $chart_script;
?>                  

<script>
$(document).ready(function(){
    
  $.each($('td.trunk').not(':empty'), function(i,v){
    var count = parseInt($(this).text().length);
    var maxChars = 6;
    if(count > maxChars){
      var str = $(this).text();
      var trimmed = str.substr(0, maxChars);
      $(v).html('<b>'+trimmed + '<a href="#" title="'+str+'">...</a></b>');          
    }
       
  });
  
}); 

  function currencyFormat(number){   
		return (number + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  }  
          
  function currencyFormatRS0(number){
    return (number + "").replace(/(\d)(?=((\d)(\d{2}?)+)$)/g, "$1,");
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

<?php
  $this->load->view('shared/footer');
?>