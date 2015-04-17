<?php
  $this->load->view('shared/notopbar_header',$this->data);
?>
<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;"> 
           
    <div class="row" style="text-align:center;">  
        <h4>
          <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <br><?=$restname->REST_NAME?> 
        </h4>
    </div>
    
    <hr style="margin-bottom:10px;margin-top:10px" />
	   
    <div class="panel panel-default">
		    <div class="panel-heading" style="font-size:110% !important;">
          <div class="row" style="vertical-align:bottom !important;"> 
          <table width="100%"><tr> 
            <td>
              <b>&nbsp;&nbsp;&nbsp;Inventory Report</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$nowadate?></b>
            </td>
          </tr></table>
          </div>  
        </div>
	      <div class="panel-body table-responsive">   
	        <table id="report" class="table table-striped dt-right compact">
				<thead>
						  <tr class="tablehead text3D">
						    <th>Name</th>
						    <th class="cin">Quantity</th>
						    <th>Status</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php $i = 0;  foreach ($inventory as $row){ ?>
						  <tr class="<?=$this->inventory->inv_status_class($row->STATUS)?>" data-index="<?=$i?>">
						    <td><?=$row->NAME?></td>
						    <td class="cin"><?=$row->QUANTITY?></td>
						    <td><?=$row->STATUS?></td>
						  </tr>
						  <?php $i++; } ?>
						</tbody>
					</table>      
			  </div>
			</div>
		</div>
		
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<script>                     
  //inititate datatable
  var table = $('#report').DataTable({  
    "searching": false,     
    "paging": false,
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 0, "asc" ]],
    "bAutoWidth": false,
    "info": false,
    "bPaginate": false
  });    
</script>        

<?php
  $this->load->view('shared/footer');
?>