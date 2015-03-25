<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
              
    <div class="row" style="">  
      <div class="col-md-4">
        <h1>
          <img class="img-thumbnail" style="width:53px; height:53px; margin-top:-10px;" src="<?=$reslogo?>"/> <?=$restaurants->NAME?> 
        </h1>
      </div>
      <div class="col-md-4" style="text-align:center;">
        <h1>
           <?=ucwords($report_name)?> Report 
        </h1>
      </div>
      <div class="col-md-4" style="text-align:right;vertical-align:bottom !important;">
        <h3>
           <?=$startdate." - ".$enddate?>
        </h3>
      </div>
    </div>
    
    <hr style="margin-bottom:10px;margin-top:10px" />
	   
    <div class="panel panel-default">
		    <div class="panel-heading">
          <b></b>  
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
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 0, "asc" ]],
    "bAutoWidth": false,
    "bPaginate": false,
    bFilter: false, 
    bInfo: false
  });    
</script> 