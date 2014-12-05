<link rel="stylesheet" type="text/css" href="assets/css/carousel-mini.css"/>

<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
      
    <div class="row">
    
      <div class="col-sm-10">
      
        <hr />  
        
     <form id="selRest" method="POST" role="form">
     <div class="form-group">
        <ul class="list-inline">
          <li>
               <input id="startdate" name="startdate" type="text" value="<?=date('m/d/Y', time() - 30 * 60 * 60 * 24)?>" class="form-control datepicker" style="display:inline" placeholder="mm/dd/yyyy" title="format : mm/dd/yyyy">
          </li>
          <li>
               <input id="enddate" name="enddate" type="text" value="<?=date('m/d/Y')?>" class="form-control datepicker" style="display:inline" title="format : mm/dd/yyyy">
          </li>
          <li>
               <select id = "myRestaurant" name="rest_id" class="form-control" style="display:inline">
                    <option value = "0">ALL Restaurants</option>
                    <?php foreach($restaurants as $row){ ?>
                    <option value = "<?=$row->REST_ID?>" <?= ($row->REST_ID==$rest_id)?'selected':''?> ><?=$row->NAME?></option>
                    <?php } ?>
               </select>
          </li>
          <li>
               <button type="submit" class="btn btn-success" style="display:inline">Filter</button>
          </li>
          <? //echo "<pre>" . var_dump($restaurants) . "</pre>"; ?>
        </ul>
     </div>
      </form>
      
		<hr />
		
	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Doughnut Chart</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="chart" id="doughnut-chart" ></canvas>
						</div>
					</div>
				</div>
			</div>	
		
       <?php //foreach($announcements as $row){ ?>     
			<?php //if($row->TYPE == 'BUILD_MANAGE'): ?>
                <div class="blockquote-box blockquote-primary clearfix">
                  <p><strong><?php //echo $row->NAME; ?></strong> - <?php //echo $row->DESCRIPTION; ?></p>
                </div>
            <?php //elseif($row->TYPE == 'NEIGHBORHOOD'): ?>
                <div class="blockquote-box blockquote-warning clearfix">
                  <p><strong><?php //echo $row->NAME; ?></strong> - <?php //echo $row->DESCRIPTION; ?></p>
                </div>
            <?php //else: ?>
                <div class="blockquote-box blockquote-danger clearfix">
                  <p><strong><?php //echo $row->NAME; ?></strong> - <?php //echo $row->DESCRIPTION; ?></p>
                </div>
            <?php //endif; ?>
		<?php //} ?>
               
      </div><!-- /.col-sm-9 -->

      <div class="col-sm-2" style="padding:0;">
        <div>
          &nbsp;
        </div>
        
        <div class="list-group">
          <span class="list-group-item">
            <strong>Sales Today</strong>
            <a href="#" class="pull-right">See all</a>
            <br>Rp <?=number_format($sales_today->res, 0, '', '.')?>
            <br><?=round((float)$percent_today->PERCENTAGE * 100 ) . '%'?> From Yesterday
          <br><?=$trans_today->res?> Transactions
          </span> 
        </div>    
        
        <div class="list-group">
          <span class="list-group-item">
            <strong>Sales This Year</strong>
            <a href="#" class="pull-right">See all</a>
            <br>Rp <?=number_format($sales_this_year->res, 0, '', '.')?>
            <br><?=round((float)$percent_last_week->PERCENTAGE * 100 ) . '%'?> From Last Week
            <br><?=round((float)$percent_this_year->PERCENTAGE * 100 ) . '%'?> From Beginning Of The Year
          <br><?=$trans_this_year->res?> Transactions
          </span> 
        </div>        
                  
        <div class="list-group">
          <span class="list-group-item">
            <strong>Your Customers</strong>
            <a href="#" class="pull-right">See all</a>
            <br><?=$num_cust_30day->res?>
            <br>People
          <br>Last 30 Days
          </span>   
        </div>    
        
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

<div id="donut1" data-payment1="<?=270?>"></div>

<script src="<?=base_url()?>assets/js/charts/chart.min.js"></script>
<script src="<?=base_url()?>assets/js/charts/easypiechart.js"></script>
<script src="<?=base_url()?>assets/js/charts/easypiechart-data.js"></script>
<script>

	$('#promoCarousel').carousel({
		interval: 5000
	});
	
	$('#serviceCarousel').carousel({
		interval: 5000
	});
    
     /*
     $('#myRestaurant').change(function() {
            $('#selRest').submit(); 
     });
     */
     
     $("#startdate").datepicker();
     $("#enddate").datepicker();
     
     var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};
     var payment1 = $('#donut1').data('payment1');
     var doughnutData = [
					{
						value: payment1,
						color:"#30a5ff",
						highlight: "#62b9fb",
						label: "Blue"
					},
					{
						value: 50,
						color: "#ffb53e",
						highlight: "#fac878",
						label: "Orange"
					},
					{
						value: 100,
						color: "#1ebfae",
						highlight: "#3cdfce",
						label: "Teal"
					},
					{
						value: 120,
						color: "#f9243f",
						highlight: "#f6495f",
						label: "Red"
					}
	
				];
	var chart3 = document.getElementById("doughnut-chart").getContext("2d");
	window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive : true
	});
	
	
</script>
