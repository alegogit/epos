<?php if(!defined("KEY") && $_SESSION['level'] != 1) die("script cannot be accessed directly."); ?>

<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">

    <a href="#menu-toggle" class="" id="menu-toggle" style="font-size:80%; margin-top:-5%;">
      <span id="hand" class="glyphicon glyphicon-hand-left"></span> Show/Hide Menu</a>
    <br /><br />
    
    <a href="<?php echo "?ct=book"; ?>" class="btn btn-primary btn-block">Book a facility</a>
    
    <hr />
    
    <div class="well well-sm">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-2"><span style="background-color:red;">&nbsp;&nbsp;</span> - Badminton Court</div>
          <div class="col-sm-2"><span style="background-color:green;">&nbsp;&nbsp;</span> - Tenis Court</div>
          <div class="col-sm-2"><span style="background-color:blue;">&nbsp;&nbsp;</span> - Community Room A</div>
          <div class="col-sm-2"><span style="background-color:yellow;">&nbsp;&nbsp;</span> - Community Room B</div>
        </div>
    </div>
	
	<iframe src="08_time_scale.html" width="100%" height="1000" frameborder="0"></iframe>
    
    <!-- FOOTER -->
    <hr class="featurette-divider" />
    
    <footer>
      <p class="pull-right"><a href="#">Back to top</a></p>
      <p>© 2014 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
	</footer>
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<script>

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $("#menu-toggle").click(function () {
        if ($("#hand").attr("class") == "glyphicon glyphicon-hand-left") {
            $("#hand").removeClass("glyphicon glyphicon-hand-left", 500);
            $("#hand").addClass("glyphicon glyphicon-hand-right", 500);
        }
        else {
            $("#hand").removeClass("glyphicon glyphicon-hand-right", 500);
            $("#hand").addClass("glyphicon glyphicon-hand-left", 500);
        }

        //$( "#hand" ).switchClass( "glyphicon glyphicon-hand-right glyphicon", "glyphicon glyphicon-hand-left glyphicon");
    });

</script>
