<div class="menu-toggle">
  	<a href="#menu-toggle" class="" id="menu-toggle">
    <!--<span id="hand" class="glyphicon glyphicon-chevron-left"></span>-->
    <span id="hand" class="toggled">&nbsp;</span>
	</a>
</div>

<!-- Sidebar -->
<div id="sidebar-wrapper">
  <div>
  <ul class="sidebar-nav">
    <li class="<?php if($menu == 'dashboard'){ echo "active";} ?>">
	  <?php echo anchor('dashboard', 'Dashboard'); ?>
    </li>
    <li class="<?php if($menu == 'inventory'){ echo "active";} ?>">
	  <?php echo anchor('inventory', 'Inventory'); ?>
    </li>
    <li class="<?php if($menu == 'customers'){ echo "active";} ?>">
	  <?php echo anchor('customers', 'Customers'); ?>
    </li>
    <li class="<?php if($menu == 'setting'){ echo "active";} ?>">
	  <?php echo anchor('setting', 'Setting'); ?>
    </li>
    <li class="<?php if($menu == 'reports'){ echo "active";} ?>">
	  <?php echo anchor('reports', 'Reports'); ?>
    </li>
    <li class="<?php if($menu == 'extracts'){ echo "active";} ?>">
	  <?php echo anchor('extracts', 'Extracts'); ?>
    </li>
    <li class="<?php if($menu == 'sync'){ echo "active";} ?>">
	  <?php echo anchor('sync', 'Sync'); ?>
    </li>
  </ul>
  </div>
  <div class="copyright"> 
  <div id="calendar" style="background-color:#fff;margin:5px;border-radius:5px;" class="responsive"></div>  
    <!--<p>© 2014 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>-->
    <p>&nbsp;&nbsp;EPOS 1.0</p>
  </div>
</div><!-- /#sidebar-wrapper -->
    
<script>

	$("#menu-toggle").click(function(e) {
  		e.preventDefault();
  		$("#wrapper").toggleClass("toggled");
	});
	
	$( "#menu-toggle" ).click(function(){
		if($( "#hand" ).attr("class") == "glyphicon glyphicon-chevron-left"){
			$( "#hand" ).removeClass("glyphicon glyphicon-chevron-left");
			$( "#hand" ).addClass("glyphicon glyphicon-chevron-right");
		}
		else{
			$( "#hand" ).removeClass("glyphicon glyphicon-chevron-right");
			$( "#hand" ).addClass("glyphicon glyphicon-chevron-left");
		}  
	});   
	
	var harini = new Date('dd M yyyy');
  $("#calendar").datepicker({ 
    format: 'dd M yyyy', 
    todayHighlight: true,
    beforeShowDay: function(date){
      $(this).children('thead').addClass('defbg');
    } 
  });
  //$("#calendar").datepicker('');
	
</script>
