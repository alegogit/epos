<link rel="stylesheet" type="text/css" href="assets/css/carousel-mini.css"/>

<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
      
    <div class="row">
    
      <div class="col-sm-10">
      
        <hr />  
        <ul class="list-inline">
          <li><span style="background-color:#D43F3A;">&nbsp;&nbsp;</span> - Notification</li>
          <li><span style="background-color:#357EBD;">&nbsp;&nbsp;</span> - Building Management Information</li>
          <li><span style="background-color:#EEA236;">&nbsp;&nbsp;</span> - Neighborhood News</li>
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
      
        <div class="list-group">
          <span class="list-group-item">
            <strong>Promotions</strong>
            <a href="#" class="pull-right">See all</a>
          </span>
          <!------------------------------------->
          <?php foreach($promotions as $row){ ?>
          	<a href="#" class="list-group-item">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row->IMAGE); ?>" alt="title1" class="img-responsive" style="">
            <h4 class="text-center"><?php echo $row->NAME; ?></h4>
            <p class="text-center"><?php echo $row->DESCRIPTION; ?></p>
          </a>
          <?php } ?>
          <!------------------------------------->
          <!--
          <a href="#" class="list-group-item">
            <img src="http://placehold.it/250x200" alt="title1" class="img-responsive" style="">
            <h4 class="text-center">Heading</h4>
            <p class="text-center">Duis mollis, est non commodo luctus, nisi erat porttitor ligula</p>
          </a>
          <a href="#" class="list-group-item">
            <img src="http://placehold.it/250x200" alt="title1" class="img-responsive" style="">
            <h4 class="text-center">Heading</h4>
            <p class="text-center">Duis mollis, est non commodo luctus, nisi erat porttitor ligula</p>
          </a>
        -->
        </div>
        
        <div class="list-group">
          <span class="list-group-item">
            <strong>Local Services</strong>
            <a href="#" class="pull-right">See all</a>
          </span>
          <!------------------------------------->
          <?php foreach($services as $row){ ?>
          	<a href="#" class="list-group-item">
            <img src="http://placehold.it/250x200" alt="title1" class="img-responsive" style="">
            <h4 class="text-center"><?php echo $row->NAME; ?></h4>
            <p class="text-center"><?php echo $row->DESCRIPTION; ?></p>
          </a>
          <?php } ?>
          <!------------------------------------->
          <!--
          <a href="#" class="list-group-item">
            <img src="http://placehold.it/250x200" alt="title1" class="img-responsive" style="">
            <h4 class="text-center">Heading</h4>
            <p class="text-center">Duis mollis, est non commodo luctus, nisi erat porttitor ligula</p>
          </a>
          <a href="#" class="list-group-item">
            <img src="http://placehold.it/250x200" alt="title1" class="img-responsive" style="">
            <h4 class="text-center">Heading</h4>
            <p class="text-center">Duis mollis, est non commodo luctus, nisi erat porttitor ligula</p>
          </a>
          -->
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
