<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
   
	<!-- HEADER -->
    <div class="page-header">
      <h1><small>Notifications</small></h1>
    </div>
    
    <!-- BODY -->
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-striped table-hover" id="notif">
          <thead>
            <tr class="info">
              <th colspan="4">Notifications</th>
            </tr>
          </thead>
          <tbody>
          <?php for($i=0;$i<10;$i++){ ?>
            <tr id="row<?php echo $i; ?>" style="cursor:pointer;">
              <td class="col-sm-1" id="<?php echo $i; ?>"><input type="checkbox" id="<?php echo $i; ?>" /></td>
              <td class="col-sm-2" data-toggle="modal" data-target="#bookModal" id="<?php echo $i; ?>"><label id="from<?php echo $i; ?>">from <?php echo $i; ?></label></td>
              <td class="col-sm-8" data-toggle="modal" data-target="#bookModal" id="<?php echo $i; ?>">
                <p class="displayTitle">
                  <b>subject <?php echo $i; ?></b> - 
                  <small>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dapibus massa elit, ut vulputate mauris consequat non. Aenean placerat nibh dui, eget posuere diam tempus finibus. Sed nec mi orci. Ut bibendum eros in libero luctus fringilla. Nulla in nisi a ante vestibulum sagittis eu nec neque. Aenean vel malesuada sem. Fusce sodales augue ac mi vehicula commodo. Pellentesque lobortis ultricies efficitur. Vestibulum ac ante id turpis sodales feugiat vel ut enim. Curabitur quis ullamcorper ligula. Phasellus ut suscipit diam. In hac habitasse platea dictumst. Curabitur non semper elit. Nullam eu pulvinar mauris.
                  </small>
                </p> 
              
                <p style="display:none;" id="subject<?php echo $i; ?>">subject <?php echo $i; ?></p> 
                
                <p style="display:none;" id="message<?php echo $i; ?>">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dapibus massa elit, ut vulputate mauris consequat non. Aenean placerat nibh dui, eget posuere diam tempus finibus. Sed nec mi orci. Ut bibendum eros in libero luctus fringilla. Nulla in nisi a ante vestibulum sagittis eu nec neque. Aenean vel malesuada sem. Fusce sodales augue ac mi vehicula commodo. Pellentesque lobortis ultricies efficitur. Vestibulum ac ante id turpis sodales feugiat vel ut enim. Curabitur quis ullamcorper ligula. Phasellus ut suscipit diam. In hac habitasse platea dictumst. Curabitur non semper elit. Nullam eu pulvinar mauris. <?php echo $i; ?>
                </p>
              </td>
              <td class="col-sm-1" id="<?php echo $i; ?>"><label id="date<?php echo $i; ?>">date <?php echo $i; ?></label></td>
            </tr>
          <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <td class="active" colspan="4" align="right">
                <button type="button" id="check-all" class="btn btn-default">
                  <span class="glyphicon glyphicon-check"></span>
                </button>
                <button type="button" class="btn btn-default">
                  <span class="glyphicon glyphicon-trash"></span>
                </button>
              </td>
            </tr>
          </tfoot>
        </table>
      </div><!-- /.col-sm-12 -->
    </div><!-- /.row -->

    <!-- FOOTER --><!-- /. -->
    <hr class="featurette-divider" />
    
    <footer>
      <p class="pull-right">
        <a href="#">Back to top <span class="glyphicon glyphicon-circle-arrow-up"></span></a>
      </p>
	</footer>
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<div id="dialog-form" title="Notification">
    
    <p><b id="dialogSubject"></b> - &lt;<small id="dialogFrom"></small>&gt;</p>
    <hr />
    <p id="dialogMessage" for="dialogMessage"></p>
    
</div>

<!-- Modal data-toggle="modal" data-target="#bookModal" -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><p><b id="dialogSubject"></b> - &lt;<small id="dialogFrom"></small>&gt;</p></h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
        <p id="dialogMessage" for="dialogMessage"></p>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->


<script>
	$( "#dialog-form" ).dialog({
      autoOpen: false,
	  width: 600,
      modal: true
	  //position: { my: "center", at: "center" }
    });

	  $("input[type=checkbox]").click(function(){
		var id = $(this).attr('id');
		$("#row"+id).toggleClass("warning");
		//if($("#"+id).attr('checked',true)) { $("#row"+id).addClass("warning"); }
		//else if($("#"+id).attr('checked',false)) { $("#row"+id).removeClass("warning"); }
	  });
	
	$("#notif tr td:not(:first-child)").click(function(){
	  //$("#dialog-form").dialog("open");	
	  var id = $(this).attr('id'); 
	  $("#dialogFrom").text($("#from"+id).text());
	  $("#dialogSubject").text($("#subject"+id).text());  
	  $("#dialogMessage").text($("#message"+id).text());
	});
	
	$(".displayTitle").text(function(index, currentText) {
      return currentText.substr(0, 150)+'...';
	});
	
	$("#check-all").click(function(){
	  if ($("input:checkbox:checked").length > 0) {
	    $('input:checkbox').attr('checked','uncheck');
	  }	
	  else {
	    $('input:checkbox').attr('checked','checked');
	  }
	  //return false;	
	});
		
</script>
