<?php
  $this->load->view('shared/notopbar_header',$this->data);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
    
    <div class="row">  
      
    <div class="row" style="text-align:center;">  
      <h4>
        <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <br><?=$restname->REST_NAME?> 
      </h4>
    </div>
	  
    <hr style="margin-bottom:10px;margin-top:10px" />
		
    <div class="panel panel-default">
      <div class="panel-heading tablehead text3D" style="font-size:110% !important;">
          <div class="row" style="vertical-align:bottom !important;"> 
          <table width="100%"><tr> 
            <td>
              <b>&nbsp;&nbsp;&nbsp;Inventory Dashboard</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$nowadate?></b>
            </td>
          </tr></table>
          </div>  
      </div>
  		<div class="panel-body">
        
        <div class="row"> 
	      
          <div class="col-md-4">
  				  <div class="panel panel-info">
  				    <div class="panel-heading"><b>Non Moving Items</b></div>
  					  <div class="panel-body" style="min-height:180px;">
  					   <div class="table-responsive">
						    <table id="" class="inv table dt-right compact" style="font-size:90% !important;">
						      <thead>
						        <tr><th></th></tr>
						      </thead>
						      <tbody>
						        
                      <?php    
                        $i = 1;
                        foreach ($nonmovitm as $row){ 
                          echo '<tr><td class="alert alert-info" style="padding:10px;margin-bottom:10px">'.$i.". <b>".ucwords(strtolower($row->NAME))."</b></td> </tr>";
                          $i++;  
                        }
                      ?>
                   
                  </tbody>
                </table>
               </div>
  					  </div>
  				  </div>
  				</div> 
          
          <div class="col-md-4">
  				  <div class="panel panel-warning">
  				    <div class="panel-heading"><b>Low in Stock</b></div>
  					  <div class="panel-body" style="min-height:180px;"> 
  					   <div class="table-responsive">
						    <table id="" class="inv table dt-right compact" style="font-size:90% !important;">
						      <thead>
						        <tr><th></th></tr>
						      </thead>
						      <tbody>
  					     
      					     <?php 
                      $i = 1;
                      foreach ($lowinstck as $row){  
                        echo '<tr><td class="alert alert-warning" style="padding:10px;margin-bottom:10px">'.$i.". <b>".ucwords(strtolower($row->NAME))."</b></td></tr>";
                        $i++;  
                      }
                    ?> 
                   
                  </tbody>
                </table>
              </div>
  				   </div>
  				  </div>
  				</div>
				  
				  <div class="col-md-4">
  				  <div class="panel panel-danger">
  				    <div class="panel-heading"><b>No Stock</b></div>
  					  <div class="panel-body" style="min-height:180px;">
  					   <div class="table-responsive">
						    <table id="" class="inv table dt-right compact" style="font-size:90% !important;">
						      <thead>
						        <tr><th></th></tr>
						      </thead>
						      <tbody>
						      
                  <?php 
                    $i = 1;
                    foreach ($nostock as $row){
                      echo '<tr><td class="alert alert-danger" style="padding:10px;margin-bottom:10px">'.$i.". <b>".ucwords(strtolower($row->NAME))."</b></td></tr>";
                      $i++;  
                    }
                  ?>   
                   
                  </tbody>
                </table>
  					  </div>
  				   </div>
  				  </div>
				  </div>
				  
				  
			  </div>	
      
        </div><!-- /.row -->
    
  		</div><!-- /.panel-body -->  
    </div><!-- /.panel -->
    
  </div><!-- /.container-fluid -->
  
</div><!-- /#page-content-wrapper -->  
       
<script>
    
  //inititate datatable
  var table = $('.inv').DataTable({  
    "searching": false,     
    "paging": false,
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "bAutoWidth": false,
    "info": false,
    "bPaginate": false
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],    
    ordering:  false,
    bLengthChange: false
  });
  
  $('table.dataTable thead th, table.dataTable thead td').css('border','none');
  $('.dataTables_empty').html('None');
     	
</script>         

<?php
  $this->load->view('shared/footer');
?>