<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">

    <div class="page-header">
      <h1><small>Facilities</small></h1>
    </div>
    
    <button style="margin-top:-5px;" type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#bookModal">
      <span class="glyphicon glyphicon-calendar"></span> Book a facility
    </button>
    
    <hr />
    
    <div class="well well-sm">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-2"><span style="background-color:red;">&nbsp;&nbsp;</span> - Badminton Court</div>
          <div class="col-sm-2"><span style="background-color:green;">&nbsp;&nbsp;</span> - Tenis Court</div>
          <div class="col-sm-2"><span style="background-color:blue;">&nbsp;&nbsp;</span> - Community Room A</div>
          <div class="col-sm-2"><span style="background-color:yellow;">&nbsp;&nbsp;</span> - Community Room B</div>
        </div>
    </div>
	
	<iframe src="<?php echo base_url(); ?>08_time_scale.html" width="100%" height="1000" frameborder="0"></iframe>
    
    <!-- FOOTER -->
    <hr class="featurette-divider" />
    
    <footer>
      <p class="pull-right">
        <a href="#">Back to top <span class="glyphicon glyphicon-circle-arrow-up"></span></a>
      </p>
	</footer>
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Book a Facility</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
        <form role="form">
          <div class="form-group">
            <label for="bookId">Booking ID -</label> <span class="text-disabled">A108</span>
          </div>

          <div class="form-group">
            <label for="inputCaption">Caption</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="">
          </div>
          <div class="form-group">
            <label for="inputDate">Date</label>
            <input type="text" class="form-control datepicker" id="inputDate" placeholder="">
          </div>
          <div class="form-group">
            <label for="inputDate">Time</label><br />
            <div class="col-sm-6">
            <select name="timeFrom" class="btn btn-default">
              <option>08:00</option>
              <option>08:30</option>
              <option>09:00</option>
              <option>09:30</option>
            </select> 
            -
            <select name="timeTo" class="btn btn-default">
              <option>08:00</option>
              <option>08:30</option>
              <option>09:00</option>
              <option>09:30</option>
            </select>
            </div>
          </div><br />
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

$(".datepicker").datepicker();

</script>
