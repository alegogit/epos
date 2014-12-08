<div class="menu-toggle">
  <a href="#menu-toggle" class="" id="menu-toggle">
    <span id="hand" class="glyphicon glyphicon-chevron-left"></span></a>
</div>

<!-- Sidebar -->
<div id="sidebar-wrapper">
  <div>
  <ul class="sidebar-nav">
    <li class="<?php if($menu == 'home'){ echo "active";} ?>">
	  <?php echo anchor('home', 'Dashboard'); ?>
    </li>
    <li class="<?php if($menu == 'services'){ echo "active";} ?>">
	  <?php echo anchor('services', 'Inventory'); ?>
    </li>
    <li class="<?php if($menu == 'facilities'){ echo "active";} ?>">
	  <?php echo anchor('facilities', 'Customers'); ?>
    </li>
    <li class="<?php if($menu == 'events'){ echo "active";} ?>">
	  <?php echo anchor('events', 'Setting'); ?>
    </li>
    <li class="<?php if($menu == 'events'){ echo "active";} ?>">
	  <?php echo anchor('events', 'Reports'); ?>
    </li>
    <!--<li class="<?php if($menu == 'about'){ echo "active";} ?>">
	  <?php echo anchor('about', 'About Us'); ?>
    </li>
    <li class="<?php if($menu == 'contact'){ echo "active";} ?>">
	  <?php echo anchor('contact', 'Contact Us'); ?>
    </li>-->
  </ul>
  </div>
  <div class="copyright"> 
  <div id="calendar" style="background-color:#fff;margin:5px;border-radius:5px;"></div>  
    <p>© 2014 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
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
