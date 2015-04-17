<div id="page-content-wrapper" style="padding-bottom:0px !important">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
    
    <div class="row">
    
      <div class="col-sm-10">
        <div class="row">
          <div class="col-md-6">
            <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
              <a role="button" class="btn btn-primary" href="<?=base_url()?>dashboard/sales">&nbsp;&nbsp;Sales&nbsp;&nbsp;</a>  
              <a role="button" class="btn btn-default" href="<?=base_url()?>dashboard/trends">&nbsp;&nbsp;Trends&nbsp;&nbsp;</a>
              <a role="button" class="btn btn-default" href="<?=base_url()?>dashboard/inventory" <?=(count($nostock)>0)?'title="'.count($nostock).' no stock item(s)"':''?>>Inventory</a> 
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
                <a id="print" role="button" class="btn btn-primary" href="<?=base_url()?>dashboard/salesprint/<?=$hashvars?>" target="_blank">&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print&nbsp;</a>
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
          <?php 
          //chart config
            $donut_color[0] = "#30a5ff";
            $donut_color[1] = "#ffb53e";
            $donut_color[2] = "#1ebfae";
            $donut_color[3] = "#f9243f";
            $donut_color[4] = "#d2691e";
            $donut_color[5] = "#8a0094";
            $donut_color[6] = "#363636";
            $donut_highl[0] = "#62b9fb";
            $donut_highl[1] = "#fac878";
            $donut_highl[2] = "#3cdfce";
            $donut_highl[3] = "#f6495f";
            $donut_highl[4] = "#e4843f";
            $donut_highl[5] = "#Ba00c7";
            $donut_highl[6] = "#5C5C5C";
          ?>                 
            
          <?php //echo "<pre>" . var_dump($dpayment) . "</pre>"; ?>
          <div class="col-md-6">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Top Category By Sales</b></div>
  					  <div class="panel-body" style="height:275px;font-size:125%;">
    					  <div class="row">
    						  <div class="canvas-donut" style="float:left;margin-left:8px">
    							  <canvas class="chart" id="topcats_donut" ></canvas>
    						  </div> 
                  <div class="fitin" style="display:inline-block;margin-left:8px;"> 
                    <div>
                      <?php    
                        $i = 0;
                        $n = count($dtopcats);
                        $ofound = 0;
                        $chart_legend = "<table style='width:100%'>";
                        $total = 0; 
                        foreach ($dtopcats as $tot){
                          $total = $total + $tot->AMOUNT; 
                        }
                        foreach ($dtopcats as $row){
                          if(strtolower($row->CAT_NAME)=="others"){   
                            $chart_legend .= "<tr><td colspan='5'>&nbsp;</td>"; 
                            //$chart_legend .= "<tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></td>"; 
                            $chart_legend .= "<tr><td><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i+1]."'></span></td>";  
                            $chart_legend .= " <td class='trunk1' style='padding-left:5px;padding-right:5px;'><b>".ucwords(strtolower($adjustcat->CAT_NAME))."</b></td>"; 
                            $chart_legend .= "<td class='cin'><span style='padding-left:10px;'>&nbsp;</span>".$cur."&nbsp;</td>";
                            $chart_legend .= " <td class='cin cur'><b>".$adjustcat->AMOUNT."</b></td>";       
                            $chart_legend .= " <td class='cin'><span style='padding-left:5px;'>&nbsp;</span>".$adjustcat->TOTAL."</td>"; 
                            $chart_legend .= "<tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></td>"; 
                            $ofound = $ofound + 1;
                          }
                            $chart_legend .= "<tr><td><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i]."'></span></td>";  
                            $chart_legend .= " <td class='trunk1' style='padding-left:5px;padding-right:5px;'><b>".ucwords(strtolower($row->CAT_NAME))."</b></td>"; 
                            $chart_legend .= "<td class='cin'><span style='padding-left:10px;'>&nbsp;</span>".$cur."&nbsp;</td>";
                            $chart_legend .= " <td class='cin cur'><b>".$row->AMOUNT."</b></td>";       
                            $chart_legend .= " <td class='cin'><span style='padding-left:5px;'>&nbsp;</span>".$row->TOTAL."</td>";  
                            $chart_legend .= " <!--<td style='float:right;display:inline-block'><span style='padding-left:10px;'>&nbsp;</span>".round(($row->AMOUNT/$total)*100)."% </td>--></tr>
                            <tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></tr>";
                         
                          $i++;  
                        } 
                        if($ofound==0){
                            $chart_legend .= "<tr><td colspan='5'>&nbsp;</td>"; 
                            //$chart_legend .= "<tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></td>"; 
                            $chart_legend .= "<tr><td><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i+1]."'></span></td>";  
                            $chart_legend .= " <td class='trunk1' style='padding-left:5px;padding-right:5px;'><b>".ucwords(strtolower($adjustcat->CAT_NAME))."</b></td>"; 
                            $chart_legend .= "<td class='cin'><span style='padding-left:10px;'>&nbsp;</span>".$cur."&nbsp;</td>";
                            $chart_legend .= " <td class='cin cur'><b>".$adjustcat->AMOUNT."</b></td>";       
                            $chart_legend .= " <td class='cin'><span style='padding-left:5px;'>&nbsp;</span>".$adjustcat->TOTAL."</td>"; 
                            $chart_legend .= "<tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></td>";
                            $chart_legend .= "<tr><td><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i+2]."'></span></td>";  
                            $chart_legend .= " <td class='trunk1' style='padding-left:5px;padding-right:5px;'><b> Others </b></td>"; 
                            $chart_legend .= "<td class='cin'><span style='padding-left:10px;'>&nbsp;</span>".$cur."&nbsp;</td>";
                            $chart_legend .= " <td class='cin cur'><b>0</b></td>";       
                            $chart_legend .= " <td class='cin'><span style='padding-left:5px;'>&nbsp;</span>0</td>"; 
                            $chart_legend .= "<tr><td colspan='5'><hr style='margin-top:5px;margin-bottom:5px'></td>";
                        } 
                        $chart_legend .= "</table>";
                        if($n!=0){    
                          echo $chart_legend;
                        }else{
                          echo "<div id='nrtcbs' class='alert alert-danger' style='padding:10px;'>No Records</div>";
                        }  
                        //echo "<pre>"; print_r($dtopcats); echo "</pre>";
                    ?>
                    </div>
                  </div> 
                </div>  
  					  </div>
  				  </div>
  				</div>
          
          <div class="col-md-6">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Top Menu Items By Sales</b></div>
  					  <div class="panel-body" style="height:275px;font-size:125%;"> 
                  <div class="fitin" style="display:inline-block;width:100%;">
      					     <?php 
                      $i = 0;
                      $n = count($dbestsells);
                      $chart_legend = "<table id='ttibs' style='width:100%'>";
                      foreach ($dbestsells as $row){
                        $chart_legend .= "<tr>
                          <td><b>".($i+1)."</b>&nbsp;</td>";  
                        $chart_legend .= "<td class='trunk2'><b>".ucwords(strtolower($row->ITEMS))."</b>&nbsp;</td>
                                          <td class='cin'><span style='padding-left:10px;'>&nbsp;</span>".$cur."&nbsp;</td>";
                        $chart_legend .= "<td class='cin cur'><b>".$row->AMOUNT."</b>&nbsp;</td>";
                        $chart_legend .= "<td class='cin' style='text-align:right'><span style='padding-left:10px;'>&nbsp;</span>".$row->QTY."</td>
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
        
		    <div class="row">
				  
				  <div class="col-md-6">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Payment Methods</b></div>
  					  <div class="panel-body" style="height:155px;font-size:125%;">
  					  <div class="row">
  						  <div class="canvas-donut" style="float:left;margin-left:8px">
  							  <canvas class="chart" id="payment_donut" ></canvas>
  						  </div>  
                <div class="fitin" style="display:inline-block;margin-left:8px;max-width:265px;margin-top:10px;"> 
                  <div>
                  <?php 
                    $i = 0;
                    $n = count($dpayment);
                    $chart_legend = ""; 
                    $total = 0; 
                    foreach ($dpayment as $tot){
                      $total = $total + $tot->AMOUNT;
                      $totalq = $totalq + $tot->TOTAL;
                    }
                    $chart_legend .= "<table>";
                    foreach ($dpayment as $row){
                      $chart_legend .= "<tr><td class='col-md-1' style='padding-left:5px;padding-right:5px;'><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i]."'></span></td>";  
                      $chart_legend .= "<td class='col-md-4 trunk' style='padding-left:5px;padding-right:5px;'><b>".ucwords(strtolower($row->PAYMENT_METHOD))."</b></td> 
                                        <td class='col-md-1 cin' style='padding-left:10px;padding-right:5px;'>".$cur."</td>";
                      $chart_legend .= "<td class='col-md-4 cin cur' style='padding-left:5px;padding-right:5px;'><span style='float:right;display:inline-block'>".$row->AMOUNT."</span></td>";
                      $chart_legend .= "<td class='col-md-2 cin' style='padding-left:5px;padding-right:5px;'><span style='float:right;display:inline-block'>".$row->TOTAL."</span></td></tr>";
                      $i++;  
                    }
                    
                    $chart_legend .= "<tr>
                        <td colspan='5'><hr style='margin-top:5px;margin-bottom:5px;border-color:#222'></td>
                      </tr>
                      <tr>
                        <td class='col-md-1' style='padding-left:5px;padding-right:5px;'><b><i class='fa fa-money'></i></b></td> 
                        <td class='col-md-4' style='padding-left:5px;padding-right:5px;'><b>Total</b></td>
                        <td class='col-md-1' style='padding-left:10px;padding-right:5px;'><b>".$cur."</b></td>
                        <td class='col-md-4 cur cin' style='padding-left:5px;padding-right:5px;font-weight:bold !important;'><b><span style='float:right;display:inline-block;'>".$total."</span></b></td>
                        <td class='col-md-2 cin' style='padding-left:5px;padding-right:5px;'><span style='float:right;display:inline-block'>".$totalq."</span></td>";
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
          
				  <div class="col-md-6">
  				  <div class="panel panel-default">
  				    <div class="panel-heading"><b>Sales Type</b></div>
  					  <div class="panel-body" style="height:155px;font-size:125%;">
    					  <div class="row">
    						  <div class="canvas-donut" style="float:left;margin-left:8px">
    							  <canvas class="chart" id="ordtype_donut" ></canvas>
    						  </div> 
                  <div class="fitin" style="display:inline-block;margin-left:8px;max-width:265px;margin-top:10px;"> 
                    <div>
                      <?php    
                        $i = 0;
                        $n = count($dordtype);
                        $chart_legend = "<table style='width:100% !important; min-width:250px !important;'>";
                        $itotal = 0; 
                        foreach ($dordtype as $itot){
                          $itotal = $itotal + $itot->AMOUNT;
                          $itotalq = $itotalq + $itot->TOTAL; 
                        }
                        foreach ($dordtype as $row){
                            $chart_legend .= "<tr><td class='col-md-1' style='padding-left:5px;padding-right:5px;'><span class='glyphicon glyphicon-tint' style='color:".$donut_color[$i]."'></span></td>";  
                            $chart_legend .= " <td class='col-md-4 trunk' style='padding-left:5px;padding-right:5px;'><b>".ucwords(strtolower($row->ORDER_TYPE))."</b></td>";    
                            $chart_legend .= "<td class='col-md-1 cin' style='padding-left:10px;padding-right:5px;'>".$cur."&nbsp;</td>";
                            $chart_legend .= " <td class='col-md-4 cin cur' style='padding-left:5px;padding-right:5px;'><b>".$row->AMOUNT."</b></td>";       
                            $chart_legend .= " <td class='col-md-2 cin' style='padding-left:5px;padding-right:5px;'><span style='padding-left:10px;'>&nbsp;</span>".$row->TOTAL."</td>";
                            $chart_legend .= " <!--<td style='float:right;display:inline-block'><span style='padding-left:10px;'>&nbsp;</span>".round(($row->AMOUNT/$itotal)*100)."% </td>--></tr>";
                          $i++;  
                        }    
                        $chart_legend .= "<tr>
                            <td colspan='5'><hr style='margin-top:5px;margin-bottom:5px;border-color:#222'></td>
                          </tr>
                          <tr>
                            <td class='col-md-1' style='padding-left:5px;padding-right:5px;'><b><i class='fa fa-money'></i></b></td> 
                            <td class='col-md-4' style='padding-left:5px;padding-right:5px;'><b>Total</b></td>
                            <td class='col-md-1' style='padding-left:10px;padding-right:5px;'><b>".$cur."</b></td>
                            <td class='col-md-4 cur cin' style='padding-left:5px;padding-right:5px;font-weight:bold !important;'><b><span style='float:right;display:inline-block;'>".$itotal."</span></b></td>
                            <td class='col-md-2 cin' style='padding-left:5px;padding-right:5px;'><span style='float:right;display:inline-block'>".$itotalq."</span></td>";
                        $chart_legend .= "</tr></table>";
                        if($n!=0){    
                          echo $chart_legend;
                        }else{
                          echo "<div id='nrtcbs' class='alert alert-danger' style='padding:10px;'>No Records</div>";
                        }  
                        //echo "<pre>"; print_r($dordtype); echo "</pre>";
                    ?>
                    </div>
                  </div> 
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
          <span class="list-group-item noborder pad30" style="background-color:#e4843f;">
            <span class="text270"><?=$cur?> <span id="nsales" value="<?=$this->currency->decimal($net_sales_today->NET_SALES,$cur)?>" data-cur="<?=$cur?>"></span></span><br>  
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:105%;"><b>Net Sales Today</b></span><br>
          </span>   
          <div class="rdinfo"></div>   
          <span class="list-group-item orgbg noborder pad30"> 
            <span class="text270"><?=$cur?> <span id="tsales" value="<?=$this->currency->decimal($tot_sales_today->TOTAL_SALES,$cur)?>" data-cur="<?=$cur?>"></span></span><br>     
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:105%;"><b>Total Sales Today</b></span><br>
          </span> 
          <div class="rdinfo"></div> 
        </div>    
        
        <div class="list-group rightdash">            
          <div class="rdtitle">Customer Today</div>
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item teabg noborder pad30">   
            <span class="text270"><?=$cur?> <span id="csales" value="<?=$this->currency->decimal($avrsls_percust->AVG_SALES_CUST,$cur)?>" data-cur="<?=$cur?>"></span></span> <br>  
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:105%;"><b>Average Sales/Customer</b></span>
          </span>   
          <div class="rdinfo"><?=$num_cust_today->TOTAL_CUST?> Customer(s) Today</div>
        </div>        
                  
        <div class="list-group rightdash">    
          <div class="rdtitle">Invoice Today</div>   
          <!--<a href="#" class="pull-right">See all</a>-->
          <span class="list-group-item redbg noborder pad30">
            <span class="text270"><?=$cur?> <span id="isales" value="<?=$this->currency->decimal($avrsls_perinv->AVG_SALES_INV,$cur)?>" data-cur="<?=$cur?>"></span></span> <br>  
            <span class="glyphicon glyphicon-info-sign"></span>&nbsp;<span style="font-size:105%;"><b>Average Sales/Invoice</b></span>
          </span>  
          <div class="rdinfo"><?=$com_inv_today->TOTAL_INV?> Invoice(s) Today</div> 
        </div>    
       
        
      </div><!-- /.col-sm-3 -->
      
    </div><!-- /.row -->
      
  </div><!-- /.container-fluid -->
  
</div><!-- /#page-content-wrapper -->     
<div id="cur" data-val="<?=$cur?>"></div>

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
    tooltipTemplate: '<%if (label){%><%=label%>: ".$cur." <%}%><%= ".$this->currency->jsformat($cur)." %>'":"tooltipTemplate: '<%if (label){%><%=label%> <%}%>'";
  $chart_script .= "  });"; 
	$chart_script .= '</script>';                       
  echo $chart_script;
?>  

<?php 
  //donut chart script
  $i = 0;
  $n = count($dordtype);
  $total = 0; 
  foreach ($dordtype as $tot){
  	$total = $total + $tot->AMOUNT;
  }
  $chart_script = "<script>"; 
  $chart_script .= "var doughnutData = [";
  if ($n!=0){
    foreach ($dordtype as $row){
      $chart_script .= "{";  
      //$chart_script .= "value: ".$row->AMOUNT.",";
      $chart_script .= "value: ".round(($row->AMOUNT/$total)*100).",";
      //$chart_script .= "tooltip: 'eek',";
      $chart_script .= "color: '".$donut_color[$i]."',";
      $chart_script .= "highlight: '".$donut_highl[$i]."',";
      $chart_script .= "label: '".ucwords(strtolower($row->ORDER_TYPE))."'";
      $chart_script .= ($i==($n-1))?"}":"},";  
      $i++;  
    }
  }else{                                                                   
    $chart_script .= "{";  
    $chart_script .= "value: 1,";
    $chart_script .= "color: '#ebccd1', label: 'No Records'}";
  }
  $chart_script .= "];";
  $chart_script .= "var chart3 = document.getElementById('ordtype_donut').getContext('2d');";
  $chart_script .= "chart3.canvas.width = 117;";
  $chart_script .= "chart3.canvas.height = 117;";
  $chart_script .= "window.myDoughnut1 = new Chart(chart3).Doughnut(doughnutData, {
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

<script>
     /*
     $('#myRestaurant').change(function() {
            $('#selRest').submit(); 
     });
     */    
$(document).ready(function(){
  /*
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
  */  
  
  elipsis(12,'td.trunk1');
  elipsis(25,'td.trunk2');
  
  function elipsis(mas,ale){  
    $.each($(ale).not(':empty'), function(i,v){
      var count = parseInt($(this).text().length);
      var maxChars = mas;
      if(count > maxChars){
        var str = $(this).text();
        var trimmed = str.substr(0, maxChars);
        $(v).html('<b>'+trimmed + '<a href="#" title="'+str+'">...</a></b>');          
      }       
    });
  } 
  
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
        //window.print();
     });   
       
    //animating numbers 
    $(document).ready(function () {
      animateNumbers("#nsales");
      animateNumbers("#tsales");
      animateNumbers("#csales");
      animateNumbers("#isales");
    });
           
    function animateNumbers0(ale) {    
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