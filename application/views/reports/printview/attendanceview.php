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
		    <div class="panel-heading"> 
          <div class="row" style="vertical-align:bottom !important;"> 
          <table width="100%"><tr> 
            <td>
              <b>&nbsp;&nbsp;&nbsp;Attendance Report</b>
            </td>
            <td class="col-md-6" class="" style="text-align:right;">
              <b><?=$startdate." - ".$enddate?></b>
            </td>
          </tr></table>
          </div>  
        </div>
	      <div class="panel-body table-responsive">   
	        <table id="report" class="table table-striped dt-right compact">
				<thead>
						  <tr class="tablehead text3D">
						    <th class="no-sort">Date</th>
						    <th class="no-sort">Name</th>  
						    <th class="no-sort">Check In</th>   
						    <th class="no-sort">Check Out</th>   
						    <th class="cin no-sort">Total Hours</th>  
						    <th class="no-sort">Terminal</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php 
                $i = 0; 
                foreach ($attendance as $row){ 
                  $total['HOURS'] = (($row->CHECKIN!=NULL)&&($row->CHECKOUT!=NULL))?round((strtotime($row->CHECKOUT) - strtotime($row->CHECKIN))/(60*60))." hrs":"-";    
              ?>
						  <tr class="<?=$this->attendance->inv_status_class($row->STATUS)?>" data-index="<?=$i?>">
						    <td><?=$row->SELECTED_DATED?></td> 
						    <td><?=$row->EMPLOYEE_NAME?></td>
						    <td><?=($row->CHECKIN==NULL)?"-":date('Y-m-d H:i', strtotime($row->CHECKIN))?></td> 
						    <td><?=($row->CHECKOUT==NULL)?"-":date('Y-m-d H:i', strtotime($row->CHECKOUT))?></td>
						    <td class="cin"><?=$total['HOURS']?></td> 
						    <td><?=($row->TERMINAL_NAME==NULL)?"-":$row->TERMINAL_NAME?></td> 
						  </tr>
						  <?php  
                $i++; 
              } ?>
						</tbody>
					</table>      
			  </div>
		</div>
		
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->  
<div id="cur" data-val="<?=$cur?>"></div>

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
