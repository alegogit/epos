<link rel="stylesheet" type="text/css" href="assets/css/carousel-mini.css"/>

<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
      
    <div class="row">
    
      <div class="col-sm-10">
      
        <hr />  
        <ul class="list-inline">
          <li><input id="startdate" name="startdate" min="2012-01-01" max="2013-01-01" type="date"></li>
          <li>
               <select id = "myRestaurant">
                    <option value = "0">ALL Restaurants</option>
                    <?php foreach($restaurants as $row){ ?>
                    <option value = "<?=$row->ID?>" <?= ($row->DEFAULT_SET==1)?'selected':''?> ><?=$row->NAME?></option>
                    <?php } ?>
               </select>
          </li>
          <? //echo "<pre>" . var_dump($restaurants) . "</pre>"; ?>
        </ul>
        <!--<div class="row">
          <div class="col-sm-2 col-sm-offset-1"><span style="background-color:#D43F3A;">&nbsp;&nbsp;</span> - Notification</div>
          <div class="col-sm-4"><span style="background-color:#357EBD;">&nbsp;&nbsp;</span> - Building Management Information</div>
          <div class="col-sm-4"><span style="background-color:#EEA236;">&nbsp;&nbsp;</span> - Neighborhood News</div>
        </div>-->
		<hr />
        <?php foreach($announcements as $row){ ?>     
			<?php if($row->TYPE == 'BUILD_MANAGE'): ?>
                <div class="blockquote-box blockquote-primary clearfix">
                  <p><strong><?php echo $row->NAME; ?></strong> - <?php echo $row->DESCRIPTION; ?></p>
                </div>
            <?php elseif($row->TYPE == 'NEIGHBORHOOD'): ?>
                <div class="blockquote-box blockquote-warning clearfix">
                  <p><strong><?php echo $row->NAME; ?></strong> - <?php echo $row->DESCRIPTION; ?></p>
                </div>
            <?php else: ?>
                <div class="blockquote-box blockquote-danger clearfix">
                  <p><strong><?php echo $row->NAME; ?></strong> - <?php echo $row->DESCRIPTION; ?></p>
                </div>
            <?php endif; ?>
		<?php } ?>
                
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

<script>

	$('#promoCarousel').carousel({
		interval: 5000
	});
	
	$('#serviceCarousel').carousel({
		interval: 5000
	});
    
</script>
