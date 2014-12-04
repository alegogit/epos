<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/carousel-mini.css"/>

<style>
</style>

<div id="page-content-wrapper">
  <div class="container-fluid" style="font-size:90%;">
        
    <div class="page-header">
      <h1>
        <small>Maintenance Services</small>
        <button style="margin-top:-5px;" type="button" class="btn btn-success btn-md pull-right" data-toggle="modal" data-target="#bookModal">
          <span class="glyphicon glyphicon-calendar"></span> Submit New Request
        </button>
      </h1>
    </div>
    
    <!-- content table -->
      <table id="myTable" class="table table-striped table-responsive table-hover"> 
        <thead> 
          <tr> 
            <th>Request ID</th> 
            <th>Request Caption</th> 
            <th>Submited Date</th> 
            <th>Status</th> 
          </tr> 
        </thead> 
        <tbody> 
          <tr> 
            <td>A101</td> 
            <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td> 
            <td>dd/mm/yy hh:mm</td> 
            <td>open</td> 
          </tr> 
          <tr> 
            <td>A102</td> 
            <td>Nulla quis augue tellus. Suspendisse at felis sed tellus ornare facilisis. </td> 
            <td>dd/mm/yy hh:mm</td> 
            <td>close</td> 
          </tr> 
          <tr> 
            <td>A103</td> 
            <td>Mauris eleifend neque ligula, in ullamcorper urna placerat a.</td> 
            <td>dd/mm/yy hh:mm</td> 
            <td>open</td> 
          </tr> 
          <tr> 
            <td>A104</td> 
            <td>Nullam scelerisque ligula sed urna porttitor, nec tempus ipsum commodo.</td> 
            <td>dd/mm/yy hh:mm</td> 
            <td>close</td> 
          </tr> 
        </tbody> 
  	  </table> 
      
    <hr class="featurette-divider" />  
	<div>
    <!-- CAROUSEL -->
    <div class="row">
      <div class="col-sm-12">
        <div id="serviceCarousel" class="carousel slide">
          <!-- Carousel items -->
            <div class="carousel-inner">
              <?php for($i=0;$i<4;$i++){ ?><!-- Create 4 slides -->
              <div class="item <?php if($i==0) echo "active"; ?>">
                <div class="row">
                  <?php for($j=0;$j<4;$j++){ ?><!-- make 4 items per slide -->
                  <div class="col-sm-3">
                    <a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                    <div class="container">
                      <div class="carousel-caption">
                        <h3>TITLE <?php echo $i." ".$j; ?></h3>
                      </div><!-- /.carousel-caption -->
                    </div><!-- /.container -->
                  </div><!-- /.col-sm-6 col-xs-12 -->
                  <?php } ?> 
                </div><!-- /.row -->
              </div><!-- /.item -->
              <?php } ?>   
            </div><!-- /.carousel-inner --> 
            <a class="left carousel-control" href="#serviceCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left glyphicon-4"></i></a>
            <a class="right carousel-control" href="#serviceCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right glyphicon-4"></i></a>
        </div><!-- /#serviceCarousel -->
	  </div><!-- /.col-md-2 -->
    </div><!-- /.row -->
    <!-- CAROUSEL END -->
    </div>
    
    <!-- START THE FEATURETTES -->
	<hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It'll blow your mind.</span></h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="500x500" src="http://placehold.it/500">
        </div>
    </div>

	<hr class="featurette-divider">

	<div class="row featurette">
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="500x500" src="http://placehold.it/500">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
		</div>
	</div>
    <!-- /END THE FEATURETTES -->
    
    <!-- /FOOTER -->
    <hr class="featurette-divider">
    
    <footer>
      <p class="pull-right">
        <a href="#">Back to top <span class="glyphicon glyphicon-circle-arrow-up"></span></a>
      </p>
	</footer>
    
  </div><!-- /.container-fluid -->
</div><!-- /.page-content-wrapper -->
      
<script>
	
	$('#serviceCarousel').carousel({
		interval: 5000
	});

</script>

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" align="center">Create New Request</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label for="requestID" class="col-sm-3 control-label" style="text-align:left;">Request ID</label>
            <div class="col-sm-8">
              <label class="form-control-static">A101</label>
            </div>
          </div>
          <div class="form-group">
            <label for="caption" class="col-sm-3 control-label" style="text-align:left;">Caption</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="caption" placeholder="Input your caption here...">
            </div>
          </div>
          <div class="form-group">
            <label for="caption" class="col-sm-3 control-label" style="text-align:left;">Date Submitted</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="caption" placeholder="Input your caption here...">
            </div>
          </div>
        </form>
            
        <form role="form">
          <div class="form-group">
            <label for="inputType">Type</label>
            <select name="service_type" class="form-control">
              <option>-- Select a service type --</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputDate">Date</label>
            <input type="text" class="form-control datepicker" id="inputDate" placeholder="mm/dd/yyyy" title="format : mm/dd/yyyy">
          </div>
          <div class="form-group">
            <label for="inputImg">Image</label>
            <div class="row">
              <input type="file" id="inputImg" class="col-sm-5" name="image" />
              <div id="imagePreview" class="col-sm-5 col-sm-offset-1"></div>
            </div>
            <p class="help-block">type : .jpg .png</p>
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </form>      
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->

<script>
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

$(".datepicker").datepicker({
});

$("#inputImg").on("change", function(){
	var files = !!this.files ? this.files : [];
	if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

	if (/^image/.test( files[0].type)){ // only image file
		var reader = new FileReader(); // instance of the FileReader
		reader.readAsDataURL(files[0]); // read the local file

		reader.onloadend = function(){ // set image data as background of div
			$("#imagePreview").css("background-image", "url("+this.result+")");
		}
	}
});

//$("#myTable").tablesorter();

$('#myTable').dataTable();
	
</script>


