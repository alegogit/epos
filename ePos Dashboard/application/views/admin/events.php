<!-- /. -->
<?php if(!defined("KEY") && $_SESSION['level'] != 1) die("script cannot be accessed directly."); ?>

<link rel="stylesheet" type="text/css" href="assets/css/carousel.css"/>

<div id="page-content-wrapper">
  <div class="container-fluid" style="font-size:90%;">
  
    <a href="#menu-toggle" class="" id="menu-toggle" style="font-size:80%; margin-top:-5%;">
    	<span id="hand" class="glyphicon glyphicon-hand-left"></span> Show/Hide Menu</a>
    <br /><br />
    
    <div class="well well-sm">
      <button type="button" class="btn btn-primary btn-sm" id="create-event">
        <span class="glyphicon glyphicon-plus"></span> Create Event
      </button>
    </div>

	<div class="row">
      <div class="col-sm-12">
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr class="info">
            <th class="col-sm-1">#</th>
            <th>Event</th>
            <th>Created by</th>
            <th>Description</th>
            <th class="col-sm-1"></th>
          </tr>
        </thead>  
        <tbody>
        <?php for($i=1;$i<=10;$i++){ ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo "event ".$i; ?></td>
            <td><?php echo "user ".$i; ?></td>
            <td><?php echo "description ".$i; ?></td>
            <td>
              <button type="button" class="btn btn-default btn-sm" title="Edit">
                <span class="glyphicon glyphicon-pencil"></span>
              </button>
              <button type="button" class="btn btn-default btn-sm" title="Delete">
                <span class="glyphicon glyphicon-trash"></span>
              </button>
            </td>
          </tr>
        <?php } ?>
        </tbody>    
      </table>
      </div>
    </div><!-- /.row-->

    <!-- /FOOTER -->
    <hr class="featurette-divider">
    
    <footer>
      <p class="pull-right"><a href="#">Back to top</a></p>
      <p>© 2014 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
	</footer>
        
  </div><!-- /.container-fluid -->
</div><!-- /.page-content-wrapper -->

<div id="dialog-form" title="Create new event">

    <form role="form">
      <div class="form-group">
        <label for="inputCaption">Caption</label>
        <input type="text" class="form-control" id="inputCaption" placeholder="">
      </div>
      <div class="form-group">
        <label for="inputDate">Date</label>
        <input type="text" class="form-control" id="inputDate" placeholder="">
      </div>
      <div class="form-group">
        <label for="inputImg">Image</label>
        <input type="file" id="inputImg" class="btn btn-default">
        <p class="help-block">type : .jpg .png</p>
      </div>
      <hr />
      <div class="form-group pull-right">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-warning" id="dialog-close">Cancel</button>
      </div>
    </form>      

</div>
      
<!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
$( "#menu-toggle" ).click(function(){
	if($( "#hand" ).attr("class") == "glyphicon glyphicon-hand-left"){
      $( "#hand" ).removeClass("glyphicon glyphicon-hand-left",500);
	  $( "#hand" ).addClass("glyphicon glyphicon-hand-right",500);
	}
	else{
	  $( "#hand" ).removeClass("glyphicon glyphicon-hand-right",500);
	  $( "#hand" ).addClass("glyphicon glyphicon-hand-left",500);
	}
	  
      //$( "#hand" ).switchClass( "glyphicon glyphicon-hand-right glyphicon", "glyphicon glyphicon-hand-left glyphicon");
    });
		
$( "#dialog-form" ).dialog({
      autoOpen: false,
	  width: 600,
      modal: true
    });
	
$( "#create-event" ).click(function() {
	$( "#dialog-form" ).dialog( "open" );
});	
$( "#dialog-close" ).click(function() {
	$( "#dialog-form" ).dialog( "close" );
});	
</script>
